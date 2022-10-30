<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class testController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	/**
	 * @return void
	 */
	public function token(){
		$getToken=$this->shurjopayplugin->authenticate();
		$token=(!empty($getToken->token))?$getToken->token:Null;
		if($getToken->sp_code=='200') {
			echo 'ok';
		}else{
			echo 'Failed';
		}
	}

	/**
	 * @return void
	 */
	public function checkOut()
	{
		$data = array();
		$orderid =$this->input->post('order_id', true);
		$prefix=$this->shurjopayplugin->storePrefix();
		if(isset($orderid) && !empty($orderid)){
			$tx_id = $prefix.$orderid;
		}else{
			$tx_id = $prefix . uniqid();
		}
		$getToken=$this->shurjopayplugin->authenticate();
		$token=(!empty($getToken->token))?$getToken->token:Null;
		$store_id=(!empty($getToken->store_id))?$getToken->store_id:0;
		$ip=$this->shurjopayplugin->get_ip();
		$returnUrl=$this->shurjopayplugin->returnUrl();
		$cancelUrl=$this->shurjopayplugin->cancelUrl();

		if($getToken->sp_code=='200') {
			$requestData = array(
				'token' => $token,
				'store_id' => $store_id,
				'prefix' => $prefix,
				'currency' => 'BDT',
				'return_url' => $returnUrl,
				'cancel_url' => $cancelUrl,
				'amount' => 10,
				// Order information
				'order_id' => $tx_id,
				'discsount_amount' => 0,
				'disc_percent' => 0,
				// Customer information
				'client_ip' => $ip,
				'customer_name' => 'Atm Fahim',
				'customer_phone' => '01717302935',
				'customer_email' => 'fahim@shurjomukhi.com.bd',
				'customer_address' => 'Dhaka',
				'customer_city' => 'Dahaka',
				'customer_state' => 'Dahaka',
				'customer_postcode' =>1200,
				'customer_country' => 'Bangladesh',
				'shipping_city' => 'Feni',
				'shipping_country' => '',
				'shipping_phone_number' => '',
				'value1' => '',
				'value2' => '',
				'value3' => '',
				'value4' => ''
			);
			$getData = $this->shurjopayplugin->makePayment($requestData);
			echo $getData;
		}else{
			echo $this->shurjopayplugin->spMessage($getToken->sp_code);
		}
	}
}
