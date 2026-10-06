<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
global $USER;
$iCurrentUser = $USER->GetID();

$iAccess = $USER->IsAdmin() || $iCurrentUser == 41;

echo json_encode($iAccess)
?>