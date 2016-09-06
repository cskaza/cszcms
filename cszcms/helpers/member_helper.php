<?php  defined('BASEPATH') OR exit('No direct script access allowed');
 
class Member_helper{
    static function is_logged_in($email){
        if(!$email || !$_SESSION['admin_logged_in']){
            $url_return = 'http'.(isset($_SERVER['HTTPS'])?'s':'').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $redirect= BASE_URL.'/member/login?url_return='.$url_return;
            header("Location: $redirect");
            exit;
        }else if($email && $_SESSION['admin_logged_in'] && $_SESSION['session_id']){
            $CI =& get_instance();
            $CI->load->model('Csz_admin_model');
            $chk = $CI->Csz_admin_model->sessionLoginChk();
            if($chk === FALSE){
                $redirect= BASE_URL.'/member/logout';
                header("Location: $redirect");	
                exit;
            }
        }
    }
    
    static function login_already($email_session){
        if($email_session && $_SESSION['admin_logged_in']){
            $redirect= BASE_URL.'/member';
            header("Location: $redirect");
            exit;
        }
    }
    
    static function plugin_not_active($plugin_urlrewrite){
        $CI =& get_instance();
        $CI->load->model('Csz_admin_model');
        $chkactive = $CI->Csz_admin_model->chkPluginActive($plugin_urlrewrite);
        if($chkactive === FALSE){
            $redirect= BASE_URL.'/';
            header("Location: $redirect");
            exit;
        }
    }
    
    static function chkVisitor($user_admin_id) {
        $CI =& get_instance();
        $CI->load->model('Csz_admin_model');
        $CI->load->library('session');
        $chk = $CI->Csz_admin_model->chkVisitorUser($user_admin_id);
        if($chk != 0){
            $CI->session->set_flashdata('error_message','<div class="alert alert-danger" role="alert">You not have permission!</div>');
            $redirect= BASE_URL.'/member';
            header("Location: $redirect");
            exit;
        }
    }
} 