<?php
/*
	* ShurjoPay PAYMENT GATEWAY FOR CodeIgniter
	*
	* Module: Pay Via API (CodeIgniter 3.1.13)
	* Developed By: Fahim
	* Email: fahim@shurjomukhi.com.bd
	* Author: Shurjomukhi Limited (shurjoPay)
	*
	* */
defined('BASEPATH') or exit('No direct script access allowed');

class ShurjopayPlugin
{
	protected $execute_url;
	protected $payment_status_url;
	protected $token_url;
	protected $sp_base_url;
	protected $store_user;
	protected $store_pass;
	protected $log_path;
	protected $store_prefix;
	public $error = '';
	protected $return_url;
	protected $cancel_url;
	protected $ipn_call_url;

	public function __construct()
	{
		$this->store_user = SP_USER;
		$this->store_pass = SP_PASS;
		$this->store_prefix = SP_PREFIX;
		$this->sp_base_url = SP_BASE_URL;
		$this->execute_url = SP_EXECUTE_URL;
		$this->cancel_url = SP_PAYMENT_CANCEL_STATUS_URL;
		$this->token_url = SP_GET_TOKEN_URL;
		$this->payment_status_url = SP_PAYMENT_STATUS_URL;
		$this->ipn_call_url = SP_IPN_CALL_URL;
		$this->log_path = LOG_PATH;
	}

	/**
	 * @param $requestData
	 * @return bool|string
	 */
	public function makePayment($requestData)
	{
		$url = $this->sp_base_url . $this->execute_url;
		$headerData = array(
			'Content-Type: application/json',
			'authorization: Bearer ' . $requestData['token']);
		$data = json_encode($requestData);
		$response = $this->spCurlRequestCall($url, $data, $headerData);
		return $response;
	}

	/**
	 * @param $requestData
	 * @return bool|int|string
	 */
	public function verifyPayment($requestData)
	{
		$getToken = $this->authenticate();
		$data = json_encode($requestData);
		$token = (!empty($getToken->token)) ? $getToken->token : Null;
		$url = $this->sp_base_url . $this->payment_status_url;
		if ($getToken->sp_code == '200') {
			$headerData = array(
				'Content-Type: application/json',
				'authorization: Bearer ' . $token);
			$response = $this->spCurlRequestCall($url, $data, $headerData);
			return $response;
		}else{
			return $this->spMessage($getToken->sp_code);
		}
	}

	/**
	 * @param $requestData
	 * @return bool|int|string
	 */
	public function cancelPayment($requestData)
	{
		$getToken = $this->authenticate();
		$data = json_encode($requestData);
		$token = (!empty($getToken->token)) ? $getToken->token : Null;
		$url = $this->sp_base_url . $this->cancel_url;
		if ($getToken->sp_code == '200') {
			$headerData = array(
				'Content-Type: application/json',
				'authorization: Bearer ' . $token);
			$response = $this->spCurlRequestCall($url, $data, $headerData);
			return $response;
		}else{
			return $this->spMessage($getToken->sp_code);
		}
	}

	/**
	 * @param $requestData
	 * @return bool|int|string
	 */
	public function ipnCallPaymentStatus($requestData)
	{
		$getToken = $this->authenticate();
		$data = json_encode($requestData);
		$token = (!empty($getToken->token)) ? $getToken->token : Null;
		$url = $this->sp_base_url . $this->ipn_call_url;
		if ($getToken->sp_code == '200') {
			$headerData = array(
				'Content-Type: application/json',
				'authorization: Bearer ' . $token);
			$response = $this->spCurlRequestCall($url, $data, $headerData);
			return $response;
		}else{
			return $this->spMessage($getToken->sp_code);
		}
	}

	/**
	 * @return bool|string
	 */
	public function authenticate()
	{
		$requestData = array();
		$baseUrl = $this->sp_base_url;
		$requestData['username'] = $this->store_user;
		$requestData['password'] = $this->store_pass;
		$this->createLog("grtToken debug--auth username & pass: " . json_encode($requestData));
		$url = $baseUrl . $this->token_url;
		$headerData = array('Content-Type: application/json');
		$data = json_encode($requestData);
		$response = $this->spCurlRequestCall($url, $data, $headerData);
		$getToken = json_decode($response);
		$this->createLog("grtToken info: " . $response);
		return $getToken;

	}

	/**
	 * @param $url
	 * @param $data
	 * @return bool|string
	 */
	protected function spCurlRequestCall($url, $data, $headerData)
	{
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => $headerData,
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			return "cURL Error #:" . $err;
		} else {
			return $response;
		}
	}


	public function storePrefix()
	{
		$prefix = (!empty($this->store_prefix)) ? $this->store_prefix : 'NOK';
		return $prefix;
	}

	/**
	 * @return mixed
	 */
	public function get_ip()
	{
		$this->CI = &get_instance();

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			//ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			//ip pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	/**
	 * @param $log_msg
	 * @return void
	 */
	function createLog($log_msg)
	{
		// log path include there
		$log_filename = $this->log_path;
		if (!file_exists($log_filename)) {
			// create directory/folder uploads.
			mkdir($log_filename, 0777, true);
		}
		$log_file_data = $log_filename . '/log_' . date('d-m-Y') . '.log';
		file_put_contents($log_file_data, date('d:m:Y h:i:sa') . ': ' . $log_msg . "\n", FILE_APPEND);
	}

	/**
	 * @return string
	 */
	public function returnUrl()
	{
		return $this->return_url = RETURN_URL;
	}

	/**
	 * @return string
	 */
	public function cancelUrl()
	{
		return $this->cancel_url = CANCEL_URL;
	}

	/**
	 * @param $spCode
	 * @return false|int|string
	 */
	public function spMessage($spCode)
	{
		$getSpMessage = array(
			'Shurjopay transaction successful.' => '1000',
			'Shurjopay transaction failed.' => '1001',
			'Shurjopay transaction canceled.' => '1002',
			'Bank transaction failed' => '1005',
			'OTP is not matched during mobile wallet transaction' => '1006',
			'Insufficient balance to pay the amount.' => '1008',
			'Daily transaction limit has been exceeded.' => '1009',
			'Shurjopay accepts BDT and USD currency.' => '1010',
			'Invalid order id. Provide shurjopay valid order id.' => '1011',
			'Bkash does not allow same payment transaction within 10 minutes.' => '1061',
			'Shurjopay merchant authentication failed.' => '1064',
			'Payment is initiated but not completed.' => '1065',
			'Shurjopay payment is not initiated.' => '1066',
			'Shurjopay payment is declined.' => '1067',
			'Shurjopay payment is initiated.' => '1068',
			'Shurjopay payment refund is requested.' => '2000',
			'Shurjopay payment refund is accepted.' => '2001',
			'Shurjopay payment refund is canceled.' => '2006',
			'Shurjopay payment refund is successfully done.' => '2002',
			'Bank holds the transaction for review' => '2005',
			'Error occured while bank processing the transaction.' => '2006',
			'Shurjopay timeout occured.' => '2007',
			'Merchant is inactive. Contact with your respective KAM.' => '2008',
			'Payment has failed debit party identity tag prohibits execution' => '2009',
		);
		return $key = array_search($spCode, $getSpMessage);
	}

}
