<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
global $APPLICATION;
global $USER;

$APPLICATION->SetTitle("Личный кабинет");
?>
    <div class="container-fluid">
	<div class="page-section text-page">
		 <?$APPLICATION->IncludeComponent(
	"bitrix:system.auth.forgotpasswd",
	"flat",
Array()
);?>
	</div>
</div>
<br><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>