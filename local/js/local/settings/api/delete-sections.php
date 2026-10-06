<?php
define("NO_KEEP_STATISTIC", true);
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/js/local/settings/api/security.php');

checkAccess();

$arRes = array(
    'del' => 0,
    'err' => 0,
    'errors' => array(),
);

if (isset($_POST["SECTIONS"])) {
    $arSectionIDs = json_decode($_POST["SECTIONS"], true);


    if (is_array($arSectionIDs) && !empty($arSectionIDs)) {

        foreach ($arSectionIDs as $arSection) {
            CIBlockSection::Delete($arSection);
        }
    }
}

sleep(0.3);

echo json_encode($arRes);

