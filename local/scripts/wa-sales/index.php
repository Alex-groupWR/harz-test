<?
define("STOP_STATISTICS", true);
define("PUBLIC_AJAX_MODE", true);
define("NO_KEEP_STATISTIC", true);
define("STATISTIC_SKIP_ACTIVITY_CHECK", true);
define("NOT_CHECK_PERMISSIONS", true);
define('BX_SESSION_ID_CHANGE', false);
define('BX_SKIP_POST_UNQUOTE', false);
define('NO_AGENT_CHECK', true);
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

require_once('functions.php');

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


$json = file_get_contents('php://input');
$decoded = json_decode($json, true);
$sMessage = 'Произошла ошибка, данные не получены';

foreach ($decoded['messages'] as $arWAMessage) {
	if ($arWAMessage['self'] === 0) {
		$sWAmessageID = $arWAMessage ['id'];
		$chatID = $arWAMessage['chatId'];

		$connector_id = getConnectorID();
		$line_id = getLine();

		$arMessage = [
			'id' => $sWAmessageID,
			'user' => [
				'id' => $chatID,
				'name' => htmlspecialchars($arWAMessage['senderName']),
			],
			'message' => [
				'id' => false,
				'date' => time(),
				'text' => htmlspecialchars($arWAMessage['body']),
			],
			'chat' => [
				'id' => $chatID,
				'url' => htmlspecialchars('WA'),
			],
		];

		$result = CRest::call(
			'imconnector.send.messages',
			[
				'CONNECTOR' => $connector_id,
				'LINE' => $line_id,
				'MESSAGES' => [$arMessage],
			]
		);
	}
}

die();
?>
