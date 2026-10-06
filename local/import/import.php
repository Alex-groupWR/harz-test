<?
ini_set('memory_limit', '1000M');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

\Bitrix\Main\Loader::includeModule('iblock');


$iBlockID = 53;

class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
	public function readCell($column, $row, $worksheetName = '')
	{
		// Read title row and rows 20 - 30
		if ($row >= 2 && $row <= 6000) {
			return true;
		}
		return false;
	}
}

$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
$reader->setReadDataOnly(true);
$reader->setReadFilter(new MyReadFilter());
$oClientsXlsx = $reader->load("settings5.xlsx");

$sheetData = $oClientsXlsx->getActiveSheet()->toArray(null, true, true, true);

$arAccordance = [

];

foreach ($sheetData as $arLine) {
	// Проверим, есть ли раздел
	$sCode = preg_replace("#[[:punct:]]#", "",  $arLine['B']);

	$arSection = \Bitrix\Iblock\SectionTable::getList([
		'select' => ['ID'],
		'filter' => [
			'IBLOCK_ID' => $iBlockID,
			'CODE' => $sCode,
		],
	])->fetchAll();

	if (count($arSection) == 0) {
		echo 'Нет раздела ' . $arLine['A'] . '<br>';

		$bs = new \CIBlockSection;
		if ($arLine['D'] || $arLine['E'] || $arLine['F'] || $arLine['G'] || $arLine['H']) {
			$arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/local/import/configs/".$arLine['B'] .".cfg");
			if (!isset($arFile) || !is_array($arFile)) {
				$arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/local/import/configs/".$arLine['B'] .".cxcfg");
			}
			$arFields = array(
				"ACTIVE" => 'Y',
				"IBLOCK_ID" => $iBlockID,
				"NAME" => $arLine['A'],
				"SORT" => 500,
				"CODE" => $sCode,
				"UF_CONF_FILE" => $arFile
			);

			$ID = $bs->Add($arFields);
			unset($bs);

			$iElementSectionID = $ID;
			echo 'Создан раздел ' . $ID . '<br>';
		}

	} else {
		$iElementSectionID = $arSection[0]['ID'];
	}

	var_dump($arLine);

	if (floatval($arLine['E']) == 0 && floatval($arLine['G']) == 0 && floatval($arLine['J']) == 0) {
		echo $arLine['J']. ' - не добавлено <br>';
	} else {
		$el = new \CIBlockElement;
	$arProperties = [
		312 => floatval($arLine['D']),
		313 => $arLine['E'],
		314 => floatval($arLine['F']),
		315 => floatval($arLine['G']),
		316 => floatval($arLine['H']),
		317 => floatval($arLine['I']),
		318 => floatval($arLine['J']),
		319 => floatval($arLine['K']),
		320 => floatval($arLine['L']),
		321 => floatval($arLine['M']),
		322 => floatval($arLine['N']),
	];

	$arLoadProductArray = array(
		"CREATED_BY" => 527, // БОТ
		"IBLOCK_SECTION_ID" => $iElementSectionID,
		"IBLOCK_ID" => $iBlockID,
		"PROPERTY_VALUES" => $arProperties,
		"NAME" => $arLine['C'],
		"ACTIVE" => "Y",
	);

	if ($PRODUCT_ID = $el->Add($arLoadProductArray))
		echo "New ID: " . $PRODUCT_ID;
	else
		echo "Error: " . $el->LAST_ERROR;
	}
}
?>
