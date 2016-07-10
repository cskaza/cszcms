<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Article extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->library('unzip');
        define('LANG', $this->Csz_admin_model->getLang());
        $this->lang->load('admin', LANG);
        $this->lang->load('plugin/article', LANG);
        $this->template->set_template('admin');
        $this->_init();
        admin_helper::plugin_not_active($this->uri->segment(3));
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
        $this->csz_referrer->setIndex('article');

        $this->load->helper('form');
        $this->load->library('pagination');
        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_model->countData('article_content');
        $num_link = 10;
        $base_url = BASE_URL . '/admin/plugin/article/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 4);
        ($this->uri->segment(4)) ? $pagination = $this->uri->segment(4) : $pagination = 0;

        //Get users from database
        $this->template->setSub('article', $this->Csz_admin_model->getIndexData('article_content', $result_per_page, $pagination, 'timestamp_create', 'desc'));
        $this->template->setSub('category', $this->Csz_model->getValueArray('*', 'article_category', "category_name != ''", ''));
        $this->template->setSub('total_row', $total_row);

        //Load the view
        $this->template->loadSub('admin/plugin/article_index');
    }

}
