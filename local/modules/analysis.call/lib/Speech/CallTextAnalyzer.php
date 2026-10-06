<?php
namespace Analysis\Call\Speech;

use Exception;

class CallTextAnalyzer
{
    private $apiKey;
    private $folderId;
    private $text;

    public function __construct($apiKey, $folderId)
    {
        $this->apiKey = $apiKey;
        $this->folderId = $folderId;
    }

    /**
     * Загрузка текста для анализа
     */
    public function loadText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Анализ текста звонка через YandexGPT
     */
    public function analyzeCall()
    {
        if (empty($this->text)) {
            return ['error' => "No text loaded for analysis"];
        }

        $prompt = $this->buildPrompt($this->text);

        $requestData = [
            'modelUri' => "gpt://{$this->folderId}/yandexgpt",
            'completionOptions' => [
                'stream' => false,
                'temperature' => 0.1,
                'maxTokens' => 500
            ],
            'messages' => [
                [
                    'role' => 'user',
                    'text' => $prompt
                ]
            ]
        ];

        $jsonData = json_encode($requestData, JSON_UNESCAPED_UNICODE);

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://llm.api.cloud.yandex.net/foundationModels/v1/completion',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => [
                'Authorization: Api-Key ' . $this->apiKey,
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData)
            ],
            CURLOPT_TIMEOUT => 60
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        curl_close($ch);

        if ($response === false) {
            return ['error' => "cURL error: " . $curlError];
        }

        $responseData = json_decode($response, true);

        if ($httpCode !== 200) {
            $errorMessage = $responseData['message'] ?? $responseData['error']['message'] ?? 'Unknown error';
            return ['error' =>"YandexGPT API error (HTTP {$httpCode}): " . $errorMessage];
        }

        return $this->parseAnalysisResult($responseData);
    }

    /**
     * Формирование промпта для анализа
     */
    private function buildPrompt($text)
    {
        return "Проанализируй текст звонка и ответь строго в формате JSON:

{$text}

Критерии (ответь только 'да' или 'нет'):
- Приветствие (greeting): «да», если оператор произнёс фразу типа «Здравствуйте», «Добрый день», «Приветствую вас». «нет», если приветствия не было.
- Сотрудник представился (introduction): «да», если прозвучали имя сотрудника. «нет», если представление отсутствовало или было неполным.
- Развернутые ответы (detailed_answers): «да», если ответы содержат пояснения, альтернативы или примеры. «нет», если ответы односложные («да», «нет», «не знаю»).
- Вежливость (politeness): «да», если прозвучали вежливые слова: «пожалуйста», «спасибо», «будьте добры», «благодарю», «извините» и другие.
- Нет перебиваний (no_interruptions): «да», если оператор даёт клиенту завершить мысль до ответа.
- Прощание (farewell): «да», если произносит фразу прощания: «До свидания», «Всего доброго», «Хорошего дня» и и другие.

Ответ должен быть только в JSON формате без дополнительного текста или markdown:
{
  \"greeting\": \"да/нет\",
  \"introduction\": \"да/нет\", 
  \"detailed_answers\": \"да/нет\",
  \"politeness\": \"да/нет\", 
  \"no_interruptions\": \"да/нет\",
  \"farewell\": \"да/нет\"
}";
    }

    /**
     * Парсинг результата анализа
     */
    private function parseAnalysisResult($responseData)
    {
        // Проверяем структуру ответа
        if (!isset($responseData['result']['alternatives'][0]['message']['text'])) {
            return ['error' =>"No analysis result received"];
        }

        $analysisText = $responseData['result']['alternatives'][0]['message']['text'];

        // Очищаем от markdown и лишних символов
        $analysisText = $this->cleanJsonResponse($analysisText);

        // Парсим JSON
        $analysis = json_decode($analysisText, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['error' =>"Failed to parse analysis JSON: " . json_last_error_msg()];
        }

        // Проверяем наличие всех необходимых полей
        $requiredFields = ['greeting', 'introduction', 'detailed_answers', 'politeness', 'no_interruptions', 'farewell'];
        foreach ($requiredFields as $field) {
            if (!isset($analysis[$field])) {
                $analysis[$field] = 'нет данных';
            }
        }

        return $analysis;
    }

    /**
     * Очистка JSON ответа от markdown и лишних символов
     */
    private function cleanJsonResponse($text)
    {
        // Удаляем markdown обрамление ```json и ```
        $text = preg_replace('/```(?:json)?\s*/', '', $text);
        $text = preg_replace('/\s*```/', '', $text);

        // Удаляем лишние пробелы и переносы
        $text = trim($text);

        // Заменяем кавычки если нужно
        $text = str_replace(['“', '”', '‘', '’'], '"', $text);

        // Удаляем BOM если есть
        $text = preg_replace('/^\xEF\xBB\xBF/', '', $text);

        // Удаляем все символы перед первой { и после последней }
        if (strpos($text, '{') !== false && strpos($text, '}') !== false) {
            $start = strpos($text, '{');
            $end = strrpos($text, '}') + 1;
            $text = substr($text, $start, $end - $start);
        }

        return $text;
    }

    /**
     * Вывод результатов анализа в виде таблицы
     */
    public static function displayAnalysisTable($analysis)
    {
        $criteria = [
            'greeting' => 'Приветствие',
            'introduction' => 'Сотрудник представился',
            'detailed_answers' => 'Развернутые ответы',
            'politeness' => 'Вежливость',
            'no_interruptions' => 'Нет перебиваний',
            'farewell' => 'Прощание'
        ];

        echo "\n" . str_repeat("=", 60) . "\n";
        echo "РЕЗУЛЬТАТЫ АНАЛИЗА ЗВОНКА\n";
        echo str_repeat("=", 60) . "\n";

        foreach ($criteria as $key => $label) {
            $value = $analysis[$key] ?? 'нет данных';
            printf("%-35s | %s\n", $label, strtoupper($value));
        }

        echo str_repeat("=", 60) . "\n";
    }

    /**
     * Упрощенный метод для получения результатов в виде массива
     */
    public function getAnalysisResult($text)
    {
        $this->loadText($text);
        return $this->analyzeCall();
    }
}