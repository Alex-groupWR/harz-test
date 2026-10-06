<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/class/cRest.php');

if (isset($_POST['COMMENT'])) {
    $sComment = json_decode($_POST['COMMENT']);
    $sRecaptchaSecret = '6LdYikErAAAAAPkCH9lF-HckVYQXJFr5hGtU-HQn';
    $sRecaptchaToken = $_POST['recaptcha_token'] ?? '';
    $bCheckCaptcha = false;
    $arRecaptchaResult = array();

    $arFields = array(
        'TITLE' => $_POST['TITLE'] ? $_POST['TITLE'] : 'Оцените качество нашего сервиса',
        //'COMMENTS' => $sComment,
        'ASSIGNED_BY_ID' => 7
    );

    if (isset($_POST['FIELDS'])) {
        $arPostFields = json_decode($_POST['FIELDS']);

        foreach ($arPostFields as $key => $arPostField) {
            if ($key == 'EMAIL' || $key == 'PHONE') {
                $arFields[$key] = array(json_decode($arPostField, true));
            } else {
                $arFields[$key] = $arPostField;
            }
        }
    }

    $arFiles = [];
    $arFile = [];
    if (!empty($_FILES['FILES']['tmp_name']) && is_array($_FILES['FILES']['tmp_name'])) {
        foreach ($_FILES['FILES']['tmp_name'] as $k => $path) {
            $arFiles[] = [
                "fileData" => [
                    $_FILES['FILES']['name'][$k],
                    base64_encode(file_get_contents($path))
                ]
            ];
        }
    }

    $arFields['UF_CRM_1647434668572'] = $arFiles;

    if (isset($sRecaptchaToken)) {
        $arData = [
            'secret' => $sRecaptchaSecret,
            'response' => $sRecaptchaToken
        ];

        $arPost = http_build_query($arData);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $arPost);
        $res = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($res, true);
        $arRecaptchaResult = $response;

        if (!$response['success'] || $response['score'] < 0.5) {
            $bCheckCaptcha = false;
        } else {
            $bCheckCaptcha = true;
        }
    } else {
        $bCheckCaptcha = true;
    }

    if ($bCheckCaptcha) {
        $arLID = CRest::call(
            'crm.lead.add',
            [
                'fields' => $arFields
            ]);
    }

    if (isset($arLID) && !empty($arLID['result'])) {
        if (!empty($arRecaptchaResult)) {
            echo json_encode(array('res' => true, 'recaptcha' => $arRecaptchaResult));
        } else {
           echo json_encode(true);
        }
    } else {
        if (!empty($arRecaptchaResult)) {
            echo json_encode(array('res' => false, 'recaptcha' => $arRecaptchaResult));
        } else {
            echo json_encode(false);
        }
    }
} else {
    echo json_encode(false);
}