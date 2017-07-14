<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

class Gallery_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function insert() {
        // Create the new lang
        $arrange = $this->Csz_model->getLastID('gallery_db', 'arrange');
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        $url_rewrite = $this->Csz_model->rw_link($this->input->post('album_name', TRUE));
        $this->db->set('album_name', $this->input->post('album_name', TRUE));
        $this->db->set('url_rewrite', $url_rewrite);
        $this->db->set('keyword', $this->input->post('keyword', TRUE));
        $this->db->set('short_desc', $this->input->post('short_desc', TRUE));
        $this->db->set('lang_iso', $this->input->post('lang_iso', TRUE));
        $this->db->set('active', $active);
        $this->db->set('arrange', ($arrange)+1);
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->insert('gallery_db');
    }
    
    public function update($id) {
        // Create the new lang
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        $url_rewrite = $this->Csz_model->rw_link($this->input->post('album_name', TRUE));
        $this->db->set('album_name', $this->input->post('album_name', TRUE));
        $this->db->set('url_rewrite', $url_rewrite);
        $this->db->set('keyword', $this->input->post('keyword', TRUE));
        $this->db->set('short_desc', $this->input->post('short_desc', TRUE));
        $this->db->set('lang_iso', $this->input->post('lang_iso', TRUE));
        $this->db->set('active', $active);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->where("gallery_db_id", $id);
        $this->db->update('gallery_db');
    }
    
    public function delete($id) {
        if($id){
            $this->Csz_admin_model->removeData('gallery_db', 'gallery_db_id', $id);
        }else{
            return FALSE;
        }
    }
    
    public function insertFileUpload($gallery_db_id, $gallery_type, $fileupload = '', $youtube_url = '') {
        $img_rs = $this->Csz_model->getValue('arrange', 'gallery_picture', "gallery_db_id", $gallery_db_id, 1, 'arrange', 'desc');
        if(!empty($img_rs)){
            $arrange = $img_rs->arrange;
        }else{
            $arrange = 0;
        }
        $data = array(
            'gallery_db_id' => $gallery_db_id,
            'arrange' => ($arrange)+1,
        );
        if($fileupload){ $this->db->set('file_upload', $fileupload, TRUE); }
        $this->db->set('gallery_type', $gallery_type, TRUE);
        if($youtube_url){ $this->db->set('youtube_url', $youtube_url, TRUE); }
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->insert('gallery_picture', $data);
    }
    
    public function getFirstImgs($gallery_db_id) {
        $no_img = base_url().'photo/no_image.png';
        if($gallery_db_id){
            $img_rs = $this->Csz_model->getValue('file_upload,gallery_type,youtube_url', 'gallery_picture', "gallery_db_id", $gallery_db_id, 1, 'arrange', 'asc');
            if(!empty($img_rs)){
                if($img_rs->gallery_type == 'multiimages'){
                    if($img_rs->file_upload){
                        return base_url().'photo/plugin/gallery/'.$img_rs->file_upload;
                    }else{
                        return $no_img;
                    }                   
                }else if($img_rs->gallery_type == 'youtubevideos'){
                    $youtube_script_replace = array("http://youtu.be/", "http://www.youtube.com/watch?v=", "https://youtu.be/", "https://www.youtube.com/watch?v=", "http://www.youtube.com/embed/", "https://www.youtube.com/embed/");
                    $youtube_value = str_replace($youtube_script_replace, '', $img_rs->youtube_url);
                    return '//i1.ytimg.com/vi/'.$youtube_value.'/mqdefault.jpg';
                }else{
                    return $no_img;
                }                
            }else{
                return $no_img;
            }
        }else{
            return FALSE;
        }
    }
    
}
