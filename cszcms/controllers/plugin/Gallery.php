<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
        $this->template->set('title', 'Gallery | ' . $row->site_name);
        $this->template->set('meta_tags', $this->Csz_model->coreMetatags('CSZ CMS | Gallery',$row->keywords));
        $this->template->set('cur_page', $this->page_url);
        $search_arr = " active = '1' AND lang_iso = '".$this->session->userdata('fronlang_iso')."'";
        $this->load->helper('form');
        $this->load->library('pagination');
        // Pages variable
        $result_per_page = 15;
        $total_row = $this->Csz_model->countData('gallery_db', $search_arr);
        $num_link = 10;
        $base_url = BASE_URL . '/plugin/gallery/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 3);
        ($this->uri->segment(3)) ? $pagination = $this->uri->segment(3) : $pagination = 0;

        //Get users from database
        $this->template->setSub('gallery', $this->Csz_admin_model->getIndexData('gallery_db', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
        $this->template->setSub('total_row', $total_row);

        //Load the view
        $this->template->loadSub('frontpage/plugin/gallery_index');
    }
    
    public function view() {
        if($this->uri->segment(4)){
            $album_row = $this->Csz_model->getValue('*', 'gallery_db', "active = '1' AND gallery_db_id = '".$this->uri->segment(4)."'", '', 1);
            if($album_row !== FALSE){
                $row = $this->Csz_model->load_config();
                $this->template->set('title', $album_row->album_name.' | ' . $row->site_name);
                $this->template->set('meta_tags', $this->Csz_model->coreMetatags($album_row->short_desc,$album_row->keyword));
                $this->template->set('cur_page', $this->page_url);

                //Get users from database
                $this->template->setSub('album', $album_row);
                $this->load->library('pagination');
                // Pages variable
                $search_arr = "gallery_db_id = '".$album_row->gallery_db_id."'";
                $result_per_page = 30;
                $total_row = $this->Csz_model->countData('gallery_picture', $search_arr);
                $num_link = 10;
                $base_url = BASE_URL . '/plugin/gallery/view/'.$this->uri->segment(4).'/'.$album_row->url_rewrite.'/';

                // Pageination config
                $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 6);
                ($this->uri->segment(6)) ? $pagination = $this->uri->segment(6) : $pagination = 0;

                //Get users from database
                $this->template->setSub('image', $this->Csz_admin_model->getIndexData('gallery_picture', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
                $this->template->setSub('total_row', $total_row);

                //Load the view
                $this->template->loadSub('frontpage/plugin/gallery_view');
            }else{
                redirect(BASE_URL.'/plugin/gallery', 'refresh');
            }
        }else{
            redirect(BASE_URL.'/plugin/gallery', 'refresh');
        }
    }

}