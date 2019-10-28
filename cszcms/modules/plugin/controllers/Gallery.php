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

class Gallery extends CI_Controller {

    /**
     Article Plugin by CSKAZA
     */
    var $page_url;
    function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
        $this->load->database();
        $row = $this->Csz_model->load_config();
        $this->load->model('plugin/Gallery_model');
        if ($row->themes_config) {
            $this->template->set_template($row->themes_config);
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
        member_helper::plugin_not_active('gallery');
    }

    public function _init() {
        $this->template->set('core_css', $this->Csz_model->coreCss('assets/css/ekko-lightbox.min.css'));
        $js_arr = array(base_url() . 'assets/js/ekko-lightbox.min.js', base_url() . 'assets/js/ekko-lightbox.run.js');
        $this->template->set('core_js', $this->Csz_model->coreJs($js_arr));
        $row = $this->Csz_model->load_config();
        $this->page_url = $this->uri->segment(2);	
        $this->template->set('additional_js', $row->additional_js);
        $this->template->set('additional_metatag', $row->additional_metatag);
        if (CACHE_TYPE == 'file') {
            $this->load->driver('cache', array('adapter' => 'file', 'key_prefix' => EMAIL_DOMAIN . '_'));
        } else {
            $this->load->driver('cache', array('adapter' => CACHE_TYPE, 'backup' => 'file', 'key_prefix' => EMAIL_DOMAIN . '_'));
        }
    }

