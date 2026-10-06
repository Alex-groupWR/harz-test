<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

global $APPLICATION;
global $USER;

\Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/vreale/cabinet.css");
\Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/style/popup.css");

$APPLICATION->SetTitle("Личный кабинет");
?><div class="container-fluid">
	<div class="container">
		<div class="cabinet-block">
			 <?

			if ($_GET['change_password'] == 'yes') {
				$APPLICATION->IncludeComponent("bitrix:system.auth.changepasswd", "flat", array(
						"REGISTER_URL" => "",
						"PROFILE_URL" => "/personal/",
						"SHOW_ERRORS" => "Y"
					)
				);
			} elseif ($_GET['forgot_password'] == 'yes') {
				$APPLICATION->IncludeComponent("bitrix:system.auth.forgotpasswd", "flat", array(
						"REGISTER_URL" => "",
						"PROFILE_URL" => "/personal/",
						"SHOW_ERRORS" => "Y"
					)
				);
			} elseif ($_GET['register'] == 'yes'){
				?> <?$APPLICATION->IncludeComponent(
                    "ptrhta:main.register",
                    ".default",
                    array(
                        "AUTH" => "Y",	// Автоматически авторизовать пользователей
                        "COMPONENT_TEMPLATE" => ".default",
                        "FIELDS_ORDER" => array(
                            0 => "NAME",
                            1 => "EMAIL",
                            2 => "PASSWORD",
                            3 => "CONFIRM_PASSWORD",
                            4 => "LOGIN",
                        ),
                        "REQUIRED_FIELDS" => array(	// Поля, обязательные для заполнения
                            0 => "EMAIL",
                            1 => "NAME",
                        ),
                        "SET_TITLE" => "Y",	// Устанавливать заголовок страницы
                        "SHOW_FIELDS" => array(	// Поля, которые показывать в форме
                            0 => "EMAIL",
                            1 => "NAME",
                        ),
                        "SUCCESS_PAGE" => "/personal/?login=yes",	// Страница окончания регистрации
                        "USER_PROPERTY" => "",	// Показывать доп. свойства
                        "USER_PROPERTY_NAME" => "",	// Название блока пользовательских свойств
                        "USE_BACKURL" => "Y",	// Отправлять пользователя по обратной ссылке, если она есть
                    )
                );?> <?
			} else if ($USER->IsAuthorized()) {
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
		"PATH_TO_CATALOG" => "/catalog/",
		"PATH_TO_CONTACT" => "/contacts/",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"PROFILES_PER_PAGE" => "10",
		"PROP_1" => "",
		"PROP_2" => "",
		"PROP_3" => "",
		"PROP_4" => "",
		"SAVE_IN_SESSION" => "Y",
		"SEF_MODE" => "Y",
		"SEND_INFO_PRIVATE" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_ACCOUNT_COMPONENT" => "Y",
		"SHOW_ACCOUNT_PAGE" => "N",
		"SHOW_ACCOUNT_PAY_COMPONENT" => "Y",
		"SHOW_BASKET_PAGE" => "N",
		"SHOW_CONTACT_PAGE" => "N",
		"SHOW_ORDER_PAGE" => "Y",
		"SHOW_PRIVATE_PAGE" => "Y",
		"SHOW_PROFILE_PAGE" => "Y",
		"SHOW_SUBSCRIBE_PAGE" => "N",
		"USE_AJAX_LOCATIONS_PROFILE" => "Y",
		"COMPONENT_TEMPLATE" => "intec.cabinet.1",
		"MAILING_SHOW" => "N",
		"SEF_FOLDER" => "/personal/",
		"PROP_9" => array(
		),
		"PROP_8" => array(
		),
		"PROP_5" => array(
			0 => "150",
			1 => "151",
		),
		"PROP_7" => array(
		),
		"ORDERS_LINK" => "",
		"PROFILE_LINK" => "",
		"CHANGE_PASSWORD_LINK" => "",
		"SHOW_ICON" => "N",
		"PROPERTY_MANAGER" => "",
		"CRM_SHOW_PAGE" => "N",
		"PRODUCT_VIEWED_SHOW_PAGE" => "N",
		"PROP_10" => array(
		),
		"CRM_PATH" => "https://bx.harzlabs.ru/",
		"SEF_URL_TEMPLATES" => array(
			"index" => "index.php",
			"orders" => "orders/",
			"account" => "account/",
			"subscribe" => "subscribe/",
			"profile" => "profiles/",
			"profile_detail" => "profiles/#ID#",
			"private" => "private/",
			"order_detail" => "orders/#ID#",
			"order_cancel" => "cancel/#ID#",
		)
	),
	false
);
			} else {
				$APPLICATION->IncludeComponent("ptrhta:system.auth.authorize", "flat", array(
						"REGISTER_URL" => "",
						"PROFILE_URL" => "/personal/",
						"SHOW_ERRORS" => "Y"
					)
				);
			} ?>
		</div>
	</div>
</div>
 <br><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>