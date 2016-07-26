<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function insert() {
        // Create the new lang
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        $url_rewrite = $this->Csz_model->rw_link($this->input->post('album_name', TRUE));
        $this->db->set('album_name', $this->input->post('album_name', TRUE));
        $this->db->set('url_rewrite', $url_rewrite);
        $this->db->set('keyword', $this->input->post('keyword', TRUE));
        $this->db->set('short_desc', $this->input->post('short_desc', TRUE));
        $this->db->set('lang_iso', $this->input->post('lang_iso', TRUE));
        $this->db->set('active', $active);
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
    
    public function insertFileUpload($gallery_db_id, $fileupload) {
        $data = array(
            'gallery_db_id' => $gallery_db_id,
            'file_upload' => $fileupload,
        );
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->insert('gallery_picture', $data);
    }
    
    public function getFirstImgs($gallery_db_id) {
        if($gallery_db_id){
            $img_rs = $this->Csz_model->getValue('file_upload', 'gallery_picture', "gallery_db_id", $gallery_db_id, 1, 'arrange', 'asc');
            if(!empty($img_rs)){
                return $img_rs->file_upload;
            }else{
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }
    
}
