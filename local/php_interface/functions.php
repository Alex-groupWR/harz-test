<?php

use Bitrix\Main\Data\Cache;

function getOfferQuantity($iOfferID)
{
	$oCache = Cache::createInstance();

	$iQuantity = false;

	$idCache = md5('PROD_OFFER_QUANTITY_' . $iOfferID);
	if ($oCache->initCache(60 * 60 * 2, $idCache)) {
		$iQuantity = $oCache->getVars();
	} elseif ($oCache->startDataCache()) {
		$oResult = \Bitrix\Catalog\ProductTable::getList(array(
			'filter' => array('=ID' => $iOfferID),
		));

		$arProduct = $oResult->fetch();

		$iQuantity = floatval($arProduct['QUANTITY']);
		$oCache->endDataCache($iQuantity);
	}

	return $iQuantity;
}


function getTranslateSectionName($arItem)
{
	if (DEFAULT_LANG != SITE_LANG) {
		$l = strtoupper(SITE_LANG);
		if (isset($arItem['UF_PR_GR_NAME_' . $l]) && $arItem['UF_PR_GR_NAME_' . $l])
			return $arItem['UF_PR_GR_NAME_' . $l];
	}
	return $arItem['NAME'];
}

function getTranslateSectionDesc($arItem)
{
	if (DEFAULT_LANG != SITE_LANG) {
		$l = strtoupper(SITE_LANG);
		if (isset($arItem['UF_PR_GR_DESC_' . $l]) && $arItem['UF_PR_GR_DESC_' . $l])
			return $arItem['UF_PR_GR_DESC_' . $l];
	}
	return $arItem['PREVIEW_TEXT'];
}

function getTranslatePropItem($arItem, $param)
{
	$l = strtoupper(SITE_LANG);
	$param = strtoupper($param);
	if (isset($arItem['PROPERTIES'][$param . '_' . $l]['~VALUE'])) {
		$res = $arItem['PROPERTIES'][$param . '_' . $l]['~VALUE'];
		if (is_array($res)) {
			if (isset($res['TEXT']))
				return $res['TEXT'];
		}
		return $res;
	}
	return $arItem['NAME'];
}

/**
 * Конвертирует изображение в формат webp без сохранения в инфоблок
 * @param $src
 */
function makeWebp($src)
{
	$newImgPath = false;

	if (function_exists('imagewebp')) {
		$src = ToLower($src);
		if (strpos($src, '.png')) {
			$newImg = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . $src);
			$newImgPath = str_replace('.png', '.webp', $src);
		} elseif (strpos($src, '.jpg') !== false || strpos($src, '.jpeg') !== false) {
			$newImg = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'] . $src);
			$newImgPath = str_replace(array('.jpg', '.jpeg'), '.webp', $src);
		}
		if ($newImg) {
			if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $newImgPath)) {
				imagewebp($newImg, $_SERVER['DOCUMENT_ROOT'] . $newImgPath, 90);
			}
			imagedestroy($newImg);
		}
	}

	return $newImgPath;
}

/**
 * Конвертирует изображение в формат webp
 * @param $src
 */
function convertToWebP($src)
{
	$convertedSrc = (new IblockImageConvert([
		'iBlockId' => 8,
		'iBlockElementId' => 0,
		'src' => $src
	]))->run();

	return $convertedSrc;
}


/*
 * Получение кол-во товаров и кол-во их позиций в корзине
 * для текущего пользователя
 * */
function getCountItemsInBasket()
{
	$arBasketItems = array();
	$count = 0;

	$dbBasketItems = CSaleBasket::GetList(
		array(),
		array(
			"FUSER_ID" => CSaleBasket::GetBasketUserID(),
			"LID" => SITE_ID,
			"ORDER_ID" => "NULL"
		),
		false,
		false,
		array("QUANTITY")
	);

	while ($arItems = $dbBasketItems->Fetch()) {
		if (strlen($arItems["CALLBACK_FUNC"]) > 0) {
			CSaleBasket::UpdatePrice($arItems["ID"],
				$arItems["CALLBACK_FUNC"],
				$arItems["MODULE"],
				$arItems["PRODUCT_ID"],
				$arItems["QUANTITY"]);
			$arItems = CSaleBasket::GetByID($arItems["ID"]);
		}

		$arBasketItems[] = $arItems;
		$count += intval($arItems["QUANTITY"]);
	}

	return $count;
}