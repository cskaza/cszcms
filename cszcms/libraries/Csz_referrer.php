<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Csz_referrer {
    
    /**
     * For page redirect to index when after save.
     */
    
    public function setIndex($index = '') {
        if(!$index) $index = 'index';
        $paramiter_url = basename(str_replace('index.php', '', $_SERVER['REQUEST_URI']));
        if(strpos($paramiter_url, '?') !== false){
            $param = $paramiter_url;
        }else{
            $param = '';
        }
        $_SESSION['referred_'.$index] = current_url().$param;
    }
    
    public function getIndex($index = '') {
        if(!$index) $index = 'index';
        $referred_from = $_SESSION['referred_'.$index];
        return $referred_from;
    }
    
}