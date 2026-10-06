<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once ('./functions.php');

// Доменное имя
$domainName = 'https://harzlabs.com';

// Временная директория для хранения
$tempDirectory = $_SERVER['DOCUMENT_ROOT'].'/upload/temp_convert';

// Директория для хранения хеш сумм изображений
$hashSumDirectory = $_SERVER['DOCUMENT_ROOT'].'/upload/hash_sum_image_convert';

// Инфоблок для конвертации
$iblockId = 7;

// Список свойств для конвертации
$convertProperties = [
    'PREVIEW_PICTURE',
    'DETAIL_PICTURE',
];
// Список свойств для сохранения сконвертированных изображений
$convertPropertiesToSave = [
    'PREVIEW_PICTURE_COMPRESS',
    //'DETAIL_PICTURE_COMPRESS',
];

pre('Конвертация изображений в формат webp');

// Подключаем инфоблоки
if(!\Bitrix\Main\Loader::includeModule('iblock')){
    pre('Ошибка подключения модуля инфоблоков','red');
    die();
}

// Проверка директории для временных файлов
if(!check_dir($tempDirectory)){
    pre('Ошибка создания директории для временных файлов','red');
    die();
}

// Проверка директории для хеш сумм
if(!check_dir($hashSumDirectory)){
    pre('Ошибка создания директории для хеш сумм','red');
    die();
}


// Получаем список элементов инфоблока
$arSelect = array_merge(["ID", "NAME"],$convertProperties);
$arFilter = Array("IBLOCK_ID"=>$iblockId, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");

$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>100), $arSelect);

$arElementsToConvert = [];

while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();

    $arElementToConvert = [
        'ID' => $arFields['ID'],
        'IMAGES' => [],
    ];

    foreach ($convertProperties as $i=>$convertProperty)
    {
        if($arFields[$convertProperty])
        {
            // Получаем путь до изображения
            if($filePath = CFile::GetPath($arFields[$convertProperty])) {

                $arElementToConvert['IMAGES'][] = [
                    'ID' => $arFields[$convertProperty],
                    'PATH' => $domainName . $filePath,
                    'PATH_HASH' => $hashSumDirectory.'/'.md5($filePath).'.md5',
                    'PROPERTY_NAME' => $convertProperty,
                    'CONVERT_PROPERTY_NAME' => $convertPropertiesToSave[$i],
                ];


            }
        }
    }
    $arElementsToConvert[] = $arElementToConvert;
}

// Перебераем все элементы
foreach ($arElementsToConvert as $arElementToConvert)
{

    // Перебераем все изображения в нем
    foreach ($arElementToConvert['IMAGES'] as $image) {

        // Проверяем наличие хеш суммы начального изображения
        if (is_file($image['PATH_HASH'])) {
           continue;
        }

        // Получаем изображение
        $imageConvert = new IblockImageConvert([
            'src' => $image['PATH'],
            'type' => 'png',
            'tmpDir' => $tempDirectory
        ]);

        $imageConvert->convertToWebP();

        // Создаем массив понятный для битрикса
        $arSrcConvert = CFile::MakeFileArray($imageConvert->srcConverted);


        if($arSrcConvert['size'] > 0) {
            pre($image['ID']);
            pre($image['CONVERT_PROPERTY_NAME']);
            pre($arSrcConvert);
            // Сохраняем в инфоблок
            var_dump(CIBlockElement::SetPropertyValueCode(
                $arElementToConvert['ID'],
                $image['CONVERT_PROPERTY_NAME'],
                $arSrcConvert));
            echo '--------';
            make_file_hash($image['PATH'],$image['PATH_HASH']);

        }
    }

}