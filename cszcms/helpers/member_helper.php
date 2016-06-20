<?php  defined('BASEPATH') OR exit('No direct script access allowed');
 
class Member_helper{
    static function is_logged_in($email){
        if(!$email || !$_SESSION['member_logged_in']){
            $redirect= BASE_URL.'/admin/login';
            header("Location: $redirect");	
            exit;	
        }
    }
    
    static function login_already($email_session){
        if($email_session && $_SESSION['member_logged_in']){
            $redirect= BASE_URL.'/admin';
            header("Location: $redirect");	
            exit;	
        }
    }
} 