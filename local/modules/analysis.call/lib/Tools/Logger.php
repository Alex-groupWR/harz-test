<?php
namespace Analysis\Call\Tools;

class Logger
{
    static public function write($message,$fileName): void
    {
        $timestamp = '[' . date('Y-m-d H:i:s') . '] ';
        $logFile = __DIR__.'/log/'.$fileName;

        file_put_contents($logFile, $timestamp."\n".'<PRE>'.print_r($message,true). '</PRE>'. "\n", FILE_APPEND);
    }

}