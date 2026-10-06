<?$APPLICATION->IncludeComponent(
    "bitrix:main.register", 
    "register", 
    array(
        "AUTH" => "Y",
        "REQUIRED_FIELDS" => array(
            0 => "EMAIL",
            1 => "NAME",
        ),
        "SET_TITLE" => "N",
        "SHOW_FIELDS" => array(
            0 => "EMAIL",
            1 => "NAME",
            2 => "LAST_NAME",
        ),
        "SUCCESS_PAGE" => "",
        "USER_PROPERTY" => array(
        ),
        "USER_PROPERTY_NAME" => "",
        "USE_BACKURL" => "Y",
        "COMPONENT_TEMPLATE" => "register",
		'AJAX_MODE' => 'Y',
    ),
    false
);?>