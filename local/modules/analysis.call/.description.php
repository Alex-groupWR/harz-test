<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arModuleDescription = [
    'ID' => 'order.spam.protection',
    'VERSION' => '1.0.0',
    'VERSION_DATE' => '2024-05-21 00:00:00',
    'NAME' => 'Анали звонков',
    'DESCRIPTION' => '-',
    'GROUP' => [
        'ID' => 'security',
    ],
    'AUTHOR' => '-',
    'PUBLISHED' => true,
    'PARTNER_NAME' => '-',
    'PARTNER_URI' => '-',
    'REQUIREMENTS' => [
        'php' => '7.4',
        'bitrix' => '20.0.0',
    ],
    'INSTALL_REQUIREMENTS' => [
        'modules' => [
            'sale' => true,
        ],
    ],
];