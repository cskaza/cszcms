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
class Languages extends CI_Controller {

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
        admin_helper::is_allowchk('language');
        $this->load->helper('form');
        $this->db->cache_on();
        $this->csz_referrer->setIndex();
        $total_row = $this->Csz_model->countData('lang_iso');
        //Get users from database
        $this->template->setSub('lang', $this->Csz_model->getValueArray('*', 'lang_iso', '', '', 0, 'arrange', 'asc'));
        $this->template->setSub('total_row', $total_row);

        //Load the view
        $this->template->loadSub('admin/lang_index');
    }
    
    public function indexSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('language');
        admin_helper::is_allowchk('save');
        $i = 0; $arrange = 1;
        $lang_iso_id = $this->input->post('lang_iso_id', TRUE);
        if (!empty($lang_iso_id)) {
            while ($i < count($lang_iso_id)) {
                if ($lang_iso_id[$i]) {
                    $this->db->set('arrange', $arrange, FALSE);
                    $this->db->set('timestamp_update', $this->Csz_model->timeNow(), TRUE);
                    $this->db->where("lang_iso_id", $lang_iso_id[$i]);
                    $this->db->update('lang_iso');
                    $arrange++;
                }
                $i++;
            }
        }
        $this->db->cache_delete_all();
        $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }

    public function addLang() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('language');
        //Load the form helper
        $this->load->helper('form');
        //Load the view
        $this->template->loadSub('admin/lang_add');
    }

    public function insert() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('language');
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('lang_name', 'Language Name', 'required');
        $this->form_validation->set_rules('lang_iso', 'Language ISO Code', 'trim|required|min_length[2]|max_length[2]|is_unique[lang_iso.lang_iso]');
        $this->form_validation->set_rules('country', 'Country Name', 'required');
        $this->form_validation->set_rules('country_iso', 'Country ISO Code', 'trim|required|min_length[2]|max_length[2]');

        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->addLang();
        } else {
            //Validation passed
            //Add the user
            $this->Csz_admin_model->insertLang();
            //Return to user list
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function editLang() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('language');
        //Load the form helper
        $this->load->helper('form');
        if($this->uri->segment(4)){
            $this->db->cache_on();
            $lang = $this->Csz_model->getValue('*', 'lang_iso', 'lang_iso_id', $this->uri->segment(4), 1);
            if($lang !== FALSE){
                $this->template->setSub('lang', $lang);
                //Load the view
                $this->template->loadSub('admin/lang_edit');
            }else{
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }
        }else{
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function edited() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('language');
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('lang_name', 'Language Name', 'required');
        $this->form_validation->set_rules('lang_iso', 'Language ISO Code', 'trim|required|min_length[2]|max_length[2]');
        $this->form_validation->set_rules('country', 'Country Name', 'required');
        $this->form_validation->set_rules('country_iso', 'Country ISO Code', 'trim|required|min_length[2]|max_length[2]');


        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->editLang();
        } else {
            //Validation passed
            //Update the user
            $this->Csz_admin_model->updateLang($this->uri->segment(4));
            //Return to user list
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function delete() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('language');
        admin_helper::is_allowchk('delete');
        if($this->uri->segment(4)){
            //Delete the languages
            if($this->uri->segment(4) != 1) {
                $lang = $this->Csz_model->getValue('lang_iso', 'lang_iso', 'lang_iso_id', $this->uri->segment(4), 1);
                $this->Csz_admin_model->findLangDataUpdate($lang->lang_iso);
                $this->Csz_admin_model->removeData('lang_iso', 'lang_iso_id', $this->uri->segment(4));
                $this->db->cache_delete_all();
                $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
            } else {
                $this->session->set_flashdata('error_message','<div class="alert alert-danger" role="alert">'.$this->lang->line('lang_delete_default').'</div>');
            }
        }
        //Return to languages list
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
}
