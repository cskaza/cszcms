<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Admin_helper{
    static function is_logged_in($email){
        if((!$email)){
            $redirect= BASE_URL.'/admin/login';
            header("Location: $redirect");	
            exit;	
        }
    }
    
    static function for_not_login($email_session){
        if($email_session){
            $redirect= BASE_URL.'/admin';
            header("Location: $redirect");	
            exit;	
        }
    }
} 