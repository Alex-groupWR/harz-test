<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/class/dadata.php");

use Dadata\CompanySuggestions;

$sVal = trim($_REQUEST['vat']);

if (empty($sVal)) {
    echo json_encode(["error" => "Не указан ИНН"]);
    die();
}

$dadata = new CompanySuggestions();
$arResult = $dadata->getCompanyByINN($sVal);

if ($arResult['status'] != 200 || empty($arResult['data']->suggestions)) {
    echo json_encode(["error" => "Компания не найдена"]);
    die();
}

$oCompany = $arResult['data']->suggestions[0]->data;

$arResponse = [
    "KPP" => $oCompany->kpp ?? '',
    "COMPANY_NAME" => $oCompany->name->full ?? $oCompany->name->short ?? '',
	//"FIO" => $oCompany->management->name ?? '',
    "ADDRESS" => $oCompany->address->unrestricted_value ?? ''
];

echo json_encode($arResponse);
die();