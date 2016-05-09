<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forms extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('admin_helper');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Csz_admin_model');
        $this->load->model('Csz_model');
        define('LANG', $this->Csz_admin_model->getLang());
        $this->lang->load('admin', LANG);
        $this->load->model('Headfoot_html');
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

        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_admin_model->countTable('form_main');
        $num_link = 10;
        $base_url = BASE_URL . '/admin/forms/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url,$total_row,$result_per_page,$num_link);  
        ($this->uri->segment(3))? $pagination = ($this->uri->segment(3)) : $pagination = 1;        

        //Get users from database
        $this->template->setSub('forms', $this->Csz_admin_model->getIndexData('form_main', $result_per_page, $pagination-1, 'form_main_id', 'asc'));

        //Load the view
        $this->template->loadSub('admin/forms_index');
    }

    public function addForms() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        
        //Load the form helper
        $this->load->helper('form');
        //Load the view
        $this->template->loadSub('admin/forms_add');
    }

    public function insert() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('form_name', 'Forms Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->addForms();
        } else {            
            //Validation passed
            //Add the user
            $this->Csz_admin_model->insertForms();
            //Return to user list
            redirect('/admin/forms', 'refresh');
        }
    }

    public function editForms() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');

        if($this->uri->segment(4)){
            //Get data from database
            $this->template->setSub('form_rs', $this->Csz_model->getValue('*', 'form_main', 'form_main_id', $this->uri->segment(4), 1));
            $this->template->setSub('field_rs', $this->Csz_model->getValue('*', 'form_field', 'form_main_id', $this->uri->segment(4)));
            //Load the view
            $this->template->loadSub('admin/forms_edit');
        }else{
            redirect('/admin/forms', 'refresh');
        }
    }

    public function edited() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('form_name', 'Forms Name', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->editForms();
        } else {
            //Validation passed
            //Update the user
            $this->Csz_admin_model->updateForms($this->uri->segment(4));
            //Return to user list
            redirect('/admin/forms', 'refresh');
        }
    }

    public function delete() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Delete the languages
        if($this->uri->segment(4)) {
            $frm_rs = $this->Csz_model->getValue('form_name', 'form_main', 'form_main_id', $this->uri->segment(4), 1);
            $this->Csz_admin_model->dropTable('form_'.$frm_rs->form_name);
            $this->Csz_admin_model->removeData('form_field', 'form_main_id', $this->uri->segment(4));
            $this->Csz_admin_model->removeData('form_main', 'form_main_id', $this->uri->segment(4));
        }
        
        //Return to languages list
        redirect('admin/forms', 'refresh');
    }
    
    public function viewForm() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        if($this->uri->segment(4)){
            $this->load->library('pagination');
            // Get form name
            $frm_rs = $this->Csz_model->getValue('form_name', 'form_main', 'form_main_id', $this->uri->segment(4), 1);
            // Pages variable
            $result_per_page = 20;
            $total_row = $this->Csz_admin_model->countTable('form_'.$frm_rs->form_name);
            $num_link = 10;
            $base_url = BASE_URL . '/admin/forms/view/'.$this->uri->segment(4).'/';
            // Pageination config
            $this->Csz_admin_model->pageSetting($base_url,$total_row,$result_per_page,$num_link);       
            ($this->uri->segment(5))? $pagination = ($this->uri->segment(5)) : $pagination = 1;     
            //Get users from database   
            $this->template->setSub('form_name', $frm_rs->form_name);
            $this->template->setSub('field_rs', $this->Csz_model->getValue('*', 'form_field', 'form_main_id', $this->uri->segment(4)));
            $this->template->setSub('post_rs', $this->Csz_admin_model->getIndexData('form_'.$frm_rs->form_name, $result_per_page, $pagination-1));
            //Load the view
            $this->template->loadSub('admin/forms_view');
        }else{
            redirect('admin/forms', 'refresh');
        }
    }
    
    public function deleteViewData() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Delete the languages
        if($this->uri->segment(4) && $this->uri->segment(6)) {
            $frm_rs = $this->Csz_model->getValue('form_name', 'form_main', 'form_main_id', $this->uri->segment(4), 1);
            $this->Csz_admin_model->removeData('form_'.$frm_rs->form_name, 'form_'.$frm_rs->form_name.'_id', $this->uri->segment(6));
        }
        
        //Return to languages list
        redirect('admin/forms/view/'.$this->uri->segment(4), 'refresh');
    }
}
