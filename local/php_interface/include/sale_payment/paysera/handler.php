<?php
	namespace Sale\Handlers\PaySystem;

	require_once($_SERVER["DOCUMENT_ROOT"] ."/local/php_interface/class/WebToPay.php");

	use Bitrix\Main\Config;
	use Bitrix\Main\Error;
	use Bitrix\Main\Localization\Loc;
	use Bitrix\Main\Request;
	use Bitrix\Main\Result;
	use Bitrix\Main\Text\Encoding;
	use Bitrix\Main\Type\DateTime;
	use Bitrix\Main\Web\HttpClient;
	use Bitrix\Sale\Order;
	use Bitrix\Sale\PaySystem;
	use Bitrix\Sale\Payment;
	use Bitrix\Sale\PriceMaths;

	Loc::loadMessages(__FILE__);



	class paysera extends PaySystem\ServiceHandler /* implements PaySystem\IRefundExtended, PaySystem\IHold*/

	{
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
		/**

		 * @param Payment $payment

		 * @param Request|null $request

		 * @return PaySystem\ServiceResult

		 */

		public function initiatePay(Payment $payment, Request $request = null)

		{
			$request=[];

			try {
				$self_url = $this->get_self_url();
			//	Bitrix\Main\Diag\Debug::writeToFile(array("url initiatePay" => $self_url), date("Y-m-d H:i:s") . "url", "/log_pay.txt");
				$request = WebToPay::redirectToPayment(array(
					'projectid'     => 179525,
					'sign_password' => 'KS3D!1234',
					'orderid'       => 0,
					'amount'        => 1000,
					'currency'      => 'EUR',
					'country'       => 'LT',
					'accepturl'     => $self_url.'/accept.php',
					'cancelurl'     => $self_url.'/cancel.php',
					'callbackurl'   => $self_url.'/callback.php',
					'test'          => 0,
				));
			//	Bitrix\Main\Diag\Debug::writeToFile(array("request" => $request), date("Y-m-d H:i:s") . "request", "/log_pay.txt");
			} catch (WebToPayException $e) {
				// handle exception
			}

			$params = array(

				'PARAM1' => 'VALUE1',

				'PARAM2' => $request,


			);

			$this->setExtraParams($params);



			return $this->showTemplate($payment, "template");

		}

		/**

		 * @param Request $request

		 * @return mixed

		 */

		public function getPaymentIdFromRequest(Request $request)

		{

			$paymentId = $request->get('ORDER');
		//	Bitrix\Main\Diag\Debug::writeToFile(array("getPaymentIdFromRequest" => $request), date("Y-m-d H:i:s") . "request", "/log_pay.txt");
			$paymentId = preg_replace("/^[0]+/","",$paymentId);

			return intval($paymentId);

		}

		/**

		 * @return array

		 */

		public function getCurrencyList()

		{

			return array('EUR', 'USD', 'RUB');

		}

		/**

		 * @return array

		 */

		public static function getIndicativeFields()

		{
			Bitrix\Main\Diag\Debug::writeToFile(array("getIndicativeFields" => 'PARAM1'), date("Y-m-d H:i:s") . "request", "/log_pay.txt");
			return array('PARAM1','PARAM2');

		}

		/**

		 * @param Request $request

		 * @param $paySystemId

		 * @return bool

		 */

		static protected function isMyResponseExtended(Request $request, $paySystemId)

		{
			Bitrix\Main\Diag\Debug::writeToFile(array("isMyResponseExtended" => $request), date("Y-m-d H:i:s") . "request", "/log_pay.txt");
			return true;

		}

		/**

		 * @param Payment $payment

		 * @param Request $request

		 * @return PaySystem\ServiceResult

		 */

		public function processRequest(Payment $payment, Request $request)

		{
		//	Bitrix\Main\Diag\Debug::writeToFile(array("request processRequest" => $request), date("Y-m-d H:i:s") . "url", "/log_Pay.txt");
			$result = new PaySystem\ServiceResult();

			$action = $request->get('ACTION');

			$data = $this->extractDataFromRequest($request);

			/*************************************/
			$request=[];

			try {
				$self_url = $this->get_self_url();
			//	Bitrix\Main\Diag\Debug::writeToFile(array("url processRequest" => $self_url), date("Y-m-d H:i:s") . "url", "/log_pay.txt");
				$request = WebToPay::redirectToPayment(array(
					'projectid'     => 179525,
					'sign_password' => 'KS3D!1234',
					'orderid'       => 0,
					'amount'        => $request->get('AMOUNT'),
					'currency'      => $payment->getField('CURRENCY'),
					'country'       => 'LT',
					'accepturl'     => $self_url.'/accept.php',
					'cancelurl'     => $self_url.'/cancel.php',
					'callbackurl'   => $self_url.'/callback.php',
					'test'          => 1,
				));
			//	Bitrix\Main\Diag\Debug::writeToFile(array("request processRequest" => $request), date("Y-m-d H:i:s") . "url", "/log_pay.txt");
			} catch (WebToPayException $e) {
			//	Bitrix\Main\Diag\Debug::writeToFile(array("except processRequest" => $e), date("Y-m-d H:i:s") . "e", "/log_pay.txt");
			}


			/******************************/

			$data['CODE'] = $action;



			if($action==="1")

			{

				$result->addError(new Error("Ошибка платежа"));

			}

			elseif($action==="0")

			{

				$fields = array(

					"PS_STATUS_CODE" => $action,

					"PS_STATUS_MESSAGE" => '',

					"PS_SUM" => $request->get('AMOUNT'),

					"PS_CURRENCY" => $payment->getField('CURRENCY'),

					"PS_RESPONSE_DATE" => new DateTime(),

					"PS_INVOICE_ID" => '',

				);

				if ($this->isCorrectSum($payment, $request))

				{

					$data['CODE'] = 0;

					$fields["PS_STATUS"] = "Y";

					$fields['PS_STATUS_DESCRIPTION'] = "Оплата произведена успешно";

					$result->setOperationType(PaySystem\ServiceResult::MONEY_COMING);

				}

				else

				{

					$data['CODE'] = 200;

					$fields["PS_STATUS"] = "N";

					$message = "Неверная сумма платежа";

					$fields['PS_STATUS_DESCRIPTION'] = $message;

					$result->addError(new Error($message));

				}

				$result->setPsData($fields);

			}

			else

			{

				$result->addError(new Error("Неверный статус платежной системы при возврате информации о платеже"));

			}



			$result->setData($data);



			if (!$result->isSuccess())

			{

				PaySystem\ErrorLog::add(array(

					'ACTION' => "processRequest",

					'MESSAGE' => join('\n', $result->getErrorMessages())

				));

			}



			return $result;

		}

	}