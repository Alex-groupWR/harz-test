<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;
use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\FileHelper;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

if (!Loader::includeModule('intec.core'))
    return;

if (!Loader::includeModule('intec.cabinet'))
    return;

IntecCabinet::Initialize();

Loc::loadMessages(__FILE__);

$APPLICATION->SetAdditionalCSS(BX_PERSONAL_ROOT . '/css/intec/style.css', true);
$this->setFrameMode(true);
$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));
$arPaymentData = [];

$arSvg = [
    'RETURN' => FileHelper::getFileData(__DIR__.'/images/arrow_return.svg'),
    'BLOCK_TOGGLE' => FileHelper::getFileData(__DIR__.'/images/block_toggle.svg'),
    'PREV' => FileHelper::getFileData(__DIR__.'/images/pagination_prev.svg'),
    'NEXT' => FileHelper::getFileData(__DIR__.'/images/pagination_next.svg')
];

$bOrderCanceled = $arResult['CANCELED'] === 'Y';
$sUserName = [];
$sUserNameTitle = Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_HEADER_FIO');

if (!empty($arResult['USER']['NAME']))
    $sUserName[] = $arResult['USER']['NAME'];

if (!empty($arResult['USER']['SECOND_NAME']))
    $sUserName[] = $arResult['USER']['SECOND_NAME'];

if (!empty($arResult['USER']['LAST_NAME']))
    $sUserName[] = $arResult['USER']['LAST_NAME'];

$sUserName = implode(' ', $sUserName);

if (empty($sUserName)) {
    if (!empty($arResult['FIO'])) {
        $sUserName = $arResult['FIO'];
    } else {
        $sUserName = $arResult['USER']['LOGIN'];
        $sUserNameTitle = Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_HEADER_LOGIN');
    }
}

$bShowUserLogin = !empty($arResult['USER']['LOGIN']) && !ArrayHelper::isIn('LOGIN', $arParams['HIDE_USER_INFO']);
$bShowUserEmail = !empty($arResult['USER']['EMAIL']) && !ArrayHelper::isIn('EMAIL', $arParams['HIDE_USER_INFO']);
$bShowUserType = !empty($arResult['USER']['PERSON_TYPE_NAME']) && !ArrayHelper::isIn('PERSON_TYPE_NAME', $arParams['HIDE_USER_INFO']);
$bShowUser = !empty($arResult['USER']) && ($bShowUserLogin || $bShowUserEmail || $bShowUserType);

if ($arParams['GUEST_MODE'] !== 'Y') {
	Asset::getInstance()->addCss('/bitrix/templates/.default/components/bitrix/sale.order.payment.change/intec.cabinet.order.payment.change.1/style.css');
}

CJSCore::Init(['clipboard', 'fx']);

$APPLICATION->SetTitle(Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_HEADER_NUM', [
    '#NUMBER#' => Html::encode($arResult['ID'])
]));

?>
<div id="<?= $sTemplateId ?>" class="ns-bitrix c-sale-personal-order-detail c-sale-personal-order-detail-template-1">
    <div class="sale-personal-order-detail-wrapper intec-content">
        <div class="sale-personal-order-detail-wrapper-2 intec-content-wrapper">
            <?php if (!empty($arResult['ERRORS']['FATAL'])) { ?>
                <div class="sale-personal-order-detail-errors intec-ui intec-ui-control-alert intec-ui-scheme-red">
                    <?php foreach ($arResult['ERRORS']['FATAL'] as $sError) echo Html::tag('div', $sError) ?>
                </div>
                <?php if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED])) { ?>
                    <div class="sale-personal-order-detail-authorize intec-ui-m-t-20">
                        <?php $APPLICATION->AuthForm('', false, false, 'N', false) ?>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <?php include(__DIR__.'/parts/back_to_orders.php') ?>
                <?php if (!empty($arResult['ERRORS']['NONFATAL'])) { ?>
                    <div class="sale-personal-order-detail-errors intec-ui intec-ui-control-alert intec-ui-scheme-red intec-ui-m-b-20">
                        <?php foreach ($arResult['ERRORS']['NONFATAL'] as $sError) echo Html::tag('div', $sError) ?>
                    </div>
                <?php } ?>
                <div class="sale-personal-order-detail-header">
                    <div class="sale-personal-order-detail-header-top">
                        <div class="intec-grid intec-grid-wrap intec-grid-a-h-start intec-grid-a-v-center intec-grid-i-h-8 intec-grid-i-v-8">
                            <div class="intec-grid-item-auto">
                                <span class="sale-personal-order-detail-header-number">
                                    <?= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_HEADER_NUM', [
                                        '#NUMBER#' => Html::encode($arResult['ACCOUNT_NUMBER'])
                                    ]) ?>
                                </span>
                                <span class="sale-personal-order-detail-header-date">
                                    <?= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_HEADER_DATE', [
                                        '#DATE#' => $arResult['DATE_FORMATED']
                                    ]) ?>
                                </span>
                            </div>
                            <div class="intec-grid-item"></div>
