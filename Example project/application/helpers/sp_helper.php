<?php
/**
 * shurjoPay PAYMENT GATEWAY FOR CodeIgniter
 *
 * Module: Pay Via API (CodeIgniter 3.1.8)
 * Developed By: fahim
 * Email: fahim@shurjomukhi.com.bd
 * Author: Shurjomukhi Limited (shurjoPay)
 *
 **/

defined('BASEPATH') OR exit('No direct script access allowed');
//######## config #####
define("SP_USER", "sp_sandbox");
define("SP_PASS", "pyyk97hu&6u6");
define("SP_PREFIX", "NOK"); // 'NOK' for sandbox/
define("SP_BASE_URL", "https://sandbox.shurjopayment.com"); //'https://www.sandbox.shurjopayment.com' for sandbox/ //'https://engine.shurjopayment.com' for live
define("RETURN_URL",base_url('payment-verify-status'));
define("CANCEL_URL",base_url('payment-verify-status'));

//##### End point ####
define("SP_GET_TOKEN_URL", "/api/get_token");
define("SP_EXECUTE_URL", "/api/secret-pay");
define("SP_PAYMENT_STATUS_URL", "/api/verification");
define("SP_PAYMENT_CANCEL_STATUS_URL", "/api/cancel");
define("SP_IPN_CALL_URL", "/api/payment-status");
define("LOG_PATH", "logs");


