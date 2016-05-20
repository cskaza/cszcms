<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

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
        $this->template->loadSub('admin/home');
    }

    public function login() {
        admin_helper::for_not_login($this->session->userdata('admin_email'));
        //Load the form helper

        $this->template->setSub('error', '');
        $this->load->helper('form');
        $this->template->loadSub('admin/login');
    }

    public function loginCheck() {
        admin_helper::for_not_login($this->session->userdata('admin_email'));
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $result = $this->Csz_admin_model->login($email, $password);
        if ($result == 'SUCCESS') {
            redirect('admin', 'refresh');
        } else {
            $this->template->setSub('error', $result);
            $this->load->helper('form');
            $this->template->loadSub('admin/login');
        }
    }

    public function logout() {
        $data = array(
            'user_admin_id' => '',
            'admin_name' => '',
            'admin_email' => '',
            'admin_logged_in' => FALSE,
        );
        $this->session->unset_userdata($data);
        $this->session->sess_destroy();
        redirect('admin', 'refresh');
    }

    public function social() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');

        $this->template->setSub('social', $this->Csz_admin_model->getSocial());
        $this->template->loadSub('admin/social');
    }

    public function updateSocial() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        $this->Csz_admin_model->updateSocial();
        redirect('admin/social', 'refresh');
    }

    public function settings() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');
        $this->load->helper('directory');
        $this->load->helper('url');
        $this->template->setSub('themesdir', directory_map(APPPATH . '/views/templates/', 1));
        $this->template->setSub('langdir', directory_map(APPPATH . '/language/', 1));

        $this->template->setSub('settings', $this->Csz_admin_model->load_config());
        $this->template->loadSub('admin/settings');
    }

    public function updateSettings() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        $this->Csz_admin_model->updateSettings();
        redirect('/admin/settings', 'refresh');
    }

    public function uploadIndex() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('pagination');

        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_admin_model->countTable('upload_file');
        $num_link = 10;
        $base_url = BASE_URL . '/admin/uploadindex/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link);
        ($this->uri->segment(3)) ? $pagination = ($this->uri->segment(3)) : $pagination = 1;

        $this->template->setSub('showfile', $this->Csz_admin_model->getIndexData('upload_file', $result_per_page, $pagination-1));
        $this->template->loadSub('admin/upload_index');
    }

    public function uploadIndexSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        $path = FCPATH . "/photo/upload/";
        $filedel = $this->input->post('filedel');
        foreach ($filedel as $value) {
            if ($value) {
                $filename = $this->Csz_model->getValue('file_upload', 'upload_file', 'upload_file_id', $value, 1);
                if($filename->file_upload){
                    @unlink($path . $filename->file_upload);
                }
                $this->Csz_admin_model->removeData('upload_file', 'upload_file_id', $value);
            }
        }
        redirect('/admin/uploadindex', 'refresh');
    }

    public function htmlUpload() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        $this->load->helper('url');
        if ($this->uri->segment(3)) {
            $year = $this->uri->segment(3);
        } else {
            $year = date("Y");
        }
        $path = FCPATH . "/photo/upload/";
        $files = $_FILES;
        $cpt = count($_FILES['files']['name']);
        for($i=0; $i<$cpt; $i++) {   
            if($files['files']['name'][$i]){
                $file_id = time() . "_" . rand(1111, 9999);
                $photo_name = $files['files']['name'][$i];
                $photo = $files['files']['tmp_name'][$i];
                $file_id1 = $this->Csz_admin_model->file_upload($photo, $photo_name, '', $path, $file_id, '', $year);
                if ($file_id1) {
                    $this->Csz_admin_model->insertFileUpload($year, $file_id1);
                }
            }
        }        
        redirect('/admin/uploadindex', 'refresh');
    }

}
