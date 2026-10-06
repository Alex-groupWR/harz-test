<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?><? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/header.php", Array(), Array("MODE" => "php")); ?>
<div class="width width--checkout width--1400">
    <div class="steps">
		<?php if(SITE_LANG == 'en') { ?>
        <span class="step">1. Cart</span> <span class="step ">2. Checkout</span> <span class="step step--active">3. Success</span>
		<?php } else { ?>
		<span class="step">1. Корзина</span> <span class="step ">2. Оформление</span> <span class="step step--active">3. Подтверждение</span>
		<?php } ?>
    </div>
    <div id="order_form_div">
	    <div class="notice">
    		<div class="notice__wrapper">
        		<div class="notice__content">
					<?php if(SITE_LANG == 'en') { ?>
                	<div class="notice__title">Order payed</div>
					<div class="notice__order">
						<p>Your order payed successfully.</p>
					</div>
					<?php } else { ?>
                	<div class="notice__title">Заказ оплачен</div>
					<div class="notice__order">
						<p>Ваш заказ успешно оплачен.</p>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment.receive",
	"",
Array()
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>