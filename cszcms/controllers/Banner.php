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
class Banner extends CI_Controller {

    var $page_rs;
    var $page_url;
    var $url_go;
    
    function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
        $this->load->database();
        $row = $this->Csz_model->load_config();
        if($row->maintenance_active){
            //Return to home page
            redirect('./', 'refresh');
            exit;
        }
        if ($row->themes_config) {
            $this->template->set_template($row->themes_config);
        }
        if(!$this->session->userdata('fronlang_iso')){ 
            $this->Csz_model->setSiteLang();
        }
        if($this->Csz_model->chkLangAlive($this->session->userdata('fronlang_iso')) == 0){ 
            $this->session->unset_userdata('fronlang_iso');
            $this->Csz_model->setSiteLang(); 
        }
        $this->_init();
    }

    public function _init() {
        $id = $this->uri->segment(2);
        $row = $this->Csz_model->load_config();
        if ($id && is_numeric($id)) {
            $this->db->where("'".$this->Csz_model->timeNow()."' BETWEEN start_date AND DATE_ADD(end_date, INTERVAL 1 DAY)", '', FALSE); /* For date range between start to end */
            $getLink = $this->Csz_model->getValue('*', 'banner_mgt', "active = '1' AND banner_mgt_id = '".$id."'", '', 1);
            if(!empty($getLink) && $getLink !== FALSE){
                if($getLink->link == '' || $getLink->link == '#'){
                    $this->url_go = base_url();
                }else{
                    $this->url_go = $getLink->link;
                }
                $redirectmeta = '<meta http-equiv="refresh" content="0;url='.$this->url_go.'">'."\n";
                $this->Csz_model->saveBannerStats($getLink->banner_mgt_id);
            }else{
                //Return to home page
                redirect('./', 'refresh');
                exit;
            }
        } else {
            //Return to home page
            redirect('./', 'refresh');
            exit;
        }
        $this->template->set('core_css', $this->Csz_model->coreCss());
        $this->template->set('core_js', $this->Csz_model->coreJs());
        $pageURL = $this->Csz_model->getCurPages();	
        $this->page_url = $pageURL;
        $this->template->set('additional_js', $row->additional_js);
        $this->template->set('additional_metatag', $row->additional_metatag . "\n" . $redirectmeta);
        $title = $this->Csz_model->pagesTitle('Please wait... ,Redirect to' );
        $this->template->set('title', $title);
        $this->template->set('meta_tags', $this->Csz_model->coreMetatags('Please wait... ,Redirect to ',$row->keywords,$title));
        $this->template->set('cur_page', $pageURL);
    }

    public function index() {
        $html = '<br><br><center><h3>Please Wait... ,Redirect to ' . $this->url_go . '</h3></center>';
        $this->template->setSub('content', $html);
        //Load the view
        $this->template->loadFrontViews('static/banner');
    }

}