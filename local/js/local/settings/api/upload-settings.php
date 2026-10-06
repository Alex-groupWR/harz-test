<?php
define("NO_KEEP_STATISTIC", true);
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/vendor/autoload.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/js/local/settings/api/security.php');

checkAccess();

$config = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/settings-config.json'));

use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Loader;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Bitrix\Main\Page\Asset;

Loader::includeModule('iblock');

class MyReadFilter implements IReadFilter
{
    public function readCell($column, $row, $worksheetName = '')
    {
        // Read title row and rows 20 - 30
        if ($row >= 2 && $row <= 6000) {
            return true;
        }
        return false;
    }
}

$arRes = array(
    'del' => 0,
    'data' => array(),
    'err' => 0,
    'errors' => array(),
    'filter' => array(),
);

if (isset($_POST["FILE"]) && isset($_POST["LANGUAGE"]) && isset($_POST["SECTION"]) && isset($config) && !empty($config)) {
    $arFile = json_decode($_POST["FILE"], true);
    $reader = IOFactory::createReader("Xlsx");
    $reader->setReadDataOnly(true);
    $reader->setReadFilter(new MyReadFilter());
    $oClientsXlsx = IOFactory::load($arFile['target_file']);

    $sheetData = $oClientsXlsx->getActiveSheet()->toArray(null, true, true, true);

    //echo print_r($sheetData);

    if (is_array($sheetData) && !empty($sheetData)) {
        $sLanguage = $_POST["LANGUAGE"] == 'true' ? 'ru' : 'en';
        $sSection = $_POST["SECTION"];
        $arSec = $config->{$sSection};

        if ($arSec) {
            $arFilter = array(
                'IBLOCK_ID' => $arSec->{'IBLOCK_ID'},
                'SECTION_ID' => $arSec->{$sLanguage}
            );

            $arRes['filter'] = $arFilter;

            $db_list = CIBlockSection::GetList(array(), $arFilter, true);
            while ($ar_result = $db_list->GetNext()) {
                $arSectionIDs[] = $ar_result['ID'];
            }

            if ($arSectionIDs && !empty($arSectionIDs)) {
                $arEls = array();
                $arEls = ElementTable::GetList(
                    [
                        'select' => array("ID", "IBLOCK_ID"),
                        'filter' => array("IBLOCK_ID" => $arSec->{'IBLOCK_ID'}, "IBLOCK_SECTION_ID" => $arSectionIDs),
                    ]
                )->fetchAll();

                $arRes['elements'] = $arEls;
                $arRes['sections'] = $arSectionIDs;


//                foreach ($arEls as $el) {
//                    if ($el['IBLOCK_ID'] == $arSec->{'IBLOCK_ID'} && CIBlockElement::Delete($el["ID"])) {
//                        $arRes['del']++;
//                    } else if ($el['IBLOCK_ID'] == $iBlockID) {
//                        $arRes['err']++;
//                        array_push($arRes['errors'], "ERROR delete " . $el["ID"]);
//                    }
//                }
//
//                foreach ($arSectionIDs as $arSection) {
//                    CIBlockSection::Delete($arSection);
//                }
            }

            $arRes['data'] = array_slice($sheetData, 1);
        }
    }
}

echo json_encode($arRes);

