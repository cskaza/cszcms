<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
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
class Export extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->lang->load('admin', $this->Csz_admin_model->getLang());
        $this->template->set_template('admin');
        $this->_init();
        admin_helper::is_allowchk('export');
    }

    public function _init() {
        $this->template->set('core_css', $this->Csz_admin_model->coreCss());
        $this->template->set('core_js', $this->Csz_admin_model->coreJs());
        $this->template->set('title', 'Backend System | ' . $this->Csz_admin_model->load_config()->site_name);
        $this->template->set('meta_tags', $this->Csz_admin_model->coreMetatags('Backend System for CSZ Content Management System'));
        $this->template->set('cur_page', $this->Csz_admin_model->getCurPages());
    }

    public function index() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        $this->csz_referrer->setIndex('export');
        $this->load->helper('form');
        if($this->uri->segment(3) && $this->db->table_exists($this->uri->segment(3))){
            $this->template->setSub('fields', $this->db->list_fields($this->uri->segment(3)));
        }
        $this->template->setSub('tablelist', $this->db->list_tables());
        @array_map('unlink', glob(FCPATH . 'importcsv_*'));
        $this->template->loadSub('admin/export_index');
    }
    
    public function getCSV() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('save');
        if($this->uri->segment(4) && $this->db->table_exists($this->uri->segment(4))){
            $this->Csz_admin_model->exportCSV($this->uri->segment(4), $this->uri->segment(4), $this->input->get('fieldS'), '', $this->input->get('orderby', TRUE), $this->input->get('sort', TRUE));
        }else{
            redirect($this->csz_referrer->getIndex('export'), 'refresh');
        }
    }
    
    public function importCSV() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('save');
        if($this->uri->segment(4) && $this->db->table_exists($this->uri->segment(4))){
            if (function_exists('ini_set')) {
                @ini_set('max_execution_time', 600);
                @ini_set('memory_limit','512M');
            }
            $config['upload_path'] = FCPATH;
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '0';
            $file_name = 'importcsv_'.$this->uri->segment(4).'_'.time().'.csv';
            $config['file_name'] = $file_name;
            //load the upload library
            $this->load->library('upload', $config);
            @$this->upload->do_upload('import_csv');
            $newfname = FCPATH . $file_name;
            if (file_exists($newfname)) {
                $this->load->library('csvimport');
                $csv_array = $this->csvimport->get_array($newfname);
                if (!empty($csv_array)) {
                    $data = array();
                    $data_count = 1;
                    foreach ($csv_array as $row) {
                        $data_row = array();
                        foreach ($row as $key => $value) {
                            $data_row[$key] = $value;
                        }
                        $data[] = $data_row;
                        $data_count++;
                    }
                    $this->load->helper('form');
                    $this->template->setSub('fields', $this->db->list_fields($this->uri->segment(4)));
                    $this->template->setSub('csvdata', $data);
                    $this->template->setSub('data_count', $data_count);
                    $this->template->setSub('csvfile', str_replace('.csv', '', $file_name));
                    $this->template->setSub('csvfields', array_keys($data_row));
                    $this->template->setSub('primary_key', $this->Csz_admin_model->findPrimaryKey($this->uri->segment(4)));
                    $this->template->loadSub('admin/export_import');
                } else {
                    if (is_writable($newfname)) {
                        @unlink($newfname);
                    }
                    $this->session->set_flashdata('error_message', '<div class="alert alert-danger" role="alert">' . $this->lang->line('error_message_alert') . '</div>');
                    redirect($this->csz_referrer->getIndex('export'), 'refresh');
                }
            }else{
                $this->session->set_flashdata('error_message', '<div class="alert alert-danger" role="alert">' . $this->lang->line('error_message_alert') . '</div>');
                redirect($this->csz_referrer->getIndex('export'), 'refresh');
            }
        }else{
            redirect($this->csz_referrer->getIndex('export'), 'refresh');
        }
    }
    
    public function importDB() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('save');
        if($this->uri->segment(4) && $this->db->table_exists($this->uri->segment(4))){
            if (function_exists('ini_set')) {
                @ini_set('max_execution_time', 600);
                @ini_set('memory_limit','512M');
            }
            $primary_key = $this->Csz_admin_model->findPrimaryKey($this->uri->segment(4));
            $field = $this->input->post('field', TRUE);
            $csvfile = $this->input->post('csvfile', TRUE);
            $this->load->library('csvimport');
            $newfname = FCPATH . $csvfile.'.csv';
            $csv_array = $this->csvimport->get_array($newfname);
            if (!empty($csv_array)) {
                $data = array();
                foreach ($csv_array as $row) {
                    $data_row = array();
                    foreach ($row as $key => $value) {
                        $dbfield = $this->security->xss_clean($field[$this->Csz_model->cleanEmailFormat($key)]);
                        if ($dbfield) {
                            if ($this->input->post('csv_ignore', TRUE) == '1' && in_array($dbfield, (array) $primary_key)) {
                                $data_row[$dbfield] = '';
                            } else {
                                $data_row[$dbfield] = str_replace('&gt;', '>', $this->security->xss_clean($value));
                            }
                        }
                    }
                    $data[] = $data_row;
                }
                $this->db->insert_batch($this->uri->segment(4), $data);
                $this->db->cache_delete_all();
                if (is_writable($newfname)) {
                    @unlink($newfname);
                }
                $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
                redirect($this->csz_referrer->getIndex('export'), 'refresh');
            } else {
                if (is_writable($newfname)) {
                    @unlink($newfname);
                }
                $this->session->set_flashdata('error_message', '<div class="alert alert-danger" role="alert">' . $this->lang->line('error_message_alert') . '</div>');
                redirect($this->csz_referrer->getIndex('export'), 'refresh');
            }
        }else{
            redirect($this->csz_referrer->getIndex('export'), 'refresh');
        }
    }

}
