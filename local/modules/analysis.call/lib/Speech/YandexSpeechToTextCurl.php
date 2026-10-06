<?php
namespace Analysis\Call\Speech;

use Bitrix\Main\Config\Option;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Exception;
class YandexSpeechToTextCurl
{
    private $apiKey;
    private $folderId;

    private static $composerLoaded = false;

    public function __construct($apiKey, $folderId)
    {
        $this->apiKey = $apiKey;
        $this->folderId = $folderId;

        $this->ensureComposerLoaded();

        $this->s3Client = new S3Client([
            'version' => 'latest',
            'region'  => 'ru-central1',
            'endpoint' => 'https://storage.yandexcloud.net',
            'credentials' => [
                'key'    => 'YCAJE_hZx700NuFueMO5BbUuc', // из yc iam access-key create
                'secret' => 'YCPH4bn9qvFYZ0ANY2otwh2UN_5RcevOMznbLnxq', // из yc iam access-key create
            ],
        ]);
    }

    private function ensureComposerLoaded()
    {
        if (self::$composerLoaded) {
            return;
        }

        // Только при первом вызове класса загружаем зависимости
        $autoloadPath = dirname(__DIR__, 2) . '/vendor/autoload.php';

        if (!file_exists($autoloadPath)) {
            throw new \Exception('Composer dependencies not found. Run: composer install');
        }

        require_once $autoloadPath;
        self::$composerLoaded = true;
    }

    /**
     * Загрузка аудио в бакет Yandex Cloud Storage
     */
    public function uploadToBucket($audioFile, $bucketName = 'alo'): array|string
    {
        try {
            $fileName = 'audio_' . time() . '_' . uniqid() . '.mp3';

            // Загружаем файл
            $this->s3Client->putObject([
                'Bucket' => $bucketName,
                'Key'    => $fileName,
                'SourceFile' => $audioFile,
                'ContentType' => 'audio/mpeg',
            ]);

            return $fileName;

        } catch (AwsException $e) {
            return ['error' => "AWS SDK Error: " . $e->getAwsErrorMessage()];
        }
    }

    /**
     * Отправка аудио на транскрибацию (используя бакет)
     */
    public function startTranscription($bucketName, $objectName, $languageCode = 'ru-RU')
    {
        // Определяем формат аудио по расширению
        $audioFormat = pathinfo($objectName, PATHINFO_EXTENSION);
        if ($audioFormat === 'mp3') {
            $containerAudio = 'MP3';
        } else if ($audioFormat === 'wav') {
            $containerAudio = 'LINEAR16_PCM';
        } else {
            return ['error' =>"Unsupported audio format. Use MP3 or WAV"];
        }

        // ИСПРАВЛЕНО: Используем правильный формат URI для Yandex Cloud
        $requestData = [
            'config' => [
                'specification' => [
                    'languageCode' => $languageCode,
                    'model' => 'general',
                    'profanityFilter' => false,
                    'audioEncoding' => $containerAudio,
                    'sampleRateHertz' => 48000,
                    'audioChannelCount' => 2, // двуканальное аудио
                ],
                'folderId' => $this->folderId
            ],
            'audio' => [
                'uri' => "https://storage.yandexcloud.net/{$bucketName}/{$objectName}" // ← ИСПРАВЛЕНО
            ]
        ];

        $jsonData = json_encode($requestData);

        // Настраиваем cURL
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://transcribe.api.cloud.yandex.net/speech/stt/v2/longRunningRecognize',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => [
                'Authorization: Api-Key ' . $this->apiKey,
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData)
            ],
            CURLOPT_TIMEOUT => 30
        ]);

        // Выполняем запрос
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        curl_close($ch);

        if ($response === false) {
            return ['error' => "cURL error: " . $curlError];
        }

        $responseData = json_decode($response, true);

        if ($httpCode !== 200) {
            return ['error' =>"API error (HTTP {$httpCode}): " .
                ($responseData['message'] ?? 'Unknown error')];
        }

        if (isset($responseData['id'])) {
            return $responseData['id']; // ID операции
        } else {
            return ['error' =>"Failed to start transcription: " . json_encode($responseData)];
        }
    }

    /**
     * Проверка статуса операции
     */
    public function checkOperationStatus($operationId)
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://operation.api.cloud.yandex.net/operations/' . $operationId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Api-Key ' . $this->apiKey,
            ],
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        curl_close($ch);

        if ($response === false) {
            return ['error' =>"cURL error: " . $curlError];
        }

        if ($httpCode !== 200) {
            return ['error' =>"API error (HTTP {$httpCode})"];
        }

        return json_decode($response, true);
    }

    /**
     * Получение результатов транскрибации
     */
    public function getTranscriptionResults($operationId, $maxAttempts = 180, $delaySeconds = 10)
    {
        $attempts = 0;

        while ($attempts < $maxAttempts) {
            $operation = $this->checkOperationStatus($operationId);

            if (isset($operation['done']) && $operation['done']) {
                if (isset($operation['response']['chunks'])) {
                    return $this->formatResults($operation['response']['chunks']);
                } else if (isset($operation['error'])) {
                    return ['error' =>"Transcription error: " . $operation['error']['message']];
                }
            }

            // Если операция еще не завершена, ждем
            $attempts++;
            if ($attempts < $maxAttempts) {
                sleep($delaySeconds);
            }
        }

        return ['error' =>"Transcription timeout after " . ($maxAttempts * $delaySeconds) . " seconds"];
    }

	 /**
     * Удаление аудиофайла из бакета
     */
    public function deleteObject($bucketName, $objectKey)
    {
        try {
            $result = $this->s3Client->deleteObject([
                'Bucket' => $bucketName,
                'Key'    => $objectKey,
            ]);

            // Возвращаем статус об успешном удалении
            return [
                'success' => true,
                'message' => "File '{$objectKey}' successfully deleted from bucket '{$bucketName}'"
            ];

        } catch (AwsException $e) {
            return [
                'error' => true,
                'message' => "AWS SDK Error deleting object: " . $e->getAwsErrorMessage()
            ];
        }
    }



    /**
     * Форматирование результатов
     */
    private function formatResults($chunks)
    {
        $results = [];

        foreach ($chunks as $chunk) {
            if (isset($chunk['alternatives'][0]['text'])) {
                $results[] = [
                    'text' => $chunk['alternatives'][0]['text'],
                    'confidence' => $chunk['alternatives'][0]['confidence'] ?? null,
                    'channel' => $chunk['channelTag'] ?? '1',
                    'start_time' => $chunk['alternatives'][0]['words'][0]['startTime'] ?? null,
                    'end_time' => $chunk['alternatives'][0]['words'][count($chunk['alternatives'][0]['words'])-1]['endTime'] ?? null
                ];
            }
        }

        return $results;
    }
}


