<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CSZ CMS
 *
 * An open source content management system
 *
 * Copyright (c) 2016, Astian Foundation.
 *
 * Astian Develop Public License (ADPL)
 * 
 * This Source Code Form is subject to the terms of the Astian Develop Public
 * License, v. 1.0. If a copy of the APL was not distributed with this
 * file, You can obtain one at http://astian.org/about-ADPL
 * 
 * @author	CSKAZA
 * @copyright   Copyright (c) 2016, Astian Foundation.
 * @license	http://astian.org/about-ADPL	ADPL License
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 */
class Linkstats extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
    }

    public function index() {
        $link1 = str_replace("'", "\'", $this->Csz_model->decodeURL($this->uri->segment(3)));
        $link = str_replace('['.($this->uri->segment(2)-1).']', '', $link1);
        if ($link) {
            echo '<html><head>';
            echo '<title>Please wait... ,Redirect to '.$link.' | CSZ CMS</title>
                <meta name="generator" content="CSZ CMS"/>
                <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
                <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>';
            echo '<meta http-equiv="refresh" content="0;url='.$link.'"></head><body>';
            echo '<center><h2>Please Wait... ,Redirect to '.$link.'</h2></center>';
            $this->Csz_model->saveLinkStats($link);
            echo '</body></head>';
            exit;          
        } else {
            //Return to home page
            redirect('./', 'refresh');
            exit;
        }
    }

}