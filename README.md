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
  
 - Your-project\application\config autoload.php | Add below libraries & helper
  - $autoload['libraries'] = array('', 'ShurjopayPlugin');
  - $autoload['helper'] = array('url','sp_helper');
- Your-project\application\config config.php | Add your project base URL
 $config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
 $config['base_url'] .= "://" . $_SERVER['HTTP_HOST'];
 $config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

- Your-project\application\libraries | Copy ShurjopayPlugin.php library here
- Your-project\application\helpers | Copy sp_helper.php helper here and change the API credentials & API mode

define("SP_USER", "____"); Your Test/Live Store Username will be sent through email.
define("SP_PASS", "_____"); Your Test/Live Store Password will be sent through email.
define("SP_PREFIX", NOK); Your Test/Live Store Prefix will be sent through email.
define("SP_BASE_URL","_____"); Your Test/Live shurjopay provide URL will be sent through email.
efine("RETURN_URL",""); Your Application Get The Transection Verify response. 
define("CANCEL_URL",""); Your Application Get The Transection Canceled response.

define("LOG_PATH", "logs"); Log create path define.

  
