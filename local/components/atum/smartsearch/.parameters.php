<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
	use Bitrix\Main\ModuleManager,
	Bitrix\Main\Loader,
	Bitrix\Main\Web\Json,
	Bitrix\Iblock,
	Bitrix\Catalog,
	Bitrix\Currency;

	if(!CModule::IncludeModule("iblock")) return;
	$catalogIncluded = Loader::includeModule('catalog');

	$arIBlockType = CIBlockParameters::GetIBlockTypes();

	$arIBlock = array();
	$iblockFilter = !empty($arCurrentValues['IBLOCK_TYPE'])? array('TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE' => 'Y'): array('ACTIVE' => 'Y');
	$rsIBlock = CIBlock::GetList(array('SORT' => 'ASC'), $iblockFilter);
	while ($arr = $rsIBlock->Fetch()){
		$id = (int)$arr['ID'];
		if (isset($offersIblock[$id])) continue;
		$arIBlock[$id] = '['.$id.'] '.$arr['NAME'];
	}
	
	$arSort = CIBlockParameters::GetElementSortFields(
		array('SHOWS', 'SORT', 'TIMESTAMP_X', 'NAME', 'ID', 'ACTIVE_FROM', 'ACTIVE_TO'),
		array('KEY_LOWERCASE' => 'Y')
	);
	
	if ($catalogIncluded){
		$arSort = array_merge($arSort, CCatalogIBlockParameters::GetCatalogSortFields());
		if (isset($arSort['CATALOG_AVAILABLE'])) unset($arSort['CATALOG_AVAILABLE']);
	}
	
	$arAscDesc = array(
		'asc' => GetMessage('IBLOCK_SORT_ASC'),
		'desc' => GetMessage('IBLOCK_SORT_DESC'),
	);

	$arComponentParameters = array(
		"GROUPS" => array(
			"SEARCH" => array(
				"NAME" => GetMessage("SEARCH"),
				"SORT" => 650
			),
			"ITEM" => array(
				"NAME" => GetMessage("ITEM"),
				"SORT" => 660
			),
			'SORT_SETTINGS' => array(
				'NAME' => GetMessage('SORT_SETTINGS'),
				'SORT' => 670
			),
		),
		"PARAMETERS" => array(
			'ELEMENT_SORT_FIELD' => array(
				'PARENT' => 'SORT_SETTINGS',
				'NAME' => GetMessage('IBLOCK_ELEMENT_SORT_FIELD'),
				'TYPE' => 'LIST',
				'VALUES' => $arSort,
				'ADDITIONAL_VALUES' => 'Y',
				'DEFAULT' => 'sort',
			),
			'ELEMENT_SORT_ORDER' => array(
				'PARENT' => 'SORT_SETTINGS',
				'NAME' => GetMessage('IBLOCK_ELEMENT_SORT_ORDER'),
				'TYPE' => 'LIST',
				'VALUES' => $arAscDesc,
				'DEFAULT' => 'asc',
				'ADDITIONAL_VALUES' => 'Y',
			),
			'ELEMENT_SORT_FIELD2' => array(
				'PARENT' => 'SORT_SETTINGS',
				'NAME' => GetMessage('IBLOCK_ELEMENT_SORT_FIELD2'),
				'TYPE' => 'LIST',
				'VALUES' => $arSort,
				'ADDITIONAL_VALUES' => 'Y',
				'DEFAULT' => 'id',
			),
			'ELEMENT_SORT_ORDER2' => array(
				'PARENT' => 'SORT_SETTINGS',
				'NAME' => GetMessage('IBLOCK_ELEMENT_SORT_ORDER2'),
				'TYPE' => 'LIST',
				'VALUES' => $arAscDesc,
				'DEFAULT' => 'desc',
				'ADDITIONAL_VALUES' => 'Y',
			),
			"INCLUDE_JQUERY" => array(
				"PARENT" => "BASE",
				"NAME" => GetMessage("INCLUDE_JQUERY"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "N",
			),
			'IBLOCK_TYPE' => array(
				'PARENT' => 'BASE',
				'NAME' => GetMessage('IBLOCK_TYPE'),
				'TYPE' => 'LIST',
				'VALUES' => $arIBlockType,
				'REFRESH' => 'Y',
			),
			"IBLOCK_ID" => array(
				"PARENT" => "BASE",
				"NAME" => GetMessage("IBLOCK_ID"),
				"TYPE" => "LIST",
				"VALUES" => $arIBlock,
				"REFRESH" => "Y",
				"ADDITIONAL_VALUES" => "Y",
			),
/*SEARCH------------------------------------------------*/
			"SEARCH_MIN_CHARS" => array(
				"PARENT" => "SEARCH",
				"NAME" => GetMessage("SEARCH_MIN_CHARS"),
				"TYPE" => "STRING",
				"DEFAULT" => "3",
			),
			"SEARCH_PAGE" => array(
				"PARENT" => "SEARCH",
				"NAME" => GetMessage("SEARCH_PAGE"),
				"TYPE" => "STRING",
				"DEFAULT" => "/search",
			),
			"SEARCH_BY" => array(
				"PARENT" => "SEARCH",
				"NAME" => GetMessage("SEARCH_BY"),
				"TYPE" => "LIST",
				"VALUES" => array(
					'1'=>GetMessage("ATUM_SMARTSEARCH_NAZVANIU"),
					'2'=>GetMessage("ATUM_SMARTSEARCH_NAZVANIU_I_OPISANIU"),
				),
			),	
			"SEARCH_SHOW_SECTIONS" => array(
				"PARENT" => "SEARCH",
				"NAME" => GetMessage("SEARCH_SHOW_SECTIONS"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "Y",
			),
			"SEARCH_BY_ARTICLE" => array(
				"PARENT" => "SEARCH",
				"NAME" => GetMessage("SEARCH_BY_ARTICLE"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "Y",
				"REFRESH" => "Y",
			),
			"SEARCH_ONLY_WITH_PICTURE" => array(
				"PARENT" => "SEARCH",
				"NAME" => GetMessage("SEARCH_ONLY_WITH_PICTURE"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "N",
			),
			"SEARCH_ONLY_AVAILABLE" => array(
				"PARENT" => "SEARCH",
				"NAME" => GetMessage("SEARCH_ONLY_AVAILABLE"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "N",
			),
			"SEARCH_ONLY_WITH_PRICE" => array(
				"PARENT" => "SEARCH",
				"NAME" => GetMessage("SEARCH_ONLY_WITH_PRICE"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "N",
			),
/*ITEM--------------------------------------------------*/
			"ITEMS_COUNT" => array(
				"PARENT" => "ITEM",
				"NAME" => GetMessage("ITEMS_COUNT"),
				"TYPE" => "STRING",
				"DEFAULT" => "8",
			),
			"ITEMS_COUNT_NAV" => array(
				"PARENT" => "ITEM",
				"NAME" => GetMessage("ITEMS_COUNT_NAV"),
				"TYPE" => "STRING",
				"DEFAULT" => "4",
			),

		),
	);
	$arFields = array();
	$properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
	while ($prop_fields = $properties->GetNext()){
		$arFields[$prop_fields["CODE"]] =  $prop_fields["NAME"]." [".$prop_fields["CODE"]."]";
		if($prop_fields["PROPERTY_TYPE"] == "F"){
			$arFields_img[$prop_fields["CODE"]] =  $prop_fields["NAME"]." [".$prop_fields["CODE"]."]";
		}

	}
	$arComponentParameters['PARAMETERS']['SEARCH_ARTICLE_PROPERTY'] = array(
		"PARENT" => "SEARCH",
		"NAME" => GetMessage("SEARCH_ARTICLE_PROPERTY"),
		"TYPE" => "LIST",
		"VALUES" => $arFields,
		"ADDITIONAL_VALUES" => "Y",
	);
	$arComponentParameters['PARAMETERS']['ITEMS_IMAGES'] = array(
		"PARENT" => "ITEM",
		"NAME" => GetMessage("ITEMS_IMAGES"),
		"TYPE" => "LIST",
		"VALUES" => $arFields_img,
		"ADDITIONAL_VALUES" => "Y",
	);

	if ($catalogIncluded){
		$arPrices = array();
		$dbPrices = CCatalogGroup::GetList(Array('ID' => 'ASC'), Array(), false, false, Array('ID','NAME'));
		while ( $arPrice = $dbPrices->Fetch()){
			$arPrices[$arPrice['ID']] = $arPrice['NAME'] . ' [' . $arPrice['ID'] . ']';
		}
		$arComponentParameters['PARAMETERS']['ITEMS_PRICE_CODE'] = array(
			"PARENT" => "ITEM",
			"NAME" => GetMessage("ITEMS_PRICE_CODE"),
			"TYPE" => "LIST",
			"VALUES" => $arPrices,
			"ADDITIONAL_VALUES" => "Y",
		);

		if (CModule::IncludeModule( 'currency' )){
			$arCurrencies = array();
			$dbCurrencies = CCurrency::GetList( $by = 'sort', $order = 'asc');

			while ( $arCurrency = $dbCurrencies->Fetch() ){
				$arCurrencies[$arCurrency['CURRENCY']] = $arCurrency['FULL_NAME'];
			}
			$arComponentParameters['PARAMETERS']['ITEMS_CURRENCY'] = array(
				"PARENT" => "ITEM",
				"NAME" => GetMessage("ITEMS_CURRENCY"),
				"TYPE" => "LIST",
				"VALUES" => $arCurrencies,
				"ADDITIONAL_VALUES" => "Y",
			);
		}
	}
?>