<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
use Bitrix\Main\Page\Asset;
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/style/support.css");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/support.js");
Asset::getInstance()->addCss("/support/support.css");
?>

<div class="page-content">
    <div class="container-fluid">
        <div class="page-section page-article-support">
            <? if (!isset($bShowLeftCol) || $bShowLeftCol) { ?>
                <div class="left-sidenav left-sidenav-support" id="leftSidenav">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:catalog.section",
                        "support_menu",
                        Array(
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "IBLOCK_ID" => "43",
                            "IBLOCK_TYPE" => "content",
                        )
                    );?>
                </div>
            <? } ?>
            <div class="main right-col">
                <div class="tab-content">
                    <div class="container tab-pane active">