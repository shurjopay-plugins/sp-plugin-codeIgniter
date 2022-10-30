<?php
defined('BASEPATH') or exit('No direct script access allowed');

class checkoutController extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 *        http://example.com/index.php/welcome
	 *    - or -
	 *        http://example.com/index.php/welcome/index
	 *    - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	public function index()
	{
		$this->load->view('addToCart');
	}

	/**
	 * @param
	 * order_id string
	 * currency string
	 * amount decimal
	 * discount_amount float
	 * disc_percent float
	 * customer_name string
	 * customer_phone string
	 * email string
	 * customer_address string
	 * customer_city string
	 * customer_state string
	 * customer_postcode string
	 * customer_country string
	 * shipping_city string
	 * shipping_country string
	 * shipping_phone_number string
	 * shipping_country string
	 * value1 string
	 * value2 string
	 * value3 string
	 * value4 string
	 */
	public function checkOut()
	{
		$data = array();
		$orderid = $this->input->post('order_id', true);
		$prefix = $this->shurjopayplugin->storePrefix();
		if (isset($orderid) && !empty($orderid)) {
			$customerOrderId = $prefix . $orderid;
		} else {
			$customerOrderId = $prefix . uniqid();
		}
		$getToken = $this->shurjopayplugin->authenticate();
		$token = (!empty($getToken->token)) ? $getToken->token : Null;
		$store_id = (!empty($getToken->store_id)) ? $getToken->store_id : 0;
		$ip = $this->shurjopayplugin->get_ip();
		$returnUrl = $this->shurjopayplugin->returnUrl();
		$cancelUrl = $this->shurjopayplugin->cancelUrl();
		if ($getToken->sp_code == '200') {
			$requestData = array(
				'token' => $token,
				'store_id' => $store_id,
				'prefix' => $prefix,
				'currency' => $this->input->post('currency', true),
				'return_url' => $returnUrl,
				'cancel_url' => $cancelUrl,
				'amount' => $this->input->post('amount', true),
				// Order information
				'order_id' => $customerOrderId,
				'discount_amount' => $this->input->post('discount_amount', true),
				'disc_percent' => $this->input->post('disc_percent', true),
				// Customer information
				'client_ip' => $ip,
				'customer_name' => $this->input->post('customer_name', true),
				'customer_phone' => $this->input->post('customer_phone', true),
				'customer_email' => $this->input->post('email', true),
				'customer_address' => $this->input->post('customer_address', true),
				'customer_city' => $this->input->post('customer_city', true),
				'customer_state' => $this->input->post('customer_state', true),
				'customer_postcode' => $this->input->post('customer_postcode', true),
				'customer_country' => $this->input->post('customer_country', true),
				'shipping_city' => $this->input->post('shipping_city', true),
				'shipping_country' => $this->input->post('shipping_country', true),
				'shipping_phone_number' => $this->input->post('shipping_phone_number', true),
				'value1' => $this->input->post('value1', true),
				'value2' => $this->input->post('value2', true),
				'value3' => $this->input->post('value3', true),
				'value4' => $this->input->post('value4', true)
			);
			$getData = $this->shurjopayplugin->makePayment($requestData);
			//seve the response in your database
			$getSpayCheckOutURL = json_decode($getData, true);
			if (isset($getSpayCheckOutURL['checkout_url']) && !empty($getSpayCheckOutURL['checkout_url'])) {
				header("location:" . $getSpayCheckOutURL['checkout_url']);
			} else {
				echo $getData;
			}
		} else {
			echo $this->shurjopayplugin->spMessage($getToken->sp_code);
		}
	}

	/**
	 * @param
	 * @order_id
	 */
	public function verifyPaymentStatus()
	{
		$getOrderId = $_GET['order_id'];
		$requestData = array("order_id" => $getOrderId);
		$getData = $this->shurjopayplugin->verifyPayment($requestData);
		//seve the response in your database
		echo $getData;
		exit;

	}

	/**
	 * @param
	 * @order_id
	 */
	public function cancelPaymentStatus()
	{
		$getOrderId = $_GET['order_id'];
		$requestData = array("order_id" => $getOrderId);
		$getData = $this->shurjopayplugin->cancelPayment($requestData);
		//seve or update the response in your database
		echo $getData;
		exit;

	}
	/**
	 * @param
	 * @order_id
	 */
	public function ipnCallPaymentStatus($orderId)
	{
		$requestData = array("order_id" => $orderId);
		$getData = $this->shurjopayplugin->verifyPayment($requestData);
		//seve the response in your database
		echo $getData;
		exit;

	}
}
