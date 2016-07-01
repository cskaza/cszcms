<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     * $this->template->set_template('template_name'); to use another one, 
     * before $this->template->load('index_page', array('view' => 'data'));
     * ---
     * OR
     * $this->template->load('index_page', array('view' => 'data'), 'template_name'); If template file name is 'main'
     */
    var $page_rs;
    var $page_url;
    
    function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
        $this->load->database();
        $row = $this->Csz_model->load_config();
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
        $this->_init();
    }

    public function _init() {
        $this->template->set('core_css', $this->Csz_model->coreCss());
        $this->template->set('core_js', $this->Csz_model->coreJs());
        $row = $this->Csz_model->load_config();
        $pageURL = $this->Csz_model->getCurPages();	
        $this->page_url = $pageURL;
        $this->page_rs = $this->Csz_model->load_page($pageURL);
        $page_rs = $this->page_rs;
        $this->template->set('additional_js', $row->additional_js);
        $this->template->set('additional_metatag', $row->additional_metatag);
        if ($page_rs !== FALSE) {
            $this->template->set('title', $page_rs->page_title . ' | ' . $row->site_name);
            $this->template->set('meta_tags', $this->Csz_model->coreMetatags($page_rs->page_desc,$page_rs->page_keywords));
            $this->template->set('cur_page', $page_rs->page_url);
        } else {        
            $this->template->set('title', '404 Page not Found | ' . $row->site_name);
            $this->template->set('meta_tags', $this->Csz_model->coreMetatags('404 Page not Found',$row->keywords));
            $this->template->set('cur_page', $pageURL);
        }
    }

    public function index() {
        $config = $this->Csz_model->load_config();
        //Get pages from database
        $this->template->setSub('page', $this->page_url);
        $this->template->setSub('page_rs', $this->page_rs);
        if($this->uri->segment(1)){
            $this->output->cache($config->pagecache_time);
        }
        //Load the view
        $this->template->loadSub('frontpage/getpage');
    }
    
    public function setLang() {
        $this->Csz_model->setSiteLang($this->uri->segment(2));
        redirect('./', 'refresh');
    }

}