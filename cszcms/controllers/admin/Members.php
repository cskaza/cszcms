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
class Members extends CI_Controller {

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
        admin_helper::is_allowchk('member users');
        $this->load->library('pagination');
        $this->db->cache_on();
        $this->csz_referrer->setIndex();
        $search_arr = " user_type = 'member' ";
        if($this->input->get('search')){
            $search_arr.= ' 1=1 ';
            if($this->input->get('search')){
                $search_arr.= " AND name LIKE '%".$this->input->get('search', TRUE)."%' OR email LIKE '%".$this->input->get('search', TRUE)."%'";
            }
        }
        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_model->countData('user_admin', $search_arr);
        $num_link = 10;
        $base_url = $this->Csz_model->base_link(). '/admin/members/';
        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url,$total_row,$result_per_page,$num_link);     
        ($this->uri->segment(3))? $pagination = $this->uri->segment(3) : $pagination = 0;
        //Get users from database
        $this->template->setSub('users', $this->Csz_admin_model->getIndexData('user_admin', $result_per_page, $pagination, 'user_admin_id', 'desc', $search_arr));        
        $this->template->setSub('total_row', $total_row);       
        //Load the view
        $this->template->loadSub('admin/members_index');
    }

    public function addUser() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('member users');
        //Load the form helper
        $this->load->helper('form');
        $this->template->setSub('group', $this->Csz_auth_model->get_group_all());
        //Load the view
        $this->template->loadSub('admin/members_add');
    }

    public function confirm() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('member users');
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('name', $this->lang->line('user_new_name'), 'required|is_unique[user_admin.name]');
        $this->form_validation->set_rules('email', $this->lang->line('user_new_email'), 'trim|required|valid_email|is_unique[user_admin.email]');
        $this->form_validation->set_rules('password', $this->lang->line('user_new_pass'), 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('con_password', $this->lang->line('user_new_confirm'), 'trim|required|matches[password]');
        $this->form_validation->set_message('is_unique', $this->lang->line('is_unique'));
        $this->form_validation->set_message('valid_email', $this->lang->line('valid_email'));
        $this->form_validation->set_message('matches', $this->lang->line('matches'));
        $this->form_validation->set_message('required', $this->lang->line('required'));
        $this->form_validation->set_message('min_length', $this->lang->line('min_length'));
        $this->form_validation->set_message('max_length', $this->lang->line('max_length'));

        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->addUser();
        } else {
            //Validation passed
            //Add the user
            $this->Csz_admin_model->createUser(TRUE);
            $this->db->cache_delete_all();
            //Return to user list
            $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function editUser() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('member users');
        //Load the form helper
        $this->load->helper('form');
        if($this->uri->segment(4)){
            $this->db->cache_on();
            //Get user details from database
            $users = $this->Csz_admin_model->getUser($this->uri->segment(4), 'member');
            if($users !== FALSE){
                $this->template->setSub('users', $users);
                $this->template->setSub('group', $this->Csz_auth_model->get_group_all());
                //Load the view
                $this->template->loadSub('admin/members_edit');
            }else{
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }
        }else{
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function edited() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('member users');
        admin_helper::is_allowchk('save');   
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('name', $this->lang->line('user_new_name'), 'required|is_unique[user_admin.name.user_admin_id.' . $this->uri->segment(4) . ']');
        $this->form_validation->set_rules('email', $this->lang->line('user_new_email'), 'trim|required|valid_email|is_unique[user_admin.email.user_admin_id.' . $this->uri->segment(4) . ']');
        $this->form_validation->set_rules('password', $this->lang->line('user_new_pass'), 'trim|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('con_password', $this->lang->line('user_new_confirm'), 'trim|matches[password]');
        $this->form_validation->set_rules('cur_password', $this->lang->line('user_cur_pass'), 'trim|min_length[4]|max_length[32]');
        $this->form_validation->set_message('is_unique', $this->lang->line('is_unique'));
        $this->form_validation->set_message('valid_email', $this->lang->line('valid_email'));
        $this->form_validation->set_message('matches', $this->lang->line('matches'));
        $this->form_validation->set_message('required', $this->lang->line('required'));
        $this->form_validation->set_message('min_length', $this->lang->line('min_length'));
        $this->form_validation->set_message('max_length', $this->lang->line('max_length'));

        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->editUser();
        } else {
            //Validation passed
            //Update the user
            $rs = $this->Csz_admin_model->updateUser($this->uri->segment(4));
            if($rs !== FALSE){
                //Return to user list
                $this->db->cache_delete_all();
                $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }else{
                $this->session->set_flashdata('error_message','<div class="alert alert-danger" role="alert">'.$this->lang->line('login_incorrect').'</div>');
                $this->editUser();
            }
            
        }
    }
    
    public function viewUsers() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('member users');
        if($this->uri->segment(4)){             
            //Get users from database   
            $this->db->cache_on();
            $users = $this->Csz_admin_model->getUser($this->uri->segment(4), 'member');
            if($users !== FALSE){
                $this->template->setSub('users', $users);
                //Load the view
                $this->template->loadSub('admin/members_view');
            }else{
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }
        }else{
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function delete() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('member users');
        admin_helper::is_allowchk('delete');
        if($this->uri->segment(4)){
            if ($this->session->userdata('user_admin_id') != $this->uri->segment(4)) {
                //Delete the user account
                $this->Csz_admin_model->removeUser($this->uri->segment(4));
                $this->Csz_auth_model->remove_user_from_allgroup($this->uri->segment(4));
                $this->db->cache_delete_all();
                $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
            } else {
                $this->session->set_flashdata('error_message','<div class="alert alert-danger" role="alert">'.$this->lang->line('user_delete_myacc').'</div>');
            }
        }
        //Return to user list
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
}
