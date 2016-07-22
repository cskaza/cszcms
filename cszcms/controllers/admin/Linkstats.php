<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Linkstats extends CI_Controller {

    function __construct() {
        parent::__construct();      
        define('LANG', $this->Csz_admin_model->getLang());
        $this->lang->load('admin', LANG);
        $this->template->set_template('admin');
        $this->_init();
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
        $this->load->helper('form');
        $this->load->library('pagination');   
        $this->csz_referrer->setIndex();
        $search_arr = '';
        if($this->input->get('search') || $this->input->get('start_date') || $this->input->get('end_date')){
            $search_arr.= ' 1=1 ';
            if($this->input->get('search')){
                $search_arr.= " AND link LIKE '%".$this->input->get('search', TRUE)."%'";
            }
            if($this->input->get('start_date') && !$this->input->get('end_date')){
                $search_arr.= " AND timestamp_create >= '".$this->input->get('start_date',true)." 00:00:00'";
            }elseif($this->input->get('end_date') && !$this->input->get('start_date')){
                $search_arr.= " AND timestamp_create <= '".$this->input->get('end_date',true)." 23:59:59'";
            }elseif($this->input->get('start_date') && $this->input->get('end_date')){
                $search_arr.= " AND timestamp_create >= '".$this->input->get('start_date',true)." 00:00:00' AND timestamp_create <= '".$this->input->get('end_date',true)." 23:59:59'";
            }
        }
        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_model->countData('link_statistic', $search_arr, 'link');
        $num_link = 10;
        $base_url = BASE_URL . '/admin/linkstats/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url,$total_row,$result_per_page,$num_link);     
        ($this->uri->segment(3))? $pagination = $this->uri->segment(3) : $pagination = 0;

        //Get users from database
        $this->template->setSub('linkstats', $this->Csz_admin_model->getIndexData('link_statistic', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr, 'link'));
        $this->template->setSub('total_row',$total_row);
        //Load the view
        $this->template->loadSub('admin/linkstats_index');
    }
    
    public function view() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        if($this->uri->segment(4)){
            $this->csz_referrer->setIndex('view');
            $this->load->helper('form');
            $this->load->library('pagination');   
            $getLink = $this->Csz_model->getValue('*', 'link_statistic', 'link_statistic_id', $this->uri->segment(4), 1);
            if(empty($getLink)|| $getLink == NULL){
                redirect($this->csz_referrer->getIndex(), 'refresh');
                exit();
            }
            $search_arr = "link = '".str_replace("'", "\'", $getLink->link)."' ";
            if($this->input->get('search') || $this->input->get('start_date') || $this->input->get('end_date')){
                if($this->input->get('search')){
                    $search_arr.= " AND ip_address LIKE '%".$this->input->get('search', TRUE)."%'";
                }
                if($this->input->get('start_date') && !$this->input->get('end_date')){
                    $search_arr.= " AND timestamp_create >= '".$this->input->get('start_date',true)." 00:00:00'";
                }elseif($this->input->get('end_date') && !$this->input->get('start_date')){
                    $search_arr.= " AND timestamp_create <= '".$this->input->get('end_date',true)." 23:59:59'";
                }elseif($this->input->get('start_date') && $this->input->get('end_date')){
                    $search_arr.= " AND timestamp_create >= '".$this->input->get('start_date',true)." 00:00:00' AND timestamp_create <= '".$this->input->get('end_date',true)." 23:59:59'";
                }
            }
            // Pages variable
            $result_per_page = 20;
            $total_row = $this->Csz_model->countData('link_statistic', $search_arr);
            $num_link = 10;
            $base_url = BASE_URL . '/admin/linkstats/view/'.$this->uri->segment(4).'/';

            // Pageination config
            $this->Csz_admin_model->pageSetting($base_url,$total_row,$result_per_page,$num_link,5);     
            ($this->uri->segment(5))? $pagination = $this->uri->segment(5) : $pagination = 0;

            //Get users from database
            $this->template->setSub('linkstats', $this->Csz_admin_model->getIndexData('link_statistic', $result_per_page, $pagination, 'link_statistic_id', 'desc', $search_arr));
            $this->template->setSub('total_row',$total_row);
            $this->template->setSub('url_link',$getLink->link);
            //Load the view
            $this->template->loadSub('admin/linkstats_view');
        }else{
            redirect($this->csz_referrer->getIndex(), 'refresh');
        }
    }
    
    public function deleteViewByID() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        $delR = $this->input->post('delR');
        if(isset($delR)){
            foreach ($delR as $value) {
                if ($value) {
                    $this->Csz_admin_model->removeData('link_statistic', 'link_statistic_id', $value);
                }
            }
        }
        redirect($this->csz_referrer->getIndex('view'), 'refresh');
    }
    
    public function deleteIndexByURL() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        $delR = $this->input->post('delR');
        if(isset($delR)){
            foreach ($delR as $value) {
                if ($value) {
                    $getLink = $this->Csz_model->getValue('link', 'link_statistic', 'link_statistic_id', $value, 1);
                    $this->Csz_admin_model->removeData('link_statistic', 'link', $getLink->link);
                }
            }
        }
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }

    public function deleteByID() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        if($this->uri->segment(4)){
            $this->Csz_admin_model->removeData('link_statistic', 'link_statistic_id', $this->uri->segment(4));   
        }
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }
    
    public function deleteByURL() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        if($this->uri->segment(4)){
            $getLink = $this->Csz_model->getValue('link', 'link_statistic', 'link_statistic_id', $this->uri->segment(4), 1);
            $this->Csz_admin_model->removeData('link_statistic', 'link', $getLink->link);   
        }
        redirect($this->csz_referrer->getIndex(), 'refresh');
    }

}
