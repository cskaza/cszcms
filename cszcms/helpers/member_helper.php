<?php  defined('BASEPATH') OR exit('No direct script access allowed');
 
class Member_helper{
    static function is_logged_in($email){
        if(!$email || !$_SESSION['admin_logged_in']){
            $redirect= BASE_URL.'/member/login';
            header("Location: $redirect");	
            exit;	
        }
    }
    
    static function login_already($email_session){
        if($email_session && $_SESSION['admin_logged_in']){
            $redirect= BASE_URL.'/member';
            header("Location: $redirect");	
            exit;	
        }
    }
} 