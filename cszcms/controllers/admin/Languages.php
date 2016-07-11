<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Languages extends CI_Controller {

    function __construct() {
        parent::__construct();
        define('LANG', $this->Csz_admin_model->getLang());
        $this->lang->load('admin', LANG);
        $this->template->set_template('admin');
        $this->_init();
    }

    public function _init() {
        $row = $this->Csz_admin_model->load_config();
        $pageURL = $this->Csz_admin_model->getCurPages();
        $this->template->set('core_css', $this->Csz_admin_model->coreCss());
        $this->template->set('core_js', $this->Csz_admin_model->coreJs());
        $this->template->set('title', 'Backend System | ' . $row->site_name);
        $this->template->set('meta_tags', $this->Csz_admin_model->coreMetatags('Backend System for CSZ Content Management'));
        $this->template->set('cur_page', $pageURL);
    }

    public function index() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        $this->load->library('pagination');
        $this->csz_referrer->setIndex();

        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_admin_model->countTable('lang_iso');
        $num_link = 10;
        $base_url = BASE_URL . '/admin/lang/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url,$total_row,$result_per_page,$num_link); 
        ($this->uri->segment(3))? $pagination = ($this->uri->segment(3)) : $pagination = 0;

        //Get users from database
        $this->template->setSub('lang', $this->Csz_admin_model->getIndexData('lang_iso', $result_per_page, $pagination, 'lang_iso_id', 'ASC'));

        //Load the view
        $this->template->loadSub('admin/lang_index');
    }

    public function addLang() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');
        //Load the view
        $this->template->loadSub('admin/lang_add');
    }

    public function insert() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('lang_name', 'Language Name', 'required');
        $this->form_validation->set_rules('lang_iso', 'Language ISO Code', 'trim|required|min_length[2]|max_length[2]');
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
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function editLang() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');
        if($this->uri->segment(4)){
            //Get user details from database
            $this->template->setSub('lang', $this->Csz_model->getValue('*', 'lang_iso', 'lang_iso_id', $this->uri->segment(4), 1));
            //Load the view
            $this->template->loadSub('admin/lang_edit');
        }else{
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function edited() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
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
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function delete() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        if($this->uri->segment(4)){
            //Delete the languages
            if($this->uri->segment(4) != 1) {
                $lang = $this->Csz_model->getValue('lang_iso', 'lang_iso', 'lang_iso_id', $this->uri->segment(4), 1);
                $this->Csz_admin_model->findLangDataUpdate($lang->lang_iso);
                $this->Csz_admin_model->removeData('lang_iso', 'lang_iso_id', $this->uri->segment(4));
                $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
            } else {
                $this->session->set_flashdata('error_message','<div class="alert alert-danger" role="alert">'.$this->lang->line('lang_delete_default').'</div>');
            }
        }
        //Return to languages list
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
}
