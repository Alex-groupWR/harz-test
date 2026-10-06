<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

if (!empty($arResult["ITEMS"])): ?>
    <div class="section-recently section-products">
        <h2><?= Loc::GetMessage($arParams["LOC_TITLE"]) ?></h2>

        <div class="slider slider-recently slider-products">
            <? foreach ($arResult["ITEMS"] as $productId):
                if ((int)$productId !== $arParams['CURRENT_PRODUCT_ID']) {
                    getSliderProductsView($productId);
                }

            endforeach; ?>

        </div>
        <a href="/products/" class="btn-comments"><?= Loc::GetMessage("VIEW_ALL") ?></a>
    </div>
<?php endif; ?>