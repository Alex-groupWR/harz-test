<?
include_once 'system-functions.php';
require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/critical_css.php");
$classPath = $_SERVER['DOCUMENT_ROOT'] . '/support/rate-us/RateSP.php';

if (file_exists($classPath)) {
    include_once $classPath;
} else {
    AddMessage2Log("Файл класса не найден: " . $classPath);
}


use \Bitrix\Main\EventManager;
use \Bitrix\Main\Loader;
use Bitrix\Crm\DealTable;

EventManager::getInstance()->addEventHandler("imconnector", "OnSendMessageCustom", array("HarzEvents", "OnSendMessageCustomHandler"));
EventManager::getInstance()->addEventHandler("iblock", "OnAfterIBlockElementAdd", array("HarzEvents", "IBlockClearCache"));
EventManager::getInstance()->addEventHandler("iblock", "OnAfterIBlockElementUpdate", array("HarzEvents", "IBlockClearCache"));
//EventManager::getInstance()->addEventHandler("crm", "OnAfterCrmDealAdd", array("HarzEvents", "OnAfterCrmDealAddHandler"));

//AddEventHandler("form","onBeforeResultAdd","onBeforeResultAddHandler");

Loader::registerAutoLoadClasses(null, [
    'B24OrderRest' => '/local/php_interface/B24OrderRest.php',
]);

//if (SITE_ID == 'en') {
//    $ip = $_SERVER['REMOTE_ADDR'];
//
//    $ipInfo = json_decode(file_get_contents("http://ip-api.com/json/{$ip}?fields=status,message,country,countryCode"), true);
//
//    if(isset($ipInfo['country']) && $ipInfo['country'] == 'Russia') {
//        http_response_code(403);
//        die('Forbidden');
//    }
//}

class HarzEvents {
    public static function IBlockClearCache(&$arFields)
    {
        if(!$arFields["RESULT"] || $arFields["WF_PARENT_ELEMENT_ID"]) return false;

        // Массив хранящий ID инфоблока (ключ массива) и путь к кешу
        $arIBlock2Component[40][] = "/local/templates/hlab_store/components/bitrix/news/new_news/news.php";
        $arIBlock2Component[40][] = "/local/templates/hlab_store/components/bitrix/news/new_news/bitrix/news.detail/.default/template.php";

        // Если для этого инфоблока есть пути для очищения, то очищаем их
        if ($arIBlock2Component[$arFields["IBLOCK_ID"]] && count($arIBlock2Component[$arFields["IBLOCK_ID"]])) {
            foreach ($arIBlock2Component[$arFields["IBLOCK_ID"]] as $cachePath) {
                BXClearCache(true, $cachePath);
            }
        }
    }
    public static function OnSendMessageCustomHandler(\Bitrix\Main\Event $event)
    {
        $arParameters = $event->getParameters();
        if ($arParameters['CONNECTOR'] == 'HarzLabs_WA_Connector') {

            $sMessage = $arParameters['DATA'][0]['message']['text'];
            $sChatID = $arParameters['DATA'][0]['chat']['id'];

            $sMessage = str_replace('[br]','', $sMessage);
            $sMessage = str_replace('[b]','*', $sMessage);
            $sMessage = str_replace('[/b]','*', $sMessage);

            $arPOST = [
                'body' => $sMessage,
                'chatId' => $sChatID
            ];

            $arSend = sendWhatsappRequest('sendMessage', '', $arPOST, 'SUPPORT');
        }
		
	if ($arParameters['CONNECTOR'] == 'HarzLabs_WA_Sales_Connector') {

            $sMessage = $arParameters['DATA'][0]['message']['text'];
            $sChatID = $arParameters['DATA'][0]['chat']['id'];

            $sMessage = str_replace('[br]','', $sMessage);
            $sMessage = str_replace('[b]','*', $sMessage);
            $sMessage = str_replace('[/b]','*', $sMessage);

            $arPOST = [
                'body' => $sMessage,
                'chatId' => $sChatID
            ];

            $arSend = sendWhatsappRequest('sendMessage', '', $arPOST, 'SALES');
        }
		
    }


