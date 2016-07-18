<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
        $this->_init();
        member_helper::plugin_not_active($this->uri->segment(2));
    }

    public function _init() {
        $this->template->set('core_css', $this->Csz_model->coreCss());
        $this->template->set('core_js', $this->Csz_model->coreJs());
        $row = $this->Csz_model->load_config();
        $this->page_url = $this->Csz_model->getCurPages();	
        $this->template->set('additional_js', $row->additional_js);
        $this->template->set('additional_metatag', $row->additional_metatag);
    }

    public function index() {
        $row = $this->Csz_model->load_config();
        $this->template->set('title', 'Article | ' . $row->site_name);
        $this->template->set('meta_tags', $this->Csz_model->coreMetatags('CSZ CMS | Article',$row->keywords));
        $this->template->set('cur_page', $this->page_url);
        $search_arr = " is_category = '0' AND active = '1' AND lang_iso = '".$this->session->userdata('fronlang_iso')."'";
        $this->load->helper('form');
        $this->load->library('pagination');
        // Pages variable
        $result_per_page = 10;
        $total_row = $this->Csz_model->countData('article_db', $search_arr);
        $num_link = 10;
        $base_url = BASE_URL . '/plugin/article/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 3);
        ($this->uri->segment(3)) ? $pagination = $this->uri->segment(3) : $pagination = 0;

        //Get users from database
        $this->template->setSub('article', $this->Csz_admin_model->getIndexData('article_db', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
        $this->template->setSub('total_row', $total_row);

        //Load the view
        $this->template->loadSub('frontpage/plugin/article_index');
    }
    
    public function category() {
        if($this->uri->segment(4)){
            $cat_row = $this->Csz_model->getValue('*', 'article_db', "is_category = '1' AND active = '1' AND url_rewrite = '".$this->uri->segment(4)."'", '', 1);
            if($cat_row !== FALSE){
                $row = $this->Csz_model->load_config();
                $this->template->set('title', 'Article | ' . $row->site_name);
                $this->template->set('meta_tags', $this->Csz_model->coreMetatags('CSZ CMS | Article',$row->keywords));
                $this->template->set('cur_page', $this->page_url);
                $search_arr = " is_category = 0 AND active = '1' AND lang_iso = '".$this->session->userdata('fronlang_iso')."' AND cat_id = $cat_row->article_db_id";
                $this->load->helper('form');
                $this->load->library('pagination');
                // Pages variable
                $result_per_page = 10;
                $total_row = $this->Csz_model->countData('article_db', $search_arr);
                $num_link = 10;
                $base_url = BASE_URL . '/plugin/article/category/'.$this->uri->segment(4).'/';

                // Pageination config
                $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 5);
                ($this->uri->segment(5)) ? $pagination = $this->uri->segment(5) : $pagination = 0;

                //Get users from database
                $this->template->setSub('article', $this->Csz_admin_model->getIndexData('article_db', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
                $this->template->setSub('total_row', $total_row);
                $this->template->setSub('category_name', $cat_row->category_name);

                //Load the view
                $this->template->loadSub('frontpage/plugin/article_category');
            }else{
                redirect(BASE_URL.'/plugin/article', 'refresh');
            }
        }else{
            redirect(BASE_URL.'/plugin/article', 'refresh');
        }
    }
    
    public function view() {
        if($this->uri->segment(4)){
            $art_row = $this->Csz_model->getValue('*', 'article_db', "is_category = '0' AND active = '1' AND article_db_id = '".$this->uri->segment(4)."'", '', 1);
            if($art_row !== FALSE){
                $row = $this->Csz_model->load_config();
                $this->template->set('title', $art_row->title.' | ' . $row->site_name);
                $this->template->set('meta_tags', $this->Csz_model->coreMetatags($art_row->short_desc,$art_row->keyword));
                $this->template->set('cur_page', $this->page_url);

                //Get users from database
                $this->template->setSub('article', $art_row);
                $cat_row = $this->Csz_model->getValue('category_name', 'article_db', "is_category = '1' AND active = '1' AND article_db_id = '".$art_row->cat_id."'", '', 1);
                $this->template->setSub('category_name', $cat_row->category_name);

                //Load the view
                $this->template->loadSub('frontpage/plugin/article_view');
            }else{
                redirect(BASE_URL.'/plugin/article', 'refresh');
            }
        }else{
            redirect(BASE_URL.'/plugin/article', 'refresh');
        }
    }

}