<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 

/**
 * PayPal_Lib Controller Class
 *
 * Copyright (c) 2016, Astian Foundation.
 *
 * Astian Develop Public License (ADPL)
 * 
 * This Source Code Form is subject to the terms of the Astian Develop Public
 * License, v. 1.0. If a copy of the APL was not distributed with this
 * file, You can obtain one at http://astian.org/about-ADPL
 * 
 * @author	CSKAZA
 * @copyright   Copyright (c) 2016, Astian Foundation.
 * @license	http://astian.org/about-ADPL	ADPL License
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 */

class Paypal_lib {
        private $fields = array();		// array holds the fields to submit to paypal
	private $submit_btn = '';		// Image/Form button
	private $CI;
        public $paypal_url = '';
        public $paypal_url_ipn = '';
        
	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->helper('form');	
	}
        public function config($paypal_email, $currency_code, $sanbox = FALSE){
                ($sanbox == TRUE) ? $this->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr' : $this->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
                ($sanbox == TRUE) ? $this->paypal_url_ipn = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr' : $this->paypal_url_ipn = 'https://ipnpb.paypal.com/cgi-bin/webscr';
		$this->add_field('rm','2'); /* Return POST  */
		$this->add_field('cmd','_xclick');
                $this->add_field('business', $paypal_email);
		$this->add_field('currency_code', $currency_code);
                $this->add_field('quantity', '1');
                $this->add_field('charset', 'utf-8');
                $this->button();
        }


        public function button($value = 'Pay Now!', $att = '')
	{
		$this->submit_btn = '<input type="submit" name="pp_submit" value="'.$value.'" '.$att.'/>';
	}
	public function add_field($field, $value) 
	{
		$this->fields[$field] = $value;
	}
	public function paypal_auto_form() 
	{
		$this->button('Click here if you\'re not automatically redirected...');
		echo '<html>' . "\n";
		echo '<head><title>Processing Payment...</title></head>' . "\n";
		echo '<body style="text-align:center;" onLoad="document.forms[\'paypal_auto_form\'].submit();">' . "\n";
		echo '<p style="text-align:center;">Please wait, your order is being processed and you will be redirected to the Paypal website.</p>' . "\n";
		echo $this->paypal_form('paypal_auto_form');
		echo '</body></html>';
                exit(0); /* Not Delete for exit(); */
	}
        
        public function paypal_show_form($form_name='paypal_form') 
	{
		echo $this->paypal_form($form_name);
	}
        
	public function paypal_form($form_name='paypal_form') 
	{
		$str = '';
		$str .= '<form method="post" action="'.$this->paypal_url.'" name="'.$form_name.'"/>' . "\n";
		foreach ($this->fields as $name => $value) {
                    $str .= form_hidden($name, $value) . "\n";
                }
		$str .= '<p>'. $this->submit_btn . '</p>';
		$str .= form_close() . "\n";
		return $str;
	}
        
        function curlPost($paypalurl, $paypalreturnarr)
	{
            if (function_exists('curl_version')) {
		$req = 'cmd=_notify-validate';
		foreach($paypalreturnarr as $key => $value) 
		{
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}
		$ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $paypalurl);
                if(stripos($paypalurl, 'https://') !== FALSE){
                    curl_setopt($ch, CURLOPT_CAINFO, APPPATH . 'cacert.pem');
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                }
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
            }else{
                log_message('error', 'You have neither cUrl installed. Please install now!');
                return FALSE;
            }
	}

}