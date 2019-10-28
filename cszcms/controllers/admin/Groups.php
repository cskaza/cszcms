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
class Groups extends CI_Controller {

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
        admin_helper::is_allowchk('user groups');
        $this->load->library('pagination');
        $this->db->cache_on();
        $this->csz_referrer->setIndex();

        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_admin_model->countTable('user_groups');
        $num_link = 10;
        $base_url = $this->Csz_model->base_link(). '/admin/groups/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link);
        ($this->uri->segment(3)) ? $pagination = ($this->uri->segment(3)) : $pagination = 0;

        //Get users from database
        $this->template->setSub('groups', $this->Csz_admin_model->getIndexData('user_groups', $result_per_page, $pagination, 'user_groups_id', 'ASC'));
        $this->template->setSub('total_row', $total_row); 
        //Load the view
        $this->template->loadSub('admin/groups_index');
    }

    public function add() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('user groups');
        //Load the form helper
        $this->load->helper('form');
        $this->template->setSub('b_perms', $this->Csz_auth_model->get_perms_all('backend'));
        $this->template->setSub('f_perms', $this->Csz_auth_model->get_perms_all('frontend'));
        //Load the view
        $this->template->loadSub('admin/groups_add');
    }

    public function insert() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('user groups');
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('name', 'Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->add();
        } else {
            //Validation passed
            $this->Csz_auth_model->create_group($this->input->post("name", TRUE), $this->input->post("definition", TRUE), $this->input->post("perms"));
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function edit() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('user groups');
        //Load the form helper
        $this->load->helper('form');
        if ($this->uri->segment(4)) {
            $group = $this->Csz_model->getValue('*', 'user_groups', 'user_groups_id', $this->uri->segment(4), 1);
            if($group !== FALSE){
                $this->template->setSub('group', $group);
                $this->template->setSub('b_perms', $this->Csz_auth_model->get_perms_all('backend'));
                $this->template->setSub('f_perms', $this->Csz_auth_model->get_perms_all('frontend'));
                //Load the view
                $this->template->loadSub('admin/groups_edit');
            }else{
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }
        } else {
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function update() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('user groups');
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('name', 'Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->edit();
        } else {
            //Validation passed
            if($this->uri->segment(4)){
                //Update the user
                $this->Csz_auth_model->update_group($this->uri->segment(4), $this->input->post("name", TRUE), $this->input->post("definition", TRUE), $this->input->post("perms"));
                //Return to user list
                $this->db->cache_delete_all();
                $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            }          
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function delete() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('user groups');
        admin_helper::is_allowchk('delete');
        if ($this->uri->segment(4)) {
            if($this->uri->segment(4) != 1 && $this->uri->segment(4) != 2 && $this->uri->segment(4) != 3 && $this->uri->segment(4) != 4){
                $this->Csz_auth_model->delete_group($this->uri->segment(4));
                $this->db->cache_delete_all();
                $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            }else{
                $this->session->set_flashdata('error_message', '<div class="alert alert-danger" role="alert">' . $this->lang->line('default_data_remark') . '</div>');
            }
        }
        //Return to widget list
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function asCopy() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('user groups');
        admin_helper::is_allowchk('save');
        if($this->uri->segment(4)){
            $group = $this->Csz_model->getValue('*', 'user_groups', 'user_groups_id', $this->uri->segment(4), 1);
            if($group !== FALSE){
                $data = array(
                    'name' => $this->Csz_model->findNameAsCopy('user_groups', 'user_groups_id', $group->name),
                    'definition' => $group->definition,
                );
                $this->db->insert('user_groups', $data);
                $lastid = $this->db->insert_id();
                $perm_group = $this->Csz_model->getValueArray('user_perms_id', 'user_perm_to_group', 'user_groups_id', $this->uri->segment(4));
                if($perm_group !== FALSE){
                    foreach ($perm_group as $value) {
                        $data = array(
                            'user_perms_id' => $value['user_perms_id'],
                            'user_groups_id' => $lastid,
                        );
                        $this->db->insert('user_perm_to_group', $data);
                    }
                }
                $this->db->cache_delete_all();
            }
        }
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }

}
