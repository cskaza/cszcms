<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Upgrade extends CI_Controller {

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
        $this->template->setSub('cur_version', $this->cur_version);
        $this->template->setSub('last_version', $this->last_version);
        //Load the view
        $this->template->loadSub('admin/upgrade_index');
    }

    public function download() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        $lastversion = $this->Csz_admin_model->chkVerUpdate($this->cur_version);
        if ($lastversion !== FALSE) {
            $url = "http://www.cszcms.com/downloads/upgrade/upgrade-to-" . $this->Csz_admin_model->findNextVersion($this->cur_version) . ".zip";
            $newfname = FCPATH . basename($url);
            $this->Csz_model->downloadFile($url, $newfname);
            if (file_exists($newfname)) {
                @$this->unzip->extract($newfname, FCPATH);
                if (file_exists(FCPATH . 'upgrade_sql/upgrade.sql')) {
                    $this->Csz_admin_model->execSqlFile(FCPATH . 'upgrade_sql/upgrade.sql');
                    delete_files(FCPATH . 'upgrade_sql', TRUE);
                    rmdir(FCPATH . 'upgrade_sql');
                }
                if(is_writable($newfname)){
                    @unlink($newfname);
                }
            }
            if($this->Csz_admin_model->chkVerUpdate($this->Csz_model->getVersion()) !== FALSE){
                redirect('/admin/upgrade/download', 'refresh');
            }else{
                $this->Csz_model->clear_all_cache();
                // When Success 
                $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('upgrade_success_alert').'</div>');
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }
        } else {
            $this->session->set_flashdata('error_message','<div class="alert alert-info" role="alert">'.$this->lang->line('upgrade_lastver_alert').'</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }
    
    public function dbOptimize() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        $this->load->dbutil();
        $result = $this->dbutil->optimize_database();
        if ($result !== FALSE){
            $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('optimize_success_alert').'</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }else{
            $this->session->set_flashdata('error_message','<div class="alert alert-danger" role="alert">'.$this->lang->line('optimize_error_alert').'</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }
    
    public function dbBackup() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        $this->load->dbutil();
        $prefs = array(
                'format'      => 'txt',             // gzip, zip, txt
                'filename'    => 'cszcmsbackup.sql',    // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );
        $backup =& $this->dbutil->backup($prefs);
        $this->load->helper('download');
        force_download('cszcmsbackup_'.date('Ymd').'.sql', $backup);
    }
    
    public function clearAllCache() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        $this->Csz_model->clear_all_cache();
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('clearallcache_success_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }

    public function clearAllErrLog() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        $this->Csz_model->clear_all_error_log();
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
}
