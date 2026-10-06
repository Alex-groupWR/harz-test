<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['question'])) {
    $arData = [
        'fields' => [
            'TITLE' => 'Новый вопрос с формы "Обучение"',
            'NAME' => $_POST['name'],
            'EMAIL' => [['VALUE' => $_POST['email'], 'VALUE_TYPE' => 'WORK']],
            'COMMENTS' => $_POST['question'],
            'SOURCE_ID' => 'UC_YZJW7H'
        ]
    ];

    $webhookUrl = 'https://bx.2cifra.ru/rest/21/erjsgb5nzo0mpt3f/crm.lead.add.json';

    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $webhookUrl,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_POST => 1,
      CURLOPT_HEADER => 0,
      CURLOPT_RETURNTRANSFER => 1,      
   ));
   if(!empty($arData)){
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arData));
   }
   $response = curl_exec($ch);
    curl_close($ch);

    echo json_encode(['status' => 'success', 'data' => $response, 'payload' => $arData]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>