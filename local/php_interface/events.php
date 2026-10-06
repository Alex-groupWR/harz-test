<?php
$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler('catalog', 'OnGetOptimalPrice', function (
	$productId,
	$quantity = 1,
	$arUserGroups = [],
	$renewal = "N",
	$arPrices = [],
	$siteID = false,
	$arDiscountCoupons = false) {
	// Через $isLoop убираем рекурсию, так как CCatalogProduct::GetOptimalPrice снова вызовет эту функцию
	static $isLoop = false;

	if ($isLoop) {
		return true;
	}

	// Колонка цен для разных сайтов
	if (SITE_ID == 'st') {
		$iCatalogPriceID = 4;
	} else {
		$iCatalogPriceID = 2;
	}

	$priceIterator = \Bitrix\Catalog\PriceTable::getList(array(
		'select' => array('ID', 'CATALOG_GROUP_ID', 'PRICE', 'CURRENCY'),
		'filter' => array(
			'=PRODUCT_ID' => $productId,
			'@CATALOG_GROUP_ID' => $iCatalogPriceID,
			array(
				'LOGIC' => 'OR',
				'<=QUANTITY_FROM' => $quantity,
				'=QUANTITY_FROM' => null
			),
			array(
				'LOGIC' => 'OR',
				'>=QUANTITY_TO' => $quantity,
				'=QUANTITY_TO' => null
			)
		),
		'order' => array('CATALOG_GROUP_ID' => 'ASC')
	));

	$isLoop = true;
	$prices = \CCatalogProduct::GetOptimalPrice($productId, $quantity, $arUserGroups, $renewal, $priceIterator->fetchAll(), $siteID, $arDiscountCoupons);
	$isLoop = false;

	return $prices;
});