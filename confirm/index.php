<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?><?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if (isset($_REQUEST["backurl"]) && strlen($_REQUEST["backurl"])>0) 
	LocalRedirect($backurl);

$APPLICATION->SetTitle("Подтверждение регистрации");
?>
<div class="container confirm">
	<div class="page-section text-page">
		 <?$APPLICATION->IncludeComponent(
	"ptrhta:system.auth.confirmation",
	"",
	Array(
		"CONFIRM_CODE" => "confirm_code",
		"LOGIN" => "login",
		"USER_ID" => "confirm_user_id"
	)
);?>
		<p>
 <a href="/personal/" class="btn btn-primary">Перейти в личный кабинет</a>
		</p>
		<p>
 <a href="<?=SITE_DIR?>">Вернуться на главную страницу</a>
		</p>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>