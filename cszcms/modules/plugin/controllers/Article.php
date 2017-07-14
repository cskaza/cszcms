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

class Article extends CI_Controller {

    /**
     Article Plugin by CSKAZA
     */
    var $page_url;
    function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
        $this->load->database();
        $row = $this->Csz_model->load_config();
        $this->load->model('plugin/Article_model');
        if ($row->themes_config) {
            $this->template->set_template($row->themes_config);
            define('THEME', $row->themes_config);
        }
        if(!$this->session->userdata('fronlang_iso')){ 
            $this->Csz_model->setSiteLang();
        }
        if($this->Csz_model->chkLangAlive($this->session->userdata('fronlang_iso')) == 0){ 
            $this->session->unset_userdata('fronlang_iso');
            $this->Csz_model->setSiteLang(); 
        }
        if($row->pagecache_time != 0){ $this->db->cache_on(); }
        $this->_init();
        member_helper::plugin_not_active('article');
    }

    public function _init() {
        $this->template->set('core_css', $this->Csz_model->coreCss());
        $this->template->set('core_js', $this->Csz_model->coreJs());
        $row = $this->Csz_model->load_config();
        $this->page_url = $this->uri->segment(2);	
        $this->template->set('additional_js', $row->additional_js);
        $this->template->set('additional_metatag', $row->additional_metatag);
    }

    public function index() {
        $row = $this->Csz_model->load_config();
        $title = $this->Csz_model->getLabelLang('article_index_header') . ' | ' . $row->site_name;
        $this->template->set('title', $title);
        $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title,$row->keywords,$title));
        $this->template->set('cur_page', $this->page_url);
        $search_arr = " is_category = '0' AND active = '1' AND lang_iso = '".$this->session->userdata('fronlang_iso')."'";
        $this->load->helper('form');
        $this->load->library('pagination');
        // Pages variable
        $result_per_page = 10;
        $total_row = $this->Csz_model->countData('article_db', $search_arr);
        $num_link = 10;
        $base_url = $this->Csz_model->base_link(). '/plugin/article/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 3);
        ($this->uri->segment(3)) ? $pagination = $this->uri->segment(3) : $pagination = 0;

        //Get users from database
        $this->template->setSub('article', $this->Csz_admin_model->getIndexData('article_db', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
        $this->template->setSub('total_row', $total_row);

        //Load the view
        $this->template->loadSub('article/article_index');
    }
    
    public function category() {
        if($this->uri->segment(4)){
            $cat_row = $this->Csz_model->getValue('*', 'article_db', "is_category = '1' AND active = '1' AND url_rewrite = '".$this->uri->segment(4)."'", '', 1);
            if($cat_row !== FALSE){
                if($this->session->userdata('fronlang_iso') != $cat_row->lang_iso){
                    $this->Csz_model->setSiteLang($cat_row->lang_iso);
                }
                $row = $this->Csz_model->load_config();
                $title = $this->Csz_model->getLabelLang('article_index_header') . ' | ' . $row->site_name;
                $this->template->set('title', $title);
                $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title,$row->keywords,$title));
                $this->template->set('cur_page', $this->page_url);
                $search_arr = " is_category = 0 AND active = '1' AND lang_iso = '".$this->session->userdata('fronlang_iso')."' AND cat_id = $cat_row->article_db_id";
                $this->load->helper('form');
                $this->load->library('pagination');
                // Pages variable
                $result_per_page = 10;
                $total_row = $this->Csz_model->countData('article_db', $search_arr);
                $num_link = 10;
                $base_url = $this->Csz_model->base_link(). '/plugin/article/category/'.$this->uri->segment(4).'/';

                // Pageination config
                $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 5);
                ($this->uri->segment(5)) ? $pagination = $this->uri->segment(5) : $pagination = 0;

                //Get users from database
                $this->template->setSub('article', $this->Csz_admin_model->getIndexData('article_db', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
                $this->template->setSub('total_row', $total_row);
                $this->template->setSub('category_name', $cat_row->category_name);

                //Load the view
                $this->template->loadSub('article/article_category');
            }else{
                redirect($this->Csz_model->base_link().'/plugin/article', 'refresh');
            }
        }else{
            redirect($this->Csz_model->base_link().'/plugin/article', 'refresh');
        }
    }
    
    public function search() {
        $p = $this->Csz_model->cleanOSCommand($this->input->get('p', TRUE));
        if ($p) {
            $row = $this->Csz_model->load_config();
            $title = 'Article Search | ' . $row->site_name;
            $this->template->set('title', $title);
            $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
            $this->template->set('cur_page', $this->page_url);
            $search_arr = " is_category = 0 AND active = '1' AND lang_iso = '".$this->session->userdata('fronlang_iso')."' AND (title LIKE '%" . $p . "%' OR keyword LIKE '%" . $p . "%')";
            $this->load->library('pagination');
            // Pages variable
            $result_per_page = 15;
            $total_row = $this->Csz_model->countData('article_db', $search_arr);
            $num_link = 10;
            $base_url = $this->Csz_model->base_link(). '/plugin/article/search/';

            // Pageination config
            $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 4);
            ($this->uri->segment(4)) ? $pagination = $this->uri->segment(4) : $pagination = 0;

            //Get users from database
            $this->template->setSub('article', $this->Csz_admin_model->getIndexData('article_db', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
            $this->template->setSub('total_row', $total_row);
            $this->template->setSub('searchtxt', $p);

            //Load the view
            $this->template->loadSub('article/article_search');
        } else {
            redirect($this->Csz_model->base_link(). '/plugin/article', 'refresh');
        }
    }
    
    public function archive() {
        if($this->uri->segment(4)){
            $year_arr = array();
            $year_arr = explode('-', $this->uri->segment(4));
            if($year_arr !== FALSE){
                $row = $this->Csz_model->load_config();
                $title = $this->Csz_model->getLabelLang('article_index_header') . ' | ' . $row->site_name;
                $this->template->set('title', $title);
                $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title,$row->keywords,$title));
                $this->template->set('cur_page', $this->page_url);
                if(count($year_arr) == 1){
                    $this->template->setSub('category_name', $year_arr[0]);
                    $search_arr = " is_category = 0 AND active = '1' AND lang_iso = '".$this->session->userdata('fronlang_iso')."' AND timestamp_create LIKE '".$year_arr[0]."-%'";
                }elseif(count($year_arr) == 2){
                    $this->template->setSub('category_name', date('F', mktime(0, 0, 0, $year_arr[1], 10)).' '.$year_arr[0]);
                    $search_arr = " is_category = 0 AND active = '1' AND lang_iso = '".$this->session->userdata('fronlang_iso')."' AND timestamp_create LIKE '".$year_arr[0]."-".str_pad($year_arr[1], 2, '0', STR_PAD_LEFT)."%'";
                }
                $this->load->helper('form');
                $this->load->library('pagination');
                // Pages variable
                $result_per_page = 10;
                $total_row = $this->Csz_model->countData('article_db', $search_arr);
                $num_link = 10;
                $base_url = $this->Csz_model->base_link(). '/plugin/article/archive/'.$this->uri->segment(4).'/';

                // Pageination config
                $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 5);
                ($this->uri->segment(5)) ? $pagination = $this->uri->segment(5) : $pagination = 0;

                //Get users from database
                $this->template->setSub('article', $this->Csz_admin_model->getIndexData('article_db', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
                $this->template->setSub('total_row', $total_row);
                

                //Load the view
                $this->template->loadSub('article/article_archive');
            }else{
                redirect($this->Csz_model->base_link().'/plugin/article', 'refresh');
            }
        }else{
            redirect($this->Csz_model->base_link().'/plugin/article', 'refresh');
        }
    }
    
    public function view() {
        if($this->uri->segment(4) && $this->uri->segment(5)){
            $art_row = $this->Csz_model->getValue('*', 'article_db', "is_category = '0' AND active = '1' AND article_db_id = '".$this->uri->segment(4)."' AND url_rewrite = '".$this->uri->segment(5)."'", '', 1);
            if($art_row !== FALSE){
                if($this->session->userdata('fronlang_iso') != $art_row->lang_iso){
                    $this->Csz_model->setSiteLang($art_row->lang_iso);
                }
                $row = $this->Csz_model->load_config();
                if ($this->Csz_model->findFrmTag($art_row->content) !== false) {
                    $row->pagecache_time = 0;
                    $this->db->cache_off();
                }
                $this->output->cache($row->pagecache_time);
                $title = $art_row->title.' | ' . $row->site_name;
                $this->template->set('title', $title);
                $more_meta = '<link rel="amphtml" href="'.$this->Csz_model->base_link().'/plugin/article/amp/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'">' . "\n";
                $more_meta.= '<meta property="article:published_time" content="'.date('c', strtotime($art_row->timestamp_create)).'" />' . "\n";
                $more_meta.= '<meta property="article:modified_time" content="'.date('c', strtotime($art_row->timestamp_update)).'" />' . "\n";
                $facebook = $this->Csz_model->getValue('*', 'footer_social', "social_name = 'facebook' AND active = '1'", '', 1);
                if($facebook !== FALSE && $facebook->social_url){
                    $more_meta.= '<meta property="article:author" content="' . $facebook->social_url . '" />' . "\n";
                }
                $this->template->set('meta_tags', $this->Csz_model->coreMetatags($art_row->short_desc,$art_row->keyword,$title,'plugin/article/' . $art_row->main_picture,$more_meta));
                $this->template->set('cur_page', $this->page_url);

                //Get users from database
                $this->template->setSub('article', $art_row);
                $cat_row = $this->Csz_model->getValue('category_name', 'article_db', "is_category = '1' AND active = '1' AND article_db_id = '".$art_row->cat_id."'", '', 1);
                $this->template->setSub('category_name', $cat_row->category_name);

                //Load the view
                $this->template->loadSub('article/article_view');
            }else{
                redirect($this->Csz_model->base_link().'/plugin/article', 'refresh');
            }
        }else{
            redirect($this->Csz_model->base_link().'/plugin/article', 'refresh');
        }
    }
    
    public function amp() {
        if($this->uri->segment(4) && $this->uri->segment(5)){
            $art_row = $this->Csz_model->getValue('*', 'article_db', "is_category = '0' AND active = '1' AND article_db_id = '".$this->uri->segment(4)."' AND url_rewrite = '".$this->uri->segment(5)."'", '', 1);
            if($art_row !== FALSE){
                if($this->session->userdata('fronlang_iso') != $art_row->lang_iso){
                    $this->Csz_model->setSiteLang($art_row->lang_iso);
                }
                $row = $this->Csz_model->load_config();
                if ($this->Csz_model->findFrmTag($art_row->content) !== false) {
                    $row->pagecache_time = 0;
                    $this->db->cache_off();
                }
                $this->output->cache($row->pagecache_time);
                $title = $art_row->title.' | ' . $row->site_name;
                $this->template->set('title', $title);
                $canonical = '<link rel="canonical" href="'.$this->Csz_model->base_link().'/plugin/article/view/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'">' . "\n";               
                $this->template->set('canonical', $canonical);

                //Get users from database
                $this->template->setSub('article', $art_row);
                $cat_row = $this->Csz_model->getValue('category_name', 'article_db', "is_category = '1' AND active = '1' AND article_db_id = '".$art_row->cat_id."'", '', 1);
                $this->template->setSub('category_name', $cat_row->category_name);

                //Load the view
                $this->template->loadSub('article/article_view_amp', 'frontpage/amp');
            }else{
                redirect($this->Csz_model->base_link().'/plugin/article', 'refresh');
            }
        }else{
            redirect($this->Csz_model->base_link().'/plugin/article', 'refresh');
        }
    }
    
    public function rss() {
        // creating rss feed with our most recent 20
        // first load the library
        $this->load->library('feed');
        $row = $this->Csz_model->load_config();
        if($row->pagecache_time != 0){ 
            $this->db->cache_on(); 
            $this->output->cache($row->pagecache_time);
        }
        // create new instance
        $feed = new Feed();
        // set your feed's title, description, link, pubdate and language
        $feed->title = $row->site_name;
        $feed->description = $this->Csz_model->getLabelLang('article_index_header') . ' | ' . $row->site_name;
        $feed->link = $this->Csz_model->base_link().'/plugin/article';
        $search_arr = " is_category = '0' AND active = '1'";
        $limit = 20;
        // get article list
        $article = $this->Csz_admin_model->getIndexData('article_db', $limit, 0, 'timestamp_create', 'desc', $search_arr);
        // add posts to the feed
        if($article !== FALSE){
            foreach ($article as $a)
            {
                // set item's title, author, url, pubdate and description
                $url = $this->Csz_model->base_link().'/plugin/article/view/'.$a['article_db_id'].'/'.$a['url_rewrite'];
                $feed->add($a['title'], $row->site_name, $url, $a['timestamp_create'], $a['short_desc']);
            }
        }
        // show your feed (options: 'atom' (recommended) or 'rss')
        $feed->render('rss');
    }
    
    public function getWidget() {
        $config = $this->Csz_model->load_config();
        $this->db->cache_on();
        $this->load->driver('cache', array('adapter' => 'file'));
        if (!$this->cache->get('article_getWidget_'.$this->uri->segment(4).'_'.$this->uri->segment(5))) {
            // For New Category
            $this->load->library('Xml_writer');
            // Initiate class
            $xml = new Xml_writer;
            $xml->setRootName('csz_widget');
            $xml->initiate();
            // Start Main branch
            $xml->startBranch('plugin'); 
            $xml->addNode('main_url', $this->Csz_model->base_link().'/plugin/article');
            // Get article 10 items
            if ($this->uri->segment(4)) {
                if($this->uri->segment(5)){
                    $search_arr = " is_category = '0' AND active = '1' AND lang_iso = '".$this->uri->segment(4)."' AND cat_id = '".$this->uri->segment(5)."'";
                }else{
                    $search_arr = " is_category = '0' AND active = '1' AND lang_iso = '".$this->uri->segment(4)."'";
                }
            }else{
                $search_arr = " is_category = '0' AND active = '1'";
            }
            $article = $this->Csz_admin_model->getIndexData('article_db', 100, 0, 'timestamp_create', 'desc', $search_arr);
            if($article !== FALSE){
                $xml->addNode('null', '0'); // For check item is not empty
                foreach ($article as $row) {
                    // start sub branch
                    $xml->startBranch('item', array('id' => $row['article_db_id'])); 
                    $xml->addNode('sub_url', $this->Csz_model->base_link().'/plugin/article/view/'.$row['article_db_id'].'/'.$row['url_rewrite']);
                    $xml->addNode('title', $row['title']);
                    $xml->addNode('short_desc', $row['short_desc']);
                    if($row['main_picture']){
                        $xml->addNode('photo', $this->Csz_model->base_link().'/photo/plugin/article/'.$row['main_picture']);
                    }else{
                        $xml->addNode('photo', $this->Csz_model->base_link().'/photo/no_image.png');
                    }
                    // End sub branch
                    $xml->endBranch();
                }
            }else{
                $xml->addNode('null', '1'); // For check item is empty
            }
            // End Main branch 
            $xml->endBranch();
            // Print the XML to screen
            
            $getXML = $xml->getXml();
            if($config->pagecache_time == 0){
                $cache_time = 1;
            }else{
                $cache_time = $config->pagecache_time;
            }
            $this->cache->save('article_getWidget_'.$this->uri->segment(4).'_'.$this->uri->segment(5), $getXML, ($cache_time * 60));
        }
        header('Content-type: text/xml');
        print $this->cache->get('article_getWidget_'.$this->uri->segment(4).'_'.$this->uri->segment(5));
        exit(1);
    }   

}