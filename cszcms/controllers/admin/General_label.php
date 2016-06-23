<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class General_label extends CI_Controller {

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
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        $this->load->library('pagination');
        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_admin_model->countTable('general_label');
        $num_link = 10;
        $base_url = BASE_URL . '/admin/genlabel/';
        
        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url,$total_row,$result_per_page,$num_link); 
        ($this->uri->segment(3))? $pagination = ($this->uri->segment(3)) : $pagination = 0;
        
        //Get users from database
        $this->template->setSub('genlab', $this->Csz_admin_model->getIndexData('general_label', $result_per_page, $pagination, 'general_label_id', 'ASC'));
        $lang = $this->Csz_model->getValueArray('lang_name', 'lang_iso', "active", '1');
        foreach ($lang as $l) { 
            if($l['lang_name']) $lang_arr[] = $l['lang_name'];
        }
        $this->template->setSub('lang_show', implode(", ", $lang_arr));

        //Load the view
        $this->template->loadSub('admin/genlabel_index');
    }

    public function edit() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        //Load the form helper
        $this->load->helper('form');
        if($this->uri->segment(4)){
            //Get user details from database
            $this->template->setSub('genlab', $this->Csz_model->getValue('*', 'general_label', 'general_label_id', $this->uri->segment(4), 1));
            $this->template->setSub('lang', $this->Csz_model->getValueArray('lang_name', 'lang_iso', "active", '1'));
            //Load the view
            $this->template->loadSub('admin/genlabel_edit');
        }else{
            redirect('/admin/genlabel', 'refresh');
        }
    }

    public function updated() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
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
            redirect('/admin/genlabel', 'refresh');
        }
    }
    
}
