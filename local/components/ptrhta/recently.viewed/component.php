<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Catalog\PriceTable as Price;
use Bitrix\Catalog\CatalogViewedProductTable as CatalogViewedProductTable;
use Bitrix\Main\Page\Asset;

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/style/card.css", true);
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/slick/slick.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/slick/slick-theme.css");

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/slick/slick.js");

if (isset($arParams["PRODUCT_IDS"])) {
    $arResult["ITEMS"] = $arParams["PRODUCT_IDS"];
} else {
    $arViewed = array();
    $basketUserId = (int)CSaleBasket::GetBasketUserID(false);
    if ($basketUserId > 0) {
        $viewedIterator = CatalogViewedProductTable::getList(array(
            'select' => array('PRODUCT_ID', 'ELEMENT_ID'),
            'filter' => array('=FUSER_ID' => $basketUserId, '=SITE_ID' => SITE_ID),
            'order' => array('DATE_VISIT' => 'DESC'),
            'limit' => 10
        ));

        while ($arFields = $viewedIterator->fetch()) {
            $arResult["ITEMS"][] = $arFields['ELEMENT_ID'];
        }
    }


}


if (!function_exists('getSliderProductsView')) {
    function getSliderProductsView($productId)
    {
        $curIblockId = LANGUAGE_ID == 'ru' ? 34 : 55;
        $arSelect = array("ID", "IBLOCK_ID", "NAME", "CODE", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "PREVIEW_TEXT", "PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
        $arFilter = array("IBLOCK_ID" => IntVal($curIblockId), "ID" => $productId, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
        $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);

        if ($ob = $res->GetNextElement()):
            $arFields = $ob->GetFields();
            $arProps = $ob->GetProperties();

            $resultOff = CCatalogSKU::getOffersList(
                $productId,
                $iblockID = 0,
                $skuFilter = array("!PROPERTY_IS_HIDE_PRICE_VALUE" => "Y"),
                $fields = array("PREVIEW_PICTURE", "WEIGHT", "PROPERTY_VOLUME", "PROPERTY_IS_HIDE_PRICE"),
                $propertyFilter = array()
            );

            if (!empty($resultOff["$productId"])) {
				$idElement = $resultOff[$productId][array_key_first($resultOff[$productId])]; //array_shift($resultOff[$productId]);
				$idEl = $idElement["ID"];
				$curWeight = 0;

                foreach ($resultOff[$productId] as $off) {
					if (($off["PROPERTY_VOLUME_ENUM_ID"] == 119 || $off["PROPERTY_VOLUME_ENUM_ID"] == 118) && $off["WEIGHT"] >= $curWeight) {
						$curWeight = $off["WEIGHT"];
						$idEl = $off["ID"];
						$idElement = $off;

						if ($picture = $off["PREVIEW_PICTURE"]) {
							$arFields["PREVIEW_PICTURE"] = $picture;
						}
					}
					else {
						if ($off["PROPERTY_VOLUME_ENUM_ID"] == 17) {
							$idEl = $off["ID"];
						}
					}
                }

                $dbPrice = Price::getList([
                    "filter" => array(
                        "PRODUCT_ID" => $idEl,
                        'CATALOG_GROUP.ID' => LANGUAGE_ID == 'ru' ? "4" : "2"
                    )]);

                $price = "";
                if ($arPrice = $dbPrice->fetch()) {
                    $price = $arPrice["PRICE"];
                }
                ?>
                <div>

                    <a href="<?= $arFields["DETAIL_PAGE_URL"]; ?>">
                        <div class="product-block" style="align-items: center">
                            <div class="img-product"
                                 style="background-image: url('<?= CFile::GetPath($arFields["PREVIEW_PICTURE"]); ?>'); background-position: center;">
                            </div>

                            <div class="text-product">
                                <p><span class="name"><?= $arFields["NAME"]; ?></span></p>
                                <p class="hidden-mobile">
                                    <?= $arProps["PREVIEW_TEXT"]["VALUE"] ? TruncateText($arProps["PREVIEW_TEXT"]["~VALUE"]["TEXT"], 70) : ''; ?>
                                </p>

                                <p>
                                    <span class="cost"> <? if (LANGUAGE_ID == "en"): ?><?= CurrencyFormat($price, 'EUR'); ?><? else: ?><?= CurrencyFormat($price, 'RUB'); ?><? endif; ?></span>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        <? endif; ?>
    <? } ?>
<? } ?>

<?php

$this->IncludeComponentTemplate();
