<?php
// Файл вашего вебхука
define('NOT_CHECK_PERMISSIONS', true);
define('BX_NO_ACCELERATOR_RESET', true);

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Diag\Debug;

// Логируем абсолютно все входящие вебхуки по оплатам
Debug::writeToFile(
    "Входящий вебхук: " . json_encode($_REQUEST['data']['FIELDS'] ?? []),
    'OnSaleOrderPaid INCOMING ' . date('Y-m-d H:i:s'),
    '/local/php_interface/sale_order_paid.log'
);

if (isset($_REQUEST['event']) && $_REQUEST['event'] === 'ONPAYMENTENTITYSAVED') {
    $paymentId = (int)($_REQUEST['data']['FIELDS']['ID'] ?? 0);

    if ($paymentId > 0) {
        // Вычисляем время старта: текущее время + 5 минут (300 секунд)
        $startTime = ConvertTimeStamp(time() + 300, "FULL");

        // Регистрируем агент в базе данных. Он проверит статус позже.
        \CAgent::AddAgent(
            "runDeferredPaymentWorkflow({$paymentId});", 
            "main",                                      
            "N",                                         
            0,                                           
            "",                                          
            "Y",                                         
            $startTime                                   
        );

        Debug::writeToFile(
            "Вебхук: Создан агент для проверки оплаты №{$paymentId} на время {$startTime}", 
            'OnSaleOrderPaid AGENT_CREATED ' . date('Y-m-d H:i:s'), 
            '/local/php_interface/sale_order_paid.log'
        );
        
        die('OK');
    }
}
