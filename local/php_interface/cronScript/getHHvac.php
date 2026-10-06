<?php
$_SERVER["DOCUMENT_ROOT"] = '/var/www/vhosts/harzlabs.ru/httpdocs';
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];


define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define('BX_NO_ACCELERATOR_RESET', true);
define('BX_CRONTAB', true);
define('STOP_STATISTICS', true);
define('NO_AGENT_STATISTIC', 'Y');
define('DisableEventsCheck', true);


function logError($message, $context = []) {
    $logFile = __DIR__ . '/hh_sync.log';
    $log = sprintf(
        "[%s] ERROR: %s\nContext: %s\n---\n",
        date('Y-m-d H:i:s'),
        $message,
        print_r($context, true)
    );
    file_put_contents($logFile, $log, FILE_APPEND | LOCK_EX);
}

try {
    try {
        require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
    } catch (Exception $e) {
        throw new Exception("Ошибка загрузки Битрикс: " . $e->getMessage());
    }

    @set_time_limit(0);
    @ignore_user_abort(true);

    // Получение данных с API
    try {
        $url = 'https://api.hh.ru/vacancies?employer_id=3988126';
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception("cURL error: " . curl_error($ch));
        }

        curl_close($ch);

        // Парсинг JSON
        $data = json_decode($response, true);
        if (!$data || !isset($data['items'])) {
            throw new Exception("Некорректный ответ от API");
        }

        $ids = array_column($data['items'], 'id');
        $vacancies = array_column($data['items'], null, 'id');

    } catch (Exception $e) {
        throw new Exception("Ошибка API HH: " . $e->getMessage());
    }

    // Загрузка модуля Битрикс
    if (!\Bitrix\Main\Loader::includeModule('iblock')) {
        throw new Exception("Модуль iblock не доступен");
    }

    // Получение существующих вакансий
    try {
        $res = CIBlockElement::GetList(
            ["SORT" => "ASC"],
            ["IBLOCK_ID" => 44, "ACTIVE" => "Y"],
            false,
            false,
            ["ID", "PROPERTY_HH_ID"]
        );

        $existingElements = [];
        while ($ob = $res->GetNextElement()) {
            $fields = $ob->GetFields();
            $existingElements[$fields['PROPERTY_HH_ID_VALUE']] = $fields['ID'];
        }
    } catch (Exception $e) {
        throw new Exception("Ошибка получения элементов: " . $e->getMessage());
    }

    // Обновление и удаление элементов
    foreach ($existingElements as $hhId => $elementId) {
        try {
            if (in_array($hhId, $ids)) {
                // Обновление
                $el = new CIBlockElement;
                $el->Update($elementId, ["NAME" => $vacancies[$hhId]['name']]);
                CIBlockElement::SetPropertyValuesEx($elementId, 44, [
                    'HH_ID' => $hhId,
                    'LINK' => $vacancies[$hhId]['alternate_url']
                ]);
            } else {
                // Удаление
                CIBlockElement::Delete($elementId);
            }
        } catch (Exception $e) {
            logError("Ошибка обработки элемента {$elementId}", [
                'hh_id' => $hhId,
                'error' => $e->getMessage()
            ]);
        }
    }

    // Создание новых элементов
    $newIds = array_diff($ids, array_keys($existingElements));
    foreach ($newIds as $hhId) {
        try {
            $el = new CIBlockElement;
            $el->Add([
                "IBLOCK_ID" => 44,
                "NAME" => $vacancies[$hhId]['name'],
                "ACTIVE" => "Y",
                "PROPERTY_VALUES" => [
                    "HH_ID" => $hhId,
                    "LINK" => $vacancies[$hhId]['url']
                ]
            ]);
        } catch (Exception $e) {
            logError("Ошибка создания элемента для HH_ID: {$hhId}", [
                'error' => $e->getMessage()
            ]);
        }
    }

    echo "Синхронизация завершена успешно\n";

} catch (Exception $e) {
    logError("Критическая ошибка синхронизации", [
        'error' => $e->getMessage(),
    ]);
    echo "Произошла ошибка. Подробности в лог-файле.\n";
    exit(1);
}