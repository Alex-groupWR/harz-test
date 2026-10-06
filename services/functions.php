<?php

// Проверка и создание директории
function check_dir($path, $name = null)
{
    if (!is_dir($path)) {
        mkdir($path);
    }

    return is_dir($path);
}

// Создание файла хеша сумм
function make_file_hash($filePath, $fileHashPath)
{
    $hashSum = get_file_hash($filePath);
    pre($fileHashPath);
    pre($hashSum);
    var_dump(file_put_contents($fileHashPath, $hashSum));

}

// Проверка хеша файла
function check_file_hash($filePath, $fileHashPath)
{

}

// Получить файл хеша
function get_file_hash($filePath)
{
    $content = file_get_contents($filePath);

    return md5($content);
    //return hash_file('md5', $filePath);
}