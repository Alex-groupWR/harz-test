<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/style/company.css");

$APPLICATION->SetTitle("404 Not Found");

// $APPLICATION->IncludeComponent("bitrix:main.map", ".default", Array(
// 	"LEVEL"	=>	"3",
// 	"COL_NUM"	=>	"2",
// 	"SHOW_DESCRIPTION"	=>	"Y",
// 	"SET_TITLE"	=>	"Y",
// 	"CACHE_TIME"	=>	"36000000"
// 	)
// );
?>
<div class="container">
	<div class="page-section text-page company-page" style="
    min-height: calc(100vh - 275px);     
    display: flex;
    align-items: center;
    justify-content: center;
">
		<div class="company-block">
			<h1 style="position: initial; float: initial; margin-bottom: 0" class="slogan">404 - Не найдено</h1>
		</div>
	</div>
</div>
<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>