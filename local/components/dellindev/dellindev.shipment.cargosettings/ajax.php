<?
/**
 * Bitrix Framework
 * @global CMain $APPLICATION
 */

define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_STATISTIC", true);
define("NO_AGENT_CHECK", true);
define("NOT_CHECK_PERMISSIONS", true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

$result = array("ERROR" => "");

if (!\Bitrix\Main\Loader::includeModule('sale'))
	$result["ERROR"] = "Error! Can't include module \"Sale\"";

\Bitrix\Sale\Delivery\Services\Manager::getHandlersList();
$saleModulePermissions = $APPLICATION->GetGroupRight("sale");

if($result["ERROR"] == '' && $saleModulePermissions >= "W" && check_bitrix_sessid())
{
	$action = isset($_REQUEST['action']) ? trim($_REQUEST['action']): '';


	$result = $action;

}
else
{
	if($result["ERROR"] == '')
		$result["ERROR"] = "Error! Access denied";
}

if($result["ERROR"] <> '')
	$result["RESULT"] = "ERROR";
else
	$result["RESULT"] = "OK";

if(mb_strtolower(SITE_CHARSET) != 'utf-8')
	$result = \Bitrix\Main\Text\Encoding::convertEncoding($result, SITE_CHARSET, 'utf-8');

header('Content-Type: application/json');
echo  json_encode($result);
\CMain::FinalActions();
die;