<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Linkstats extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
    }

    public function index() {
        $link1 = str_replace("'", "\'", base64_decode(str_replace(array('-', '_', '.'), array('+', '/', '='), $this->uri->segment(3))));
        $link = str_replace('['.($this->uri->segment(2)-1).']', '', $link1);
        /*$link = str_replace(BASE_URL.'/linkstats?url=', '', $link);*/
        if ($link) {
            echo 'Please wait. Redirect to '.$link;
            $this->Csz_model->saveLinkStats($link);
            echo '<meta http-equiv="refresh" content="0;url='.$link.'">';
            exit;          
        } else {
            //Return to home page
            redirect('./', 'refresh');
            exit;
        }
    }

}
