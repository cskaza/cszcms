<?php  defined('BASEPATH') OR exit('No direct script access allowed');
 
class Admin_helper{
    static function is_logged_in($email){
        if(!$email || !$_SESSION['admin_logged_in']){
            $redirect= BASE_URL.'/admin/login';
            header("Location: $redirect");	
            exit;	
        }
    }
    
    static function for_not_login($email_session){
        if($email_session && $_SESSION['admin_logged_in']){
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
} 