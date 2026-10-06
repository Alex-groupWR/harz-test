<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Privacy policy");
?><? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/preloader.php", Array(), Array("MODE" => "html")); ?>
<? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/header_dark.php", Array(), Array("MODE" => "php")); ?>

<div class="policy">
<? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/".SITE_LANG."/policy.php", Array(), Array("MODE" => "html")); ?>
</div>

<? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/footer.php", Array(), Array("MODE" => "php")); ?>
<? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/popup_items.php", Array(), Array("MODE" => "php")); ?>
<? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/modals.php", Array(), Array("MODE" => "php")); ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>