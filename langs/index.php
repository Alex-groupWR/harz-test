<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("langs");
?><?
var_dump($_SESSION['lang']);
echo SITE_TEMPLATE_ID;
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>