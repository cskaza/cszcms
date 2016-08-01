<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

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
        $this->csz_referrer->setIndex();
        $this->template->setSub('email_logs', $this->Csz_model->getValueArray('*', 'email_logs', "ip_address != ''", '', 10, 'timestamp_create', 'desc'));
        $this->template->setSub('link_stats', $this->Csz_model->getValueArray('*', 'link_statistic', "ip_address != ''", '', 20, 'timestamp_create', 'desc'));
        $this->template->setSub('total_emaillogs', $this->Csz_model->countData('email_logs'));
        $this->template->setSub('total_linkstats', $this->Csz_model->countData('link_statistic'));
        $this->template->setSub('total_member', $this->Csz_model->countData('user_admin',"user_type = 'member'"));
        $this->template->loadSub('admin/home');
    }
    
    public function deleteEmailLogs() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        //Delete the languages
        if($this->uri->segment(4)) {
            $this->Csz_admin_model->removeData('email_logs', 'email_logs_id', $this->uri->segment(4));
            $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        }
        //Return to languages list
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }

    public function login() {
        admin_helper::login_already($this->session->userdata('admin_email'));
        //Load the form helper

        $this->template->setSub('error', '');
        $this->load->helper('form');
        $this->template->loadSub('admin/login');
    }

    public function loginCheck() {
        admin_helper::login_already($this->session->userdata('admin_email'));
        //Load the form validation library
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', $this->lang->line('login_email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('password', $this->lang->line('login_password'), 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_message('valid_email', $this->lang->line('valid_email'));
        $this->form_validation->set_message('required', $this->lang->line('required'));
        $this->form_validation->set_message('min_length', $this->lang->line('min_length'));
        $this->form_validation->set_message('max_length', $this->lang->line('max_length'));
        if ($this->form_validation->run() == FALSE) {
            $this->login();
        }else{
            $email = $this->input->post('email', TRUE);
            $password = sha1(md5($this->input->post('password', TRUE)));
            $result = $this->Csz_admin_model->login($email, $password);
            if ($result == 'SUCCESS') {
                $url_return = $this->input->post('url_return', TRUE);
                if($url_return){
                    redirect($url_return, 'refresh');
                }else{
                    redirect(BASE_URL.'/admin', 'refresh');
                }
            } else {
                $this->template->setSub('error', $result);
                $this->load->helper('form');
                $this->template->loadSub('admin/login');
            }
        } 
    }

    public function logout() {
        $data = array(
            'user_admin_id' => '',
            'admin_name' => '',
            'admin_email' => '',
            'admin_type' => '',
            'admin_logged_in' => FALSE,
        );
        $this->session->unset_userdata($data);
        $this->session->sess_destroy();
        redirect(BASE_URL.'/admin', 'refresh');
    }

    public function social() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->csz_referrer->setIndex();
        $this->load->helper('form');

        $this->template->setSub('social', $this->Csz_admin_model->getSocial());
        $this->template->loadSub('admin/social');
    }

    public function updateSocial() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        $this->Csz_admin_model->updateSocial();
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function genSitemap() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        $this->load->model('Csz_sitemap');
        $this->Csz_sitemap->runSitemap();
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }

    public function settings() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        //Load the form helper
        $this->csz_referrer->setIndex();
        $this->load->helper('form');
        $this->load->helper('directory');
        $this->load->model('Csz_sitemap');
        $this->template->setSub('themesdir', directory_map(APPPATH . '/views/templates/', 1));
        $this->template->setSub('langdir', directory_map(APPPATH . '/language/', 1));
        $this->template->setSub('sitemaptime', $this->Csz_sitemap->getFileTime());

        $this->template->setSub('settings', $this->Csz_admin_model->load_config());
        $this->template->loadSub('admin/settings');
    }

    public function updateSettings() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        $this->Csz_admin_model->updateSettings();
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function uploadIndex() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->csz_referrer->setIndex();
        $this->load->helper('form');
        $this->load->library('pagination');

        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_admin_model->countTable('upload_file');
        $num_link = 10;
        $base_url = BASE_URL . '/admin/uploadindex/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link);
        ($this->uri->segment(3)) ? $pagination = ($this->uri->segment(3)) : $pagination = 0;

        $this->template->setSub('showfile', $this->Csz_admin_model->getIndexData('upload_file', $result_per_page, $pagination));
        $this->template->loadSub('admin/upload_index');
    }
    
    public function uploadDownload() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        if($this->uri->segment(3)){
            $file = $this->Csz_model->getValue('file_upload', 'upload_file', "upload_file_id", $this->uri->segment(3), 1);
            $path = FCPATH."/photo/upload/".$file->file_upload;
            $this->load->helper('file');
            $data = read_file($path);
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $filename = strtolower(pathinfo($path, PATHINFO_FILENAME));
            $this->load->helper('download');
            force_download($filename.'.'.$ext, $data);
        }else{
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function uploadIndexSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        $path = FCPATH . "/photo/upload/";
        $filedel = $this->input->post('filedel');
        if(isset($filedel)){
            foreach ($filedel as $value) {
                if ($value) {
                    $filename = $this->Csz_model->getValue('file_upload', 'upload_file', 'upload_file_id', $value, 1);
                    if($filename->file_upload){
                        @unlink($path . $filename->file_upload);
                    }
                    $this->Csz_admin_model->removeData('upload_file', 'upload_file_id', $value);
                }
            }
        }
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }

    public function htmlUpload() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
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
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }

}
