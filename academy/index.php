<?php require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION->SetTitle('Академия HARZ labs');
$APPLICATION->SetPageProperty('title', '');
$APPLICATION->SetPageProperty('description', '');

?>
	<div class="container">

		<div class="page-section text-page support-page">
			<div class="left-sidenav-text-page">
				<ul class="nav flex-column">
					<li class="nav-item">
						<a class="nav-link" href="#ourProducts">Онлайн мероприятия</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#afterWork">Оффлайн мероприятия</a>
					</li>

				</ul>
			</div>

			<div class="main right-col">
				<div class="support-block">
					<div id="instructions"></div>
					<div class="section-instructions">
						<div class="service-container">
							<div class="service-item" id="ourProducts">
								<?
								$APPLICATION->IncludeComponent(
									"bitrix:catalog.section",
									"academy_article_list",
									array(
										"ACTION_VARIABLE" => "action",
										"ADD_PICT_PROP" => "-",
										"ADD_PROPERTIES_TO_BASKET" => "Y",
										"ADD_SECTIONS_CHAIN" => "N",
										"ADD_TO_BASKET_ACTION" => "ADD",
										"AJAX_MODE" => "N",
										"AJAX_OPTION_ADDITIONAL" => "",
										"AJAX_OPTION_HISTORY" => "N",
										"AJAX_OPTION_JUMP" => "N",
										"AJAX_OPTION_STYLE" => "N",
										"BACKGROUND_IMAGE" => "UF_BACKGROUND_IMAGE",
										"BASKET_URL" => "/personal/basket.php",
										"BRAND_PROPERTY" => "-",
										"BROWSER_TITLE" => "-",
										"CACHE_FILTER" => "N",
										"CACHE_GROUPS" => "N",
										"CACHE_TIME" => "36000000",
										"CACHE_TYPE" => "A",
										"COMPATIBLE_MODE" => "Y",
										"CONVERT_CURRENCY" => "Y",
										"CURRENCY_ID" => "RUB",
										"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
										"DATA_LAYER_NAME" => "dataLayer",
										"DETAIL_URL" => "",
										"DISABLE_INIT_JS_IN_COMPONENT" => "N",
										"DISCOUNT_PERCENT_POSITION" => "bottom-right",
										"DISPLAY_BOTTOM_PAGER" => "Y",
										"DISPLAY_COMPARE" => "N",
										"DISPLAY_TOP_PAGER" => "N",
										"ELEMENT_SORT_FIELD" => "sort",
										"ELEMENT_SORT_FIELD2" => "id",
										"ELEMENT_SORT_ORDER" => "asc",
										"ELEMENT_SORT_ORDER2" => "desc",
										"ENLARGE_PRODUCT" => "PROP",
										"ENLARGE_PROP" => "-",
										"FILTER_NAME" => "arrFilter",
										"HIDE_NOT_AVAILABLE" => "N",
										"HIDE_NOT_AVAILABLE_OFFERS" => "N",
										"IBLOCK_ID" => ID_IB_ACADEMY,
										"IBLOCK_TYPE" => "content",
										"INCLUDE_SUBSECTIONS" => "Y",
										"LABEL_PROP" => array(),
										"LABEL_PROP_MOBILE" => "",
										"LABEL_PROP_POSITION" => "top-left",
										"LAZY_LOAD" => "Y",
										"LINE_ELEMENT_COUNT" => "3",
										"LOAD_ON_SCROLL" => "N",
										"MESSAGE_404" => "",
										"MESS_BTN_ADD_TO_BASKET" => "В корзину",
										"MESS_BTN_BUY" => "Купить",
										"MESS_BTN_DETAIL" => "Подробнее",
										"MESS_BTN_LAZY_LOAD" => "Показать ещё",
										"MESS_BTN_SUBSCRIBE" => "Подписаться",
										"MESS_NOT_AVAILABLE" => "Нет в наличии",
										"META_DESCRIPTION" => "-",
										"META_KEYWORDS" => "-",
										"OFFERS_CART_PROPERTIES" => array(
											0 => "ARTNUMBER",
											1 => "COLOR_REF",
											2 => "SIZES_SHOES",
											3 => "SIZES_CLOTHES",
										),
										"OFFERS_FIELD_CODE" => array(
											0 => "",
											1 => "",
										),
										"OFFERS_LIMIT" => "0",
										"OFFERS_PROPERTY_CODE" => array(
											0 => "COLOR_REF",
											1 => "SIZES_SHOES",
											2 => "SIZES_CLOTHES",
											3 => "",
										),
										"OFFERS_SORT_FIELD" => "sort",
										"OFFERS_SORT_FIELD2" => "id",
										"OFFERS_SORT_ORDER" => "asc",
										"OFFERS_SORT_ORDER2" => "desc",
										"OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
										"OFFER_TREE_PROPS" => array(
											0 => "COLOR_REF",
											1 => "SIZES_SHOES",
											2 => "SIZES_CLOTHES",
										),
										"PAGER_BASE_LINK_ENABLE" => "N",
										"PAGER_DESC_NUMBERING" => "N",
										"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
										"PAGER_SHOW_ALL" => "N",
										"PAGER_SHOW_ALWAYS" => "N",
										"PAGER_TEMPLATE" => ".default",
										"PAGER_TITLE" => "Товары",
										"PAGE_ELEMENT_COUNT" => "6",
										"PARTIAL_PRODUCT_PROPERTIES" => "N",
										"PRICE_CODE" => array(),
										"PRICE_VAT_INCLUDE" => "Y",
										"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
										"PRODUCT_DISPLAY_MODE" => "Y",
										"PRODUCT_ID_VARIABLE" => "id",
										"PRODUCT_PROPERTIES" => array(),
										"PRODUCT_PROPS_VARIABLE" => "prop",
										"PRODUCT_QUANTITY_VARIABLE" => "",
										"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':true}]",
										"PRODUCT_SUBSCRIPTION" => "N",
										"PROPERTY_CODE" => array(
											0 => "",
											1 => "ZAD",
											2 => "KOL_SLOEV",
											3 => "MATERIAL",
											4 => "V_OPUSK",
											5 => "V_POD",
											6 => "EKSPO_BAS",
											7 => "EKSPO_NORM",
											8 => "NEWPRODUCT",
											9 => "",
										),
										"PROPERTY_CODE_MOBILE" => array(),
										"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
										"RCM_TYPE" => "personal",
										"SECTION_CODE" => "onlayn-meropriyatiya",
										"SECTION_CODE_PATH" => "",
										"SECTION_ID" => "",
										"SECTION_ID_VARIABLE" => "SECTION_CODE",
										"SECTION_URL" => "",
										"SECTION_USER_FIELDS" => array(
											0 => "UF_PR_GR_NAME_RU",
											1 => "UF_NASTR_FILE",
											2 => "",
										),
										"SEF_MODE" => "Y",
										"SEF_RULE" => "",
										"SET_BROWSER_TITLE" => "Y",
										"SET_LAST_MODIFIED" => "N",
										"SET_META_DESCRIPTION" => "Y",
										"SET_META_KEYWORDS" => "Y",
										"SET_STATUS_404" => "N",
										"SET_TITLE" => "Y",
										"SHOW_404" => "N",
										"SHOW_ALL_WO_SECTION" => "N",
										"SHOW_CLOSE_POPUP" => "N",
										"SHOW_DISCOUNT_PERCENT" => "N",
										"SHOW_FROM_SECTION" => "N",
										"SHOW_MAX_QUANTITY" => "N",
										"SHOW_OLD_PRICE" => "N",
										"SHOW_PRICE_COUNT" => "1",
										"SHOW_SLIDER" => "N",
										"SLIDER_INTERVAL" => "3000",
										"SLIDER_PROGRESS" => "N",
										"TEMPLATE_THEME" => "blue",
										"USE_ENHANCED_ECOMMERCE" => "Y",
										"USE_MAIN_ELEMENT_SECTION" => "N",
										"USE_PRICE_COUNT" => "N",
										"USE_PRODUCT_QUANTITY" => "N",
										"COMPONENT_TEMPLATE" => "academy_article_list"
									),
									false
								);
								?>


							</div>
							<div class="service-item" id="afterWork">
								<?
								$APPLICATION->IncludeComponent(
									"bitrix:catalog.section",
									"academy_article_list",
									array(
										"ACTION_VARIABLE" => "action",
										"ADD_PICT_PROP" => "-",
										"ADD_PROPERTIES_TO_BASKET" => "Y",
										"ADD_SECTIONS_CHAIN" => "N",
										"ADD_TO_BASKET_ACTION" => "ADD",
										"AJAX_MODE" => "N",
										"AJAX_OPTION_ADDITIONAL" => "",
										"AJAX_OPTION_HISTORY" => "N",
										"AJAX_OPTION_JUMP" => "N",
										"AJAX_OPTION_STYLE" => "N",
										"BACKGROUND_IMAGE" => "UF_BACKGROUND_IMAGE",
										"BASKET_URL" => "/personal/basket.php",
										"BRAND_PROPERTY" => "-",
										"BROWSER_TITLE" => "-",
										"CACHE_FILTER" => "N",
										"CACHE_GROUPS" => "N",
										"CACHE_TIME" => "36000000",
										"CACHE_TYPE" => "A",
										"COMPATIBLE_MODE" => "Y",
										"CONVERT_CURRENCY" => "Y",
										"CURRENCY_ID" => "RUB",
										"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
										"DATA_LAYER_NAME" => "dataLayer",
										"DETAIL_URL" => "",
										"DISABLE_INIT_JS_IN_COMPONENT" => "N",
										"DISCOUNT_PERCENT_POSITION" => "bottom-right",
										"DISPLAY_BOTTOM_PAGER" => "Y",
										"DISPLAY_COMPARE" => "N",
										"DISPLAY_TOP_PAGER" => "N",
										"ELEMENT_SORT_FIELD" => "sort",
										"ELEMENT_SORT_FIELD2" => "id",
										"ELEMENT_SORT_ORDER" => "asc",
										"ELEMENT_SORT_ORDER2" => "desc",
										"ENLARGE_PRODUCT" => "PROP",
										"ENLARGE_PROP" => "-",
										"FILTER_NAME" => "arrFilter",
										"HIDE_NOT_AVAILABLE" => "N",
										"HIDE_NOT_AVAILABLE_OFFERS" => "N",
										"IBLOCK_ID" => ID_IB_ACADEMY,
										"IBLOCK_TYPE" => "content",
										"INCLUDE_SUBSECTIONS" => "Y",
										"LABEL_PROP" => array(),
										"LABEL_PROP_MOBILE" => "",
										"LABEL_PROP_POSITION" => "top-left",
										"LAZY_LOAD" => "Y",
										"LINE_ELEMENT_COUNT" => "3",
										"LOAD_ON_SCROLL" => "N",
										"MESSAGE_404" => "",
										"MESS_BTN_ADD_TO_BASKET" => "В корзину",
										"MESS_BTN_BUY" => "Купить",
										"MESS_BTN_DETAIL" => "Подробнее",
										"MESS_BTN_LAZY_LOAD" => "Показать ещё",
										"MESS_BTN_SUBSCRIBE" => "Подписаться",
										"MESS_NOT_AVAILABLE" => "Нет в наличии",
										"META_DESCRIPTION" => "-",
										"META_KEYWORDS" => "-",
										"OFFERS_CART_PROPERTIES" => array(
											0 => "ARTNUMBER",
											1 => "COLOR_REF",
											2 => "SIZES_SHOES",
											3 => "SIZES_CLOTHES",
										),
										"OFFERS_FIELD_CODE" => array(
											0 => "",
											1 => "",
										),
										"OFFERS_LIMIT" => "0",
										"OFFERS_PROPERTY_CODE" => array(
											0 => "COLOR_REF",
											1 => "SIZES_SHOES",
											2 => "SIZES_CLOTHES",
											3 => "",
										),
										"OFFERS_SORT_FIELD" => "sort",
										"OFFERS_SORT_FIELD2" => "id",
										"OFFERS_SORT_ORDER" => "asc",
										"OFFERS_SORT_ORDER2" => "desc",
										"OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
										"OFFER_TREE_PROPS" => array(
											0 => "COLOR_REF",
											1 => "SIZES_SHOES",
											2 => "SIZES_CLOTHES",
										),
										"PAGER_BASE_LINK_ENABLE" => "N",
										"PAGER_DESC_NUMBERING" => "N",
										"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
										"PAGER_SHOW_ALL" => "N",
										"PAGER_SHOW_ALWAYS" => "N",
										"PAGER_TEMPLATE" => ".default",
										"PAGER_TITLE" => "Товары",
										"PAGE_ELEMENT_COUNT" => "6",
										"PARTIAL_PRODUCT_PROPERTIES" => "N",
										"PRICE_CODE" => array(),
										"PRICE_VAT_INCLUDE" => "Y",
										"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
										"PRODUCT_DISPLAY_MODE" => "Y",
										"PRODUCT_ID_VARIABLE" => "id",
										"PRODUCT_PROPERTIES" => array(),
										"PRODUCT_PROPS_VARIABLE" => "prop",
										"PRODUCT_QUANTITY_VARIABLE" => "",
										"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':true}]",
										"PRODUCT_SUBSCRIPTION" => "N",
										"PROPERTY_CODE" => array(
											0 => "",
											1 => "ZAD",
											2 => "KOL_SLOEV",
											3 => "MATERIAL",
											4 => "V_OPUSK",
											5 => "V_POD",
											6 => "EKSPO_BAS",
											7 => "EKSPO_NORM",
											8 => "NEWPRODUCT",
											9 => "",
										),
										"PROPERTY_CODE_MOBILE" => array(),
										"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
										"RCM_TYPE" => "personal",
										"SECTION_CODE" => "offlayn-meropriyatiya",
										"SECTION_CODE_PATH" => "",
										"SECTION_ID" => "",
										"SECTION_ID_VARIABLE" => "SECTION_CODE",
										"SECTION_URL" => "",
										"SECTION_USER_FIELDS" => array(
											0 => "UF_PR_GR_NAME_RU",
											1 => "UF_NASTR_FILE",
											2 => "",
										),
										"SEF_MODE" => "Y",
										"SEF_RULE" => "",
										"SET_BROWSER_TITLE" => "Y",
										"SET_LAST_MODIFIED" => "N",
										"SET_META_DESCRIPTION" => "Y",
										"SET_META_KEYWORDS" => "Y",
										"SET_STATUS_404" => "N",
										"SET_TITLE" => "Y",
										"SHOW_404" => "N",
										"SHOW_ALL_WO_SECTION" => "N",
										"SHOW_CLOSE_POPUP" => "N",
										"SHOW_DISCOUNT_PERCENT" => "N",
										"SHOW_FROM_SECTION" => "N",
										"SHOW_MAX_QUANTITY" => "N",
										"SHOW_OLD_PRICE" => "N",
										"SHOW_PRICE_COUNT" => "1",
										"SHOW_SLIDER" => "N",
										"SLIDER_INTERVAL" => "3000",
										"SLIDER_PROGRESS" => "N",
										"TEMPLATE_THEME" => "blue",
										"USE_ENHANCED_ECOMMERCE" => "Y",
										"USE_MAIN_ELEMENT_SECTION" => "N",
										"USE_PRICE_COUNT" => "N",
										"USE_PRODUCT_QUANTITY" => "N",
										"COMPONENT_TEMPLATE" => "academy_article_list"
									),
									false
								);
								?>

							</div>

						</div>

					</div>


				</div>


			</div>
		</div>
	</div>
	</div>
<? require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php' ?>