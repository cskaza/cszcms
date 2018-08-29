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
class Pwidget extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->lang->load('admin', $this->Csz_admin_model->getLang());
        $this->template->set_template('admin');
        $this->_init();
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
        admin_helper::is_allowchk('plugin widget');
        $this->load->library('pagination');
        $this->db->cache_on();
        $this->csz_referrer->setIndex();
        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_admin_model->countTable('plugin_widget');
        $num_link = 10;
        $base_url = $this->Csz_model->base_link(). '/admin/pwidget/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link);
        ($this->uri->segment(3)) ? $pagination = ($this->uri->segment(3)) : $pagination = 0;

        //Get users from database
        $this->template->setSub('widget', $this->Csz_admin_model->getIndexData('plugin_widget', $result_per_page, $pagination, 'plugin_widget_id', 'ASC'));

        //Load the view
        $this->template->loadSub('admin/pwidget_index');
    }

    public function addWidget() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('plugin widget');
        $js_more = $this->Csz_admin_model->getSaveDraftJS();
        $js_more.= "
        function genCode(){
                var plugin_filename = $('#plugin_filename').val();
                var data_limit = $('#data_limit').val();
                var view_id = $('#view_id').val();
                var field_html = '';
                var otherfield_html = '';
                if(plugin_filename){
                    $.ajax({
                            dataType: 'json',
                            url:'".$this->Csz_model->base_link()."/admin/pwidget/getOthertableFieldAjax/'+plugin_filename,
                            success:function(other){
                                for (j = 0; j < other.length; j++) {
                                    if(view_id != '' && view_id != 0){ otherfield_html += '{field=' + other[j] + '} ';}
                                }
                            }
                    });
                    $.ajax({
                        dataType: 'json',
                        url:'".$this->Csz_model->base_link()."/admin/pwidget/getFieldAjax/'+plugin_filename,
                        success:function(html){
                            for (i = 0; i < html.length; i++) {
                                field_html += '{field=' + html[i] + '} ';
                            }
                            if(data_limit == 1 && view_id != '' && view_id != 0){
                                $('#main_field_rs').html(field_html);
                                if(otherfield_html != ''){
                                    $('#field_rs').html(otherfield_html);
                                }else{
                                    $('#field_rs').html('-');
                                }
                            }else if(data_limit > 1 && view_id != '' && view_id != 0){
                                $('#main_field_rs').html(field_html);
                                if(otherfield_html != ''){
                                    $('#field_rs').html(otherfield_html);
                                }else{
                                    $('#field_rs').html('-');
                                }
                            }else if(data_limit == 1 && (view_id == '' || view_id == 0)){
                                $('#main_field_rs').html(field_html);
                                $('#field_rs').html('-');
                            }else if(data_limit > 1 && (view_id == '' || view_id == 0)){
                                $('#main_field_rs').html('');
                                $('#field_rs').html(field_html);
                            }
                        }
                    }); 
                }
        }
        function getAjax(){
                var plugin_filename = $('#plugin_filename').val();
                $('#sort_by').children('option:not(:first)').remove();
                if(plugin_filename){
                    $.ajax({
                        dataType: 'json',
                        url:'".$this->Csz_model->base_link()."/admin/pwidget/getFieldAjax/'+plugin_filename,
                        success:function(html){
                            for (i = 0; i < html.length; i++) {
                                $('#sort_by').append('<option value=\"' + html[i] + '\">' + html[i] + '</option>');
                            }
                        }
                    }); 
                }
        }
        $(document).ready(function(){
            $('#plugin_filename').change(function() {
                getAjax();
            });
            getAjax();
            genCode();
        });";
        $this->template->set('extra_js', '<script type="text/javascript">'.$js_more.'</script>');
        //Load the form helper
        $this->load->helper('form');
        $this->template->setSub('getPlugin', $this->Csz_admin_model->getAllPluginWidget());
        $this->template->setSub('lang', $this->Csz_model->loadAllLang());
        //Load the view
        $this->template->loadSub('admin/pwidget_add');
    }

    public function insert() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('plugin widget');
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('name', $this->lang->line('pwidget_name'), 'required');
        $this->form_validation->set_rules('plugin_filename', $this->lang->line('pwidget_plugin'), 'required');
        $this->form_validation->set_rules('sort_by', $this->lang->line('pwidget_sort_by'), 'required');
        $this->form_validation->set_rules('view_id', $this->lang->line('pwidget_plugin_view_id'), 'numeric');
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->addWidget();
        } else {
            //Validation passed
            //Add the user
            $this->Csz_admin_model->insertPWidget();
            //Return to user list
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function editWidget() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('plugin widget');
        $js_more = "
        function genCode(){
                var plugin_filename = $('#plugin_filename').val();
                var data_limit = $('#data_limit').val();
                var view_id = $('#view_id').val();
                var field_html = '';
                var otherfield_html = '';
                if(plugin_filename){
                    $.ajax({
                            dataType: 'json',
                            url:'".$this->Csz_model->base_link()."/admin/pwidget/getOthertableFieldAjax/'+plugin_filename,
                            success:function(other){
                                for (j = 0; j < other.length; j++) {
                                    if(view_id != '' && view_id != 0){ otherfield_html += '{field=' + other[j] + '} ';}
                                }
                            }
                    });
                    $.ajax({
                        dataType: 'json',
                        url:'".$this->Csz_model->base_link()."/admin/pwidget/getFieldAjax/'+plugin_filename,
                        success:function(html){
                            for (i = 0; i < html.length; i++) {
                                field_html += '{field=' + html[i] + '} ';
                            }
                            if(data_limit == 1 && view_id != '' && view_id != 0){
                                $('#main_field_rs').html(field_html);
                                if(otherfield_html != ''){
                                    $('#field_rs').html(otherfield_html);
                                }else{
                                    $('#field_rs').html('-');
                                }
                            }else if(data_limit > 1 && view_id != '' && view_id != 0){
                                $('#main_field_rs').html(field_html);
                                if(otherfield_html != ''){
                                    $('#field_rs').html(otherfield_html);
                                }else{
                                    $('#field_rs').html('-');
                                }
                            }else if(data_limit == 1 && (view_id == '' || view_id == 0)){
                                $('#main_field_rs').html(field_html);
                                $('#field_rs').html('-');
                            }else if(data_limit > 1 && (view_id == '' || view_id == 0)){
                                $('#main_field_rs').html('');
                                $('#field_rs').html(field_html);
                            }
                        }
                    }); 
                }
        }
        function getAjax(){
                var plugin_filename = $('#plugin_filename').val();
                $('#sort_by').children('option:not(:first)').remove();
                if(plugin_filename){
                    $.ajax({
                        dataType: 'json',
                        url:'".$this->Csz_model->base_link()."/admin/pwidget/getFieldAjax/'+plugin_filename,
                        success:function(html){
                            for (i = 0; i < html.length; i++) {
                                $('#sort_by').append('<option value=\"' + html[i] + '\">' + html[i] + '</option>');
                            }
                        }
                    }); 
                }
        }
        $(document).ready(function(){
            $('#plugin_filename').change(function() {
                getAjax();
            });
            getAjax();
            genCode();
        });";
        $this->template->set('extra_js', '<script type="text/javascript">'.$js_more.'</script>');
        //Load the form helper
        $this->load->helper('form');
        if ($this->uri->segment(4)) {
            $this->db->cache_on();
            $widget = $this->Csz_model->getValue('*', 'plugin_widget', 'plugin_widget_id', $this->uri->segment(4), 1);
            if($widget !== FALSE){
                $this->template->setSub('widget', $widget);
                $this->template->setSub('getPlugin', $this->Csz_admin_model->getAllPluginWidget());
                $this->template->setSub('lang', $this->Csz_model->loadAllLang());
                //Load the view
                $this->template->loadSub('admin/pwidget_edit');
            }else{
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }
        } else {
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function edited() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('plugin widget');
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('name', $this->lang->line('pwidget_name'), 'required');
        $this->form_validation->set_rules('plugin_filename', $this->lang->line('pwidget_plugin'), 'required');
        $this->form_validation->set_rules('sort_by', $this->lang->line('pwidget_sort_by'), 'required');
        $this->form_validation->set_rules('view_id', $this->lang->line('pwidget_plugin_view_id'), 'numeric');
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->editWidget();
        } else {
            //Validation passed
            if($this->uri->segment(4)){
                //Update the user
                $this->Csz_admin_model->updatePWidget($this->uri->segment(4));
                //Return to user list
                $this->db->cache_delete_all();
                $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            }          
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function delete() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('plugin widget');
        admin_helper::is_allowchk('delete');
        if ($this->uri->segment(4)) {
            //Delete the widget
            $this->Csz_admin_model->removeData('plugin_widget', 'plugin_widget_id', $this->uri->segment(4));
            $this->db->cache_delete_all();
            $this->Csz_model->clear_file_cache('pwidget_*', TRUE);
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        }
        //Return to widget list
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function getFieldAjax(){
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('plugin widget');
        header('Content-Type: application/json; charset=utf-8');
        if ($this->uri->segment(4)) {
            $plugin_widget_sel_field = $this->Csz_model->getPluginConfig($this->uri->segment(4), 'plugin_widget_sel_field');
            if($plugin_widget_sel_field !== FALSE && $plugin_widget_sel_field != NULL){
                echo json_encode($plugin_widget_sel_field, JSON_UNESCAPED_UNICODE);
            }else{
                echo json_encode(NULL, JSON_UNESCAPED_UNICODE);
            }
        }else{
            echo json_encode(NULL, JSON_UNESCAPED_UNICODE);
        }
        exit();
    }
    
    public function getOthertableFieldAjax(){
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('plugin widget');
        header('Content-Type: application/json; charset=utf-8');
        if ($this->uri->segment(4)) {
            $plugin_widget_othertable_selfield = $this->Csz_model->getPluginConfig($this->uri->segment(4), 'plugin_widget_othertable_selfield');
            if($plugin_widget_othertable_selfield !== FALSE && $plugin_widget_othertable_selfield != NULL){
                echo json_encode($plugin_widget_othertable_selfield, JSON_UNESCAPED_UNICODE);
            }else{
                echo json_encode(NULL, JSON_UNESCAPED_UNICODE);
            }
        }else{
            echo json_encode(NULL, JSON_UNESCAPED_UNICODE);
        }
        exit();
    }
    
    public function asCopy() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('plugin widget');
        admin_helper::is_allowchk('save');
        if($this->uri->segment(4)){
            $widget = $this->Csz_model->getValue('*', 'plugin_widget', 'plugin_widget_id', $this->uri->segment(4), 1);
            if($widget !== FALSE){
                $data = array(
                    'name' => $this->Csz_model->findNameAsCopy('plugin_widget', 'plugin_widget_id', $widget->name),
                    'plugin_filename' => $widget->plugin_filename,
                    'sort_by' => $widget->sort_by,
                    'active' => 0,
                    'data_limit' => $widget->data_limit,
                    'view_id' => $widget->view_id,
                    'template_code' => $widget->template_code,
                    'lang_iso' => $widget->lang_iso,
                );
                $this->Csz_model->insertAsCopy('plugin_widget', $data);
                $this->db->cache_delete_all();
            }
        }
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }

}