    public function index() {
        $row = $this->Csz_model->load_config();
        $title = $this->Csz_model->pagesTitle($this->Csz_model->getLabelLang('gallery_header'));
        $this->template->set('title', $title);
        $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title,$row->keywords,$title));
        $this->template->set('cur_page', $this->page_url);
        $search_arr = " active = '1' AND lang_iso = '".$this->session->userdata('fronlang_iso')."'";
        $this->load->helper('form');
        $this->load->library('pagination');
        // Pages variable
        $result_per_page = 15;
        $total_row = $this->Csz_model->countData('gallery_db', $search_arr);
        $num_link = 10;
        $base_url = $this->Csz_model->base_link(). '/plugin/gallery/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 3);
        ($this->uri->segment(3)) ? $pagination = $this->uri->segment(3) : $pagination = 0;

        //Get users from database
        $this->template->setSub('gallery', $this->Gallery_model->getIndexData('gallery_db', $result_per_page, $pagination, $search_arr));
        $this->template->setSub('total_row', $total_row);

        //Load the view
        $this->template->loadFrontPlugin('gallery/gallery_index');
    }
    
    public function view() {
        if($this->uri->segment(4)){
            $album_row = $this->Csz_model->getValue('*', 'gallery_db', "active = '1' AND gallery_db_id = '".$this->uri->segment(4)."'", '', 1);
            if($album_row !== FALSE){
                Member_helper::is_allow_groups($album_row->user_groups_idS);
                if($this->session->userdata('fronlang_iso') != $album_row->lang_iso){
                    $this->Csz_model->setSiteLang($album_row->lang_iso);
                }
                $row = $this->Csz_model->load_config();
                $this->template->set('title', $this->Csz_model->pagesTitle($album_row->album_name));
                $this->template->set('meta_tags', $this->Csz_model->coreMetatags($album_row->short_desc,$album_row->keyword,$album_row->album_name,$this->Gallery_model->getFirstImgs($album_row->gallery_db_id)));
                $this->template->set('cur_page', $this->page_url);

                //Get users from database
                $this->template->setSub('album', $album_row);
                $this->load->library('pagination');
                // Pages variable
                $search_arr = "gallery_db_id = '".$album_row->gallery_db_id."'";
                $result_per_page = 30;
                $total_row = $this->Csz_model->countData('gallery_picture', $search_arr);
                $num_link = 10;
                $base_url = $this->Csz_model->base_link(). '/plugin/gallery/view/'.$this->uri->segment(4).'/'.$album_row->url_rewrite.'/';

                // Pageination config
                $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 6);
                ($this->uri->segment(6)) ? $pagination = $this->uri->segment(6) : $pagination = 0;

                //Get users from database
                $this->template->setSub('image', $this->Csz_admin_model->getIndexData('gallery_picture', $result_per_page, $pagination, 'arrange', 'asc', $search_arr));
                $this->template->setSub('total_row', $total_row);

                //Load the view
                $this->template->loadFrontPlugin('gallery/gallery_view');
            }else{
                redirect($this->Csz_model->base_link().'/plugin/gallery', 'refresh');
            }
        }else{
            redirect($this->Csz_model->base_link().'/plugin/gallery', 'refresh');
        }
    }
    
    public function viewxml() {
        $config = $this->Csz_model->load_config();
        $this->db->cache_on();
        
        if (!$this->cache->get('gallery_getWidget_album' . $this->uri->segment(4))) {
            // For New Category
            $this->load->library('Xml_writer');
            // Initiate class
            $xml = new Xml_writer;
            $xml->setRootName('csz_widget');
            $xml->initiate();
            // Start Main branch
            $xml->startBranch('plugin');
            $album_row = $this->Csz_model->getValue('*', 'gallery_db', "active = '1' AND gallery_db_id = '" . $this->uri->segment(4) . "'", '', 1);
            if($album_row === FALSE){
                $xml->addNode('main_url', $this->Csz_model->base_link().'/plugin/gallery');
                $xml->addNode('null', '1');
            }else{
                $xml->addNode('main_url', $this->Csz_model->base_link() . '/plugin/gallery/view/' . $album_row->gallery_db_id . '/' . $album_row->url_rewrite);
                $search_arr = "gallery_db_id = '" . $album_row->gallery_db_id . "'";
                $photo = $this->Csz_admin_model->getIndexData('gallery_picture', 100, 0, 'arrange', 'asc', $search_arr);
                if ($photo !== FALSE) {
                    $xml->addNode('null', '0'); // For check item is not empty
                    foreach ($photo as $value) {
                        $xml->startBranch('item', array('id' => $value['gallery_picture_id']));
                        if ($value['gallery_type'] == 'multiimages') {
                            // start sub branch
                            $img_url = ($value['file_upload']) ? base_url() . 'photo/plugin/gallery/' . $value['file_upload'] : base_url() . 'photo/no_image.png';
                            $xml->addNode('sub_url', $img_url);
                            $xml->addNode('title', $value['caption']);
                            $xml->addNode('short_desc', $value['caption']);
                            $xml->addNode('photo', $img_url);
                        } else if ($value['gallery_type'] == 'youtubevideos') {
                            $youtube_script_replace = array("http://youtu.be/", "http://www.youtube.com/watch?v=", "https://youtu.be/", "https://www.youtube.com/watch?v=", "http://www.youtube.com/embed/", "https://www.youtube.com/embed/");
                            $youtube_value = str_replace($youtube_script_replace, '', $value['youtube_url']);
                            $xml->addNode('sub_url', 'http://www.youtube.com/embed/' . $youtube_value);
                            $xml->addNode('title', $value['caption']);
                            $xml->addNode('short_desc', $value['caption']);
                            $img_url = ($value['youtube_url']) ? '//i1.ytimg.com/vi/' . $youtube_value . '/mqdefault.jpg' : base_url() . 'photo/no_image.png';
                            $xml->addNode('photo', $img_url);
                        }
                        // End sub branch
                        $xml->endBranch();
                    }
                } else {
                    $xml->addNode('null', '1'); // For check item is empty
                }
            }
            // End Main branch 
            $xml->endBranch();
            // Print the XML to screen
            $getXML = $xml->getXml();
            if ($config->pagecache_time == 0) {
                $cache_time = 1;
            } else {
                $cache_time = $config->pagecache_time;
            }
            $this->cache->save('gallery_getWidget_album' . $this->uri->segment(4), $getXML, ($cache_time * 60));
        }
        header('Content-type: text/xml');
        print $this->cache->get('gallery_getWidget_album' . $this->uri->segment(4));
        exit(1);
    }
    
    public function rss() {
        // creating rss feed with our most recent 20
        // first load the library
        $this->load->library('feed');
        $row = $this->Csz_model->load_config();
        if($row->pagecache_time != 0){ 
            $this->db->cache_on();
        }
        // create new instance
        $feed = new Feed();
        // set your feed's title, description, link, pubdate and language
        $feed->title = $row->site_name;
        $feed->description = $this->Csz_model->getLabelLang('gallery_header') . ' | ' . $row->site_name;
        $feed->link = $this->Csz_model->base_link().'/plugin/gallery';
        $search_arr = " active = '1'";
        $limit = 20;
        // get article list
        $gallery = $this->Gallery_model->getIndexData('gallery_db', $limit, 0, $search_arr);
        // add posts to the feed
        if($gallery !== FALSE){
            foreach ($gallery as $a)
            {
                // set item's title, author, url, pubdate and description
                $url = $this->Csz_model->base_link().'/plugin/gallery/view/'.$a['gallery_db_id'].'/'.$a['url_rewrite'];
                $feed->add($a['album_name'], $row->site_name, $url, $a['timestamp_create'], $a['short_desc']);
            }
        }
        // show your feed (options: 'atom' (recommended) or 'rss')
        $feed->render('rss', $row->pagecache_time, 'gallery_RSS');
    }
    
    public function getWidget() {
        $config = $this->Csz_model->load_config();
        $this->db->cache_on();       
        
        if (!$this->cache->get('gallery_getWidget_'.$this->uri->segment(4))) {
            // For New Category
            $this->load->library('Xml_writer');
            // Initiate class
            $xml = new Xml_writer;
            $xml->setRootName('csz_widget');
            $xml->initiate();
            // Start Main branch
            $xml->startBranch('plugin'); 
            $xml->addNode('main_url', $this->Csz_model->base_link().'/plugin/gallery');
            // Get article 10 items
            if ($this->uri->segment(4)) {
                $search_arr = " active = '1' AND lang_iso = '".$this->uri->segment(4)."'";
            }else{
                $search_arr = " active = '1'";
            }
            $gallery = $this->Gallery_model->getIndexData('gallery_db', 100, 0, $search_arr);
            if($gallery !== FALSE){
                $xml->addNode('null', '0'); // For check item is not empty
                foreach ($gallery as $row) {
                    // start sub branch
                    $xml->startBranch('item', array('id' => $row['gallery_db_id'])); 
                    $xml->addNode('sub_url', $this->Csz_model->base_link().'/plugin/gallery/view/'.$row['gallery_db_id'].'/'.$row['url_rewrite']);
                    $xml->addNode('title', $row['album_name']);
                    $xml->addNode('short_desc', $row['short_desc']);
                    $f_img = $this->Gallery_model->getFirstImgs($row['gallery_db_id']);
                    $xml->addNode('photo', $f_img);
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
            $this->cache->save('gallery_getWidget_'.$this->uri->segment(4), $getXML, ($cache_time * 60));
        }
        header('Content-type: text/xml');
        print $this->cache->get('gallery_getWidget_'.$this->uri->segment(4));
        exit(1);
    }

}