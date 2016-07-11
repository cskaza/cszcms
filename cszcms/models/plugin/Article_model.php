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
            $data = array(
                'lang_name' => $this->input->post('lang_name', TRUE),
                'lang_iso' => $this->input->post('lang_iso', TRUE),
                'country' => $this->input->post('country', TRUE),
                'country_iso' => $this->input->post('country_iso', TRUE),
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
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        $data = array(
            'lang_name' => $this->input->post('lang_name', TRUE),
            'lang_iso' => $this->input->post('lang_iso', TRUE),
            'country' => $this->input->post('country', TRUE),
            'country_iso' => $this->input->post('country_iso', TRUE),
            'active' => $active,
        );
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->where('article_db_id', $id);
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
