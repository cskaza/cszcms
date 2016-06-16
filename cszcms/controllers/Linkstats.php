<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Linkstats extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
    }

    public function index() {
        $link = $this->input->get('url',TRUE);
        if ($link) {
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