    function OnAfterCrmDealAddHandler (&$arFields){
        \Bitrix\Main\Diag\Debug::writeToFile($arFields);

        require_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/class/cRest.php');
        define('C_REST_WEB_HOOK_URL','https://bx.harzlabs.ru/rest/463/3ipx7vlboaw688m6/');

        $iOwnerID = intval($arFields['ID']);
        $iDealNumber = intval($arFields['UF_CRM_1668255176610']); // Номер заказа

        if ($iDealNumber > 0){
            $arResult = CRest::call('crm.orderentity.list',['filter' => ['ownerId' => $iOwnerID]]);
            $iOrderID = intval($arResult['result']['orderEntity'][0]['orderId']);

            if ($iOrderID > 0 && $iDealNumber > 0) {

                $connection = \Bitrix\Main\Application::getConnection();
                $sqlHelper = $connection->getSqlHelper();

                $sqlDealNumber = $sqlHelper->forSql($iDealNumber);
                $sqlOrderID = $sqlHelper->forSql($iOrderID);

                $query = "UPDATE b_sale_order SET ACCOUNT_NUMBER = '".$sqlDealNumber."' where id='".$sqlOrderID."'";
                $result = $connection->query($query);

                $arOrder = CRest::call('sale.order.get',['id' => $iOrderID]);
                $arOrder = $arOrder['result']['order'];

                $sOrderProps = '';
                foreach ($arOrder['propertyValues'] as $arProperty){
                    $sOrderProps = $sOrderProps.$arProperty['name']. ': '.$arProperty['value'] . ' 
';
                }

                $sOrderProps = $sOrderProps.'
Комментарий покупателя: '.$arOrder['userDescription'];

                $arResult = CRest::call('crm.deal.update',
                    ['id' => $iOwnerID,
                        'fields' => ['UF_CRM_1669046190' => $sOrderProps],
                    ]);
            }
        }
    }
}


if (SITE_ID == 'st' || SITE_ID == 'en') {
    include_once 'class/IblockImageConvert.php';
	//include_once 'class/searchQuery.php';
    include_once 'events.php';
    include_once 'functions.php';

    $APPLICATION->AddHeadString('<link rel="icon" href="/local/templates/hlab_store/favicon.png" type="image/x-icon">');

    // боремся с ебучими магическими числами
    define("SKU_COLOR_ID", 173);
    define("ID_IB_PRINTERS_TYPES", 45); // ИБ - Виды принтеров
    define("ID_IB_CATALOG_PRODUCTS", 34); // ИБ - Catalog
    define("ID_IB_CATALOG_SKU", 35); // ИБ - Offers
    define("ID_IB_PRINTERS_SETTINGS", 53); // ИБ - принтеры настройка


    define("ID_IB_NEWS_RU", 40); // ИБ - Offers
    define("ID_IB_MEDIA_RU", 58); // ИБ - smi
    define("ID_IB_ACADEMY", 37); // ИБ - Академия
    define("ID_IB_DEALERS_MAP", 47); // ИБ - Карты
    define("URL_EN_DOMAIN", 'harzlabs.com');
    define("URL_RU_DOMAIN", 'harzlabs.ru');

    function pre($data)
    {
        echo '<pre>' . print_r($data, true) . '</pre>';
    }

    define("DEFAULT_LANG", 'en');
    $languages = [
        DEFAULT_LANG => 'English',
        'ru' => 'Russian',
    ];

    $client_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    if (isset($_GET['lang']) || in_array($_GET['lang'], $languages)) {
        $_SESSION['lang'] = $_GET['lang'];
    } else if (!isset($_SESSION['lang'])) {
        if (!isset($_GET['lang']) && isset($languages[$client_lang])) {
            $_SESSION['lang'] = $client_lang;
        } else {
            $_SESSION['lang'] = DEFAULT_LANG;
        }
    }

    define('SITE_LANG', $_SESSION['lang']);
    define(LANGUAGE_ID, $_SESSION["lang"]);
}

AddEventHandler("main", "OnAfterUserAdd", "OnAfterUserRegisterHandler");
AddEventHandler("main", "OnAfterUserRegister", "OnAfterUserRegisterHandler");

