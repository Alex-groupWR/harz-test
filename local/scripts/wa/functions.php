<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/class/cRest.php');

define('WA_STORAGE', $_SERVER['DOCUMENT_ROOT'].'/local/scripts/wa/storage');


function getConnectorID()
{
	return 'HarzLabs_WA_Connector';
}

function getChat($chatID)
{
	$result = [];
	if (file_exists(WA_STORAGE . '/chats/' . $chatID . '.txt')) {
		$result = json_decode(file_get_contents(WA_STORAGE . '/chats/' . $chatID . '.txt'), 1);
	}

	return $result;
}

function saveMessage($chatID, $arMessage)
{
	$arMessages = getChat($chatID);
	$count = count($arMessages);
	$arMessages['message' . $count] = $arMessage;
	if (file_put_contents(WA_STORAGE . '/chats/' . $chatID . '.txt', json_encode($arMessages))) {
		$return = $count;
	} else {
		$return = false;
	}

	return $return;
}

function getLine()
{
	return file_get_contents(WA_STORAGE . '/line_id.txt');
}

function setLine($line_id)
{
	return file_put_contents(WA_STORAGE . '/line_id.txt', intVal($line_id));
}

?>