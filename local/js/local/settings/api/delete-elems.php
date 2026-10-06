<?php
define("NO_KEEP_STATISTIC", true);
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/js/local/settings/api/security.php');

checkAccess();

use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Loader;

$arRes = array(
    'del' => 0,
    'err' => 0,
    'errors' => array(),
);

if (isset($_POST["ELEMENTS"])) {
    $arEls = json_decode($_POST["ELEMENTS"], true);


    if (is_array($arEls) && !empty($arEls)) {

        foreach ($arEls as $el) {
            if (CIBlockElement::Delete($el["ID"])) {
                $arRes['del']++;
            } else  {
                $arRes['err']++;
                array_push($arRes['errors'], "ERROR delete " . $el["ID"]);
            }
        }
    }
}

sleep(0.5);

echo json_encode($arRes);

