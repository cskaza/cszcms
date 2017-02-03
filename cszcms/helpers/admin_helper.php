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

class Admin_helper{
    
    /**
    * is_logged_in
    *
    * Function for check login or not. If login already this function has to check session_id is true
    *
    * @param	string	$email    Email Address from session
    */
    static function is_logged_in($email){
        $CI =& get_instance();
        if(!$email || !$_SESSION['admin_logged_in'] || !$_SESSION['admin_type'] || $_SESSION['admin_type'] == 'member'){
            $CI->load->model('Csz_model');
            $url_return = 'http'.(isset($_SERVER['HTTPS'])?'s':'').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $sess_data = array('cszblogin_cururl' => $url_return);
            $CI->session->set_userdata($sess_data);
            $redirect= BASE_URL.'/admin/login';
            header("Location: $redirect");	
            exit;
        }else if($email && $_SESSION['admin_logged_in'] && $_SESSION['session_id'] && $_SESSION['admin_type'] != 'member' && $_SESSION['admin_visitor'] != 1){
            $CI->load->model('Csz_admin_model');
            $chk = $CI->Csz_admin_model->sessionLoginChk();
            if($chk === FALSE){
                $redirect= BASE_URL.'/admin/logout';
                header("Location: $redirect");	
                exit;
            }
        }
    }
    
    /**
    * login_already
    *
    * Function for check login already for login page
    *
    * @param	string	$email_session    Email Address from session
    */
    static function login_already($email_session){
        if($email_session && $_SESSION['admin_logged_in'] && $_SESSION['session_id'] && $_SESSION['admin_type'] != 'member'){
            $redirect= BASE_URL.'/admin';
            header("Location: $redirect");	
            exit;
        }
    }
    
    /**
    * is_not_admin
    *
    * Function for check member type is admin or not
    *
    * @param	string	$user_type    Member type from session
    */
    static function is_not_admin($user_type){
        if($user_type != 'admin'){
            $redirect= BASE_URL.'/admin';
            header("Location: $redirect");	
            exit;
        }
    }
    
    /**
    * is_a_member
    *
    * Function for check member type is member or not
    *
    * @param	string	$user_type    Member type from session
    */
    static function is_a_member($user_type){
        if($user_type == 'member'){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /**
    * plugin_not_active
    *
    * Function for check the plugin active (backend use)
    *
    * @param	string	$plugin_urlrewrite    Plugin url_rewrite
    */
    static function plugin_not_active($plugin_urlrewrite){
        $CI =& get_instance();
        $CI->load->model('Csz_admin_model');
        $chkactive = $CI->Csz_admin_model->chkPluginActive($plugin_urlrewrite);
        if($chkactive === FALSE){
            $redirect= BASE_URL.'/admin';
            header("Location: $redirect");	
            exit;
        }
    }
    
    /**
    * chkVisitor
    *
    * Function for check user is visitor mode
    *
    * @param	string	$user_admin_id    User id from session
    */
    static function chkVisitor($user_admin_id) {
        $CI =& get_instance();
        $CI->lang->load('admin', LANG);
        $CI->load->model('Csz_admin_model');
        $CI->load->library('session'); 
        $CI->load->library('csz_referrer');
        $CI->load->helper('url');
        $chk = $CI->Csz_admin_model->chkVisitorUser($user_admin_id);
        if($chk != 0){
            $CI->session->set_flashdata('error_message','<div class="alert alert-danger" role="alert">'.$CI->lang->line('user_not_allow_txt').'</div>');
            redirect($CI->csz_referrer->getIndex(), 'refresh');	
            exit;
        }
    }
} 