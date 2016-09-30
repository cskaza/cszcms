<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {

    /**
      Shop Plugin by CSKAZA
     */
    var $page_url;

    function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
        $this->load->database();
        $this->load->library('cart');
        $row = $this->Csz_model->load_config();
        $this->load->model('plugin/Shop_model');
        if ($row->themes_config) {
            $this->template->set_template($row->themes_config);
            define('THEME', $row->themes_config);
        }
        if (!$this->session->userdata('fronlang_iso')) {
            $this->Csz_model->setSiteLang();
        }
        if ($this->Csz_model->chkLangAlive($this->session->userdata('fronlang_iso')) == 0) {
            $this->session->unset_userdata('fronlang_iso');
            $this->Csz_model->setSiteLang();
        }
        if ($row->pagecache_time != 0) {
            $this->db->cache_on();
        }
        $this->_init();
        member_helper::plugin_not_active($this->uri->segment(2));
    }

    public function _init() {
        $this->template->set('core_css', $this->Csz_model->coreCss('assets/css/ekko-lightbox.min.css'));
        $js_arr = array(BASE_URL . '/assets/js/ekko-lightbox.min.js', BASE_URL . '/assets/js/ekko-lightbox.run.js');
        $this->template->set('core_js', $this->Csz_model->coreJs($js_arr));
        $row = $this->Csz_model->load_config();
        $this->page_url = $this->Csz_model->getCurPages();
        $this->template->set('additional_js', $row->additional_js);
        $this->template->set('additional_metatag', $row->additional_metatag);
    }

    public function index() {
        $this->csz_referrer->setIndex('front_shop');
        $row = $this->Csz_model->load_config();
        $shop_config = $this->Shop_model->load_config();
        $title = 'Shopping online | ' . $row->site_name;
        $this->template->set('title', $title);
        $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
        $this->template->set('cur_page', $this->page_url);

        //Get users from database
        $this->template->setSub('shop_config', $shop_config);
        $this->template->setSub('new_product', $this->Csz_model->getValueArray('*', 'shop_product', "active = 1 AND product_status = 'new'", '', 6));
        $this->template->setSub('hot_product', $this->Csz_model->getValueArray('*', 'shop_product', "active = 1 AND product_status = 'hot'", '', 6));
        $this->template->setSub('best_product', $this->Csz_model->getValueArray('*', 'shop_product', "active = 1 AND product_status = 'bestseller'", '', 6));
        $this->template->setSub('sold_product', $this->Csz_model->getValueArray('*', 'shop_product', "active = '1' AND stock = '0'", '', 6));

        //Load the view
        $this->template->loadSub('frontpage/plugin/shop/shop_index');
    }

    public function hotProduct() {
        $row = $this->Csz_model->load_config();
        $shop_config = $this->Shop_model->load_config();
        if ($shop_config->stat_hot_show) {
            $title = 'Shopping online hot products | ' . $row->site_name;
            $this->template->set('title', $title);
            $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
            $this->template->set('cur_page', $this->page_url);

            $search_arr = " active = '1' AND product_status = 'hot'";
            $this->load->helper('form');
            $this->load->library('pagination');
            // Pages variable
            $result_per_page = 15;
            $total_row = $this->Csz_model->countData('shop_product', $search_arr);
            $num_link = 10;
            $base_url = BASE_URL . '/plugin/shop/hotProduct/';

            // Pageination config
            $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 4);
            ($this->uri->segment(4)) ? $pagination = $this->uri->segment(4) : $pagination = 0;

            //Get users from database
            $this->template->setSub('shop_config', $shop_config);
            $this->template->setSub('hot_product', $this->Csz_admin_model->getIndexData('shop_product', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
            $this->template->setSub('total_row', $total_row);

            //Load the view
            $this->template->loadSub('frontpage/plugin/shop/shop_hot');
        } else {
            redirect(BASE_URL . '/plugin/shop');
        }
    }

    public function bestSeller() {
        $row = $this->Csz_model->load_config();
        $shop_config = $this->Shop_model->load_config();
        if ($shop_config->stat_bestseller_show) {
            $title = 'Shopping online best seller | ' . $row->site_name;
            $this->template->set('title', $title);
            $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
            $this->template->set('cur_page', $this->page_url);

            $search_arr = " active = '1' AND product_status = 'bestseller'";
            $this->load->helper('form');
            $this->load->library('pagination');
            // Pages variable
            $result_per_page = 15;
            $total_row = $this->Csz_model->countData('shop_product', $search_arr);
            $num_link = 10;
            $base_url = BASE_URL . '/plugin/shop/bestSeller/';

            // Pageination config
            $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 4);
            ($this->uri->segment(4)) ? $pagination = $this->uri->segment(4) : $pagination = 0;

            //Get users from database
            $this->template->setSub('shop_config', $shop_config);
            $this->template->setSub('best_product', $this->Csz_admin_model->getIndexData('shop_product', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
            $this->template->setSub('total_row', $total_row);

            //Load the view
            $this->template->loadSub('frontpage/plugin/shop/shop_best');
        } else {
            redirect(BASE_URL . '/plugin/shop');
        }
    }

    public function newProduct() {
        $row = $this->Csz_model->load_config();
        $shop_config = $this->Shop_model->load_config();
        if ($shop_config->stat_new_show) {
            $title = 'Shopping online new product | ' . $row->site_name;
            $this->template->set('title', $title);
            $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
            $this->template->set('cur_page', $this->page_url);

            $search_arr = " active = '1' AND product_status = 'new'";
            $this->load->helper('form');
            $this->load->library('pagination');
            // Pages variable
            $result_per_page = 15;
            $total_row = $this->Csz_model->countData('shop_product', $search_arr);
            $num_link = 10;
            $base_url = BASE_URL . '/plugin/shop/newProduct/';

            // Pageination config
            $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 4);
            ($this->uri->segment(4)) ? $pagination = $this->uri->segment(4) : $pagination = 0;

            //Get users from database
            $this->template->setSub('shop_config', $shop_config);
            $this->template->setSub('new_product', $this->Csz_admin_model->getIndexData('shop_product', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
            $this->template->setSub('total_row', $total_row);

            //Load the view
            $this->template->loadSub('frontpage/plugin/shop/shop_new');
        } else {
            redirect(BASE_URL . '/plugin/shop');
        }
    }

    public function soldOut() {
        $row = $this->Csz_model->load_config();
        $shop_config = $this->Shop_model->load_config();
        if ($shop_config->stat_soldout_show) {
            $title = 'Shopping online product soldout | ' . $row->site_name;
            $this->template->set('title', $title);
            $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
            $this->template->set('cur_page', $this->page_url);

            $search_arr = " active = '1' AND stock = '0'";
            $this->load->helper('form');
            $this->load->library('pagination');
            // Pages variable
            $result_per_page = 15;
            $total_row = $this->Csz_model->countData('shop_product', $search_arr);
            $num_link = 10;
            $base_url = BASE_URL . '/plugin/shop/soldOut/';

            // Pageination config
            $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 4);
            ($this->uri->segment(4)) ? $pagination = $this->uri->segment(4) : $pagination = 0;

            //Get users from database
            $this->template->setSub('shop_config', $shop_config);
            $this->template->setSub('soldout_product', $this->Csz_admin_model->getIndexData('shop_product', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
            $this->template->setSub('total_row', $total_row);

            //Load the view
            $this->template->loadSub('frontpage/plugin/shop/shop_soldout');
        } else {
            redirect(BASE_URL . '/plugin/shop');
        }
    }

    public function category() {
        if ($this->uri->segment(4)) {
            $cat_row = $this->Csz_model->getValue('*', 'shop_category', "active = '1' AND url_rewrite = '" . $this->uri->segment(4) . "'", '', 1);
            if ($cat_row !== FALSE) {
                $row = $this->Csz_model->load_config();
                $shop_config = $this->Shop_model->load_config();
                $title = 'Shopping online product category | ' . $row->site_name;
                $this->template->set('title', $title);
                $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
                $this->template->set('cur_page', $this->page_url);
                $search_arr = " active = '1' AND shop_category_id = '" . $cat_row->shop_category_id . "'";
                $this->load->helper('form');
                $this->load->library('pagination');
                // Pages variable
                $result_per_page = 15;
                $total_row = $this->Csz_model->countData('shop_product', $search_arr);
                $num_link = 10;
                $base_url = BASE_URL . '/plugin/shop/category/' . $this->uri->segment(4) . '/';

                // Pageination config
                $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 5);
                ($this->uri->segment(5)) ? $pagination = $this->uri->segment(5) : $pagination = 0;

                //Get users from database
                $this->template->setSub('shop_config', $shop_config);
                $this->template->setSub('product', $this->Csz_admin_model->getIndexData('shop_product', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
                $this->template->setSub('total_row', $total_row);
                $this->template->setSub('category_name', $cat_row->name);

                //Load the view
                $this->template->loadSub('frontpage/plugin/shop/shop_category');
            } else {
                redirect(BASE_URL . '/plugin/shop', 'refresh');
            }
        } else {
            redirect(BASE_URL . '/plugin/shop', 'refresh');
        }
    }

    public function view() {
        if ($this->uri->segment(4) && $this->uri->segment(5)) {
            $art_row = $this->Csz_model->getValue('*', 'shop_product', "active = '1' AND shop_product_id = '" . $this->uri->segment(4) . "' AND url_rewrite = '" . $this->uri->segment(5) . "'", '', 1);
            if ($art_row !== FALSE) {
                $row = $this->Csz_model->load_config();
                $shop_config = $this->Shop_model->load_config();
                $this->load->helper('form');
                $this->output->cache($row->pagecache_time);
                $title = $art_row->product_name . ' | ' . $row->site_name;
                $this->template->set('title', $title);
                $this->template->set('meta_tags', $this->Csz_model->coreMetatags($art_row->short_desc, $art_row->keyword, $title));
                $this->template->set('cur_page', $this->page_url);

                //Get users from database
                $this->template->setSub('shop_config', $shop_config);
                $this->template->setSub('product', $art_row);
                $cat_row = $this->Csz_model->getValue('name', 'shop_category', "active = '1' AND shop_category_id = '" . $art_row->shop_category_id . "'", '', 1);
                $this->template->setSub('category_name', $cat_row->name);
                $this->template->setSub('image', $this->Csz_model->getValueArray('*', 'shop_product_imgs', "shop_product_id", $art_row->shop_product_id, 0, 'arrange', 'asc'));
                $this->template->setSub('form_option', $this->Csz_model->getValueArray('*', 'shop_product_option', "shop_product_id", $art_row->shop_product_id, 0, 'shop_product_option_id', 'asc'));

                //Load the view
                $this->template->loadSub('frontpage/plugin/shop/shop_view');
            } else {
                redirect(BASE_URL . '/plugin/shop', 'refresh');
            }
        } else {
            redirect(BASE_URL . '/plugin/shop', 'refresh');
        }
    }

    public function search() {
        if ($this->input->get('p', TRUE)) {
            $row = $this->Csz_model->load_config();
            $shop_config = $this->Shop_model->load_config();
            $title = 'Shopping online products search | ' . $row->site_name;
            $this->template->set('title', $title);
            $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
            $this->template->set('cur_page', $this->page_url);
            $search_arr = " active = '1' AND (product_name LIKE '%" . $this->input->get('p', TRUE) . "%' OR keyword LIKE '%" . $this->input->get('p', TRUE) . "%' OR product_code LIKE '%" . $this->input->get('p', TRUE) . "%')";
            $this->load->library('pagination');
            // Pages variable
            $result_per_page = 15;
            $total_row = $this->Csz_model->countData('shop_product', $search_arr);
            $num_link = 10;
            $base_url = BASE_URL . '/plugin/shop/search/';

            // Pageination config
            $this->Csz_admin_model->pageSetting($base_url, $total_row, $result_per_page, $num_link, 4);
            ($this->uri->segment(4)) ? $pagination = $this->uri->segment(4) : $pagination = 0;

            //Get users from database
            $this->template->setSub('shop_config', $shop_config);
            $this->template->setSub('product', $this->Csz_admin_model->getIndexData('shop_product', $result_per_page, $pagination, 'timestamp_create', 'desc', $search_arr));
            $this->template->setSub('total_row', $total_row);

            //Load the view
            $this->template->loadSub('frontpage/plugin/shop/shop_search');
        } else {
            redirect(BASE_URL . '/plugin/shop', 'refresh');
        }
    }

    public function addCart() {
        if ($this->uri->segment(4)) {
            $product = $this->Csz_model->getValue('*', 'shop_product', "active = '1' AND shop_product_id = '" . $this->uri->segment(4) . "'", '', 1);
            if ($product !== FALSE) {
                $insert_data = array(
                    'id' => ($product->product_code) ? $product->product_code : $product->shop_product_id,
                    'shop_product_id' => $product->shop_product_id,
                    'url_rewrite' => $product->url_rewrite,
                    'name' => $product->product_name,
                    'price' => ($product->price) - ($product->discount),
                    'qty' => $this->input->post('qty', TRUE),
                );
                $option_frm = $this->Csz_model->getValueArray('*', 'shop_product_option', "shop_product_id", $product->shop_product_id, 0, 'shop_product_option_id', 'asc');
                if ($option_frm !== FALSE) {
                    $opt_arr = array();
                    foreach ($option_frm as $value) {
                        if ($value['field_type'] != 'label') {
                            $opt_arr[$value['field_label']] = $this->input->post($value['field_name'], TRUE);
                        }
                    }
                    $insert_data['options'] = $opt_arr;
                }

                /* This function add items into cart. */
                $this->cart->insert($insert_data);
                /* Redirect to cart page */
                redirect(BASE_URL . '/plugin/shop/cartView', 'refresh');
            } else {
                redirect(BASE_URL . '/plugin/shop', 'refresh');
            }
        } else {
            redirect(BASE_URL . '/plugin/shop', 'refresh');
        }
    }

    public function cartView() {
        $this->load->helper('form');
        $row = $this->Csz_model->load_config();
        $shop_config = $this->Shop_model->load_config();
        $title = 'Shopping online cart | ' . $row->site_name;
        $this->template->set('title', $title);
        $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
        $this->template->set('cur_page', $this->page_url);

        //Get users from database
        $this->template->setSub('shop_config', $shop_config);
        $this->template->setSub('cart_check', $this->cart->contents());

        //Load the view
        $this->template->loadSub('frontpage/plugin/shop/shop_cart');
    }

    public function removeCartItem() {
        if ($this->uri->segment(4)) {
            $this->cart->remove($this->uri->segment(4));
            /* Redirect to cart page */
            redirect(BASE_URL . '/plugin/shop/cartView', 'refresh');
        } else {
            redirect(BASE_URL . '/plugin/shop', 'refresh');
        }
    }

    public function clearAllCart() {
        $this->cart->destroy();
        /* Redirect to cart page */
        redirect(BASE_URL . '/plugin/shop/cartView', 'refresh');
    }

    public function placeOrder() {
        $this->load->helper('form');
        $row = $this->Csz_model->load_config();
        $shop_config = $this->Shop_model->load_config();
        $title = 'Shopping online order | ' . $row->site_name;
        $this->template->set('title', $title);
        $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
        $this->template->set('cur_page', $this->page_url);

        //Get users from database
        $this->template->setSub('shop_config', $shop_config);
        $this->template->setSub('cart_check', $this->cart->contents());
        if ($this->session->userdata('user_admin_id')) {
            $this->template->setSub('user', $this->Csz_admin_model->getUser($this->session->userdata('user_admin_id')));
        }

        //Load the view
        $this->template->loadSub('frontpage/plugin/shop/shop_order');
    }

    public function paymentNow() {
        $this->load->helper('form');
        $row = $this->Csz_model->load_config();
        $shop_config = $this->Shop_model->load_config();
        $title = 'Shopping online payment | ' . $row->site_name;
        $this->template->set('title', $title);
        $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
        $this->template->set('cur_page', $this->page_url);
        $lastID = $this->Csz_model->getLastID('shop_payment', 'shop_payment_id');
        $cart_check = $this->cart->contents();
        if (!empty($cart_check) && $this->input->post('email') && $this->input->post('name') && $this->input->post('phone') && $this->input->post('address')) {
            $inv_id = 'INV-' . str_pad($lastID + 1, 11, '0', STR_PAD_LEFT); /* Gen Invoice ID */
            $sha1_hash = sha1($inv_id . '+csz+' . time()); /* Gen SHA1 hash ID */
            $order_detail = '<h3><b>Invoice ID: ' . $inv_id . '</b></h3>';
            $order_detail.= '<p><b>' . $this->Csz_model->getLabelLang('email_address') . ':</b> ' . $this->input->post('email', TRUE) . '<br>';
            $order_detail.= '<b>' . $this->Csz_model->getLabelLang('first_name') . ' - ' . $this->Csz_model->getLabelLang('last_name') . ':</b> ' . $this->input->post('name', TRUE) . '<br>';
            $order_detail.= '<b>' . $this->Csz_model->getLabelLang('phone') . ':</b> ' . $this->input->post('phone', TRUE) . '<br>';
            $order_detail.= '<b>' . $this->Csz_model->getLabelLang('address') . ':</b> ' . $this->input->post('address', TRUE) . '<br>';
            $order_detail.= '<b>' . $this->Csz_model->getLabelLang('shop_payment_methods') . ':</b> ' . $this->input->post('payment_methods', TRUE) . '</p>';
            $order_detail.= '<table border="1" cellspacing="3" cellpadding="3">';
            $order_detail.= '<thead><tr>
            <th width="13%" class="text-center" style="vertical-align:middle;">' . $this->Csz_model->getLabelLang('shop_product_code_txt') . '</th>
            <th width="47%" class="text-center" style="vertical-align:middle;">' . $this->Csz_model->getLabelLang('shop_product_name_txt') . '</th>
            <th width="15%" class="text-center" style="vertical-align:middle;">' . $this->Csz_model->getLabelLang('shop_price_txt') . '<br>(' . $shop_config->currency_code . ')</th>
            <th width="5%" class="text-center" style="vertical-align:middle;">' . $this->Csz_model->getLabelLang('shop_qty_txt') . '</th>
            <th width="20%" class="text-center" style="vertical-align:middle;">' . $this->Csz_model->getLabelLang('shop_amount_txt') . '<br>(' . $shop_config->currency_code . ')</th>
            </tr></thead><tbody>';
            $product_id = array();
            $qty = array();
            foreach ($cart_check as $u) {
                if ($this->Shop_model->chkStock($u['shop_product_id'], $u['qty'], $u['rowid']) === FALSE) {
                    echo "<script>alert('" . $this->Csz_model->getLabelLang('shop_soldout_product') . "');</script>";
                    redirect(BASE_URL . '/plugin/shop/cartView', 'refresh');
                    exit();
                }
                $product_id[] = $u['shop_product_id'];
                $qty[] = $u['qty'];
                $order_detail.= '<tr>';
                $order_detail.= '<td class="text-center" style="vertical-align:middle;">' . $u['id'] . '</td>';
                $order_detail.= '<td style="vertical-align:middle;">';
                $order_detail.= '<b>' . $u['name'] . '</b><br>';
                $opt_product = $this->cart->product_options($u['rowid']);
                if (!empty($opt_product)) {
                    $opt_arr = array();
                    $order_detail.= '<span style="color:red;font-size:10px;"><em>';
                    foreach ($opt_product as $key => $opt) {
                        $opt_arr[] = $key . '=' . $opt;
                    }
                    $opt_show = implode(', ', $opt_arr);
                    $order_detail.= $opt_show . '</em></span>';
                }
                $order_detail.= '</td>';
                $order_detail.= '<td class="text-center" style="vertical-align:middle;">' . number_format($u['price'], 2) . '</td>';
                $order_detail.= '<td class="text-center" style="vertical-align:middle;">' . number_format($u['qty']) . '</b></td>';
                $order_detail.= '<td class="text-center" style="vertical-align:middle;">' . number_format($u['subtotal'], 2) . '</td>';
                $order_detail.= '</tr>';
                $order_detail.= '</tr>';
            }
            $this->Shop_model->updateStock($product_id, $qty);
            $order_detail.= '</tbody></table>';
            $order_detail.= '<h4><b>' . $this->Csz_model->getLabelLang('shop_order_total_txt') . ': ' . number_format($this->cart->total(), 2) . ' ' . $shop_config->currency_code . '</b></h4>';
            $payment_type = $this->input->post('payment_methods', TRUE);
            $this->Shop_model->paymentInsert($sha1_hash, $inv_id, $this->input->post('email', TRUE), $this->input->post('name', TRUE), $this->input->post('phone', TRUE), $this->input->post('address', TRUE), $payment_type, $this->cart->total(), $order_detail);
            /* Send mail to customer */
            $email_from = 'no-reply@' . EMAIL_DOMAIN;
            $mail_body = $shop_config->order_body;
            $mail_body.= $order_detail;
            if ($payment_type == 'banktransfer') {
                $mail_body.= '<br>' . $shop_config->bank_detail;
                $mail_body.= '<br><a href="' . BASE_URL . '/plugin/shop/bankTransfer/' . $sha1_hash . '">[Print]</a><br><br>';
            } else {
                $mail_body.= '<br><a href="' . BASE_URL . '/plugin/shop/success/' . $sha1_hash . '">[Print]</a><br><br>';
            }
            $mail_body.= $shop_config->signature;
            /* Send BCC mail to staff */
            $bcc = '';
            if ($shop_config->seller_email) {
                $bcc = $shop_config->seller_email;
            }
            @$this->Csz_model->sendEmail($this->input->post('email', TRUE), $shop_config->order_subject, $mail_body, $email_from, $row->site_name, $bcc);

            /* Payment */
            $returnURL = BASE_URL . '/plugin/shop/success/' . $sha1_hash; /* payment success url */
            $cancelURL = BASE_URL . '/plugin/shop/cancel/' . $sha1_hash; /* payment cancel url */
            if ($payment_type == 'paypal') {
                $this->load->library('Paypal_lib');
                /* Set variables for paypal form */
                $notifyURL = BASE_URL . '/plugin/shop/paypalIPN/' . $sha1_hash; /* ipn url */
                /* get particular product data */
                $this->paypal_lib->add_field('return', $returnURL);
                $this->paypal_lib->add_field('cancel_return', $cancelURL);
                $this->paypal_lib->add_field('notify_url', $notifyURL);
                $this->paypal_lib->add_field('item_name', 'Invoice ID: ' . $inv_id);
                $this->paypal_lib->add_field('custom', $this->input->post('email', TRUE));
                $this->paypal_lib->add_field('item_number', $inv_id);
                $this->paypal_lib->add_field('amount', $this->cart->total());
                $this->paypal_lib->paypal_auto_form();
                exit(); /* Not Delete for exit(); */
            } else if ($payment_type == 'paysbuy') {
                echo '<html>' . "\n";
                echo '<head><title>Processing Payment...</title></head>' . "\n";
                echo '<body style="text-align:center;" onLoad="document.forms[\'PaymentFrm\'].submit();">' . "\n";
                echo '<p style="text-align:center;">Please wait, your order is being processed and you will be redirected to the Paysbuy website.</p>';
                echo '<Form name="PaymentFrm" id="PaymentFrm" method="post" action="https://www.paysbuy.com/paynow.aspx?lang=e">
	    	    <input type="Hidden" Name="psb" value="psb" />
	    	    <input Type="Hidden" Name="biz" value="' . $shop_config->paysbuy_email . '" />
	    	    <input Type="Hidden" Name="inv" value="' . $inv_id . '" />
	    	    <input Type="Hidden" Name="itm" value="Invoice ID: ' . $inv_id . '" />
	    	    <input Type="Hidden" Name="amt" value="' . $this->cart->total() . '" />
	    	    <input Type="Hidden" Name="postURL" value="' . $returnURL . '" />
	    	</Form>';
                echo '</body></html>';
                exit();
            } else if ($payment_type == 'banktransfer') {
                redirect(BASE_URL . '/plugin/shop/bankTransfer/' . $sha1_hash, 'refresh');
            } else {
                redirect(BASE_URL . '/plugin/shop/cartView', 'refresh');
            }
        } else {
            redirect(BASE_URL . '/plugin/shop/cartView', 'refresh');
        }
    }

    public function bankTransfer() {
        if ($this->uri->segment(4)) {
            $row = $this->Csz_model->load_config();
            $shop_config = $this->Shop_model->load_config();
            $payment = $this->Csz_model->getValue('*', 'shop_payment', "sha1_hash = '" . $this->uri->segment(4) . "' AND payment_methods = 'banktransfer'", '', 1);
            $title = 'Shopping online bank transfer | ' . $row->site_name;
            $this->template->set('title', $title);
            $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
            $this->template->set('cur_page', $this->page_url);
            if ($payment !== FALSE && $payment->payment_methods == 'banktransfer') {
                //Get users from database
                $this->cart->destroy();
                if ($payment->payment_status != 'Completed') {
                    $this->db->set('payment_status', 'Pending');
                    $this->db->set('timestamp_update', 'NOW()', FALSE);
                    $this->db->where("sha1_hash = '" . $this->uri->segment(4) . "' AND payment_status != 'Completed'", '');
                    $this->db->update('shop_payment');
                }
                $this->template->setSub('shop_config', $shop_config);
                $this->template->setSub('payment', $payment);

                //Load the view
                $this->template->loadSub('frontpage/plugin/shop/shop_banktransfer');
            } else {
                redirect(BASE_URL . '/plugin/shop', 'refresh');
            }
        } else {
            redirect(BASE_URL . '/plugin/shop', 'refresh');
        }
    }

    public function success() {
        if ($this->uri->segment(4)) {
            $row = $this->Csz_model->load_config();
            $shop_config = $this->Shop_model->load_config();
            $payment = $this->Csz_model->getValue('*', 'shop_payment', "sha1_hash", $this->uri->segment(4), 1);
            $title = 'Shopping online order successfully | ' . $row->site_name;
            $this->template->set('title', $title);
            $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
            $this->template->set('cur_page', $this->page_url);
            if ($payment !== FALSE && $payment->payment_status != 'Canceled' && $payment->payment_methods != 'banktransfer') {
                if ($payment->payment_methods == 'paysbuy') {
                    $this->db->set('payment_status', 'Completed');
                    $this->db->set('timestamp_update', 'NOW()', FALSE);
                    $this->db->where("sha1_hash = '" . $this->uri->segment(4) . "' AND payment_status != 'Canceled'", '');
                    $this->db->update('shop_payment');
                }
                if ($payment->payment_methods == 'paypal') {
                    $this->db->set('payment_status', $this->input->post('payment_status', TRUE));
                    $this->db->set('timestamp_update', 'NOW()', FALSE);
                    $this->db->where("sha1_hash = '" . $this->uri->segment(4) . "' AND payment_status != 'Canceled'", '');
                    $this->db->update('shop_payment');
                }
                //Get users from database
                $this->cart->destroy();
                /* Send mail to customer */
                $email_from = 'no-reply@' . EMAIL_DOMAIN;
                $mail_body = $shop_config->payment_body;
                $mail_body.= $payment->order_detail;
                $mail_body.= '<br><a href="' . BASE_URL . '/plugin/shop/success/' . $this->uri->segment(4) . '">[Print]</a><br><br>';
                $mail_body.= $shop_config->signature;
                /* Send BCC mail to staff */
                $bcc = '';
                if ($shop_config->seller_email) {
                    $bcc = $shop_config->seller_email;
                }
                @$this->Csz_model->sendEmail($payment->email, $shop_config->payment_subject, $mail_body, $email_from, $row->site_name, $bcc);
                $this->template->setSub('shop_config', $shop_config);
                $this->template->setSub('payment', $payment);

                //Load the view
                $this->template->loadSub('frontpage/plugin/shop/shop_success');
            } else {
                redirect(BASE_URL . '/plugin/shop', 'refresh');
            }
        } else {
            redirect(BASE_URL . '/plugin/shop', 'refresh');
        }
    }

    public function cancel() {
        $row = $this->Csz_model->load_config();
        $title = 'Shopping online order cancel | ' . $row->site_name;
        $this->template->set('title', $title);
        $this->template->set('meta_tags', $this->Csz_model->coreMetatags($title, $row->keywords, $title));
        $this->template->set('cur_page', $this->page_url);
        if ($this->uri->segment(4)) {
            $this->db->set('payment_status', 'Canceled');
            $this->db->set('timestamp_update', 'NOW()', FALSE);
            $this->db->where("sha1_hash = '" . $this->uri->segment(4) . "' AND payment_status != 'Completed'", '');
            $this->db->update('shop_payment');
            $cart_check = $this->cart->contents();
            if (!empty($cart_check)) {
                $product_id = array();
                $qty = array();
                foreach ($cart_check as $u) {
                    $product_id[] = $u['shop_product_id'];
                    $qty[] = $u['qty'];
                }
                $this->Shop_model->updateStock($product_id, $qty, TRUE);
            }
        }

        //Load the view
        $this->template->loadSub('frontpage/plugin/shop/shop_cancel');
    }

    public function paypalIPN() {
        if ($this->uri->segment(4)) {
            $this->load->library('Paypal_lib');
            /* paypal return transaction details array */
            $paypalInfo = $this->input->post();
            $paypalURL = $this->paypal_lib->paypal_url;
            $result = $this->paypal_lib->curlPost($paypalURL, $paypalInfo);

            /* check whether the payment is verified */
            if (preg_match("/VERIFIED/i", $result)) {
                /* insert the transaction data into the database */
                $this->db->set('payment_status', $paypalInfo["payment_status"]);
                $this->db->set('timestamp_update', 'NOW()', FALSE);
                $this->db->where('sha1_hash', $this->uri->segment(4));
                $this->db->update('shop_payment');
            }
        } else {
            redirect(BASE_URL . '/plugin/shop', 'refresh');
        }
    }

    public function getWidget() {
        if ($this->uri->segment(4)) {
            // For Product status from url
            $this->load->library('Xml_writer');
            // Initiate class
            $xml = new Xml_writer;
            $xml->setRootName('csz_widget');
            $xml->initiate();
            // Start Main branch
            $xml->startBranch('plugin'); 
            if($this->uri->segment(4) == 'new'){
                $xml->addNode('main_url', BASE_URL.'/plugin/shop/newProduct');
            }elseif($this->uri->segment(4) == 'hot'){
                $xml->addNode('main_url', BASE_URL.'/plugin/shop/hotProduct');
            }elseif($this->uri->segment(4) == 'bestseller'){
                $xml->addNode('main_url', BASE_URL.'/plugin/shop/bestSeller');
            }else{
                $xml->addNode('main_url', BASE_URL.'/plugin/shop');
            }
            // Get product category 10 items
            $product = $this->Csz_model->getValueArray('*', 'shop_product', "active = 1 AND product_status = '".$this->uri->segment(4)."'", '', 20, 'timestamp_create','DESC');
            if($product !== FALSE){
                $xml->addNode('null', '0'); // For check item is not empty
                foreach ($product as $row) {
                    // start sub branch
                    $xml->startBranch('item', array('id' => $row['shop_product_id'])); 
                    $xml->addNode('sub_url', BASE_URL.'/plugin/shop/view/'.$row['shop_product_id'].'/'.$row['url_rewrite']);
                    $xml->addNode('title', $row['product_name']);
                    $xml->addNode('short_desc', $row['short_desc']);
                    $xml->addNode('photo', $this->Shop_model->getFirstImgs($row['shop_product_id']));
                    // End sub branch
                    $xml->endBranch();
                }
            }else{
                $xml->addNode('null', '1'); // For check item is empty
            }
            // End Main branch 
            $xml->endBranch();
            // Print the XML to screen
            $xml->getXml(true);
            exit();
        }else{
            // For All Product
            $this->load->library('Xml_writer');
            // Initiate class
            $xml = new Xml_writer;
            $xml->setRootName('csz_widget');
            $xml->initiate();
            // Start Main branch
            $xml->startBranch('plugin'); 
            $xml->addNode('main_url', BASE_URL.'/plugin/shop');
            // Get all product 20 items
            $product = $this->Csz_model->getValueArray('*', 'shop_product', "active", '1', 20, 'timestamp_create','DESC');
            if($product !== FALSE){
                $xml->addNode('null', '0'); // For check item is not empty
                foreach ($product as $row) {
                    // start sub branch
                    $xml->startBranch('item', array('id' => $row['shop_product_id'])); 
                    $xml->addNode('sub_url', BASE_URL.'/plugin/shop/view/'.$row['shop_product_id'].'/'.$row['url_rewrite']);
                    $xml->addNode('title', $row['product_name']);
                    $xml->addNode('short_desc', $row['short_desc']);
                    $xml->addNode('photo', $this->Shop_model->getFirstImgs($row['shop_product_id']));
                    // End sub branch
                    $xml->endBranch();
                }
            }else{
                $xml->addNode('null', '1'); // For check item is empty
            }
            // End Main branch 
            $xml->endBranch();
            // Print the XML to screen
            $xml->getXml(true);
            exit();
        }
    }

}
