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
            $url_rewrite = $this->Csz_model->rw_link($this->input->post('category_name', TRUE));
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
                'content' => str_replace(' class="container"', '', $this->input->post('content', TRUE)),
                'cat_id' => $this->input->post('cat_id', TRUE),
            );
            $url_rewrite = $this->Csz_model->rw_link($this->input->post('title', TRUE));
        }
        $this->db->set('url_rewrite', $url_rewrite);
        $this->db->set('lang_iso', $this->input->post('lang_iso', TRUE));
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
            $url_rewrite = $this->Csz_model->rw_link($this->input->post('category_name', TRUE));
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
                'content' => str_replace(' class="container"', '', $this->input->post('content', TRUE)),
                'cat_id' => $this->input->post('cat_id', TRUE),
            );
            $url_rewrite = $this->Csz_model->rw_link($this->input->post('title', TRUE));
            $this->Csz_model->clear_uri_cache($this->config->item('base_url').urldecode('plugin/article/view/'.$id.'/'.$this->Csz_model->getValue('url_rewrite', 'article_db', "article_db_id", $id, 1)->url_rewrite)); /* Clear Page Cache when update */
        }
        $this->db->set('url_rewrite', $url_rewrite);
        $this->db->set('lang_iso', $this->input->post('lang_iso', TRUE));
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
    
    public function categoryMenu($lang_iso) {
        $maincat = $this->Csz_model->getValueArray('*', 'article_db', "is_category = '1' AND active = '1' AND main_cat_id = '0' AND lang_iso = '".$lang_iso."'", '', 0, 'category_name', 'ASC');
        $html = '<div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-menu-hamburger"></i> '.$this->Csz_model->getLabelLang('article_category_menu').'</b></div>
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">';
                            $html.= '<li role="presentation" class="text-left"><a href="'.BASE_URL.'/plugin/article"><b><i class="glyphicon glyphicon-home"></i> '.$this->Csz_model->getLabelLang('article_index_header').'</b></a></li>';
                        if($maincat === FALSE){
                            $html.= '<li role="presentation" class="text-left"><a><b>'.$this->Csz_model->getLabelLang('article_cat_not_found').'</b></a></li>';
                        }else{
                            foreach ($maincat as $mc) {
                                $html.= '<li role="presentation" class="text-left"><a href="'.BASE_URL.'/plugin/article/category/'.$mc['url_rewrite'].'"><b><i class="glyphicon glyphicon-triangle-right"></i> '.$mc['category_name'].'</b></a></li>';
                                $subcat = $this->Csz_model->getValueArray('*', 'article_db', "is_category = '1' AND active = '1' AND main_cat_id = '".$mc['article_db_id']."'", '', 0, 'category_name', 'ASC');
                                if(!empty($subcat)){
                                    foreach ($subcat as $sc) {
                                        $html.= '<li role="presentation" class="text-left"><a href="'.BASE_URL.'/plugin/article/category/'.$sc['url_rewrite'].'"> |-- '.$sc['category_name'].'</a></li>';
                                    }
                                }
                            } 
                        }
            $html.= '</ul>
                </div>
            </div>';
            $archive = $this->Csz_model->getValueArray('YEAR(timestamp_create) AS article_year', 'article_db', "is_category = '0' AND active = '1' AND lang_iso = '".$lang_iso."'", '', 0, 'article_year', 'DESC', 'article_year');
            $html.= '<div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-menu-hamburger"></i> '.$this->Csz_model->getLabelLang('article_archive').'</b></div>
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">';
                        if($archive === FALSE){
                            $html.= '<li role="presentation" class="text-left"><a><b>'.$this->Csz_model->getLabelLang('article_cat_not_found').'</b></a></li>';
                        }else{
                            foreach ($archive as $ac) {
                                $html.= '<li role="presentation" class="text-left"><a href="'.BASE_URL.'/plugin/article/archive/'.$ac['article_year'].'"><b><i class="glyphicon glyphicon-triangle-right"></i> '.$ac['article_year'].'</b></a></li>';
                                $subarchive = $this->Csz_model->getValueArray("MONTHNAME(STR_TO_DATE(MONTH(timestamp_create), '%m')) AS article_month_name, MONTH(timestamp_create) AS article_month", 'article_db', "is_category = '0' AND active = '1' AND lang_iso = '".$lang_iso."' AND YEAR(timestamp_create) = '".$ac['article_year']."'", '', 0, 'article_month', 'DESC', 'article_month');
                                if(!empty($subarchive)){
                                    foreach ($subarchive as $sa) {
                                        $html.= '<li role="presentation" class="text-left"><a href="'.BASE_URL.'/plugin/article/archive/'.$ac['article_year'].'-'.$sa['article_month'].'"> |-- '.$sa['article_month_name'].'</a></li>';
                                    }
                                }
                            } 
                        }
            $html.= '</ul>
                </div>
            </div>';
        return $html;
    }
    
}
