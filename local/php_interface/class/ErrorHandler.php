<?php

use Bitrix\Main\Diag\ExceptionHandlerLog;
use Bitrix\Main\Diag\ExceptionHandlerFormatter;


class ErrorHandler extends ExceptionHandlerLog
{
    private const ENDPOINT = 'https://bx.realink.pro/local/tools/tool/logs/api/collect/';
    private const CLIENT = 'HARZLABS';
    private const TOKEN = 'f669f7a392ce80bff998895e220561db';
    private const TIMEOUT = 3;

    private static $recursionGuard = false;

    public function initialize(array $options)
    {
    }

    /**
     * Вызывается ядром Битрикс на каждую перехваченную ошибку/исключение.
     *
     * @param \Throwable|mixed $exception
     * @param int              $logType
     */
    public function write($exception, $logType)
    {
        if (self::$recursionGuard) {
            return;
        }
        self::$recursionGuard = true;

        try {
            $this->send($this->buildPayload($exception));
        } catch (\Throwable $e) {
            // Отчёт об ошибке не должен ломать сайт — глушим любые сбои отправки.
        } finally {
            self::$recursionGuard = false;
        }
    }

    /** Собрать структурированный payload из исключения. */
    private function buildPayload($exception): array
    {
        $error = ['level' => 'Error', 'message' => '', 'file' => '', 'line' => 0, 'trace' => ''];

        if ($exception instanceof \Throwable) {
            $error['level']   = get_class($exception);
            $error['message'] = $exception->getMessage();
            $error['file']    = $exception->getFile();
            $error['line']    = $exception->getLine();
            try {
                $error['trace'] = trim(strip_tags(ExceptionHandlerFormatter::format($exception, false)));
            } catch (\Throwable $e) {
                $error['trace'] = $exception->getTraceAsString();
            }
        } else {
            // Нестандартный объект — форматируем как есть.
            try {
                $error['message'] = trim(strip_tags(ExceptionHandlerFormatter::format($exception, false)));
            } catch (\Throwable $e) {
                $error['message'] = is_scalar($exception) ? (string)$exception : 'Unknown error';
            }
        }

        $host = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? '');
        $uri  = $_SERVER['REQUEST_URI'] ?? '';
        if ($host !== '' || $uri !== '') {
            $error['url'] = $host . $uri;
        }

        return ['client' => self::CLIENT, 'errors' => [$error]];
    }

    /** Неблокирующая отправка JSON на портал (cURL, с фолбэком на stream). */
    private function send(array $payload): void
    {
        $json = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $headers = ['Content-Type: application/json'];
        if (self::TOKEN !== '') {
            $headers[] = 'X-Log-Token: ' . self::TOKEN;
        }

        if (function_exists('curl_init')) {
            $ch = curl_init(self::ENDPOINT);
            curl_setopt_array($ch, [
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $json,
                CURLOPT_HTTPHEADER     => $headers,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => self::TIMEOUT,
                CURLOPT_CONNECTTIMEOUT => 2,
                CURLOPT_SSL_VERIFYPEER => true,
            ]);
            curl_exec($ch);
            curl_close($ch);
            return;
        }

        @file_get_contents(self::ENDPOINT, false, stream_context_create([
            'http' => [
                'method'        => 'POST',
                'header'        => implode("\r\n", $headers),
                'content'       => $json,
                'timeout'       => self::TIMEOUT,
                'ignore_errors' => true,
            ],
        ]));
    }
}