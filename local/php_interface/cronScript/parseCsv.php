<?php

$_SERVER["DOCUMENT_ROOT"] = '/var/www/vhosts/harzlabs.ru/httpdocs';

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define('BX_NO_ACCELERATOR_RESET', true);
define('BX_CRONTAB', true);
define('STOP_STATISTICS', true);
define('NO_AGENT_STATISTIC', 'Y');
define('DisableEventsCheck', true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

@set_time_limit(0);
@ignore_user_abort(true);

// ID инфоблока, который нужно обновить
$iblockId = 71; // совместимые с актуал 1
$parentSectionId = 5211; // совместимые с актуал 1
//$iblockId = 72; // частично совместимые с актуал 0
//$parentSectionId = 5213; // частично совместимые с актуал 0

// Функция для парсинга таблицы (предполагаем CSV формат или массив)
function parseSettingsTable($filePath) {
    $settings = [];

    // Здесь реализуйте парсинг вашей таблицы
    // Например, для CSV:
    if (($handle = fopen($filePath, "r")) !== FALSE) {
        $headers = fgetcsv($handle, 4000, ",", '"'); // Табуляция как разделитель

        while (($data = fgetcsv($handle, 4000, ",", '"')) !== FALSE) {
            $row = array_combine($headers, $data);

            $settings[] = [
                'SECTION_CODE' => $row['Code'],
                'MATERIAL_NAME' => $row['Матреиал'],
                'BASE_LAYERS' => $row['Количество базовых слоев, шт'],
                'EXPOSURE_50' => $row['Время засветки 50мкм, с'],
                'BOTTOM_EXPOSURE_50' => $row['Время засветки низа 50мкм, с'],
                'EXPOSURE_100' => $row['Время засветки 100мкм, с'],
                'BOTTOM_EXPOSURE_100' => $row['Время засветки низа 100мкм, с'],
                'EXPOSURE_200' => $row['Время засветки 200мкм, с'],
                'BOTTOM_EXPOSURE_200' => $row['Время засветки низа 200мкм, с'],
                'PAUSE' => $row['Пауза в нижнем положении, с'],
                'LIFT_HEIGHT' => $row['Выоста подъема столика, мм'],
                'LIFT_SPEED' => $row['Скорость подъема столика, мм/мин'],
                'RETRACT_SPEED' => $row['Скорость опускания столика, мм/мин'],
            ];
        }
        fclose($handle);
    }

    return $settings;
}

// Функция для получения или создания раздела
function getOrCreateSection($iblockId, $sectionCode, $sectionName = '', $parentSectionId) {
    CModule::IncludeModule('iblock');

    // Пытаемся найти существующий раздел
    $section = CIBlockSection::GetList(
        [],
        [
            'IBLOCK_ID' => $iblockId,
            'CODE' => $sectionCode,
            'SECTION_ID' => $parentSectionId,
        ],
        false,
        ['ID', 'NAME', 'CODE'],
        false
    )->Fetch();

    if ($section) {
        return $section['ID'];
    }

    // Если раздел не найден - создаем его
    $bs = new CIBlockSection;

    // Если имя не передано, используем код как имя
    if (empty($sectionName)) {
        $sectionName = $sectionCode;
    }

    $sectionFields = [
        "IBLOCK_ID" => $iblockId,
        "IBLOCK_SECTION_ID" => $parentSectionId,
        "NAME" => $sectionName,
        "CODE" => $sectionCode,
        "ACTIVE" => "Y",
        "SORT" => 500,
    ];

    $sectionId = $bs->Add($sectionFields);

    if ($sectionId) {
        echo "Создан новый раздел: {$sectionName} (ID: {$sectionId})<br>";
        return $sectionId;
    } else {
        echo "Ошибка создания раздела '{$sectionName}': " . $bs->LAST_ERROR . "<br>";
        return false;
    }
}

// Функция для получения или создания элемента
function getOrCreateElement($iblockId, $sectionId, $elementName) {
    CModule::IncludeModule('iblock');

    // Пытаемся найти существующий элемент
    $res = CIBlockElement::GetList(
        [],
        [
            'IBLOCK_ID' => $iblockId,
            'IBLOCK_SECTION_ID' => $sectionId,
            'INCLUDE_SUBSECTIONS' => 'N',
            'NAME' => $elementName
        ],
        false,
        false,
        ['ID', 'NAME']
    );

    if ($element = $res->Fetch()) {
        return $element['ID'];
    }

    // Если элемент не найден - создаем его
    $el = new CIBlockElement;

    $elementFields = [
        "IBLOCK_ID" => $iblockId,
        "NAME" => $elementName,
        "CODE" => CUtil::translit($elementName, "ru"),
        "IBLOCK_SECTION_ID" => $sectionId,
        "ACTIVE" => "Y",
        "PREVIEW_TEXT" => "",
        "DETAIL_TEXT" => "",
    ];

    $elementId = $el->Add($elementFields);

    if ($elementId) {
        echo "Создан новый элемент: {$elementName} (ID: {$elementId})<br>";
        return $elementId;
    } else {
        echo "Ошибка создания элемента '{$elementName}': " . $el->LAST_ERROR . "<br>";
        return false;
    }
}

// Функция для получения всех существующих элементов
function getAllExistingElements($iblockId, $parentSectionId) {
    CModule::IncludeModule('iblock');

    $existingElements = [];

    $res = CIBlockElement::GetList(
        [],
        [
            'IBLOCK_ID' => $iblockId,
            'SECTION_ID' => $parentSectionId,
            'INCLUDE_SUBSECTIONS' => 'Y',
            'CHECK_PERMISSIONS' => 'N'
        ],
        false,
        false,
        ['ID', 'NAME', 'IBLOCK_SECTION_ID']
    );

    while ($element = $res->Fetch()) {
        // Получаем код раздела элемента
        $sectionRes = CIBlockSection::GetList(
            [],
            ['ID' => $element['IBLOCK_SECTION_ID']],
            false,
            ['ID', 'CODE']
        );

        if ($section = $sectionRes->Fetch()) {
            $existingElements[$section['CODE'] . '_' . $element['NAME']] = [
                'ID' => $element['ID'],
                'NAME' => $element['NAME'],
                'SECTION_CODE' => $section['CODE']
            ];
        }
    }

    return $existingElements;
}

// Функция для удаления элементов
function deleteElements($elementIds) {
    CModule::IncludeModule('iblock');

    $deletedCount = 0;
    $errorCount = 0;

    foreach ($elementIds as $elementId) {
        if (CIBlockElement::Delete($elementId)) {
            echo "Удален элемент ID: {$elementId}<br>";
            $deletedCount++;
        } else {
            echo "Ошибка удаления элемента ID: {$elementId}<br>";
            $errorCount++;
        }
    }

    return ['deleted' => $deletedCount, 'errors' => $errorCount];
}

// Функция поиска и обновления элементов с удалением отсутствующих
function updateMaterialsBySettings($iblockId, $settings, $parentSectionId) {
    CModule::IncludeModule('iblock');

    $updatedCount = 0;
    $createdCount = 0;
    $errorCount = 0;

    // Массив для отслеживания обработанных элементов
    $processedElements = [];

    // Получаем все существующие элементы
    $existingElements = getAllExistingElements($iblockId, $parentSectionId);

    foreach ($settings as $setting) {
        // Получаем или создаем раздел
        $sectionId = getOrCreateSection($iblockId, $setting['SECTION_CODE'], $setting['SECTION_CODE'], $parentSectionId);

        if (!$sectionId) {
            echo "Не удалось получить или создать раздел '{$setting['SECTION_CODE']}'<br>";
            $errorCount++;
            continue;
        }

        // Получаем или создаем элемент
        $elementId = getOrCreateElement($iblockId, $sectionId, $setting['MATERIAL_NAME']);

        if (!$elementId) {
            echo "Не удалось получить или создать элемент '{$setting['MATERIAL_NAME']}'<br>";
            $errorCount++;
            continue;
        }

        // Отмечаем элемент как обработанный
        $elementKey = $setting['SECTION_CODE'] . '_' . $setting['MATERIAL_NAME'];
        $processedElements[$elementKey] = true;

        // Определяем, был ли элемент создан только что или уже существовал
        $wasCreated = false;

        // Проверяем, есть ли у элемента свойства
        $res = CIBlockElement::GetProperty($iblockId, $elementId);
        $hasProperties = false;
        while ($prop = $res->Fetch()) {
            $hasProperties = true;
            break;
        }

        // Если элемент только что создан и у него нет свойств, считаем его новым
        if (!$hasProperties) {
            $wasCreated = true;
        }

        // Обновляем свойства элемента
        $el = new CIBlockElement;

        $updateFields = [
            'PROPERTY_VALUES' => [
                'BASE_LAYORTS' => !empty($setting['BASE_LAYERS']) ? $setting['BASE_LAYERS'] : "0",
                'T_50_ILLUMINATION' => !empty($setting['EXPOSURE_50']) ? $setting['EXPOSURE_50'] : "0",
                'T_50_ILLUMINATION_FOOTER' => !empty($setting['BOTTOM_EXPOSURE_50']) ? $setting['BOTTOM_EXPOSURE_50'] : "0",
                'T_100_ILLUMINATION' => !empty($setting['EXPOSURE_100']) ? $setting['EXPOSURE_100'] : "0",
                'T_100_ILLUMINATION_FOOTER' => !empty($setting['BOTTOM_EXPOSURE_100']) ? $setting['BOTTOM_EXPOSURE_100'] : "0",
                'T_200_ILLUMINATION' => !empty($setting['EXPOSURE_200']) ? $setting['EXPOSURE_200'] : "0",
                'T_200_ILLUMINATION_FOOTER' => !empty($setting['BOTTOM_EXPOSURE_200']) ? $setting['BOTTOM_EXPOSURE_200'] : "0",
                'PAUSE_FOOTER' => !empty($setting['PAUSE']) ? $setting['PAUSE'] : "0",
                'TABLE_HEIGHT' => !empty($setting['LIFT_HEIGHT']) ? $setting['LIFT_HEIGHT'] : "0",
                'TABLE_UP' => !empty($setting['LIFT_SPEED']) ? $setting['LIFT_SPEED'] : "0",
                'TABLE_DOWN' => !empty($setting['RETRACT_SPEED']) ? $setting['RETRACT_SPEED'] : "0",
            ]
        ];

        if ($el->Update($elementId, $updateFields)) {
            if ($wasCreated) {
                echo "Создан и заполнен элемент ID: {$elementId} - {$setting['MATERIAL_NAME']} в разделе {$setting['SECTION_CODE']}<br>";
                $createdCount++;
            } else {
                echo "Обновлен элемент ID: {$elementId} - {$setting['MATERIAL_NAME']} в разделе {$setting['SECTION_CODE']}<br>";
                $updatedCount++;
            }
        } else {
            echo "Ошибка обновления элемента ID: {$elementId} - {$el->LAST_ERROR}<br>";
            $errorCount++;
        }
    }

    // Находим элементы для удаления (которые есть в БД, но нет в файле)
    $elementsToDelete = [];
    foreach ($existingElements as $key => $element) {
        if (!isset($processedElements[$key])) {
            $elementsToDelete[] = $element['ID'];
            echo "Найден элемент для удаления: {$element['NAME']} (ID: {$element['ID']}) из раздела {$element['SECTION_CODE']}<br>";
        }
    }

    // Удаляем найденные элементы
    $deletionResult = ['deleted' => 0, 'errors' => 0];
    if (!empty($elementsToDelete)) {
        echo "<br>Начинаю удаление элементов...<br>";
        $deletionResult = deleteElements($elementsToDelete);
    } else {
        echo "<br>Нет элементов для удаления.<br>";
    }

    echo "<br>Итог:<br>";
    echo "Обновлено существующих элементов: {$updatedCount}<br>";
    echo "Создано новых элементов: {$createdCount}<br>";
    echo "Удалено элементов: {$deletionResult['deleted']}<br>";
    echo "Ошибок при удалении: {$deletionResult['errors']}<br>";
    echo "Ошибок при обновлении/создании: {$errorCount}<br>";

    return [
        'updated' => $updatedCount,
        'created' => $createdCount,
        'deleted' => $deletionResult['deleted'],
        'errors' => $errorCount + $deletionResult['errors']
    ];
}

// Основной скрипт
try {
    // Путь к вашему файлу с настройками
    $settingsFile = $_SERVER['DOCUMENT_ROOT'].'/upload/settings.csv';

    // Проверяем существование файла
    if (!file_exists($settingsFile)) {
        die("Файл настроек не найден: {$settingsFile}");
    }

    // Парсим таблицу
    $settings = parseSettingsTable($settingsFile);

    if (empty($settings)) {
        die("Не удалось загрузить настройки из файла");
    }

    echo "Загружено настроек: " . count($settings) . "<br><br>";

    // Обновляем элементы
    $result = updateMaterialsBySettings($iblockId, $settings, $parentSectionId);

} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>