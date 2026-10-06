<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Обновление настроек печати");

\Bitrix\Main\UI\Extension::load("local.settings");
?>
    <script>
        window.bitrixSessid = '<?= bitrix_sessid() ?>';
    </script>

    <div class="container">
        <div class="page-section text-page support-page">
            <div id="app"></div>
        </div>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>