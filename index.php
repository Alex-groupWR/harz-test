<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle("HARZ Labs");

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(SITE_TEMPLATE_PATH . "/index.php");
$APPLICATION->SetPageProperty("CRITICAL_CSS", "PAGE");
?>

<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
?>