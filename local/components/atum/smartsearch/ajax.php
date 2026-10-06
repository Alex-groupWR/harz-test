<? define("NO_KEEP_STATISTIC", true);
require $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php";
CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
CModule::IncludeModule('currency');

global $USER; 

function GetList($arOrder,$arFilter,$arGroup,$arNav,$arSelect){
	$dbElement = CIBlockElement::GetList($arOrder,$arFilter,$arGroup,$arNav,$arSelect);
	$result = array();
	while($ob = $dbElement->GetNextElement()){
		$arFields = $ob->GetFields();
		$arFields['PROPERTIES'] = $ob->GetProperties();
		$result[$arFields['ID']] = $arFields;
	}
	return $result;
}
if (!function_exists('is_countable')) {
    function is_countable($var) { 
        return is_array($var) || $var instanceof Countable || $var instanceof ResourceBundle || $var instanceof SimpleXmlElement; 
    }
}


$search = $_POST['SEARCH'];
$arParams = $_POST['PARAMS'];
$template = $_POST['TEMPLATE']?$_POST['TEMPLATE']:'';

if(isset($search) && isset($arParams) && isset($template)){
	$search = trim(htmlspecialchars($search));

	$arResult = array();
	$arOrder = array();

	$resArray = array();
	
	if($search!==''){
		if($arParams["ELEMENT_SORT_FIELD"]){
			$arOrder[$arParams["ELEMENT_SORT_FIELD"]] = $arParams["ELEMENT_SORT_ORDER"];
		}
		if($arParams["ELEMENT_SORT_FIELD2"]){
			$arOrder[$arParams["ELEMENT_SORT_FIELD2"]] = $arParams["ELEMENT_SORT_ORDER2"];
		}
		
		$arFilter = Array(
			"IBLOCK_TYPE"=>$arParams['IBLOCK_TYPE'],
			"IBLOCK_ID"=>$arParams['IBLOCK_ID'],
	  		"ACTIVE"=>"Y",
			Array('LOGIC' => 'OR',
				Array('SECTION_GLOBAL_ACTIVE' => 'Y'),
				Array('SECTION_ID' => false),
			),
		);
		if ($arParams["SEARCH_ONLY_WITH_PICTURE"] == 'Y'){
			$arFilter[] = Array(
				'LOGIC' => 'OR',
				Array('!PREVIEW_PICTURE' => false),
				Array('!DETAIL_PICTURE' => false),
				($arParams["ITEMS_IMAGES"])?Array('!PROPERTY_'.mb_strtoupper($arParams["ITEMS_IMAGES"]) => false):'',
			);
		}
		if($arParams["SEARCH_ONLY_AVAILABLE"] == 'Y'){
			$arFilter['>CATALOG_QUANTITY'] = 0;
		}
		if($arParams["SEARCH_ONLY_WITH_PRICE"] == 'Y' && $arParams['ITEMS_PRICE_CODE']){
			$arFilter['!CATALOG_PRICE_'.mb_strtoupper($arParams['ITEMS_PRICE_CODE'])] = false;
		}

        $arFilter['=PROPERTY_CML2_TRAITS'] = false;

		$arSelect = Array(
			"ID", 
			"IBLOCK_ID",
			"IBLOCK_SECTION_ID",
			"NAME",
			"DETAIL_PAGE_URL",
			"DETAIL_TEXT",
			"PREVIEW_TEXT",
			"DETAIL_PICTURE",
			"PREVIEW_PICTURE",
			"CATALOG_GROUP_". mb_strtoupper($arParams['ITEMS_PRICE_CODE'])
		);

		if($arParams['SEARCH_BY_ARTICLE'] == "Y" && $arParams["SEARCH_ARTICLE_PROPERTY"]){
			$resArray += GetList($arOrder, array_merge($arFilter,Array('PROPERTY_'. mb_strtoupper($arParams["SEARCH_ARTICLE_PROPERTY"]) => "%".$search."%")), false, false, $arSelect);
		}

		switch ($arParams['SEARCH_BY']){
		    case 1:
		        $arFilterBy = array_merge($arFilter,Array('NAME' => "%".$search."%"));
		        break;
		    case 2:
		        $arFilterBy = array_merge($arFilter,Array('*SEARCHABLE_CONTENT' => $search));
		        break;
		}

		$resArray += GetList($arOrder, $arFilterBy, false, false, $arSelect);
		

		if ($arParams["SEARCH_SHOW_SECTIONS"] == 'Y'){
			$arFilterSection = Array(
				"IBLOCK_TYPE"=>$arParams['IBLOCK_TYPE'],
				"IBLOCK_ID"=>$arParams['IBLOCK_ID'],
				'ACTIVE' => 'Y',
				'GLOBAL_ACTIVE' => 'Y',
				'NAME' => "%".$search."%", 
			);
			$arSelectSection = Array(
				'ID',
				'NAME',
				'SECTION_PAGE_URL',
				'DETAIL_PICTURE',
				'DETAIL_TEXT',
				'PICTURE',
				'DESCRIPTION',
			);

			$dbSections = CIBlockSection::GetList(Array('NAME'=>'ASC'), $arFilterSection, false, $arSelectSection);
			while ($arSection = $dbSections->GetNext()){
				$arSection['PICTURE_URL'] = CFile::GetPath($arSection['PICTURE']);
				$arResult['SECTIONS'][] = $arSection;
			}
		}

		foreach ($resArray as $arFields){
			$arItems = Array();

            $bActive = false;
            if (CModule::IncludeModule("catalog")) {
                $arProductPar = CCatalogSku::GetProductInfo($arFields['ID'], $arFields['IBLOCK_ID']);
                if (is_array($arProductPar)) {
                    $oProductInfo = CIBlockElement::GetByID($arProductPar['ID']);
                    if($arProductInfo = $oProductInfo->GetNext())
                        if ($arProductInfo['ACTIVE'] == 'Y') {
                            $bActive = true;
                        } else {
                            $bActive = false;
                        }
                } else {
                    $bActive = true;
                }
            } else {
                $bActive = true;
            }

			$arItems['ID'] = $arFields['ID'];
			$arItems['IBLOCK_ID'] = $arFields['IBLOCK_ID'];
			$arItems['URL'] = $arFields['DETAIL_PAGE_URL'];

			$dbSection = CIBlockSection::GetByID($arFields["IBLOCK_SECTION_ID"]);
			if($arSection = $dbSection ->Fetch()){
				$arItems['SECTION_NAME'] = $arSection['NAME'];
			}

			$arItems['NAME'] = $arFields['NAME'];

			$breadcrumb = '';	
			$dbBreadcrumb = CIBlockSection::GetNavChain( $arFields['IBLOCK_ID'], $arFields['IBLOCK_SECTION_ID'], Array());
			while ($arBreadcrumbItem = $dbBreadcrumb->GetNext() ){
				$breadcrumb .= '<span>' . $arBreadcrumbItem['NAME'] . '</span>';
			}
			
			$arItems['BREADCRUMB'] = '<div class="smartSearch-breadcrumb">'.$breadcrumb.'</div>';

			if($arParams["SEARCH_ARTICLE_PROPERTY"]){
				$arItems['ARTICLE'] = $arFields['PROPERTIES'][mb_strtoupper($arParams["SEARCH_ARTICLE_PROPERTY"])]["VALUE"];
			}
			if ($arFields['PREVIEW_TEXT'] != ''){
				$arItems['PREVIEW_TEXT'] = $arFields['PREVIEW_TEXT'];
			}
			if ($arFields['DETAIL_TEXT'] != ''){
				$arItems['DETAIL_TEXT'] = $arFields['DETAIL_TEXT'];
			}

			if($arFields['PREVIEW_TEXT'] != ''){
				$arItems['DESCRIPTION'] = preg_replace('/\s+/', ' ', strip_tags($arFields['PREVIEW_TEXT']));
			}elseif($arFields['DETAIL_TEXT'] != ''){
				$arItems['DESCRIPTION'] = preg_replace('/\s+/', ' ', strip_tags($arFields['DETAIL_TEXT']));
			}
	
			if($arFields['PROPERTIES'][mb_strtoupper($arParams["ITEMS_IMAGES"])]['VALUE'][0]){
				$imgID = $arFields['PROPERTIES'][mb_strtoupper($arParams["ITEMS_IMAGES"])]['VALUE'][0];
				$img = CFile::GetPath($imgID);
			}elseif($arFields['PREVIEW_PICTURE']){
				$imgID = $arFields['PREVIEW_PICTURE'];
				$img = CFile::GetPath($imgID);
			}elseif($arFields['DETAIL_PICTURE']){
				$imgID = $arFields['DETAIL_PICTURE'];
				$img = CFile::GetPath($imgID);
			}else{
				$imgID = '';
				$img = '';
			}
			$arItems['PICTURE_ID'] = $imgID;
			$arItems['PICTURE'] = $img;	

			$BASIC_PRICE = (int)$arFields['CATALOG_PRICE_'.$arParams['ITEMS_PRICE_CODE']]; 
			$BASIC_CURRENCY_PRICE = $arFields['CATALOG_CURRENCY_'.$arParams['ITEMS_PRICE_CODE']];

			$arDiscounts = CCatalogDiscount::GetDiscountByProduct($arFields['ID'], $USER->GetUserGroupArray(), "N", $arParams['ITEMS_PRICE_CODE']);
		        if(is_array($arDiscounts) && sizeof($arDiscounts) > 0) {
		        	$DISCOUNT_PRICE = CCatalogProduct::CountPriceWithDiscount($BASIC_PRICE, $BASIC_CURRENCY_PRICE, $arDiscounts);
		        }else{
				$DISCOUNT_PRICE = $BASIC_PRICE;
			}
		
			if($arParams['ITEMS_CURRENCY'] && $arParams['ITEMS_CURRENCY']!=$BASIC_CURRENCY_PRICE){
				$BASIC_PRICE = CCurrencyRates::ConvertCurrency($BASIC_PRICE, $BASIC_CURRENCY_PRICE, $arParams['ITEMS_CURRENCY']);
				$DISCOUNT_PRICE = CCurrencyRates::ConvertCurrency($DISCOUNT_PRICE, $BASIC_CURRENCY_PRICE, $arParams['ITEMS_CURRENCY']);
				$CURRENCY_PRICE = $arParams['ITEMS_CURRENCY'];
			}else{
				$CURRENCY_PRICE = $BASIC_CURRENCY_PRICE;
			}

			$arItems['PRICE'] = $DISCOUNT_PRICE;
			$arItems['PRICE_FORMATED'] = CurrencyFormat($DISCOUNT_PRICE, $CURRENCY_PRICE);
			$arItems['PRICE_CURRENCY'] = $CURRENCY_PRICE;
			
			if($BASIC_PRICE>$DISCOUNT_PRICE){
				$arItems['OLD_PRICE'] = $BASIC_PRICE;
				$arItems['OLD_PRICE_FORMATED'] = CurrencyFormat($BASIC_PRICE, $CURRENCY_PRICE);
			}

				
			$arInfo = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']); 
			if (is_array($arInfo)){
				$getOffers = GetList(array('id'=>'asc'),array('IBLOCK_ID' => $arInfo['IBLOCK_ID'], 'PROPERTY_'.$arInfo['SKU_PROPERTY_ID'] => $arFields['ID'],  "!PROPERTY_IS_HIDE_PRICE_VALUE" => "Y", 'ACTIVE' => 'Y' ), false, false, $arSelect);
				foreach ($getOffers as $arOffers){
					$arItemsOffers['ID'] = $arOffers['ID'];
					$arItemsOffers['NAME'] = $arOffers['NAME'];

					if($arOffers['PROPERTIES'][mb_strtoupper($arParams["ITEMS_IMAGES"])]['VALUE'][0]){
						$imgOffersID = $arOffers['PROPERTIES'][mb_strtoupper($arParams["ITEMS_IMAGES"])]['VALUE'][0];
						$imgOffers = CFile::GetPath($imgID);
					}elseif($arOffers['PREVIEW_PICTURE']){
						$imgOffersID = $arOffers['PREVIEW_PICTURE'];
						$imgOffers = CFile::GetPath($imgID);
					}elseif($arOffers['DETAIL_PICTURE']){
						$imgOffersID = $arOffers['DETAIL_PICTURE'];
						$imgOffers = CFile::GetPath($imgID);
					}else{
						$imgOffersID = '';
						$imgOffers = '';
					}
					$arItemsOffers['PICTURE_ID'] = $imgOffersID;
					$arItemsOffers['PICTURE'] = $imgOffers;

					$CURRENCY_PRICE_OFFERS = $arOffers['CATALOG_CURRENCY_'.mb_strtoupper($arParams['ITEMS_PRICE_CODE'])];
					$BASIC_PRICE_OFFERS = (int)$arOffers['CATALOG_PRICE_'.mb_strtoupper($arParams['ITEMS_PRICE_CODE'])]; 
		
					$arDiscounts = CCatalogDiscount::GetDiscountByProduct($arOffers['ID'], $USER->GetUserGroupArray(), "N", $arParams['ITEMS_PRICE_CODE']);
				        if(is_array($arDiscounts) && sizeof($arDiscounts) > 0) {
				        	$DISCOUNT_PRICE_OFFERS = CCatalogProduct::CountPriceWithDiscount($BASIC_PRICE_OFFERS, $CURRENCY_PRICE_OFFERS, $arDiscounts);
				        }else{
						$DISCOUNT_PRICE_OFFERS = $BASIC_PRICE;
					}

					$arItemsOffers['PRICE'] = $DISCOUNT_PRICE_OFFERS;
					$arItemsOffers['PRICE_FORMATED'] = CurrencyFormat($DISCOUNT_PRICE_OFFERS, $CURRENCY_PRICE_OFFERS);
					$arItemsOffers['PRICE_CURRENCY'] = $CURRENCY_PRICE_OFFERS;
						
					if($BASIC_PRICE_OFFERS>$DISCOUNT_PRICE_OFFERS){
						$arItemsOffers['OLD_PRICE'] = $BASIC_PRICE_OFFERS;
						$arItemsOffers['OLD_PRICE_FORMATED'] = CurrencyFormat($BASIC_PRICE_OFFERS, $CURRENCY_PRICE_OFFERS);
					}

					$arItemsOffers['PROPERTIES'] = $arOffers['PROPERTIES'];
				}
				$getOffers_first = array_shift($getOffers);
				if(!empty($getOffers_first)) {
					$BASIC_PRICE_OFFERS_FIRST = (int)$getOffers_first['CATALOG_PRICE_'.mb_strtoupper($arParams['ITEMS_PRICE_CODE'])]; 
					$BASIC_CURRENCY_PRICE_OFFERS_FIRST = $getOffers_first['CATALOG_CURRENCY_'.mb_strtoupper($arParams['ITEMS_PRICE_CODE'])];
					
					$arDiscounts_first = CCatalogDiscount::GetDiscountByProduct($getOffers_first['ID'], $USER->GetUserGroupArray(), "N", $arParams['ITEMS_PRICE_CODE']);
				        if(is_array($arDiscounts_first) && sizeof($arDiscounts_first) > 0) {
				        	$DISCOUNT_PRICE_OFFERS_FIRST = CCatalogProduct::CountPriceWithDiscount($BASIC_PRICE_OFFERS_FIRST, $BASIC_CURRENCY_PRICE_OFFERS_FIRST, $arDiscounts_first);
				        }else{
						$DISCOUNT_PRICE_OFFERS_FIRST = $BASIC_PRICE_OFFERS_FIRST;
					}
					
					if($arParams['ITEMS_CURRENCY'] && $arParams['ITEMS_CURRENCY']!=$BASIC_CURRENCY_PRICE_OFFERS_FIRST){
						$BASIC_PRICE_OFFERS_FIRST = CCurrencyRates::ConvertCurrency($BASIC_PRICE_OFFERS_FIRST, $BASIC_CURRENCY_PRICE_OFFERS_FIRST, $arParams['ITEMS_CURRENCY']);
						$DISCOUNT_PRICE_OFFERS_FIRST = CCurrencyRates::ConvertCurrency($DISCOUNT_PRICE_OFFERS_FIRST, $BASIC_CURRENCY_PRICE_OFFERS_FIRST, $arParams['ITEMS_CURRENCY']);
						$CURRENCY_PRICE_OFFERS_FIRST = $arParams['ITEMS_CURRENCY'];
					}else{
						$CURRENCY_PRICE_OFFERS_FIRST = $BASIC_CURRENCY_PRICE_OFFERS_FIRST;
					}

					$arItems['PRICE'] = $DISCOUNT_PRICE_OFFERS_FIRST;
					$arItems['PRICE_FORMATED'] = CurrencyFormat($DISCOUNT_PRICE_OFFERS_FIRST, $CURRENCY_PRICE_OFFERS_FIRST);
					$arItems['PRICE_CURRENCY'] = $CURRENCY_PRICE_OFFERS_FIRST;

					if($BASIC_PRICE_OFFERS_FIRST>$DISCOUNT_PRICE_OFFERS_FIRST){
						$arItems['OLD_PRICE'] = $BASIC_PRICE_OFFERS_FIRST;
						$arItems['OLD_PRICE_FORMATED'] = CurrencyFormat($BASIC_PRICE_OFFERS_FIRST, $CURRENCY_PRICE_OFFERS_FIRST);
					}
				}
			}

			$arItems['PROPERTIES'] = $arFields['PROPERTIES'];

            if ($bActive) {
                $arResult['ITEMS'][] = $arItems;
            }
			if($arParams["ITEMS_COUNT"]>0 && $arParams["ITEMS_COUNT"]<=($key+1)) break;
		}
		if(isset($arResult['ITEMS']) || is_countable($arResult['ITEMS'])){
			$arResult['ITEMS_COUNT'] = count($arResult['ITEMS']);
		}
		if(isset($arResult['SECTION_COUNT']) || is_countable($arResult['SECTION_COUNT'])){
			$arResult['SECTION_COUNT'] = count($arResult['SECTION']);
		}
		
		require_once($_SERVER['DOCUMENT_ROOT'].$template);
	}
}?>