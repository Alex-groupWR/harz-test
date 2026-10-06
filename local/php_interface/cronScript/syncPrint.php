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

use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock')) {
    die("Модуль инфоблоков не подключен");
}

$sourceIblockIds = [71, 72]; // ИБ с разделами
$sourceIblockIdsType2 = [73, 74]; // ИБ с разделами
$targetIblockId = 69; // ИБ с элементами

// Получаем существующие названия ЭЛЕМЕНТОВ в целевом инфоблоке
$existingNames = [];
$targetIterator = \Bitrix\Iblock\ElementTable::getList([
    'select' => ['NAME'],
    'filter' => ['IBLOCK_ID' => $targetIblockId]
]);
while ($item = $targetIterator->fetch()) {
    $existingNames[mb_strtolower(trim($item['NAME']))] = true;
}

$el = new CIBlockElement;
$addedCount = 0;
$skippedCount = 0;

foreach ($sourceIblockIds as $sourceIblockId) {
    
    // Получаем разделы из исходного инфоблока
    $sourceSections = \Bitrix\Iblock\SectionTable::getList([
        'select' => ['ID', 'NAME', 'DESCRIPTION', 'CODE', 'SORT'],
        'filter' => [
            'IBLOCK_ID' => $sourceIblockId,
            'ACTIVE' => 'Y',
            '!NAME' => false // исключаем пустые названия
        ],
        'order' => ['NAME' => 'ASC']
    ]);

    while ($section = $sourceSections->fetch()) {
        $name = trim($section['NAME']);

		if ($name == 'ru' || $name == 'en') {
            continue;
        }

        if (empty($name)) {
            $skippedCount++;
            continue;
        }

        $lowerName = mb_strtolower($name);

        // Проверяем, есть ли уже элемент с таким названием в целевом инфоблоке
        if (!isset($existingNames[$lowerName])) {
            // Подготовка полей для создания элемента
            $fields = [
                "IBLOCK_ID" => $targetIblockId,
                "NAME" => $name,
                "ACTIVE" => "Y",
                "CODE" => !empty($section['CODE']) ? $section['CODE'] :
                    CUtil::translit($name, "ru", ["replace_space" => "-", "replace_other" => "-"]),
                "SORT" => $section['SORT'] ?? 500,
                "PREVIEW_TEXT" => $section['DESCRIPTION'] ?? '',
                "PREVIEW_TEXT_TYPE" => 'html',
            ];

            // Добавляем элемент
            if ($newId = $el->Add($fields)) {
                $existingNames[$lowerName] = true;
                $addedCount++;
            } else {
                echo "✗ Ошибка добавления элемента '{$name}': " . $el->LAST_ERROR . "<br>\n";
            }
        } else {
            $skippedCount++;
            // echo "⏭ Пропущен (элемент уже существует): {$name}<br>\n";
        }

        // Для предотвращения таймаута при большом количестве разделов
        if ($addedCount % 50 == 0) {
            flush();
        }
    }
}


foreach ($sourceIblockIdsType2 as $sourceIblockId) {

    $sourceIterator = \Bitrix\Iblock\ElementTable::getList([
        'select' => ['NAME'],
        'filter' => ['IBLOCK_ID' => $sourceIblockId, 'ACTIVE' => 'Y'],
        'group'  => ['NAME'],
    ]);

    while ($sourceItem = $sourceIterator->fetch()) {
        $name = $sourceItem['NAME'];
        $lowerName = mb_strtolower($name);

        if (!isset($existingNames[$lowerName])) {
            $fields = [
                "IBLOCK_ID"      => $targetIblockId,
                "NAME"           => $name,
                "ACTIVE"         => "Y",
                "CODE"           => CUtil::translit($name, "ru", ["replace_space" => "-", "replace_other" => "-"]),
            ];

            if ($newId = $el->Add($fields)) {
                $existingNames[$lowerName] = true;
            }
        }
    }
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");