
<?php
define("NO_KEEP_STATISTIC", true);
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

global $USER;
if (!$USER->IsAuthorized()) {
    http_response_code(401);
    die(json_encode(['error' => 'Authentication required']));
}

$iCurrentUser = $USER->GetID();
$iAccess = $USER->IsAdmin() || $iCurrentUser == 41;

if (!$iAccess) {
    http_response_code(403);
    die(json_encode(['error' => 'Access denied']));
}

$target_dir = $_SERVER["DOCUMENT_ROOT"] . "/local/js/local/settings/api/files/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);

$arUpload = array(
    'files' => $_FILES,
    'is_upload' => move_uploaded_file($_FILES["file"]["tmp_name"], $target_file),
    'target_file' => $target_file
);

echo json_encode($arUpload);
?>