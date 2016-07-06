<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Plugin_manager extends CI_Controller {

    var $cur_version;
    var $last_version;

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->library('unzip');
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
        $this->cur_version = $this->Csz_model->getVersion();
        $this->last_version = $this->Csz_admin_model->getLatestVersion()->version;
    }

    public function index() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        $this->csz_referrer->setIndex();

        $this->load->helper('form');
        $this->load->library('pagination');
        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_model->countData('plugin_manager');
        $num_link = 10;
        $base_url = BASE_URL . '/admin/plugin/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link);
        ($this->uri->segment(3)) ? $pagination = $this->uri->segment(3) : $pagination = 0;

        //Get users from database
        $this->template->setSub('plugin_mgr', $this->Csz_admin_model->getIndexData('plugin_manager', $result_per_page, $pagination, 'timestamp_create', 'desc'));
        $this->template->setSub('total_row', $total_row);

        //Load the view
        $this->template->loadSub('admin/plugin_mgr_index');
    }

    public function install() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        /* upload zip file */
        $zip_ext = array('application/x-zip', 'application/zip', 'application/x-zip-compressed', 'application/s-compressed', 'multipart/x-zip');
        if($_FILES['file_upload'] != null){
            if (in_array($_FILES['file_upload']['type'], $zip_ext)) {
                $paramiter = '_1';
                $photo_id = time();
                $uploaddir = 'photo/plugin/';
                $file_f = $_FILES['file_upload']['tmp_name'];
                $file_name = $_FILES['file_upload']['name'];
                $upload_file = $this->Csz_admin_model->file_upload($file_f, $file_name, '', $uploaddir, $photo_id, $paramiter);
                $newfname = FCPATH.$uploaddir.$upload_file;
                if (file_exists($newfname)) {
                    @$this->unzip->extract($newfname, FCPATH);
                    if (file_exists(FCPATH . 'plugin_sql/install.sql')) {
                        $this->Csz_admin_model->execSqlFile(FCPATH . 'plugin_sql/install.sql');
                        delete_files(FCPATH . 'plugin_sql', TRUE);
                        rmdir(FCPATH . 'plugin_sql');
                    }
                    if (is_writable($newfname)) {
                        @unlink($newfname);
                    }
                    $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
                }else{
                    $this->session->set_flashdata('error_message','<div class="alert alert-danger" role="alert">'.$this->lang->line('error_message_alert').'</div>');
                }
            }else{
                $this->session->set_flashdata('error_message','<div class="alert alert-danger" role="alert">'.$this->lang->line('pluginmgr_zip_remark').'</div>');
            }
        }else{
            $this->session->set_flashdata('error_message','<div class="alert alert-danger" role="alert">'.$this->lang->line('error_message_alert').'</div>');
        }
        // When Success 
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }

}
