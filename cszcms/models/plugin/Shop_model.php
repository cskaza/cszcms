<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function htmlTinyMCE($text_area) {
        $content1 = str_replace('&lt;', '<', $text_area);
        $content = str_replace('&gt;', '>', $content1);
        return $content;
    }

    public function configSave() {
        // Save Config
        ($this->input->post('paypal_active')) ? $paypal_active = $this->input->post('paypal_active', TRUE) : $paypal_active = 0;
        ($this->input->post('paysbuy_active')) ? $paysbuy_active = $this->input->post('paysbuy_active', TRUE) : $paysbuy_active = 0;
        ($this->input->post('stat_new_show')) ? $stat_new_show = $this->input->post('stat_new_show', TRUE) : $stat_new_show = 0;
        ($this->input->post('stat_hot_show')) ? $stat_hot_show = $this->input->post('stat_hot_show', TRUE) : $stat_hot_show = 0;
        ($this->input->post('stat_bestseller_show')) ? $stat_bestseller_show = $this->input->post('stat_bestseller_show', TRUE) : $stat_bestseller_show = 0;
        ($this->input->post('stat_soldout_show')) ? $stat_soldout_show = $this->input->post('stat_soldout_show', TRUE) : $stat_soldout_show = 0;
        ($this->input->post('sanbox_active')) ? $sanbox_active = $this->input->post('sanbox_active', TRUE) : $sanbox_active = 0;
        ($this->input->post('ipn_log_active')) ? $ipn_log_active = $this->input->post('ipn_log_active', TRUE) : $ipn_log_active = 0;
        $this->db->set('stat_new_show', $stat_new_show);
        $this->db->set('stat_hot_show', $stat_hot_show);
        $this->db->set('stat_bestseller_show', $stat_bestseller_show);
        $this->db->set('stat_soldout_show', $stat_soldout_show);
        $this->db->set('paypal_active', $paypal_active);
        $this->db->set('sanbox_active', $sanbox_active);
        $this->db->set('paypal_email', $this->input->post('paypal_email', TRUE));
        $this->db->set('paysbuy_active', $paysbuy_active);
        $this->db->set('paysbuy_email', $this->input->post('paysbuy_email', TRUE));
        $this->db->set('bank_detail', $this->htmlTinyMCE($this->input->post('bank_detail', FALSE)));
        $this->db->set('currency_code', $this->input->post('currency_code', TRUE));
        $this->db->set('seller_email', $this->input->post('seller_email', TRUE));
        $this->db->set('order_subject', $this->input->post('order_subject', TRUE));
        $this->db->set('order_body', $this->htmlTinyMCE($this->input->post('order_body', FALSE)));
        $this->db->set('payment_subject', $this->input->post('payment_subject', TRUE));
        $this->db->set('payment_body', $this->htmlTinyMCE($this->input->post('payment_body', FALSE)));
        $this->db->set('signature', $this->htmlTinyMCE($this->input->post('signature', FALSE)));
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->where("shop_config_id", 1);
        $this->db->update('shop_config');
    }

    public function catInsert() {
        // Create the new lang
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        $url_rewrite = $this->Csz_model->rw_link($this->input->post('name', TRUE));
        $this->db->set('shop_category_main_id', $this->input->post('shop_category_main_id', TRUE));
        $this->db->set('name', $this->input->post('name', TRUE));
        $this->db->set('url_rewrite', $url_rewrite);
        $this->db->set('keyword', $this->input->post('keyword', TRUE));
        $this->db->set('short_desc', $this->input->post('short_desc', TRUE));
        $this->db->set('active', $active);
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->insert('shop_category');
    }

    public function catUpdate($id) {
        // Create the new lang
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        $url_rewrite = $this->Csz_model->rw_link($this->input->post('name', TRUE));
        $this->db->set('shop_category_main_id', $this->input->post('shop_category_main_id', TRUE));
        $this->db->set('name', $this->input->post('name', TRUE));
        $this->db->set('url_rewrite', $url_rewrite);
        $this->db->set('keyword', $this->input->post('keyword', TRUE));
        $this->db->set('short_desc', $this->input->post('short_desc', TRUE));
        $this->db->set('active', $active);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->where("shop_category_id", $id);
        $this->db->update('shop_category');
    }

    public function productInsert() {
        // Create the new lang
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        $url_rewrite = $this->Csz_model->rw_link($this->input->post('product_name', TRUE));
        $this->db->set('product_name', $this->input->post('product_name', TRUE));
        $this->db->set('url_rewrite', $url_rewrite);
        $this->db->set('shop_category_id', $this->input->post('shop_category_id', TRUE));
        $this->db->set('keyword', $this->input->post('keyword', TRUE));
        $this->db->set('short_desc', $this->input->post('short_desc', TRUE));
        $this->db->set('full_desc', $this->input->post('full_desc', FALSE));
        $this->db->set('price', $this->input->post('price', TRUE));
        $this->db->set('discount', $this->input->post('discount', TRUE));
        $this->db->set('stock', $this->input->post('stock', TRUE));
        $this->db->set('product_code', $this->input->post('product_code', TRUE));
        $this->db->set('product_status', $this->input->post('product_status', TRUE));
        $this->db->set('active', $active);
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->insert('shop_product');
    }

    public function productUpdate($id) {
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        $url_rewrite = $this->Csz_model->rw_link($this->input->post('product_name', TRUE));
        $this->db->set('product_name', $this->input->post('product_name', TRUE));
        $this->db->set('url_rewrite', $url_rewrite);
        $this->db->set('shop_category_id', $this->input->post('shop_category_id', TRUE));
        $this->db->set('keyword', $this->input->post('keyword', TRUE));
        $this->db->set('short_desc', $this->input->post('short_desc', TRUE));
        $this->db->set('full_desc', $this->input->post('full_desc', FALSE));
        $this->db->set('price', $this->input->post('price', TRUE));
        $this->db->set('discount', $this->input->post('discount', TRUE));
        $this->db->set('stock', $this->input->post('stock', TRUE));
        $this->db->set('product_code', $this->input->post('product_code', TRUE));
        $this->db->set('product_status', $this->input->post('product_status', TRUE));
        $this->db->set('active', $active);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->where('shop_product_id', $id);
        $this->db->update('shop_product');
        /* Rename Field */
        $shop_product_option_id = $this->input->post('shop_product_option_id', TRUE);
        $field_name1 = $this->input->post('field_name1', TRUE);
        $field_oldname = $this->input->post('field_oldname', TRUE);
        $field_type1 = $this->input->post('field_type1', TRUE);
        $field_placeholder1 = $this->input->post('field_placeholder1', TRUE);
        $field_value1 = $this->input->post('field_value1', TRUE);
        $field_label1 = $this->input->post('field_label1', TRUE);
        $field_sel_value1 = $this->input->post('field_sel_value1', TRUE);
        if (count($field_oldname) > 0) {
            for ($i = 0; $i < count($field_oldname); $i++) {
                if ($field_oldname[$i]) {
                    $data = array(
                        'shop_product_id' => $id,
                        'field_type' => $field_type1[$i],
                        'field_name' => $field_name1[$i],
                        'field_placeholder' => $field_placeholder1[$i],
                        'field_value' => $field_value1[$i],
                        'field_label' => $field_label1[$i],
                        'field_sel_value' => $field_sel_value1[$i],
                    );
                    $this->db->set('timestamp_update', 'NOW()', FALSE);
                    $this->db->where('shop_product_option_id', $shop_product_option_id[$i]);
                    $this->db->update('shop_product_option', $data);
                }
            }
        }

        /* Add New Field */
        $field_name = $this->input->post('field_name', TRUE);
        $field_type = $this->input->post('field_type', TRUE);
        $field_placeholder = $this->input->post('field_placeholder', TRUE);
        $field_value = $this->input->post('field_value', TRUE);
        $field_label = $this->input->post('field_label', TRUE);
        $field_sel_value = $this->input->post('field_sel_value', TRUE);
        if (count($field_name) > 0) {
            for ($i = 0; $i < count($field_name); $i++) {
                if ($field_name[$i] && $field_label[$i]) {
                    $data = array(
                        'shop_product_id' => $id,
                        'field_type' => $field_type[$i],
                        'field_name' => $field_name[$i],
                        'field_placeholder' => $field_placeholder[$i],
                        'field_value' => $field_value[$i],
                        'field_label' => $field_label[$i],
                        'field_sel_value' => $field_sel_value[$i],
                    );
                    $this->db->set('timestamp_create', 'NOW()', FALSE);
                    $this->db->set('timestamp_update', 'NOW()', FALSE);
                    $this->db->insert('shop_product_option', $data);
                }
            }
        }
        $this->Csz_model->clear_all_cache();
    }

    public function delete($id, $table) {
        if ($id && $table) {
            $this->Csz_admin_model->removeData($table, $table . '_id', $id);
        } else {
            return FALSE;
        }
    }

    private function AdminMenuActive($menu_page, $cur_page, $addeditdel = '') {
        /* $addeditdel = 'cat'; //Example: catNew, catEdit, catDel etc. */
        if ($menu_page == $cur_page || ($addeditdel != '' && strpos($cur_page, $addeditdel) !== false)) {
            $active = ' class="active"';
        } else {
            $active = "";
        }
        return $active;
    }

    public function AdminMenu() {
        $cur_page = $this->uri->segment(4);
        $html = '<nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="' . BASE_URL . '/admin/plugin/shop">' . $this->lang->line('shop_menu') . '</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li' . $this->AdminMenuActive('config', $cur_page) . '><a href="' . BASE_URL . '/admin/plugin/shop/config">' . $this->lang->line('shop_config') . '</a></li>
                        <li' . $this->AdminMenuActive('category', $cur_page, 'cat') . '><a href="' . BASE_URL . '/admin/plugin/shop/category">' . $this->lang->line('shop_product_category') . '</a></li>
                        <li' . $this->AdminMenuActive('products', $cur_page, 'product') . '><a href="' . BASE_URL . '/admin/plugin/shop/products">' . $this->lang->line('shop_products') . '</a></li>
                        <li' . $this->AdminMenuActive('order', $cur_page) . '><a href="' . BASE_URL . '/admin/plugin/shop/order">' . $this->lang->line('shop_order') . '</a></li>
                        <li' . $this->AdminMenuActive('shipping', $cur_page, 'shipping') . '><a href="' . BASE_URL . '/admin/plugin/shop/shipping">' . $this->lang->line('shop_shipping_header') . '</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>';
        return $html;
    }

    public function currencyCode() {
        $code = array(
            'USD' => 'US Dollar',
            'THB' => 'Thai Baht',
            'AUD' => 'Australian Dollar',
            'BTC' => 'Bitcoin',
            'GBP' => 'British Pound',
            'CAD' => 'Canadian Dollar',
            'CNY' => 'Chinese Yuan',
            'EUR' => 'Euro',
            'HKD' => 'Hong Kong Dollar',
            'INR' => 'Indian Rupee',
            'IDR' => 'Indonesian Rupiah',
            'JPY' => 'Japanese Yen',
            'MYR' => 'Malaysian Ringgit',
            'NZD' => 'New Zealand Dollar',
            'PHP' => 'Philippine Peso',
            'RUB' => 'Russian Ruble',
            'SGD' => 'Singapore Dollar',
            'KRW' => 'South Korean Won',
            'AED' => 'United Arab Emirates Dirham',
            'VND' => 'Vietnamese Dong',
                /* You can add more if you want. */
        );
        return $code;
    }

    public function productStatus() {
        $status = array(
            'new' => $this->lang->line('shop_stat_new'),
            'hot' => $this->lang->line('shop_stat_hot'),
            'bestseller' => $this->lang->line('shop_stat_bestseller'),
        );
        return $status;
    }

    public function insertFileUpload($shop_product_id, $fileupload = '') {
        $img_rs = $this->Csz_model->getValue('arrange', 'shop_product_imgs', "shop_product_id", $shop_product_id, 1, 'arrange', 'desc');
        if (!empty($img_rs)) {
            $arrange = $img_rs->arrange;
        } else {
            $arrange = 0;
        }
        $data = array(
            'shop_product_id' => $shop_product_id,
            'arrange' => ($arrange) + 1,
        );
        if ($fileupload) {
            $this->db->set('file_upload', $fileupload, TRUE);
        }
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->insert('shop_product_imgs', $data);
    }

    public function getFirstImgs($shop_product_id) {
        $no_img = BASE_URL . '/photo/no_image.png';
        if ($shop_product_id) {
            $img_rs = $this->Csz_model->getValue('file_upload', 'shop_product_imgs', "shop_product_id", $shop_product_id, 1, 'arrange', 'asc');
            if (!empty($img_rs)) {
                if ($img_rs->file_upload) {
                    return BASE_URL . '/photo/plugin/shop/' . $img_rs->file_upload;
                } else {
                    return $no_img;
                }
            } else {
                return $no_img;
            }
        } else {
            return $no_img;
        }
    }

    public function load_config() {
        $this->db->limit(1, 0);
        $query = $this->db->get('shop_config');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row;
        } else {
            return FALSE;
        }
    }

    public function getMainCatName($id) {
        if ($id) {
            $this->db->select('name');
            $this->db->where('shop_category_id', $id);
            $this->db->limit(1, 0);
            $query = $this->db->get('shop_category');
            if ($query->num_rows() > 0) {
                $row = $query->row();
                return $row->name;
            } else {
                return '-';
            }
        } else {
            return '-';
        }
    }

    public function rightCatMenu() {
        $this->load->library('cart');
        $maincat = $this->Csz_model->getValueArray('*', 'shop_category', "active = '1' AND shop_category_main_id = '0'", '', 0, 'name', 'ASC');
        $html = '<div class="panel panel-default">
                <div class="panel-heading">
                    <a href="' . BASE_URL . '/plugin/shop/cartView" style="text-decoration:none;"><div style="width:100%;"><b><span class="glyphicon glyphicon-shopping-cart"></span> &nbsp; ' . $this->Csz_model->getLabelLang('shop_cart_text') . ' &nbsp; <span class="badge" id="cart-count">' . $this->cart->total_items() . '</span></b></div></a>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-body">
                    <form action="' . BASE_URL . '/plugin/shop/search" name="searchfrm" id="searchfrm" method="get" style="margin:0px; padding:0px;">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-search"></i></span>
                        <input type="text" class="form-control" placeholder="' . $this->Csz_model->getLabelLang('shop_product_search_txt') . '" name="p" value="'.$this->input->get('p' ,TRUE).'">
                    </div>
                    </form>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-menu-hamburger"></i> ' . $this->Csz_model->getLabelLang('shop_product_category') . '</b></div>
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">';
        $html.= '<li role="presentation" class="text-left"><a href="' . BASE_URL . '/plugin/shop"><b><i class="glyphicon glyphicon-home"></i> ' . $this->Csz_model->getLabelLang('shop_home_txt') . '</b></a></li>';
        if ($maincat === FALSE) {
            $html.= '<li role="presentation" class="text-left"><a><b>' . $this->Csz_model->getLabelLang('shop_notfound') . '</b></a></li>';
        } else {
            foreach ($maincat as $mc) {
                $html.= '<li role="presentation" class="text-left"><a href="' . BASE_URL . '/plugin/shop/category/' . $mc['url_rewrite'] . '"><b><i class="glyphicon glyphicon-triangle-right"></i> ' . $mc['name'] . '</b></a></li>';
                $subcat = $this->Csz_model->getValueArray('*', 'shop_category', "active = '1' AND shop_category_main_id = '" . $mc['shop_category_id'] . "'", '', 0, 'name', 'ASC');
                if (!empty($subcat)) {
                    foreach ($subcat as $sc) {
                        $html.= '<li role="presentation" class="text-left" style="padding-left:30px;"><a href="' . BASE_URL . '/plugin/shop/category/' . $sc['url_rewrite'] . '">' . $sc['name'] . '</a></li>';
                    }
                }
            }
        }
        $html.= '</ul>
                </div>
            </div>';
        return $html;
    }

    public function paymentInsert($sha1_hash, $inv_id, $email, $name, $phone, $address, $payment_methods, $price_total, $order_detail) {
        $this->db->set('sha1_hash', $sha1_hash);
        $this->db->set('inv_id', $inv_id);
        $this->db->set('email', $email);
        $this->db->set('name', $name);
        $this->db->set('phone', $phone);
        $this->db->set('address', $address);
        $this->db->set('payment_methods', $payment_methods);
        $this->db->set('price_total', $price_total);
        $this->db->set('order_detail', $order_detail);
        $this->db->set('user_agent', $this->input->user_agent());
        $this->db->set('ip_address', $this->input->ip_address());
        $this->db->set('payment_status', 'Pending');
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->insert('shop_payment');
    }

    public function chkStock($product_id, $stock_use, $cart_row_id) {
        $getStock = 0;
        $this->db->select('stock');
        $this->db->where('shop_product_id', $product_id);
        $this->db->limit(1, 0);
        $query = $this->db->get('shop_product');
        if (!empty($query) && $query->num_rows() > 0) {
            $row = $query->row();
            $getStock = $row->stock;
            $moreStock = $getStock - $stock_use;
            if($getStock != 0 && $moreStock >= 0){
                return TRUE;
            }else{
                $this->cart->remove($cart_row_id);
                return FALSE;
            }
        }else{
            $this->cart->remove($cart_row_id);
            return FALSE;
        }
    }
    
    public function updateStock($product_id = array(), $stock_use = array(), $cancel = FALSE) {
        if(is_array($product_id) && is_array($stock_use)){
            for ($i = 0; $i < count($product_id); $i++) {
                $getStock = 0;
                $this->db->select('stock');
                $this->db->where('shop_product_id', $product_id[$i]);
                $this->db->limit(1, 0);
                $query = $this->db->get('shop_product');
                if (!empty($query) && $query->num_rows() > 0) {
                    $row = $query->row();
                    $getStock = $row->stock;
                    if($cancel === FALSE){
                        $moreStock = $getStock - $stock_use[$i];
                    }else{
                        $moreStock = $getStock + $stock_use[$i];
                    }
                    if($getStock != 0 && $moreStock >= 0){
                        $this->db->set('stock', $moreStock);
                        $this->db->set('timestamp_update', 'NOW()', FALSE);
                        $this->db->where('shop_product_id', $product_id[$i]);
                        $this->db->update('shop_product');
                    }
                }else{
                    return FALSE;
                }
            }
        }else{
            return FALSE;
        }
    }
    
    public function shippingInsert() {
        // Create the new lang
        $this->db->set('inv_id', $this->input->post('inv_id', TRUE));
        $this->db->set('shipping_name', $this->input->post('shipping_name', TRUE));
        $this->db->set('shipping_id', $this->input->post('shipping_id', TRUE));
        $this->db->set('note', $this->input->post('note', TRUE));
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->insert('shop_shipping');
        $this->db->set('shipping', '1');
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->where("inv_id = '".$this->input->post('inv_id', TRUE)."' AND payment_status = 'Completed'", '');
        $this->db->update('shop_payment');
    }
    
    public function shippingUpdate($id) {
        // Create the new lang
        $this->db->set('shipping_name', $this->input->post('shipping_name', TRUE));
        $this->db->set('shipping_id', $this->input->post('shipping_id', TRUE));
        $this->db->set('note', $this->input->post('note', TRUE));
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->where("shop_shipping_id", $id);
        $this->db->update('shop_shipping');
    }

}
