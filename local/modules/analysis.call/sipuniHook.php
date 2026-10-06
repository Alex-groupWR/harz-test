<?php
define('NOT_CHECK_PERMISSIONS', true);
define('STOP_STATISTICS', true);
define('NO_AGENT_CHECK', true);
define('DisableEventsCheck', true);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use Bitrix\Main\Loader;


try {
    if(!Loader::IncludeModule('analysis.call')){
        die();
    }
    $data = json_decode(file_get_contents('php://input'), true) ?: $_REQUEST;
    \Analysis\Call\Tools\Logger::write($data, 'Hook.log');

    if (empty($data)){
        throw new  Exception('Пустой запрос');
    }

    if ($data['status'] == 'ANSWER' && $data['call_id'] && $data['call_record_link'] && $data['call_start_timestamp'] && $data['user_id']){
        \Analysis\Call\Orm\CallQueueController::addInQueue($data);
    }


} catch (Exception $e) {
    echo $e->getMessage();
}

