<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Csz_referrer {
    
    /**
     * For page redirect to index when after save.
     */
    
    public function setIndex($index = '') {
        if(!$index){
            $key = 'referred_index';
        }else{
            $key = 'referred_'.$index;
        }
        $paramiter_url = basename(str_replace('index.php', '', $_SERVER['REQUEST_URI']));
        if(strpos($paramiter_url, '?') !== false){ /* Find ? in string */
            $param = strstr($paramiter_url,'?'); /* Remove string before ? */
        }else{
            $param = '';
        }
        $_SESSION[$key] = current_url().$param;
    }
    
    public function getIndex($index = '') {
        if(!$index){
            $key = 'referred_index';
        }else{
            $key = 'referred_'.$index;
        }
        if(isset($_SESSION[$key])){
            $referred_from = $_SESSION[$key];
        }else{
            $referred_from = current_url();
        }
        return $referred_from;
    }
    
}