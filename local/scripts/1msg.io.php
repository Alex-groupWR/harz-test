<?php

function sendWANotification($sWAClientNumber, $sNumOrder, $sSumOrder, $sTrackNumber, $sTemplate) {
   // $url = 'https://api.1msg.io/406401/templates?token=off_CzMjyRATOv42QdnYmzO6DwIdAK'; // for get all templates
    $sURLSendTemlate = 'https://api.1msg.io/406401/sendTemplate?token=off_CzMjyRATOv42QdnYmzO6DwIdAK'; //for send template
    $headers = ['Content-Type: application/json'];

    $arParams = array();

    $sPhone = preg_replace('/\D/', '', $sWAClientNumber);

    if (substr($sPhone, 0, 1) == '8') {
        $sPhone = '7' . substr($sPhone, 1, strlen($sPhone) - 1);
    }

    if (strlen($sPhone) !== 11 && substr($sPhone, 0, 1) !== '7') {
        return false;
    }

    switch ($sTemplate) {
        case 'RussiaNewOrder':
            //russia_neworder
            $arParams = [
                'template' => 'russia_neworder',
                'phone' => $sPhone,
                'language' => array(
                    'policy' => 'deterministic',
                    'code' => 'ru'
                ),
                'namespace' => '9f6c7146_4500_4602_b659_5c6ed23ad873',
                'params' => array(
                    array(
                        'type' => 'body',
                        'parameters' => array(
                            array(
                                'type' => 'text',
                                'text' => $sNumOrder
                            ),
                            array(
                                'type' => 'text',
                                'text' => $sSumOrder
                            ),
                        )
                    )
                ),
            ];
            break;
        case 'RussiaInvoice':
            //russia_invoice
            $arParams = [
                'template' => 'russia_invoice1',
                'phone' => $sPhone,
                'language' => array(
                    'policy' => 'deterministic',
                    'code' => 'ru'
                ),
                'namespace' => '9f6c7146_4500_4602_b659_5c6ed23ad873',
                'params' => array(
                    array(
                        'type' => 'body',
                        'parameters' => array(
                            array(
                                'type' => 'text',
                                'text' => $sNumOrder
                            ),
                        )
                    )
                ),
            ];
            break;
        case 'RussiaPickup':
            //russia_invoice
            $arParams = [
                'template' => 'russia_pickup1',
                'phone' => $sPhone,
                'language' => array(
                    'policy' => 'deterministic',
                    'code' => 'ru'
                ),
                'namespace' => '9f6c7146_4500_4602_b659_5c6ed23ad873',
                'params' => array(
                    array(
                        'type' => 'body',
                        'parameters' => array(
                            array(
                                'type' => 'text',
                                'text' => $sNumOrder
                            ),
                        )
                    )
                ),
            ];
            break;
        case 'RussiaCollectedWaitDK':
            //russia_collected_wait_dk
            $arParams = [
                'template' => 'russia_collected_wait_dk',
                'phone' => $sPhone,
                'language' => array(
                    'policy' => 'deterministic',
                    'code' => 'ru'
                ),
                'namespace' => '9f6c7146_4500_4602_b659_5c6ed23ad873',
                'params' => array(
                    array(
                        'type' => 'body',
                        'parameters' => array(
                            array(
                                'type' => 'text',
                                'text' => $sNumOrder
                            ),
                            array(
                                'type' => 'text',
                                'text' => $sSumOrder
                            ),
                        )
                    )
                ),
            ];
            break;
        case 'RussiaSendDK':
            //russia_send_dk
            $arParams = [
                'template' => 'russia_send_dk1',
                'phone' => $sPhone,
                'language' => array(
                    'policy' => 'deterministic',
                    'code' => 'ru'
                ),
                'namespace' => '9f6c7146_4500_4602_b659_5c6ed23ad873',
                'params' => array(
                    array(
                        'type' => 'body',
                        'parameters' => array(
                            array(
                                'type' => 'text',
                                'text' => $sNumOrder
                            ),
                            array(
                                'type' => 'text',
                                'text' => $sSumOrder
                            ),
                            array(
                                'type' => 'text',
                                'text' => $sTrackNumber
                            ),
                        )
                    )
                ),
            ];
            break;
    }

    if (!empty($arParams)) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arParams)); // здесь массив с шаблоном
        curl_setopt($ch, CURLOPT_URL, $sURLSendTemlate);
        curl_setopt($ch, CURLOPT_POST, true);

        $resWANotification = curl_exec($ch);

        curl_close($ch);

        return $resWANotification;
    }
    return false;
}