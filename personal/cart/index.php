<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;
?>

	<div class="container">
		<div class="page-section page-cart">
			
			<? $APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket", 
	"vreale", 
	array(
		"ACTION_VARIABLE" => "soa-action",
		"ADDITIONAL_PICT_PROP_6" => "-",
		"ADDITIONAL_PICT_PROP_7" => "-",
		"AUTO_CALCULATION" => "Y",
		"BASKET_IMAGES_SCALING" => "adaptive",
		"COLUMNS_LIST_EXT" => array(
			0 => "PREVIEW_PICTURE",
			1 => "DISCOUNT",
			2 => "DELETE",
			3 => "DELAY",
			4 => "TYPE",
			5 => "SUM",
		),
		"COLUMNS_LIST_MOBILE" => array(
			0 => "PREVIEW_PICTURE",
			1 => "DISCOUNT",
			2 => "DELETE",
			3 => "DELAY",
			4 => "TYPE",
			5 => "SUM",
		),
		"COMPATIBLE_MODE" => "Y",
		"CORRECT_RATIO" => "Y",
		"DEFERRED_REFRESH" => "Y",
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"DISPLAY_MODE" => "extended",
		"EMPTY_BASKET_HINT_PATH" => "/",
		"GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
		"GIFTS_CONVERT_CURRENCY" => "N",
		"GIFTS_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_HIDE_NOT_AVAILABLE" => "N",
		"GIFTS_MESS_BTN_BUY" => "Выбрать",
		"GIFTS_MESS_BTN_DETAIL" => "Подробнее",
		"GIFTS_PAGE_ELEMENT_COUNT" => "4",
		"GIFTS_PLACE" => "BOTTOM",
		"GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
		"GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
		"GIFTS_SHOW_OLD_PRICE" => "N",
		"GIFTS_TEXT_LABEL_GIFT" => "Подарок",
		"HIDE_COUPON" => "N",
		"LABEL_PROP" => array(
		),
		"OFFERS_PROPS" => array(
			0 => "COLOR_REF",
			1 => "COLOR",
			2 => "VOLUME",
		),
		"PATH_TO_ORDER" => "/personal/order/make/",
		"PRICE_DISPLAY_MODE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"PRODUCT_BLOCKS_ORDER" => "props,sku,columns",
		"QUANTITY_FLOAT" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_FILTER" => "N",
		"SHOW_RESTORE" => "Y",
		"TEMPLATE_THEME" => "blue",
		"TOTAL_BLOCK_DISPLAY" => array(
			0 => "bottom",
		),
		"USE_DYNAMIC_SCROLL" => "Y",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_GIFTS" => "N",
		"USE_PREPAYMENT" => "N",
		"USE_PRICE_ANIMATION" => "Y",
		"COMPONENT_TEMPLATE" => "vreale",
		"ADDITIONAL_PICT_PROP_25" => "-",
		"ADDITIONAL_PICT_PROP_27" => "-",
		"ADDITIONAL_PICT_PROP_29" => "-",
		"ADDITIONAL_PICT_PROP_32" => "-",
		"ADDITIONAL_PICT_PROP_34" => "-",
		"ADDITIONAL_PICT_PROP_35" => "MORE_PHOTO",
		"ADDITIONAL_PICT_PROP_55" => "-",
		"ADDITIONAL_PICT_PROP_56" => "MORE_PHOTO"
	),
	false
); ?>
			</div>
	</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>