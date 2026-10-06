<?php
define('NOT_CHECK_PERMISSIONS', true);
define('STOP_STATISTICS', true);
define('NO_AGENT_CHECK', true);
define('DisableEventsCheck', true);
define("NO_KEEP_STATISTIC", true);
define('BX_NO_ACCELERATOR_RESET', true);
define('BX_CRONTAB', true);
define('NO_AGENT_STATISTIC', 'Y');

set_time_limit(0); // Без ограничения времени
ini_set('memory_limit', '-1'); // Без ограничения памяти
ignore_user_abort(true); // Продолжать выполнение даже если соединение разорвано

$_SERVER["DOCUMENT_ROOT"] = '/var/www/vhosts/harzlabs.ru/bx.harzlabs.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
require_once (__DIR__.'/lib/Rest/crest.php');


try {
    if(!Loader::IncludeModule('analysis.call')){
        die();
    }

    // получаем звонок и проверяем находится он в обработке или нет
    $call = \Analysis\Call\Orm\CallQueueController::getFirstInQueue();

    $userName = getUserID($call['CALL_ID']);
    if (isset($userName['error'])) {
        Analysis\Call\Orm\CallQueueController::deleteQueue($call['ID']);
        throw new \Exception($userName['error'] . $call['CALL_ID'] . $call['RECORD_LINK']);
    }

    if(isset($call['error'])){
        throw new \Exception($call['error']);
    }
    if(!isset($call['RECORD_LINK']) || !isset($call['USER_ID']) || !isset($call['CALL_ID']) ){
        throw new \Exception('Не переданы обязательные аргументы');
    }

    //получаем аудиозапись проверяем её
    $filePath = \Analysis\Call\Orm\CallQueueController::getRecord($call['RECORD_LINK'], $call['CALL_ID']);
    if(!$filePath || isset($filePath['error'])){
        throw new \Exception($filePath['error']??'Не известная ошибка при скачивание аудио');
    }



    // Создаем экземпляр класса
    $stt = new Analysis\Call\Speech\YandexSpeechToTextCurl( \Analysis\Call\Tools\Config::API_KEY, \Analysis\Call\Tools\Config::FLODER_ID);

    // 1. Загружаем аудио в бакет
    $objectName = $stt->uploadToBucket($filePath, \Analysis\Call\Tools\Config::BUCKET_NAME);
    if(isset($objectName['error'])){
        throw new \Exception($objectName['error']);
    }

    // 2. Запускаем транскрибацию
    $operationId = $stt->startTranscription(\Analysis\Call\Tools\Config::BUCKET_NAME, $objectName);
    if(isset($operationId['error'])){
        throw new \Exception($objectName['error']);
    }

    // 3. Получаем результаты
    $results = $stt->getTranscriptionResults($operationId);
    if(isset($results['error'])){
        throw new \Exception($objectName['error']);
    }

	$deleteResult = $stt->deleteObject(\Analysis\Call\Tools\Config::BUCKET_NAME, $objectName);
    if(isset($deleteResult['error'])){
        throw new \Exception($deleteResult['error']);
    }

    // 4. Формируем ответ в строку
    $speechText = '';
    foreach ($results as $index => $result) {
        $speechText .=  " (Channel: " . $result['channel'] . "):\n";
        $speechText .= "Text: " . $result['text'] . "\n";
        if ($result['confidence']) {
            $speechText .= "Confidence: " . round($result['confidence'] * 100, 2) . "%\n";
        }
    }
    if(!$speechText){
        throw new \Exception('Не удалось получить текст звонка');
    }



    // Создаем экземпляр анализатора
    $analyzer = new Analysis\Call\Speech\CallTextAnalyzer(\Analysis\Call\Tools\Config::API_KEY, \Analysis\Call\Tools\Config::FLODER_ID);
    // Загружаем текст
    $analyzer->loadText($speechText);
    //запускаем анализ текста
    $analysis = $analyzer->analyzeCall();
    if (isset($analysis['error'])) {
        throw new \Exception($analysis['error']);
    }



    if (!empty($analysis)) {
        Analysis\Call\Orm\CallQueueController::addStatistic($analysis,$userName,$call['CALL_DATE']);
        addStaticList($analysis,$userName,$call['CALL_DATE']);
        unlink($filePath);
        Analysis\Call\Orm\CallQueueController::deleteQueue($call['ID']);

    }else{
        throw new \Exception('Пришел пустой ответ от нейронки');
    }


}catch (Exception $e) {
    \Analysis\Call\Tools\Logger::write($e->getMessage(), 'errorCron.log');
}

function addStaticList($analysis,$userName,$callDate)
{
    $callDateString = $callDate->format('Y-m-d\TH:i:s');
    
    CRest::call(
        'crm.item.add',
        [
            'entityTypeId' => 1058,
            'fields' => [
                'ufCrm11Manager' => $userName,
                'ufCrm11CallDatetime' => $callDateString,
                'ufCrm11EmployeeIntroduced' => $analysis['introduction'],
                'ufCrm11Farewell' => $analysis['farewell'],
                'ufCrm11Greeting' => $analysis['greeting'],
                'ufCrm11Interruption' => $analysis['no_interruptions'],
                'ufCrm11NoMonosyllabicAnswers' => $analysis['detailed_answers'],
                'ufCrm11Politeness' => $analysis['politeness'],
            ],

        ]
    );
}

function getUserID($callId): array|string
{
    $callInfo = CRest::call(
        'voximplant.statistic.get',
        [
            'FILTER' => ['EXTERNAL_CALL_ID' => $callId],
            'LIMIT' => 1,
        ]
    );

    if (!$userId = $callInfo['result']['0']['PORTAL_USER_ID']) {
        return ['error' => 'Не удалось найти звонок или пользователя'];
    }

    return $userId;
}