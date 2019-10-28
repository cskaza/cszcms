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
class Gallery extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('file');
        $this->lang->load('admin', $this->Csz_admin_model->getLang());
        $this->lang->load('plugin/gallery', $this->Csz_admin_model->getLang());
        $this->template->set_template('admin');
        $this->load->model('plugin/Gallery_model');
        $this->_init();
        admin_helper::plugin_not_active('gallery');
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
        admin_helper::is_allowchk('gallery');
        $this->db->cache_on();
        $this->csz_referrer->setIndex('gallery'); /* Set index page when redirect after save */
        $search_arr = "1";
        if ($this->input->get('search')) {
            $search_arr.= " AND album_name LIKE '%" . $this->input->get('search', TRUE) . "%' OR short_desc LIKE '%" . $this->input->get('search', TRUE) . "%'";          
        }
        if (!$this->input->get('lang')) {
            $search_arr.= " AND lang_iso = '" . $this->Csz_model->getDefualtLang() . "'";
        }else if($this->input->get('lang')){
            $search_arr.= " AND lang_iso = '" . $this->input->get('lang', TRUE) . "'";
        }
        $this->load->helper('form');
        
        $total_row = $this->Csz_model->countData('gallery_db', $search_arr);
        //Get users from database
        $this->template->setSub('gallery', $this->Gallery_model->getValueArray('gallery_db', $search_arr));
        $this->template->setSub('total_row', $total_row);
        $this->template->setSub('lang', $this->Csz_model->loadAllLang());

        //Load the view
        $this->template->loadSub('admin/plugin/gallery/gallery_index');
    }

    public function add() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('gallery');
        $this->template->set('extra_js', '<script type="text/javascript">'.$this->Csz_admin_model->getSaveDraftJS().'</script>');
        //Load the form helper
        $this->load->helper('form');
        $this->template->setSub('lang', $this->Csz_model->loadAllLang());
        $this->template->setSub('user_groups', $this->Csz_auth_model->get_group_all());
        //Load the view
        $this->template->loadSub('admin/plugin/gallery/gallery_add');
    }

    public function addSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('gallery');
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('album_name', 'Album Name', 'required');
        $this->form_validation->set_rules('short_desc', 'Short Description', 'required');
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->add();
        } else {
            //Validation passed
            //Add the user
            $this->Gallery_model->insert();
            $this->Csz_model->clear_file_cache('gallery_RSS');
            $this->Csz_model->clear_file_cache('gallery_getWidget_*', TRUE);
            $this->db->cache_delete_all();
            redirect($this->csz_referrer->getIndex('gallery'), 'refresh');
        }
    }

    public function edit() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('gallery');
        //Load the form helper
        $this->load->helper('form');
        $this->csz_referrer->setIndex('gallery_edit'); /* Set index page when redirect after save */
        if ($this->uri->segment(5)) {
            $album = $this->Csz_model->getValue('*', 'gallery_db', 'gallery_db_id', $this->uri->segment(5), 1);
            if($album === FALSE){
                redirect($this->csz_referrer->getIndex('gallery'), 'refresh');
                exit();
            }
            $this->template->setSub('album', $album);
            $this->template->setSub('lang', $this->Csz_model->loadAllLang());
            $this->template->setSub('user_groups', $this->Csz_auth_model->get_group_all());
            $this->load->library('pagination');
            
            $search_arr = "gallery_db_id = '".$this->uri->segment(5)."'";
            // Pages variable           
            $total_row = $this->Csz_model->countData('gallery_picture', $search_arr);           
            $this->template->setSub('showfile', $this->Csz_admin_model->getIndexData('gallery_picture', 0, 0, 'arrange', 'ASC', $search_arr));
            $this->template->setSub('total_row', $total_row);
            //Load the view
            $this->template->loadSub('admin/plugin/gallery/gallery_edit');
        } else {
            redirect($this->csz_referrer->getIndex('gallery'), 'refresh');
        }
    }

    public function editSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('gallery');
        admin_helper::is_allowchk('save');
        if ($this->uri->segment(5)) {
            //Load the form validation library
            $this->load->library('form_validation');
            //Set validation rules
            $this->form_validation->set_rules('album_name', 'Album Name', 'required');
            $this->form_validation->set_rules('short_desc', 'Short Description', 'required');
            if ($this->form_validation->run() == FALSE) {
                //Validation failed
                $this->edit();
            } else {
                //Validation passed
                //Add the user
                $this->Gallery_model->update($this->uri->segment(5));
                $this->Csz_model->clear_file_cache('gallery_RSS');
                $this->Csz_model->clear_file_cache('gallery_getWidget_*', TRUE);
                $this->db->cache_delete_all();
                redirect($this->csz_referrer->getIndex('gallery'), 'refresh');
            }
        } else {
            redirect($this->csz_referrer->getIndex('gallery'), 'refresh');
        }
    }
    
    public function addYoutube() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('gallery');
        admin_helper::is_allowchk('save');
        if ($this->uri->segment(5)) {
            $gallery_type = $this->input->post('gallery_type', TRUE);
            $youtube_url = preg_replace('/\s+/', '', $this->input->post('youtube_url', TRUE));
            if ($youtube_url) {
                $this->Gallery_model->insertFileUpload($this->uri->segment(5), $gallery_type, '', $youtube_url);
                $this->db->cache_delete_all();
            }
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex('gallery_edit'), 'refresh');
        } else {
            $this->session->set_flashdata('error_message', '<div class="alert alert-danger" role="alert">' . $this->lang->line('error_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex('gallery_edit'), 'refresh');
        }
    }

    public function htmlUpload() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('gallery');
        admin_helper::is_allowchk('save');
        if ($this->uri->segment(5) && !empty($_FILES['files'])) {
            $gallery_type = $this->input->post('gallery_type', TRUE);
            $path = FCPATH . "/photo/plugin/gallery/";
            $files = $_FILES;
            $cpt = count($_FILES['files']['name']);
            for ($i = 0; $i < $cpt; $i++) {
                if ($files['files']['name'][$i]) {
                    $file_id = time() . "_" . rand(1111, 9999);
                    $photo_name = $files['files']['name'][$i];
                    $photo = $files['files']['tmp_name'][$i];
                    $file_id1 = $this->Csz_admin_model->file_upload($photo, $photo_name, '', $path, $file_id, '');
                    if ($file_id1) {
                        $this->Gallery_model->insertFileUpload($this->uri->segment(5), $gallery_type, $file_id1);
                    }
                }
            }
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex('gallery_edit'), 'refresh');
        } else {
            $this->session->set_flashdata('error_message', '<div class="alert alert-danger" role="alert">' . $this->lang->line('error_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex('gallery_edit'), 'refresh');
        }
    }

    public function uploadIndexSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('gallery');
        admin_helper::is_allowchk('save');
        $path = FCPATH . "/photo/plugin/gallery/";
        $filedel = $this->input->post('filedel', TRUE);
        $caption = $this->input->post('caption', TRUE);
        $i = 0;
        $arrange = 1;
        $gallery_picture_id = $this->input->post('gallery_picture_id', TRUE);
        if (isset($filedel)) {
            admin_helper::is_allowchk('delete');
            foreach ($filedel as $value) {
                if ($value) {
                    $filename = $this->Csz_model->getValue('file_upload', 'gallery_picture', 'gallery_picture_id', $value, 1);
                    if ($filename->file_upload) {
                        @unlink($path . $filename->file_upload);
                    }
                    $this->Csz_admin_model->removeData('gallery_picture', 'gallery_picture_id', $value);
                }
            }
        }
        if (!empty($gallery_picture_id)) {
            while ($i < count($gallery_picture_id)) {
                if ($gallery_picture_id[$i]) {
                    $this->db->set('arrange', $arrange, FALSE);
                    $this->db->set('timestamp_update', $this->Csz_model->timeNow(), TRUE);
                    $this->db->where("gallery_picture_id", $gallery_picture_id[$i]);
                    $this->db->update('gallery_picture');
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
                    $this->db->where('gallery_picture_id', $key);
                    $this->db->update('gallery_picture');
                }
            }
        }
        $this->db->cache_delete_all();
        $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        redirect($this->csz_referrer->getIndex('gallery_edit'), 'refresh');
    }
    
    public function albumIndexSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('gallery');
        admin_helper::is_allowchk('save');
        if($this->Gallery_model->getConfig()->gallery_sort != 'newest' && $this->Gallery_model->getConfig()->gallery_sort != 'oldest'){
            $i = 0;
            $arrange = 1;
            $gallery_db_id = $this->input->post('gallery_db_id', TRUE);
            if (!empty($gallery_db_id)) {
                while ($i < count($gallery_db_id)) {
                    if ($gallery_db_id[$i]) {
                        $this->db->set('arrange', $arrange, FALSE);
                        $this->db->set('timestamp_update', $this->Csz_model->timeNow(), TRUE);
                        $this->db->where("gallery_db_id", $gallery_db_id[$i]);
                        $this->db->update('gallery_db');
                        $arrange++;
                    }
                    $i++;
                }
            }
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        }
        redirect($this->csz_referrer->getIndex('gallery'), 'refresh');
    }

    public function delete() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('gallery');
        admin_helper::is_allowchk('delete');
        if ($this->uri->segment(5)) {
            $path = FCPATH . "/photo/plugin/gallery/";
            //Delete the data
            $filedel = $this->Csz_model->getValue('*', 'gallery_picture', 'gallery_db_id', $this->uri->segment(5));
            if (!empty($filedel)) {
                foreach ($filedel as $value) {
                    if ($value) {
                        if ($value->file_upload) {
                            @unlink($path . $value->file_upload);
                        }
                        $this->Csz_admin_model->removeData('gallery_picture', 'gallery_picture_id', $value->gallery_picture_id);
                    }
                }
            }
            $this->Gallery_model->delete($this->uri->segment(5));
            $this->Csz_model->clear_file_cache('gallery_RSS');
            $this->Csz_model->clear_file_cache('gallery_getWidget_*', TRUE);
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        }
        redirect($this->csz_referrer->getIndex('gallery'), 'refresh');
    }
    
    public function configSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('gallery');
        admin_helper::is_allowchk('save');
        $this->Gallery_model->updateConfig();
        $this->Csz_model->clear_file_cache('gallery_config');
        $this->db->cache_delete_all();
        $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        redirect($this->csz_referrer->getIndex('gallery'), 'refresh');
    }
    
    public function asCopy() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('gallery');
        admin_helper::is_allowchk('save');
        if($this->uri->segment(5)){
            $gallery = $this->Csz_model->getValue('*', 'gallery_db', "gallery_db_id", $this->uri->segment(5), 1);
            if($gallery !== FALSE){
                $data = array(
                    'album_name' => $this->Csz_model->findNameAsCopy('gallery_db', 'gallery_db_id', $gallery->album_name),
                    'url_rewrite' => $this->Csz_model->findNameAsCopy('gallery_db', 'gallery_db_id', $gallery->url_rewrite, TRUE),
                    'keyword' => $gallery->keyword,
                    'short_desc' => $gallery->short_desc,
                    'lang_iso' => $gallery->lang_iso,
                    'arrange' => $this->Csz_model->getLastID('gallery_db', 'arrange')+1,
                    'active' => 0,
                );
                $this->Csz_model->insertAsCopy('gallery_db', $data);
                $this->db->cache_delete_all();
            }
            $gallery_img = $this->Csz_model->getValueArray('*', 'gallery_picture', "gallery_db_id", $this->uri->segment(5));
            if($gallery_img !== FALSE){
                foreach ($gallery_img as $value) {
                    $data = array(
                        'gallery_db_id' => $this->Csz_model->getLastID('gallery_db', 'gallery_db_id'),
                        'file_upload' => $value['file_upload'],
                        'caption' => $value['caption'],
                        'arrange' => $this->Csz_model->getLastID('gallery_picture', 'arrange', "gallery_db_id = '".$this->uri->segment(5)."'")+1,
                        'gallery_type' => $value['gallery_type'],
                        'youtube_url ' => $value['youtube_url'],
                    );
                    $this->Csz_model->insertAsCopy('gallery_picture', $data);
                }
                $this->db->cache_delete_all();
            }
        }
        redirect($this->csz_referrer->getIndex('gallery'), 'refresh');
    }

}
