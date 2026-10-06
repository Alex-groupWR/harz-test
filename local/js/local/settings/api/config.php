
<?php
define("NO_KEEP_STATISTIC", true);
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

global $USER;
if (!$USER->IsAuthorized()) {
    http_response_code(401);
    die(json_encode(['error' => 'Authentication required']));
}

$iCurrentUser = $USER->GetID();
$iAccess = $USER->IsAdmin() || $iCurrentUser == 41;

if (!$iAccess) {
    http_response_code(403);
    die(json_encode(['error' => 'Access denied']));
}

$target_dir = $_SERVER["DOCUMENT_ROOT"] . "/upload/configs/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);

$arFileName = explode('.', $_FILES["file"]["name"]);
$sFileName = $arFileName[0];

$sLang = '';
$arFilter = array(
    'CODE' => explode('.', $_FILES["file"]["name"])
);

if (str_contains($sFileName, '-ru')) {
    $arFilter['CODE'] =  explode('-ru', $sFileName);
    $sLang = 'ru';
} else if (str_contains($sFileName, '-en')) {
    $arFilter['CODE'] =  explode('-en', $sFileName);
    $sLang = 'en';
}

$arFileCfg = CFile::MakeFileArray($target_file);

$arSectionIDs = array();
$db_list = CIBlockSection::GetList(array(), $arFilter, true);
while ($arSection = $db_list->GetNext()) {
    $bAdd = false;

    if ($sLang) {
       $oParentSection = CIBlockSection::GetByID($arSection['IBLOCK_SECTION_ID']);

        if ($arParentSection = $oParentSection->GetNext()) {
            if ($arParentSection['NAME'] == $sLang) {
                $bAdd = true;
            }
        }
    } else {
        $bAdd = true;
    }

    if ($bAdd) {
        $arSectionIDs[] = $arSection['ID'];
        $bs = new \CIBlockSection;
        $arFields = array(
            "UF_CONF_FILE" => $arFileCfg
        );
        $bs->Update($arSection['ID'], $arFields);
    }
}

$arUpload = array(
    'files' => $_FILES,
    'is_upload' => move_uploaded_file($_FILES["file"]["tmp_name"], $target_file),
    'target_file' => $target_file,
    'sections' => $arSectionIDs
);

echo json_encode($arUpload);
?>