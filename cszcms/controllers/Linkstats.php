<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Linkstats extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
    }

    public function index() {
        $link = $this->input->get('url',TRUE);
        /*$url_arr = array("https","http","mailto",":","//");
        $link1 = str_replace($url_arr, '', $link);*/
        if ($link) {
            $this->Csz_model->saveLinkStats($link);
            /*if(strpos($link,"@")){
                echo '<meta http-equiv="refresh" content="0;url='.$link.'">';
                exit;
            }else{*/
                echo '<meta http-equiv="refresh" content="0;url='.$link.'">';
                exit;
            //}           
        } else {
            //Return to home page
            redirect('./', 'refresh');
            exit;
        }
    }

}
