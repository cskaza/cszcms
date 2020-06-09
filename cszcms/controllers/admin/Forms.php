<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CSZ CMS
 *
 * An open source content management system
 *
 * Copyright (c) 2016 - 2017, Astian Foundation.
 *
 * Astian Develop Public License (ADPL)
 * 
 * This Source Code Form is subject to the terms of the Astian Develop Public
 * License, v. 1.0. If a copy of the APL was not distributed with this
 * file, You can obtain one at http://astian.org/about-ADPL
 * 
 * @author	CSKAZA
 * @copyright   Copyright (c) 2016 - 2017, Astian Foundation.
 * @license	http://astian.org/about-ADPL	ADPL License
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 */
class Forms extends CI_Controller {

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
        admin_helper::is_allowchk('forms builder');
        $this->load->library('pagination');
        $this->db->cache_on();
        $this->csz_referrer->setIndex();
        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_admin_model->countTable('form_main');
        $num_link = 10;
        $base_url = $this->Csz_model->base_link(). '/admin/forms/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url,$total_row,$result_per_page,$num_link);  
        ($this->uri->segment(3))? $pagination = ($this->uri->segment(3)) : $pagination = 0;        

        //Get users from database
        $this->template->setSub('forms', $this->Csz_admin_model->getIndexData('form_main', $result_per_page, $pagination, 'form_main_id', 'asc'));