function OnAfterUserRegisterHandler(&$arFields)
{
    if (intval($arFields["ID"])>0)
    {
        $toSend = Array();
        $toSend["PASSWORD"] = $arFields["CONFIRM_PASSWORD"] ? $arFields["CONFIRM_PASSWORD"] : $arFields["PASSWORD"];
        $toSend["EMAIL"] = $arFields["EMAIL"];
        $toSend["USER_ID"] = $arFields["ID"];
        $toSend["USER_IP"] = $arFields["USER_IP"];
        $toSend["USER_HOST"] = $arFields["USER_HOST"];
        $toSend["LOGIN"] = $arFields["LOGIN"];
        $toSend["CHECKWORD"] = $arFields["CHECKWORD"];
        $toSend["NAME"] = (trim ($arFields["NAME"]) == "")? $toSend["NAME"] = htmlspecialchars('<Не указано>'): $arFields["NAME"];
        $toSend["LAST_NAME"] = (trim ($arFields["LAST_NAME"]) == "") ? '' : $arFields["LAST_NAME"];
        CEvent::SendImmediate ("USER_INFO_NEW", SITE_ID, $toSend);
    }
    return $arFields;
}

EventManager::getInstance()->addEventHandler(
    'sale',
    'onSaleDeliveryServiceCalculate',
    'calcDelivery'
);

function calcDelivery(\Bitrix\Main\Event $event)
{
    /** @var Delivery\CalculationResult $baseResult */
    $baseResult = $event->getParameter('RESULT');
    $shipment = $event->getParameter('SHIPMENT');

    $result = \Bitrix\Sale\Delivery\Services\Table::getList(array(
        'filter' => array('ACTIVE'=>'Y', 'ID' => $shipment->getDeliveryId()),
    ));

    while($delivery=$result->fetch())
    {
        if ($delivery["CONFIG"]["MAIN"]["PRICE"] === "") {
            $baseResult->addError(new \Bitrix\Main\Error(GetMessage("CW_MD_DELIVERY_TITLE")));
        }
    }
    $event->addResult(
        new \Bitrix\Main\EventResult(
            \Bitrix\Main\EventResult::SUCCESS, array('RESULT' => $baseResult)
        )
    );
}

/*
EventManager::getInstance()->addEventHandler(
    "tasks",
    "OnTaskAdd",
    "addAccomplice"
);

function addAccomplice($id, $arData) {
    require_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/class/cRest.php');
    define('C_REST_WEB_HOOK_URL','https://bx.harzlabs.ru/rest/1051/qe2lqn53eeapvc69/');

    $iAuditorId = 8009;

    if ($id && !empty($arData)) {
        $arAuditors = $arData['AUDITORS'];
        if (is_array($arAuditors)) {
            array_push($arAuditors, $iAuditorId);
        } else {
            $arAuditors = array($iAuditorId);
        }

        $result = CRest::call(
            'tasks.task.update',
            [
                'taskId' => $id,
                'fields' => [
                    'AUDITORS' => $arAuditors
                ],
            ]);
    }
}
*/

$eventManager = EventManager::getInstance();

$eventManager->addEventHandlerCompatible(
	'crm',
	'OnBeforeCrmDealUpdate',
	function (&$arFields){
		$dealFactory = \Bitrix\Crm\Service\Container::getInstance()->getFactory(2);
		$deal  = $dealFactory->GetItem($arFields['ID']); //$dealId -число
		$dealFileId = $deal->get('UF_CRM_1674408779879');

		//file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logs.txt', print_r($propValue,1));

		if(!empty($dealFileId) && ($dealFileId != $arFields['UF_CRM_1674408779879'])){
			die();
		}
		//$arFields['UF_CRM_1674408779879'] = 273036;

		//die();
	}
);




EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleOrderBeforeSaved',
    'updateAddress'
);

function updateAddress(\Bitrix\Main\Event $event)
{
    if (!Loader::includeModule('dellindev.shipment')) {
        return;
    }

    /** @var \Bitrix\Sale\Order $order */
    $order = $event->getParameter("ENTITY");

    $propertyCollection = $order->getPropertyCollection();
    $terminalProperty = $propertyCollection->getItemByOrderPropertyCode('TERMINAL_ID');

    $terminalId = $terminalProperty ? $terminalProperty->getValue() : null;

    // Если есть terminalId, но нет адреса
    if (!empty($terminalId)) {
            $addressInfo = Sale\Handlers\Delivery\DellinBlockAdmin::getTerminalInfo($terminalId, 99);

			$propertyCollection = $order->getPropertyCollection();
			$property = $propertyCollection->getItemByOrderPropertyCode('ADDRESS_TERMINAL');

			if ($property) {
    			$property->setField('VALUE', $addressInfo->fullAddress);
			}
    }
}


