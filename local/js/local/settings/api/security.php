<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    define("NO_KEEP_STATISTIC", true);
    require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
}

function checkCsrfToken() {
    if (!check_bitrix_sessid()) {
        http_response_code(403);
        die(json_encode(['error' => 'Security check failed']));
    }
    return true;
}

function checkAuthorization() {
    global $USER;
    if (!$USER->IsAuthorized()) {
        http_response_code(401);
        die(json_encode(['error' => 'Authentication required']));
    }
    return true;
}

function checkAccessRights() {
    global $USER;
    $iCurrentUser = $USER->GetID();
    $iAccess = $USER->IsAdmin() || $iCurrentUser == 41;

    if (!$iAccess) {
        die(json_encode(['error' => 'Access denied']));
    }
    return true;
}

function checkAccess() {
    //checkCsrfToken();
    checkAuthorization();
    checkAccessRights();
    return true;
}

