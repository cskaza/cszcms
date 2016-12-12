<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * PayPal_Lib Controller Class (Paypal IPN Class)
 *
 * This CI library is based on the Paypal PHP class by Micah Carrick
 * See www.micahcarrick.com for the most recent version of this class
 * along with any applicable sample files and other documentaion.
 *
 * This file provides a neat and simple method to interface with paypal and
 * The paypal Instant Payment Notification (IPN) interface.  This file is
 * NOT intended to make the paypal integration "plug 'n' play". It still
 * requires the developer (that should be you) to understand the paypal
 * process and know the variables you want/need to pass to paypal to
 * achieve what you want.  
 *
 * This class handles the submission of an order to paypal as well as the
 * processing an Instant Payment Notification.
 * This class enables you to mark points and calculate the time difference
 * between them.  Memory consumption can also be displayed.
 *
 * The class requires the use of the PayPal_Lib config file.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Commerce
 * @author      Ran Aroussi <ran@aroussi.com>
 * @copyright   Copyright (c) 2006, http://aroussi.com/ci/
 * http://www.codexworld.com/paypal-payment-gateway-integration-in-codeigniter/
 *
 */
// ------------------------------------------------------------------------
class Paypal_lib {
	var $last_error;			// holds the last error encountered
	var $ipn_log;				// bool: log IPN results to text file?
	var $ipn_log_file;			// filename of the IPN log
	var $ipn_response;			// holds the IPN response from paypal	
	var $ipn_data = array();	// array contains the POST values for IPN
	var $fields = array();		// array holds the fields to submit to paypal
	var $submit_btn = '';		// Image/Form button
	var $button_path = '';		// The path of the buttons
	
	var $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->helper('form');
                $this->CI->load->model('plugin/Shop_model');
                $config = $this->CI->Shop_model->load_config();
		
		$sanbox = ($config->sanbox_active) ? TRUE : FALSE;
		$this->paypal_url = ($sanbox == TRUE)?'https://www.sandbox.paypal.com/cgi-bin/webscr':'https://www.paypal.com/cgi-bin/webscr';
                
		$this->last_error = '';
		$this->ipn_response = '';
		$this->ipn_log_file = APPPATH . 'logs/paypal_ipn.log';
		$this->ipn_log = FALSE; 
		
		$this->button_path = 'buttons';
		
