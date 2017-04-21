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

}
