<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<div class="notice">
    <div class="notice__wrapper">
        <div class="notice__content">
            <div class="notice__title">
                Заказ оформлен!
            </div>
            <div class="notice__order">
                <p><? require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/sberbank.ecom/payment/result.php"); ?></p>
            </div>
        </div>
        <div class="buttons">
			<a href="/" class="button button--back">
                Вернуться в каталог
            </a>
			<a href="/" class="button button--main">
                Перейти на главную
            </a>
        </div>
    </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
