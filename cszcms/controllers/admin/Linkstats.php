<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
        $this->lang->load('admin', $this->Csz_admin_model->getLang());
        $this->template->set_template('admin');
        $this->_init();
    }

    public function _init() {
        $this->template->set('core_css', $this->Csz_admin_model->coreCss());
        $this->template->set('core_js', $this->Csz_admin_model->coreJs());
        $this->template->set('title', 'Backend System | ' . $this->Csz_admin_model->load_config()->site_name);
        $this->template->set('meta_tags', $this->Csz_admin_model->coreMetatags('Backend System for CSZ Content Management System'));
        $this->template->set('cur_page', $this->Csz_admin_model->getCurPages());
    }

    public function index() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('linkstats');
        $this->load->helper('form');
        $this->load->library('pagination');
        $this->csz_referrer->setIndex();
        $search_arr = '';
        if($this->input->get('search')){
            $search_arr.= ' 1=1 ';
            if($this->input->get('search')){
                $search_arr.= " AND url LIKE '%".$this->input->get('search', TRUE)."%'";
            }
        }
        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_model->countData('link_stat_mgt', $search_arr);
        $num_link = 10;
        $base_url = $this->Csz_model->base_link(). '/admin/linkstats/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url,$total_row,$result_per_page,$num_link);     
        ($this->uri->segment(3))? $pagination = $this->uri->segment(3) : $pagination = 0;

        //Get users from database
        $this->template->setSub('linkstats', $this->Csz_admin_model->getIndexData('link_stat_mgt', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
        $this->template->setSub('total_row',$total_row);
        //Load the view
        $this->template->loadSub('admin/linkstats_index');
    }
    
    public function addLinks() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('linkstats');
        //Load the form helper
        $this->load->helper('form');
        //Load the view
        $this->template->loadSub('admin/linkstats_add');
    }

    public function insert() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('linkstats');
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('url', 'URL', 'required');
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->addLinks();
        } else {
            //Validation passed
            //Add the user
            $this->Csz_admin_model->insertLinks();
            //Return to user list
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }
    
    public function view() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('linkstats');
        if($this->uri->segment(4)){
            $this->csz_referrer->setIndex('view');
            $this->load->helper('form');
            $this->load->library('pagination');   
            $getLink = $this->Csz_model->getValue('url', 'link_stat_mgt', 'link_stat_mgt_id', $this->uri->segment(4), 1);
            if(empty($getLink)|| $getLink == NULL){
                redirect($this->csz_referrer->getIndex(), 'refresh');
                exit();
            }
            $search_arr = "link = '".str_replace("'", "\'", $getLink->url)."' ";
            if($this->input->get('search') || $this->input->get('start_date') || $this->input->get('end_date')){
                if($this->input->get('search')){
                    $search_arr.= " AND ip_address LIKE '%".$this->input->get('search', TRUE)."%'";
                }
                if($this->input->get('start_date') && !$this->input->get('end_date')){
                    $search_arr.= " AND timestamp_create >= '".$this->input->get('start_date',true)." 00:00:00'";
                }elseif($this->input->get('end_date') && !$this->input->get('start_date')){
                    $search_arr.= " AND timestamp_create <= '".$this->input->get('end_date',true)." 23:59:59'";
                }elseif($this->input->get('start_date') && $this->input->get('end_date')){
                    $search_arr.= " AND timestamp_create >= '".$this->input->get('start_date',true)." 00:00:00' AND timestamp_create <= '".$this->input->get('end_date',true)." 23:59:59'";
                }
            }
            // Pages variable
            $result_per_page = 20;
            $total_row = $this->Csz_model->countData('link_statistic', $search_arr);
            $num_link = 10;
            $base_url = $this->Csz_model->base_link(). '/admin/linkstats/view/'.$this->uri->segment(4).'/';

            // Pageination config
            $this->Csz_admin_model->pageSetting($base_url,$total_row,$result_per_page,$num_link,5);     
            ($this->uri->segment(5))? $pagination = $this->uri->segment(5) : $pagination = 0;

            //Get users from database
            $this->template->setSub('linkstats', $this->Csz_admin_model->getIndexData('link_statistic', $result_per_page, $pagination, 'link_statistic_id', 'desc', $search_arr));
            $this->template->setSub('total_row',$total_row);
            $this->template->setSub('url_link',$getLink->url);
            //Load the view
            $this->template->loadSub('admin/linkstats_view');
        }else{
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }
    
    public function deleteViewByID() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('linkstats');
        admin_helper::is_allowchk('delete');
        $delR = $this->input->post('delR');
        if(isset($delR)){
            foreach ($delR as $value) {
                if ($value) {
                    $this->Csz_admin_model->removeData('link_statistic', 'link_statistic_id', $value);
                }
            }
        }
        $this->db->cache_delete_all();
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex('view'), 'refresh');
    }
    
    public function deleteIndexByURL() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('linkstats');
        admin_helper::is_allowchk('delete');
        $delR = $this->input->post('delR');
        if(isset($delR)){
            foreach ($delR as $value) {
                if ($value) {
                    $getLink = $this->Csz_model->getValue('url', 'link_stat_mgt', 'link_stat_mgt_id', $value, 1);
                    $this->Csz_admin_model->removeData('link_statistic', 'link', $getLink->url);
                    $this->Csz_admin_model->removeData('link_stat_mgt', 'link_stat_mgt_id', $value);
                }
            }
        }
        $this->db->cache_delete_all();
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
}
