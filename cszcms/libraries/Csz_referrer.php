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
        $this->CI =& get_instance();
        if(!$index){
            $key = 'referred_index';
        }else{
            $key = 'referred_'.$index;
        }
        $paramiter_url = basename(str_replace('index.php', '', $_SERVER['REQUEST_URI']));
        $baseurl = rtrim(BASE_URL, '/');
        $base_url = (HTACCESS_FILE === FALSE) ? $baseurl.'/index.php/' : $baseurl.'/';
        if(strpos($paramiter_url, '?') !== false){ /* Find ? in string */
            $param = strstr($paramiter_url,'?'); /* Remove string before ? */
        }else{
            $param = '';
        }
        $_SESSION[$key] = $base_url.$this->CI->uri->uri_string().$param;
        unset($index,$key,$paramiter_url,$param);
    }
    
    /**
     * getIndex
     *
     * Function for get page from session
     *
     * @param	string	$index    session name
     * @param	bool	$backend    Is for backend
     * @return	string
     */
    public function getIndex($index = '', $backend = TRUE) {
        $this->CI =& get_instance();
        $this->CI->load->library('user_agent');
        if($backend){
            $topage = '/admin';
        }else{
            $topage = '/member';
        }
        if(!$index){
            $key = 'referred_index';
        }else{
            $key = 'referred_'.$index;
        }
        $baseurl = rtrim(BASE_URL, '/');
        $base_url = (HTACCESS_FILE === FALSE) ? $baseurl.'/index.php' : $baseurl;
        if(isset($_SESSION[$key])){
            $referred_from = $_SESSION[$key];
        }else{
            if($this->CI->agent->is_referral()) {
                $referred_from = $this->CI->agent->referrer();
            }else{
                $referred_from = $base_url.$topage;
            }
        }
        unset($index,$key,$base_url,$baseurl,$topage);
        return $referred_from;
    }
    
    public function getReferrer() {
        $this->CI =& get_instance();
        $this->CI->load->library('user_agent');
        $baseurl = rtrim(BASE_URL, '/');
        $base_url = (HTACCESS_FILE === FALSE) ? $baseurl.'/index.php' : $baseurl;
        if ($this->CI->agent->is_referral()) {
            $referred_from = $this->CI->agent->referrer();
        } else {
            $referred_from = $base_url;
        }
        unset($base_url,$baseurl);
        return $referred_from;
    }
    
}