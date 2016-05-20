<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Upgrade extends CI_Controller {

    var $cur_version;
    var $last_version;

    function __construct() {
        parent::__construct();
        $this->load->helper('admin_helper');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('unzip');
        $this->load->model('Csz_admin_model');
        $this->load->model('Csz_model');
        $this->load->helper('form');
        $this->load->helper("file");
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
        $this->cur_version = $this->Csz_model->getVersion();
        $this->last_version = $this->Csz_model->getVersion('http://www.cszcms.com/downloads/lastest_version.xml');
    }

    public function index() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));

        $this->template->setSub('cur_version', $this->cur_version);
        $this->template->setSub('last_version', $this->last_version);
        $this->template->setSub('error', '');
        //Load the view
        $this->template->loadSub('admin/upgrade_index');
    }

    public function download() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        $lastversion = $this->Csz_admin_model->chkVerUpdate($this->cur_version);
        if ($lastversion !== FALSE) {
            // maximum execution time in seconds
            set_time_limit(24 * 60 * 60);
            // folder to save downloaded files to. must end with slash
            $url = "http://www.cszcms.com/downloads/upgrade/upgrade-" . $this->cur_version . "-to-" . $this->Csz_admin_model->findNextVersion($this->cur_version, $lastversion) . ".zip";
            $filename = basename($url);
            $newfname = FCPATH . $filename;
            $content = file_get_contents($url);
            file_put_contents($newfname, $content);
            if (file_exists($newfname)) {
                $this->unzip->extract($newfname);
                $this->Csz_admin_model->execSqlFile(FCPATH . 'upgrade_sql/upgrade.sql');
                delete_files($newfname);
                delete_files(FCPATH . 'upgrade_sql', TRUE);
                rmdir(FCPATH . 'upgrade_sql');
            }

            /* When Success */
            $this->template->setSub('cur_version', $this->cur_version);
            $this->template->setSub('last_version', $this->last_version);
            $this->template->setSub('error', 'success');
            //Load the view
            $this->template->loadSub('admin/upgrade_index');
        } else {
            $this->template->setSub('cur_version', $this->cur_version);
            $this->template->setSub('last_version', $this->last_version);
            $this->template->setSub('error', 'lastver');
            //Load the view
            $this->template->loadSub('admin/upgrade_index');
        }
    }

}
