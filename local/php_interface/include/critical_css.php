<?php
if (!function_exists('critical_css_head')) {
	function critical_css_head() {
	    global $APPLICATION;
        echo '<meta http-equiv="Content-Type" content="text/html; charset='.LANG_CHARSET.'"'.(true? ' /':'').'>'."\n";
        $APPLICATION->ShowMeta("robots", false, true);
        $APPLICATION->ShowMeta("keywords", false, true);
        $APPLICATION->ShowMeta("description", false, true);
        $APPLICATION->ShowLink("canonical", null, true);
        //$APPLICATION->ShowCSS(true, $bXhtmlStyle = true);
        if ($APPLICATION->GetCurPage()=='/') {
            echo "<!--CRITICAL CSS page -->";
            $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                ".default",
                array(
                    "AREA_FILE_SHOW" => "page",
                    "AREA_FILE_SUFFIX" => "css",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_MODE" => "html",
                    "EDIT_TEMPLATE" => "page_css.php"
                )
            );
        }else{
            echo "<!--CRITICAL CSS sect -->";
            $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                ".default",
                array(
                    "AREA_FILE_SHOW" => "sect",
                    "AREA_FILE_SUFFIX" => "css",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_MODE" => "html",
                    "EDIT_TEMPLATE" => "sect_css.php"
                )
            );
        }
        //
        $APPLICATION->ShowHeadStrings();
        $APPLICATION->ShowHeadScripts();
        //$APPLICATION->ShowHead();
	}
}
if (!function_exists('critical_css_foot')) {
    function critical_css_foot() {
        global $APPLICATION;
        if ($APPLICATION->GetProperty("CRITICAL_CSS") == "SECT"
        || $APPLICATION->GetProperty("CRITICAL_CSS") == "PAGE") {
            $APPLICATION->ShowCSS(true, true);
        }
        //$APPLICATION->ShowCSS(true, $bXhtmlStyle = true);
    }
}

?>