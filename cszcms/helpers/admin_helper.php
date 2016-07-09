<?php  defined('BASEPATH') OR exit('No direct script access allowed');
 
class Admin_helper{
    static function is_logged_in($email){
        if(!$email || !$_SESSION['admin_logged_in'] || !$_SESSION['admin_type'] || !$_SESSION['admin_hash'] || $_SESSION['admin_type'] == 'member'){
            $url_return = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $redirect= BASE_URL.'/admin/login?url_return='.$url_return;
            header("Location: $redirect");	
            exit;
        }
    }
    
    static function login_already($email_session){
        if($email_session && $_SESSION['admin_logged_in'] && $_SESSION['admin_type'] != 'member'){
            $redirect= BASE_URL.'/admin';
            header("Location: $redirect");	
            exit;
        }
    }
    
    static function is_not_admin($user_type){
        if($user_type != 'admin'){
            $redirect= BASE_URL.'/admin';
            header("Location: $redirect");	
            exit;
        }
    }
    
    static function is_a_member($user_type){
        if($user_type == 'member'){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
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
} 