		// populate $fields array with a few default values.  See the paypal
		// documentation for a list of fields and their data types. These default
		// values can be overwritten by the calling script.
		$this->add_field('rm','2');			  // Return method = POST
		$this->add_field('cmd','_xclick');
                $this->add_field('business', $config->paypal_email);
		$this->add_field('currency_code', $config->currency_code);
                $this->add_field('quantity', '1');
		$this->button('Pay Now!');
	}
	function button($value)
	{
		// changes the default caption of the submit button
		$this->submit_btn = form_submit('pp_submit', $value);
	}
	function image($file)
	{
		$this->submit_btn = '<input type="image" name="add" src="' . site_url($this->button_path .'/'. $file) . '" border="0" />';
	}
	function add_field($field, $value) 
	{
		// adds a key=>value pair to the fields array, which is what will be 
		// sent to paypal as POST variables.  If the value is already in the 
		// array, it will be overwritten.
		$this->fields[$field] = $value;
	}
	function paypal_auto_form() 
	{
		// this function actually generates an entire HTML page consisting of
		// a form with hidden elements which is submitted to paypal via the 
		// BODY element's onLoad attribute.  We do this so that you can validate
		// any POST vars from you custom form before submitting to paypal.  So 
		// basically, you'll have your own form which is submitted to your script
		// to validate the data, which in turn calls this function to create
		// another hidden form and submit to paypal.
		$this->button('Click here if you\'re not automatically redirected...');
		echo '<html>' . "\n";
		echo '<head><title>Processing Payment...</title></head>' . "\n";
		echo '<body style="text-align:center;" onLoad="document.forms[\'paypal_auto_form\'].submit();">' . "\n";
		echo '<p style="text-align:center;">Please wait, your order is being processed and you will be redirected to the Paypal website.</p>' . "\n";
		echo $this->paypal_form('paypal_auto_form');
		echo '</body></html>';
	}
	function paypal_form($form_name='paypal_form') 
	{
		$str = '';
		$str .= '<form method="post" action="'.$this->paypal_url.'" name="'.$form_name.'"/>' . "\n";
		foreach ($this->fields as $name => $value)
			$str .= form_hidden($name, $value) . "\n";
		$str .= '<p>'. $this->submit_btn . '</p>';
		$str .= form_close() . "\n";
		return $str;
	}
	
	function validate_ipn()
	{
		// parse the paypal URL
		$url_parsed = parse_url($this->paypal_url);		  
		// generate the post string from the _POST vars aswell as load the
		// _POST vars into an arry so we can play with them from the calling
		// script.
		$post_string = '';	 
		if ($this->CI->input->post())
		{
			foreach ($this->CI->input->post() as $field=>$value)
			{ 
				$this->ipn_data[$field] = $value;
				$post_string .= $field.'='.urlencode(stripslashes($value)).'&'; 
			}
		}
		
		$post_string.="cmd=_notify-validate"; // append ipn command
		// open the connection to paypal
		$fp = fsockopen($url_parsed['host'],"80",$err_num,$err_str,30); 
		if(!$fp)
		{
			// could not open the connection.  If loggin is on, the error message
			// will be in the log.
			$this->last_error = "fsockopen error no. $errnum: $errstr";
			$this->log_ipn_results(false);		 
			return false;
		} 
		else
		{ 
			// Post the data back to paypal
			fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n"); 
			fputs($fp, "Host: $url_parsed[host]\r\n"); 
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n"); 
			fputs($fp, "Content-length: ".strlen($post_string)."\r\n"); 
			fputs($fp, "Connection: close\r\n\r\n"); 
			fputs($fp, $post_string . "\r\n\r\n"); 
			// loop through the response from the server and append to variable
			while(!feof($fp))
				$this->ipn_response .= fgets($fp, 1024); 
			fclose($fp); // close connection
		}
		if (preg_match("/VERIFIED/",$this->ipn_response))
		{
			// Valid IPN transaction.
			$this->log_ipn_results(true);
			return true;		 
		} 
		else 
		{
			// Invalid IPN transaction.  Check the log for details.
			$this->last_error = 'IPN Validation Failed.';
			$this->log_ipn_results(false);	
			return false;
		}
	}
	function log_ipn_results($success) 
	{
		if (!$this->ipn_log) return;  // is logging turned off?
		// Timestamp
		$text = '['.date('m/d/Y g:i A').'] - '; 
		// Success or failure being logged?
		if ($success) $text .= "SUCCESS!\n";
		else $text .= 'FAIL: '.$this->last_error."\n";
		// Log the POST variables
		$text .= "IPN POST Vars from Paypal:\n";
		foreach ($this->ipn_data as $key=>$value)
			$text .= "$key=$value, ";
		// Log the response from the paypal server
		$text .= "\nIPN Response from Paypal Server:\n ".$this->ipn_response;
		// Write to log
		$fp=fopen($this->ipn_log_file,'a');
		fwrite($fp, $text . "\n\n"); 
		fclose($fp);  // close file
	}
	function dump() 
	{
		// Used for debugging, this function will output all the field/value pairs
		// that are currently defined in the instance of the class using the
		// add_field() function.
		ksort($this->fields);
		echo '<h2>ppal->dump() Output:</h2>' . "\n";
		echo '<code style="font: 12px Monaco, \'Courier New\', Verdana, Sans-serif;  background: #f9f9f9; border: 1px solid #D0D0D0; color: #002166; display: block; margin: 14px 0; padding: 12px 10px;">' . "\n";
		foreach ($this->fields as $key => $value) echo '<strong>'. $key .'</strong>:	'. urldecode($value) .'<br/>';
		echo "</code>\n";
	}
	
	
	function curlPost($paypalurl,$paypalreturnarr)
	{
		
		$req = 'cmd=_notify-validate';
		foreach($paypalreturnarr as $key => $value) 
		{
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}
			
		$ipnsiteurl=$paypalurl;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $ipnsiteurl);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		$result = curl_exec($ch);
		curl_close($ch);
	
		return $result;
	}
	
	
}
?>