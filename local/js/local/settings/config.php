<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

return [
	'js' => [
		'./dist/js/app.js',
        './dist/js/chunk-vendors.js'
	],
	'css' => [
		'./dist/css/app.css',
        './dist/css/chunk-vendors.css',
	],
	'skip_core' => true,
];