<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function insert() {
        // Create the new lang
        $is_category = $this->input->post('is_category', TRUE);
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        if($is_category){
            $data = array(
                'category_name' => $this->input->post('category_name', TRUE),
                'main_cat_id' => $this->input->post('main_cat_id', TRUE),
            );
        }else{
            $upload_file = '';
            if ($_FILES['file_upload']['type'] == 'image/png' || $_FILES['file_upload']['type'] == 'image/jpg' || $_FILES['file_upload']['type'] == 'image/jpeg' || $_FILES['file_upload']['type'] == 'image/gif') {
                    $paramiter = '_1';
                    $photo_id = time();
                    $uploaddir = 'photo/plugin/article/';
                    $file_f = $_FILES['file_upload']['tmp_name'];
                    $file_name = $_FILES['file_upload']['name'];
                    $upload_file = $this->Csz_admin_model->file_upload($file_f, $file_name, '', $uploaddir, $photo_id, $paramiter);
            }
            $data = array(
                'main_picture' => $upload_file,
                'title' => $this->input->post('title', TRUE),
                'keyword' => $this->input->post('keyword', TRUE),
                'short_desc' => $this->input->post('short_desc', TRUE),
                'content' => $this->input->post('content', TRUE),
                'cat_id' => $this->input->post('cat_id', TRUE),
            );
        }
        $this->db->set('is_category', $is_category);
        $this->db->set('active', $active);
        $this->db->set('user_admin_id', $this->session->userdata('user_admin_id'));
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->insert('article_db', $data);
    }
    
    public function update($id) {
        // Create the new lang
        $is_category = $this->input->post('is_category', TRUE);
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        if($is_category){
            $data = array(
                'category_name' => $this->input->post('category_name', TRUE),
                'main_cat_id' => $this->input->post('main_cat_id', TRUE),
            );
        }else{
            if ($this->input->post('del_file')) {
                $upload_file = '';
                unlink('photo/plugin/article/' . $this->input->post('del_file', TRUE));
            } else {
                $upload_file = $this->input->post('mainPicture');
                if ($_FILES['file_upload']['type'] == 'image/png' || $_FILES['file_upload']['type'] == 'image/jpg' || $_FILES['file_upload']['type'] == 'image/jpeg') {
                    $paramiter = '_1';
                    $photo_id = time();
                    $uploaddir = 'photo/plugin/article/';
                    $file_f = $_FILES['file_upload']['tmp_name'];
                    $file_name = $_FILES['file_upload']['name'];
                    $upload_file = $this->file_upload($file_f, $file_name, $this->input->post('siteLogo', TRUE), $uploaddir, $photo_id, $paramiter);
                }
            }
            $data = array(
                'main_picture' => $upload_file,
                'title' => $this->input->post('title', TRUE),
                'keyword' => $this->input->post('keyword', TRUE),
                'short_desc' => $this->input->post('short_desc', TRUE),
                'content' => $this->input->post('content', TRUE),
                'cat_id' => $this->input->post('cat_id', TRUE),
            );
        }
        $this->db->set('is_category', $is_category);
        $this->db->set('active', $active);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->where("article_db_id", $id);
        $this->db->update('article_db', $data);
    }
    
    public function delete($id) {
        if($id){
            $row = $this->Csz_model->getValue('*', 'article_db', 'article_db_id', $id, 1);
            if($row->is_category){
                if(!$row->main_cat_id){
                    $this->db->set('main_cat_id', 0);
                    $this->db->set('timestamp_update', 'NOW()', FALSE);
                    $this->db->where('main_cat_id',$id);
                    $this->db->update('article_db');
                }
                $this->db->set('cat_id', 0);
                $this->db->set('timestamp_update', 'NOW()', FALSE);
                $this->db->where('cat_id',$id);
                $this->db->update('article_db');
            }
            $this->Csz_admin_model->removeData('article_db', 'article_db_id', $id);
        }else{
            return FALSE;
        }
    }
    
}
