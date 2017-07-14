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
class Article extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('file');
        define('LANG', $this->Csz_admin_model->getLang());
        $this->lang->load('admin', LANG);
        $this->lang->load('plugin/article', LANG);
        $this->template->set_template('admin');
        $this->load->model('plugin/Article_model');
        $this->_init();
        admin_helper::plugin_not_active('article');
    }

    public function _init() {
        $row = $this->Csz_admin_model->load_config();
        $pageURL = $this->Csz_admin_model->getCurPages();
        $this->template->set('core_css', $this->Csz_admin_model->coreCss());
        $this->template->set('core_js', $this->Csz_admin_model->coreJs());
        $this->template->set('title', 'Backend System | ' . $row->site_name);
        $this->template->set('meta_tags', $this->Csz_admin_model->coreMetatags('Backend System for CSZ Content Management'));
        $this->template->set('cur_page', $pageURL);
    }

    public function index() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('article');
        $this->csz_referrer->setIndex('article'); /* Set index page when redirect after save */
        $this->db->cache_on();
        //Get users from database
        $this->template->setSub('total_cat', $this->Csz_model->countData('article_db', "active = '1' AND is_category = '1'"));
        $this->template->setSub('total_art', $this->Csz_model->countData('article_db', "active = '1' AND is_category = '0'"));

        //Load the view
        $this->template->loadSub('admin/plugin/article/article_home');
    }

    public function article() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('article');
        $this->csz_referrer->setIndex('article_art'); /* Set index page when redirect after save */
        $this->db->cache_on();
        $search_arr = ' 1=1 ';
        if ($this->input->get('search') || $this->input->get('category') || $this->input->get('lang')) {
            if ($this->input->get('search')) {
                $search_arr.= " AND title LIKE '%" . $this->input->get('search', TRUE) . "%' OR short_desc LIKE '%" . $this->input->get('search', TRUE) . "%'";
            }
            if ($this->input->get('category')) {
                $search_arr.= " AND cat_id = '" . $this->input->get('category', TRUE) . "'";
            }
            if ($this->input->get('lang')) {
                $search_arr.= " AND lang_iso = '" . $this->input->get('lang', TRUE) . "'";
            }
        }
        $search_arr.= " AND is_category = 0";
        $this->load->helper('form');
        $this->load->library('pagination');
        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_model->countData('article_db', $search_arr);
        $num_link = 10;
        $base_url = $this->Csz_model->base_link(). '/admin/plugin/article/article/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 5);
        ($this->uri->segment(5)) ? $pagination = $this->uri->segment(5) : $pagination = 0;

        //Get users from database
        $this->template->setSub('article', $this->Csz_admin_model->getIndexData('article_db', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
        $this->template->setSub('category', $this->Csz_model->getValueArray('*', 'article_db', "is_category", '1'));
        $this->template->setSub('total_row', $total_row);
        $this->template->setSub('lang', $this->Csz_model->loadAllLang());

        //Load the view
        $this->template->loadSub('admin/plugin/article/article_index');
    }

    public function category() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('article');
        $this->csz_referrer->setIndex('article_cat'); /* Set index page when redirect after save */
        $this->db->cache_on();
        $search_arr = "is_category = '1'";
        if ($this->input->get('search') || $this->input->get('main_cat_id') || $this->input->get('lang')) {
            if ($this->input->get('search')) {
                $search_arr.= " AND category_name LIKE '%" . $this->input->get('search', TRUE) . "%'";
            }
            if ($this->input->get('main_cat_id')) {
                $search_arr.= " AND main_cat_id = '" . $this->input->get('main_cat_id', TRUE) . "'";
            }
            if ($this->input->get('lang')) {
                $search_arr.= " AND lang_iso = '" . $this->input->get('lang', TRUE) . "'";
            }
        }
        $this->load->helper('form');
        $total_row = $this->Csz_model->countData('article_db', $search_arr);
        
        //Get users from database
        $this->template->setSub('category', $this->Csz_model->getValueArray('*', 'article_db', $search_arr, '', 0, 'arrange', 'asc'));
        $this->template->setSub('main_category', $this->Csz_model->getValueArray('*', 'article_db', "is_category = '1' AND main_cat_id = ''", ''));
        $this->template->setSub('total_row', $total_row);
        $this->template->setSub('lang', $this->Csz_model->loadAllLang());

        //Load the view
        $this->template->loadSub('admin/plugin/article/article_category');
    }
    
    public function catIndexSave(){
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('article');
        admin_helper::is_allowchk('save');
        $count = 0;
        $arrange = 1;
        $article_db_id = $this->input->post('article_db_id', TRUE);
        if (!empty($article_db_id)) {
            while ($count < count($article_db_id)) {
                if ($article_db_id[$count]) {
                    $this->db->set('arrange', $arrange, FALSE);
                    $this->db->set('timestamp_update', 'NOW()', FALSE);
                    $this->db->where("article_db_id", $article_db_id[$count]);
                    $this->db->update('article_db');
                    $arrange++;
                }
                $count++;
            }
        }
        $this->db->cache_delete_all();
        $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        redirect($this->csz_referrer->getIndex('article_cat'), 'refresh');
    }

    public function artadd() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('article');        
        $this->template->set('extra_js', '<script type="text/javascript">'.$this->Csz_admin_model->getSaveDraftJS().'</script>');
        //Load the form helper
        $this->load->helper('form');
        $this->template->setSub('category', $this->Csz_model->getValueArray('*', 'article_db', "is_category", '1'));
        $this->template->setSub('lang', $this->Csz_model->loadAllLang());
        //Load the view
        $this->template->loadSub('admin/plugin/article/article_add');
    }

    public function catadd() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('article');
        //Load the form helper
        $this->load->helper('form');
        $this->template->setSub('category', $this->Csz_model->getValueArray('*', 'article_db', "is_category = '1' AND main_cat_id = ''", ''));
        $this->template->setSub('lang', $this->Csz_model->loadAllLang());
        //Load the view
        $this->template->loadSub('admin/plugin/article/article_addcat');
    }

    public function addSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('article');
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('short_desc', 'Short Description', 'required');
        $this->form_validation->set_rules('cat_id', 'Category', 'required');
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->artadd();
        } else {
            //Validation passed
            //Add the user
            $this->Article_model->insert();
            $this->output->delete_cache('plugin/article/rss');
            $this->Csz_model->clear_file_cache('article_getWidget_*', TRUE);
            $this->db->cache_delete_all();
            redirect($this->csz_referrer->getIndex('article_art'), 'refresh');
        }
    }

    public function addCatSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('article');
        admin_helper::is_allowchk('save');
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('category_name', 'Category Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->catadd();
        } else {
            //Validation passed
            //Add the user
            $this->Article_model->insertCat();
            $this->db->cache_delete_all();
            redirect($this->csz_referrer->getIndex('article_cat'), 'refresh');
        }
    }

    public function artedit() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('article');
        //Load the form helper
        $this->load->helper('form');
        if ($this->uri->segment(5)) {
            $this->template->setSub('category', $this->Csz_model->getValueArray('*', 'article_db', "is_category", '1'));
            $this->template->setSub('article', $this->Csz_model->getValue('*', 'article_db', 'article_db_id', $this->uri->segment(5), 1));
            $this->template->setSub('lang', $this->Csz_model->loadAllLang());
            //Load the view
            $this->template->loadSub('admin/plugin/article/article_artedit');
        } else {
            redirect($this->csz_referrer->getIndex('article_art'), 'refresh');
        }
    }

    public function editArtSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('article');
        admin_helper::is_allowchk('save');
        if ($this->uri->segment(5)) {
                //Load the form validation library
                $this->load->library('form_validation');
                //Set validation rules
                $this->form_validation->set_rules('title', 'Title', 'required');
                $this->form_validation->set_rules('short_desc', 'Short Description', 'required');
                $this->form_validation->set_rules('cat_id', 'Category', 'required');
                if ($this->form_validation->run() == FALSE) {
                    //Validation failed
                    $this->artedit();
                } else {
                    //Validation passed
                    //Add the user
                    $this->Article_model->artupdate($this->uri->segment(5));
                    $this->output->delete_cache('plugin/article/rss');
                    $this->Csz_model->clear_file_cache('article_getWidget_*', TRUE);
                    $this->db->cache_delete_all();
                    redirect($this->csz_referrer->getIndex('article_art'), 'refresh');
                }
        } else {
            redirect($this->csz_referrer->getIndex('article'), 'refresh');
        }
    }
    
    public function catedit() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('article');
        //Load the form helper
        $this->load->helper('form');
        if ($this->uri->segment(5)) {
            $this->template->setSub('main_category', $this->Csz_model->getValueArray('*', 'article_db', "is_category = '1' AND main_cat_id = ''", ''));
            $this->template->setSub('category', $this->Csz_model->getValue('*', 'article_db', 'article_db_id', $this->uri->segment(5), 1));
            $this->template->setSub('lang', $this->Csz_model->loadAllLang());
            //Load the view
            $this->template->loadSub('admin/plugin/article/article_catedit');
        } else {
            redirect($this->csz_referrer->getIndex('article_cat'), 'refresh');
        }
    }
    
    public function editCatSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('article');
        admin_helper::is_allowchk('save');
        if ($this->uri->segment(5)) {
            $this->load->library('form_validation');
            //Set validation rules
            $this->form_validation->set_rules('category_name', 'Category Name', 'required');
            if ($this->form_validation->run() == FALSE) {
                //Validation failed
                $this->catedit();
            } else {
                $this->Article_model->catupdate($this->uri->segment(5));
                $this->db->cache_delete_all();
                redirect($this->csz_referrer->getIndex('article_cat'), 'refresh');
            }
        } else {
            redirect($this->csz_referrer->getIndex('article'), 'refresh');
        }
    }

    public function artdel() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('article');
        admin_helper::is_allowchk('delete');
        if ($this->uri->segment(5)) {
            //Delete the data
            $this->Article_model->delete($this->uri->segment(5));
            $this->output->delete_cache('plugin/article/rss');
            $this->Csz_model->clear_file_cache('article_getWidget_*', TRUE);
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        }
        redirect($this->csz_referrer->getIndex('article_art'), 'refresh');
    }
    
    public function catdel() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('article');
        admin_helper::is_allowchk('delete');
        if ($this->uri->segment(5)) {
            //Delete the data
            $this->Article_model->delete($this->uri->segment(5));
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        }
        redirect($this->csz_referrer->getIndex('article_cat'), 'refresh');
    }
    
    public function asCopy() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('article');
        admin_helper::is_allowchk('save');
        if($this->uri->segment(5)){
            $article = $this->Csz_model->getValue('*', 'article_db', "article_db_id = '".$this->uri->segment(5)."' AND is_category = '0'", '', 1);
            if($article !== FALSE){
                $data = array(
                    'main_picture' => '',
                    'title' => $article->title.'-copy',
                    'url_rewrite' => $article->url_rewrite.'-copy',
                    'keyword' => $article->keyword,
                    'short_desc' => $article->short_desc,
                    'content' => $article->content,
                    'cat_id' => $article->cat_id,
                    'lang_iso' => $article->lang_iso,
                    'is_category' => 0,
                    'active' => 0,
                    'user_admin_id' => $this->session->userdata('user_admin_id'),
                );
                $this->Csz_model->insertAsCopy('article_db', $data);
                $this->db->cache_delete_all();
            }
        }
        redirect($this->csz_referrer->getIndex('article_art'), 'refresh');
    }

}
