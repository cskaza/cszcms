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
class Plugin_manager extends CI_Controller {

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
    }

    public function index() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('plugin manager');
        $this->db->cache_on();
        $this->csz_referrer->setIndex();
        $this->load->helper('form');
        
        $total_row = $this->Csz_model->countData('plugin_manager');
        
        //Get users from database
        $this->template->setSub('plugin_mgr', $this->Csz_model->getValueArray('*', 'plugin_manager', '', ''));
        $this->template->setSub('total_row', $total_row);
        $this->template->setSub('plugin_list', $this->Csz_admin_model->getPluginXML());

        //Load the view
        $this->template->loadSub('admin/plugin_mgr_index');
    }

    public function setstatus() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('plugin manager');
        admin_helper::is_allowchk('save');
        if ($this->uri->segment(4)) {
            $status = $this->Csz_model->getValue('plugin_active', 'plugin_manager', "plugin_config_filename != '' AND plugin_manager_id = '".$this->uri->segment(4)."'", '', 1);
            if ($status->plugin_active) {
                $this->db->set('plugin_active', 0, FALSE);
                $this->db->set('timestamp_update', 'NOW()', FALSE);
                $this->db->where('plugin_manager_id', $this->uri->segment(4));
                $this->db->update('plugin_manager');
            } else {
                $this->db->set('plugin_active', 1, FALSE);
                $this->db->set('timestamp_update', 'NOW()', FALSE);
                $this->db->where('plugin_manager_id', $this->uri->segment(4));
                $this->db->update('plugin_manager');
            }
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        } else {
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }
    
    public function install() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('plugin manager');
        admin_helper::is_allowchk('save');
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set('memory_limit','1024M');
        }
        if ($this->uri->segment(4) && $this->Csz_admin_model->chkPluginInst($this->uri->segment(4)) === FALSE) {
            $version = $this->Csz_admin_model->pluginLatestVer($this->uri->segment(4));
            $url1 = $this->config->item('csz_plugin_install_server_1') . $this->uri->segment(4)."-install-" . $version . ".zip";
            $url2 = $this->config->item('csz_plugin_install_server_2') . $this->uri->segment(4)."-install-" . $version . ".zip";
            if($this->Csz_model->is_url_exist($url1) !== FALSE){
                $url = &$url1; /* Main Link */
            }else if($this->Csz_model->is_url_exist($url1) === FALSE && $this->Csz_model->is_url_exist($url2) !== FALSE){
                $url = &$url2; /* Backup Link */
            }
            $newfname = FCPATH . basename($url);
            if($this->Csz_model->downloadFile($url, $newfname) !== FALSE){
                if (file_exists($newfname)) {
                    $unzip = @$this->unzip->extract($newfname, FCPATH);
                    if(!empty($unzip)){
                        if (file_exists(FCPATH . 'plugin_sql/install.sql')) {
                            $this->Csz_admin_model->execSqlFile(FCPATH . 'plugin_sql/install.sql');
                            delete_files(FCPATH . 'plugin_sql', TRUE);
                            rmdir(FCPATH . 'plugin_sql');
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
                $this->db->cache_delete_all();
                $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }else{
                $this->session->set_flashdata('error_message', '<div class="alert alert-danger" role="alert">' . $this->lang->line('error_message_alert') . '</div>');
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }
        } else {
            $this->session->set_flashdata('error_message', '<div class="alert alert-danger" role="alert">' . $this->lang->line('error_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }
    
    public function upgrade() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('plugin manager');
        admin_helper::is_allowchk('save');
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set('memory_limit','1024M');
        }
        if ($this->uri->segment(4) && $this->Csz_admin_model->chkPluginInst($this->uri->segment(4)) !== FALSE) {
            $last_ver = $this->Csz_admin_model->pluginLatestVer($this->uri->segment(4));
            $cur_ver = $this->Csz_model->getPluginConfig($this->uri->segment(4), 'plugin_version');
            if($this->Csz_admin_model->chkPluginUpdate($cur_ver, $last_ver) !== FALSE){
                $nextversion = $this->Csz_admin_model->pluginNextVer($cur_ver, $last_ver);
                $url1 = $this->config->item('csz_plugin_upgrade_server_1') . $this->uri->segment(4)."-upgrade-" . $nextversion . ".zip";
                $url2 = $this->config->item('csz_plugin_upgrade_server_2') . $this->uri->segment(4)."-upgrade-" . $nextversion . ".zip";
                if($this->Csz_model->is_url_exist($url1) !== FALSE){
                    $url = &$url1; /* Main Link */
                }else if($this->Csz_model->is_url_exist($url1) === FALSE && $this->Csz_model->is_url_exist($url2) !== FALSE){
                    $url = &$url2; /* Backup Link */
                }
                $newfname = FCPATH . basename($url);
                if($this->Csz_model->downloadFile($url, $newfname) !== FALSE){
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
                    if($this->Csz_admin_model->chkPluginUpdate($this->Csz_model->getPluginConfig($this->uri->segment(4), 'plugin_version'), $last_ver) !== FALSE){
                        redirect('/admin/plugin/upgrade/' . $this->uri->segment(4), 'refresh');
                    }else{
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
            }else{
                $this->session->set_flashdata('error_message','<div class="alert alert-info" role="alert">'.$this->lang->line('pluginmgr_latest_already').'</div>');
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }
        } else {
            $this->session->set_flashdata('error_message', '<div class="alert alert-danger" role="alert">' . $this->lang->line('error_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

}