        //Load the view
        $this->template->loadSub('admin/forms_index');
    }

    public function addForms() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('forms builder');
        //Load the form helper
        $this->load->helper('form');
        //Load the view
        $this->template->loadSub('admin/forms_add');
    }

    public function insert() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('forms builder');
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('form_name', 'Forms Name', 'trim|required|is_unique[form_main.form_name]');
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->addForms();
        } else {            
            //Validation passed
            //Add the user
            $this->Csz_admin_model->insertForms();
            $this->db->cache_delete_all();
            //Return to user list
            $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function editForms() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('forms builder');
        //Load the form helper
        $this->load->helper('form');
        $this->csz_referrer->setIndex('edit_form');
        if($this->uri->segment(4)){
            $this->db->cache_on();
            $form_rs = $this->Csz_model->getValue('*', 'form_main', 'form_main_id', $this->uri->segment(4), 1);
            if($form_rs !== FALSE){
                //Get data from database
                $this->template->setSub('form_rs', $form_rs);
                $this->template->setSub('field_rs', $this->Csz_model->getValueArray('*', 'form_field', 'form_main_id', $this->uri->segment(4), '', array('arrange','form_field_id'), 'ASC'));
                $this->template->setSub('field_email', $this->Csz_model->getValueArray('*', 'form_field', "form_main_id = '".$this->uri->segment(4)."' AND field_type = 'email'", ''));
                //Load the view
                $this->template->loadSub('admin/forms_edit');
            }else{
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }
        }else{
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function edited() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('forms builder');
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('form_name', 'Forms Name', 'trim|required|is_unique[form_main.form_name.form_main_id.'.$this->uri->segment(4).']');

        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->editForms();
        } else {
            //Validation passed
            //Update the user
            if($this->Csz_admin_model->updateForms($this->uri->segment(4)) !== FALSE){
                $this->db->cache_delete_all();
                //Return to user list
                $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }else{
                //Return to user list
                $this->session->set_flashdata('error_message','<div class="alert alert-danger" role="alert">'.$this->lang->line('error_message_alert').'</div>');
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }
        }
    }

    public function delete() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('forms builder');
        admin_helper::is_allowchk('delete');
        //Delete the languages
        if($this->uri->segment(4)) {
            $frm_rs = $this->Csz_model->getValue('form_name', 'form_main', 'form_main_id', $this->uri->segment(4), 1);
            $fiels_name = $this->Csz_admin_model->countTable('form_field', "form_main_id = '".$this->uri->segment(4)."' AND field_type = 'file'");
            if($fiels_name !== FALSE && $fiels_name != 0){
                $this->Csz_model->rmdir_recursive(FCPATH . "/photo/forms/".$this->Csz_model->cleanEmailFormat($frm_rs->form_name));
            }
            $this->Csz_admin_model->dropTable('form_'.$frm_rs->form_name);
            $this->Csz_admin_model->removeData('form_field', 'form_main_id', $this->uri->segment(4));
            $this->Csz_admin_model->removeData('form_main', 'form_main_id', $this->uri->segment(4));
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        }
        
        //Return to languages list
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function deleteField() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('forms builder');
        admin_helper::is_allowchk('delete');
        //Delete the languages
        if($this->uri->segment(4) && $this->uri->segment(5)) {
            $frm_rs = $this->Csz_model->getValue('form_name', 'form_main', 'form_main_id', $this->uri->segment(4), 1);
            $field_rs = $this->Csz_model->getValue('*', 'form_field', "form_field_id = '".$this->uri->segment(5)."' AND form_main_id = '".$this->uri->segment(4)."'", '', 1);
            $this->load->dbforge();
            if($field_rs->field_type != 'button' && $field_rs->field_type != 'reset' && $field_rs->field_type != 'submit' && $field_rs->field_type != 'label'){                
                $this->dbforge->drop_column('form_'.$frm_rs->form_name, $field_rs->field_name);
            }else if($field_rs->field_type == 'file'){
                $this->Csz_model->rmdir_recursive(FCPATH . "/photo/forms/".$this->Csz_model->cleanEmailFormat($frm_rs->form_name).'/'.$this->Csz_model->cleanEmailFormat($field_rs->field_name));
                $this->dbforge->drop_column('form_'.$frm_rs->form_name, $field_rs->field_name);
            }
            $this->Csz_admin_model->removeData('form_field', 'form_field_id', $this->uri->segment(5));
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        }
        
        //Return to languages list
        redirect($this->csz_referrer->getIndex('edit_form'), 'refresh');
    }
    
    public function viewForm() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('forms builder');
        if($this->uri->segment(4)){
            $this->csz_referrer->setIndex('admin_form_view');
            $this->load->helper('form');
            $this->load->library('pagination');
            // Get form name
            $frm_rs = $this->Csz_model->getValue('form_name', 'form_main', 'form_main_id', $this->uri->segment(4), 1);
            if($frm_rs !== FALSE){
                $search_arr = " 1 = 1 ";
                if($this->input->get('search') && $this->input->get('field') && $this->input->get('field') != 'form_'.$frm_rs->form_name.'_id'){
                    $search_arr.= " AND ".$this->input->get('field',true)." LIKE '%".$this->input->get('search',true)."%'";
                }
                if($this->input->get('search') && $this->input->get('field') == 'form_'.$frm_rs->form_name.'_id'){
                    $search_arr.= " AND ".$this->input->get('field',true)." = '".$this->input->get('search',true)."'";
                }
                $result_per_page = 50;
                $total_row = $this->Csz_admin_model->countTable('form_'.$frm_rs->form_name, $search_arr);
                $num_link = 10;
                $base_url = $this->Csz_model->base_link(). '/admin/forms/view/'.$this->uri->segment(4).'/';
                // Pageination config
                $this->Csz_admin_model->pageSetting($base_url,$total_row,$result_per_page,$num_link,5);       
                ($this->uri->segment(5))? $pagination = ($this->uri->segment(5)) : $pagination = 0;     
                //Get users from database   
                $this->template->setSub('form_name', $frm_rs->form_name);
                $this->template->setSub('field_rs', $this->Csz_model->getValueArray('*', 'form_field', 'form_main_id', $this->uri->segment(4), '', array('arrange','form_field_id'), 'ASC'));
                $this->template->setSub('post_rs', $this->Csz_admin_model->getIndexData('form_'.$frm_rs->form_name, $result_per_page, $pagination, 'form_'.$frm_rs->form_name.'_id', 'DESC', $search_arr));
                $this->template->setSub('total_row',$total_row);
                //Load the view
                $this->template->loadSub('admin/forms_view');
            }else{
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }
        }else{
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }
    
    public function deleteViewData() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('forms builder');
        admin_helper::is_allowchk('delete');
        $delR = $this->input->post('delR');
        if($this->uri->segment(4) && isset($delR)) {
            $frm_rs = $this->Csz_model->getValue('form_name', 'form_main', 'form_main_id', $this->uri->segment(4), 1);
            $fiels_name = $this->Csz_model->getValue('field_name,field_type', 'form_field', "form_main_id = '".$this->uri->segment(4)."' AND field_type = 'file'", '', 1);
            foreach ($delR as $value) {
                if ($value) {
                    if($fiels_name !== FALSE && !empty($fiels_name) && $fiels_name->field_type == 'file' && $fiels_name->field_name){
                        $this->Csz_admin_model->removeDataAndFile('form_'.$frm_rs->form_name, 'form_'.$frm_rs->form_name.'_id', $value, 'forms/'.$this->Csz_model->cleanEmailFormat($frm_rs->form_name).'/'.$this->Csz_model->cleanEmailFormat($fiels_name->field_name), $fiels_name->field_name);
                    }else{
                        $this->Csz_admin_model->removeData('form_'.$frm_rs->form_name, 'form_'.$frm_rs->form_name.'_id', $value);
                    }
                }
            }
            unset($frm_rs,$fiels_name,$delR,$value);
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        }
        redirect($this->csz_referrer->getIndex('admin_form_view'), 'refresh');
    }
    
    public function dataSaveExcel() {
        $this->template->set_template('admin', 'excel');
        if($this->uri->segment(4)){
            $frm_rs = $this->Csz_model->getValue('form_name', 'form_main', 'form_main_id', $this->uri->segment(4), 1);
            if($frm_rs !== FALSE){
                $search_arr = " 1 = 1 ";
                if($this->input->get('search') && $this->input->get('field') && $this->input->get('field') != 'form_'.$frm_rs->form_name.'_id'){
                    $search_arr.= " AND ".$this->input->get('field',true)." LIKE '%".$this->input->get('search',true)."%'";
                }
                if($this->input->get('search') && $this->input->get('field') == 'form_'.$frm_rs->form_name.'_id'){
                    $search_arr.= " AND ".$this->input->get('field',true)." = '".$this->input->get('search',true)."'";
                }
                //Get users from database
                $this->template->setSub('form_name', $frm_rs->form_name);
                $this->template->setSub('filename', $frm_rs->form_name.time());
                $this->template->setSub('field_rs', $this->Csz_model->getValueArray('*', 'form_field', 'form_main_id', $this->uri->segment(4), 0, array('arrange','form_field_id'), 'ASC'));
                $this->template->setSub('post_rs', $this->Csz_model->getValueArray('*', 'form_'.$frm_rs->form_name, $search_arr, '', 0, 'timestamp_create', 'ASC'));
                //Load the view
                $this->template->loadSub('admin/forms_excel');
            }else{
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }
        }else{
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }
    
    public function dataAdd() {
        if($this->uri->segment(4)){
            $frm_rs = $this->Csz_model->getValue('form_name', 'form_main', 'form_main_id', $this->uri->segment(4), 1);
            if($frm_rs !== FALSE){
                //Load the form helper
                $this->load->helper('form');
                $this->template->setSub('form_name', $frm_rs->form_name);
                $this->template->setSub('field_data', $this->Csz_model->getValueArray('*', 'form_field', 'form_main_id', $this->uri->segment(4), '', array('arrange','form_field_id'), 'ASC'));
                //Load the view
                $this->template->loadSub('admin/forms_dataadd');
            }else{
                redirect($this->csz_referrer->getIndex('admin_form_view'), 'refresh');
            }
        }else{
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function dataInsert() {
        admin_helper::is_allowchk('save');
        if($this->uri->segment(4)){
            $chk = $this->Csz_admin_model->insertDataForm($this->uri->segment(4));
            if($chk !== FALSE){
                $this->session->set_flashdata('error_message','<div class="alert alert-success hidden-print" role="alert">'.$this->lang->line('success_message_alert').'</div>');
                redirect($this->csz_referrer->getIndex('admin_form_view'), 'refresh');
            }else{
                $this->session->set_flashdata('error_message','<div class="alert alert-danger hidden-print" role="alert">'.$this->lang->line('error_message_alert').'</div>');
                redirect($this->csz_referrer->getIndex('admin_form_view'), 'refresh');
            }
        }else{
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }
    
    public function dataEdit() {
        if($this->uri->segment(4) && $this->uri->segment(5)){
            $frm_rs = $this->Csz_model->getValue('form_name,dont_repeat_field', 'form_main', 'form_main_id', $this->uri->segment(4), 1);
            if($frm_rs !== FALSE){
                //Load the form helper
                $this->load->helper('form');
                $this->template->setSub('form_name', $frm_rs->form_name);
                $this->template->setSub('dont_repeat_field', $frm_rs->dont_repeat_field);
                $this->template->setSub('post', $this->Csz_model->getValue('*', 'form_'.$frm_rs->form_name, 'form_'.$frm_rs->form_name.'_id', $this->uri->segment(5), 1));
                $this->template->setSub('field_data', $this->Csz_model->getValueArray('*', 'form_field', 'form_main_id', $this->uri->segment(4), '', array('arrange','form_field_id'), 'ASC'));
                //Load the view
                $this->template->loadSub('admin/forms_dataedit');
            }else{
                redirect($this->csz_referrer->getIndex('admin_form_view'), 'refresh');
            }
        }else{
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function dataUpdate() {
        admin_helper::is_allowchk('save');
        if($this->uri->segment(4) && $this->uri->segment(5)){
            $chk = $this->Csz_admin_model->updateDataForm($this->uri->segment(4), $this->uri->segment(5));
            if($chk !== FALSE){
                $this->session->set_flashdata('error_message','<div class="alert alert-success hidden-print" role="alert">'.$this->lang->line('success_message_alert').'</div>');
                redirect($this->csz_referrer->getIndex('admin_form_view'), 'refresh');
            }else{
                $this->session->set_flashdata('error_message','<div class="alert alert-danger hidden-print" role="alert">'.$this->lang->line('error_message_alert').'</div>');
                redirect($this->csz_referrer->getIndex('admin_form_view'), 'refresh');
            }
        }
    }
}
