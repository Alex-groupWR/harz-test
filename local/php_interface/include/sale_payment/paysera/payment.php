<?
	
	require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
	
	if (!CModule::IncludeModule("sale")) {
		echo "Module SALE not found";
		exit;
	}
	/* getOrder() */
	$amount=0;
	$currency=0;

$order = \Bitrix\Sale\Order::loadByAccountNumber($_REQUEST['ORDER_ID']);
if (!$order) {
	echo "Заказ не найден";
} else {
	$amount = $order->getField('PRICE');
	$currency = $order->getField('CURRENCY');
}

	/*************/
	require_once($_SERVER["DOCUMENT_ROOT"] ."/local/php_interface/class/WebToPay.php");

	function get_self_url() {
		$s = substr(strtolower($_SERVER['SERVER_PROTOCOL']), 0,
			strpos($_SERVER['SERVER_PROTOCOL'], '/'));

		if (!empty($_SERVER["HTTPS"])) {
			$s .= ($_SERVER["HTTPS"] == "on") ? "s" : "";
		}

		$s .= '://'.$_SERVER['HTTP_HOST'];

		if (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80') {
			$s .= ':'.$_SERVER['SERVER_PORT'];
		}

		$s .= dirname($_SERVER['SCRIPT_NAME']);

		return $s;
	}

	/*************************************/
	$request=[];

	try {
		$self_url = get_self_url();
		Bitrix\Main\Diag\Debug::writeToFile(array("url payment" => $self_url), date("Y-m-d H:i:s") . "url", "/log_pay.txt");
		$request = WebToPay::redirectToPayment(array(
			'projectid'     => 179525,
			'sign_password' => '8c71d6367dc1f7a95488ccff97c2f37e',
			'orderid'       => $_REQUEST['ORDER_ID'],
			'amount'        => $amount,
			'currency'      => $currency,
			'country'       => 'LT',
			'accepturl'     => 'https://harzlabs.com/',
			'cancelurl'     => 'https://harzlabs.com/', /*$self_url.'/cancel.php',*/
			'callbackurl'   => 'https://harzlabs.com/paysera_accept.php', /*$self_url.'/callback.php',*/
			'test'          => 0,
		));
		//Bitrix\Main\Diag\Debug::writeToFile(array("request payment" => $request), date("Y-m-d H:i:s") . "url", "/log_pay.txt");
	} catch (WebToPayException $e) {
		//Bitrix\Main\Diag\Debug::writeToFile(array("except payment" => $e), date("Y-m-d H:i:s") . "e", "/log_pay.txt");
	}
	
	
	/******************************/