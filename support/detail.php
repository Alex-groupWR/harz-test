<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
//$APPLICATION->SetTitle("Поддержка - HARZ Labs");

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(SITE_TEMPLATE_PATH . "footer.php");

$arElement = CIBlockElement::GetList (
	Array("ID" => "ASC"),
	Array("IBLOCK_ID" => "43", "CODE" => $_REQUEST["ELEMENT_CODE"]),
	false,
	false,
	Array('PROPERTY_NAME_RU')
);

$sTitle = 'Поддержка - HARZ Labs';

if ($arItem = $arElement->GetNext()) {
	$sTitle = $arItem["PROPERTY_NAME_RU_VALUE"] . " - HARZ Labs";
}

$APPLICATION->SetPageProperty("title", $sTitle);
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:news.detail", 
	"support_detile_article", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_CODE" => $_REQUEST["ELEMENT_CODE"],
		"ELEMENT_ID" => $_REQUEST["ELEMENT_ID"],
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "DETAIL_TEXT",
			2 => "DETAIL_PICTURE",
			3 => "DATE_ACTIVE_FROM",
			4 => "ACTIVE_FROM",
			5 => "",
		),
		"IBLOCK_ID" => "43",
		"IBLOCK_TYPE" => "content",
		"IBLOCK_URL" => "",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Страница",
		"PROPERTY_CODE" => array(
			0 => "DETAIL_TEXT_RU",
			1 => "NAME_RU",
			2 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_CANONICAL_URL" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"STRICT_SECTION_CHECK" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_SHARE" => "N",
		"COMPONENT_TEMPLATE" => "support_detile_article"
	),
	false
);?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>