EventManager::getInstance()->addEventHandler(
    'tasks',
    'OnTaskAdd',
    'checkRegularTaskAndNotify'
);

function checkRegularTaskAndNotify($taskId, &$arFields)
{
    if (!Loader::includeModule('tasks') || !Loader::includeModule('im')) {
        return;
    }

    $resTask = CTasks::GetByID($taskId, false);
    if ($task = $resTask->Fetch()) {

        if (!empty($task['FORKED_BY_TEMPLATE_ID'])) {

            $notificationFields = [
                "MESSAGE_TYPE" => "S",
                "TO_USER_ID" => $task['CREATED_BY'],
                "FROM_USER_ID" => 0,
                "NOTIFY_TYPE" => 4,
                "NOTIFY_MODULE" => "tasks",
                "NOTIFY_EVENT" => "task_regular_created",
                "NOTIFY_TAG" => "TASK|REGULAR|".$taskId,
                "MESSAGE" => "Создана новая регулярная задача: [URL=/company/personal/user/{$task['CREATED_BY']}/tasks/task/view/{$taskId}/]{$task['TITLE']}[/URL]"
            ];

            CIMNotify::Add($notificationFields);
        }
    }
}

use Bitrix\Main\Config\Option;

EventManager::getInstance()->addEventHandler(
    'tasks',
    'OnTaskUpdate',
    'OnTaskUpdateHandler'
);

function OnTaskUpdateHandler($ID, &$arFields, &$arTaskCopy)
{
    if (isset($arFields['RESPONSIBLE_ID']) && $arFields['RESPONSIBLE_ID'] != $arTaskCopy['RESPONSIBLE_ID']) {

        if (Loader::includeModule('im')) {
            $newResponsibleId = $arFields['RESPONSIBLE_ID'];
            $taskTitle = $arTaskCopy['TITLE']; 

            $serverName = Option::get('main', 'server_name', $_SERVER['SERVER_NAME']);
            $protocol = (\CMain::IsHTTPS() ? 'https' : 'http');
            $taskUrl = "{$protocol}://{$serverName}/company/personal/user/{$newResponsibleId}/tasks/task/view/{$ID}/";

            // Отправляем уведомление
            \CIMNotify::Add([
                "FROM_USER_ID" => 0,
                "TO_USER_ID" => $newResponsibleId,
                "NOTIFY_MODULE" => "tasks",
                "NOTIFY_MESSAGE" => "Вам делегирована задача: [URL={$taskUrl}]{$taskTitle}[/URL]",
                "NOTIFY_TAG" => "TASK|DELEGATE|{$ID}",
            ]);
        }
    }
}

use Bitrix\Sale\Order;



EventManager::getInstance()->addEventHandler('sale', 'OnSaleOrderSaved', 'finalCrmFix');

function finalCrmFix(\Bitrix\Main\Event $event)
{
    /** @var Order $order */
    $order = $event->getParameter("ENTITY");
    $isNew = $event->getParameter("IS_NEW");

    if ($isNew) return; // Не трогаем новые заказы

    // Получаем типы (приводим к INT для надежности)
    $currentType = (int)$order->getPersonTypeId();

    // Получаем ОРИГИНАЛЬНОЕ значение из базы до этого сохранения
    $fields = $order->getFields();
    $originalValues = $fields->getOriginalValues();
    $oldType = isset($originalValues['PERSON_TYPE_ID']) ? (int)$originalValues['PERSON_TYPE_ID'] : $currentType;

    // Если в базе было 8 или 9, а сейчас стало 5
    if (($oldType === 8 || $oldType === 9) && $currentType === 5) {

        // Проверяем, не в админке ли мы
        if (strpos($_SERVER['REQUEST_URI'], '/bitrix/admin/') === false) {

            // Насильно меняем тип обратно в объекте и сохраняем ТИХО (без повторных событий)
            $order->setFieldNoDemand('PERSON_TYPE_ID', $oldType);

            // Прямое обновление таблицы, чтобы никто больше не перехватил
            $conn = \Bitrix\Main\Application::getConnection();
            $conn->queryExecute("UPDATE b_sale_order SET PERSON_TYPE_ID = {$oldType} WHERE ID = " . $order->getId());

            // Лог для подтверждения победы
            file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/final_win.log", "Заказ #".$order->getId().": Тип 5 принудительно возвращен на $oldType через SQL\n", FILE_APPEND);
        }
    }
}


