<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Поиск - HARZ Labs");
?>
    <div class="container">
        <?
        $sCurCatalogBlockId = LANGUAGE_ID == 'ru' ? '35' : '56';
        ?>
        <div class="search-section text-page company-page">
            <? $arProducts = $APPLICATION->IncludeComponent(
                "arturgolubev:search.page",
                "catalog",
                array(
                    "CACHE_TIME" => "3600",
                    "CACHE_TYPE" => "A",
                    "DEFAULT_SORT" => "rank",
                    "arrFILTER" => array(
                        0 => "iblock_CRM_PRODUCT_CATALOG",
                    ),
                    "arrFILTER_iblock_CRM_PRODUCT_CATALOG" => array(
                        0 => $sCurCatalogBlockId
                    ),
                    "COMPONENT_TEMPLATE" => "catalog",
                    "USE_LANGUAGE_GUESS" => "Y",
                    "SHOW_WHERE" => "N",
                    "arrWHERE" => "",
                    "SHOW_WHEN" => "N",
                    "SHOW_HISTORY" => "N",
                    "CHECK_DATES" => "N",
                    "FILTER_NAME" => "",
                    "INPUT_PLACEHOLDER" => "",
                    "PAGE_RESULT_COUNT" => "50",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_TITLE" => "Название результатов поиска",
                    "PAGER_SHOW_ALWAYS" => "N"
                ),
                false
            );

            if (count($arProducts) > 0) {
                // sorrь
                foreach ($arProducts as $key => $arItemID) {
                    $bActive = false;
                    if (CModule::IncludeModule("catalog")) {
                        $arProductPar = CCatalogSku::GetProductInfo($arItemID);
                        if (is_array($arProductPar)) {
                            $oProductInfo = CIBlockElement::GetByID($arProductPar['ID']);
                            if ($arProductInfo = $oProductInfo->GetNext())
                                if ($arProductInfo['ACTIVE'] == 'Y') {
                                    $bActive = true;
                                } else {
                                    $bActive = false;
                                }
                        } else {
                            $bActive = true;
                        }
                    } else {
                        $bActive = true;
                    }

                    if (!$bActive) {
                        unset($arProducts[$key]);
                    }
                }

                $arrProductsFilter = ['ID' => $arProducts, 'ACTIVE' => 'Y', '=PROPERTY_CML2_TRAITS' => false, '!CATALOG_PRICE_4' => false];
                ?>
            <? } ?>
            <? if (count($arProducts) > 0) { ?>
                <h2>Каталог товаров</h2>
                <? $APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"vreale", 
	[
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "PRODUCTS_IMG",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/basket.php",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPATIBLE_MODE" => "Y",
		"COMPONENT_TEMPLATE" => "vreale",
		"CONVERT_CURRENCY" => "N",
		"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
		"CYCLIC_LOADING" => "N",
		"CYCLIC_LOADING_COUNTER_NAME" => "cycleCount",
		"DEFERRED_LOAD" => "N",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "SCALED_PRICE_4",
		"ELEMENT_SORT_FIELD2" => "SCALED_PRICE_4",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "asc",
		"ENLARGE_PRODUCT" => "PROP",
		"ENLARGE_PROP" => "-",
		"FILTER_NAME" => "arrProductsFilter",
		"HIDE_NOT_AVAILABLE" => "Y",
		"HIDE_NOT_AVAILABLE_OFFERS" => "Y",
		"IBLOCK_ID" => $sCurCatalogBlockId,
		"IBLOCK_TYPE" => "CRM_PRODUCT_CATALOG",
		"INCLUDE_SUBSECTIONS" => "A",
		"LABEL_PROP" => "",
		"LAZY_LOAD" => "N",
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
		"OFFERS_CART_PROPERTIES" => [
			0 => "COLOR",
			1 => "VOLUME",
		],
		"OFFERS_FIELD_CODE" => [
			0 => "",
			1 => "",
		],
		"OFFERS_LIMIT" => "0",
		"OFFERS_PROPERTY_CODE" => [
			0 => "COLOR",
			1 => "VOLUME",
			2 => "",
		],
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => [
			0 => "COLOR",
			1 => "VOLUME",
		],
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "30",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => [
			0 => "RUB",
		],
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
		"PRODUCT_DISPLAY_MODE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => [
		],
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'6','BIG_DATA':false},{'VARIANT':'6','BIG_DATA':false},{'VARIANT':'6','BIG_DATA':false},{'VARIANT':'6','BIG_DATA':false},{'VARIANT':'6','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => [
			0 => "",
			1 => "",
		],
		"PROPERTY_CODE_MOBILE" => "",
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
		"RCM_TYPE" => "personal",
		"SECTIONS_OFFSET_MODE" => "N",
		"SECTIONS_OFFSET_VARIABLE" => "",
		"SECTIONS_SECTION_CODE" => "",
		"SECTIONS_SECTION_ID" => "",
		"SECTIONS_TOP_DEPTH" => "2",
		"SECTION_CODE" => "",
		"SECTION_ID" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => [
			0 => "",
			1 => "",
		],
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "N",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_OFFER_NAME" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N"
	],
	false
); ?><? } ?>
            <h2>Настройки принтеров</h2>
            <? $APPLICATION->IncludeComponent(
                "arturgolubev:search.page",
                ".default",
                array(
                    "CACHE_TIME" => "3600",
                    "CACHE_TYPE" => "A",
                    "CHECK_DATES" => "Y",
                    "COMPONENT_TEMPLATE" => ".default",
                    "DEFAULT_SORT" => "rank",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "DISPLAY_TOP_PAGER" => "Y",
                    "FILTER_NAME" => "",
                    "INPUT_PLACEHOLDER" => "",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => "round",
                    "PAGER_TITLE" => "Результаты поиска",
                    "PAGE_RESULT_COUNT" => "50",
                    "SHOW_HISTORY" => "N",
                    "SHOW_PROPS" => array(
                        0 => "CML2_ARTICLE",
                        1 => "",
                    ),
                    "SHOW_WHEN" => "N",
                    "SHOW_WHERE" => "N",
                    "USE_LANGUAGE_GUESS" => "Y",
                    "arrFILTER" => array(
                        0 => "iblock_content",
                    ),
                    "arrFILTER_iblock_content" => array(
                        0 => "41",
                        1 => "53",
                    ),
                    "arrWHERE" => ""
                ),
                false
            ); ?>
        </div>
    </div>
    <br><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>