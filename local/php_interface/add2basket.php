<? require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include.php"); ?>
<?
if (CModule::IncludeModule("sale") && CModule::IncludeModule("catalog")) {
    if (isset($_POST['PRODUCT_ID'])) {
        $PRODUCT_ID = $_POST['PRODUCT_ID'];
        Add2BasketByProductID(
            $PRODUCT_ID,
            1,
        );
    } else {
        echo "Нет параметров ";
    }
} else {
    echo "Не подключены модули";
}
?>