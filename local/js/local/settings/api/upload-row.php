<?php
define("NO_KEEP_STATISTIC", true);
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/js/local/settings/api/security.php');

checkAccess();

$config = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/settings-config.json'));

use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;

Loader::includeModule('iblock');

$arRes = array(
    'sections' => array()
);

if (isset($_POST["ROW"]) && isset($_POST["FILTER"]) && isset($config) && !empty($config)) {
    $arLine = json_decode($_POST["ROW"], true);
    $arUploadedSections = json_decode($_POST["SECTIONS"], true);
    $arSectionFilter = json_decode($_POST["FILTER"], true);
    $sLang = $_POST['LANGUAGE'];

    $sA = str_replace(" ", "", $arLine['A']);

    $sCode = preg_replace("#[[:punct:]]#", "", $sA);

    if (!isset($arUploadedSections[$sCode])) {
        $bs = new \CIBlockSection;
        if ($arLine['D'] || $arLine['E'] || $arLine['F'] || $arLine['G'] || $arLine['H']) {
            $arFileCfg = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/upload/configs/" . $sCode . ".cfg");
            if (!$arFileCfg) {
                $arFileCfg = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/upload/configs/" . $sCode . "-" . $sLang . ".7z");
            }

            if (!$arFileCfg) {
                $arFileCfg = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/upload/configs/" . $sCode . ".7z");
            }

            if (!$arFileCfg) {
                $arFileCfg = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/upload/configs/" . $sCode . ".cxcfg");
            }
            if (!$arFileCfg) {
                $arFileCfg = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/upload/configs/" . $sCode . ".cfgx");
            }
            $arFields = array(
                "ACTIVE" => 'Y',
                "IBLOCK_ID" => $arSectionFilter['IBLOCK_ID'],
                "NAME" => $arLine['A'],
                "SORT" => 500,
                "CODE" => $sCode,
                "IBLOCK_SECTION_ID" => $arSectionFilter['SECTION_ID'],
                "UF_CONF_FILE" => $arFileCfg
            );

            $ID = $bs->Add($arFields);
            unset($bs);

            $iElementSectionID = $ID;
            $arUploadedSections[$sCode] = $ID;
        }
    } else {
        $iElementSectionID = $arUploadedSections[$sCode];
    }

    $arRes['sections'] = $arUploadedSections;

    if (floatval($arLine['E']) == 0 && floatval($arLine['G']) == 0 && floatval($arLine['J']) == 0) {
        // echo $arLine['J']. ' - не добавлено <br>';
    } else {
        $el = new \CIBlockElement;
        $arProperties = [
            'BASE_LAYORTS' => floatval($arLine['D']),
            'T_50_ILLUMINATION' => $arLine['E'],
            'T_50_ILLUMINATION_FOOTER' => floatval($arLine['F']),
            'T_100_ILLUMINATION' => floatval($arLine['G']),
            'T_100_ILLUMINATION_FOOTER' => floatval($arLine['H']),
            'T_200_ILLUMINATION' => floatval($arLine['I']),
            'T_200_ILLUMINATION_FOOTER' => floatval($arLine['J']),
            'PAUSE_FOOTER' => floatval($arLine['K']),
            'TABLE_HEIGHT' => floatval($arLine['L']),
            'TABLE_UP' => floatval($arLine['M']),
            'TABLE_DOWN' => floatval($arLine['N']),
        ];

        $arLoadProductArray = array(
            "CREATED_BY" => 527, // БОТ
            "IBLOCK_SECTION_ID" => $iElementSectionID,
            "IBLOCK_ID" => $arSectionFilter['IBLOCK_ID'],
            "PROPERTY_VALUES" => $arProperties,
            "NAME" => $arLine['C'],
            "ACTIVE" => "Y",
        );

        $arRes['id'] = $el->Add($arLoadProductArray);

        $arRes['props'] = $arLoadProductArray;

    }

    sleep(0.2);
}




echo json_encode($arRes);

