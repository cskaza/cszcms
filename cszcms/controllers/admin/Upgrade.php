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
        $this->last_version = $this->Csz_model->getVersion('http://www.cszcms.com/downloads/lastest_version.xml');
    }

    public function index() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        $this->template->setSub('cur_version', $this->cur_version);
        $this->template->setSub('last_version', $this->last_version);
        $this->template->setSub('error', '');
        //Load the view
        $this->template->loadSub('admin/upgrade_index');
    }

    public function download() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        $lastversion = $this->Csz_admin_model->chkVerUpdate($this->cur_version);
        if ($lastversion !== FALSE) {
            // folder to save downloaded files to. must end with slash
            $url = "http://www.cszcms.com/downloads/upgrade/upgrade-" . $this->cur_version . "-to-" . $this->Csz_admin_model->findNextVersion($this->cur_version, $lastversion) . ".zip";
            $filename = basename($url);
            $newfname = FCPATH . $filename;
            $this->Csz_model->downloadFile($url, $newfname);
            /*$content = file_get_contents($url);
            file_put_contents($newfname, $content);*/
            if (file_exists($newfname)) {
                @$this->unzip->extract($newfname);
                if (file_exists(FCPATH . 'upgrade_sql/upgrade.sql')) {
                    $this->Csz_admin_model->execSqlFile(FCPATH . 'upgrade_sql/upgrade.sql');
                    delete_files(FCPATH . 'upgrade_sql', TRUE);
                    rmdir(FCPATH . 'upgrade_sql');
                }
                if(is_writable($newfname)){
                    delete_files($newfname);
                }
            }
            if($this->Csz_admin_model->chkVerUpdate($this->Csz_model->getVersion()) !== FALSE){
                redirect('/admin/upgrade/download', 'refresh');
            }else{
                $this->Csz_model->clear_all_cache();
                /* When Success */
                $this->template->setSub('cur_version', $this->last_version);
                $this->template->setSub('last_version', $this->last_version);
                $this->template->setSub('error', 'success');
                //Load the view
                $this->template->loadSub('admin/upgrade_index');
            }
        } else {
            $this->template->setSub('cur_version', $this->cur_version);
            $this->template->setSub('last_version', $this->last_version);
            $this->template->setSub('error', 'lastver');
            //Load the view
            $this->template->loadSub('admin/upgrade_index');
        }
    }
    
    public function dbOptimize() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        $this->load->dbutil();
        $result = $this->dbutil->optimize_database();
        if ($result !== FALSE){
            $this->template->setSub('cur_version', $this->cur_version);
            $this->template->setSub('last_version', $this->last_version);
            $this->template->setSub('error', 'opt_success');
            //Load the view
            $this->template->loadSub('admin/upgrade_index');
        }else{
            $this->template->setSub('cur_version', $this->cur_version);
            $this->template->setSub('last_version', $this->last_version);
            $this->template->setSub('error', 'opt_error');
            //Load the view
            $this->template->loadSub('admin/upgrade_index');
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
        redirect('admin/upgrade', 'refresh');
    }

}
