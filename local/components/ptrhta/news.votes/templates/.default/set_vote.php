<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
if (isset($_REQUEST["iblockId"]) && isset($_REQUEST["elementId"])) {
    $elementID = $_REQUEST["elementId"];
    $iblockID = $_REQUEST["iblockId"];
    $elem =  $_REQUEST["elem"];
    $arSelect = Array("ID", "NAME", "PROPERTY_YES_COUNTER", "PROPERTY_NO_COUNTER");
    $arFilter = Array("IBLOCK_ID"=>$iblockID, "ID" => $elementID);
    $iCounter = 0;
    $sPropertyName = "NO_COUNTER";
    if(CModule::IncludeModule("iblock")) {
        $res = CIBlockElement::GetList(array(), $arFilter, false, array(), $arSelect);
        while ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            if ($elem == "Yes" || $elem == "Да") {
                $iCounter = (int)$arFields["PROPERTY_YES_COUNTER_VALUE"] + 1;
                $sPropertyName = "YES_COUNTER";
            } else {
                $iCounter = (int)$arFields["PROPERTY_NO_COUNTER_VALUE"] + 1;
            }
        }
    }

    CIBlockElement::SetPropertyValueCode($elementID, $sPropertyName, $iCounter);
    $res = CIBlockElement::GetList(array(), $arFilter, false, array(), $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        echo $arFields["PROPERTY_" . $sPropertyName . "_VALUE"];
    }

    /* --- НАЧАЛО ПАРАЛЛЕЛЬНОЙ ОБРАБОТКИ ЧЕРЕЗ CURL --- */
    if (CModule::IncludeModule("iblock")) {
        // Дополнительно запрашиваем DETAIL_PAGE_URL для генерации ссылки
        $arApiSelect = array("ID", "NAME", "DETAIL_PAGE_URL");
        $apiRes = CIBlockElement::GetList(array(), $arFilter, false, array(), $arApiSelect);
        if ($apiOb = $apiRes->GetNextElement()) {
            $arApiFields = $apiOb->GetFields();

            // Текст ответа
            $userAnswer = ($elem == "Yes" || $elem == "Да") ? "Да" : "Нет";

            // Собираем полную ссылку на статью сайта
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $elementUrl = $protocol . $_SERVER['HTTP_HOST'] . $arApiFields["DETAIL_PAGE_URL"];

            // Текст уведомления (BB-коды поддерживаются в чатах Б24)
            $messageText = "📢 Получен отзыв о статье\n";
            $messageText .= "📄 Статья: [URL=" . $elementUrl . "]" . $arApiFields["NAME"] . "[/URL] (ID: " . $elementID . ")\n";
            $messageText .= "👤 Ответ пользователя: " . $userAnswer;

            // Настройки для вебхука
            $webhookUrl = 'https://bx.harzlabs.ru/rest/530/fsohw1xkc450b07z/im.message.add';

            $postData = array(
                'DIALOG_ID' => 'chat21877', // ⚠️ ЗАМЕНИТЕ НА ID ВАШЕГО ЧАТА (например chat45) ИЛИ ID ПОЛЬЗОВАТЕЛЯ
                'MESSAGE'   => $messageText,
                'SYSTEM'    => 'N'
            );

            // Отправка через cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $webhookUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3); // Защита от зависания скрипта
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // На случай проблем с SSL-сертификатами

            curl_exec($ch);
            curl_close($ch);
        }
    }
    /* --- КОНЕЦ ПАРАЛЛЕЛЬНОЙ ОБРАБОТКИ --- */
}
?>
