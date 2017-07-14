<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Security extends CI_Security{

    public function csrf_verify()
    {
        $headers = $this->getallheaders();
        if(isset($headers[$this->_csrf_token_name])) {
            $_POST[$this->_csrf_token_name] = $headers[$this->_csrf_token_name];
        }
        parent::csrf_verify();
    }
    
    private function getallheaders() {
        if (!function_exists('getallheaders'))  {
            if (!is_array($_SERVER)) {
                return array();
            }
            $headers = array();
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
            return $headers;
        }else{
            return getallheaders();
        }
    }
    
    /**
     * Show CSRF Error
     *
     * @return	void
     */
    public function csrf_show_error() {
        if(!empty($_SERVER["HTTP_REFERER"])) {
            $referer_host = @parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
            $own_host = parse_url(config_item('base_url'), PHP_URL_HOST);
            if(($referer_host && $referer_host === $own_host)){
                header('Refresh:2;url=' . $_SERVER["HTTP_REFERER"].'?nocache='.time());
                show_error('The action is not allowed by CSRF Protection. Please wait 2 seconds to redirect.', 403);
            }
        }
        show_error('The action is not allowed by CSRF Protection. Please clear your browser cookie and cache.', 403);
    }
    
}