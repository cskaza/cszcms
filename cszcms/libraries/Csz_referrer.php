<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * For page redirect to index when after save.
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

class Csz_referrer {
    
    /**
     * setIndex
     *
     * Function for set the session for page when redirect after save
     *
     * @param	string	$index    Session name
     */
    public function setIndex($index = '') {
        if(!$index){
            $key = 'referred_index';
        }else{
            $key = 'referred_'.$index;
        }
        $paramiter_url = basename(str_replace('index.php', '', $_SERVER['REQUEST_URI']));
        if(strpos($paramiter_url, '?') !== false){ /* Find ? in string */
            $param = strstr($paramiter_url,'?'); /* Remove string before ? */
        }else{
            $param = '';
        }
        $_SESSION[$key] = current_url().$param;
    }
    
    /**
     * getIndex
     *
     * Function for get page from session
     *
     * @param	string	$index    session name
     * @return	string
     */
    public function getIndex($index = '') {
        if(!$index){
            $key = 'referred_index';
        }else{
            $key = 'referred_'.$index;
        }
        if(isset($_SESSION[$key])){
            $referred_from = $_SESSION[$key];
        }else{
            $referred_from = current_url();
            if(!empty($_SERVER["HTTP_REFERER"])) {
                $referer_host = @parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
                $own_host = parse_url(config_item('base_url'), PHP_URL_HOST);
                if(($referer_host && $referer_host === $own_host)){
                    $referred_from = $_SERVER["HTTP_REFERER"];
                }
            }
        }
        return $referred_from;
    }
    
}