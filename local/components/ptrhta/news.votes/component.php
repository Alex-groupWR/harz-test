<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arResult["VOTES"] = [];

$arSelect = Array("ID", "NAME", "PROPERTY_YES_COUNTER", "PROPERTY_NO_COUNTER");
$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "ID" => $arParams["CURRENT_PAGE_ID"]);
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arResult["VOTES"] = $arFields;
}

$arResult["isManager"] = 0;
global $USER;
$curUserId = $USER->GetID();
$arGroups = CUser::GetUserGroup($curUserId);
foreach ($arGroups as $curUserGroups) {
    $rsGroup = CGroup::GetByID($curUserGroups);
    $arGroup = $rsGroup->Fetch();
    if ($arGroup["ID"] == 11) {
        $arResult["isManager"] = 1;
    }
}

$this->IncludeComponentTemplate();
