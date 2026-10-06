<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode( true );

if ($arParams['INCLUDE_JQUERY'] == 'Y' ){ CJSCore::Init(Array('jquery'));}

if (!function_exists("getComponentID")){
	function getComponentID(){
	   static $indexID = 0;
	   $indexID++;
	   return $indexID;
	}
}
$arParams['ID'] = getComponentID();

$this->IncludeComponentTemplate();?>
