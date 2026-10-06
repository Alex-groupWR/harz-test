<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $APPLICATION;
?>
<div class="page-section text-page">
<?php
$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.section",
	"intec.cabinet.rest",
	array(
		"ACCOUNT_PAYMENT_ELIMINATED_PAY_SYSTEMS" => array(
			0 => "0",
		),
		"ACCOUNT_PAYMENT_SELL_CURRENCY" => "RUB",
		"ACCOUNT_PAYMENT_SELL_SHOW_FIXED_VALUES" => "Y",
		"ACCOUNT_PAYMENT_SELL_TOTAL" => array(
			0 => "100",
			1 => "200",
			2 => "500",
			3 => "1000",
			4 => "5000",
			5 => "",
		),
		"ACCOUNT_PAYMENT_SELL_USER_INPUT" => "N",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ALLOW_INNER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHECK_RIGHTS_PRIVATE" => "N",
		"COMPATIBLE_LOCATION_MODE_PROFILE" => "Y",
		"CUSTOM_PAGES" => "",
		"CUSTOM_SELECT_PROPS" => array(
		),
		"MAIN_CHAIN_NAME" => "Мой кабинет",
		"NAV_TEMPLATE" => "",
		"ONLY_INNER_FULL" => "N",
		"ORDERS_PER_PAGE" => "10",
		"ORDER_DEFAULT_SORT" => "STATUS",
		"ORDER_DISALLOW_CANCEL" => "N",
		"ORDER_HIDE_USER_INFO" => array(
			0 => "0",
		),
		"ORDER_HISTORIC_STATUSES" => array(
			0 => "F",
		),
		"ORDER_REFRESH_PRICES" => "N",
		"ORDER_RESTRICT_CHANGE_PAYSYSTEM" => array(
			0 => "0",
		),
		"PATH_TO_BASKET" => "/personal/cart/",
		"PATH_TO_CATALOG" => "/",
		"PATH_TO_CONTACT" => "https://harzlabs.com/contacts/",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"PROFILES_PER_PAGE" => "10",
		"PROP_1" => array(
		),
		"PROP_2" => array(
		),
		"PROP_3" => array(
		),
		"PROP_4" => array(
		),
		"SAVE_IN_SESSION" => "Y",
		"SEF_MODE" => "N",
		"SEND_INFO_PRIVATE" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_ACCOUNT_COMPONENT" => "Y",
		"SHOW_ACCOUNT_PAGE" => "N",
		"SHOW_ACCOUNT_PAY_COMPONENT" => "Y",
		"SHOW_BASKET_PAGE" => "Y",
		"SHOW_CONTACT_PAGE" => "Y",
		"SHOW_ORDER_PAGE" => "Y",
		"SHOW_PRIVATE_PAGE" => "Y",
		"SHOW_PROFILE_PAGE" => "Y",
		"SHOW_SUBSCRIBE_PAGE" => "N",
		"USE_AJAX_LOCATIONS_PROFILE" => "Y",
		"COMPONENT_TEMPLATE" => "personal.information"
	),
	false
);?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>