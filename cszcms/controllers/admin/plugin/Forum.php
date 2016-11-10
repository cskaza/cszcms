<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('file');
        define('LANG', $this->Csz_admin_model->getLang());
        $this->lang->load('admin', LANG);
        $this->lang->load('plugin/forum', LANG);
        $this->template->set_template('admin');
        $this->load->model('plugin/Forum_model');
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
        $this->csz_referrer->setIndex('forum'); /* Set index page when redirect after save */

        //Get users from database
        $this->template->setSub('total_cat', $this->Csz_model->countData('article_db', "active = '1' AND is_category = '1'"));
        $this->template->setSub('total_art', $this->Csz_model->countData('article_db', "active = '1' AND is_category = '0'"));

        //Load the view
        $this->template->loadSub('admin/plugin/forum/home');
    }
    
    public function config() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        
        $this->template->setSub('settings', $this->Csz_model->getValue('*', 'shop_config', 'shop_config_id', '1', 1));

        //Load the view
        $this->template->loadSub('admin/plugin/forum/config_index');
    }

}
