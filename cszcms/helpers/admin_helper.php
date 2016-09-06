<?php  defined('BASEPATH') OR exit('No direct script access allowed');
 
class Admin_helper{
    static function is_logged_in($email){
        if(!$email || !$_SESSION['admin_logged_in'] || !$_SESSION['admin_type'] || $_SESSION['admin_type'] == 'member'){
            $url_return = 'http'.(isset($_SERVER['HTTPS'])?'s':'').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $redirect= BASE_URL.'/admin/login?url_return='.$url_return;
            header("Location: $redirect");	
            exit;
        }else if($email && $_SESSION['admin_logged_in'] && $_SESSION['session_id'] && $_SESSION['admin_type'] != 'member' && $_SESSION['admin_visitor'] != 1){
            $CI =& get_instance();
            $CI->load->model('Csz_admin_model');
            $chk = $CI->Csz_admin_model->sessionLoginChk();
            if($chk === FALSE){
                $redirect= BASE_URL.'/admin/logout';
                header("Location: $redirect");	
                exit;
            }
        }
    }
    
    static function login_already($email_session){
        if($email_session && $_SESSION['admin_logged_in'] && $_SESSION['session_id'] && $_SESSION['admin_type'] != 'member'){
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