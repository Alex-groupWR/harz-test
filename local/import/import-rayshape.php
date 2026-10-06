<?
ini_set('memory_limit', '1000M');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//\Bitrix\Main\Loader::includeModule('iblock');
//
//
class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
    public function readCell($column, $row, $worksheetName = '')
    {
        // Read title row and rows 20 - 30
        if ($row >= 1 && $row <= 6000) {
            return true;
        }
        return false;
    }
}

$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
$reader->setReadDataOnly(true);
$reader->setReadFilter(new MyReadFilter());
$oClientsXlsx = $reader->load("settings-rayshape1.xlsx");

$iSheetCount = $oClientsXlsx->getSheetCount();
$arFinalData = array();

for ($i = 0; $i < $iSheetCount; $i++)
{
    $sheet = $oClientsXlsx->getSheet($i);
    $sheetData = $sheet->toArray(null, true, true, true);

    $highestRow = $sheet->getHighestRow(); // e.g. 10
    $highestColumn = $sheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

    $data = array();

    for ($row = 1; $row <= $highestRow; $row++) {
        $arData = array();
        for ($col = 1; $col <= $highestColumnIndex; $col++) {
            $sVal = $sheetData[$row][range('A', 'Z')[$col - 1]];
            if ($sVal && 1 === $row || $row > 1) {
                $arData[] = $sVal;
            }
        }
        if (1 === $row && !empty($arData)) {
            // Header row. Save it in "$keys".
            $keys = $arData;
            $highestColumnIndex = count($keys);
            continue;
        }

        $arRes = array_combine($keys, $arData);
        if ($arRes['Material Name']) {
            if ($arRes['Exposure Time ']) {
                $arRes['Exposure Time '] = round($arRes['Exposure Time '], 2);
            }
            if ($arRes['Exposure PWM']) {
                $arRes['Exposure PWM'] = $arRes['Exposure PWM'] * 100 . '%';
            }
            $data[] = $arRes;
        }
    }
    echo '<pre>';
    var_dump($data, $sheetData);
    echo '</pre>';
    $arFinalData[$data[0]['Thickness']] = $data;
}


$newJsonString = json_encode($arFinalData);
file_put_contents('rayshape.json', $newJsonString);
?>
