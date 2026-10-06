<?php

$_SERVER["DOCUMENT_ROOT"] = '/var/www/vhosts/harzlabs.ru/httpdocs';
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];


define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define('BX_NO_ACCELERATOR_RESET', true);
define('BX_CRONTAB', true);
define('STOP_STATISTICS', true);
define('NO_AGENT_STATISTIC', 'Y');
define('DisableEventsCheck', true);


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

@set_time_limit(0);
@ignore_user_abort(true);


$serviceId = 107;
$result = \Bitrix\Sale\Delivery\Services\Manager::update($serviceId, [
    'ACTIVE' => 'N'
]);

?>