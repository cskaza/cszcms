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
class Shop extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('file');
        define('LANG', $this->Csz_admin_model->getLang());
        $this->lang->load('admin', LANG);
        $this->lang->load('plugin/shop', LANG);
        $this->template->set_template('admin');
        $this->load->model('plugin/Shop_model');
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
        $this->csz_referrer->setIndex('shop'); /* Set index page when redirect after save */
        //Get data from database       
        $shop_config = $this->Shop_model->load_config();
        $this->template->setSub('payment', $this->Csz_model->getValueArray('*', 'shop_payment', "ip_address != ''", '', 20, 'timestamp_create', 'desc'));
        $this->template->setSub('total_complete', $this->Csz_model->countData('shop_payment', "payment_status = 'Completed'"));
        $this->template->setSub('total_order', $this->Csz_model->countData('shop_payment'));
        $this->template->setSub('total_shipping', $this->Csz_model->countData('shop_shipping'));
        $this->template->setSub('total_product', $this->Csz_model->countData('shop_product',"active = '1'"));
        $this->template->setSub('shop_config', $shop_config);
        //Load the view
        $this->template->loadSub('admin/plugin/shop/home');
    }

    public function config() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        $this->csz_referrer->setIndex('shop'); /* Set index page when redirect after save */
        //Get users from database       
        $this->template->setSub('settings', $this->Csz_model->getValue('*', 'shop_config', 'shop_config_id', '1', 1));
        $this->template->setSub('currency_code', $this->Shop_model->currencyCode());

        //Load the view
        $this->template->loadSub('admin/plugin/shop/config_index');
    }

    public function configSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        //Save Config
        $this->Shop_model->configSave();
        $this->db->cache_delete_all();
        $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        redirect($this->csz_referrer->getIndex('shop'), 'refresh');
    }

    public function category() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        $this->csz_referrer->setIndex('shop'); /* Set index page when redirect after save */
       
        $total_row = $this->Csz_model->countData('shop_category');
      
        //Get users from database
        $this->template->setSub('category', $this->Csz_model->getValueArray('*', 'shop_category', '', '', 0, 'arrange', 'asc'));
        $this->template->setSub('total_row', $total_row);

        //Load the view
        $this->template->loadSub('admin/plugin/shop/category_index');
    }
    
    public function catIndexSave(){
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        $i = 0;
        $arrange = 1;
        $shop_category_id = $this->input->post('shop_category_id', TRUE);
        if (!empty($shop_category_id)) {
            while ($i < count($shop_category_id)) {
                if ($shop_category_id[$i]) {
                    $this->db->set('arrange', $arrange, FALSE);
                    $this->db->set('timestamp_update', 'NOW()', FALSE);
                    $this->db->where("shop_category_id", $shop_category_id[$i]);
                    $this->db->update('shop_category');
                    $arrange++;
                }
                $i++;
            }
        }
        $this->db->cache_delete_all();
        $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        redirect($this->csz_referrer->getIndex('shop'), 'refresh');
    }

    public function catNew() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');
        $this->template->setSub('main_category', $this->Csz_model->getValueArray('*', 'shop_category', "active = '1' AND shop_category_main_id = '0'", ''));
        //Load the view
        $this->template->loadSub('admin/plugin/shop/category_add');
    }

    public function catNewSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('name', 'Products Category Name', 'required');
        $this->form_validation->set_rules('short_desc', 'Short Description', 'required');
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->catNew();
        } else {
            //Validation passed
            //Add the user
            $this->Shop_model->catInsert();
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex('shop'), 'refresh');
        }
    }

    public function catEdit() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');
        if ($this->uri->segment(5)) {
            $this->template->setSub('main_category', $this->Csz_model->getValueArray('*', 'shop_category', "active = 1 AND shop_category_main_id = 0 AND shop_category_id <> '" . $this->uri->segment(5) . "'", ''));
            $this->template->setSub('category', $this->Csz_model->getValue('*', 'shop_category', 'shop_category_id', $this->uri->segment(5), 1));
            //Load the view
            $this->template->loadSub('admin/plugin/shop/category_edit');
        } else {
            redirect($this->csz_referrer->getIndex('shop'), 'refresh');
        }
    }

    public function catEditSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        if ($this->uri->segment(5)) {
            //Load the form validation library
            $this->load->library('form_validation');
            //Set validation rules
            $this->form_validation->set_rules('name', 'Products Category Name', 'required');
            $this->form_validation->set_rules('short_desc', 'Short Description', 'required');
            if ($this->form_validation->run() == FALSE) {
                //Validation failed
                $this->catEdit();
            } else {
                //Validation passed
                //Add the user
                $this->Shop_model->catUpdate($this->uri->segment(5));
                $this->db->cache_delete_all();
                $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
                redirect($this->csz_referrer->getIndex('shop'), 'refresh');
            }
        } else {
            redirect($this->csz_referrer->getIndex('shop'), 'refresh');
        }
    }

    public function catDel() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        if ($this->uri->segment(5)) {
            $this->Shop_model->delete($this->uri->segment(5), 'shop_category');
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        }
        redirect($this->csz_referrer->getIndex('shop'), 'refresh');
    }

    public function products() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        $this->csz_referrer->setIndex('shop'); /* Set index page when redirect after save */
        $search_arr = ' 1=1 ';
        if ($this->input->get('search') || $this->input->get('category') || $this->input->get('product_status')) {
            if ($this->input->get('search')) {
                $search_arr.= " AND product_name LIKE '%" . $this->input->get('search', TRUE) . "%' OR short_desc LIKE '%" . $this->input->get('search', TRUE) . "%' OR keyword LIKE '%" . $this->input->get('search', TRUE) . "%' OR product_code LIKE '%" . $this->input->get('search', TRUE) . "%'";
            }
            if ($this->input->get('category')) {
                $search_arr.= " AND shop_category_id = '" . $this->input->get('category', TRUE) . "'";
            }
            if ($this->input->get('product_status')) {
                $search_arr.= " AND product_status = '" . $this->input->get('product_status', TRUE) . "'";
            }
        }
        $this->load->helper('form');
        $this->load->library('pagination');
        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_model->countData('shop_product', $search_arr);
        $num_link = 10;
        $base_url = BASE_URL . '/admin/plugin/shop/products/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 5);
        ($this->uri->segment(5)) ? $pagination = $this->uri->segment(5) : $pagination = 0;

        //Get users from database
        $this->template->setSub('products', $this->Csz_admin_model->getIndexData('shop_product', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
        $this->template->setSub('category', $this->Csz_model->getValueArray('*', 'shop_category', "active", '1'));
        $this->template->setSub('total_row', $total_row);
        $this->template->setSub('currency', $this->Shop_model->load_config()->currency_code);
        $this->template->setSub('product_status', $this->Shop_model->productStatus());

        //Load the view
        $this->template->loadSub('admin/plugin/shop/products_index');
    }

    public function productNew() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');

        $this->template->setSub('category', $this->Csz_model->getValueArray('*', 'shop_category', "active", '1'));
        $this->template->setSub('product_status', $this->Shop_model->productStatus());
        //Load the view
        $this->template->loadSub('admin/plugin/shop/products_add');
    }

    public function productNewSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('product_name', 'Products Name', 'required');
        $this->form_validation->set_rules('shop_category_id', 'Products Category', 'required');
        $this->form_validation->set_rules('short_desc', 'Short Description', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');
        $this->form_validation->set_rules('stock', 'Amount', 'required');
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->productNew();
        } else {
            //Validation passed
            //Add the user
            $this->Shop_model->productInsert();
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex('shop'), 'refresh');
        }
    }

    public function productEdit() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');
        $this->csz_referrer->setIndex('shop_edit'); /* Set index page when redirect after save */
        if ($this->uri->segment(5)) {
            $this->template->setSub('product', $this->Csz_model->getValue('*', 'shop_product', 'shop_product_id', $this->uri->segment(5), 1));
            $this->template->setSub('category', $this->Csz_model->getValueArray('*', 'shop_category', "active", '1'));
            $this->template->setSub('product_status', $this->Shop_model->productStatus());
            $search_arr = "shop_product_id = '" . $this->uri->segment(5) . "'";
            $this->template->setSub('showfile', $this->Csz_admin_model->getIndexData('shop_product_imgs', 0, 0, 'arrange', 'ASC', $search_arr));
            $this->template->setSub('total_row', $this->Csz_model->countData('shop_product_imgs', $search_arr));
            $this->template->setSub('field_rs', $this->Csz_model->getValueArray('*', 'shop_product_option', 'shop_product_id', $this->uri->segment(5)));
            //Load the view
            $this->template->loadSub('admin/plugin/shop/products_edit');
        } else {
            redirect($this->csz_referrer->getIndex('shop'), 'refresh');
        }
    }

    public function productEditSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        if ($this->uri->segment(5)) {
            //Load the form validation library
            $this->load->library('form_validation');
            //Set validation rules
            $this->form_validation->set_rules('product_name', 'Products Name', 'required');
            $this->form_validation->set_rules('shop_category_id', 'Products Category', 'required');
            $this->form_validation->set_rules('short_desc', 'Short Description', 'required');
            $this->form_validation->set_rules('price', 'Price', 'required');
            $this->form_validation->set_rules('stock', 'Amount', 'required');
            if ($this->form_validation->run() == FALSE) {
                //Validation failed
                $this->productEdit();
            } else {
                //Validation passed
                //Add the user
                $this->Shop_model->productUpdate($this->uri->segment(5));
                $this->db->cache_delete_all();
                $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
                redirect($this->csz_referrer->getIndex('shop'), 'refresh');
            }
        } else {
            redirect($this->csz_referrer->getIndex('shop'), 'refresh');
        }
    }

    public function productDel() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        if ($this->uri->segment(5)) {
            $this->Shop_model->delete($this->uri->segment(5), 'shop_product');
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        }
        redirect($this->csz_referrer->getIndex('shop'), 'refresh');
    }

    public function delProductField() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        if ($this->uri->segment(5)) {
            $this->Shop_model->delete($this->uri->segment(5), 'shop_product_option');
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        }
        redirect($this->csz_referrer->getIndex('shop_edit'), 'refresh');
    }

    public function htmlUpload() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        if ($this->uri->segment(5)) {
            $path = FCPATH . "/photo/plugin/shop/";
            $files = $_FILES;
            $cpt = count($_FILES['files']['name']);
            for ($i = 0; $i < $cpt; $i++) {
                if ($files['files']['name'][$i]) {
                    $file_id = time() . "_" . rand(1111, 9999);
                    $photo_name = $files['files']['name'][$i];
                    $photo = $files['files']['tmp_name'][$i];
                    $file_id1 = $this->Csz_admin_model->file_upload($photo, $photo_name, '', $path, $file_id, '');
                    if ($file_id1) {
                        $this->Shop_model->insertFileUpload($this->uri->segment(5), $file_id1);
                    }
                }
            }
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex('shop_edit'), 'refresh');
        } else {
            $this->session->set_flashdata('error_message', '<div class="alert alert-danger" role="alert">' . $this->lang->line('error_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex('shop_edit'), 'refresh');
        }
    }

    public function uploadIndexSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        $path = FCPATH . "/photo/plugin/shop/";
        $filedel = $this->input->post('filedel', TRUE);
        $caption = $this->input->post('caption', TRUE);
        $i = 0;
        $arrange = 1;
        $shop_product_imgs_id = $this->input->post('shop_product_imgs_id', TRUE);
        if (isset($filedel)) {
            foreach ($filedel as $value) {
                if ($value) {
                    $filename = $this->Csz_model->getValue('file_upload', 'shop_product_imgs', 'shop_product_imgs_id', $value, 1);
                    if ($filename->file_upload) {
                        @unlink($path . $filename->file_upload);
                    }
                    $this->Csz_admin_model->removeData('shop_product_imgs', 'shop_product_imgs_id', $value);
                }
            }
        }
        if (!empty($shop_product_imgs_id)) {
            while ($i < count($shop_product_imgs_id)) {
                if ($shop_product_imgs_id[$i]) {
                    $this->db->set('arrange', $arrange, FALSE);
                    $this->db->set('timestamp_update', 'NOW()', FALSE);
                    $this->db->where("shop_product_imgs_id", $shop_product_imgs_id[$i]);
                    $this->db->update('shop_product_imgs');
                    $arrange++;
                }
                $i++;
            }
        }
        if (isset($caption)) {
            foreach ($caption as $key => $value) {
                if ($value && $key) {
                    $this->db->set('caption', $value, TRUE);
                    $this->db->set('timestamp_update', 'NOW()', FALSE);
                    $this->db->where('shop_product_imgs_id', $key);
                    $this->db->update('shop_product_imgs');
                }
            }
        }
        $this->db->cache_delete_all();
        $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        redirect($this->csz_referrer->getIndex('shop_edit'), 'refresh');
    }

    public function order() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        $this->csz_referrer->setIndex('shop'); /* Set index page when redirect after save */
        $search_arr = "shipping IS NULL ";
        if ($this->input->get('search') || $this->input->get('payment_status')) {
            if ($this->input->get('search')) {
                $search_arr.= " AND inv_id LIKE '%" . $this->input->get('search', TRUE) . "%' OR email LIKE '%" . $this->input->get('search', TRUE) . "%' OR name LIKE '%" . $this->input->get('search', TRUE) . "%' OR phone LIKE '%" . $this->input->get('search', TRUE) . "%' OR address LIKE '%" . $this->input->get('search', TRUE) . "%'";
            }
            if ($this->input->get('payment_status')) {
                $search_arr.= " AND payment_status LIKE '%" . $this->input->get('payment_status', TRUE) . "%'";
            }
        }
        $this->load->helper('form');
        $this->load->library('pagination');
        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_model->countData('shop_payment', $search_arr);
        $num_link = 10;
        $base_url = BASE_URL . '/admin/plugin/shop/order/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 5);
        ($this->uri->segment(5)) ? $pagination = $this->uri->segment(5) : $pagination = 0;

        //Get users from database
        $this->template->setSub('payment', $this->Csz_admin_model->getIndexData('shop_payment', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
        $this->template->setSub('total_row', $total_row);

        //Load the view
        $this->template->loadSub('admin/plugin/shop/order_index');
    }

    public function orderDel() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_not_admin($this->session->userdata('admin_type'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        if ($this->uri->segment(5)) {
            $this->Shop_model->delete($this->uri->segment(5), 'shop_payment');
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        }
        redirect($this->csz_referrer->getIndex('shop'), 'refresh');
    }

    public function orderConfirmed() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        if ($this->uri->segment(5)) {
            $this->db->set('payment_status', "Completed");
            $this->db->set('timestamp_update', 'NOW()', FALSE);
            $this->db->where("shop_payment_id = '" . $this->uri->segment(5) . "' AND payment_status != 'Completed' AND payment_status != 'Refunded' AND payment_status != 'Canceled'", '');
            $this->db->update('shop_payment');
            $this->db->cache_delete_all();
            $row = $this->Csz_model->load_config();
            $shop_config = $this->Shop_model->load_config();
            $payment = $this->Csz_model->getValue('*', 'shop_payment', "shop_payment_id", $this->uri->segment(5), 1);
            /* Send mail to customer */
            $email_from = 'no-reply@' . EMAIL_DOMAIN;
            $mail_body = $shop_config->payment_body;
            $mail_body.= $payment->order_detail;
            $mail_body.= '<br><a href="' . BASE_URL . '/plugin/shop/success/' . $payment->sha1_hash . '">[Print]</a><br><br>';
            $mail_body.= $shop_config->signature;
            /* Send BCC mail to staff */
            $bcc = '';
            if ($shop_config->seller_email) {
                $bcc = $shop_config->seller_email;
            }
            @$this->Csz_model->sendEmail($payment->email, $shop_config->payment_subject, $mail_body, $email_from, $row->site_name, $bcc);
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        }
        redirect($this->csz_referrer->getIndex('shop'), 'refresh');
    }

    public function orderPending() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        if ($this->uri->segment(5)) {
            $this->db->set('payment_status', "Pending");
            $this->db->set('timestamp_update', 'NOW()', FALSE);
            $this->db->where("shop_payment_id = '" . $this->uri->segment(5) . "' AND payment_status != 'Pending' AND payment_status != 'Refunded' AND payment_status != 'Canceled'", '');
            $this->db->update('shop_payment');
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        }
        redirect($this->csz_referrer->getIndex('shop'), 'refresh');
    }

    public function orderRefunded() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        if ($this->uri->segment(5)) {
            $this->db->set('payment_status', "Refunded");
            $this->db->set('timestamp_update', 'NOW()', FALSE);
            $this->db->where("shop_payment_id = '" . $this->uri->segment(5) . "' AND payment_status = 'Completed'", '');
            $this->db->update('shop_payment');
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        }
        redirect($this->csz_referrer->getIndex('shop'), 'refresh');
    }

    public function orderCanceled() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        if ($this->uri->segment(5)) {
            $this->db->set('payment_status', "Canceled");
            $this->db->set('timestamp_update', 'NOW()', FALSE);
            $this->db->where("shop_payment_id = '" . $this->uri->segment(5) . "' AND payment_status != 'Completed' AND payment_status != 'Refunded' AND payment_status != 'Canceled'", '');
            $this->db->update('shop_payment');
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        }
        redirect($this->csz_referrer->getIndex('shop'), 'refresh');
    }

    public function shippingCreate() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        if ($this->uri->segment(5)) {
            $payment = $this->Csz_model->getValue('*', 'shop_payment', "inv_id = '" . $this->uri->segment(5) . "' AND payment_status = 'Completed'", '', 1);
            if ($payment !== FALSE) {
                //Load the form helper
                $this->load->helper('form');
                $this->template->setSub('payment', $payment);
                //Load the view
                $this->template->loadSub('admin/plugin/shop/shipping_add');
            } else {
                redirect($this->csz_referrer->getIndex('shop'), 'refresh');
            }
        } else {
            redirect($this->csz_referrer->getIndex('shop'), 'refresh');
        }
    }

    public function createShippingSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('shipping_name', 'Shipping Name', 'required');
        $this->form_validation->set_rules('shipping_id', 'Shipping ID', 'required');
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->createShipping();
        } else {
            //Validation passed
            //Add the user
            $this->Shop_model->shippingInsert();
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
            redirect(BASE_URL . '/admin/plugin/shop/shipping', 'refresh');
        }
    }

    public function shipping() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        $this->csz_referrer->setIndex('shop'); /* Set index page when redirect after save */
        $search_arr = ' 1 = 1 ';
        if ($this->input->get('search')) {
            if ($this->input->get('search')) {
                $search_arr.= " AND inv_id LIKE '%" . $this->input->get('search', TRUE) . "%' OR shipping_name LIKE '%" . $this->input->get('search', TRUE) . "%' OR shipping_id LIKE '%" . $this->input->get('search', TRUE) . "%' OR note LIKE '%" . $this->input->get('search', TRUE) . "%'";
            }
        }
        $this->load->helper('form');
        $this->load->library('pagination');
        // Pages variable
        $result_per_page = 20;
        $total_row = $this->Csz_model->countData('shop_shipping', $search_arr);
        $num_link = 10;
        $base_url = BASE_URL . '/admin/plugin/shop/shipping/';

        // Pageination config
        $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 5);
        ($this->uri->segment(5)) ? $pagination = $this->uri->segment(5) : $pagination = 0;

        //Get users from database
        $this->template->setSub('shipping', $this->Csz_admin_model->getIndexData('shop_shipping', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
        $this->template->setSub('total_row', $total_row);

        //Load the view
        $this->template->loadSub('admin/plugin/shop/shipping_index');
    }

    public function shippingEdit() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');
        if ($this->uri->segment(5)) {
            $shipping = $this->Csz_model->getValue('*', 'shop_shipping', 'shop_shipping_id', $this->uri->segment(5), 1);
            $payment = $this->Csz_model->getValue('order_detail', 'shop_payment', "inv_id = '" . $shipping->inv_id . "' AND payment_status = 'Completed'", '', 1);
            $this->template->setSub('shipping', $shipping);
            $this->template->setSub('payment', $payment);

            //Load the view
            $this->template->loadSub('admin/plugin/shop/shipping_edit');
        } else {
            redirect($this->csz_referrer->getIndex('shop'), 'refresh');
        }
    }

    public function editShippingSave() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        if ($this->uri->segment(5)) {
            //Load the form validation library
            $this->load->library('form_validation');
            //Set validation rules
            $this->form_validation->set_rules('shipping_name', 'Shipping Name', 'required');
            $this->form_validation->set_rules('shipping_id', 'Shipping ID', 'required');
            if ($this->form_validation->run() == FALSE) {
                //Validation failed
                $this->shippingEdit();
            } else {
                //Validation passed
                //Add the user
                $this->Shop_model->shippingUpdate($this->uri->segment(5));
                $this->db->cache_delete_all();
                $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
                redirect($this->csz_referrer->getIndex('shop'), 'refresh');
            }
        } else {
            redirect($this->csz_referrer->getIndex('shop'), 'refresh');
        }
    }

    public function shippingDel() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::chkVisitor($this->session->userdata('user_admin_id'));
        if ($this->uri->segment(5)) {
            $this->db->set('shipping', '0');
            $this->db->set('timestamp_update', 'NOW()', FALSE);
            $this->db->where("inv_id = '" . $this->uri->segment(6) . "' AND payment_status = 'Completed'", '');
            $this->db->update('shop_payment');
            $this->Shop_model->delete($this->uri->segment(5), 'shop_shipping');
            $this->db->cache_delete_all();
            $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        }
        redirect($this->csz_referrer->getIndex('shop'), 'refresh');
    }

}