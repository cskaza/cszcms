<?php
defined('BASEPATH') || exit('No direct script access allowed');

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
class Pm extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->lang->load('admin', $this->Csz_admin_model->getLang());
        $this->template->set_template('admin');
        $this->_init();
        admin_helper::is_allowchk('pm');
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
        $this->load->helper('form');
        $this->load->library('pagination');
        $this->csz_referrer->setIndex();
        // Pages variable
        $search_arr = " pm_deleted_receiver IS NULL AND receiver_id = '".$this->session->userdata('user_admin_id')."' ";
        $result_per_page = 20;
        $total_row = $this->Csz_admin_model->countTable('user_pms', $search_arr);
        $num_link = 10;
        $base_url = $this->Csz_model->base_link(). '/admin/pm/';
        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url,$total_row,$result_per_page,$num_link); 
        ($this->uri->segment(3))? $pagination = ($this->uri->segment(3)) : $pagination = 0;
        //Get users from database
        $this->template->setSub('msg', $this->Csz_admin_model->getIndexData('user_pms', $result_per_page, $pagination, 'id', 'desc', $search_arr));
        $this->template->setSub('total_row',$total_row);
        //Load the view
        $this->template->loadSub('admin/pm_index');
    }
    
    public function sendIndex() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        $this->load->helper('form');
        $this->load->library('pagination');
        $this->csz_referrer->setIndex();
        // Pages variable
        $search_arr = " pm_deleted_sender IS NULL AND sender_id = '".$this->session->userdata('user_admin_id')."' ";
        $result_per_page = 20;
        $total_row = $this->Csz_admin_model->countTable('user_pms', $search_arr);
        $num_link = 10;
        $base_url = $this->Csz_model->base_link(). '/admin/pm/';
        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url,$total_row,$result_per_page,$num_link); 
        ($this->uri->segment(3))? $pagination = ($this->uri->segment(3)) : $pagination = 0;
        //Get users from database
        $this->template->setSub('msg', $this->Csz_admin_model->getIndexData('user_pms', $result_per_page, $pagination, 'id', 'desc', $search_arr));
        $this->template->setSub('total_row',$total_row);
        //Load the view
        $this->template->loadSub('admin/pm_send_index');
    }
    
    public function viewMSG() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        if($this->uri->segment(4) && is_numeric($this->uri->segment(4))){
            //Get users from database   
            $pm = $this->Csz_auth_model->get_pm($this->uri->segment(4), 'inbox');
            if($pm !== FALSE){
                $this->template->setSub('pm', $pm);
                //Load the view
                $this->db->cache_delete_all();
                $this->template->loadSub('admin/pm_view');
            }else{
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }
        }else{
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }
        
    public function viewSendMSG() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        if($this->uri->segment(4) && is_numeric($this->uri->segment(4))){
            //Get users from database   
            $pm = $this->Csz_auth_model->get_pm($this->uri->segment(4), 'send');
            if($pm !== FALSE){
                $this->template->setSub('pm', $pm);
                //Load the view
                $this->db->cache_delete_all();
                $this->template->loadSub('admin/pm_send_view');
            }else{
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }
        }else{
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }
    
    public function newMSG() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');
        $this->template->setSub('users', $this->Csz_model->getValueArray('*', 'user_admin', "active = '1' AND user_admin_id != '".$this->session->userdata('user_admin_id')."'", '', 0));
        if($this->uri->segment(4)){
            if($this->uri->segment(5) && is_numeric($this->uri->segment(5))){ $this->template->setSub('main_pm', $this->Csz_auth_model->get_pm($this->uri->segment(5))); }
            $this->template->setSub('receiver', $this->Csz_admin_model->getUser($this->uri->segment(4)));
        }
        //Load the view
        $this->template->loadSub('admin/pm_add');
    }

    public function insert() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('to[]', $this->lang->line('pm_to'), 'required');
        $this->form_validation->set_rules('title', $this->lang->line('pm_subject'), 'required');
        $this->form_validation->set_rules('message', $this->lang->line('pm_message'), 'required');
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->newMSG();
        } else {            
            //Validation passed
            //Add the user
            foreach($this->input->post('to[]') as $value){
                $this->Csz_auth_model->send_pm($value, $this->input->post('title', TRUE), $this->input->post('message', TRUE), '', str_replace(array('{[',']}'), '', $this->input->post('re_message', TRUE)));
            }
            $this->db->cache_delete_all();
            //Return to user list
            $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }
    
    public function setRead() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('save');
        //Load the form helper
        if($this->uri->segment(4) && is_numeric($this->uri->segment(4))){
            $this->Csz_auth_model->set_as_read_pm($this->uri->segment(4));            
        }
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function setUnRead() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('save');
        //Load the form helper
        if($this->uri->segment(4) && is_numeric($this->uri->segment(4))){
            $this->Csz_auth_model->set_as_unread_pm($this->uri->segment(4));            
        }
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function indexSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('delete');
        $delR = $this->input->post('delR');
        if(isset($delR)){
            foreach ($delR as $value) {
                if ($value) {
                    $this->Csz_auth_model->delete_pm($value);
                }
            }
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        }
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function delete() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('delete');
        if($this->uri->segment(4) && is_numeric($this->uri->segment(4))){
            $this->Csz_auth_model->delete_pm($this->uri->segment(4));
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        }
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
}
