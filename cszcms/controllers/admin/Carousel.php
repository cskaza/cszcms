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
class Carousel extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->lang->load('admin', $this->Csz_admin_model->getLang());
        $this->template->set_template('admin');
        $this->_init();
        admin_helper::is_allowchk('carousel');
        $this->db->cache_on();
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
        $this->load->helper('form');
        $this->load->library('pagination');
        $this->csz_referrer->setIndex();
        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_model->countData('carousel_widget');
        $num_link = 10;
        $base_url = $this->Csz_model->base_link(). '/admin/carousel/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url,$total_row,$result_per_page,$num_link);     
        ($this->uri->segment(3))? $pagination = $this->uri->segment(3) : $pagination = 0;

        //Get users from database
        $this->template->setSub('carousel', $this->Csz_admin_model->getIndexData('carousel_widget', $result_per_page, $pagination, 'timestamp_create', 'desc'));
        $this->template->setSub('total_row',$total_row);
        //Load the view
        $this->template->loadSub('admin/carousel_index');
    }
    
    public function addNew() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');
        //Load the view
        $this->template->loadSub('admin/carousel_add');
    }

    public function insert() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('name', $this->lang->line('carousel_name'), 'required');
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->addNew();
        } else {
            //Validation passed
            //Add the user
            $this->Csz_admin_model->insertCarousel();
            //Return to user list
            $this->db->cache_delete_all();
            $this->Csz_model->clear_file_cache('carousel_*', TRUE);
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }
    
    public function editPhoto() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');
        $this->csz_referrer->setIndex('carousel_edit'); /* Set index page when redirect after save */
        if ($this->uri->segment(4)) {
            $carousel = $this->Csz_model->getValue('*', 'carousel_widget', 'carousel_widget_id', $this->uri->segment(4), 1);
            if($carousel !== FALSE){
                $this->template->setSub('carousel', $carousel);
                $this->load->library('pagination');            
                $search_arr = "carousel_widget_id = '".$this->uri->segment(4)."'";
                // Pages variable           
                $total_row = $this->Csz_model->countData('carousel_picture', $search_arr);           
                $this->template->setSub('showfile', $this->Csz_admin_model->getIndexData('carousel_picture', 0, 0, 'arrange', 'ASC', $search_arr));
                $this->template->setSub('total_row', $total_row);
                //Load the view
                $this->template->loadSub('admin/carousel_edit');
            }else{
                redirect($this->csz_referrer->getIndex(), 'refresh');
            }
        } else {
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }

    public function update() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('name', $this->lang->line('carousel_name'), 'required');
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->editPhoto();
        } else {
            //Validation passed
            if($this->uri->segment(4)){
                //Update the user
                $this->Csz_admin_model->updateCarousel($this->uri->segment(4));
                //Return to user list
                $this->db->cache_delete_all();
                $this->Csz_model->clear_file_cache('carousel_*', TRUE);
                $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            }          
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }
    
    public function addYoutube() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('save');
        if ($this->uri->segment(4)) {
            $carousel_type = $this->input->post('carousel_type', TRUE);
            $youtube_url = $this->input->post('youtube_url', TRUE);
            if ($youtube_url) {
                $this->Csz_admin_model->insertCarouselUpload($this->uri->segment(4), $carousel_type, '', $youtube_url);
                $this->db->cache_delete_all();
            }                
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex('carousel_edit'), 'refresh');
        } else {
            $this->session->set_flashdata('error_message', '<div class="alert alert-danger" role="alert">' . $this->lang->line('error_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex('carousel_edit'), 'refresh');
        }
    }
    
    public function addUrl() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('save');
        if ($this->uri->segment(4)) {
            $carousel_type = $this->input->post('carousel_type', TRUE);
            $photo_url = $this->input->post('photo_url', TRUE);
            if ($photo_url) {
                $this->Csz_admin_model->insertCarouselUpload($this->uri->segment(4), $carousel_type, '', '', $photo_url);
                $this->db->cache_delete_all();
            }                
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex('carousel_edit'), 'refresh');
        } else {
            $this->session->set_flashdata('error_message', '<div class="alert alert-danger" role="alert">' . $this->lang->line('error_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex('carousel_edit'), 'refresh');
        }
    }
    
    public function filesUpload() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('save');
        if ($this->uri->segment(4) && !empty($_FILES['files'])) {
            $carousel_type = $this->input->post('carousel_type', TRUE);
            $path = FCPATH . "/photo/carousel/";
            $files = $_FILES;
            $cpt = count($_FILES['files']['name']);
            for ($i = 0; $i < $cpt; $i++) {
                if ($files['files']['name'][$i]) {
                    $file_id = time() . "_" . rand(1111, 9999);
                    $photo_name = $files['files']['name'][$i];
                    $photo = $files['files']['tmp_name'][$i];
                    $file_id1 = $this->Csz_admin_model->file_upload($photo, $photo_name, '', $path, $file_id, '');
                    if ($file_id1) {
                        $this->Csz_admin_model->insertCarouselUpload($this->uri->segment(4), $carousel_type, $file_id1);
                    }
                }
            }
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex('carousel_edit'), 'refresh');
        } else {
            $this->session->set_flashdata('error_message', '<div class="alert alert-danger" role="alert">' . $this->lang->line('error_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex('carousel_edit'), 'refresh');
        }
    }
    
    public function filesSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('save');
        $path = FCPATH . "/photo/carousel/";
        $filedel = $this->input->post('filedel', TRUE);
        $caption = $this->input->post('caption', TRUE);
        $i = 0;
        $arrange = 1;
        $carousel_picture_id = $this->input->post('carousel_picture_id', TRUE);
        if (isset($filedel)) {
            admin_helper::is_allowchk('delete');
            foreach ($filedel as $value) {
                if ($value) {
                    $filename = $this->Csz_model->getValue('file_upload', 'carousel_picture', 'carousel_picture_id', $value, 1);
                    if ($filename->file_upload) {
                        @unlink($path . $filename->file_upload);
                    }
                    $this->Csz_admin_model->removeData('carousel_picture', 'carousel_picture_id', $value);
                }
            }
        }
        if (!empty($carousel_picture_id)) {
            while ($i < count($carousel_picture_id)) {
                if ($carousel_picture_id[$i]) {
                    $this->db->set('arrange', $arrange, FALSE);
                    $this->db->set('timestamp_update', $this->Csz_model->timeNow(), TRUE);
                    $this->db->where("carousel_picture_id", $carousel_picture_id[$i]);
                    $this->db->update('carousel_picture');
                    $arrange++;
                }
                $i++;
            }
        }
        if (isset($caption)) {
            foreach ($caption as $key => $value) {
                if ($value && $key) {
                    $this->db->set('caption', $value, TRUE);
                    $this->db->set('timestamp_update', $this->Csz_model->timeNow(), TRUE);
                    $this->db->where('carousel_picture_id', $key);
                    $this->db->update('carousel_picture');
                }
            }
        }
        $this->db->cache_delete_all();
        $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        redirect($this->csz_referrer->getIndex('carousel_edit'), 'refresh');
    }
    
    public function deleteIndex() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('delete');
        $delR = $this->input->post('delR');
        if(isset($delR)){
            foreach ($delR as $delV) {
                if ($delV) {
                    $path = FCPATH . "/photo/carousel/";
                    //Delete the data
                    $filedel = $this->Csz_model->getValue('*', 'carousel_picture', 'carousel_widget_id', $delV);
                    if (!empty($filedel)) {
                        foreach ($filedel as $value) {
                            if ($value) {
                                if ($value->file_upload) {
                                    @unlink($path . $value->file_upload);
                                }
                                $this->Csz_admin_model->removeData('carousel_picture', 'carousel_picture_id', $value->carousel_picture_id);
                            }
                        }
                    }
                    $this->Csz_admin_model->removeData('carousel_widget', 'carousel_widget_id', $delV);
                }
            }
        }
        $this->db->cache_delete_all();
        $this->Csz_model->clear_file_cache('carousel_*', TRUE);
        $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
}
