<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CSZ CMS
 *
 * An open source content management system
 *
 * Copyright (c) 2016, Astian Foundation.
 *
 * Astian Develop Public License (ADPL)
 * 
 * This Source Code Form is subject to the terms of the Astian Develop Public
 * License, v. 1.0. If a copy of the APL was not distributed with this
 * file, You can obtain one at http://astian.org/about-ADPL
 * 
 * @author	CSKAZA
 * @copyright   Copyright (c) 2016, Astian Foundation.
 * @license	http://astian.org/about-ADPL	ADPL License
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 */
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
        $this->last_version = $this->Csz_admin_model->getLatestVersion();
    }

    public function index() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('maintenance');
        $this->csz_referrer->setIndex();
        $this->session->unset_userdata('cszcms_lastver');
        $this->load->helper('directory');
        $this->template->setSub('cur_version', $this->cur_version);
        $this->template->setSub('last_version', $this->last_version);
        $this->template->setSub('logsdir', directory_map(APPPATH . '/logs/', 1));
        //Load the view
        $this->template->loadSub('admin/upgrade_index');
    }

    public function download() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('maintenance');
        admin_helper::is_allowchk('save');
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set('memory_limit','1024M');
        }
        $lastversion = $this->Csz_admin_model->chkVerUpdate($this->cur_version);
        if ($lastversion !== FALSE) {
            $nextversion = $this->Csz_admin_model->findNextVersion($this->cur_version);
            $url1 = $this->config->item('csz_upgrade_server_1') . "upgrade-to-" . $nextversion . ".zip";
            $url2 = $this->config->item('csz_upgrade_server_2') . "upgrade-to-" . $nextversion . ".zip";
            if($this->Csz_model->is_url_exist($url1) !== FALSE){
                $url = &$url1; /* Main Link */
            }else if($this->Csz_model->is_url_exist($url1) === FALSE && $this->Csz_model->is_url_exist($url2) !== FALSE){
                $url = &$url2; /* Backup Link */
            }
            $newfname = FCPATH . basename($url);
            if($this->Csz_model->downloadFile($url, $newfname) !== FALSE){
                $this->Csz_admin_model->setMaintenance();
                if (file_exists($newfname)) {
                    $unzip = @$this->unzip->extract($newfname, FCPATH);
                    if(!empty($unzip)){
                        if (file_exists(FCPATH . 'upgrade_sql/upgrade.sql')) {
                            $this->Csz_admin_model->execSqlFile(FCPATH . 'upgrade_sql/upgrade.sql');
                            delete_files(FCPATH . 'upgrade_sql', TRUE);
                            rmdir(FCPATH . 'upgrade_sql');
                        }
                        if(is_writable($newfname)){
                            @unlink($newfname);
                        }
                    }else{
                        if(is_writable($newfname)){
                            @unlink($newfname);
                        }
                        $this->session->set_flashdata('error_message','<div class="alert alert-danger" role="alert">'.$this->lang->line('error_message_alert').'</div>');
                        redirect($this->csz_referrer->getIndex(), 'refresh');
                    }
                }
                if($this->Csz_admin_model->chkVerUpdate($this->Csz_model->getVersion()) !== FALSE){
                    redirect('/admin/upgrade/download', 'refresh');
                }else{
                    $this->Csz_admin_model->unsetMaintenance();
                    $this->Csz_model->clear_all_cache();
                    $this->db->cache_delete_all();
                    // When Success 
                    $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('upgrade_success_alert').'</div>');
                    redirect($this->csz_referrer->getIndex(), 'refresh');
                }
            }else{
                $this->session->set_flashdata('error_message','<div class="alert alert-danger" role="alert">'.$this->lang->line('error_message_alert').'</div>');
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }
        } else {
            $this->session->set_flashdata('error_message','<div class="alert alert-info" role="alert">'.$this->lang->line('upgrade_lastver_alert').'</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }
    
    public function install() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('maintenance');
        admin_helper::is_allowchk('save');
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set('memory_limit','1024M');
        }
        /* upload zip file */
        $zip_ext = array('application/x-zip', 'application/zip', 'application/x-zip-compressed', 'application/s-compressed', 'multipart/x-zip');
        if ($_FILES['file_upload'] != null) {
            if (in_array($_FILES['file_upload']['type'], $zip_ext)) {
                $config['upload_path'] = FCPATH;
                /* set the filter image types Ex. zip|rar|7z */
                $config['allowed_types'] = 'zip';
                $file_name = 'manualzip_'.time().'.zip';
                $config['file_name'] = $file_name;
                //load the upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $this->upload->set_allowed_types('*');
                @$this->upload->do_upload('file_upload');
                $newfname = FCPATH . $file_name;
                if (file_exists($newfname)) {
                    $this->Csz_admin_model->setMaintenance();
                    @$this->unzip->extract($newfname, FCPATH);
                    if (file_exists(FCPATH . 'upgrade_sql/upgrade.sql')) { /* for sql upgrade  */
                        $this->Csz_admin_model->execSqlFile(FCPATH . 'upgrade_sql/upgrade.sql');
                        delete_files(FCPATH . 'upgrade_sql', TRUE);
                        rmdir(FCPATH . 'upgrade_sql');
                    }
                    if (file_exists(FCPATH . 'plugin_sql/install.sql')) { /* for sql plugin install or upgrade  */
                        $this->Csz_admin_model->execSqlFile(FCPATH . 'plugin_sql/install.sql');
                        delete_files(FCPATH . 'plugin_sql', TRUE);
                        rmdir(FCPATH . 'plugin_sql');
                    }
                    if (is_writable($newfname)) {
                        @unlink($newfname);
                    }
                    $this->Csz_admin_model->unsetMaintenance();
                    $this->Csz_model->clear_all_cache();
                    $this->db->cache_delete_all();
                    $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
                } else {
                    $this->session->set_flashdata('error_message', '<div class="alert alert-danger" role="alert">' . $this->lang->line('error_message_alert') . '</div>');
                }
            } else {
                $this->session->set_flashdata('error_message', '<div class="alert alert-danger" role="alert">' . $this->lang->line('pluginmgr_zip_remark') . '</div>');
            }
        } else {
            $this->session->set_flashdata('error_message', '<div class="alert alert-danger" role="alert">' . $this->lang->line('error_message_alert') . '</div>');
        }
        // When Success 
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function dbOptimize() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('maintenance');
        admin_helper::is_allowchk('save');
        $this->load->dbutil();
        $result = $this->dbutil->optimize_database();
        if ($result !== FALSE){
            $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('optimize_success_alert').'</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }else{
            $this->session->set_flashdata('error_message','<div class="alert alert-danger" role="alert">'.$this->lang->line('optimize_error_alert').'</div>');
            redirect('admin/upgrade', 'refresh');
        }
    }
    
    public function dbBackup() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('maintenance');
        admin_helper::is_allowchk('save');
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set('memory_limit','1024M');
        }
        $this->load->dbutil();
        $prefs = array(
                'format'      => 'txt',             // gzip, zip, txt
                'filename'    => DB_NAME . '.sql',    // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );
        $backup = $this->dbutil->backup($prefs);
        $this->load->helper('download');
        force_download(DB_NAME . '_'.date('Ymd').'.sql', $backup);
    }
    
    public function fileBackup() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('maintenance');
        admin_helper::is_allowchk('save');
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set('memory_limit','1024M');
        }
        @array_map('unlink', glob(FCPATH.'/'.EMAIL_DOMAIN . '_*'));
        $this->load->library('zip');
        $this->zip->clear_data();
        $this->load->helper('directory');
        foreach (directory_map('templates/', 1) as $t) {
            if (!is_dir($t)) {
                $t = str_replace("\\", "", $t);
                $t = str_replace("/", "", $t);
                if (($t != "index.html" && $t != ".htaccess") && ($t != "admin") && (strpos($t, 'admin') === false) && ($t != "cszdefault") && (strpos($t, 'cszdefault') === false)) {
                    $this->zip->read_dir('templates/' . $t . '/');
                }
            }
        }
        foreach (directory_map('cszcms/views/templates/', 1) as $t) {
            if (!is_dir($t)) {
                $t = str_replace("\\", "", $t);
                $t = str_replace("/", "", $t);
                if (($t != "index.html") && ($t != "admin") && (strpos($t, 'admin') === false) && ($t != "cszdefault") && (strpos($t, 'cszdefault') === false)) {
                    $this->zip->read_dir('cszcms/views/templates/' . $t . '/');
                }
            }
        }
        $this->zip->read_file(FCPATH . '/.htaccess', '.htaccess');
        $this->zip->read_file(FCPATH . '/config.inc.php', 'config.inc.php');
        $this->zip->read_file(FCPATH . '/htaccess.config.inc.php', 'htaccess.config.inc.php');
        $zip_filename = EMAIL_DOMAIN . '_files_'.date('Ymd').'.zip';
        $this->zip->archive(FCPATH . '/' . $zip_filename);
        $this->load->helper('download');
        force_download(FCPATH . '/' . $zip_filename, NULL);
    }
    
    public function photoBackup() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('maintenance');
        admin_helper::is_allowchk('save');
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set('memory_limit','1024M');
        }
        @array_map('unlink', glob(FCPATH.'/'.EMAIL_DOMAIN . '_*'));
        $this->load->library('zip');
        $this->zip->clear_data();
        $this->zip->read_dir('photo/');
        $zip_filename = EMAIL_DOMAIN . '_photo_'.date('Ymd').'.zip';
        $this->zip->archive(FCPATH . '/' . $zip_filename);
        $this->load->helper('download');
        force_download(FCPATH . '/' . $zip_filename, NULL);
    }
    
    public function clearAllCache() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('maintenance');
        admin_helper::is_allowchk('save');
        $this->Csz_model->clear_all_cache();
        @array_map('unlink', glob(FCPATH.'/'.EMAIL_DOMAIN . '_*'));
        @$this->db->empty_table('save_formdraft');
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('clearallcache_success_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function clearAllDBCache() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('maintenance');
        admin_helper::is_allowchk('save');
        $this->db->cache_delete_all();
        @array_map('unlink', glob(FCPATH.'/'.EMAIL_DOMAIN . '_*'));
        @$this->db->empty_table('save_formdraft');
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('clearalldbcache_success_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function clearAllSession() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('maintenance');
        admin_helper::is_allowchk('delete');
        $this->Csz_model->clear_all_session();
        @array_map('unlink', glob(FCPATH.'/'.EMAIL_DOMAIN . '_*'));
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect('admin/logout', 'refresh');
    }

    public function clearAllErrLog() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('maintenance');
        admin_helper::is_allowchk('delete');
        $this->Csz_model->clear_all_error_log();
        @array_map('unlink', glob(FCPATH.'/'.EMAIL_DOMAIN . '_*'));
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect('admin/upgrade', 'refresh');
    }
    
    public function downloadErrLog() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('maintenance');
        admin_helper::is_allowchk('save');
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set('memory_limit','1024M');
        }
        $log_file = $this->input->post('errlogfile', TRUE);
        if($log_file){
            $log_file = $this->security->sanitize_filename($log_file);
            $data = read_file(APPPATH . '/logs/'.$log_file);
            $string = str_replace("<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>", '', $data);
            $this->load->helper('download');
            force_download('error_'.str_replace('.php', '', $log_file).'.txt', $string);
        }else{
            $this->session->set_flashdata('error_message','<div class="alert alert-danger" role="alert">'.$this->lang->line('error_message_alert').'</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }
}
