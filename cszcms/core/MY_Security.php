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
    
}