<?php
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
defined('BASEPATH') OR exit('No direct script access allowed');

class Csz_model extends CI_Model {
             
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get Current Version
     *
     * Function for get current version
     *
     * @param	string	$version_test    version to test or NULL
     * @return	string
     */
    public function getVersion($version_test = '') {
        $con_version = $this->config->item('csz_version'); /* For CMS Version */
        $con_release = $this->config->item('csz_release'); /* For release or beta */
        $version = '';
        if($version_test) {
            $version = $version_test;               
        }else{
            if($con_release == 'beta'){
                $version = $con_version.' Beta';
            }else{
                $version = $con_version;
            }
        }
        return $version;
    }

    /**
     * downloadFile From url
     *
     * Function for download file from url
     *
     * @param	string	$url    url for file  download
     * @param	string	$newfname    path for file save
     * @return	FALSE if can't download
     */
    public function downloadFile($url, $newfname) {
        $file = fopen($url, 'rb') or die("Can't open file");
        if (!$file) {
            fclose($file);
            return FALSE;
        } else {
            $newf = fopen($newfname, 'wb') or die("Can't create file");
            if ($newf) {
                while (!feof($file)) {
                    fwrite($newf, fread($file, 1024 * 1024 * 10), 1024 * 1024 * 10); /* 10MB */
                }
                fclose($newf);
            }
            fclose($file);
        }
    }

