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
        $string = str_replace($search, '', strip_tags($this->_fetch_from_array($_GET, $index, $xss_clean)));
        return str_replace("'", "\'", $string);
    }
}
