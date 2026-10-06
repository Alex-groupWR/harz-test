<?php

function custom_mail($to, $subject, $message, $additionalHeaders = '')
{
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = 0;

    $mail->Host = 'smtp.yandex.ru';
    $mail->Port = 465;
    $mail->Username = 'info@harzlabs.ru';
    $mail->Password = 'wmxiswwedstswjni';
    $mail->SMTPSecure = 'ssl';

    $mail->IsHTML = true;
    $mail->CharSet = 'UTF-8';

    $to = str_replace(' ', '', $to);
    $address = explode(',', $to);
    foreach ($address as $addr)
        $mail->addAddress($addr);


    $mail->ContentType = 'text/html';
    //$mail->ContentType = $mail::CONTENT_TYPE_MULTIPART_ALTERNATIVE;

    $headers = explode("\n", $additionalHeaders);
    $attachHeader = 'Content-Type: multipart/mixed; boundary=';
    foreach( $headers as $h )
    {
        if( stripos($h, $attachHeader) === 0 )
        {
            $bndr = substr($h, strlen($attachHeader));
            $bndr = trim($bndr, '"');
            $mail->ContentType = 'multipart/mixed; boundary="' . $bndr . '"';
        }
    }

    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->From = 'info@harzlabs.ru';
    $mail->send();


    return true;
}

function switchDostavista($iSemafore)
{
    \CModule::IncludeModule("sale");

    switch ($iSemafore) {
        case 1:
            $arFields = ['ACTIVE' => 'Y'];
            break;
        case 0:
            $arFields = ['ACTIVE' => 'N'];
            break;
    }

    \Bitrix\Sale\Delivery\Services\Manager::update(107, $arFields);

    return 'switchDostavista(' . $iSemafore . ');';
}

// функция для переключения статусов сделки в регулярных заданиях
// двигаем статус вверх, чтобы сработали роботы в сделке, и сделка начала грузиться в 1C
function moveCRMstatus()
{
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/class/cRest.php');
    define('C_REST_WEB_HOOK_URL', 'https://bx.harzlabs.ru/rest/527/n4wpc17084unfgq3/');


    $arResult = CRest::call('crm.deal.list',
        [
            'filter' => [
                'STAGE_ID' => 2,
                '>=ID' => 16733
            ],
        ]);

    if (count($arResult['result']) > 0) {
        foreach ($arResult['result'] as $arDeal) {
            $arResult = CRest::call('crm.deal.update',
                [
                    'id' => $arDeal['ID'],
                    'fields' => ['STAGE_ID' => 1], // создана в 1С
                ]);
        }
    }

    return 'moveCRMstatus();';
}

function sendWhatsappRequest($sMode, $sCommand, $arPOST = [], $sLine)
{
    switch ($sLine){
        case 'SALES':
            $sServer = 'api.1msg.io/VAN837873618';
            $sToken = 'Dyn6F7hs4U8hAOs3nKnDM1p80dX4xI2v';
            break;
        case 'SUPPORT':
            $sServer = 'api.1msg.io/406401';
            $sToken = 'off_CzMjyRATOv42QdnYmzO6DwIdAK';
            break;
    }

    $sCURLString = 'https://' . $sServer . '/' . $sMode . '?token=' . $sToken . $sCommand;

    $ch = curl_init($sCURLString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);

    if ($arPOST) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arPOST));
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $cResult = curl_exec($ch);
    curl_close($ch);

    $arCURLResult = json_decode($cResult, 1);
    $arCURLResult['connection_string'] = $sCURLString;

    return $arCURLResult;
}