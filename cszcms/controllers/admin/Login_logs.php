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
class Login_logs extends CI_Controller {

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
        admin_helper::is_allowchk('login logs');
        $this->load->helper('form');
        $this->load->library('pagination');
        $this->csz_referrer->setIndex();
        // Pages variable
        $search_arr = '';
        if($this->input->get('search') || $this->input->get('start_date') || $this->input->get('end_date') || $this->input->get('result')){
            $search_arr.= ' 1=1 ';
            if($this->input->get('search')){
                $search_arr.= " AND email_login LIKE '%".$this->input->get('search', TRUE)."%' OR user_agent LIKE '%".$this->input->get('search', TRUE)."%' OR ip_address LIKE '%".$this->input->get('search', TRUE)."%' OR note LIKE '%".$this->input->get('search', TRUE)."%'";
            }
            if($this->input->get('result')){
                $search_arr.= " AND result = '".$this->input->get('result', TRUE)."'";
            }
            if($this->input->get('start_date') && !$this->input->get('end_date')){
                $search_arr.= " AND timestamp_create >= '".$this->input->get('start_date',true)." 00:00:00'";
            }elseif($this->input->get('end_date') && !$this->input->get('start_date')){
                $search_arr.= " AND timestamp_create <= '".$this->input->get('end_date',true)." 23:59:59'";
            }elseif($this->input->get('start_date') && $this->input->get('end_date')){
                $search_arr.= " AND timestamp_create >= '".$this->input->get('start_date',true)." 00:00:00' AND timestamp_create <= '".$this->input->get('end_date',true)." 23:59:59'";
            }
        }
        $result_per_page = 50;
        $total_row = $this->Csz_admin_model->countTable('login_logs', $search_arr);
        $num_link = 10;
        $base_url = $this->Csz_model->base_link(). '/admin/loginlogs/';
        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url,$total_row,$result_per_page,$num_link); 
        ($this->uri->segment(3))? $pagination = ($this->uri->segment(3)) : $pagination = 0;
        //Get users from database
        $this->template->setSub('login_logs', $this->Csz_admin_model->getIndexData('login_logs', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
        $this->template->setSub('total_row',$total_row);
        //Load the view
        $this->template->loadSub('admin/loginlogs_index');
    }
    
    public function deleteLoginLogs() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('login logs');
        admin_helper::is_allowchk('delete');
        $delR = $this->input->post('delR');
        if(isset($delR)){
            foreach ($delR as $value) {
                if ($value) {
                    $this->Csz_admin_model->removeData('login_logs', 'login_logs_id', $value);
                }
            }
        }
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function settings() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('protection settings');
        $this->db->cache_on();
        //Load the form helper
        $this->csz_referrer->setIndex();
        $this->load->helper('form');
        $this->template->setSub('settings', $this->Csz_model->load_bf_config());
        $this->template->setSub('whitelist', $this->Csz_model->getValueArray('*', 'whitelist_ip', '', '', 0, ' 	timestamp_create', 'desc'));
        $this->template->setSub('blacklist', $this->Csz_model->getValueArray('*', 'blacklist_ip', '', '', 0, ' 	timestamp_create', 'desc'));
        $this->template->loadSub('admin/loginlogs_settings');
    }
    
    public function settings_save() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('protection settings');
        admin_helper::is_allowchk('save');
        $this->Csz_admin_model->updateBFSettings();
        $this->db->cache_delete_all();
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function whiteipsave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('protection settings');
        admin_helper::is_allowchk('save');
        $this->Csz_admin_model->saveWhiteIP();
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function blackipsave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('protection settings');
        admin_helper::is_allowchk('save');
        $this->Csz_admin_model->saveBlackIP();
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function whiteipdel() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('protection settings');
        admin_helper::is_allowchk('delete');
        if($this->uri->segment(4)){
            $this->Csz_admin_model->removeData('whitelist_ip', 'whitelist_ip_id', $this->uri->segment(4));
            $this->db->cache_delete_all();
        }
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function blackipdel() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('protection settings');
        admin_helper::is_allowchk('delete');
        if($this->uri->segment(4)){
            $this->Csz_admin_model->removeData('blacklist_ip', 'blacklist_ip_id', $this->uri->segment(4));
            $this->db->cache_delete_all();
        }
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function genPrivateKey() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('protection settings');
        admin_helper::is_allowchk('save');
        $this->Csz_admin_model->makePrivateKey();
        $this->db->cache_delete_all();
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }

}
