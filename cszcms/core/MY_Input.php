<?php
defined('BASEPATH') || exit('No direct script access allowed');
class MY_Input extends CI_Input {
    /**
     * Fetch an item from the GET array
     *
     * @param	mixed	$index		Index for item to be fetched from $_GET
     * @param	bool	$xss_clean	Whether to apply XSS filtering
     * @return	mixed
     */
    public function get($index = NULL, $xss_clean = NULL) {
        $search = array('"','\\');
        $data = $this->_fetch_from_array($_GET, $index, $xss_clean);
        if(is_string($data)){
            $string = str_replace($search, '', strip_tags($data));
        }else{
            $string = str_replace($search, '', $data);
        }
        return str_replace("'", "\'", $string);
    }
    
    /**
     * Fetch User Agent string
     *
     * @return	string|null	User Agent string or NULL if it doesn't exist
     */
    public function user_agent($xss_clean = NULL) {
        $search = array('"','\\');
        $data = $this->_fetch_from_array($_SERVER, 'HTTP_USER_AGENT', $xss_clean);
        if(is_string($data)){
            $string = str_replace($search, '', strip_tags($data));
        }else{
            $string = str_replace($search, '', $data);
        }
        return str_replace("'", "\'", $string);
    }
}
