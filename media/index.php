<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("News");

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/style/company.css");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/company.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/slick/slick.js");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/slick/slick.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/slick/slick-theme.css");


Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/new.js");
$sTitle = 'СМИ о нас - HARZ Labs';

$sPath = (explode ('/', $_SERVER['REQUEST_URI']));

if (isset($sPath[3]) && $sPath[3] !== '') {
	$arElement = CIBlockElement::GetList (
		Array("ID" => "ASC"),
		Array("IBLOCK_ID" => "58", "CODE" => $sPath[3]),
		false,
		false,
		Array('PROPERTY_NAME_RU')
	);

	if ($arItem = $arElement->GetNext()) {
		if (isset($arItem["PROPERTY_NAME_RU_VALUE"])) {
			$sTitle = $arItem["PROPERTY_NAME_RU_VALUE"] . " - HARZ Labs";
		}
	}
}

$APPLICATION->SetPageProperty("title", $sTitle);
?><div class="container">
 <?$arNewsFilter = ["!PROPERTY_HIDE_RU_VALUE"   =>   'Y']; ?>
	 <?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"media", 
	array(
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CATEGORY_CODE" => "CATEGORY",
		"CATEGORY_IBLOCK" => array(
		),
		"CATEGORY_ITEMS_COUNT" => "5",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "new_news",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "Y",
		"DETAIL_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "PREVIEW_TEXT_RU",
			1 => "DETAIL_TEXT_RU",
			2 => "",
		),
		"DETAIL_SET_CANONICAL_URL" => "Y",
		"DISPLAY_AS_RATING" => "rating",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"FILE_404" => "",
		"FILTER_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "arNewsFilter",
		"FILTER_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"FORUM_ID" => "1",
		"GROUP_PERMISSIONS" => array(
			0 => "1",
		),
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
		"IBLOCK_ID" => "58",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"LIST_ACTIVE_DATE_FORMAT" => "j M Y",
		"LIST_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "PREVIEW_TEXT_RU",
			1 => "DETAIL_TEXT_RU",
			2 => "",
		),
		"MAX_VOTE" => "5",
		"MESSAGES_PER_PAGE" => "10",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "999",
		"NUM_DAYS" => "30",
		"NUM_NEWS" => "20",
		"PAGER_BASE_LINK" => "",
		"PAGER_BASE_LINK_ENABLE" => "Y",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_PARAMS_NAME" => "arrPager",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Новости",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"POST_FIRST_MESSAGE" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"REVIEW_AJAX_POST" => "Y",
		"SEF_FOLDER" => "/media/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHARE_HANDLERS" => array(
			0 => "twitter",
			1 => "delicious",
			2 => "lj",
			3 => "facebook",
		),
		"SHARE_HIDE" => "Y",
		"SHARE_SHORTEN_URL_KEY" => "",
		"SHARE_SHORTEN_URL_LOGIN" => "",
		"SHARE_TEMPLATE" => "",
		"SHOW_404" => "N",
		"SHOW_LINK_TO_FORUM" => "Y",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "Y",
		"URL_TEMPLATES_READ" => "",
		"USE_CAPTCHA" => "Y",
		"USE_CATEGORIES" => "Y",
		"USE_FILTER" => "Y",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_REVIEW" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "Y",
		"VOTE_NAMES" => array(
			0 => "0",
			1 => "1",
			2 => "2",
			3 => "3",
			4 => "4",
			5 => "",
		),
		"YANDEX" => "Y",
		"SEF_URL_TEMPLATES" => array(
			"news" => "/media/",
			"section" => "#SECTION_CODE#/",
			"detail" => "#SECTION_CODE#/#ELEMENT_CODE#/",
		)
	),
	false
);?>
</div>
<? //$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/footer.php", Array(), Array("MODE" => "php")); ?>
<? //$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/popup_items.php", Array(), Array("MODE" => "php")); ?>
<? //$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/modals.php", Array(), Array("MODE" => "php")); ?><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>