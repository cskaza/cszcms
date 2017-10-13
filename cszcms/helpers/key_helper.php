<?php  defined('BASEPATH') OR exit('No direct script access allowed');
 
/**
 * CodeIgniter HTML Helpers
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

class Key_helper{

    /**
    * chkPrivateKey
    *
    * Function for check the private key from get parameter ?pkey=
    * How to use = Key_helper::chkPrivateKey(); 
    *
    */
    static function chkPrivateKey(){
        $CI =& get_instance();
        $private_key = $CI->input->get('pkey', TRUE);
        if($CI->Csz_model->chkPrivateKey($private_key) === FALSE){
            $error_txt = 'Your private key invalid. Please try again. [IP: '.$CI->input->ip_address().', Time: '. date('Y-m-d H:i:s').']';
            log_message('error', $error_txt);
            show_error($error_txt, 403);
        }
    }
} 