    /**
     * count data from table
     *
     * Function for count the data from table
     *
     * @param	string	$table   DB Table
     * @param	string	$search_sql    For sql where Ex. "field1 = '1' AND field2 = '1'" or NULL
     * @param	string	$groupby   Group by field or NULL
     * @param	string	$orderby   Order by field or NULL
     * @param	string	$sort   asc or desc or NULL
     * @return	number or FALSE
     */
    public function countData($table, $search_sql = '', $groupby = '', $orderby = '', $sort = '') {
        $this->db->select('*');
        if ($search_sql) {
            if (is_array($search_sql)) {
                /* $search = array('field'=>'value') */
                foreach ($search_sql as $key => $value) {
                    $this->db->where($key, $value);
                }
            } else {
                /* $search = "name='Joe' AND status LIKE '%boss%' OR status1 LIKE '%active%'") */
                $this->db->where($search_sql);
            }
        }
        if ($groupby){
            $this->db->group_by($groupby);
        }
        if($orderby && $sort){
            $this->db->order_by($orderby, $sort);
        }
        $query = $this->db->get($table);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return FALSE;
        }
    }

    /**
     * getCurPages
     *
     * Function for get current page
     *
     * @return	String
     */
    public function getCurPages() {
        $totSegments = $this->uri->total_segments();
        if (!is_numeric($this->uri->segment($totSegments))) {
            $pageURL = $this->uri->segment($totSegments);
        } else if (is_numeric($this->uri->segment($totSegments))) {
            $pageURL = $this->uri->segment($totSegments - 1);
        }
        if ($pageURL == "") {
            $defaultpage = $this->getDefualtPage($this->session->userdata('fronlang_iso'));
            if ($defaultpage !== FALSE) {
                $pageURL = $defaultpage;
            } else {
                $pageURL = $this->getDefualtPage($this->getDefualtLang());
            }
        }
        return $pageURL;
    }

    /**
     * getValue
     *
     * Function get value from table with object
     *
     * @param	string	$sel_field   DB field select
     * @param	string	$table    DB table
     * @param	string	$where_field   where field or where condition Ex. "field = '1' AND field2 = '2'"
     * @param	string	$where_val   value of wherer (If $where_field has condition. Please null)
     * @param	string	$orderby   Order by field or NULL 
     * @param	string	$sort   asc or desc or NULL 
     * @param	string	$groupby   Group by field or NULL 
     * @return	Object or FALSE
     */
    public function getValue($sel_field = '*', $table, $where_field, $where_val, $limit = 0, $orderby = '', $sort = '', $groupby = '') {
        $this->db->select($sel_field);
        if($where_field || $where_val){
            if (is_array($where_field) && is_array($where_val)) {
                for ($i = 0; $i < count($where_field); $i++) {
                    $this->db->where($where_field[$i], $where_val[$i]);
                }
            } else {
                $this->db->where($where_field, $where_val);
            }
        }
        if ($groupby) {
            $this->db->group_by($groupby);
        }
        if ($orderby && $sort) {
            $this->db->order_by($orderby, $sort);
        }
        if ($limit) {
            $this->db->limit($limit, 0);
        }
        $query = $this->db->get($table);
        if (!empty($query)) {
            if ($query->num_rows() !== 0) {
                if ($query->num_rows() === 1) {
                    $row = $query->first_row();
                } else {
                    $row = $query->result();
                }
                return $row;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * getValueArray
     *
     * Function get value from table with array
     *
     * @param	string	$sel_field   DB field select
     * @param	string	$table    DB table
     * @param	string	$where_field   where field or where condition Ex. "field = '1' AND field2 = '2'"
     * @param	string	$where_val   value of wherer (If $where_field has condition. Please null)
     * @param	string	$orderby   Order by field or NULL 
     * @param	string	$sort   asc or desc or NULL 
     * @param	string	$groupby   Group by field or NULL 
     * @return	Array or FALSE
     */
    public function getValueArray($sel_field = '*', $table, $where_field, $where_val, $limit = 0, $orderby = '', $sort = '', $groupby = '') {
        $this->db->select($sel_field);
        if($where_field || $where_val){
            if (is_array($where_field) && is_array($where_val)) {
                for ($i = 0; $i < count($where_field); $i++) {
                    $this->db->where($where_field[$i], $where_val[$i]);
                }
            } else {
                $this->db->where($where_field, $where_val);
            }
        }
        if ($groupby) {
            $this->db->group_by($groupby);
        }
        if ($orderby && $sort) {
            $this->db->order_by($orderby, $sort);
        }
        if ($limit) {
            $this->db->limit($limit, 0);
        }
        $query = $this->db->get($table);
        if (!empty($query)) {
            if ($query->num_rows() !== 0) {
                return $query->result_array();
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * getLastID
     *
     * Function for get last id from db
     *
     * @param	string	$table    db table name
     * @param	string	$field_id    field id (primary key)
     * @return	number
     */
    public function getLastID($table, $field_id, $search_sql = '') {
        $this->db->select($field_id);
        if ($search_sql) {
            if (is_array($search_sql)) {
                /* $search = array('field'=>'value') */
                foreach ($search_sql as $key => $value) {
                    $this->db->where($key, $value);
                }
            } else {
                /* $search = "name='Joe' AND status LIKE '%boss%' OR status1 LIKE '%active%'") */
                $this->db->where($search_sql);
            }
        }
        $this->db->order_by($field_id, 'DESC');
        $this->db->limit(1, 0);
        $query = $this->db->get($table);
        if (!empty($query) && $query->num_rows() !== 0) {
            $row = $query->row();
            return $row->$field_id;
        } else {
            return 0;
        }
    }

    /**
     * load_config
     *
     * Function for get settings from settings table
     *
     * @return	Object or FALSE
     */
    public function load_config() {
        $this->db->limit(1, 0);
        $query = $this->db->get('settings');
        if ($query->num_rows() !== 0) {
            $row = $query->row();
            return $row;
        } else {
            return FALSE;
        }
    }

    /**
     * getLang()
     *
     * Function for get admin language
     *
     * @return	String
     */
    function getLang() {
        $this->db->limit(1, 0);
        $query = $this->db->get('settings');
        if ($query->num_rows() !== 0) {
            $row = $query->row();
            return $row->admin_lang;
        }
    }

    /**
     * getCountryCode
     *
     * Function for get country code from language code
     *
     * @param	string	$lang    language code
     * @return	String
     */
    public function getCountryCode($lang) {
        $this->db->limit(1, 0);
        $this->db->where("lang_iso", $lang);
        $query = $this->db->get('lang_iso');
        if ($query->num_rows() !== 0) {
            $row = $query->row();
            return $row->country_iso;
        }
    }

    /**
     * getPageUrlFromID
     *
     * Function for get page url_rewrite from page id
     *
     * @param	string	$id    pages id
     * @return	String
     */
    public function getPageUrlFromID($id) {
        $this->db->limit(1, 0);
        $this->db->where("pages_id", $id);
        $query = $this->db->get('pages');
        if ($query->num_rows() !== 0) {
            $row = $query->row();
            return $row->page_url;
        }
    }

    /**
     * getDefualtPage
     *
     * Function for get defualt page url_rewrite from language code
     *
     * @param	string	$lang    language code
     * @return	String or FALSE if not found
     */
    public function getDefualtPage($lang) {
        $this->db->where("lang_iso = '" . $lang . "' AND active = '1'", '');
        $this->db->limit(1, 0);
        $this->db->order_by('pages_id ASC');
        $query = $this->db->get('pages');
        if ($query->num_rows() !== 0) {
            $row = $query->row();
            return $row->page_url;
        } else {
            return FALSE;
        }
    }

    /**
     * getDefualtLang
     *
     * Function for get defualt language code
     *
     * @return	String
     */
    public function getDefualtLang() {
        $this->db->where('active', 1);
        $this->db->order_by("lang_iso_id", "asc");
        $this->db->limit(1, 0);
        $query = $this->db->get('lang_iso');
        if ($query->num_rows() !== 0) {
            $row = $query->row();
            return $row->lang_iso;
        }
    }

    /**
     * chkLangAlive
     *
     * Function for check language code is active
     *
     * @param	string	$lang_iso    language code
     * @return	number
     */
    public function chkLangAlive($lang_iso) {
        $this->db->where("lang_iso", $lang_iso);
        $this->db->where("active", 1);
        $query = $this->db->get('lang_iso');
        return $query->num_rows();
    }

    /**
     * setSiteLang
     *
     * Function for set language code into session
     *
     * @param	string	$lang_iso    language code
     */
    public function setSiteLang($lang_iso = '') {
        if (!$lang_iso) {
            $set_lang_iso = $this->getDefualtLang();
        } else {
            if ($this->chkLangAlive($lang_iso) > 0) {
                $set_lang_iso = $lang_iso;
            } else {
                $set_lang_iso = $this->getDefualtLang();
            }
        }
        $this->session->set_userdata('fronlang_iso', $set_lang_iso);
    }

    /**
     * loadAllLang
     *
     * Function for load all language
     *
     * @param	int	$active    (1 = active only, 0 or null = all)
     * @return	Object or FALSE id not found
     */
    public function loadAllLang($active = 0) {
        $this->db->select("*");
        if ($active)
            $this->db->where("active", 1);
        $this->db->order_by("lang_iso_id", "asc");
        $query = $this->db->get('lang_iso');
        if ($query->num_rows() !== 0) {
            $row = $query->result();
            return $row;
        } else {
            return FALSE;
        }
    }

    /**
     * load_page
     *
     * Function for load page data from page url_rewrite
     *
     * @param	string	$pageurl    page url_rewrite
     * @return	Object or FALSE id not found
     */
    public function load_page($pageurl) {
        $this->db->where("page_url", $pageurl);
        $this->db->where("active", 1);
        $this->db->limit(1, 0);
        $query = $this->db->get('pages');
        if ($query->num_rows() !== 0) {
            $row = $query->row();
            return $row;
        } else {
            return FALSE;
        }
    }

    /**
     * main_menu
     *
     * Function for load main menu
     *
     * @param	int	$drop_page_menu_id    1 = drop menu, 0 = main menu
     * @param	string	$lang    language code
     * @return	Object or FALSE id not found
     */
    public function main_menu($drop_page_menu_id = 0, $lang) {
        if ($drop_page_menu_id) {
            $this->db->where("drop_page_menu_id", $drop_page_menu_id);
        } else {
            $this->db->where("drop_page_menu_id", 0);
        }
        $this->db->where("lang_iso", $lang);
        $this->db->where("active", 1);
        $this->db->order_by("arrange", "asc");
        $query = $this->db->get('page_menu');
        if ($query->num_rows() !== 0) {
            $row = $query->result();
            return $row;
        } else {
            return FALSE;
        }
    }

    /**
     * getSocial
     *
     * Function for get social link
     *
     * @return	Object or FALSE id not found
     */
    public function getSocial() {
        $this->db->select("*");
        $this->db->where("active", 1);
        $this->db->order_by("social_name", "asc");
        $query = $this->db->get('footer_social');
        if ($query->num_rows() !== 0) {
            $row = $query->result();
            return $row;
        } else {
            return FALSE;
        }
    }

    /**
     * cszCopyright
     *
     * Function for show website footer
     * Please do not remove or change the fuction $this->Csz_admin_model->cszCopyright()
     *
     */
    public function cszCopyright() {
        $row = $this->Csz_model->load_config();
        $html = '<span class="copyright">' . str_replace(' %YEAR ', ' ' . date('Y') . ' ', $row->site_footer) . '</span>
                <small style="color:gray;">' . $this->Csz_admin_model->cszCopyright() . '</small>'; /* Please do not remove or change the fuction $this->Csz_admin_model->cszCopyright() */
        return $html;
    }

    /**
     * coreCss
     *
     * Function for load core css
     *
     * @param	string	$more_css    additional css
     * @return	String
     */
    public function coreCss($more_css = '') {
        $core_css = '<link rel="canonical" href="' . base_url(uri_string()) . '" />' . "\n";
        $core_css.= link_tag('assets/css/corecss.min.css');
        $core_css.= link_tag('assets/font-awesome/css/font-awesome.min.css');
        $core_css.= link_tag('assets/css/jquery-ui-themes-1.11.4/themes/smoothness/jquery-ui.min.css');
        if (!empty($more_css)) {
            if (is_array($more_css)) {
                foreach ($more_css as $value) {
                    if ($value) {
                        $core_css.= link_tag($value);
                    }
                }
            } else {
                $core_css.= link_tag($more_css);
            }
        }
        return $core_css;
    }

    /**
     * coreJs
     *
     * Function for load core js
     *
     * @param	string	$more_js    additional js
     * @return	String
     */
    public function coreJs($more_js = '') {
        $core_js = '<script type="text/javascript" src="' . BASE_URL . '/assets/js/corejs.min.js"></script>' . "\n";
        if (!empty($more_js)) {
            if (is_array($more_js)) {
                foreach ($more_js as $value) {
                    if ($value) {
                        $core_js.= '<script type="text/javascript" src="' . $value . '"></script>';
                    }
                }
            } else {
                $core_js.= '<script type="text/javascript" src="' . $more_js . '"></script>';
            }
        }
        return $core_js;
    }

    /**
     * coreMetatags
     *
     * Function for load core metatag
     *
     * @param	string	$desc_txt    page description
     * @param	string	$keywords    page keyword
     * @param	string	$title    page title
     * @param	string	$article_img    page article image url
     * @return	String
     */
    public function coreMetatags($desc_txt, $keywords, $title, $article_img = '') {
        $config = $this->load_config();
        $og_image = '';
        $og_type = '';
        if ($article_img) {
            $og_image = BASE_URL . '/photo/plugin/article/' . str_replace(BASE_URL . '/photo/plugin/article/', '', $article_img);
            $og_type = 'article';
        } else {
            $og_type = 'website';
            if ($config->og_image) {
                $og_image = BASE_URL . '/photo/logo/' . $config->og_image;
            } else {
                if ($config->site_logo) {
                    $og_image = BASE_URL . '/photo/logo/' . $config->site_logo;
                } else {
                    $og_image = BASE_URL . '/assets/images/logo.png';
                }
            }
        }
        $meta = array(
            array('name' => 'robots', 'content' => 'no-cache, no-cache'),
            array('name' => 'description', 'content' => $desc_txt),
            array('name' => 'keywords', 'content' => $keywords),
            array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1'),
            array('name' => 'author', 'content' => $config->site_name),
            array('name' => 'generator', 'content' => 'CSZ CMS | Version '.$this->Csz_model->getVersion()),
            array('name' => 'X-UA-Compatible', 'content' => 'IE=edge', 'type' => 'equiv'),
            array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
            array('name' => 'og:site_name', 'content' => $config->site_name, 'type' => 'property'),
            array('name' => 'og:title', 'content' => $title, 'type' => 'property'),
            array('name' => 'og:type', 'content' => $og_type, 'type' => 'property'),
            array('name' => 'og:description', 'content' => $desc_txt, 'type' => 'property'),
            array('name' => 'og:url', 'content' => BASE_URL . '/' . $this->uri->uri_string(), 'type' => 'property'),
            array('name' => 'og:image', 'content' => $og_image, 'type' => 'property'),
            array('name' => 'name', 'content' => $title, 'type' => 'itemprop'),
            array('name' => 'description', 'content' => $desc_txt, 'type' => 'itemprop')
        );
        $return_meta = meta($meta);
        if ($config->fbapp_id) {
            $return_meta.= '<meta property="fb:app_id" content="' . $config->fbapp_id . '" />' . "\n";
        }
        return $return_meta;
    }

    /**
     * rw_link
     *
     * Function for url rewrite from string
     *
     * @param	string	$val    Title name or string
     * @return	String
     */
    public function rw_link($val) {
        $val = trim(strtolower(strip_tags($val)));    
        $val = str_replace('&amp', 'and', $val);
        $val_arr = array('–',' ',"'s-","’s-",'!','@','#','$','%','^','&','*','(',')','_','+','|','{','}',':','"','‘','’','<','>','?','/','.',',',"'",';',']','[','=','----','---','--');
        $val = str_replace($val_arr, '-', $val);
        $val = strip_tags(iconv_substr($val,0,255,'UTF-8')); /* cut char limit 255 char */
        return $val;
    }

    /**
     * getHtmlContent
     *
     * Function for convert HTML for form linkstats and widget
     *
     * @param	string	$ori_content    Original content
     * @param	string	$url_segment    Form status paramiter return
     * @return	string
     */
    public function getHtmlContent($ori_content, $url_segment) { /* Calculate the HTML code */
        $config = $this->load_config();
        if ($config->link_statistic_active) {
            $ori_content = $this->linkFromHtml($ori_content);
        }
        $ori_content = $this->frmNameInHtml($ori_content, $url_segment);
        $ori_content = $this->widgetInHtml($ori_content);
        return $ori_content;
    }

    /**
     * widgetInHtml
     *
     * Function for find widget tag
     *
     * @param	string	$content    Original content
     * @return	string
     */
    public function widgetInHtml($content) { /* Find the widget in content */
        $txt_nonhtml = strip_tags($content);
        if (strpos($txt_nonhtml, '[?]{=widget:') !== false) {
            $txt_nonline = str_replace(PHP_EOL, '', $txt_nonhtml);
            $array = explode("[?]", $txt_nonline);
            if (!empty($array)) {
                foreach ($array as $key => $value) {
                    $widget_name[] = $array[$key];
                }
            }
            if (!empty($widget_name)) {
                foreach ($widget_name as $val) {
                    if (strpos($val, '{=widget:') !== false) {
                        $rep_arr = array('{=widget:', '}');
                        $wid_name = str_replace($rep_arr, '', $val);
                        $content = $this->addWidgetToHTML($content, $wid_name);
                    }
                }
            }
        }
        return $content;
    }

    /**
     * addWidgetToHTML
     *
     * Function for add widget into html
     *
     * @param	string	$content    Original content
     * @param	string	$wid_name   Widget name
     * @return	string
     */
    public function addWidgetToHTML($content, $wid_name) {
        $getWidget = $this->getValue('*', 'widget_xml', "active = '1' AND widget_name = '" . $wid_name . "' AND xml_url != '' AND limit_view != '0'", '', 1);
        if ($getWidget !== FALSE) {
            $html = '<div class="panel panel-default">
            <div class="panel-heading"><b>' . $getWidget->widget_name . '</b></div>
            <div class="panel-body">';
            if ($this->is_url_exist($getWidget->xml_url) !== FALSE) {
                $xml = @simplexml_load_file($getWidget->xml_url);
                if ($xml !== FALSE) {
                    if ($xml->plugin[0]->null == 0) {
                        $i = 1;
                        foreach ($xml->plugin[0]->item as $item) {
                            $html.= '<div class="row">
                                        <div class="col-md-3">
                                            <a href="' . $item->sub_url . '" title="' . $item->title . '">
                                                <img class="img-responsive img-thumbnail" src="' . $item->photo . '" alt="' . $item->title . '">
                                            </a>
                                        </div>
                                        <div class="col-md-9">
                                            <a href="' . $item->sub_url . '" title="' . $item->title . '"><h4>' . $item->title . '</h4></a><br>
                                            <p>' . $item->short_desc . '</p>
                                        </div>
                                    </div><hr>';
                            if ($i == $getWidget->limit_view) {
                                break;
                            }
                            $i++;
                        }
                    } else {
                        $html.= '<h4 class="error">' . $this->getLabelLang('shop_notfound') . '</h4>';
                    }
                    $html.= '</div>
                    <div class="panel-footer text-right"><a href="' . $xml->plugin[0]->main_url . '" class="btn btn-primary btn-sm">' . $this->getLabelLang('article_readmore_text') . '</a></div>';
                }else{
                    $html.= '</div>';
                }
            }else{
                $html.= '</div>';
            }
            $html.= '</div>';
            $content = str_replace('[?]{=widget:' . $getWidget->widget_name . '}[?]', $html, $content);
        }
        return $content;
    }

    /**
     * linkFromHtml
     *
     * Function for find link stats from html
     *
     * @param	string	$content    Original content
     * @return	string
     */
    public function linkFromHtml($content) { /* Find and replace a tag in content */
        if (strpos($content, ' href="') !== false && strpos($content, '</a>') !== false) {
            $txt_nonline = str_replace(PHP_EOL, '', $content);
            $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
            $i = 0;
            $j = 0;
            $k = 0;
            if (preg_match_all("/$regexp/siU", $txt_nonline, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    /* $match[0] = tag a | $match[2] = link address | $match[3] = link text */
                    if (!preg_match('/#/', $match[2]) && strpos($match[0], ' linkstats="') !== false) {
                        $ori_link[] = $match[2];
                        $link[] = $match[2] . '[' . $i . ']';
                        $i++;
                    }
                }
            }
            if (!empty($ori_link)) {
                foreach ($ori_link as $val) {
                    $patterns = array();
                    $patterns[0] = 'href="' . $val . '"';
                    $patterns[1] = 'linkstats="' . $j . '"';
                    $replacements = array();
                    $replacements[1] = 'href="' . $val . '[' . $j . ']"';
                    $replacements[0] = 'linkstats="' . $j . '"';
                    $content = str_replace($patterns, $replacements, $content);
                    $j++;
                }
            }
            if (!empty($link)) {
                foreach ($link as $val) {
                    $patterns = array();
                    $patterns[0] = 'href="' . $val . '"';
                    $patterns[1] = 'linkstats="' . $k . '"';
                    $replacements = array();
                    $replacements[1] = 'href="' . BASE_URL . '/linkstats/' . ($k + 1) . '/' . $this->encodeURL($val) . '"';
                    $replacements[0] = 'linkstats="' . $k . '"';
                    $content = str_replace($patterns, $replacements, $content);
                    /* $content = str_replace('['.$k.']', '', $content); */
                    $k++;
                }
            }
        }
        return $content;
    }

    /**
     * frmNameInHtml
     *
     * Function for find form tag from html
     *
     * @param	string	$content    Original content
     * @param	string	$url_segment   Form status paramiter return
     * @return	string
     */
    public function frmNameInHtml($content, $url_segment) { /* Find the form in content */
        $txt_nonhtml = strip_tags($content);
        if ($this->findFrmTag($content) !== false) {
            $txt_nonline = str_replace(PHP_EOL, '', $txt_nonhtml);
            $array = explode("[?]", $txt_nonline);
            if (!empty($array)) {
                foreach ($array as $key => $value) {
                    $form_name[] = $array[$key];
                }
            }
            if (!empty($form_name)) {
                foreach ($form_name as $val) {
                    if (strpos($val, '{=forms:') !== false) {
                        $rep_arr = array('{=forms:', '}');
                        $frm_name = str_replace($rep_arr, '', $val);
                        $content = $this->addFrmToHtml($content, $frm_name, $url_segment);
                        break; /* Break for reCaptcha one form per page only */
                    }
                }
            }
        }
        return $content;
    }

    /**
     * addFrmToHtml
     *
     * Function for add form into html
     *
     * @param	string	$content    Original content
     * @param	string	$frm_name   Form name
     * @param	string	$status     Form status paramiter return
     * @return	string
     */
    public function addFrmToHtml($content, $frm_name, $status = '') { /* Add the form in content */
        $CI =& get_instance();
        $row_config = $this->load_config();
        $where_arr = array('form_name', 'active');
        $val_arr = array($frm_name, 1);
        $form_data = $this->getValue('*', 'form_main', $where_arr, $val_arr, 1);
        if ($form_data) {
            $html_btn = '';
            if ($status == 1) {
                $sts_msg = '<div class="text-center"><div class="alert alert-success" role="alert">' . $form_data->success_txt . '</div></div><br>';
            } else if ($status == 2) {
                $sts_msg = '<div class="text-center"><div class="alert alert-danger" role="alert">' . $form_data->captchaerror_txt . '</div></div><br>';
            } else if ($status == 3) {
                $sts_msg = '<div class="text-center"><div class="alert alert-danger" role="alert">' . $form_data->error_txt . '</div></div><br>';
            } else {
                $sts_msg = '';
            }
            $html = $sts_msg;
            $action_url = BASE_URL . '/formsaction/' . $form_data->form_main_id;
            $html.= '<form action="' . $action_url . '" name="' . $frm_name . '" method="' . $form_data->form_method . '" enctype="' . $form_data->form_enctype . '" accept-charset="utf-8">';
            if ($CI->config->item('csrf_protection') === TRUE && strpos($action_url, $CI->config->base_url()) !== FALSE && !stripos($form_data->form_method, 'get')) {
                $html.= '<input type="hidden" name="'.$CI->security->get_csrf_token_name().'" id="'.$CI->security->get_csrf_token_name().'" value="' . $CI->security->get_csrf_hash() . '">';
            }
            $sess_data = array('cszfrm_cururl' => str_replace(BASE_URL . '/', '', current_url()));
            $this->session->set_userdata($sess_data);
            $field_data = $this->getValue('*', 'form_field', 'form_main_id', $form_data->form_main_id, '', 'form_field_id', 'asc');
            foreach ($field_data as $field) {
                if ($field->field_required) {
                    $f_req = ' required="required"';
                    $star_req = ' <i style="color:red;">*</i>';
                } else {
                    $f_req = '';
                    $star_req = '';
                }
                if ($field->field_type == 'email' || $field->field_type == 'password' || $field->field_type == 'text') {
                    $maxlength = ' maxlength="255"';
                } else {
                    $maxlength = '';
                }
                if ($field->field_type == 'checkbox' || $field->field_type == 'email' || $field->field_type == 'password' || $field->field_type == 'radio' || $field->field_type == 'text') {
                    $html.= '<label class="control-label" for="' . $field->field_id . '">' . $field->field_label . $star_req . '</label>
                    <div class="controls">
                        <input type="' . $field->field_type . '" name="' . $field->field_name . '" value="' . $field->field_value . '" id="' . $field->field_id . '" class="' . $field->field_class . '" placeholder="' . $field->field_placeholder . '"' . $f_req . $maxlength . '/>
                    </div>';
                } else if ($field->field_type == 'datepicker') {
                    if ($field->field_class) {
                        $class = $field->field_class . ' form-datepicker';
                    } else {
                        $class = 'form-datepicker';
                    }
                    $html.= '<label class="control-label" for="' . $field->field_id . '">' . $field->field_label . $star_req . '</label>
                    <div class="controls">
                        <input type="text" name="' . $field->field_name . '" value="' . $field->field_value . '" id="' . $field->field_id . '" class="' . $class . '" placeholder="' . $field->field_placeholder . '"' . $f_req . '/>
                    </div>';
                } else if ($field->field_type == 'selectbox') {
                    $opt_html = '';
                    if ($field->sel_option_val) {
                        $opt_arr = explode(",", $field->sel_option_val);
                        foreach ($opt_arr as $opt) {
                            list($val, $show) = explode("=>", $opt);
                            $opt_html.= '<option value="' . trim($val) . '">' . trim($show) . '</option>';
                        }
                    }
                    ($field->field_placeholder) ? $placehol = '<option value="">' . $field->field_placeholder . '</option>' : $placehol = '';
                    $html.= '<label class="control-label" for="' . $field->field_id . '">' . $field->field_label . $star_req . '</label>
                            <select id="' . $field->field_id . '" name="' . $field->field_name . '" class="' . $field->field_class . '"' . $f_req . '>
                                ' . $placehol . '
                                ' . $opt_html . '
                            </select>';
                } else if ($field->field_type == 'textarea') {
                    $html.= '<label class="control-label" for="' . $field->field_id . '">' . $field->field_label . $star_req . '</label>
                    <div class="controls">
                        <textarea name="' . $field->field_name . '" id="' . $field->field_id . '" class="' . $field->field_class . '" placeholder="' . $field->field_placeholder . '"' . $f_req . ' rows="4">' . $field->field_value . '</textarea>
                    </div>';
                } else if ($field->field_type == 'button' || $field->field_type == 'reset' || $field->field_type == 'submit') {
                    $html_btn.= '<input type="' . $field->field_type . '" name="' . $field->field_name . '" value="' . $field->field_value . '" id="' . $field->field_id . '" class="' . $field->field_class . '" placeholder="' . $field->field_placeholder . '"' . $f_req . '/> ';
                } else if ($field->field_type == 'label') {
                    $html.= '<label class="' . $field->field_class . '" id="' . $field->field_id . '" name="' . $field->field_name . '">' . $field->field_label . $star_req . '</label><br>';
                }
            }
            if ($form_data->captcha) {
                $html.= $this->showCaptcha();
            }
            $html.= '<br><div class="form-actions">' . $html_btn . '</div>';
            $html.= '</form>';
            $new_content = str_replace('[?]{=forms:' . $frm_name . '}[?]', $html, $content);
            return $new_content;
        } else {
            return $content;
        }
    }
    
    /**
     * encodeURL
     *
     * Function for encode the url
     *
     * @param	string	$val    Original url
     * @return	string
     */
    public function encodeURL($val) {
        $return = str_replace(array('+', '/', '='), array('-', '_', '.'), base64_encode($val));
        return $return;
    }
    
    /**
     * decodeURL
     *
     * Function for decode the url
     *
     * @param	string	$val    Encode url
     * @return	string
     */
    public function decodeURL($val) {
        $return = base64_decode(str_replace(array('-', '_', '.'), array('+', '/', '='), $val));
        return $this->security->xss_clean($return);
    }

    /**
     * clear_all_error_log
     *
     * Function for clear all log file
     *
     */
    public function clear_all_error_log() {
        $CI = & get_instance();
        $path = $CI->config->item('log_path');

        $logs_path = ($path == '') ? APPPATH . 'logs/' : $path;

        $handle = opendir($logs_path);
        while (($file = readdir($handle)) !== FALSE) {
            //Leave the directory protection alone
            if ($file != '.htaccess' && $file != 'index.html') {
                @unlink($logs_path . '/' . $file);
            }
        }
        closedir($handle);
    }

    /**
     * clear_all_session
     *
     * Function for clear all session file
     *
     */
    public function clear_all_session() {
        $CI = & get_instance();
        $path = $CI->config->item('sess_save_path');

        $sess_path = ($path == '') ? BASEPATH . '/ci_session' : $path;

        $handle = opendir($sess_path);
        while (($file = readdir($handle)) !== FALSE) {
            //Leave the directory protection alone
            if ($file != '.htaccess' && $file != 'index.html') {
                @unlink($sess_path . '/' . $file);
            }
        }
        closedir($handle);
    }

    /**
     * clear_all_cache
     *
     * Function for clear all cache file
     *
     */
    public function clear_all_cache() {
        $CI = & get_instance();
        $path = $CI->config->item('cache_path');

        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;

        $handle = opendir($cache_path);
        while (($file = readdir($handle)) !== FALSE) {
            //Leave the directory protection alone
            if ($file != '.htaccess' && $file != 'index.html') {
                @unlink($cache_path . '/' . $file);
            }
        }
        closedir($handle);
    }

    /**
     * clear_uri_cache
     *
     * Function for clear uri cache file
     *
     * @param	string	$uri    page uri
     */
    public function clear_uri_cache($uri) {
        $CI = & get_instance();
        $path = $CI->config->item('cache_path');
        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;
        @unlink($cache_path . '/' . md5($uri));
    }

    /**
     * getCurlreCaptData
     *
     * Function for get the reCaptcha respone data from json
     *
     * @param	string	$url    reCaptcha json respone url
     * @return	string or FALSE if reCaptcha wrong
     */
    private function getCurlreCaptData($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        $obj = json_decode($result);
        if (!empty($obj)) {
            return $obj->success;
        } else {
            return FALSE;
        }
    }

    /**
     * chkCaptchaRes
     *
     * Function for check the reCaptcha
     *
     * @return	string
     */
    public function chkCaptchaRes() {
        $config = $this->load_config();
        $respone = '';
        if ($config->googlecapt_active && $config->googlecapt_sitekey && $config->googlecapt_secretkey) {
            //$recaptcha = $_POST['g-recaptcha-response'];   
            $recaptcha = $this->input->post('g-recaptcha-response');
            if ($recaptcha != null && strlen($recaptcha) != 0) {
                $ip = $this->input->ip_address();
                $url = "https://www.google.com/recaptcha/api/siteverify" . "?secret=" . $config->googlecapt_secretkey . "&response=" . $recaptcha . "&remoteip=" . $ip;
                $res = $this->getCurlreCaptData($url);
                if ($res !== FALSE && $res) {
                    $respone = $res;
                } else {
                    $respone = '';
                }
            } else {
                $respone = '';
            }
        } else {
            $respone = 'NOT_ACTIVE';
        }
        return $respone;
    }

    /**
     * showCaptcha
     *
     * Function for show the reCaptcha
     *
     * @return	string
     */
    public function showCaptcha() {
        $config = $this->load_config();
        $html = '';
        if ($config->googlecapt_active && $config->googlecapt_sitekey && $config->googlecapt_secretkey) {
            $hl = '';
            if($this->uri->segment(1) == 'admin'){
                if($this->Csz_admin_model->getLang()){
                    $hl = '?hl='.$this->Csz_admin_model->getLangISOfromName($this->Csz_admin_model->getLang());
                }
            }else{
                if($this->session->userdata('fronlang_iso')){
                    $hl = '?hl=' . $this->session->userdata('fronlang_iso');
                }
            }
            $html = '<script type="text/javascript" src="https://www.google.com/recaptcha/api.js'.$hl.'"></script>'."\n";
            $html.= '<div class="g-recaptcha" style="transform:scale(0.75) !important; -webkit-transform:scale(0.75) !important; transform-origin:0 0 !important; -webkit-transform-origin:0 0 !important;" data-sitekey="' . $config->googlecapt_sitekey . '"></div>';
        }
        return $html;
    }

    /**
     * saveLinkStats
     *
     * Function for save link stats
     *
     * @param	string	$link    url for save into database
     */
    public function saveLinkStats($link) {
        $this->db->set('link', $link, TRUE);
        $this->db->set('ip_address', $this->input->ip_address(), TRUE);
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->insert('link_statistic');
    }

    /**
     * chkPassword
     *
     * Function for check the email and password
     *
     * @param	string	$email    email address
     * @param	string	$password    password
     * @param	string	$typecondition   User type sql condition for WHERE. Default is NULL
     * @return	object
     */
    public function chkPassword($email, $password, $typecondition = '') {
        $this->db->select("*");
        $this->db->where("email", $email);
        $this->db->where("password", $password);
        $this->db->where("active", '1');
        if($typecondition){
            $this->db->where($typecondition);
        }
        $this->db->limit(1, 0);
        return $this->db->get("user_admin");
    }

    /**
     * memberLogin
     *
     * Function for check the email and password
     *
     * @param	string	$email    email address
     * @param	string	$password    password
     * @return	string
     */
    public function memberLogin($email, $password) {
        if ($this->Csz_model->chkCaptchaRes() == '') {
            return 'CAPTCHA_WRONG';
        } else {
            if($this->chkIPBaned($email) === FALSE){
                $query = $this->chkPassword($email, $password);
                if ($query->num_rows() == 1) {
                    $rows = $query->row();
                    if (!empty($rows)) {
                        $session_id = session_id();
                        $this->db->set('session_id', $session_id, TRUE);
                        $this->db->where('user_admin_id', $rows->user_admin_id);
                        $this->db->update('user_admin');
                        $data = array(
                            'user_admin_id' => $rows->user_admin_id,
                            'admin_name' => $rows->name,
                            'admin_email' => $rows->email,
                            'admin_type' => $rows->user_type,
                            'admin_visitor' => $rows->backend_visitor,
                            'session_id' => $session_id,
                            'admin_logged_in' => TRUE,
                        );
                        $this->session->set_userdata($data);
                        return 'SUCCESS';
                    }else{
                        return 'INVALID';
                    }
                } else {
                    return 'INVALID';
                }
            }else{
                return 'IP_BANNED';
            }
        }
    }

    /**
     * saveLogs
     *
     * Function for save the login log into database
     *
     * @param	string	$email    email address
     * @param	string	$note    note text
     * @param	string	$result    result text
     */
    public function saveLogs($email, $note = '', $result = '') {
        if($result != 'IP_BANNED'){
            $data = array(
                'email_login' => $email,
                'note' => $note,
                'result' => $result,
            );
            $this->db->set('user_agent', $this->input->user_agent(), TRUE);
            $this->db->set('ip_address', $this->input->ip_address(), TRUE);
            $this->db->set('timestamp_create', 'NOW()', FALSE);
            $this->db->insert('login_logs', $data);
        }
    }

    /**
     * getLabelLang
     *
     * Function for get the label language for frontend
     *
     * @param	string	$name    label name
     * @return	string or FALSE
     */
    public function getLabelLang($name) {
        if (!$this->session->userdata('fronlang_iso')) {
            $this->setSiteLang();
        }
        $lang = $this->session->userdata('fronlang_iso');
        if ($lang) {
            $sel_name = 'lang_' . $lang;
            $this->db->select($sel_name);
            $this->db->where("name", $name);
            $this->db->limit(1, 0);
            $query = $this->db->get("general_label");
            if ($query && $query->num_rows() !== 0) {
                if ($query->row()->$sel_name)
                    return $query->row()->$sel_name;
                else
                    return "This label is untranslated!";
            }else {
                return "This language isn't sync! (lang_" . $lang . ")";
            }
        } else {
            return FALSE;
        }
    }

    /**
     * createMember
     *
     * Function for create new member
     */
    public function createMember() {
        // Create the user account
        $config = $this->Csz_model->load_config();
        if ($config->member_close_regist) {
            return FALSE;
        } else {
            $md5_hash = md5(time() + mt_rand(1, 99999999));
            $data = array(
                'name' => 'Member User',
                'email' => $this->cleanEmailFormat($this->input->post('email', TRUE)),
                'password' => sha1(md5($this->input->post('password', TRUE))),
                'user_type' => 'member',
                'active' => 0,
                'md5_hash' => $md5_hash,
            );
            $this->db->set('md5_lasttime', 'NOW()', FALSE);
            $this->db->set('timestamp_create', 'NOW()', FALSE);
            $this->db->set('timestamp_update', 'NOW()', FALSE);
            $this->db->insert('user_admin', $data);
            return $md5_hash;
        }
    }

    /**
     * updateMember
     *
     * Function for update the member
     *
     * @param	string	$id    member id
     * @return	TRUE or FALSE
     */
    public function updateMember($id) {
        $query = $this->chkPassword($this->session->userdata('admin_email'), sha1(md5($this->input->post('cur_password', TRUE))));
        if ($query->num_rows() !== 0) {
            // update the user account
            if ($this->input->post('year', TRUE) && $this->input->post('month', TRUE) && $this->input->post('day', TRUE)) {
                $birthday = $this->input->post('year', TRUE) . '-' . $this->input->post('month', TRUE) . '-' . $this->input->post('day', TRUE);
            } else {
                $birthday = '';
            }
            if ($this->input->post('del_file')) {
                $upload_file = '';
                @unlink('photo/profile/' . $this->input->post('del_file', TRUE));
            } else {
                $upload_file = $this->input->post('picture');
                if ($_FILES['file_upload']['type'] == 'image/png' || $_FILES['file_upload']['type'] == 'image/jpg' || $_FILES['file_upload']['type'] == 'image/jpeg' || $_FILES['file_upload']['type'] == 'image/gif') {
                    $paramiter = '_1';
                    $photo_id = time();
                    $uploaddir = 'photo/profile/';
                    $file_f = $_FILES['file_upload']['tmp_name'];
                    $file_name = $_FILES['file_upload']['name'];
                    $upload_file = $this->Csz_admin_model->file_upload($file_f, $file_name, $this->input->post('picture', TRUE), $uploaddir, $photo_id, $paramiter);
                }
            }
            $this->db->set('name', $this->input->post("name", TRUE), TRUE);
            $this->db->set('email', $this->cleanEmailFormat($this->input->post('email', TRUE)), TRUE);
            if ($this->input->post('password') != '') {
                $this->db->set('password', sha1(md5($this->input->post('password', TRUE))), TRUE);
                $this->db->set('md5_hash', md5(time() + mt_rand(1, 99999999)), TRUE);
                $this->db->set('md5_lasttime', 'NOW()', FALSE);
            }
            $this->db->set('first_name', $this->input->post("first_name", TRUE), TRUE);
            $this->db->set('last_name', $this->input->post("last_name", TRUE), TRUE);
            $this->db->set('birthday', $birthday, TRUE);
            $this->db->set('gender', $this->input->post("gender", TRUE), TRUE);
            $this->db->set('address', $this->input->post("address", TRUE), TRUE);
            $this->db->set('phone', $this->input->post("phone", TRUE), TRUE);
            $this->db->set('picture', $upload_file, TRUE);
            $this->db->set('timestamp_update', 'NOW()', FALSE);
            $this->db->where('user_admin_id', $id);
            $this->db->update('user_admin');
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * sendEmail
     *
     * Function for send the email (effect with settings on backend)
     *
     * @param	string	$to_email    to email address
     * @param	string	$subject     email subject
     * @param	string	$message    email body message
     * @param	string	$from_email    from email address
     * @param	string	$from_name    from name
     * @param	string	$bcc    bcc to email address
     * @param	string	$alt_message    alternate message when html not working
     * @param	array	$attach_file    attach files with array
     * @return	string
     */
    public function sendEmail($to_email, $subject, $message, $from_email, $from_name = '', $bcc = '', $alt_message = '', $attach_file = array()) {
        $this->load->library('email');
        $load_conf = $this->load_config();
        $protocal = $load_conf->email_protocal;
        if (!$protocal) {
            $protocal = 'mail';
        }
        $config = array();
        $config['protocol'] = $protocal;  /* mail, sendmail, smtp */
        if ($protocal == 'smtp') {
            $config['smtp_host'] = $load_conf->smtp_host;
            $config['smtp_user'] = $load_conf->smtp_user;
            $config['smtp_pass'] = $load_conf->smtp_pass;
            $config['smtp_port'] = $load_conf->smtp_port;
        } else if ($protocal == 'sendmail' && $load_conf->sendmail_path) {
            $config['mailpath'] = $load_conf->sendmail_path;
        }
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from($from_email, $from_name); // change it to yours
        $this->email->to($to_email); // change it to yours
        $this->email->subject($subject);
        $this->email->message($message);
        if ($bcc) {
            $this->email->bcc($bcc);
        }
        if ($alt_message) {
            $this->email->set_alt_message($alt_message);
        }
        if (is_array($attach_file) && !empty($attach_file)) {
            foreach ($attach_file as $value) {
                $this->email->attach($value);
            }
        }
        if ($this->email->send()) {
            $result = 'success';
        } else {
            $result = $this->email->print_debugger(FALSE);
        }
        $data = array(
            'to_email' => $to_email,
            'from_email' => $from_email,
            'from_name' => $from_name,
            'subject' => $subject,
            'message' => $message,
            'email_result' => $result,
        );
        $this->db->set('user_agent', $this->input->user_agent(), TRUE);
        $this->db->set('ip_address', $this->input->ip_address(), TRUE);
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->insert('email_logs', $data);
        return $result;
    }

    /**
     * my_get_headers
     *
     * Function for check url is exist
     *
     * @param	string	$url    url file
     * @return	ARRAY or FALSE
     */
    public function my_get_headers($url) {
        $url_info = parse_url($url);
        if (isset($url_info['scheme']) && $url_info['scheme'] == 'https') {
            $port = 443;
            $fp = @fsockopen('ssl://' . $url_info['host'], $port, $errno, $errstr, 10);
        } else {
            $port = isset($url_info['port']) ? $url_info['port'] : 80;
            $fp = @fsockopen($url_info['host'], $port, $errno, $errstr, 10);
        }
        if ($fp) {
            $headers = array();
            stream_set_timeout($fp, 10);
            $head = "HEAD " . @$url_info['path'] . "?" . @$url_info['query'];
            $head .= " HTTP/1.0\r\nHost: " . @$url_info['host'] . "\r\n\r\n";
            @fputs($fp, $head);
            while (!feof($fp)) {
                if ($header = trim(fgets($fp, 1024))) {
                    $sc_pos = strpos($header, ':');
                    if ($sc_pos === false) {
                        $headers['status'] = $header;
                    } else {
                        $label = substr($header, 0, $sc_pos);
                        $value = substr($header, $sc_pos + 1);
                        $headers[strtolower($label)] = trim($value);
                    }
                }
            }
            return $headers;
        } else {
            return false;
        }
    }

    /**
     * is_url_exist
     *
     * Function for check url is exist
     *
     * @param	string	$url    url file
     * @return	TRUE or FALSE
     */
    public function is_url_exist($url) {
        $headers = $this->my_get_headers($url);
        if(isset($headers["status"])){
            if ($headers !== FALSE && (@stripos($headers["status"], '200') || stripos($headers["status"], '301') || stripos($headers["status"], '302'))) {
                return TRUE;
            } else {
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }

    /**
     * urlencode
     *
     * Function for url encode
     *
     * @param	string	$url    url
     * @return	string
     */
    public function urlencode($url) {
        return str_replace('%2F', '/', urlencode($url));
    }

    /**
     * getFBComments
     *
     * Function for get facebook comments code from settings
     *
     * @param	string	$url    page url for show comment
     * @param	int	$limit  comment show limit
     * @param	string	$sort   comment sort ("social", "reverse_time", or "time".)
     * @param	string	$lang   language code from session
     * @return	string or FALSE if not have fbapp_id
     */
    public function getFBComments($url, $limit, $sort, $lang) {
        $html = '';
        $config = $this->load_config();
        if ($config->fbapp_id && $url && $limit && $sort && $lang) {
            $html.= '<div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/' . $lang . '_' . strtoupper($this->getCountryCode($lang)) . '/sdk.js#xfbml=1&version=v2.8&appId=' . $config->fbapp_id . '";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, \'script\', \'facebook-jssdk\'));</script>
            <div class="fb-comments" data-href="' . $url . '" data-width="100%" data-numposts="' . $limit . '" data-order-by="' . $sort . '"></div>' . "\n";
            return $html;
        } else {
            return FALSE;
        }
    }

    /**
     * createAsCopy
     *
     * Function for create new content as copy
     *
     * @param	string	$table  for database table
     * @param	array	$data   for all data with array into database
     * @return	TRUE or FALSE   if not insert
     */
    public function insertAsCopy($table, $data = array()) {
        if($table && is_array($data) && !empty($data)){
            $this->db->set('timestamp_create', 'NOW()', FALSE);
            $this->db->set('timestamp_update', 'NOW()', FALSE);
            $this->db->insert($table, $data);
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /**
     * cleanEmailFormat
     *
     * Function for clean email format
     *
     * @param	string	$email  for email address input
     * @return	string
     */
    public function cleanEmailFormat($email){
        $search = array('&','/',';','\\','"',"'",'|',' ','{','}');
        $email = str_replace($search, '', $email);
        return $this->security->xss_clean($email);
    }
    
    /**
     * cleanOSCommand
     *
     * Function for clean any string with security (OS Command injection)
     *
     * @param	string	$string  for any string
     * @return	string
     */
    public function cleanOSCommand($string){
        $search = array('&','/',';','\\','"','|',"'",'{','}');
        $string = str_replace($search, '', $string);
        return $this->security->xss_clean($string);
    }
    
    /**
     * findFormsTag
     *
     * Function for find forms tag from content html
     *
     * @param	string	$content  for content html
     * @return	TRUE or FALSE
     */
    public function findFrmTag($content) {
        $txt_nonhtml = strip_tags($content);
        if (strpos($txt_nonhtml, '[?]{=forms:') !== false) {
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /**
     * load_bf_config
     *
     * Function for get settings from brute force login protection setting
     *
     * @return	Object or FALSE
     */
    public function load_bf_config() {
        $this->db->limit(1, 0);
        $query = $this->db->get('login_security_config');
        if ($query->num_rows() !== 0) {
            $row = $query->row();
            return $row;
        } else {
            return FALSE;
        }
    }
    
    /**
     * chkBFwhitelistIP
     *
     * Function for check the IP from whitelist
     *
     * @param	string	$ip_address  for ip address
     * @return	TRUE or FALSE
     */
    public function chkBFwhitelistIP($ip_address) {
        $ip_count = $this->countData('whitelist_ip', "ip_address = '".$ip_address."'");
        if($ip_count !== FALSE && $ip_count !== 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /**
     * chkBFblacklistIP
     *
     * Function for check the IP from whitelist
     *
     * @param	string	$ip_address  for ip address
     * @return	TRUE or FALSE
     */
    public function chkBFblacklistIP($ip_address) {
        $ip_count = $this->countData('blacklist_ip', "ip_address = '".$ip_address."'");
        if($ip_count !== FALSE && $ip_count !== 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /**
     * saveBFloginIP
     *
     * Function for automatic add the IP blacklist from brute force login protection
     * 
     * @param	string	$ip_address  for ip address
     * @param	string	$email  for email address
     */
    public function saveBFloginIP($ip_address, $email) {
        if(!$ip_address) $ip_address = $this->input->ip_address();
        $config = $this->load_bf_config();
        if($this->chkBFwhitelistIP($ip_address) === FALSE){
            $search_sql = "ip_address = '".$ip_address."' AND result = 'INVALID' AND timestamp_create >= DATE_SUB(NOW(),INTERVAL ".$config->bf_protect_period." MINUTE)";
            $ip_count = $this->countData('login_logs', $search_sql);
            if($ip_count !== FALSE  && $ip_count !== 0 && $ip_count > ($config->max_failure-1) && $this->chkBFblacklistIP($ip_address) === FALSE){
                $this->db->set('ip_address', $ip_address, TRUE);
                $this->db->set('note', 'Automatic add this IP from brute force', TRUE);
                $this->db->set('timestamp_create', 'NOW()', FALSE);
                $this->db->insert('blacklist_ip');
                $data = array(
                    'email_login' => $email,
                    'note' => 'Automatic add this IP from brute force',
                    'result' => 'IP_BANNED',
                );
                $this->db->set('user_agent', $this->input->user_agent(), TRUE);
                $this->db->set('ip_address', $this->input->ip_address(), TRUE);
                $this->db->set('timestamp_create', 'NOW()', FALSE);
                $this->db->insert('login_logs', $data);
            }
        }
    }
    
    /**
     * chkIPBaned
     *
     * Function for check the IP from blacklist
     *
     * @param	string	$email  for email address or NULL
     * @return	TRUE or FALSE
     */
    public function chkIPBaned($email = '') {
        $cur_ip = $this->input->ip_address();
        $this->saveBFloginIP($cur_ip, $email);
        if($this->chkBFblacklistIP($cur_ip) === TRUE){
            return TRUE;
        }else{
            return FALSE;
        }
    }

}
