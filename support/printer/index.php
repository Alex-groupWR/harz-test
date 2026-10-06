<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
//$APPLICATION->SetTitle("Новая страница");
$config = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/settings-config.json'));
$arIblockIds = array($config->{'actual'}->{'IBLOCK_ID'}, $config->{'part-actual'}->{'IBLOCK_ID'});
$arSectionIds = array($config->{'actual'}->{'ru'}, $config->{'part-actual'}->{'ru'});
$arFilter = array('IBLOCK_ID' => $arIblockIds, 'SECTION_ID' => $arSectionIds, 'GLOBAL_ACTIVE' => 'Y');
$db_list = CIBlockSection::GetList(array("sort" => "asc", "NAME" => "ASC"), $arFilter, true);
$iIblockId = $config->{'actual'}->{'IBLOCK_ID'};
$_GLOBALS['arrFilter'] = $arFilter;
$iSectionId = '';
?>

	<div class="container">
		<div class="page-section page-print-support">
			<div class="left-sidenav" id="leftSidenav">
				<div id="filtersBlock">
					<div class="filter-block">
						<div class="collapse show" data-parent="#filtersBlock">
							<div class="filter-elem usage">
								<div class="collapse show">
									<ul class="nav flex-column">
										<? while ($ar_result = $db_list->GetNext()) {
                                            if ($ar_result['CODE'] == $_REQUEST["SECTION_CODE"]) {
                                                $iIblockId = $ar_result['IBLOCK_ID'];
                                                $iSectionId = $ar_result['ID'];
                                            }
											if ($ar_result['ELEMENT_CNT'] > 0):
												?>
												<li class="nav-item"><a class="nav-link container-checkbox" href="/support/printer/<?= $ar_result['CODE']; ?>/"><?= $ar_result['NAME']; ?></a></li>

											<?
											endif;
										} ?>

									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="main right-col">
				<?
				$APPLICATION->IncludeComponent(
					"bitrix:catalog.section",
					"support_printer_detail_flat",
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
						"CACHE_TYPE" => "N",
						"COMPATIBLE_MODE" => "Y",
						"CONVERT_CURRENCY" => "Y",
						"CURRENCY_ID" => "RUB",
						"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
						"DATA_LAYER_NAME" => "dataLayer",
						"DETAIL_URL" => "#SITE_DIR#/support/printer/#ELEMENT_CODE#",
						"DISABLE_INIT_JS_IN_COMPONENT" => "N",
						"DISCOUNT_PERCENT_POSITION" => "bottom-right",
						"DISPLAY_BOTTOM_PAGER" => "Y",
						"DISPLAY_COMPARE" => "N",
						"DISPLAY_TOP_PAGER" => "N",
						"ELEMENT_SORT_FIELD" => "sort",
						"ELEMENT_SORT_FIELD2" => "name",
						"ELEMENT_SORT_ORDER" => "asc",
						"ELEMENT_SORT_ORDER2" => "asc",
						"ENLARGE_PRODUCT" => "PROP",
						"ENLARGE_PROP" => "-",
						"FILTER_NAME" => "arrFilter",
						"HIDE_NOT_AVAILABLE" => "N",
						"HIDE_NOT_AVAILABLE_OFFERS" => "N",
						"IBLOCK_ID" => $iIblockId,
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
						"PAGE_ELEMENT_COUNT" => "60",
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
							0 => "ZAD",
							1 => "KOL_SLOEV",
							2 => "MATERIAL",
							3 => "V_OPUSK",
							4 => "V_POD",
							5 => "EKSPO_BAS",
							6 => "EKSPO_NORM",
							7 => "NEWPRODUCT",
							8 => "",
						),
						"PROPERTY_CODE_MOBILE" => array(),
						"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
						"RCM_TYPE" => "personal",
						"SECTION_CODE" => $_REQUEST["SECTION_CODE"],
						"SECTION_CODE_PATH" => "",
						"SECTION_ID" => $iSectionId,
						"SECTION_ID_VARIABLE" => "SECTION_CODE",
						"SECTION_URL" => "#SITE_DIR#/support/printer/",
						"SECTION_USER_FIELDS" => array(
							0 => "UF_NASTR_FILE",
							1 => "",
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
						"COMPONENT_TEMPLATE" => "support_printer_detail"
					),
					false
				);
				?>

				
			</div>
		</div>
	</div>
	<br><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");

?>