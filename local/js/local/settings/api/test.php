 <?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;

Loader::includeModule('iblock');

 $sLang = 'ru';

$sA = str_replace(" ", "", 'CrealityHalotSky');

$sCode = preg_replace("#[[:punct:]]#", "", $sA);

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

            var_dump($arFileCfg);