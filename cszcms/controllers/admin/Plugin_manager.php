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
        
        //Load the view
        $this->template->loadSub('admin/plugin_mgr_index');
    }

    public function install() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        /* upload zip file */
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
        }
        // When Success 
        $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('upgrade_success_alert') . '</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }

}
