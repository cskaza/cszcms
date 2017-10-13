<?php

if(!defined('BASEPATH'))
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
class Navigation extends CI_Controller{

    var $all_lang;

    function __construct(){
        parent::__construct();
        $this->lang->load('admin', $this->Csz_admin_model->getLang());
        $this->template->set_template('admin');
        $this->_init();
    }

    public function _init(){
        $this->template->set('core_css', $this->Csz_admin_model->coreCss());
        $this->template->set('core_js', $this->Csz_admin_model->coreJs());
        $this->template->set('title', 'Backend System | ' . $this->Csz_admin_model->load_config()->site_name);
        $this->template->set('meta_tags', $this->Csz_admin_model->coreMetatags('Backend System for CSZ Content Management System'));
        $this->template->set('cur_page', $this->Csz_admin_model->getCurPages());
        $this->all_lang = $this->Csz_model->loadAllLang();
    }
    
    private function getPosition(){
        $position = array(
            0 => $this->lang->line('navpage_position_top'),
            1 => $this->lang->line('navpage_position_bottom')
        );
        return $position;
    }

    public function index(){
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('navigation');
        $this->db->cache_on();
        $this->csz_referrer->setIndex();
        $this->template->set('cur_page', $this->uri->segment(2));
        if(!$this->uri->segment(3)){
            $lang = $this->Csz_model->getDefualtLang();
        }else{
            $lang = $this->uri->segment(3);
        }
        //Get menu from database
        $this->template->setSub('cur_lang', $lang);
        $this->template->setSub('position', $this->getPosition());
        $this->template->setSub('lang', $this->all_lang);
        $this->load->helper('form');
        //Load the view
        $this->template->loadSub('admin/nav_index');
    }

    public function saveNav(){
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('navigation');
        admin_helper::is_allowchk('save');
        $this->Csz_admin_model->sortNav();
        $this->db->cache_delete_all();
        $this->Csz_model->clear_file_cache('topmenu_*', TRUE);
        $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }

    public function newNav(){
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('navigation');
        //Get pages from database
        $this->template->setSub('pages', $this->Csz_admin_model->getPagesAll());
        $this->template->setSub('dropmenu', $this->Csz_admin_model->getDropMenuAll());
        $this->template->setSub('lang', $this->Csz_model->loadAllLang());
        $this->template->setSub('plugin', $this->Csz_admin_model->getPluginAll());
        $this->template->setSub('position', $this->getPosition());
        $this->load->helper('form');
        //Load the view
        $this->template->loadSub('admin/nav_add');
    }

    public function insert(){
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('navigation');
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', $this->lang->line('navpage_menuname'), 'trim|required');

        if($this->form_validation->run() == FALSE){
            //Validation failed
            $this->newNav();
        }else{
            //Validation passed
            $this->Csz_admin_model->insertMenu();
            //Return to navigation list
            $this->db->cache_delete_all();
            $this->Csz_model->clear_file_cache('topmenu_*', TRUE);
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function editNav(){
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('navigation');
        if($this->uri->segment(4)){
            //Get pages from database
            $this->db->cache_on();
            $nav = $this->Csz_model->getValue('*', 'page_menu', 'page_menu_id', $this->uri->segment(4), 1);
            if($nav !== FALSE){
                $this->template->setSub('pages', $this->Csz_admin_model->getPagesAll());
                $this->template->setSub('dropmenu', $this->Csz_admin_model->getDropMenuAll());
                $this->template->setSub('lang', $this->all_lang);
                //Get navigation from database
                $this->template->setSub('nav', $nav);
                $this->template->setSub('plugin', $this->Csz_admin_model->getPluginAll());
                $this->template->setSub('position', $this->getPosition());
                $this->load->helper('form');
                //Load the view
                $this->template->loadSub('admin/nav_edit');
            }else{
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }
        }else{
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function update(){
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('navigation');
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', $this->lang->line('navpage_menuname'), 'trim|required');

        if($this->form_validation->run() == FALSE){
            //Validation failed
            $this->editNav();
        }else{
            //Validation passed
            $this->Csz_admin_model->updateMenu($this->uri->segment(4));
            //Return to navigation list
            $this->db->cache_delete_all();
            $this->Csz_model->clear_all_cache();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function deleteNav(){
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('navigation');
        admin_helper::is_allowchk('delete');
        if($this->uri->segment(4)){
            //Delete the user account
            $this->Csz_admin_model->removeData('page_menu', 'page_menu_id', $this->uri->segment(4));
            $this->Csz_admin_model->removeData('page_menu', 'drop_page_menu_id', $this->uri->segment(4));
        }
        //Return to user list
        $this->db->cache_delete_all();
        $this->Csz_model->clear_all_cache();
        $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }

}
