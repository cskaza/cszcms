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
    * @param	string	$email_session    Email Address from session
    */
    static function is_logged_in($email_session){
        $CI =& get_instance();
        $CI->load->library('session');
        if(!$email_session || !$_SESSION['admin_logged_in']){
            $url_return = 'http'.(isset($_SERVER['HTTPS'])?'s':'').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $sess_data = array('cszblogin_cururl' => $url_return);
            $CI->session->set_userdata($sess_data);
            $redirect= $CI->Csz_model->base_link().'/admin/login';
            header("Location: $redirect");	
            exit;
        }else if($email_session && $_SESSION['admin_logged_in'] && $_SESSION['session_id']){
            $CI->load->model('Csz_admin_model');
            $chk = $CI->Csz_admin_model->sessionLoginChk();
            if($chk === FALSE){
                $redirect= $CI->Csz_model->base_link().'/admin/logout';
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
        if($email_session && $_SESSION['admin_logged_in'] && $_SESSION['session_id']){
            $CI =& get_instance();
            $redirect= $CI->Csz_model->base_link().'/admin';
            header("Location: $redirect");	
            exit;
        }
    }
    
    /**
    * is_allowchk
    *
    * Function for check permission allow to access on the section
    *
    * @param	string	$perms_name    Permission Name
    */
    static function is_allowchk($perms_name){
        $CI =& get_instance();
        if($perms_name){
            $CI->load->model('Csz_auth_model');
            if($CI->Csz_auth_model->is_group_allowed($perms_name, 'backend') === FALSE){
                $CI->load->library('session');
                $CI->load->library('csz_referrer');
                $CI->load->helper('url');
                $CI->session->set_flashdata('error_message','<div class="alert alert-danger" role="alert">'.$CI->lang->line('user_not_allow_txt').'</div>');
                redirect($CI->csz_referrer->getIndex(), 'refresh');
                exit;
            }
            if($perms_name == 'save' || $perms_name == 'delete'){
                $CI->load->model('Csz_admin_model');
                $CI->load->helper('url');
                $CI->Csz_admin_model->saveActionsLogs(current_url(), $perms_name, $perms_name . ' on [' . uri_string() . ']');
            }
        }
    }
    
    /**
    * plugin_not_active
    *
    * Function for check the plugin active (backend use)
    *
    * @param	string	$plugin_config_filename    Plugin config filename
    */
    static function plugin_not_active($plugin_config_filename){
        $CI =& get_instance();
        $CI->load->model('Csz_admin_model');
        $chkactive = $CI->Csz_admin_model->chkPluginActive($plugin_config_filename);
        if($chkactive === FALSE){
            $redirect= $CI->Csz_model->base_link().'/admin';
            header("Location: $redirect");	
            exit;
        }
    }  
} 