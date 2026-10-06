<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Дилеры - HARZ Labs");
$APPLICATION->SetPageProperty('header-text-color', 'header__wrapper--dark-text');

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

?>
<?
$APPLICATION->IncludeComponent(
	"bitrix:advertising.banner", 
	"banner_custaom2", 
	[
		"COMPONENT_TEMPLATE" => "banner_custaom2",
		"TYPE" => "REK",
		"NOINDEX" => "N",
		"QUANTITY" => "1",
		"DEFAULT_TEMPLATE" => "-",
		"BS_EFFECT" => "fade",
		"BS_CYCLING" => "N",
		"BS_WRAP" => "Y",
		"BS_KEYBOARD" => "Y",
		"BS_ARROW_NAV" => "Y",
		"BS_BULLET_NAV" => "Y",
		"BS_HIDE_FOR_TABLETS" => "N",
		"BS_HIDE_FOR_PHONES" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => ""
	],
	false
);?>
	<script src="https://unpkg.com/@googlemaps/markerclustererplus/dist/index.min.js"></script>

	<script
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChtunykUf13dUyK_1CTWK1YkzuVZTQcps&callback=initMap&libraries=&v=weekly"
			async>
	</script>

<?php $APPLICATION->IncludeComponent(
	"bitrix:news",
	"dealers",
	array(
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CATEGORY_CODE" => "CATEGORY",
		"CATEGORY_IBLOCK" => "",
		"CATEGORY_ITEMS_COUNT" => "5",
		"CHECK_DATES" => "Y",
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
			0 => "",
			1 => "",
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
		"FILTER_NAME" => "",
		"FILTER_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"FORUM_ID" => "1",
		"GROUP_PERMISSIONS" => array(
			0 => "1",
		),
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "46",
		"IBLOCK_TYPE" => "dealers",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array(
			0 => "SORT",
			1 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "SITE",
			1 => "ADDRESS",
			2 => "GOOGLE_MAP",
			3 => "FIO",
			4 => "PREVIEW_TEXT_RU",
			5 => "DETAIL_TEXT_RU",
			6 => "",
		),
		"MAX_VOTE" => "5",
		"MESSAGES_PER_PAGE" => "10",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "9999",
		"NUM_DAYS" => "30",
		"NUM_NEWS" => "999",
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
		"SEF_FOLDER" => "/news/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHARE_HANDLERS" => array(
			0 => "facebook",
			1 => "lj",
			2 => "twitter",
			3 => "delicious",
		),
		"SHARE_HIDE" => "Y",
		"SHARE_SHORTEN_URL_KEY" => "",
		"SHARE_SHORTEN_URL_LOGIN" => "",
		"SHARE_TEMPLATE" => "",
		"SHOW_404" => "N",
		"SHOW_LINK_TO_FORUM" => "Y",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "NAME",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "Y",
		"URL_TEMPLATES_READ" => "",
		"USE_CAPTCHA" => "Y",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"USE_PERMISSIONS" => "Y",
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
		"COMPONENT_TEMPLATE" => "dealers",
		"SEF_URL_TEMPLATES" => array(
			"news" => "/",
			"section" => "rss/",
			"detail" => "#ELEMENT_CODE#/",
		)
	),
	false
); ?>

	<!-- <script data-b24-form="inline/28/nbtie1" data-skip-moving="true">
		(function (w, d, u) {
			var s = d.createElement('script');
			s.async = true;
			s.src = u + '?' + (Date.now() / 180000 | 0);
			var h = d.getElementsByTagName('script')[0];
			h.parentNode.insertBefore(s, h);
		})(window, document, 'https://bx.harzlabs.ru/upload/crm/form/loader_28_nbtie1.js');
	</script> -->

	<!-- <div style="padding-bottom: 10rem;"></div> -->

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>