<?php if ($arParams['GUEST_MODE'] !== 'Y') { ?>
     <?php
     foreach ($arResult['PAYMENT'] as &$arPayment) {
     ?>
        <?php
        $paySystemService = \Bitrix\Sale\PaySystem\Manager::getObjectById($arPayment['PAY_SYSTEM_ID']);
        if (!empty($paySystemService)) {
            $orderObj = \Bitrix\Sale\Order::load($arPayment['ORDER_ID']);
            if ($orderObj) {
                $paymentCollection = $orderObj->getPaymentCollection();
                $payment = $paymentCollection ? $paymentCollection->getItemById($arPayment['ID']) : null;

                if (
                    $payment
                    && (
                        $paySystemService->getField('NEW_WINDOW') === 'N'
                        || $paySystemService->getField('ID') == \Bitrix\Sale\PaySystem\Manager::getInnerPaySystemId()
                    )
                ) {
                    try {
                        $shipmentCollection = $orderObj->getShipmentCollection();
                        if ($shipmentCollection) {
                            $hasRealShipment = false;
                            foreach ($shipmentCollection as $currentShipment) {
                                if ($currentShipment && !$currentShipment->isSystem()) {
                                    $hasRealShipment = true;
                                    break;
                                }
                            }

                            if (!$hasRealShipment) {
                                $systemShipment = $shipmentCollection->getSystemShipment();
                                $basket = $orderObj->getBasket();
                                if ($basket) {
                                    if (in_array($systemShipment->getField('STATUS_ID'), ['N', 'NK'])) {
                                        $systemShipment->setBasePriceDelivery(0);
                                    }
                                    foreach ($basket as $basketItem) {
                                        $systemShipment->addItemQuantity($basketItem, $basketItem->getQuantity());
                                    }
                                }
                            }
                        }

                        $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

                        $initResult = $paySystemService->initiatePay(
                            $payment,
                            $request,
                            \Bitrix\Sale\PaySystem\BaseServiceHandler::STRING
                        );

                        if ($initResult->isSuccess()) {
                            $arPayment['BUFFERED_OUTPUT'] = $initResult->getTemplate();
                            $arPayment['PAYMENT_URL'] = $initResult->getPaymentUrl();
                        }
                    } catch (\Throwable $e) {
                    }
                }
            }
        }
        ?>
        <?php if (!empty($arPayment['BUFFERED_OUTPUT'])) { ?>
            <div class="intec-grid-item-auto payment-wrapper payment-wrapper--<?=$arPayment['ID']?>">
                    <?= Html::tag('div', Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_BUTTON_PAY'), [
                        'class' => [
                            'sale-personal-order-detail-button',
                            'sale-personal-order-detail-button--width',
                            'sale-personal-order-detail-block-payment--sber',
                            'intec-ui' => [
                                '',
                                'control-button',
                                'mod-transparent',
                                'mod-round-2',
                                'scheme-current'
                            ]
                        ],
                        'data-id' => $arPayment['ID'],
                    ]) ?>
                <div class="payment-content payment-content--<?=$arPayment['ID']?>">
                    <div class="sale-personal-order-detail-block-payment-form-container">
                        <div class="sale-personal-order-detail-block-payment-form intec-ui-m-t-20">
                            <div class="sale-personal-order-detail-block-payment-form-content">
                                <?= $arPayment['BUFFERED_OUTPUT'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php
    }
    unset($arPayment);
    ?>
<?php } ?>

                        </div>
                    </div>
                    <div class="sale-personal-order-detail-header-bottom">
                        <div class="intec-grid intec-grid-wrap intec-grid-a-h-between intec-grid-a-v-start intec-grid-i-h-8 intec-grid-i-v-8">
                            <div class="intec-grid-item-auto intec-grid-item-425-1 intec-grid intec-grid-a-h-start intec-grid-a-v-start intec-grid-i-8 rerow">
                                <div class="sale-personal-order-detail-field-title intec-grid-item-1 intec-grid-item-425-2">
                                    <?= $sUserNameTitle ?>
                                </div>
                                <div class="sale-personal-order-detail-field-value intec-grid-item-1 intec-grid-item-425-2">
                                    <?= $sUserName ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sale-personal-order-detail-blocks">
                    <div class="intec-grid intec-grid-wrap intec-grid-a-h-start intec-grid-a-v-start intec-grid-i-h-12">
                        <div class="intec-grid-item-1200-1 intec-grid-item-1">
                            <?php if (!empty($arResult['PAYMENT'])) { ?>
                                <?php include(__DIR__.'/parts/payment.php') ?>
                            <?php } ?>
                            <?php if (!empty($arResult['BASKET'])) { ?>
                                <?php include(__DIR__.'/parts/products.php') ?>
                            <?php } ?>
                            <?php if (!empty($arResult['DOCUMENTS'])) { ?>
                                <?php include(__DIR__.'/parts/documents.php') ?>
                            <?php } ?>
                            <?php if (!empty($arResult['INFO_BLOCKS'])) { ?>
                            <?php } ?>
                            <?php if (Loader::includeModule('support')) { ?>
                                <?php include(__DIR__.'/parts/claims.php') ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
			<?php //include(__DIR__.'/parts/back_to_orders.php') ?>
                <?php include(__DIR__.'/parts/script.php') ?>
            <?php } ?>
        </div>
    </div>
</div>
