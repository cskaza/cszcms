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

class Article_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert() {
        // Create the new lang
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        ($this->input->post('fb_comment_active')) ? $fb_comment_active = $this->input->post('fb_comment_active', TRUE) : $fb_comment_active = 0;
        $upload_file = '';
        $file_upload_field1 = $_FILES['file_upload'];
        if (!empty($file_upload_field1) && $file_upload_field1['type'] == 'image/png' || $file_upload_field1['type'] == 'image/jpg' || $file_upload_field1['type'] == 'image/jpeg' || $file_upload_field1['type'] == 'image/gif') {
            $paramiter = '_1';
            $photo_id = time();
            $uploaddir = 'photo/plugin/article/';
            $file_f = $file_upload_field1['tmp_name'];
            $file_name = $file_upload_field1['name'];
            $upload_file = $this->Csz_admin_model->file_upload($file_f, $file_name, '', $uploaddir, $photo_id, $paramiter);
        }
        $upload_file2 = '';
        $file_upload_field2 = $_FILES['file_upload2'];
        if (!empty($file_upload_field2)) {
            $paramiter = '_1';
            $photo_id = time();
            $uploaddir = 'photo/plugin/article/';
            $file_f = $file_upload_field2['tmp_name'];
            $file_name = $file_upload_field2['name'];
            $upload_file2 = $this->Csz_admin_model->file_upload($file_f, $file_name, '', $uploaddir, $photo_id, $paramiter);
        }
        $user_groups_idS = $this->input->post('user_groups_idS');
        $user_groups_id = '';
        if (isset($user_groups_idS)) {
            if (count($user_groups_idS) == 1) {
                $user_groups_id = $user_groups_idS[0];
            } else {
                $user_groups_id = implode(",", $user_groups_idS);
            }
        }
        $data = array(
            'main_picture' => $upload_file,
            'file_upload' => $upload_file2,
            'title' => $this->input->post('title', TRUE),
            'keyword' => $this->input->post('keyword', TRUE),
            'short_desc' => $this->input->post('short_desc', TRUE),
            'content' => str_replace(' class="container"', '', $this->input->post('content', FALSE)),
            'cat_id' => $this->input->post('cat_id', TRUE),
            'user_groups_idS' => $user_groups_id,
        );
        $url_rewrite = $this->Csz_model->rw_link($this->input->post('title', TRUE));
        $this->db->set('url_rewrite', $url_rewrite);
        $this->db->set('lang_iso', $this->input->post('lang_iso', TRUE));
        $this->db->set('is_category', 0);
        $this->db->set('active', $active);
        $this->db->set('fb_comment_active', $fb_comment_active);
        $this->db->set('fb_comment_limit', $this->input->post('fb_comment_limit', TRUE));
        $this->db->set('fb_comment_sort', $this->input->post('fb_comment_sort', TRUE));
        $this->db->set('user_admin_id', $this->session->userdata('user_admin_id'));
        $this->db->set('timestamp_create', $this->Csz_model->timeNow(), TRUE);
        $this->db->set('timestamp_update', $this->Csz_model->timeNow(), TRUE);
        $this->db->insert('article_db', $data);
    }

    public function insertCat() {
        // Create the new lang
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        $arrange = $this->Csz_model->getLastID('article_db', 'arrange', "is_category = '1'");
        $data = array(
            'category_name' => $this->input->post('category_name', TRUE),
            'main_cat_id' => $this->input->post('main_cat_id', TRUE),
        );
        $url_rewrite = $this->Csz_model->rw_link($this->input->post('category_name', TRUE));
        $this->db->set('url_rewrite', $url_rewrite);
        $this->db->set('lang_iso', $this->input->post('lang_iso', TRUE));
        $this->db->set('is_category', 1);
        $this->db->set('active', $active);
        $this->db->set('user_admin_id', $this->session->userdata('user_admin_id'));
        $this->db->set('arrange', ($arrange)+1);
        $this->db->set('timestamp_create', $this->Csz_model->timeNow(), TRUE);
        $this->db->set('timestamp_update', $this->Csz_model->timeNow(), TRUE);
        $this->db->insert('article_db', $data);
    }

    public function artupdate($id) {
        $row = $this->Csz_model->getValue('is_category', 'article_db', 'article_db_id', $id, 1);
        if(!$row->is_category){
            ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
            ($this->input->post('fb_comment_active')) ? $fb_comment_active = $this->input->post('fb_comment_active', TRUE) : $fb_comment_active = 0;
            if ($this->input->post('del_file')) {
                $upload_file = '';
                @unlink('photo/plugin/article/' . $this->input->post('del_file', TRUE));
            } else {
                $upload_file = $this->input->post('mainPicture');
                $file_upload_field1 = $_FILES['file_upload'];
                if (!empty($file_upload_field1) && $file_upload_field1['type'] == 'image/png' || $file_upload_field1['type'] == 'image/jpg' || $file_upload_field1['type'] == 'image/jpeg') {
                    $paramiter = '_1';
                    $photo_id = time();
                    $uploaddir = 'photo/plugin/article/';
                    $file_f = $file_upload_field1['tmp_name'];
                    $file_name = $file_upload_field1['name'];
                    $upload_file = $this->Csz_admin_model->file_upload($file_f, $file_name, $this->input->post('siteLogo', TRUE), $uploaddir, $photo_id, $paramiter);
                }
            }
            if ($this->input->post('del_file2')) {
                $upload_file2 = '';
                @unlink('photo/plugin/article/' . $this->input->post('del_file2', TRUE));
            } else {
                $upload_file2 = $this->input->post('mainFile');
                $file_upload_field2 = $_FILES['file_upload2'];
                if (!empty($file_upload_field2)) {
                    $paramiter = '_1';
                    $photo_id = time();
                    $uploaddir = 'photo/plugin/article/';
                    $file_f = $file_upload_field2['tmp_name'];
                    $file_name = $file_upload_field2['name'];
                    $upload_file2 = $this->Csz_admin_model->file_upload($file_f, $file_name, $this->input->post('siteLogo', TRUE), $uploaddir, $photo_id, $paramiter);
                }
            }
            $user_groups_idS = $this->input->post('user_groups_idS');
            $user_groups_id = '';
            if (isset($user_groups_idS)) {
                if (count($user_groups_idS) == 1) {
                    $user_groups_id = $user_groups_idS[0];
                } else {
                    $user_groups_id = implode(",", $user_groups_idS);
                }
            }
            $data = array(
                'main_picture' => $upload_file,
                'file_upload' => $upload_file2,
                'title' => $this->input->post('title', TRUE),
                'keyword' => $this->input->post('keyword', TRUE),
                'short_desc' => $this->input->post('short_desc', TRUE),
                'content' => str_replace(' class="container"', '', $this->input->post('content', FALSE)),
                'cat_id' => $this->input->post('cat_id', TRUE),
                'user_groups_idS' => $user_groups_id,
            );
            $url_rewrite = $this->Csz_model->rw_link($this->input->post('title', TRUE));           
            $this->db->set('url_rewrite', $url_rewrite);
            $this->db->set('lang_iso', $this->input->post('lang_iso', TRUE));
            $this->db->set('active', $active);
            $this->db->set('fb_comment_active', $fb_comment_active);
            $this->db->set('fb_comment_limit', $this->input->post('fb_comment_limit', TRUE));
            $this->db->set('fb_comment_sort', $this->input->post('fb_comment_sort', TRUE));
            $this->db->set('timestamp_update', $this->Csz_model->timeNow(), TRUE);
            $this->db->where("article_db_id", $id);
            $this->db->update('article_db', $data);
            $this->Csz_model->clear_uri_cache($this->config->item('base_url') . urldecode('plugin/article/view/' . $id . '/' . $this->Csz_model->getValue('url_rewrite', 'article_db', "article_db_id", $id, 1)->url_rewrite)); /* Clear Page Cache when update */
        }
    }

    public function catupdate($id) {
        $row = $this->Csz_model->getValue('is_category', 'article_db', 'article_db_id', $id, 1);
        if($row->is_category){
            ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
            $data = array(
                'category_name' => $this->input->post('category_name', TRUE),
                'main_cat_id' => $this->input->post('main_cat_id', TRUE),
            );
            $url_rewrite = $this->Csz_model->rw_link($this->input->post('category_name', TRUE));
            $this->db->set('url_rewrite', $url_rewrite);
            $this->db->set('lang_iso', $this->input->post('lang_iso', TRUE));
            $this->db->set('active', $active);
            $this->db->set('timestamp_update', $this->Csz_model->timeNow(), TRUE);
            $this->db->where("article_db_id", $id);
            $this->db->update('article_db', $data);
        }
    }

    public function delete($id) {
        if ($id) {
            $row = $this->Csz_model->getValue('*', 'article_db', 'article_db_id', $id, 1);
            if ($row->is_category) {
                if (!$row->main_cat_id) {
                    $this->db->set('main_cat_id', 0);
                    $this->db->set('timestamp_update', $this->Csz_model->timeNow(), TRUE);
                    $this->db->where('main_cat_id', $id);
                    $this->db->update('article_db');
                }
                $this->db->set('cat_id', 0);
                $this->db->set('timestamp_update', $this->Csz_model->timeNow(), TRUE);
                $this->db->where('cat_id', $id);
                $this->db->update('article_db');
            }else{
                @unlink('photo/plugin/article/' . $row->main_picture);
            }
            $this->Csz_admin_model->removeData('article_db', 'article_db_id', $id);
        } else {
            return FALSE;
        }
    }

    private function AdminMenuActive($menu_page, $cur_page, $addeditdel = '') {
        /* $addeditdel = 'cat'; //Example: catNew, catEdit, catDel etc. */
        if ($menu_page == $cur_page || ($addeditdel != '' && strpos($cur_page, $addeditdel) !== false)) {
            $active = ' class="active"';
        } else {
            $active = "";
        }
        return $active;
    }

    public function AdminMenu() {
        $cur_page = $this->uri->segment(4);
        $html = '<nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="' . $this->Csz_model->base_link(). '/admin/plugin/article">' . $this->lang->line('nav_dash') . '</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li' . $this->AdminMenuActive('category', $cur_page, 'cat') . '><a href="' . $this->Csz_model->base_link(). '/admin/plugin/article/category">' . $this->lang->line('category_header') . '</a></li>
                        <li' . $this->AdminMenuActive('article', $cur_page, 'art') . '><a href="' . $this->Csz_model->base_link(). '/admin/plugin/article/article">' . $this->lang->line('article_header') . '</a></li>                      
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>';
        return $html;
    }

    public function categoryMenu($lang_iso) {
        $maincat = $this->Csz_model->getValueArray('*', 'article_db', "is_category = '1' AND active = '1' AND main_cat_id = '0' AND lang_iso = '" . $lang_iso . "'", '', 0, 'arrange', 'ASC');
        $html = '<div class="panel panel-primary">
                <div class="panel-body">
                    <form action="' . $this->Csz_model->base_link(). '/plugin/article/search" name="searchfrm" id="searchfrm" method="get" style="margin:0px; padding:0px;">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-search"></i></span>
                        <input type="text" class="form-control" placeholder="' . $this->Csz_model->getLabelLang('article_search_txt') . '" name="p" value="' . $this->Csz_model->cleanOSCommand($this->input->get('p' ,TRUE)) . '">
                    </div>
                    </form>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-menu-hamburger"></i> ' . $this->Csz_model->getLabelLang('article_category_menu') . '</b></div>
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">';
        $html.= '<li role="presentation" class="text-left"><a href="' . $this->Csz_model->base_link(). '/plugin/article"><b><i class="glyphicon glyphicon-home"></i> ' . $this->Csz_model->getLabelLang('article_index_header') . '</b></a></li>';
        if ($maincat === FALSE) {
            $html.= '<li role="presentation" class="text-left"><a><b>' . $this->Csz_model->getLabelLang('article_cat_not_found') . '</b></a></li>';
        } else {
            foreach ($maincat as $mc) { 
                $subcat = $this->Csz_model->getValueArray('*', 'article_db', "is_category = '1' AND active = '1' AND main_cat_id = '" . $mc['article_db_id'] . "'", '', 0, 'arrange', 'ASC');
                if (!empty($subcat) && $subcat !== FALSE) {
                    $html.= '<li role="presentation" class="text-left"><a onclick="ChkHideShow(' . $mc['article_db_id'] . ');"><b><i class="glyphicon glyphicon-triangle-bottom"></i> ' . $mc['category_name'] . '</b></a></li>';
                    $html.= '<div id="' . $mc['article_db_id'] . '" style="display:none;">';
                    if($this->countArtInCat($mc['article_db_id']) > 0){
                        $html.= '<li role="presentation" class="text-left" style="margin-left:30px;"><a href="' . $this->Csz_model->base_link(). '/plugin/article/category/' . $mc['url_rewrite'] . '">' . $mc['category_name'] . '</a></li>';
                    }
                    foreach ($subcat as $sc) {
                        $html.= '<li role="presentation" class="text-left" style="margin-left:30px;"><a href="' . $this->Csz_model->base_link(). '/plugin/article/category/' . $mc['url_rewrite'] . '/' . $sc['url_rewrite'] . '">' . $sc['category_name'] . '</a></li>';
                    }
                    $html.= '</div>';
                }else{
                    $html.= '<li role="presentation" class="text-left"><a href="' . $this->Csz_model->base_link(). '/plugin/article/category/' . $mc['url_rewrite'] . '"><b>' . $mc['category_name'] . '</b></a></li>';
                }
            }
        }
        $html.= '</ul>
                </div>
            </div>';
        $archive = $this->Csz_model->getValueArray('YEAR(timestamp_create) AS article_year', 'article_db', "is_category = '0' AND active = '1' AND lang_iso = '" . $lang_iso . "'", '', 0, 'article_year', 'DESC', 'article_year');
        $html.= '<div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-menu-hamburger"></i> ' . $this->Csz_model->getLabelLang('article_archive') . '</b></div>
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">';
        if ($archive === FALSE) {
            $html.= '<li role="presentation" class="text-left"><a><b>' . $this->Csz_model->getLabelLang('article_not_found') . '</b></a></li>';
        } else {
            foreach ($archive as $ac) {
                $month_arr = array();
                $html.= '<li role="presentation" class="text-left"><a onclick="ChkHideShow(' . $ac['article_year'] . ');"><b><i class="glyphicon glyphicon-triangle-bottom"></i> ' . $ac['article_year'] . '</b></a></li>';
                $html.= '<div id="' . $ac['article_year'] . '" style="display:none;">';
                $subarchive = $this->Csz_model->getValueArray("MONTH(timestamp_create) AS article_month, MONTHNAME(timestamp_create) AS article_month_name", 'article_db', "is_category = '0' AND active = '1' AND lang_iso = '" . $lang_iso . "' AND YEAR(timestamp_create) = '" . $ac['article_year'] . "'", '', 0, 'article_month', 'DESC'); /* Can't group with sql only_full_group_by sql mode */
                if (!empty($subarchive)) {
                    foreach ($subarchive as $sa) {
                        if(!in_array($sa['article_month_name'], $month_arr)){
                            $month_arr[] = $sa['article_month_name'];
                            $html.= '<li role="presentation" class="text-left" style="padding-left:30px;"><a href="' . $this->Csz_model->base_link(). '/plugin/article/archive/' . $ac['article_year'] . '-' . $sa['article_month'] . '">' . $sa['article_month_name'] . '</a></li>';
                        }
                    }
                }
                $html.= '</div>';
            }
            unset($month_arr, $archive, $subarchive);
        }
        $html.= '</ul>
                </div>
            </div>';
        $html.= '<div class="panel panel-primary">
                <div class="panel-body text-center">
            <a href="' . $this->Csz_model->base_link(). '/plugin/article/rss" class="btn btn-sm btn-primary" target="_blank" title="RSS FEED"><i class="fa fa-rss" aria-hidden="true"></i> RSS FEED</a>
            </div>
            </div>';
        return $html;
    }
    
    public function getCatNameFromID($id){
        $cat = $this->Csz_model->getValue('category_name', 'article_db', "article_db_id", $id, 1);
        if(!empty($cat) && $cat->category_name){
            return $cat->category_name;
        }else{
            return $id;
        }
    }
    
    public function countArtInCat($cat_id){
        if($cat_id){
            $art_num = $this->Csz_model->countData('article_db', "is_category = '0' AND active = '1' AND cat_id = '" . $cat_id . "'");
            if($art_num !== FALSE){
                return $art_num;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }
    
    public function downloadArticleLog($article_db_id, $file_upload){
        $this->db->set('article_db_id', $article_db_id);
        $this->db->set('file_upload', $file_upload);
        $this->db->set('user_admin_id', $this->session->userdata('user_admin_id'));
        $this->db->set('user_agent', $this->input->user_agent(), TRUE);
        $this->db->set('ip_address', $this->input->ip_address(), TRUE);
        $this->db->set('timestamp_create', $this->Csz_model->timeNow(), TRUE);
        $this->db->insert('article_db_downloadstat');
    }
    
    public function countDownload($article_db_id) {
        if($article_db_id){
            $art_num = $this->Csz_model->countData('article_db_downloadstat', "article_db_id = '" . $article_db_id . "'");
            if($art_num !== FALSE){
                return $art_num;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

}
