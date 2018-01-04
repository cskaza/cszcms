<?php
/**
 * CSZ CMS
 *
 * An open source content management system
 *
 * Copyright (c) 2016 - 2017, Astian Foundation.
 *
 * Astian Develop Public License (ADPL)
 * 
 * This Source Code Form is subject to the terms of the Astian Develop Public
 * License, v. 1.0. If a copy of the APL was not distributed with this
 * file, You can obtain one at http://astian.org/about-ADPL
 * 
 * @author	CSKAZA
 * @copyright   Copyright (c) 2016 - 2017, Astian Foundation.
 * @license	http://astian.org/about-ADPL	ADPL License
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Csz_model extends CI_Model {
             
    function __construct() {
        parent::__construct();
        $this->load->database();
        if (CACHE_TYPE == 'file') {
            $this->load->driver('cache', array('adapter' => 'file', 'key_prefix' => EMAIL_DOMAIN . '_'));
        } else {
            $this->load->driver('cache', array('adapter' => CACHE_TYPE, 'backup' => 'file', 'key_prefix' => EMAIL_DOMAIN . '_'));
        }
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
        if (!$this->cache->get('getVersion'.$version_test)) {
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
            if($this->load_config()->pagecache_time == 0){
                $cache_time = 1;
            }else{
                $cache_time = $this->load_config()->pagecache_time;
            }
            $this->cache->save('getVersion'.$version_test, $version, ($cache_time * 60));
            unset($version, $con_version, $con_release, $cache_time);
        }
        return $this->cache->get('getVersion'.$version_test);
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
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set("pcre.recursion_limit", "16777");
        }
        if(ini_get('allow_url_fopen')){
            if (stripos($url, 'https://') !== FALSE) {
                $default_opts = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    )
                );
                stream_context_set_default($default_opts);
            }
            $file = fopen($url, 'rb') or die("Can't open file");
            if (!$file) {
                fclose($file);
                unset($url,$newfname,$newf,$file);
                return FALSE;
            } else {
                $newf = fopen($newfname, 'wb') or die("Can't create file");
                if ($newf) {
                    while (!feof($file)) {
                        fwrite($newf, fread($file, 1024 * 1024 * 100), 1024 * 1024 * 100); /* 100MB */
                    }
                    fclose($newf);
                }
                fclose($file);
            }
        }else{
            $ch = curl_init($url);
            $newf = fopen($newfname, 'wb') or die("Can't create file");
            if(stripos($url, 'https://') !== FALSE){
                curl_setopt($ch, CURLOPT_CAINFO, APPPATH . 'cacert.pem');
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            }
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_FILE, $newf);
            $result = curl_exec($ch);
            fclose($newf);
            if($result === false) {
                log_message('error', 'Unable to perform the request : ' . curl_error($ch) . ' ['.$url.']');
                return FALSE;
            }
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
     * @param	string|array	$orderby   Order by field or NULL
     * @param	string	$sort   asc or desc or NULL 
     * @param	string	$join_db   Table to join or NULL 
     * @param	string	$join_where   Join condition or NULL 
     * @param	string	$join_type   Join type ('LEFT', 'RIGHT', 'OUTER', 'INNER', 'LEFT OUTER', 'RIGHT OUTER') or NULL 
     * @return	number or FALSE
     */
    public function countData($table, $search_sql = '', $groupby = '', $orderby = '', $sort = '', $join_db = '', $join_where = '', $join_type = '') {
        $this->db->select('*');
        if($join_db && $join_where){
            $this->db->join($join_db, $join_where, $join_type);
        }
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
        if(is_array($orderby)){
            foreach ($orderby as $value) {
                $this->db->order_by($value, $sort);
            }
        }else{
            if ($orderby && $sort) {
                $this->db->order_by($orderby, $sort);
            }elseif($orderby){
                $this->db->order_by($orderby);
            }
        }
        $query = $this->db->get($table);
        if (!empty($query)) {
            return $query->num_rows();
        } else {
            return FALSE;
        }
        unset($query);        
    }

    /**
     * getCurPages
     *
     * Function for get current page
     *
     * @return	String
     */
    public function getCurPages() {
        $pageURL = '';
        $totSegments = $this->uri->total_segments();
        if (!is_numeric($this->uri->segment($totSegments))) {
            $pageURL = $this->uri->segment($totSegments);
        } else if (is_numeric($this->uri->segment($totSegments))) {
            $pageURL = $this->uri->segment($totSegments - 1);
        }
        if ($pageURL == '') {
            $defaultpage = $this->getDefualtPage($this->session->userdata('fronlang_iso'));
            if ($defaultpage !== FALSE) {
                $pageURL = $defaultpage;
            } else {
                $pageURL = $this->getDefualtPage($this->getDefualtLang());
            }
        }
        return str_replace(array('.php','.html'), '', strtolower($pageURL));
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
     * @param	integer	$limit   Limit the result. Default is 0
     * @param	string|array	$orderby   Order by field or NULL 
     * @param	string	$sort   asc or desc or NULL 
     * @param	string	$groupby   Group by field or NULL 
     * @param	string	$join_db   Table to join or NULL 
     * @param	string	$join_where   Join condition or NULL  
     * @param	string	$join_type   Join type ('LEFT', 'RIGHT', 'OUTER', 'INNER', 'LEFT OUTER', 'RIGHT OUTER') or NULL
     * @return	Object or FALSE
     */
    public function getValue($sel_field = '*', $table, $where_field, $where_val, $limit = 0, $orderby = '', $sort = '', $groupby = '', $join_db = '', $join_where = '', $join_type = '') {
        $this->db->select($sel_field);
        if($join_db && $join_where){
            $this->db->join($join_db, $join_where, $join_type);
        }
        if($where_field || $where_val){
            if (is_array($where_field) && is_array($where_val)) {
                for ($i = 0; $i < count($where_field); $i++) {
                    $this->db->where($where_field[$i], $where_val[$i]);
                }
            } else if(is_array($where_field) && !is_array($where_val)) {
                foreach ($where_field as $value) {
                    $this->db->where($value);
                }
            } else {
                if($where_val){
                    $this->db->where($where_field, $where_val);
                }else{
                    $this->db->where($where_field);
                }
            }
        }
        if ($groupby) {
            $this->db->group_by($groupby);
        }
        if(is_array($orderby)){
            foreach ($orderby as $value) {
                $this->db->order_by($value, $sort);
            }
        }else{
            if ($orderby && $sort) {
                $this->db->order_by($orderby, $sort);
            }elseif($orderby){
                $this->db->order_by($orderby);
            }
        }
        if ($limit) {
            $this->db->limit($limit, 0);
        }
        $query = $this->db->get($table);
        if (!empty($query)) {
            if ($query->num_rows() !== 0) {
                if ($query->num_rows() === 1) {
                    return $query->first_row();
                } else {
                    return $query->result();
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
        unset($query, $row);       
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
     * @param	integer	$limit   Limit the result. Default is 0
     * @param	string|array	$orderby   Order by field or NULL 
     * @param	string	$sort   asc or desc or NULL 
     * @param	string	$groupby   Group by field or NULL  
     * @param	string	$join_db   Table to join or NULL 
     * @param	string	$join_where   Join condition or NULL  
     * @param	string	$join_type   Join type ('LEFT', 'RIGHT', 'OUTER', 'INNER', 'LEFT OUTER', 'RIGHT OUTER') or NULL
     * @param	bool	$onlyone   TRUE for get only one result with out loop, FALSE get result with loop
     * @return	Array or FALSE
     */
    public function getValueArray($sel_field = '*', $table, $where_field, $where_val, $limit = 0, $orderby = '', $sort = '', $groupby = '', $join_db = '', $join_where = '', $join_type = '', $onlyone = FALSE) {
        $this->db->select($sel_field);
        if($join_db && $join_where){
            $this->db->join($join_db, $join_where, $join_type);
        }
        if($where_field || $where_val){
            if (is_array($where_field) && is_array($where_val)) {
                for ($i = 0; $i < count($where_field); $i++) {
                    $this->db->where($where_field[$i], $where_val[$i]);
                }
            } else if(is_array($where_field) && !is_array($where_val)) {
                foreach ($where_field as $value) {
                    $this->db->where($value);
                }
            } else {
                if($where_val){
                    $this->db->where($where_field, $where_val);
                }else{
                    $this->db->where($where_field);
                }
            }
        }
        if ($groupby) {
            $this->db->group_by($groupby);
        }
        if(is_array($orderby)){
            foreach ($orderby as $value) {
                $this->db->order_by($value, $sort);
            }
        }else{
            if ($orderby && $sort) {
                $this->db->order_by($orderby, $sort);
            }elseif($orderby){
                $this->db->order_by($orderby);
            }
        }
        if ($limit) {
            $this->db->limit($limit, 0);
        }
        $query = $this->db->get($table);
        if (!empty($query)) {
            if ($query->num_rows() !== 0) {
                if ($onlyone === TRUE && $query->num_rows() === 1) {
                    return $query->first_row('array');
                } else {
                    return $query->result_array();
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
        unset($query);    
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
        unset($query, $row);   
    }
    
    /**
     * getID
     *
     * Function for get id from db
     *
     * @param	string	$table    db table name
     * @param	string	$field_id_name    field id (primary key)
     * @param	string|array	$search_sql    search value
     * @return	int or FALSE
     */
    public function getID($table, $field_id_name, $search_sql) {
        $this->db->select($field_id_name);
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
            $this->db->limit(1, 0);
            $query = $this->db->get($table);
            if (!empty($query) && $query->num_rows() !== 0) {
                $row = $query->row();
                return $row->$field_id_name;
            } else {
                return FALSE;
            }
        }else{
            return FALSE;
        }
        unset($query, $row);
    }

    /**
     * load_config
     *
     * Function for get settings from settings table
     *
     * @return	Object or FALSE
     */
    public function load_config() {
        if (!$this->cache->get('config')) {
            $cache_time = 1;
            $this->db->limit(1, 0);
            $query = $this->db->get('settings');
            if (!empty($query) && $query->num_rows() !== 0) {
                $row = $query->row();
                $cache_time = $row->pagecache_time;
            } else {
                $row = FALSE;
            }
            if($cache_time == 0) $cache_time = 1;
            $this->cache->save('config', $row, ($cache_time * 60));
            unset($query, $row);
        }
        return $this->cache->get('config');
    }

    /**
     * getLang()
     *
     * Function for get admin language
     *
     * @return	String
     */
    function getLang() {
        if (!$this->cache->get('backendLang')) {
            $config = $this->load_config();
            $cache_time = $config->pagecache_time;
            if($cache_time == 0) $cache_time = 1;
            $this->cache->save('backendLang', $config->admin_lang, ($cache_time * 60));
            unset($cache_time, $config);
        }
        return $this->cache->get('backendLang');
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
        if (!empty($query) && $query->num_rows() !== 0) {
            $row = $query->row();
            return $row->country_iso;
        }else{
            return FALSE;
        }
        unset($query, $row);
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
        if (!empty($query) && $query->num_rows() !== 0) {
            $row = $query->row();
            return $row->page_url;
        }else{
            return FALSE;
        }
        unset($query, $row);
    }
    
    /**
     * getFirstPagesActive
     *
     * Private function for get first page active for default
     *
     * @return	String or FALSE if not found
     */
    private function getFirstPagesActive(){
        $this->db->where("active", '1');
        $this->db->limit(1, 0);
        $this->db->order_by('pages_id ASC');
        $query = $this->db->get('pages');
        if (!empty($query) && $query->num_rows() !== 0) {
            $row = $query->row();
            return $row->page_url;
        } else {
            return $this->getPageUrlFromID(1);
        }
        unset($query, $row);
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
        if(!$lang){ $lang = $this->getDefualtLang(); }
        $nav = $this->getValue('*', 'page_menu', "lang_iso = '" . $lang . "' AND active = '1' AND drop_page_menu_id = '0' AND position = '0'", '', 1, 'arrange', 'asc');
        if($nav !== FALSE){
            if($nav->pages_id){
                $page_url = $this->getPageUrlFromID($nav->pages_id);
                if ($page_url !== FALSE) {
                    return $page_url;
                } else {
                    return $this->getFirstPagesActive();
                }
            }else if(!$nav->pages_id && $nav->plugin_menu && $nav->plugin_menu != NULL){
                return 'plugin/' . $nav->plugin_menu;
            }else{
                return $this->getFirstPagesActive();
            }
        }else{
            $this->db->where("lang_iso = '" . $lang . "' AND active = '1'", '');
            $this->db->limit(1, 0);
            $this->db->order_by('pages_id ASC');
            $query = $this->db->get('pages');
            if (!empty($query) && $query->num_rows() !== 0) {
                return $query->row()->page_url;
            } else {
                return $this->getFirstPagesActive();
            }
        }
        unset($query);
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
        $this->db->order_by("arrange", "asc");
        $this->db->limit(1, 0);
        $query = $this->db->get('lang_iso');
        if (!empty($query) && $query->num_rows() !== 0) {
            $row = $query->row();
            return $row->lang_iso;
        }
        unset($query, $row);
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
        if(!empty($query) && $query->num_rows() !== 0){
            return $query->num_rows();
        }else{
            return 0;
        }
        unset($query);
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
        unset($set_lang_iso);
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
        $this->db->order_by("arrange", "asc");
        $query = $this->db->get('lang_iso');
        if (!empty($query) && $query->num_rows() !== 0) {
            $row = $query->result();
            return $row;
        } else {
            return FALSE;
        }
        unset($query, $row);
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
        if (!$this->cache->get('file_'.$this->encodeURL($pageurl))) {
            $this->db->where("page_url", $pageurl);
            $this->db->where("active", 1);
            $this->db->limit(1, 0);
            $query = $this->db->get('pages');
            if (!empty($query) && $query->num_rows() !== 0) {
                $row = $query->row();
            } else {
                $row = FALSE;
            }
            if($this->load_config()->pagecache_time == 0){
                $cache_time = 1;
            }else{
                $cache_time = $this->load_config()->pagecache_time;
            }
            $this->cache->save('file_'.$this->encodeURL($pageurl), $row, ($cache_time * 60));
            unset($query, $row);
        }
        return $this->cache->get('file_'.$this->encodeURL($pageurl));
    }

    /**
     * main_menu
     *
     * Function for load main menu
     *
     * @param	int	$drop_page_menu_id    1 = drop menu, 0 = main menu
     * @param	string	$lang    language code
     * @param	int	$position    menu position  0 = Top, 1 = Bottom
     * @param	bool	$backend    get value for backend, Default is FALSE
     * @return	Object or FALSE id not found
     */
    public function main_menu($drop_page_menu_id = 0, $lang = '', $position = 0, $backend = FALSE) {
        $this->db->where("drop_page_menu_id", $drop_page_menu_id);
        $this->db->where("position", $position);
        $this->db->where("lang_iso", $lang);
        if($backend === FALSE){
            $this->db->where("active", 1);
        }
        $this->db->order_by("arrange", "asc");
        $query = $this->db->get('page_menu');
        if (!empty($query) && $query->num_rows() !== 0) {
            $row = $query->result();
            return $row;
        } else {
            return FALSE;
        }
        unset($query, $row);
    }

    /**
     * getSocial
     *
     * Function for get social link
     * 
     * @param	bool	$activeonly    TRUE for get the social with active only, FALSE is get all data
     * @return	Object or FALSE id not found
     */
    public function getSocial($activeonly = TRUE) {
        ($activeonly) ? $cachename = 'getsocial_active' : $cachename = 'getsocial';        
        if (!$this->cache->get($cachename)) {
            $this->db->select("*");
            if($activeonly) $this->db->where("active", 1);
            $this->db->order_by("footer_social_id", "asc");
            $query = $this->db->get('footer_social');
            if (!empty($query) && $query->num_rows() !== 0) {
                $row = $query->result();
            } else {
                $row = FALSE;
            }
            ($this->load_config()->pagecache_time == 0) ? $cache_time = 1 : $cache_time = $this->load_config()->pagecache_time;
            $this->cache->save($cachename, $row, ($cache_time * 60));
            unset($query, $row, $activeonly);
        }
        return $this->cache->get($cachename);
    }

    /**
     * cszCopyright
     *
     * Function for show website footer
     * Please do not remove or change the fuction $this->Csz_admin_model->cszCopyright()
     *
     */
    public function cszCopyright($copyright_txt = '') {
        if(!$copyright_txt) {
            $copyright_txt = $this->Csz_admin_model->cszCopyright();
        }
        $row = $this->load_config();
        $html = '<span class="copyright">' . str_replace(array('%YEAR%', '%YEAR', '%Y%', '%y%'), date('Y'), $row->site_footer) . '</span>
                <small style="color:gray;">' . $copyright_txt . '</small>'; /* Please do not remove or change the fuction $this->Csz_admin_model->cszCopyright() */
        unset($row);
        return $html;
    }

    /**
     * coreCss
     *
     * Function for load core css and more css
     *
     * @param	string	$more_css    additional css (string type for single css file or text style only. If you have many css file please use array)
     * @param	bool	$more_include    for include the css file or FALSE
     * @return	String
     */
    public function coreCss($more_css = '', $more_include = TRUE) {
        $core_css = '<link href="' . $this->base_link(TRUE, FALSE).'/'. 'corecss.css" rel="stylesheet" type="text/css" />' . "\n";
        $core_css.= link_tag('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
        $core_css.= link_tag('https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.min.css');
        $core_css.= link_tag('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css');
        $core_css.= link_tag('assets/js/plugins/timepicker/bootstrap-timepicker.min.css');
        if (!empty($more_css)) {
            if($more_include !== FALSE){
                if (is_array($more_css)) {
                    foreach ($more_css as $value) {
                        if ($value) {
                            $core_css.= link_tag($value);
                        }
                    }
                } else {
                    $core_css.= link_tag($more_css);
                }
            }else{
                $more_css = str_replace(array('<style type="text/css">',"<style type='text/css'>",'<style>','</style>'), '', $more_css);
                $core_css.= '<style type="text/css">'.$more_css.'</style>';
            }
        }
        return $core_css;
    }

    /**
     * coreJs
     *
     * Function for load core js and more js
     *
     * @param	string	$more_js    additional js (string type for single js file or text style only. If you hve many js file please use array)
     * @param	bool	$more_include    for include the js file or FALSE
     * @return	String
     */
    public function coreJs($more_js = '', $more_include = TRUE) {
        $core_js = '<script type="text/javascript" src="' . $this->base_link(TRUE, FALSE).'/'. 'corejs.js"></script>';
        $core_js.= '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.5/jquery.lazy.min.js"></script>';
        $core_js.= '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>';
        $core_js.= '<script type="text/javascript" src="' . $this->base_link(TRUE).'/'. 'assets/js/plugins/timepicker/bootstrap-timepicker.min.js"></script>';
        $core_js.= '<script type="text/javascript">$(function(){$(".lazy").lazy();$(".select2").select2()});$("#sel-chkbox-all").change(function(){$(".selall-chkbox").prop("checked",$(this).prop("checked"))});$(".timepicker").timepicker({minuteStep:1,showMeridian:false,defaultTime:false,disableFocus:true});</script>';
        if ($this->getFBsdk() !== FALSE) { $core_js.= $this->getFBsdk(); }
        if (!empty($more_js)) {
            if($more_include !== FALSE){
                if (is_array($more_js)) {
                    foreach ($more_js as $value) {
                        if ($value) {
                            $core_js.= '<script type="text/javascript" src="' . $value . '"></script>';
                        }
                    }
                } else {
                    $core_js.= '<script type="text/javascript" src="' . $more_js . '"></script>';
                }
            }else{
                $more_js = str_replace(array('<script type="text/javascript">',"<script type='text/javascript'>",'<script>','</script>'), '', $more_js);
                $core_js.= '<script type="text/javascript">'.str_replace('<script ', '</script><script ', $more_js).'</script>';
            }
        }
        if ($this->getFBChat() !== FALSE) { $core_js.= $this->getFBChat(); }
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
     * @param	string	$img_path    page article image url path without base_url() . 'photo/'
     * @param	string	$more_meta    more meta tag text
     * @return	String
     */
    public function coreMetatags($desc_txt, $keywords, $title, $img_path = '', $more_meta = '') {
        $config = $this->load_config();
        $og_image = '';
        $og_type = '';
        if ($img_path) {
            $og_image = base_url() . 'photo/' . str_replace(base_url() . 'photo/', '', $img_path);
            if (strpos($img_path, 'article') !== false) {
                $og_type = 'article'; 
            }else{
                $og_type = 'website';
            }
        } else {
            $og_type = 'website';
            if ($config->og_image) {
                $og_image = base_url() . 'photo/logo/' . $config->og_image;
            } else {
                if ($config->site_logo) {
                    $og_image = base_url() . 'photo/logo/' . $config->site_logo;
                } else {
                    $og_image = base_url() . 'photo/no_image.png';
                }
            }
        }
        $meta = array(
            array('name' => 'content-language', 'content' => $this->session->userdata('fronlang_iso'), 'type' => 'equiv'),
            array('name' => 'description', 'content' => $desc_txt),
            array('name' => 'keywords', 'content' => $keywords),
            array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1'),
            array('name' => 'author', 'content' => $config->site_name),
            array('name' => 'generator', 'content' => $this->Csz_admin_model->cszGenerateMeta()),
            array('name' => 'X-UA-Compatible', 'content' => 'IE=edge', 'type' => 'equiv'),
            array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
            array('name' => 'og:site_name', 'content' => $config->site_name, 'type' => 'property'),
            array('name' => 'og:title', 'content' => $title, 'type' => 'property'),
            array('name' => 'og:type', 'content' => $og_type, 'type' => 'property'),
            array('name' => 'og:description', 'content' => $desc_txt, 'type' => 'property'),
            array('name' => 'og:url', 'content' => $this->base_link(). '/' . $this->uri->uri_string(), 'type' => 'property'),
            array('name' => 'og:image', 'content' => $og_image, 'type' => 'property'),
            array('name' => 'og:locale', 'content' => $this->session->userdata('fronlang_iso') . '_' . strtoupper($this->getCountryCode($this->session->userdata('fronlang_iso'))), 'type' => 'property'),
            array('name' => 'twitter:card', 'content' => 'summary'),
            array('name' => 'twitter:title', 'content' => $title),
            array('name' => 'twitter:description', 'content' => $desc_txt),
            array('name' => 'twitter:image', 'content' => $og_image),
        );
        $return_meta = meta($meta);
        $return_meta.= '<link rel="canonical" href="' . $this->base_link(). '/' . $this->uri->uri_string() . '" />' . "\n";
        $return_meta.= '<link rel="dns-prefetch" href="//cdnjs.cloudflare.com">';
        $return_meta.= '<link rel="dns-prefetch" href="//maps.googleapis.com">';
        $return_meta.= '<link rel="alternate" type="application/rss+xml" title="'.$config->site_name.' &raquo; Article Feed" href="'.$this->base_link(). '/plugin/article/rss/" />';
        $return_meta.= '<link rel="alternate" type="application/rss+xml" title="'.$config->site_name.' &raquo; Gallery Feed" href="'.$this->base_link(). '/plugin/gallery/rss/" />';
        if ($config->fbapp_id) {
            $return_meta.= '<meta property="fb:app_id" content="' . $config->fbapp_id . '" />' . "\n";
        }
        if ($config->facebook_page_id) {
            $return_meta.= '<meta property="fb:pages" content="' . $config->facebook_page_id . '" />' . "\n";
        }
        $gplus = $this->Csz_model->getValue('social_url', 'footer_social', "social_name = 'google' AND active = '1'", '', 1);
        if($gplus !== FALSE && $gplus->social_url){
            $return_meta.= '<link href="' . $gplus->social_url . '" rel="publisher"/>' . "\n";
        }
        $twitter = $this->Csz_model->getValue('social_url', 'footer_social', "social_name = 'twitter' AND active = '1'", '', 1);
        if($twitter !== FALSE && $twitter->social_url){ $twitter_username = basename($twitter->social_url);}
        if($twitter !== FALSE && $twitter->social_url && $twitter_username){
            $return_meta.= '<meta name="twitter:site" content="@' . $twitter_username . '"/>' . "\n";
            $return_meta.= '<meta name="twitter:creator" content="@' . $twitter_username . '"/>' . "\n";
        }
        if($more_meta){
            $return_meta.= $more_meta . "\n";
        }
        unset($config,$og_image,$og_type,$img_path,$meta,$gplus,$twitter,$twitter_username,$more_meta,$desc_txt,$title,$keywords);
        return $return_meta;
    }

    /**
     * rw_link
     *
     * Function for url rewrite from string
     *
     * @param	string	$val    Title name or string
     * @param	int	$char_limit    Charector limit default is 2048
     * @return	String
     */
    public function rw_link($val, $char_limit = 2048) {
        $this->load->helper("text");
        $val1 = convert_accented_characters(url_title($val, '-', TRUE));
        $val2 = character_limiter($val1, $char_limit); /* cut char limit 2048 char */
        unset($char_limit,$val,$val1);
        return $val2;
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
        $ori_content = $this->bannerInHtml($ori_content);
        $ori_content = $this->carouselInHtml($ori_content);
        $ori_content = $this->widgetInHtml($ori_content);
        $ori_content = $this->formTagToHTML($ori_content);
        $ori_content = $this->frmNameInHtml($ori_content, $url_segment);
        return $ori_content;
    }
    
    /**
     * formTagToHTML
     *
     * Function for find form tag with only post 
     * [?startform_post:form_name{action_url}][/?endform] AND [?startform_get:form_name{action_url}][/?endform]
     * Action url without base url Ex. [?startform_post:formtest{member/login/check}] Your html form [/?endform]
     * And set the current url into session (cszfrm_cururl) for use to return page. 
     *
     * @param	string	$content    Original content
     * @return	string
     */
    public function formTagToHTML($content) { /* Find the banner in content */
        $txt_nonhtml = strip_tags($content);
        if (strpos($txt_nonhtml, '[?startform_') !== false && strpos($txt_nonhtml, '[/?endform]') !== false) {
            $this->load->helper('form');
            $output_array = array();
            preg_match("/\[\?startform_(.*?)\:(.*?)\{(.*?)\}\]/", $txt_nonhtml, $output_array);
            $html = '';
            if($this->session->flashdata('formtag_error_message')){
                $html = '<div class="text-center">'.$this->session->flashdata('formtag_error_message').'</div><br>';
            }
            if(!empty($output_array) && strtolower($output_array[1]) == 'post'){
                $content = $html.str_replace($output_array[0], form_open_multipart($output_array[3], ' name="'.$output_array[2].'"'), $content);
            }else if(!empty($output_array) && strtolower($output_array[1]) == 'get'){
                $content = $html.str_replace($output_array[0], form_open_multipart($output_array[3], ' name="'.$output_array[2].'" method="get"'), $content);
            }
            $content1 = str_replace('[/?endform]', form_close(), $content);
            $content = str_replace(array('[textarea','[/textarea'), array('<textarea','</textarea'), $content1);
            $cururl = str_replace($this->base_link(). '/', '', current_url());
            $totSegments = $this->uri->total_segments();
            if (is_numeric($this->uri->segment($totSegments))) {
                $cururl = str_replace('/'.$this->uri->segment($totSegments), '', $cururl);
            }
            $sess_data = array('cszfrm_cururl' => $cururl);
            $this->session->set_userdata($sess_data);
            unset($output_array, $cururl, $totSegments, $sess_data);
        }
        unset($txt_nonhtml);
        return $content;
    }
    
    /**
     * bannerInHtml
     *
     * Function for find banner tag
     *
     * @param	string	$content    Original content
     * @return	string
     */
    public function bannerInHtml($content) { /* Find the banner in content */
        $txt_nonhtml = strip_tags($content);
        if (strpos($txt_nonhtml, '[?]{=banner:') !== false) {
            $txt_nonline = str_replace(PHP_EOL, '', $txt_nonhtml);
            $array = explode("[?]", $txt_nonline);
            if (!empty($array)) {
                foreach ($array as $val) {
                    if (strpos($val, '{=banner:') !== false) {
                        $rep_arr = array('{=banner:', '}');
                        $bid = str_replace($rep_arr, '', $val);
                        $content = $this->addBannerToHTML($content, $bid);
                    }
                }
            }
            unset($array);
        }
        unset($txt_nonhtml);
        return $content;
    }

    /**
     * addBannerToHTML
     *
     * Function for add banner into html
     *
     * @param	string	$content    Original content
     * @param	string	$id   banner id
     * @return	string
     */
    public function addBannerToHTML($content, $id) {
        if (!$this->cache->get('banner_'.$id)) {
            $this->db->where('NOW() BETWEEN start_date AND DATE_ADD(end_date, INTERVAL 1 DAY)', '', FALSE); /* For date range between start to end */
            $getBanner = $this->getValue('*', 'banner_mgt', "active = '1' AND banner_mgt_id = '" . $id . "'", '', 1);
            if ($getBanner !== FALSE) {
                ($getBanner->img_path && $getBanner->img_path != NULL) ? $img = base_url() . 'photo/banner/' . $getBanner->img_path : $img = base_url() . 'photo/no_image.png';
                ($getBanner->nofollow && $getBanner->nofollow != NULL) ? $nofol = ' rel="nofollow external"' : $nofol = '';
                ($getBanner->width && $getBanner->width != NULL) ? $width = ' width="' . $getBanner->width . '"' : $width = '';
                ($getBanner->height && $getBanner->height != NULL) ? $height = ' height="' . $getBanner->height . '"' : $height = '';
                $html = '<a target="_blank" href="' . $this->base_link(). '/banner/' . $getBanner->banner_mgt_id . '" title="' . $getBanner->name . '"'.$nofol.'><img class="lazy img-responsive img-thumbnail" data-src="' . $img . '" alt="' . $getBanner->name . '"' . $width . $height . '"></a>';
                
            }else{
                $html = '[?]{=banner:' . $id . '}[?]';
            }
            if($this->load_config()->pagecache_time == 0){
                $cache_time = 1;
            }else{
                $cache_time = $this->load_config()->pagecache_time;
            }
            $this->cache->save('banner_'.$id, $html, ($cache_time * 60));
            unset($html, $cache_time, $getBanner);
        }
        return str_replace('[?]{=banner:' . $id . '}[?]', $this->cache->get('banner_'.$id), $content);
    }

    /**
     * carouselInHtml
     *
     * Function for find carousel tag
     *
     * @param	string	$content    Original content
     * @return	string
     */
    public function carouselInHtml($content) { /* Find the carousel in content */
        $txt_nonhtml = strip_tags($content);
        if (strpos($txt_nonhtml, '[?]{=carousel:') !== false) {
            $txt_nonline = str_replace(PHP_EOL, '', $txt_nonhtml);
            $array = explode("[?]", $txt_nonline);
            if (!empty($array)) {
                foreach ($array as $val) {
                    if (strpos($val, '{=carousel:') !== false) {
                        $rep_arr = array('{=carousel:', '}');
                        $carousel_id = str_replace($rep_arr, '', $val);
                        $content = $this->addCarouselToHTML($content, $carousel_id);
                    }
                }
            }
            unset($array);
        }
        unset($txt_nonhtml);
        return $content;
    }

    /**
     * addCarouselToHTML
     *
     * Function for add carousel into html
     *
     * @param	string	$content    Original content
     * @param	string	$id   carousel id
     * @return	string
     */
    public function addCarouselToHTML($content, $id) {
        if (!$this->cache->get('carousel_'.$id)) {
            $getCarousel = $this->getValue('*', 'carousel_widget', "active = '1' AND carousel_widget_id = '" . $id . "'", '', 1);
            $html = '[?]{=carousel:' . $id . '}[?]';
            if ($getCarousel !== FALSE) {
                $getPhoto = $this->getValueArray('*', 'carousel_picture', "carousel_widget_id = '" . $getCarousel->carousel_widget_id . "'", '', '', 'arrange', 'ASC');               
                $html = '';
                if($getPhoto !== FALSE){
                    $i = 0;
                    $li_html = '';
                    $item_html = '';
                    $photo_path = base_url() . 'photo/carousel/';
                    foreach ($getPhoto as $value) {
                        $active = '';
                        $class_active = '';
                        if($i == 0){
                            $active = ' active';
                            $class_active = ' class="active"';
                        }
                        if($value['caption'] && $value['caption'] != NULL){
                            $caption = '<div class="carousel-caption">'.$value['caption'].'</div>';
                            $alt_img = ' alt="'.$value['caption'].'"';
                        }else{
                            $caption = '';
                            $alt_img = ' alt="'.$getCarousel->name.'"';
                        }
                        if($value['carousel_type'] == 'multiimages' && $value['file_upload'] && $value['file_upload'] != NULL){
                            $item_add = '<img src="'.$photo_path.$value['file_upload'].'" class="img-responsive" width="100%"'.$alt_img.'>';
                        }else if($value['carousel_type'] == 'multiimages' && $value['photo_url'] && $value['photo_url'] != NULL){
                            $item_add = '<img src="'.$value['photo_url'].'" class="img-responsive" width="100%"'.$alt_img.'>';
                        }else if($value['carousel_type'] == 'youtubevideos' && $value['youtube_url']){
                            $youtube_script_replace = array("http://", "https://", "www.youtube.com/watch?v=", "m.youtube.com/watch?v=", "youtu.be/", "www.youtube.com/embed/", "m.youtube.com/embed/");
                            $youtube_value = str_replace($youtube_script_replace, '', $value['youtube_url']);
                            $item_add = '<div class="embed-responsive embed-responsive-16by9" style="background-color: #000;"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$youtube_value.'" allowfullscreen="allowfullscreen" width="100%"></iframe></div>';
                        }
                        $li_html.= '<li data-target="#myCarousel-'.$getCarousel->carousel_widget_id.'" data-slide-to="'.$i.'"'.$class_active.'></li>';
                        $item_html.= '<div class="item'.$active.'"><div class="fill">'.$item_add.'</div>'.$caption.'</div>';
                        $i++;
                    }
                    $html = '<div id="myCarousel-'.$getCarousel->carousel_widget_id.'" class="carousel slide">';
                    $html.= '<ol class="carousel-indicators">';
                    $html.= $li_html;
                    $html.= '</ol><div class="carousel-inner">';
                    $html.= $item_html;
                    $html.= '</div><a class="left carousel-control" href="#myCarousel-'.$getCarousel->carousel_widget_id.'" data-slide="prev"><span class="icon-prev"></span></a><a class="right carousel-control" href="#myCarousel-'.$getCarousel->carousel_widget_id.'" data-slide="next"><span class="icon-next"></span></a>';
                    $html.= '</div>';
                }
            }
            if($this->load_config()->pagecache_time == 0){
                $cache_time = 1;
            }else{
                $cache_time = $this->load_config()->pagecache_time;
            }
            $this->cache->save('carousel_'.$id, $html, ($cache_time * 60));
            unset($html, $cache_time, $getCarousel, $getPhoto);
        }
        return str_replace('[?]{=carousel:' . $id . '}[?]', $this->cache->get('carousel_'.$id), $content);
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
                foreach ($array as $val) {
                    if (strpos($val, '{=widget:') !== false) {
                        $rep_arr = array('{=widget:', '}');
                        $wid_id = str_replace($rep_arr, '', $val);
                        $content = $this->addWidgetToHTML($content, $wid_id);
                    }
                }
            }
        }
        unset($array, $txt_nonline, $txt_nonhtml);
        return $content;
    }
    
    /**
     * getWidgetFromID
     *
     * Function for get widget from id
     *
     * @param	string	$wid_id   Widget id
     * @return	object or FALSE
     */
    public function getWidgetFromID($wid_id) {
        if (!$this->cache->get('widget_sql_'.md5($wid_id))) {
            $widget = $this->getValue('*', 'widget_xml', "active = '1' AND xml_url != '' AND limit_view != '0' AND (widget_xml_id = '" . $wid_id . "' OR widget_name = '" . $wid_id . "')", '', 1);            
            if($this->load_config()->pagecache_time == 0){
                $cache_time = 1;
            }else{
                $cache_time = $this->load_config()->pagecache_time;
            }
            $this->cache->save('widget_sql_'.md5($wid_id), $widget, ($cache_time * 60));
            unset($cache_time, $widget);
        }
        return $this->cache->get('widget_sql_'.md5($wid_id));
    }
    
    /**
     * replaceTagInWidget
     *
     * Function for check and replace tag in widget html
     *
     * @param	string  $html   html input
     * @param	object	$item   the item object get from xml
     * @return	string
     */
    public function replaceTagInWidget($html, $item) {
        $tags = array();
        preg_match_all("/{([^\s]+)}/", $html, $tags, PREG_SET_ORDER);
        if(!empty($tags)){
            $tag_r = array();
            $replace_r = array();
            foreach ($tags as $value) {
                $tag_r[] = $value[0];
                $item_name = $value[1];
                $replace_r[] = $item->$item_name;
            }
            $html = str_replace($tag_r, $replace_r, $html);
        }
        return $html;  
    }

    /**
     * addWidgetToHTML
     *
     * Function for add widget into html
     *
     * @param	string	$content    Original content
     * @param	string	$wid_id   Widget name
     * @return	string
     */
    public function addWidgetToHTML($content, $wid_id) {
        if (!$this->cache->get('widget_'.md5($wid_id))) {
            $getWidget = $this->getWidgetFromID($wid_id);
            if ($getWidget !== FALSE) {
                $html = str_replace('{widget_header_name}', $getWidget->widget_name, $getWidget->widget_open);
                if ($this->is_url_exist($getWidget->xml_url) !== FALSE) {
                    $xml_url = $this->get_contents_url($getWidget->xml_url);
                    if($xml_url !== FALSE){
                        $xml = simplexml_load_string($xml_url);
                        if ($xml !== FALSE) {
                            if ($xml->plugin[0]->null == 0) {
                                $i = 1;
                                foreach ($xml->plugin[0]->item as $item) {
                                    $html.= $this->replaceTagInWidget($getWidget->widget_content, $item);
                                    if ($i == $getWidget->limit_view) {
                                        break;
                                    }
                                    $i++;
                                }
                            } else {
                                $html.= '<h4 class="error">' . $this->getLabelLang('error_txt') . '</h4>';
                            }
                            $html.= str_replace(array('{main_url}', '{readmore_text}'), array($xml->plugin[0]->main_url, $this->getLabelLang('article_readmore_text')), $getWidget->widget_seemore);         
                        }else{
                            $html.= '<h4 class="error">' . $this->getLabelLang('error_txt') . '</h4>';
                        }
                        unset($xml);
                    }else{
                        $html.= '<h4 class="error">' . $this->getLabelLang('error_txt') . '</h4>';
                    }
                    unset($xml_url);
                }else{
                    $html.= '<h4 class="error">' . $this->getLabelLang('error_txt') . '</h4>';
                }
                $html.= $getWidget->widget_close;
            }else{
                $html = '[?]{=widget:' . $wid_id . '}[?]';
            }
            if($this->load_config()->pagecache_time == 0){
                $cache_time = 1;
            }else{
                $cache_time = $this->load_config()->pagecache_time;
            }
            $this->cache->save('widget_'.md5($wid_id), $html, ($cache_time * 60));
            unset($html, $cache_time, $getWidget);
        }
        return str_replace('[?]{=widget:' . $wid_id . '}[?]', $this->cache->get('widget_'.md5($wid_id)), $content);
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
                foreach ($array as $val) {
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
        $where_arr = array('form_name', 'active');
        $val_arr = array($frm_name, 1);
        $form_data = $this->getValue('*', 'form_main', $where_arr, $val_arr, 1);
        if ($form_data && $form_data !== FALSE) {
            $html_btn = '';
            $html = '';
            if($this->session->flashdata('formtag_error_message')){
                $html = '<div class="text-center">'.$this->session->flashdata('formtag_error_message').'</div><br>';
            }
            $action_url = $this->base_link(). '/formsaction/' . $form_data->form_main_id;
            $fiels_file_count = $this->Csz_admin_model->countTable('form_field', "form_main_id = '".$form_data->form_main_id."' AND field_type = 'file'");
            if($fiels_file_count !== FALSE && $fiels_file_count != 0 && ($form_data->form_enctype == NULL || empty($form_data->form_enctype))){
                $form_data->form_enctype = 'multipart/form-data';
            }
            unset($fiels_file_count);
            $html.= '<form action="' . $action_url . '" name="' . $frm_name . '" method="' . $form_data->form_method . '" enctype="' . $form_data->form_enctype . '" accept-charset="utf-8">';
            if ($this->config->item('csrf_protection') === TRUE && strpos($action_url, $this->config->base_url()) !== FALSE && !stripos($form_data->form_method, 'get')) {
                $html.= '<input type="hidden" name="'.$this->security->get_csrf_token_name().'" id="'.$this->security->get_csrf_token_name().'" value="' . $this->security->get_csrf_hash() . '">';
            }
            $cururl = str_replace($this->base_link(). '/', '', current_url());
            $totSegments = $this->uri->total_segments();
            if (is_numeric($this->uri->segment($totSegments))) {
                $cururl = str_replace('/'.$this->uri->segment($totSegments), '', $cururl);
            }
            $sess_data = array('cszfrm_cururl' => $cururl);
            $this->session->set_userdata($sess_data);
            $field_data = $this->getValueArray('*', 'form_field', 'form_main_id', $form_data->form_main_id, '', array('arrange','form_field_id'), 'asc');
            if($field_data && $field_data !== FALSE){
                foreach ($field_data as $field) {
                    if ($field['field_required']) {
                        $f_req = ' required="required"';
                        $star_req = ' <i style="color:red;">*</i>';
                    } else {
                        $f_req = '';
                        $star_req = '';
                    }
                    if ($field['field_type'] == 'email' || $field['field_type'] == 'password' || $field['field_type'] == 'text') {
                        $maxlength = ' maxlength="255"';
                    } else {
                        $maxlength = '';
                    }
                    if ($field['field_type'] == 'checkbox' || $field['field_type'] == 'email' || $field['field_type'] == 'file' || $field['field_type'] == 'password' || $field['field_type'] == 'radio' || $field['field_type'] == 'text') {
                        if ($field['field_type'] == 'file' && ($field['sel_option_val'] == NULL || empty($field['sel_option_val']))) {
                            $accept = ' accept=".jpg, .jpeg, .png, .gif, .pdf, .doc, .docx, .odt, .txt, .odg, .odp, .ods, .zip, .rar, .psv, .xls, .xlsx, .ppt, .pptx, .mp3, .wav, .mp4, .wma, .flv, .avi, .mov, .m4v, .wmv, .m3u, .pls"';
                        }else if ($field['field_type'] == 'file' && ($field['sel_option_val'] != NULL && $field['sel_option_val'])){
                            $accept = ' accept="' . $field['sel_option_val'] . '"';
                        }else{
                            $accept = '';
                        }
                        $html.= '<label class="control-label" for="' . $field['field_id'] . '">' . $field['field_label'] . $star_req . '</label>
                        <div class="controls">
                            <input type="' . $field['field_type'] . '" name="' . $field['field_name'] . '" value="' . $field['field_value'] . '" id="' . $field['field_id'] . '" class="' . $field['field_class'] . '" placeholder="' . $field['field_placeholder'] . '"' . $f_req . $maxlength . $accept . '/>
                        </div>';
                    } else if ($field['field_type'] == 'datepicker') {
                        if ($field['field_class']) {
                            $class = $field['field_class'] . ' form-datepicker';
                        } else {
                            $class = 'form-datepicker';
                        }
                        $html.= '<label class="control-label" for="' . $field['field_id'] . '">' . $field['field_label'] . $star_req . '</label>
                        <div class="input-group">
                            <input type="text" name="' . $field['field_name'] . '" value="' . $field['field_value'] . '" id="' . $field['field_id'] . '" class="' . $class . '" placeholder="' . $field['field_placeholder'] . '"' . $f_req . '/>
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>';
                    } else if ($field['field_type'] == 'timepicker') {
                        if ($field['field_class']) {
                            $class = $field['field_class'] . ' timepicker';
                        } else {
                            $class = 'timepicker';
                        }
                        $html.= '<label class="control-label" for="' . $field['field_id'] . '">' . $field['field_label'] . $star_req . '</label>
                        <div class="input-group bootstrap-timepicker timepicker">
                            <input type="text" name="' . $field['field_name'] . '" value="' . $field['field_value'] . '" id="' . $field['field_id'] . '" class="' . $class . '" placeholder="' . $field['field_placeholder'] . '"' . $f_req . '/>
                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        </div>';
                    } else if ($field['field_type'] == 'selectbox') {
                        $opt_html = '';
                        if ($field['sel_option_val']) {
                            $opt_arr = explode(",", $field['sel_option_val']);
                            foreach ($opt_arr as $opt) {
                                list($val, $show) = explode("=>", $opt);
                                $opt_html.= '<option value="' . trim($val) . '">' . trim($show) . '</option>';
                            }
                        }
                        ($field['field_placeholder']) ? $placehol = '<option value="">' . $field['field_placeholder'] . '</option>' : $placehol = '';
                        $html.= '<label class="control-label" for="' . $field['field_id'] . '">' . $field['field_label'] . $star_req . '</label>
                                <select id="' . $field['field_id'] . '" name="' . $field['field_name'] . '" class="' . $field['field_class'] . '"' . $f_req . '>
                                    ' . $placehol . '
                                    ' . $opt_html . '
                                </select>';
                    } else if ($field['field_type'] == 'textarea') {
                        $html.= '<label class="control-label" for="' . $field['field_id'] . '">' . $field['field_label'] . $star_req . '</label>
                        <div class="controls">
                            <textarea name="' . $field['field_name'] . '" id="' . $field['field_id'] . '" class="' . $field['field_class'] . '" placeholder="' . $field['field_placeholder'] . '"' . $f_req . ' rows="4">' . $field['field_value'] . '</textarea>
                        </div>';
                    } else if ($field['field_type'] == 'button' || $field['field_type'] == 'reset' || $field['field_type'] == 'submit') {
                        $html_btn.= '<input type="' . $field['field_type'] . '" name="' . $field['field_name'] . '" value="' . $field['field_value'] . '" id="' . $field['field_id'] . '" class="' . $field['field_class'] . '" placeholder="' . $field['field_placeholder'] . '"' . $f_req . '/> ';
                    } else if ($field['field_type'] == 'label') {
                        $html.= '<label class="' . $field['field_class'] . '" id="' . $field['field_id'] . '" name="' . $field['field_name'] . '">' . $field['field_label'] . $star_req . '</label><br>';
                    }
                }
            }
            if ($form_data->captcha) {
                $html.= '<br>'.$this->showCaptcha();
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
        $path = $this->config->item('log_path');
        $logs_path = ($path == '') ? APPPATH . 'logs/' : $path;
        $handle = opendir($logs_path);
        while (($file = readdir($handle)) !== FALSE) {
            //Leave the directory protection alone
            if ($file != '.htaccess' && $file != 'index.html') {
                @unlink($logs_path . '/' . $file);
            }
        }
        closedir($handle);
        $this->clear_uri_cache($this->config->item('base_url').urldecode('admin'));
    }

    /**
     * clear_all_session
     *
     * Function for clear all session file
     *
     */
    public function clear_all_session() {
        $this->db->empty_table('ci_sessions');
        $this->clear_uri_cache($this->config->item('base_url').urldecode('admin'));
    }

    /**
     * clear_all_cache
     *
     * Function for clear all cache file
     *
     */
    public function clear_all_cache() {
        $this->cache->clean();
        $path = $this->config->item('cache_path');
        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;
        $handle = opendir($cache_path);
        while (($file = readdir($handle)) !== FALSE) {
            //Leave the directory protection alone
            if ($file != '.htaccess' && $file != 'index.html') {
                $this->clear_file_cache($file);
            }
        }
        closedir($handle);
        $cache_path = APPPATH . 'db_cache/';
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
     * clear_file_cache
     *
     * Function for clear all cache file
     *
     * @param	string	$filename    File name
     * @param	bool	$search    TRUE for search filename with *, FALSE is not
     */
    public function clear_file_cache($filename, $search = FALSE) {
        $path = $this->config->item('cache_path');
        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;
        if($search === FALSE){        
            @unlink($cache_path . '/' . $filename);
        }else{
            @array_map('unlink', glob($cache_path.'/'.$filename));
        }
        $this->cache->clean();
    }

    /**
     * clear_uri_cache
     *
     * Function for clear uri cache file
     *
     * @param	string	$uri    page uri or NULL for remove the base_url cache
     */
    public function clear_uri_cache($uri = '') {
        $path = $this->config->item('cache_path');
        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;
        if($uri) @unlink($cache_path . '/' . md5($uri));
        $this->cache->clean();
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
        $result = $this->get_contents_url($url);
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
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set("pcre.recursion_limit", "16777");
        }
        $config = $this->load_config();
        $respone = '';
        if ($config->googlecapt_active && $config->googlecapt_sitekey && $config->googlecapt_secretkey) {
            $recaptcha = $this->input->post_get('g-recaptcha-response', TRUE);
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
        unset($res);
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
        $hl = '';
        if ($config->googlecapt_active && $config->googlecapt_sitekey && $config->googlecapt_secretkey) {
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
            $html.= '<div class="g-recaptcha" data-sitekey="' . $config->googlecapt_sitekey . '"></div>';
            if (!$this->cache->get('showCaptcha_' . $hl)) {
                ($config->pagecache_time == 0) ? $cache_time = 1 : $cache_time = $config->pagecache_time;
                $this->cache->save('showCaptcha_' . $hl, $html, ($cache_time * 60));
                unset($html, $config, $cache_time);
            }
            return $this->cache->get('showCaptcha_' . $hl);
        }
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
     * saveBannerStats
     *
     * Function for save banner stats
     *
     * @param	string	$banner_mgt_id    banner id for save into database
     */
    public function saveBannerStats($banner_mgt_id) {
        $this->db->set('banner_mgt_id', $banner_mgt_id, TRUE);
        $this->db->set('ip_address', $this->input->ip_address(), TRUE);
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->insert('banner_statistic');
    }
    
    /**
     * pwdEncypt
     *
     * Function for encyption the password with password_hash (BCRYPT)
     *
     * @param	string	$password    password
     * @return	string
     */
    public function pwdEncypt($password) {
        $options = array('cost' => 12);
        return password_hash($password, PASSWORD_BCRYPT, $options);
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
        $return = array();
        $this->db->select("*");
        $this->db->where("email", $email);
        if($typecondition){
            $this->db->where($typecondition);
        }
        $this->db->limit(1, 0);
        $query = $this->db->get("user_admin");
        $result = $query->row();
        if(!empty($result)){
            if(password_verify($password, $result->password)){
                $return['row'] = $result;
                $return['num_rows'] = $query->num_rows();
            }else{
                $return['row'] = '';
                $return['num_rows'] = 0;
            }
        }else{
            $return['row'] = '';
            $return['num_rows'] = 0;
        }
        unset($query);
        return $return;
    }

    /**
     * memberLogin
     *
     * Function for check the email and password
     *
     * @param	string	$email    email address
     * @param	string	$password    password
     * @param	bool	$backend    TRUE for login on backend
     * @return	string
     */
    public function login($email, $password, $backend = FALSE) {
        if ($this->Csz_model->chkCaptchaRes() == '') {
            return 'CAPTCHA_WRONG';
        } else {
            if($this->chkIPBaned($email) === FALSE){
                $data = array();
                if($backend !== FALSE){
                    $query = $this->chkPassword($email, $password, "user_type != 'member' AND active = '1'");
                    $data['admin_logged_in'] = TRUE;
                }else{
                    $query = $this->chkPassword($email, $password);
                    $data['admin_logged_in'] = FALSE;
                }
                if ($query['num_rows'] !== 0 && !empty($query['row'])) {
                    $rows = $query['row'];
                    if($rows->active == 1){
                        $session_id = session_id();
                        $this->db->set('session_id', $session_id, TRUE);
                        $this->db->set('timestamp_login', 'NOW()', FALSE);
                        $this->db->where('user_admin_id', $rows->user_admin_id);
                        $this->db->update('user_admin');
                        $data['user_admin_id'] = $rows->user_admin_id;
                        $data['admin_name'] = $rows->name;
                        $data['admin_email'] = $rows->email;
                        $data['admin_type'] = $rows->user_type;
                        $data['pwd_change'] = $rows->pass_change;
                        $data['session_id'] = $session_id;
                        $this->session->set_userdata($data);
                        unset($data,$rows);
                        return 'SUCCESS';
                    }else{
                        unset($data,$rows);
                        return 'NOT_ACTIVE';
                    }
                } else {
                    unset($data);
                    return 'INVALID';
                }
            }else{
                return 'IP_BANNED';
            }
        }
        unset($query);
    }
    
    /**
     * logout
     *
     * Function for logout
     *
     * @param	string	$url    Url to redirect
     */
    public function logout($url = '') {
        $data = array(
            'user_admin_id',
            'admin_name',
            'admin_email',
            'admin_type',
            'session_id',
            'admin_logged_in',
        );
        $this->session->unset_userdata($data);
        unset($data);
        $this->load->model('Csz_startup');
        $this->Csz_startup->clearStartup();
        if($url){
            redirect($url);
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
     * @param	string	$user_agent    user agent
     * @param	string	$ip_address    ip address
     */
    public function saveLogs($email = '', $note = '', $result = '', $user_agent = '', $ip_address = '') {
        if(!$user_agent) $user_agent = $this->input->user_agent();
        if(!$ip_address) $ip_address = $this->input->ip_address();
        if($result != 'IP_BANNED'){
            $data = array(
                'email_login' => $email,
                'note' => $note,
                'result' => $result,
            );
            $this->db->set('user_agent', $user_agent, TRUE);
            $this->db->set('ip_address', $ip_address, TRUE);
            $this->db->set('timestamp_create', 'NOW()', FALSE);
            $this->db->insert('login_logs', $data);
            unset($data);
        }
    }
    
    private function getLabelLangDB($name, $sel_name = 'lang_en'){
        $this->db->select($sel_name);
        $this->db->where("name", $name);
        $this->db->limit(1, 0);
        return $this->db->get("general_label");
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
            if (!$this->cache->get('getLabelLang_'.$name.'_'.$sel_name)) {
                $query = $this->getLabelLangDB($name, $sel_name);
                if (!empty($query) && $query->num_rows() !== 0) {
                    if ($query->row()->$sel_name){
                        $return = $query->row()->$sel_name;
                    }else{
                        unset($query);
                        $query = $this->getLabelLangDB($name);
                        if (!empty($query) && $query->num_rows() !== 0) {
                            $error_txt = "This label is untranslated on General Label! (".$name.")";
                            log_message('error', $error_txt);
                            $return = $query->row()->lang_en;
                        }else{
                            $error_txt = "This label is not defined in General Label! (".$name.")";
                            log_message('error', $error_txt);
                            $return = $error_txt;
                        }
                    }
                }else {
                    $error_txt = "This language isn't sync! (lang_" . $lang . ")";
                    log_message('error', $error_txt);
                    $return = $error_txt;
                }
                ($this->load_config()->pagecache_time == 0) ? $cache_time = 1 : $cache_time = $this->load_config()->pagecache_time;
                $this->cache->save('getLabelLang_'.$name.'_'.$sel_name, $return, ($cache_time * 60));
                unset($return, $cache_time, $query);
            }
            return $this->cache->get('getLabelLang_'.$name.'_'.$sel_name);
        }else{
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
                'name' => $this->input->post('name', TRUE),
                'email' => $this->cleanEmailFormat($this->input->post('email', TRUE)),
                'password' => $this->pwdEncypt($this->input->post('password', TRUE)),
                'user_type' => 'member',
                'active' => 0,
                'md5_hash' => $md5_hash,
                'pm_sendmail' => 1,
                'pass_change' => 1,
            );
            $this->db->set('md5_lasttime', 'NOW()', FALSE);
            $this->db->set('timestamp_create', 'NOW()', FALSE);
            $this->db->set('timestamp_update', 'NOW()', FALSE);
            $this->db->insert('user_admin', $data);
            $this->db->set('user_admin_id', $this->db->insert_id());
            $this->db->set('user_groups_id', 3);
            $this->db->insert('user_to_group');
            unset($data);
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
        $query = $this->chkPassword($this->session->userdata('admin_email'), $this->input->post('cur_password', TRUE));
        if ($query['num_rows'] !== 0) {
            if($this->input->post('pm_sendmail')){
                $pm_sendmail = $this->input->post('pm_sendmail', TRUE);
            }else{
                $pm_sendmail = 0;
            }
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
                if (!empty($_FILES['file_upload']) && $_FILES['file_upload']['type'] == 'image/png' || $_FILES['file_upload']['type'] == 'image/jpg' || $_FILES['file_upload']['type'] == 'image/jpeg' || $_FILES['file_upload']['type'] == 'image/gif') {
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
                $this->db->set('password', $this->pwdEncypt($this->input->post('password', TRUE)), TRUE);
                $this->db->set('md5_hash', md5(time() + mt_rand(1, 99999999)), TRUE);
                $this->db->set('md5_lasttime', 'NOW()', FALSE);
                $this->db->set('pass_change', 1);
            }
            $this->db->set('first_name', $this->input->post("first_name", TRUE), TRUE);
            $this->db->set('last_name', $this->input->post("last_name", TRUE), TRUE);
            $this->db->set('birthday', $birthday, TRUE);
            $this->db->set('gender', $this->input->post("gender", TRUE), TRUE);
            $this->db->set('address', $this->input->post("address", TRUE), TRUE);
            $this->db->set('phone', $this->input->post("phone", TRUE), TRUE);
            $this->db->set('picture', $upload_file, TRUE);
            $this->db->set('pm_sendmail', $pm_sendmail, FALSE);
            $this->db->set('timestamp_update', 'NOW()', FALSE);
            $this->db->where('user_admin_id', $id);
            $this->db->update('user_admin');
            $this->clear_file_cache('getUserEmail*', TRUE);
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
     * @param	string	$reply_to    reply email address
     * @param	string	$alt_message    alternate message when html not working
     * @param	array	$attach_file    attach files with array
     * @param	bool	$save_log    for save email logs into db
     * @return	string
     */
    public function sendEmail($to_email, $subject, $message, $from_email, $from_name = '', $bcc = '', $reply_to = '', $alt_message = '', $attach_file = array(), $save_log = TRUE) {
        $this->load->library('email');
        $load_conf = $this->load_config();
        $protocal = $load_conf->email_protocal;
        if (!$protocal) {
            $protocal = 'mail';
        }
        $config = array();
        $config['useragent'] = $this->Csz_admin_model->cszGenerateMeta();
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
        if($reply_to){
            $this->email->reply_to($reply_to);
        }
        if ($alt_message) {
            $this->email->set_alt_message($alt_message);
        }
        if (is_array($attach_file) && !empty($attach_file)) {
            foreach ($attach_file as $value) {
                $this->email->attach($value, 'attachment');
            }
        }
        if ($this->email->send()) {
            $result = 'success';
        } else {
            $result = $this->email->print_debugger(FALSE);
        }
        if($save_log === TRUE){
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
            $this->db->cache_delete_all();
            unset($data);
        }
        unset($to_email, $subject, $message, $from_email, $from_name, $bcc, $reply_to, $alt_message, $attach_file, $save_log, $config, $load_conf, $protocal);
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
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set("pcre.recursion_limit", "16777");
        }
        if (ini_get('allow_url_fopen') && function_exists('get_headers')) {
            if (stripos($url, 'https://') !== FALSE) {
                $default_opts = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    )
                );
                stream_context_set_default($default_opts);
            }
            $headers1 = @get_headers($url);
            $headers = substr($headers1[0], 9, 3);
            unset($url, $headers1, $default_opts);
        } else if (function_exists('curl_version')) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_HEADER => true,
            CURLOPT_NOBODY => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url));
            if (stripos($url, 'https://') !== FALSE) {
                curl_setopt($curl, CURLOPT_CAINFO, APPPATH . 'cacert.pem');
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            }
            $headers1 = explode("\n", curl_exec($curl));
            $headers = substr($headers1[0], 9, 3);
            curl_close($curl);
            unset($url, $curl, $headers1);
        } else {
            log_message('error', 'You have neither cUrl installed and not allow_url_fopen activated. Please setup one of those!');
            $headers = FALSE;
            unset($url);
        }
        return $headers;
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
        if ($headers !== FALSE && ($headers == 200 || $headers == 301 || $headers == 302)) {
            return TRUE;
        } else {
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
     * getFBsdk
     *
     * Function for get facebook SDK javascript
     *
     * @return	string or FALSE if not have fbapp_id
     */
    public function getFBsdk() {
        $html = '';
        $config = $this->load_config();
        if ($config->fbapp_id) {
            $html.= '<script type="text/javascript">
                    window.fbAsyncInit = function() {
                      FB.init({
                        appId            : \'' . $config->fbapp_id . '\',
                        autoLogAppEvents : true,
                        xfbml            : true,
                        version          : \'v2.11\'
                      });
                    };
                    (function(d, s, id){
                       var js, fjs = d.getElementsByTagName(s)[0];
                       if (d.getElementById(id)) {return;}
                       js = d.createElement(s); js.id = id;
                       js.src = "https://connect.facebook.net/' . $this->session->userdata('fronlang_iso') . '_' . strtoupper($this->getCountryCode($this->session->userdata('fronlang_iso'))) . '/sdk.js";
                       fjs.parentNode.insertBefore(js, fjs);
                     }(document, \'script\', \'facebook-jssdk\'));
                  </script>';
            return $html;
        } else {
            return FALSE;
        }
    }
    
    /**
     * getFBChat
     *
     * Function for get facebook messager chat
     *
     * @return	string or FALSE if not have facebook_page_id or fb_messenger setting not active
     */
    public function getFBChat() {
        $html = '';
        $config = $this->load_config();
        if ($config->facebook_page_id && $config->fb_messenger) {
            $html.= '<div class="fb-customerchat"
                page_id="'.$config->facebook_page_id.'"
                minimized="true">
               </div>';
            return $html;
        } else {
            return FALSE;
        }
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
    public function getFBComments($url, $limit, $sort) {
        $html = '';
        $config = $this->load_config();
        if ($config->fbapp_id && $url && $limit && $sort) {
            $html.= '<div id="fb-root"></div>
            <div class="fb-comments" data-href="' . $url . '" data-width="100%" data-numposts="' . $limit . '" data-order-by="' . $sort . '"></div>' . "\n";
            return $html;
        } else {
            return FALSE;
        }
    }

    /**
     * insertAsCopy
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
            unset($data, $table);
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /**
     * findNameAsCopy
     *
     * Function for find the name to create new content as copy with new name
     *
     * @param	string	$table  for database table
     * @param	string	$field_id  ID field
     * @param	string	$value  Value to replace name
     * @param	bool	$is_url  Value is url. Default is FALSE
     * @param	string	$separator  What should the duplicate number be appended with
     * @return	string or FALSE
     */
    public function findNameAsCopy($table, $field_id, $value, $is_url = FALSE, $separator = '-') {
        if($table && $field_id && $value){
            $value = preg_replace('/'.$separator.'(copy)'.$separator.'([0-9]+)$/', '', $value);
            $lastid = $this->getLastID($table, $field_id);
            $value = $value.$separator.'copy'.$separator.($lastid + 1);
            unset($table,$field_id,$separator,$lastid);
            return ($is_url === TRUE) ? $this->rw_link($value) : $value;
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
        $email = str_replace($search, '', trim($email));
        unset($search);
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
        unset($search);
        return $this->security->xss_clean($string);
    }
    
    /**
     * findFormsTag
     *
     * Function for find forms tag from content html
     *
     * @param	string	$content  for content html
     * @param	bool	$html  for use html tag or [?] tag. Default FALSE is use [?] tag
     * @return	TRUE or FALSE
     */
    public function findFrmTag($content, $html = FALSE) {
        @ini_set("pcre.recursion_limit", "16777");
        if($html === TRUE){
            if (strpos($content, '<form ') !== false && strpos($content, ' name="csrf_csz"') !== false) {
                unset($content,$html);
                return TRUE;
            }else{
                unset($content,$html);
                return FALSE;
            }
        }else{
            $txt_nonhtml = strip_tags($content);
            if (strpos($txt_nonhtml, '[?]{=forms:') !== false) {
                unset($content,$html);
                return TRUE;
            }else{
                unset($content,$html);
                return FALSE;
            }
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
        if (!$this->cache->get('loadBFconfig')) {
            $this->db->limit(1, 0);
            $query = $this->db->get('login_security_config');
            if ($query->num_rows() !== 0) {
                $row = $query->row();
            } else {
                $row = FALSE;
            }
            if($this->load_config()->pagecache_time == 0){
                $cache_time = 1;
            }else{
                $cache_time = $this->load_config()->pagecache_time;
            }
            $this->cache->save('loadBFconfig', $row, ($cache_time * 60));
            unset($query, $cache_time, $row);
        }
        return $this->cache->get('loadBFconfig');
    }
    
    /**
     * chkBFwhitelistIP
     *
     * Function for check the IP from whitelist
     *
     * @param	string	$ip_address  for ip address
     * @return	TRUE or FALSE
     */
    public function chkBFwhitelistIP($ip_address = '') {
        if(!$ip_address) $ip_address = $this->input->ip_address();
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
    public function chkBFblacklistIP($ip_address = '') {
        if(!$ip_address) $ip_address = $this->input->ip_address();
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
    public function saveBFloginIP($ip_address = '', $email = '') {
        if(!$ip_address) $ip_address = $this->input->ip_address();
        $config = $this->load_bf_config();
        if($this->chkBFwhitelistIP($ip_address) === FALSE){
            $search_sql = "ip_address = '".$ip_address."' AND (result = 'INVALID' OR result = 'CSRF_INVALID') AND timestamp_create >= DATE_SUB(NOW(),INTERVAL ".$config->bf_protect_period." MINUTE)";
            $ip_count = $this->countData('login_logs', $search_sql);
            if($ip_count !== FALSE  && $ip_count !== 0 && $ip_count >= ($config->max_failure) && $this->chkBFblacklistIP($ip_address) === FALSE){
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
                unset($data);
                $this->clear_all_cache();
                $this->db->cache_delete_all();
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
        $this->db->cache_delete_all();
        $cur_ip = $this->input->ip_address();
        $this->saveBFloginIP($cur_ip, $email);
        if($this->chkBFblacklistIP($cur_ip) === TRUE){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /**
     * getPluginConfig
     *
     * Function for get plugin config
     *
     * @param	string	$config_filename  for plugin config file name
     * @param	string	$index_name for plugin config file name
     * @return	string or FALSE
     */
    public function getPluginConfig($config_filename, $index_name) {
        if (!$this->cache->get('pluginconfig_'.md5($config_filename.$index_name))) {
            $plugin_config = array();
            $file_path = APPPATH.'/config/plugin/'.str_replace('.php', '', $config_filename).'.php';
            if (!file_exists($file_path)){
                $return = FALSE;
            }else{
                include($file_path);
                if (isset($plugin_config) && is_array($plugin_config) && array_key_exists($index_name, $plugin_config) === TRUE) {
                    $return = $plugin_config[strval($index_name)];
                }else{
                    $return = FALSE;
                }
            }
            ($this->load_config()->pagecache_time == 0) ? $cache_time = 1 : $cache_time = $this->load_config()->pagecache_time;
            $this->cache->save('pluginconfig_'.md5($config_filename.$index_name), $return, ($cache_time * 60));
            unset($return, $cache_time, $plugin_config, $file_path);
        }
        return $this->cache->get('pluginconfig_'.md5($config_filename.$index_name));
    }
    
    /**
     * base_link
     *
     * Function for get the base url link
     * 
     * @param	bool	$static for assets static resources from a different cdn domain
     * @param	bool	$htaccess for htaccess config
     *
     * @return	string
     */
    public function base_link($static = FALSE, $htaccess = TRUE) {
        if($static === TRUE){
            if(HTACCESS_FILE === FALSE && $htaccess === FALSE){
                $baseurl = rtrim($this->config->base_url('', '', TRUE), '/').'/index.php';
                $cachename = '_static_htaccess';
            }else{
                $baseurl = rtrim($this->config->base_url('', '', TRUE), '/');
                $cachename = '_static';
            }
        }else{
            if(HTACCESS_FILE === FALSE || $htaccess === FALSE){
                $baseurl = rtrim(BASE_URL, '/').'/index.php';
                $cachename = '_htaccess';
            }else{
                $baseurl = rtrim(BASE_URL, '/');
                $cachename = '';
            }
        }
        if (!$this->cache->get('base_link'.$cachename)) {
            if($this->load_config()->pagecache_time == 0){
                $cache_time = 1;
            }else{
                $cache_time = $this->load_config()->pagecache_time;
            }
            $this->cache->save('base_link'.$cachename, $baseurl, ($cache_time * 60));
            unset($cache_time, $baseurl);
        }
        return $this->cache->get('base_link'.$cachename);
    }
    
    /**
     * chkPrivateKey
     *
     * Function for check the private key
     *
     * @param	string	$private_key    private key
     * @return	bool
     */
    public function chkPrivateKey($private_key = '') {
        if(!$private_key){ $private_key = 'false'; }
        $this->db->where("bf_private_key", $private_key);
        $this->db->limit(1, 0);
        $query = $this->db->get("login_security_config");
        if(!empty($query) && $query->num_rows() !== 0){
            return TRUE;
        }else{
            return FALSE;
        }
        unset($query);       
    }
    
    /**
     * chkVerUpdate
     *
     * Function for check version for update
     *
     * @param	string	$cur_ver    current version
     * @param	string	$last_ver    latest version
     * @return	bool
     */
    public function chkVerUpdate($cur_ver, $last_ver){
        if (version_compare($cur_ver, $last_ver, '<') === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    private function chkNextVer($cur_ver, $last_ver){
        $cur_r = explode('.', $cur_ver);
        if ($cur_ver == $last_ver) {
            return $last_ver;
        } else {
            if ($cur_r[1] <= 9 && $cur_r[2] < 9) {
                return $cur_r[0] . '.' . $cur_r[1] . '.' . ($cur_r[2] + 1);
            } else if ($cur_r[1] < 9 && $cur_r[2] == 9) {
                return $cur_r[0] . '.' . ($cur_r[1] + 1) . '.0';
            } else if ($cur_r[1] == 9 && $cur_r[2] == 9) {
                return ($cur_r[0] + 1) . '.0.0';
            } else {
                return FALSE;
            }
        }
    }


    /**
     * findNextVersion
     *
     * Function for check version for update
     *
     * @param	string	$cur_txt    current version
     * @param	string	$last_ver    latest version
     * @return	string or false
     */
    public function findNextVersion($cur_txt, $last_ver){
        /* sub version is limit x.9.9 */
        $cur_xml = explode(' ', $cur_txt);
        if($cur_xml[0] && $last_ver){
            $cur_ver = str_replace(' ', '.', $cur_xml[0]);
            if(isset($cur_xml[1]) && $cur_xml[1] == 'Beta'){
                return $cur_xml[0];
            }else{
                return $this->chkNextVer($cur_ver, $last_ver);
            }
        }else{
            return FALSE;
        }
    }
    
    /**
     * compress_html
     *
     * Function for compress the html
     *
     * @param	string	$html    html text
     * @return	string
     */
    public function compress_html($html){
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set("pcre.recursion_limit", "16777");
        }
        $search = array(
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        );
        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );
        return preg_replace($search, $replace, $html);
    }
    
    private function compress_js_css($val){
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set("pcre.recursion_limit", "16777");
        }
        /* Function for compress js or css file */
        $config = $this->load_config();
        if($config->html_optimize_disable != 1 && $val){
            $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $val);
            $buffer = preg_replace('/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/', ';', $buffer);
            $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '     '), '', $buffer);
            $buffer = preg_replace(array('(( )+{)', '({( )+)'), '{', $buffer);
            $buffer = preg_replace(array('(( )+})', '(}( )+)', '(;( )*})'), '}', $buffer);
            $buffer = preg_replace(array('(;( )+)', '(( )+;)'), ';', $buffer);
            $buffer = str_replace(': ', ':', $buffer);
            $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
            unset($val, $config);
            return trim($buffer);
        }else{
            unset($config);
            return $val;
        }
    }
    
    /**
     * setJSCSScache
     *
     * Function for set js or css cache file
     *
     * @param	array	$files    file path
     * @param	string	$cache_name    cache filename
     * @param	string	$type    file type [js or css]
     * @param	int	$expires    expire time
     * @return	string
     */
    public function setJSCSScache($files, $cache_name, $type, $expires){
        if(is_array($files) && !$this->cache->get($cache_name)){
            $buffer = '';
            foreach ($files as $file) {
                $buffer .= file_get_contents($file);
            }
            $buffer1 = $this->compress_js_css($buffer);
            if ($type == 'css') {
                $buffer = str_replace("url(../", "url(" . base_url() . "assets/", $buffer1);
            }
            $this->cache->save($cache_name, $buffer, $expires);
            unset($buffer, $buffer1, $files);
        }
        return $this->cache->get($cache_name);
    }
    
    /**
     * setJSCSSheader
     *
     * Function for set js or css http header
     *
     * @param	int	$modefied    file modified time
     * @param	int	$expires    expire time
     * @param	string	$etag    etag MD5 from file
     * @param	string	$type    file type [text/js or application/javascript or text/css]
     * @return  void    No value is returned.
     */
    public function setJSCSSheader($modefied, $expires, $etag, $type){
	@ob_start("ob_gzhandler"); // Gzip compress
	header("Accept-Ranges: bytes");
	header("Etag: {$etag}");
        header("Content-type: {$type}");
	header("Pragma: public; maxage={$expires}");
        header("Expires: " . gmdate ("D, d M Y H:i:s", time() + ($expires)) . " GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s", $modefied).' GMT');
        header("Cache-Control: max-age={$expires}");
        header("Cache-Control: public");
    }
    
    /**
     * get_contents_url
     *
     * Function for get the content from url
     *
     * @param	string	$url    content full url path
     * @return  string or FALSE
     */
    public function get_contents_url($url = '') {
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set("pcre.recursion_limit", "16777");
        }
        if($url){
            if (ini_get('allow_url_fopen')) {
                if (stripos($url, 'https://') !== FALSE) {
                    $default_opts = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                        )
                    );
                    stream_context_set_default($default_opts);
                }
                $content = @file_get_contents($url);
            }else if (function_exists('curl_version')) {
                // create a new cURL resource
                $ch = curl_init();
                // set URL and other appropriate options
                curl_setopt($ch, CURLOPT_URL, $url);
                if(stripos($url, 'https://') !== FALSE){
                    curl_setopt($ch, CURLOPT_CAINFO, APPPATH . 'cacert.pem');
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                }
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                $content = curl_exec($ch);
                curl_close($ch);
                unset($url, $ch);
            } else {
                log_message('error', 'You have neither cUrl installed and not allow_url_fopen activated. Please setup one of those!');
                $content = FALSE;
                unset($url);
            }
            return $content;
        }else{
            return FALSE;
        }
    }
    
    /**
     * rmdir_recursive
     *
     * Function for remove directory with recursive
     *
     * @param	string	$dir    Directory path want to remove with recursive
     */
    public function rmdir_recursive($dir) {
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set("pcre.recursion_limit", "16777");
        }
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (is_dir($dir . DIRECTORY_SEPARATOR . $object)) {
                        $this->rmdir_recursive($dir . DIRECTORY_SEPARATOR . $object);
                    } else {
                        if( is_file($dir . DIRECTORY_SEPARATOR . $object) ) {
                            if(!@unlink($dir . DIRECTORY_SEPARATOR . $object)) {
                                log_message('error', "Can't remove file at ". $dir . DIRECTORY_SEPARATOR . $object);
                            }
                        } else {
                            log_message('error', "File permission issues at ". $dir . DIRECTORY_SEPARATOR . $object);
                        }
                    }
                }
            }
            unset($objects, $object);
            rmdir($dir);
        }
    }
    /**
     * copy_recursive
     *
     * Function for copy directory and file with recursive
     *
     * @param	string	$src    Source full path want to copy with recursive
     * @param	string	$dst    Destination full path want to paste with recursive
     */
    public function copy_recursive($src, $dst) {
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set("pcre.recursion_limit", "16777");
        }
        $src = rtrim(rtrim($src, '/'), '\\');
        $dst = rtrim(rtrim($dst, '/'), '\\');
        if(is_dir($src)) {
            if (!is_dir($dst)) {
                @mkdir($dst, 0755, true);
            }
            $dir_items = array_diff(scandir($src), array('..', '.'));
            if (count($dir_items) > 0) {
                foreach ($dir_items as $v) {
                    $this->copy_recursive($src . DIRECTORY_SEPARATOR . $v, $dst . DIRECTORY_SEPARATOR . $v);
                }
            }
        } elseif(is_file($src)) {
            @copy($src, $dst);
        }
    }
    
    /**
     * Runs the file through the XSS clean function (Only images)
     *
     * This prevents people from embedding malicious code in their files.
     * I'm not sure that it won't negatively affect certain files in unexpected ways,
     * but so far I haven't found that it causes trouble.
     *
     * @param srting $file From $_FILE['fieldname']['tmp_name']
     * @return	string or FALSE
     */
    public function photo_xss_clean($file) {
        if (function_exists('ini_set')) {
            @ini_set('max_execution_time', 600);
            @ini_set("pcre.recursion_limit", "16777");
        }
        if (filesize($file) == 0) {
            return FALSE;
        }
        if (memory_get_usage() && ($memory_limit = ini_get('memory_limit')) > 0) {
            $memory_limit = str_split($memory_limit, strspn($memory_limit, '1234567890'));
            if (!empty($memory_limit[1])) {
                switch ($memory_limit[1][0]) {
                    case 'g':
                    case 'G':
                        $memory_limit[0] *= 1024 * 1024 * 1024;
                        break;
                    case 'm':
                    case 'M':
                        $memory_limit[0] *= 1024 * 1024;
                        break;
                    default:
                        break;
                }
            }

            $memory_limit = (int) ceil(filesize($file) + $memory_limit[0]);
            ini_set('memory_limit', $memory_limit); // When an integer is used, the value is measured in bytes. - PHP.net
        }
        // If the file being uploaded is an image, then we should have no problem with XSS attacks (in theory), but
        // IE can be fooled into mime-type detecting a malformed image as an html file, thus executing an XSS attack on anyone
        // using IE who looks at the image. It does this by inspecting the first 255 bytes of an image. To get around this
        // CI will itself look at the first 255 bytes of an image to determine its relative safety. This can save a lot of
        // processor power and time if it is actually a clean image, as it will be in nearly all instances _except_ an
        // attempted XSS attack.

        if (function_exists('getimagesize') && @getimagesize($file) !== FALSE) {
            if (($file = @fopen($file, 'rb')) === FALSE) { // "b" to force binary
                return FALSE; // Couldn't open the file, return FALSE
            }
            
            $opening_bytes = fread($file, 256);
            fclose($file);
            
            // These are known to throw IE into mime-type detection chaos
            // <a, <body, <head, <html, <img, <plaintext, <pre, <script, <table, <title
            // title is basically just in SVG, but we filter it anyhow
            // if it's an image or no "triggers" detected in the first 256 bytes - we're good
            return !preg_match('/<(a|body|head|html|img|plaintext|pre|script|table|title)[\s>]/i', $opening_bytes);
        }
        if (($data = @file_get_contents($file)) === FALSE) {
            return FALSE;
        }
        return $this->security->xss_clean($data, TRUE);
    }
    
    /**
    * Remove the nested HTML empty tags from the string.
    *
    * @param    string  $string String to remove tags
    * @return   mixed   Cleaned string
    */
   public function remove_empty_htmltags($string) {
       // Return if string not given or empty
       if (!is_string($string) || trim($string) == ''){
            return $string;
       }else{
            return preg_replace('/<(\w+)\b(?:\s+[\w\-.:]+(?:\s*=\s*(?:"[^"]*"|"[^"]*"|[\w\-.:]+))?)*\s*\/?>\s*<\/\1\s*>/', '', $string);
       }
   }
    
}
