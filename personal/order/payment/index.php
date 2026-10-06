<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?>
<? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/header.php", Array(), Array("MODE" => "php")); ?>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment",
	"",
Array()
);?><?/*require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");*/?>