EventManager::getInstance()->addEventHandler('tasks', 'OnTaskAdd', 'AddObserverToNewTask');

function AddObserverToNewTask($taskId, $arFields) {
    if (!CModule::IncludeModule("tasks")) {
        return;
    }
    $observerId = 8009;

    CTasks::AddAuditors($taskId, [$observerId]);
}


use Bitrix\Sale\Internals\PaymentTable;
use Bitrix\Crm\Binding\OrderEntityTable;
use Bitrix\Main\Diag\Debug;

/**
 * Функция-агент, которая через 5 минут проверяет, оплачен ли заказ.
 */
function runDeferredPaymentWorkflow(int $paymentId): string
{
    if (!Loader::includeModule('sale') || !Loader::includeModule('crm') || !Loader::includeModule('bizproc')) {
        return "";
    }

    try {
        // Делаем запрос в БД спустя 5 минут после вебхука
        $payment = PaymentTable::getRow([
            'select' => ['ORDER_ID', 'PAID'],
            'filter' => ['=ID' => $paymentId],
        ]);

        // Если оплаты нет или статус спустя 5 минут НЕ равен 'Y' — отменяем запуск
        if (!$payment || !$payment['ORDER_ID'] || $payment['PAID'] !== 'Y') {
            Debug::writeToFile(
                "Агент: Проверка через 5 минут завершена. Оплата №{$paymentId} НЕ в статусе Y (или удалена). Пропуск.",
                'OnSaleOrderPaid AGENT_SKIP ' . date('Y-m-d H:i:s'),
                '/local/php_interface/sale_order_paid.log'
            );
            return ""; // Агент удаляется, БП не запускается
        }

        $orderId = (int)$payment['ORDER_ID'];

        // Если статус спустя 5 минут 'Y', ищем привязанную сделку
        $binding = OrderEntityTable::getRow([
            'select' => ['OWNER_ID'],
            'filter' => [
                '=ORDER_ID'     => $orderId,
                '=OWNER_TYPE_ID' => \CCrmOwnerType::Deal,
            ],
        ]);

        if ($binding && (int)$binding['OWNER_ID'] > 0) {
            $dealId = (int)$binding['OWNER_ID'];
            $templateId  = 691;
            $documentId  = ['crm', 'CCrmDocumentDeal', 'DEAL_' . $dealId];
            $arErrors    = [];

            // Запускаем бизнес-процесс
            $workflowId = \CBPDocument::StartWorkflow($templateId, $documentId, [], $arErrors);

            if (!empty($arErrors)) {
                Debug::writeToFile(
                    "Агент: Ошибка запуска БП для сделки №{$dealId}: " . print_r($arErrors, true),
                    'OnSaleOrderPaid BIZPROC_ERROR ' . date('Y-m-d H:i:s'),
                    '/local/php_interface/sale_order_paid.log'
                );
            } else {
                Debug::writeToFile(
                    "Агент: Статус подтвержден спустя 5 мин. БП запущен. ID: {$workflowId}. Заказ №{$orderId}, Сделка №{$dealId}",
                    'OnSaleOrderPaid SUCCESS ' . date('Y-m-d H:i:s'),
                    '/local/php_interface/sale_order_paid.log'
                );
            }
        } else {
            Debug::writeToFile(
                "Агент: Сделка не найдена для оплаты №{$paymentId} (Заказ №{$orderId})",
                'OnSaleOrderPaid WARNING ' . date('Y-m-d H:i:s'),
                '/local/php_interface/sale_order_paid.log'
            );
        }

    } catch (\Throwable $e) {
        Debug::writeToFile(
            "Ошибка в Агенте: " . $e->getMessage(),
            'OnSaleOrderPaid ERROR ' . date('Y-m-d H:i:s'),
            '/local/php_interface/sale_order_paid.log'
        );
    }

    return ""; // Возвращаем пустую строку, чтобы Битрикс удалил отработавший агент
}

?>