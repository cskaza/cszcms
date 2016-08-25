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
        $this->load->model('plugin/Article_model');
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
        $this->csz_referrer->setIndex('article'); /* Set index page when redirect after save */
        $search_arr = ' 1=1 ';
        if($this->input->get('search') || $this->input->get('category') || $this->input->get('lang')){
            if($this->input->get('search')){
                $search_arr.= " AND title LIKE '%".$this->input->get('search', TRUE)."%' OR short_desc LIKE '%".$this->input->get('search', TRUE)."%'";
            }
            if($this->input->get('category')){
                $search_arr.= " AND cat_id = '".$this->input->get('category', TRUE)."'";
            }
            if($this->input->get('lang')){
                $search_arr.= " AND lang_iso = '".$this->input->get('lang', TRUE)."'";
            }
        }
        $search_arr.= " AND is_category = 0";
        $this->load->helper('form');
        $this->load->library('pagination');
        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_model->countData('article_db', $search_arr);
        $num_link = 10;
        $base_url = BASE_URL . '/admin/plugin/article/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 4);
        ($this->uri->segment(4)) ? $pagination = $this->uri->segment(4) : $pagination = 0;

        //Get users from database
        $this->template->setSub('article', $this->Csz_admin_model->getIndexData('article_db', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
        $this->template->setSub('category', $this->Csz_model->getValueArray('*', 'article_db', "is_category", '1'));
        $this->template->setSub('total_row', $total_row);
        $this->template->setSub('lang', $this->Csz_model->loadAllLang());

        //Load the view
        $this->template->loadSub('admin/plugin/article_index');
    }
    
    public function add() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');
        $this->template->setSub('category', $this->Csz_model->getValueArray('*', 'article_db', "is_category", '1'));
        $this->template->setSub('lang', $this->Csz_model->loadAllLang());
        //Load the view
        $this->template->loadSub('admin/plugin/article_add');
    }
    
    public function addSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        $is_category = $this->input->post('is_category', TRUE);
        if(!$is_category){
            //Load the form validation library
            $this->load->library('form_validation');
            //Set validation rules
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('short_desc', 'Short Description', 'required');
            $this->form_validation->set_rules('cat_id', 'Category', 'required');
            if ($this->form_validation->run() == FALSE) {
                //Validation failed
                $this->add();
            } else {
                //Validation passed
                //Add the user
                $this->Article_model->insert();
                $this->db->cache_delete_all();
                redirect($this->csz_referrer->getIndex('article'), 'refresh');
            }
        }else{
            if($this->input->post('category_name', TRUE)){
                $this->Article_model->insert();
                $this->db->cache_delete_all();
                redirect($this->csz_referrer->getIndex('article'), 'refresh');
            }else{
                redirect(BASE_URL.'/admin/plugin/article/add?is_category=1', 'refresh');
            }
        }
    }
    
    public function edit() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');
        if($this->uri->segment(5)){
            $this->template->setSub('category', $this->Csz_model->getValueArray('*', 'article_db', "is_category", '1'));
            $this->template->setSub('article', $this->Csz_model->getValue('*', 'article_db', 'article_db_id', $this->uri->segment(5), 1));
            $this->template->setSub('lang', $this->Csz_model->loadAllLang());
            //Load the view
            $this->template->loadSub('admin/plugin/article_edit');
        }else{
            redirect($this->csz_referrer->getIndex('article'), 'refresh');
        } 
    }
    
    public function editSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        $is_category = $this->input->post('is_category', TRUE);
        if($this->uri->segment(5)){
            if(!$is_category){
                //Load the form validation library
                $this->load->library('form_validation');
                //Set validation rules
                $this->form_validation->set_rules('title', 'Title', 'required');
                $this->form_validation->set_rules('short_desc', 'Short Description', 'required');
                $this->form_validation->set_rules('cat_id', 'Category', 'required');
                if ($this->form_validation->run() == FALSE) {
                    //Validation failed
                    $this->edit();
                } else {
                    //Validation passed
                    //Add the user
                    $this->Article_model->update($this->uri->segment(5));
                    $this->db->cache_delete_all();
                    redirect($this->csz_referrer->getIndex('article'), 'refresh');
                }
            }else{
                if($this->input->post('category_name', TRUE)){
                    $this->Article_model->update($this->uri->segment(5));
                    $this->db->cache_delete_all();
                    redirect($this->csz_referrer->getIndex('article'), 'refresh');
                }else{
                    redirect(BASE_URL.'/admin/plugin/article/edit/'.$this->uri->segment(5), 'refresh');
                }
            }
        }else{
            redirect($this->csz_referrer->getIndex('article'), 'refresh');
        }
    }
    
    public function delete() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        if($this->uri->segment(5)){
            //Delete the data
            $this->Article_model->delete($this->uri->segment(5));
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message','<div class="alert alert-success" role="alert">'.$this->lang->line('success_message_alert').'</div>');
        }
        redirect($this->csz_referrer->getIndex('article'), 'refresh');
    }

}
