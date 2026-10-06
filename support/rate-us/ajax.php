<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
require_once (__DIR__.'/crest.php');

use Bitrix\Main\Loader;
use Bitrix\Main\Context;
use Bitrix\Sale\Order;
use Bitrix\Sale\Internals\DiscountCouponTable;
use Bitrix\Main\Type\DateTime;

Loader::includeModule('sale');
Loader::includeModule('catalog');

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => '',
    'has_coupon' => false,
    'coupon' => ''
];

try {
    // Получаем и валидируем данные
    $request = Context::getCurrent()->getRequest();
    $orderNumber = trim($request->getPost('order') ?? '');
    $email = trim($request->getPost('email') ?? '');

    // Валидация входных данных
    if (empty($orderNumber) || empty($email)) {
        throw new Exception('Заполните номер заказа и email');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Введите корректный email');
    }

    // Ищем заказ
    $order = Order::loadByAccountNumber('HL-' . $orderNumber);
    if (!$order) {
        throw new Exception('Заказ не найден');
    }

    // Проверяем email заказа
    $propertyCollection = $order->getPropertyCollection();
    $emailOrder = $propertyCollection->getUserEmail()->getValue();;

    if(!$emailOrder){
        foreach($propertyCollection as $orderProperty) {
            if ($orderProperty->getField('CODE') == 'CONTACT_EMAIL' && $orderProperty->getValue()) {
                $emailOrder = $orderProperty->getValue();
                break;
            }
        }
    }

    if (empty($emailOrder)) {
        throw new Exception('В заказе не указан email');
    }


    if (strtolower($emailOrder) !== strtolower($email)) {
        throw new Exception('Email не совпадает с email в заказе');
    }


    // Ищем существующий купон
    $coupon = DiscountCouponTable::getList([
        'select' => ['*'],
        'filter' => [
            'DESCRIPTION' => $orderNumber,
            'USER_ID' => $order->getUserId()
        ],
    ])->fetch();

    if (!$coupon) {
        // Купон не существует - создаем новый
        $codeCoupon = createCoupon($order->getUserId(), $orderNumber);
        createSpB24($request, $codeCoupon);

        $response = [
            'success' => true,
            'message' => 'Спасибо за ваш отзыв!',
            'has_coupon' => true,
            'coupon' => $codeCoupon
        ];

    } elseif ($coupon && !$coupon['DATE_APPLY']) {
        // Купон существует и не использован
        $response = [
            'success' => true,
            'message' => 'Спасибо за ваш отзыв!',
            'has_coupon' => true,
            'coupon' => $coupon['COUPON'],
            'repeatReq' => true
        ];

    } elseif ($coupon && $coupon['DATE_APPLY']) {
        // Купон уже использован
        $response = [
            'success' => true,
            'message' => 'Спасибо за ваш отзыв!',
            'has_coupon' => false,
            'coupon' => ''
        ];

    } else {
        throw new Exception('Произошла непредвиденная ошибка');
    }

} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => $e->getMessage(),
        'has_coupon' => false,
        'coupon' => ''
    ];
}

echo json_encode($response);

/**
 * Создает купон для пользователя
 */
function createCoupon($userId, $orderNumber): string
{
    $code = generateCouponCode();

    $couponFields = [
        'DISCOUNT_ID' => 10, // ID скидки (проверьте правильность)
        'ACTIVE' => 'Y',
        'COUPON' => $code,
        'DATE_APPLY' => null,
        'USER_ID' => $userId,
        'TYPE' => \Bitrix\Sale\Internals\DiscountCouponTable::TYPE_ONE_ORDER,
        'ONE_TIME' => 'Y', // Исправлена опечатка (был лишний пробел)
        'DESCRIPTION' => $orderNumber,
        'MAX_USE' => 1,
        'USE_COUNT' => 0
    ];

    $result = DiscountCouponTable::add($couponFields);

    if (!$result->isSuccess()) {
        $errors = implode(', ', $result->getErrorMessages());
        throw new Exception("Ошибка при создании купона: {$errors}");
    }

    return $code;
}

/**
 * Генерирует уникальный код купона
 */
function generateCouponCode($length = 8): string
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = 'HF'; // префикс

    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return $code;
}

function createSpB24($request, $coupon): void
{
    CRest::call(
        'crm.item.add',
        [
            'entityTypeId' => 1054,
            'fields' => [
                'title' => "Отзыв за заказ - ". $request->getPost('order'),
				'assignedById' => 7,
                'ufCrm10_1759942592008' => $request->getPost('order'),
                'ufCrm10_1759942606347' => $request->getPost('email'),
                'ufCrm10_1759942666972' => $request->getPost('material'),
                'ufCrm10_1759942717560' => $request->getPost('sales'),
                'ufCrm10_1759942726334' => $request->getPost('delivery'),
                'ufCrm10_1759942741498' => $request->getPost('comment'),
                'ufCrm10_1759942782137' => $request->getPost('files'),
                'ufCrm10_1759947096' => $request->getPost('technicalSupport'),
                'ufCrm10_1759947184' => $request->getPost('problem'),
                'ufCrm10_1760041911014' => $coupon,
                'ufCrm10_1760041935807' => 'Получен',
            ],
        ]
    );
}
