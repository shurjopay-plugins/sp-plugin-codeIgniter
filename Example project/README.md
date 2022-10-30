# sp-plugin-codeIgniter

### This library made based on Restful api
**Prerequisite**
  - PHP-Curl library enabled with support to TLSv1.2 or higher
  - Sandbox Store Credentials.
  [Please register here](https://shurjopay.com.bd/#merchant). After successful registration, store credentials will be sent through email.
  - [General requirements for CodeIgniter3](https://codeigniter.com/userguide3/general/requirements.html)
  
  ### [Example project features](https://github.com/shurjopay-plugins/sp-plugin-codeIgniter)
  - Sample Controller implementation
  - Easy use to helper configaration
  - Sample IPN handler implementation
  - shurjoPay Easy Checkout/UI
  
 ### Configuration
  Please follow below steps
  
   Your-project\application\config autoload.php | Add below libraries & helper
      
      $autoload['libraries'] = array('', 'ShurjopayPlugin');
      $autoload['helper'] = array('url','sp_helper');
      
   Your-project\application\config config.php | Add your project base URL
     
      $config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
      $config['base_url'] .= "://" . $_SERVER['HTTP_HOST'];
      $config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

  Your-project\application\libraries | Copy ShurjopayPlugin.php library here
  Your-project\application\helpers | Copy sp_helper.php helper here and change the API credentials & API mode

    define("SP_USER", "sp_sandbox"); Your Live Store Username will be sent through email.
    define("SP_PASS", "pyyk97hu&6u6"); Your Live Store Password will be sent through email.
    define("SP_PREFIX", NOK); Your Test/Live Store Prefix will be sent through email.
    define("SP_BASE_URL","https://sandbox.shurjopayment.com"); Your Test/Live shurjopay provide URL will be sent through email.
    define("RETURN_URL","http://localhost/sandbox_codeigniter/{returnRoute}"); Your Application Get The Transection Verify response. 
    define("CANCEL_URL","http://localhost/sandbox_codeigniter/{cancelReturnRoute}"); Your Application Get The Transection Canceled response.

    define("LOG_PATH", "logs"); Log create path define.
    
  ### Required Parameter
  
  Pass below parameter through API to connect Payment Gateway
  
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

  ### To know more about all Mandatory Parameter visit [Please see here](https://docs.google.com/document/d/19J4HE0j873nBJqcN-uRBYYAa_qBA3p1XSY-jy2fwvEE/)
  
  ### Route Example
  
    $route['default_controller'] = 'checkoutController/index';
    $route['check-out'] = 'checkoutController/checkOut';
    $route['payment-verify-status'] = 'checkoutController/verifyPaymentStatus';
    $route['payment-cancel-status'] = 'checkoutController/cancelPaymentStatus';
    $route['ipn-call-payment-status/(:any)'] = 'checkoutController/ipnCallPaymentStatus/$1';
    ---
   - Author : Shurjomukhi Limited.
   - Contributor: ATM Fahim Bhuiyan
   - Team Email:
      info@shurjopay.com.bd
      
   © 2022-2030 Shurjomukhi ALL RIGHTS RESERVED

