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
$oClientsXlsx = $reader->load("postSettings.xlsx");

$iSheetCount = $oClientsXlsx->getSheetCount();
$arFinalData = array();

for ($i = 0; $i < $iSheetCount; $i++)
{
    $iPos = 0;
    switch ($i) {
        case 0:
            $iPos = 0;
            break;
        case 1:
            $iPos = 4;
            break;
        case 2:
            $iPos = 1;
            break;
        case 3:
            $iPos = 5;
            break;
        case 4:
            $iPos = 6;
            break;
        case 5:
            $iPos = 2;
            break;
        case 6:
            $iPos = 3;
            break;
        case 7:
            $iPos = 7;
            break;
    }
    $sheet = $oClientsXlsx->getSheet($i);
    $sheetData = $sheet->toArray(null, true, true, true);

    $highestRow = $sheet->getHighestRow(); // e.g. 10
   // $highestColumn = $sheet->getHighestColumn(); // e.g 'F'
    if ($sheetData[2]['F']) {
        $highestColumn = 'F';
    } else {
        $highestColumn = 'E';
    }
    $highestColumnIndex = PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

    $data = array();

    for ($row = 2; $row <= $highestRow; $row++) {
        $arData = array();
        for ($col = 1; $col <= $highestColumnIndex; $col++) {
            $sVal = $sheetData[$row][range('A', 'Z')[$col - 1]];
            if ($sVal && 1 === $row || $row > 1) {
                $arData[] = str_replace(' ', '', trim($sVal));
            }
        }
//        if (5 === $row && !empty($arData)) {
//            // Header row. Save it in "$keys".
//            $keys = $arData;
//            $highestColumnIndex = count($keys);
//            continue;
//        }


    if (count($arData) == 5) {
        $keys = array(
          //  'type',
            'material',
            'flushing',
            'heat',
            'backlight',
            'extraheating'
        );
    } else {
        $keys = array(
            'type',
            'material',
            'flushing',
            'heat',
            'backlight',
            'extraheating'
        );
    }

        var_dump($keys, count($arData), $arData);

        $arRes = array_combine($keys, $arData);

        $arNewRes = array();
        echo '<pre>';
        var_dump($keys, $arRes);
        echo '</pre>';
      //  $data[] = $arNewRes;
        if ($arRes['material']) {
            if (isset($arRes['type'])) {
                 $arNewRes['type'] = str_replace(' ', '', trim($arRes['type']));
            }
            if ($arRes['material']) {
                $arNewRes['material'] = str_replace(' ', '', trim($arRes['material']));
            }
            if ($arRes['flushing']) {
                $arNewRes['flushing'] = str_replace(' ', '', trim($arRes['flushing']));
            }
            if ($arRes['heat']) {
                $arNewRes['heat'] = str_replace(' ', '', trim($arRes['heat']));
            }
            if ($arRes['backlight']) {
                $arNewRes['backlight'] = str_replace(' ', '', trim($arRes['backlight']));
            }
            if ($arRes['extraheating']) {
                $arNewRes['extraheating'] = str_replace(' ', '', trim($arRes['extraheating']));
            }
            if ($arRes['Азот']) {
                $arNewRes['azot'] = str_replace(' ', '', trim($arRes['Азот']));
            }
            $data[] = $arNewRes;
        }
    }
    echo '<pre>';
    var_dump($data, $sheetData);
    echo '</pre>';
    $arFinalData[$iPos]['items'] = $data;
//    $arFinalData[$iPos]['lishang'] =  $sheetData[2]['C'];
//    $arFinalData[$iPos]['spectri'] = $sheetData[3]['C'];
}


$newJsonString = json_encode($arFinalData);
file_put_contents('postSettings.json', $newJsonString);
?>
