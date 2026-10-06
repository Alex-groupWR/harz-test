<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?
ini_set('memory_limit', '1000M');
ini_set('max_execution_time', 1000);
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/vendor/autoload.php';
$APPLICATION->SetTitle("Обновление настроек печати");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Bitrix\Main\Page\Asset;

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/rate-us.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/style/support.css");

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

$arLogs = array(
    'sections' => 0,
    'elements' => 0,
    'err' => 0,
    'del' => 0,
    'errors' => array()
);

$arUploadedSections = array();

?>

<div class="container rate-us">
    <div class="page-section page-print-support rate-us__support">

        <div class="main right-col settings__right">


<?
global $USER;
$iCurrentUser = $USER->GetID();
if ($USER->IsAdmin() || $iCurrentUser == 41) {
?>
        <form action="/local/import/upload-settings.php" class="input-file-row rate-us__file-row settings__file-row" method="post" enctype="multipart/form-data">
            <label class="input-file settings__file-label">
                <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="rate-us__file settings__file" name="fileToUpload" id="fileToUpload">
                <input type="submit" class="rate-us__file-title settings__file-title" value="Загрузить настройки" name="submit">
            </label>
            <p class=" rate-us__file-descr settings__file-descr">Для того, чтобы все прошло хорошо - необходимо убрать из эксель формулы, скопировав в документ только преобразованные значения, и проверить названия(не должно быть русских букв).
            </p>
            <p class=" rate-us__file-descr settings__file-descr">
                Также, очень важно дождаться загрузки страницы и не перезагружать ее в процессе выполнения.
            </p>
        </form>

        <?
        $target_dir = $_SERVER["DOCUMENT_ROOT"] . "/local/import/uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

        if(isset($_POST["submit"])) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
                $reader->setReadDataOnly(true);
                $reader->setReadFilter(new MyReadFilter());
                $oClientsXlsx = \PhpOffice\PhpSpreadsheet\IOFactory::load($target_file);

                $sheetData = $oClientsXlsx->getActiveSheet()->toArray(null, true, true, true);

                if (is_array($sheetData)) {
                    $arEls = array();
                    $arEls = \Bitrix\Iblock\ElementTable::GetList(
                        [
                            'select' => array("ID", "IBLOCK_ID"),
                            'filter' => array("IBLOCK_ID" => $iBlockID),
                        ]
                    )->fetchAll();

                    foreach ($arEls as $el) {
                        if ($el['IBLOCK_ID'] == $iBlockID && CIBlockElement::Delete($el["ID"])) {
                            $arLogs['del']++;
                        } else if ($el['IBLOCK_ID'] == $iBlockID) {
                            $arLogs['err']++;
                            array_push($arLogs['errors'], "ERROR delete " . $el["ID"]);
                        }

                    }

                    $arSections = \Bitrix\Iblock\SectionTable::getList([
                        'select' => ['ID'],
                        'filter' => [
                            'IBLOCK_ID' => $iBlockID,
                        ],
                    ])->fetchAll();

                    foreach ($arSections as $arSection) {
                        if (CIBlockSection::Delete($arSection["ID"])) {
                            $arLogs['del']++;
                        } else {
                            $arLogs['err']++;
                            array_push($arLogs['errors'], "ERROR delete " . $arSection["ID"]);
                        }

                    }

                    $arAccordance = [];

                    foreach ($sheetData as $arLine) {
                        // Проверим, есть ли раздел
                        $sCode = preg_replace("#[[:punct:]]#", "", $arLine['B']);

                        if (!isset($arUploadedSections[$sCode])) {
                            $arSection = \Bitrix\Iblock\SectionTable::getList([
                                'select' => ['ID'],
                                'filter' => [
                                    'IBLOCK_ID' => $iBlockID,
                                    'CODE' => $sCode,
                                ],
                            ])->fetchAll();

                            $bs = new \CIBlockSection;
                            if ($arLine['D'] || $arLine['E'] || $arLine['F'] || $arLine['G'] || $arLine['H']) {
                                $arFields = array(
                                    "ACTIVE" => 'Y',
                                    "IBLOCK_ID" => $iBlockID,
                                    "NAME" => $arLine['A'],
                                    "SORT" => 500,
                                    "CODE" => $sCode,
                                    "UF_CONF_FILE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/local/import/configs/" . $arLine['B'] . ".cfg")
                                );

                                $ID = $bs->Add($arFields);
                                unset($bs);

                                $iElementSectionID = $ID;
                                $arUploadedSections[$sCode] = $ID;
                                $arLogs['sections']++;
                            }
                        } else {
                            $iElementSectionID = $arUploadedSections[$sCode];
                        }

                        if (floatval($arLine['E']) == 0 && floatval($arLine['G']) == 0 && floatval($arLine['J']) == 0) {
                            // echo $arLine['J']. ' - не добавлено <br>';
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

                            if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {
                                $arLogs['elements']++;
                            } else {
                                $arLogs['err']++;
                                array_push($arLogs['errors'], "Error: " . $el->LAST_ERROR);
                            }
                        }
                    }

                    echo "</br>";
                    echo "</br>";
//                    echo '<span style="color: blue;">Удалено разделов и элементов: ' . $arLogs['sections'] . '</span>';
//                    echo "</br>";
                    echo '<span style="color: green;">Добавлено разделов: ' . $arLogs['sections'] . '</span>';
                    echo "</br>";
                    echo '<span style="color: green;">Добавлено элементов: ' . $arLogs['elements'] . '</span>';
                    echo "</br>";
                    echo '<span style="color: red;">Ошибок: ' . $arLogs['err'] . '</span>';
                    if (count($arLogs['errors'])) {
                        foreach ($arLogs['errors'] as $error) {
                            echo "</br>";
                            echo '<span style="color: red;">' . $error . '</span>';
                        }
                    }
                } else { ?>
                    <div class="intec-content-wrapper">
                        <p>Что-то не так с файлом :(</p>
                    </div>
               <? }
            }
        }
        } else {
            ?>
            <div class="widget-wrapper intec-content">
                <div class="intec-content-wrapper">
                    <p>Не хватает прав доступа :(</p>
                </div>
            </div>
            <?
        }
        ?>
        </div>
    </div>
</div>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php") ?>
