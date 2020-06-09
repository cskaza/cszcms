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
defined('BASEPATH') || exit('No direct script access allowed');

class Headfoot_html extends CI_Model{

    function __construct(){
        parent::__construct();
        $this->load->model('Csz_admin_model');
        $this->lang->load('admin', $this->Csz_admin_model->getLang());
        if (CACHE_TYPE == 'file') {
            $this->load->driver('cache', array('adapter' => 'file', 'key_prefix' => EMAIL_DOMAIN . '_'));
        } else {
            $this->load->driver('cache', array('adapter' => CACHE_TYPE, 'backup' => 'file', 'key_prefix' => EMAIL_DOMAIN . '_'));
        }
    }
    

    /**
     * getLogo
     *
     * Function for get the logo on frontend
     *
     * @return  string
     */
    public function getLogo(){
        $row = $this->Csz_model->load_config();
        $logo = '';
        if($row->site_logo){
            $logo = '<img alt="Site Logo" class="site-logo img-responsive" src="'.base_url('', '', TRUE).'photo/logo/'.$row->site_logo.'">';
        }else{
            $logo = $row->site_name;
        }
        unset($row);
        return $logo;
    }

    /**
     * topmenu
     *
     * Function for get the top menu on frontend
     *
     * @param	string	$cur_page    current page
     * @param	string	$active_type    for active 'class' or 'id'. Default is 'id'.
     * @param	string	$active_tag     for active 'a' or 'li'. Default is 'a'.
     * @param	string	$more_id_class     for more $active_type in $active_tag.
     * @param	string	$more_drop_class     for more class on dropdown menu.
     * @return  string
     */
    public function topmenu($cur_page1, $active_type = 'id', $active_tag = 'a', $more_id_class = '', $more_drop_class = ''){
        $cur_page = strtolower($cur_page1);
        $config = $this->Csz_model->load_config();
        $menu_list = '';
        $cur_page_lang = $this->Csz_model->getValue('lang_iso', 'pages', 'page_url', $cur_page, 1);
        if($cur_page_lang === FALSE){
            $cur_page_lang_iso = $this->session->userdata('fronlang_iso');
        }else{
            $cur_page_lang_iso = $cur_page_lang->lang_iso;
            $this->Csz_model->setSiteLang($cur_page_lang_iso);
        }
        if(!$this->cache->get('topmenu_'.$cur_page_lang_iso.'_'.$this->Csz_model->rw_link($cur_page))){
            $get_mainmenu = $this->Csz_model->main_menu('', $cur_page_lang_iso);
            if($get_mainmenu === FALSE){
                $get_mainmenu = $this->Csz_model->main_menu('', $this->Csz_model->getDefualtLang());
            }
            if(!empty($get_mainmenu)){
                foreach($get_mainmenu as $rs){
                    $page_url_rs = $this->Csz_model->getPageUrlFromID($rs->pages_id);
                    if($rs->new_windows && $rs->new_windows != NULL){
                        $target = ' target="_blank"';
                    }else{
                        $target = '';
                    }
                    if($page_url_rs && (!$rs->other_link && !$rs->plugin_menu) || ($rs->other_link == NULL && $rs->plugin_menu == NULL)){
                        $page_link = $this->Csz_model->base_link().'/'.$page_url_rs;
                    }else if($rs->other_link && (!$page_url_rs && !$rs->plugin_menu) || ($page_url_rs == NULL && $rs->plugin_menu == NULL)){
                        if(substr_count($rs->other_link, '#') > 1){
                            $page_link = substr($rs->other_link, 1);
                        }else{
                            $page_link = $rs->other_link;
                        }
                    }else if((!$rs->other_link && !$page_url_rs) || ($rs->other_link == NULL && $page_url_rs == NULL) && $rs->plugin_menu){
                        $page_link = $this->Csz_model->base_link().'/'.'plugin/'.$rs->plugin_menu;
                    }else{
                        $page_link = '#';
                    }
                    $otherlink_host = @parse_url($rs->other_link, PHP_URL_HOST);
                    $own_host = @parse_url(config_item('base_url'), PHP_URL_HOST);
                    $otherlink_array = explode('/',$rs->other_link);
                    if($more_id_class){
                        $more_id_class_new = ' '.$more_id_class;
                    }else{
                        $more_id_class_new = '';
                    }
                    if($page_url_rs == $cur_page){
                        $active = ' '.$active_type.'="active'.$more_id_class_new.'"';
                    }else if($rs->plugin_menu && $rs->plugin_menu == $this->uri->segment(2)){
                        $active = ' '.$active_type.'="active'.$more_id_class_new.'"';
                    }else if(($otherlink_host && $otherlink_host === $own_host) && end($otherlink_array) === $this->Csz_model->getCurPages()){
                        $active = ' '.$active_type.'="active'.$more_id_class_new.'"';
                    }else{
                        $active = ' '.$active_type.'="'.$more_id_class.'"';
                    }
                    if($rs->drop_menu){
                        $menu_list.= '<li class="dropdown'.$more_drop_class.'">
                        <a aria-expanded="true" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#" title="'.$rs->menu_name.'">'.$rs->menu_name.' <span class="caret"></span></a>
                        <ul class="dropdown-menu">';
                        $drop_menu = $this->Csz_model->main_menu($rs->page_menu_id, $cur_page_lang_iso);
                        if($drop_menu === FALSE){
                            $drop_menu = $this->Csz_model->main_menu($rs->page_menu_id, $this->Csz_model->getDefualtLang());
                        }
                        if(!empty($drop_menu)){
                            foreach($drop_menu as $rs_sub){
                                $page_url_rs_sub = $this->Csz_model->getPageUrlFromID($rs_sub->pages_id);
                                if($rs_sub->new_windows && $rs_sub->new_windows != NULL){
                                    $target_sub = ' target="_blank"';
                                }else{
                                    $target_sub = '';
                                }
                                if($page_url_rs_sub && (!$rs_sub->other_link && !$rs_sub->plugin_menu) || ($rs_sub->other_link == NULL && $rs_sub->plugin_menu == NULL)){
                                    $page_link_sub = $this->Csz_model->base_link().'/'.$this->Csz_model->rw_link($rs->menu_name).'/'.$page_url_rs_sub;
                                }else if($rs_sub->other_link && (!$page_url_rs_sub && !$rs_sub->plugin_menu) || ($page_url_rs_sub == NULL && $rs_sub->plugin_menu == NULL)){
                                    if(substr_count($rs_sub->other_link, '#') > 1){
                                        $page_link_sub = substr($rs_sub->other_link, 1);
                                    }else{
                                        $page_link_sub = $rs_sub->other_link;
                                    }
                                }else if((!$page_url_rs_sub && !$rs_sub->other_link) || ($page_url_rs_sub == NULL && $rs_sub->other_link == NULL) && $rs_sub->plugin_menu){
                                    $page_link_sub = $this->Csz_model->base_link().'/'.'plugin/'.$rs_sub->plugin_menu;
                                }else{
                                    $page_link_sub = '#';
                                }
                                $menu_list.= '<li><a href="'.$page_link_sub.'"'.$target_sub.' title="'.strip_tags($rs_sub->menu_name).'">'.$rs_sub->menu_name.'</a></li>';
                            }
                        }
                        $menu_list.= '</ul></li>';
                    }else{
                        if($active_tag == 'a'){
                            $menu_list.= '<li><a'.$active.' href="'.$page_link.'"'.$target.' title="'.strip_tags($rs->menu_name).'">'.$rs->menu_name.'</a></li>';
                        }elseif($active_tag == 'li'){
                            $menu_list.= '<li'.$active.'><a href="'.$page_link.'"'.$target.' title="'.strip_tags($rs->menu_name).'">'.$rs->menu_name.'</a></li>';
                        }
                    }
                }
            }
            if(!$config->member_close_regist || empty($config->member_close_regist) || $config->member_close_regist === NULL){
                /* Start Member menu */
                $menu_list.= '<li><a href="'.$this->Csz_model->base_link().'/member" title="'.$this->Csz_model->getLabelLang('member_menu').'"><i class="glyphicon glyphicon-user"></i></a></li>';
                /* End Member menu */
            }
            if($config->gsearch_active && !empty($config->gsearch_cxid) && $config->gsearch_cxid !== NULL){
                /* Start Search menu */
                $menu_list.= '<li><a href="'.$this->Csz_model->base_link().'/search" title="Google Search"><i class="glyphicon glyphicon-search"></i></a></li>';
                /* End Search menu */
            }
            if($config->pagecache_time == 0){
                $cache_time = 1;
            }else{
                $cache_time = $config->pagecache_time;
            }
            $this->cache->save('topmenu_'.$cur_page_lang_iso.'_'.$this->Csz_model->rw_link($cur_page), $menu_list, ($cache_time * 60));
            unset($menu_list,$cache_time,$config,$drop_menu,$get_mainmenu,$cur_page_lang,$page_url_rs,$active,$otherlink_host,$own_host,$otherlink_array,$target_sub,$target,$page_link_sub,$page_url_rs_sub);
        }
        return $this->cache->get('topmenu_'.$cur_page_lang_iso.'_'.$this->Csz_model->rw_link($cur_page));
    }
    
    /**
     * bottomnav
     *
     * Function for get the top menu on frontend
     *
     * @param	string	$cur_page    current page
     * @return  string
     */
    public function bottomnav($cur_page){
        $config = $this->Csz_model->load_config();
        $menu_list1 = '';
        $cur_page_lang = $this->Csz_model->getValue('lang_iso', 'pages', 'page_url', $cur_page, 1);
        if($cur_page_lang === FALSE){
            $cur_page_lang_iso = $this->session->userdata('fronlang_iso');
        }else{
            $cur_page_lang_iso = $cur_page_lang->lang_iso;
            $this->Csz_model->setSiteLang($cur_page_lang_iso);
        }
        if(!$this->cache->get('bottomnav_'.$cur_page_lang_iso.'_'.$this->Csz_model->encodeURL($cur_page))){
            $get_mainmenu1 = $this->Csz_model->main_menu('', $cur_page_lang_iso, 1);
            if($get_mainmenu1 === FALSE){
                $get_mainmenu1 = $this->Csz_model->main_menu('', $this->Csz_model->getDefualtLang(), 1);
            }
            if(!empty($get_mainmenu1)){
                foreach($get_mainmenu1 as $rs){
                    $page_url_rs = $this->Csz_model->getPageUrlFromID($rs->pages_id);
                    if($rs->new_windows && $rs->new_windows != NULL){
                        $target = ' target="_blank"';
                    }else{
                        $target = '';
                    }
                    $page_link = '';
                    if($page_url_rs && (!$rs->other_link && !$rs->plugin_menu) || ($rs->other_link == NULL && $rs->plugin_menu == NULL)){
                        $page_link = $this->Csz_model->base_link().'/'.$page_url_rs;
                    }else if($rs->other_link && (!$page_url_rs && !$rs->plugin_menu) || ($page_url_rs == NULL && $rs->plugin_menu == NULL)){
                        if(substr_count($rs->other_link, '#') > 1){
                            $page_link = substr($rs->other_link, 1);
                        }else{
                            $page_link = $rs->other_link;
                        }
                    }else if((!$rs->other_link && !$page_url_rs) || ($rs->other_link == NULL && $page_url_rs == NULL) && $rs->plugin_menu){
                        $page_link = $this->Csz_model->base_link().'/'.'plugin/'.$rs->plugin_menu;
                    }else{
                        $page_link = '#';
                    }
                    if(!$page_link){
                        $page_link = '#';
                    }
                    if($rs->drop_menu){
                        $menu_list1.= '<li class="dropdown">
                        <a aria-expanded="true" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#" title="'.$rs->menu_name.'">'.$rs->menu_name.' <span class="caret"></span></a>
                        <ul class="dropdown-menu">';
                        $drop_menu1 = $this->Csz_model->main_menu($rs->page_menu_id, $cur_page_lang_iso, 1);
                        if($drop_menu1 === FALSE){
                            $drop_menu1 = $this->Csz_model->main_menu($rs->page_menu_id, $this->Csz_model->getDefualtLang(), 1);
                        }
                        if(!empty($drop_menu1)){
                            foreach($drop_menu1 as $rs_sub){
                                $page_url_rs_sub = $this->Csz_model->getPageUrlFromID($rs_sub->pages_id);
                                if($rs_sub->new_windows && $rs_sub->new_windows != NULL){
                                    $target_sub = ' target="_blank"';
                                }else{
                                    $target_sub = '';
                                }
                                $page_link_sub = '';
                                if($page_url_rs_sub && (!$rs_sub->other_link && !$rs_sub->plugin_menu) || ($rs_sub->other_link == NULL && $rs_sub->plugin_menu == NULL)){
                                    $page_link_sub = $this->Csz_model->base_link().'/'.$this->Csz_model->rw_link($rs->menu_name).'/'.$page_url_rs_sub;
                                }else if($rs_sub->other_link && (!$page_url_rs_sub && !$rs_sub->plugin_menu) || ($page_url_rs_sub == NULL && $rs_sub->plugin_menu == NULL)){
                                    if(substr_count($rs_sub->other_link, '#') > 1){
                                        $page_link_sub = substr($rs_sub->other_link, 1);
                                    }else{
                                        $page_link_sub = $rs_sub->other_link;
                                    }
                                }else if((!$page_url_rs_sub && !$rs_sub->other_link) || ($page_url_rs_sub == NULL && $rs_sub->other_link == NULL) && $rs_sub->plugin_menu){
                                    $page_link_sub = $this->Csz_model->base_link().'/'.'plugin/'.$rs_sub->plugin_menu;
                                }else{
                                    $page_link_sub = '#';
                                }
                                if(!$page_link_sub) $page_link_sub = '#';
                                $menu_list1.= '<li><a href="'.$page_link_sub.'"'.$target_sub.' title="'.strip_tags($rs_sub->menu_name).'">'.$rs_sub->menu_name.'</a></li>';
                            }
                        }
                        $menu_list1.= '</ul></li>';
                    }else{
                        $menu_list1.= '<li><a href="'.$page_link.'"'.$target.' title="'.strip_tags($rs->menu_name).'">'.$rs->menu_name.'</a></li>';
                    }
                }
            }
            if($config->pagecache_time == 0){
                $cache_time = 1;
            }else{
                $cache_time = $config->pagecache_time;
            }
            $this->cache->save('bottomnav_'.$cur_page_lang_iso.'_'.$this->Csz_model->encodeURL($cur_page), $menu_list1, ($cache_time * 60));
            unset($menu_list1,$cache_time,$config,$drop_menu1,$get_mainmenu1,$cur_page_lang,$page_url_rs,$target_sub,$target,$page_link_sub,$page_url_rs_sub);
        }
        return $this->cache->get('bottomnav_'.$cur_page_lang_iso.'_'.$this->Csz_model->encodeURL($cur_page));
    }

    /**
     * getSocial
     *
     * Function for get social
     *
     * @param	bool	$ul    Have ul tags or not
     * @param	string	$icon_tag    fa-icon is show on i tag or a tag
	 * @param	bool	$textname    have text name after icon
     * @return  string
     */
    public function getSocial($ul = TRUE, $icon_tag = 'i', $textname = FALSE){
        $social_list = '';
        if($this->Csz_model->getSocial()){
            foreach($this->Csz_model->getSocial() as $rs){
                if($rs->social_url){
                    $socail_url = $rs->social_url;
                    $target = ' target="_blank"';
                }else{
                    $socail_url = '#';
                    $target = '';
                }
                ($textname !== FALSE) ? $nameaftericon = ' '.ucfirst($rs->social_name) : $nameaftericon = '';
                if($icon_tag == 'i'){
                    $social_list.= '<li><a href="'.$socail_url.'"'.$target.' rel="nofollow external" title="'.$rs->social_name.'"><i class="fa fa-'.$rs->social_name.'"></i>'.$nameaftericon.'</a></li>';
                }else if($icon_tag == 'a'){
                    $social_list.= '<li><a href="'.$socail_url.'"'.$target.' rel="nofollow external" title="'.$rs->social_name.'" class="fa fa-'.$rs->social_name.'">'.$nameaftericon.'</a></li>';
                }
            }
        }
        if($ul !== FALSE){
            $html = '<ul class="list-inline social-buttons">'.$social_list.'</ul>';
        }else{
            $html = $social_list;
        }
        unset($social_list,$socail_url,$target);
        return $html;
    }

    /**
     * langMenu
     *
     * Function for language menu
     *
     * @param	string	$type    language menu type 1=Show flag only, 2=Show flag and Language, 3=Show flag and Country, 4=Google Translator tools,  null=Show Full detail
     * @param	string	$lang_gool  Your page default language for Google translator tools. Default is 'en'
     * @return  string
     */
    public function langMenu($type = '', $lang_gool = 'en'){
        $lang_list = '';
        $i = 0;
        if($type == 4){
            $html = "<style>.goog-te-banner-frame{display:none !important;}</style><div class=\"list-inline\" id=\"lang-menu\"><div id=\"google_translate_element\"></div><script>function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage:'".$lang_gool."'},'google_translate_element');}</script></div>";
        }else{
            $lang = $this->Csz_model->loadAllLang(1);
            if($lang !== FALSE){
                foreach($lang as $rs){
                    ($rs->lang_iso) ? $lang_url = $this->Csz_model->base_link().'/'.'lang/'.$rs->lang_iso : $lang_url = $this->Csz_model->base_link().'/'.'lang/';
                    if($type == 1){ /* Show flag only */
                        $lang_list.= '<li><a href="'.$lang_url.'" title="'.$rs->country_iso.'"><span class="flag-icon flag-icon-'.$rs->country_iso.'"></span></a></li>';
                    }else if($type == 2){ /* Show flag and Language */
                        $lang_list.= '<li><a href="'.$lang_url.'" title="'.$rs->lang_name.'"><span class="flag-icon flag-icon-'.$rs->country_iso.'"></span> '.$rs->lang_name.'</a></li>';
                    }else if($type == 3){ /* Show flag and Country */
                        $lang_list.= '<li><a href="'.$lang_url.'" title="'.$rs->country.'"><span class="flag-icon flag-icon-'.$rs->country_iso.'"></span> '.$rs->country.'</a></li>';
                    }else{ /* Show Full detail */
                        $lang_list.= '<li><a href="'.$lang_url.'" title="'.$rs->country.'('.$rs->lang_name.')"><span class="flag-icon flag-icon-'.$rs->country_iso.'"></span> '.$rs->country.'('.$rs->lang_name.')</a></li>';
                    }
                    $i++;
                }
                ($i > 1) ? $html = '<ul class="list-inline" id="lang-menu">'.$lang_list.'</ul>' : $html = '';
                unset($lang_list,$i,$lang,$rs,$type,$lang_url);
            }
        }
        return $html;
    }

    /**
     * footer
     *
     * Function for footer
     *
     * @return  string
     */
    public function footer(){
        $html = $this->Csz_model->cszCopyright();
        return $html;
    }

    /**
     * admin_leftli
     *
     * Function for left menu on backend <li></li>
     *
     * @param	string	$cur_page   Current page
     * @param	string	$page_chk   Page check
     * @param	string	$url   Url
     * @param	string	$menu_name   Menu label
     * @param	string	$icon   bootstrap glyphicon class
     * @param	string	$submenu   Submenu (TRUE or FALSE)
     * @return  string
     */
    private function admin_leftli($cur_page, $page_chk, $url, $menu_name, $icon){
        $active = '';
        $glyp_icon = '';
        if($cur_page == $page_chk){
            $active = ' class="active"';
        }
        if($icon){
            $glyp_icon = '<i class="'.$icon.'"></i> ';
        }
        $html = '<li'.$active.'><a href="'.$this->Csz_model->base_link().'/'.''.$url.'">'.$glyp_icon.'<span>'.$menu_name.'</span></a></li>';
        return $html;
    }

    /**
     * admin_leftmenu
     *
     * Function for left menu on backend (For AdminLTE Template)
     *
     * @param	string	$cur_page   Current page
     * @return  string
     */
    public function admin_leftmenu($cur_page){
        $config = $this->Csz_model->load_config();
        $html = $this->admin_leftli($cur_page, 'admin', 'admin', $this->lang->line('nav_dash'), 'fa fa-dashboard');
        if($this->Csz_auth_model->is_group_allowed('analytics', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'analytics', 'admin/analytics', $this->lang->line('nav_analytics'), 'fa fa-google');
        if($this->Csz_auth_model->is_group_allowed('pm', 'backend') !== FALSE){
            /* Start Private Message Menu */
            if($cur_page == 'pm' || $cur_page == 'sendpm'){
                $pm_display = "active ";
            }else{
                $pm_display = "";
            }
            $html.= '<li class="'.$pm_display.'treeview"><a href="#"><i class="glyphicon glyphicon-menu-right"></i> <span>'.$this->lang->line('pm_header').'</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
            $html.= '<ul class="treeview-menu">';
            $html.= $this->admin_leftli($cur_page, 'pm', 'admin/pm', $this->lang->line('pm_inbox'), 'glyphicon glyphicon-envelope');
            $html.= $this->admin_leftli($cur_page, 'sendpm', 'admin/pm/sendpm', $this->lang->line('pm_send'), 'glyphicon glyphicon-send');
            $html.= '</ul></li>';
            /* End Private Message Menu */
        }
        if($this->Csz_auth_model->is_group_allowed('forms builder', 'backend') !== FALSE || 
                $this->Csz_auth_model->is_group_allowed('old plugin widget', 'backend') !== FALSE || 
                $this->Csz_auth_model->is_group_allowed('plugin widget', 'backend') !== FALSE ||
                $this->Csz_auth_model->is_group_allowed('linkstats', 'backend') !== FALSE ||
                $this->Csz_auth_model->is_group_allowed('banner', 'backend') !== FALSE ||
                $this->Csz_auth_model->is_group_allowed('carousel', 'backend') !== FALSE ||
                $this->Csz_auth_model->is_group_allowed('pages content', 'backend') !== FALSE ||
                $this->Csz_auth_model->is_group_allowed('navigation', 'backend') !== FALSE ||
                $this->Csz_auth_model->is_group_allowed('file upload', 'backend') !== FALSE ||
                $this->Csz_auth_model->is_group_allowed('file manager', 'backend') !== FALSE
        ){
            /* Start Content Menu */
            if($cur_page == 'navigation' || $cur_page == 'pages' || $cur_page == 'uploadindex' || $cur_page == 'forms' || $cur_page == 'linkstats' || $cur_page == 'widget' || $cur_page == 'pwidget' || $cur_page == 'banner' || $cur_page == 'filemanager' || $cur_page == 'carousel'){
                $content_display = "active ";
            }else{
                $content_display = "";
            }
            $html.= '<li class="'.$content_display.'treeview"><a href="#"><i class="glyphicon glyphicon-menu-right"></i> <span>'.$this->lang->line('nav_content_menu').'</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
            $html.= '<ul class="treeview-menu">';
            if($this->Csz_auth_model->is_group_allowed('forms builder', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'forms', 'admin/forms', $this->lang->line('forms_header'), 'glyphicon glyphicon-modal-window');
            if($this->Csz_auth_model->is_group_allowed('old plugin widget', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'widget', 'admin/widget', $this->lang->line('widget_header'), 'glyphicon glyphicon-gift');
            if($this->Csz_auth_model->is_group_allowed('plugin widget', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'pwidget', 'admin/pwidget', $this->lang->line('pwidget_header'), 'glyphicon glyphicon-gift');
            if($this->Csz_auth_model->is_group_allowed('linkstats', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'linkstats', 'admin/linkstats', $this->lang->line('linkstats_header'), 'glyphicon glyphicon-stats');
            if($this->Csz_auth_model->is_group_allowed('banner', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'banner', 'admin/banner', $this->lang->line('banner_header'), 'glyphicon glyphicon-usd');
            if($this->Csz_auth_model->is_group_allowed('carousel', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'carousel', 'admin/carousel', $this->lang->line('carousel_header'), 'glyphicon glyphicon-picture');
            if($this->Csz_auth_model->is_group_allowed('pages content', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'pages', 'admin/pages', $this->lang->line('pages_header'), 'glyphicon glyphicon-blackboard');
            if($this->Csz_auth_model->is_group_allowed('navigation', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'navigation', 'admin/navigation', $this->lang->line('nav_nav_header'), 'glyphicon glyphicon-object-align-top');
            if($this->Csz_auth_model->is_group_allowed('file upload', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'uploadindex', 'admin/uploadindex', $this->lang->line('uploadfile_header'), 'glyphicon glyphicon-file');
            if($this->Csz_auth_model->is_group_allowed('file manager', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'filemanager', 'admin/filemanager', $this->lang->line('filemanager_header'), 'glyphicon glyphicon-cloud');
            $html.= '</ul></li>';
            /* End Content Menu */
        }
        if($this->Csz_auth_model->is_group_allowed('language', 'backend') !== FALSE || 
                $this->Csz_auth_model->is_group_allowed('general label', 'backend') !== FALSE || 
                $this->Csz_auth_model->is_group_allowed('social', 'backend') !== FALSE ||
                $this->Csz_auth_model->is_group_allowed('plugin manager', 'backend') !== FALSE ||
                $this->Csz_auth_model->is_group_allowed('admin users', 'backend') !== FALSE ||
                $this->Csz_auth_model->is_group_allowed('member users', 'backend') !== FALSE ||
                $this->Csz_auth_model->is_group_allowed('user groups', 'backend') !== FALSE ||
                $this->Csz_auth_model->is_group_allowed('site settings', 'backend') !== FALSE ||
                $this->Csz_auth_model->is_group_allowed('maintenance', 'backend') !== FALSE ||
                $this->Csz_auth_model->is_group_allowed('export', 'backend') !== FALSE
        ){
            /* Start General Menu */
            if($cur_page == 'users' || $cur_page == 'members' || $cur_page == 'groups' || $cur_page == 'social' || $cur_page == 'settings' || $cur_page == 'lang' || $cur_page == 'upgrade' || $cur_page == 'genlabel' || $cur_page == 'plugin' || $cur_page == 'export'){
                $gel_settings_display = "active ";
            }else{
                $gel_settings_display = "";
            }
            $html.= '<li class="'.$gel_settings_display.'treeview"><a href="#"><i class="glyphicon glyphicon-menu-right"></i> <span>'.$this->lang->line('nav_gel_settings').'</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
            $html.= '<ul class="treeview-menu">';
            if($this->Csz_auth_model->is_group_allowed('language', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'lang', 'admin/lang', $this->lang->line('lang_header'), 'glyphicon glyphicon-flag');
            if($this->Csz_auth_model->is_group_allowed('general label', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'genlabel', 'admin/genlabel', $this->lang->line('genlabel_header'), 'glyphicon glyphicon-globe');
            if($this->Csz_auth_model->is_group_allowed('social', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'social', 'admin/social', $this->lang->line('social_header'), 'glyphicon glyphicon-share');       
            if($this->Csz_auth_model->is_group_allowed('plugin manager', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'plugin', 'admin/plugin', $this->lang->line('pluginmgr_header'), 'glyphicon glyphicon-gift');
            if($this->Csz_auth_model->is_group_allowed('admin users', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'users', 'admin/users', $this->lang->line('user_admin_txt'), 'fa fa-user');
            if($this->Csz_auth_model->is_group_allowed('member users', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'members', 'admin/members', $this->lang->line('user_member_txt'), 'fa fa-user');
            if($this->Csz_auth_model->is_group_allowed('user groups', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'groups', 'admin/groups', $this->lang->line('user_group_txt'), 'fa fa-users');
            if($this->Csz_auth_model->is_group_allowed('site settings', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'settings', 'admin/settings', $this->lang->line('settings_header'), 'glyphicon glyphicon-cog');
            if($this->Csz_auth_model->is_group_allowed('maintenance', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'upgrade', 'admin/upgrade', $this->lang->line('maintenance_header'), 'glyphicon glyphicon-compressed');
            if($this->Csz_auth_model->is_group_allowed('export', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'export', 'admin/export', $this->lang->line('export_import_csv_btn'), 'glyphicon glyphicon-export');
            $html.= '</ul></li>';
            /* End General Menu */
        }
        /* Start Plugin Menu */
        $plugin_arr = $this->Csz_model->getValueArray('plugin_config_filename', 'plugin_manager', "plugin_config_filename != '' AND plugin_active = '1'", '', 0);
        $plugin_menu = '';
        if($plugin_arr !== FALSE){
            foreach($plugin_arr as $value){
                $this->lang->load('plugin/'.$value['plugin_config_filename'], $this->Csz_admin_model->getLang());
                $plugin_url[] = $this->Csz_model->getPluginConfig($value['plugin_config_filename'], 'plugin_urlrewrite');
                $perms = $this->Csz_model->getPluginConfig($value['plugin_config_filename'], 'plugin_back_permission_name_backend');
                if($perms !== FALSE){
                    if($this->Csz_auth_model->is_group_allowed($perms, 'backend') !== FALSE){
                        $plugin_menu.= $this->admin_leftli($this->uri->segment(3), $this->Csz_model->getPluginConfig($value['plugin_config_filename'], 'plugin_urlrewrite'), 'admin/plugin/' . $this->Csz_model->getPluginConfig($value['plugin_config_filename'], 'plugin_urlrewrite'), $this->lang->line($value['plugin_config_filename'].'_header'), 'glyphicon glyphicon-gift');
                    }
                }else{
                    $plugin_menu.= $this->admin_leftli($this->uri->segment(3), $this->Csz_model->getPluginConfig($value['plugin_config_filename'], 'plugin_urlrewrite'), 'admin/plugin/' . $this->Csz_model->getPluginConfig($value['plugin_config_filename'], 'plugin_urlrewrite'), $this->lang->line($value['plugin_config_filename'].'_header'), 'glyphicon glyphicon-gift');
                }
            }
            (in_array($this->uri->segment(3), $plugin_url)) ? $plugin_display = "active " : $plugin_display = "";
            $html.= '<li class="'.$plugin_display.'treeview"><a href="#"><i class="glyphicon glyphicon-menu-right"></i> <span>'.$this->lang->line('pluginmgr_header').'</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
            $html.= '<ul class="treeview-menu">';
            $html.= $plugin_menu;
            $html.= '</ul></li>';
        }
        /* End Plugin Menu */
        if($this->Csz_auth_model->is_group_allowed('email logs', 'backend') !== FALSE || $this->Csz_auth_model->is_group_allowed('login logs', 'backend') !== FALSE || $this->Csz_auth_model->is_group_allowed('protection settings', 'backend') !== FALSE){
            /* Start brute force login protection Menu */
            if($cur_page == 'loginlogs' || $cur_page == 'bfsettings' || $cur_page == 'emaillogs' || $cur_page == 'actionslogs'){
                $bf_login_display = "active ";
            }else{
                $bf_login_display = "";
            }
            $html.= '<li class="'.$bf_login_display.'treeview"><a href="#"><i class="glyphicon glyphicon-menu-right"></i> <span>'.$this->lang->line('bf_protection_header').'</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
            $html.= '<ul class="treeview-menu">';
            if($this->Csz_auth_model->is_group_allowed('email logs', 'backend') !== FALSE && $config->email_logs == 1) $html.= $this->admin_leftli($cur_page, 'emaillogs', 'admin/emaillogs', $this->lang->line('emaillogs_header'), 'glyphicon glyphicon-envelope');
            if($this->Csz_auth_model->is_group_allowed('login logs', 'backend') !== FALSE){
                $html.= $this->admin_leftli($cur_page, 'loginlogs', 'admin/loginlogs', $this->lang->line('loginlogs_header'), 'glyphicon glyphicon-list-alt');
                $html.= $this->admin_leftli($cur_page, 'actionslogs', 'admin/actionslogs', $this->lang->line('actionslogs_header'), 'glyphicon glyphicon-list-alt');
            }
            if($this->Csz_auth_model->is_group_allowed('protection settings', 'backend') !== FALSE) $html.= $this->admin_leftli($cur_page, 'bfsettings', 'admin/bfsettings', $this->lang->line('bf_settings'), 'glyphicon glyphicon-cog');
            $html.= '</ul></li>';
            /* End brute force login protection Menu */
        }
        $html.= '<br><li><a href="'.$this->Csz_model->base_link().'/'.'admin/logout"><i class="fa fa-sign-out text-red"></i> <span>'.$this->lang->line('nav_logout').'</span></a></li>';
        unset($config,$cur_page,$gel_settings_display,$pm_display,$content_display,$plugin_arr,$plugin_menu,$plugin_url,$plugin_display,$bf_login_display);
        return $html;
    }

    /**
     * admin_footer
     *
     * Function for footer on backend
     *
     * @return  string
     */
    public function admin_footer(){
        /* Please do not remove or change this function */
        $html = '<footer class="main-footer">
                    <div class="row">
                        <div class="col-md-8 div-copyright">
                            '.$this->Csz_model->cszCopyright().'
                        </div>
                    </div>
            </footer>';
        return $html;
    }

    /**
     * getLastVerAlert
     *
     * Function for show alert nofity on frontend
     *
     * @return  string
     */
    public function getLastVerAlert(){
        $html = '';
        if($this->session->flashdata('f_error_message') != ''){
            $html.= $this->session->flashdata('f_error_message');
        }
        return $html;
    }

    /**
     * memberleftMenu
     *
     * Function for left menu on member page
     *
     * @return  string
     */
    public function memberleftMenu(){
        $html = '';
        if($this->Csz_auth_model->is_group_allowed('pm', 'frontend') !== FALSE){
            $unread = $this->Csz_auth_model->count_unread_pms();
            $unreadhtml = '';
            if($unread != 0){
                $unreadhtml = ' <span class="badge"><b>' . $unread . '</b></span>';
            }
            $html.= '<div class="row"><div class="panel panel-primary">
                    <div class="panel-heading"><b><i class="glyphicon glyphicon-menu-hamburger"></i> '.$this->Csz_model->getLabelLang('pm_txt').'</b></div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked">
                            <li role="presentation" class="text-left"><a href="'.$this->Csz_model->base_link().'/member/indexpm"><i class="glyphicon glyphicon-envelope"></i> '.$this->Csz_model->getLabelLang('pm_inbox_txt').$unreadhtml.'</a></li>
                            <li role="presentation" class="text-left"><a href="'.$this->Csz_model->base_link().'/member/sendpm"><i class="glyphicon glyphicon-send"></i> '.$this->Csz_model->getLabelLang('pm_send_txt').'</a></li>
                        </ul>
                    </div>
                </div></div>';
        }
        $html.= '<div class="row"><div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-menu-hamburger"></i> '.$this->Csz_model->getLabelLang('member_menu').'</b></div>
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">';
        if($this->session->userdata('admin_type') == 'admin'){
            $html.= '<li role="presentation" class="text-left"><a href="'.$this->Csz_model->base_link().'/admin" target="_blank"><i class="glyphicon glyphicon-briefcase"></i> '.$this->Csz_model->getLabelLang('backend_system').'</a></li>';
        }
        if($this->Csz_auth_model->is_group_allowed('pm', 'frontend') !== FALSE){
            $html.= '<li role="presentation" class="text-left"><a href="'.$this->Csz_model->base_link().'/member/list"><i class="glyphicon glyphicon-list-alt"></i> '.$this->Csz_model->getLabelLang('users_list_txt').'</a></li>';
        }
        $html.= '<li role="presentation" class="text-left"><a href="'.$this->Csz_model->base_link().'/member"><i class="glyphicon glyphicon-user"></i> '.$this->Csz_model->getLabelLang('your_profile').'</a></li>
                        <li role="presentation" class="text-left"><a href="'.$this->Csz_model->base_link().'/member/edit"><i class="glyphicon glyphicon-edit"></i> '.$this->Csz_model->getLabelLang('edit_profile').'</a></li>
                        <li role="presentation" class="text-left"><a href="'.$this->Csz_model->base_link().'/member/logout"><b><i class="glyphicon glyphicon-log-out"></i> '.$this->Csz_model->getLabelLang('log_out').'</b></a></li>
                    </ul>
                </div>
            </div></div>';
        /* Start Plugin Menu */
        $plugin_arr = $this->Csz_model->getValueArray('plugin_config_filename', 'plugin_manager', "plugin_config_filename != '' AND plugin_active = '1'", '', 0);
        if($plugin_arr !== FALSE){
            $plugin_menu = '';
            foreach($plugin_arr as $value){
                $plugin_member_menu = $this->Csz_model->getPluginConfig($value['plugin_config_filename'], 'plugin_member_menu');
                if($plugin_member_menu){
                    $perms = $this->Csz_model->getPluginConfig($value['plugin_config_filename'], 'plugin_menu_permission_name');
                    ($perms) ? $perm_chk = $this->Csz_auth_model->is_group_allowed($perms, 'frontend') : $perm_chk = TRUE;
                    if($perm_chk !== FALSE){
                        $plugin_menu.= '<li role="presentation" class="text-left"><a href="'.$this->Csz_model->base_link().'/plugin/'.$this->Csz_model->getPluginConfig($value['plugin_config_filename'], 'plugin_urlrewrite').'"><i class="glyphicon glyphicon-gift"></i> '.$plugin_member_menu.'</a></li>';               
                    }
                }
            }
            if($plugin_menu){
                $html.= '<div class="row"><div class="panel panel-primary">
                    <div class="panel-heading"><b><i class="glyphicon glyphicon-menu-hamburger"></i> '.$this->Csz_model->getLabelLang('plugin_member_menu').'</b></div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked">
                        '.$plugin_menu.'
                        </ul>
                    </div>
                </div></div>';
            }
        }
        /* End Plugin Menu */
        unset($unread,$unreadhtml,$plugin_arr,$plugin_member_menu,$perms,$perm_chk,$plugin_menu,$value);
        return $html;
    }
    
    /**
     * getHtmlContent
     *
     * Function for convert HTML for form linkstats and widget
     *
     * @param	string	$ori_content    Original content
     * @return	string
     */
    public function getAdminContent($ori_content) { /* Calculate the HTML code */
        return $this->carouselInHtml($ori_content);
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
        $output_array = array();
        $txt_nonhtml = strip_tags($content);
        preg_match_all("/\[\?\]\{=carousel\:(.*?)\}\[\?\]/", $txt_nonhtml, $output_array);
        if(!empty($output_array[0])){
            for ($i = 0; $i < count($output_array[0]); $i++) {
                if (!empty($output_array[0][$i]) && strpos($output_array[0][$i], '[?]{=carousel:') !== false && !empty($output_array[1][$i])) {
                    $content = $this->addCarouselToHTML($content, $output_array[1][$i]);
                }
            }
        }
        unset($output_array, $txt_nonhtml);
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
        $getCarousel = $this->Csz_model->getValue('*', 'carousel_widget', "active = '1' AND carousel_widget_id = '" . $id . "'", '', 1);
        $html = '[?]{=carousel:' . $id . '}[?]';
        if ($getCarousel !== FALSE) {
            if ($getCarousel->custom_temp_active && $getCarousel->custom_template) {
                $html = $getCarousel->custom_template;
            } else {
                $getPhoto = $this->Csz_model->getValueArray('*', 'carousel_picture', "carousel_widget_id = '" . $getCarousel->carousel_widget_id . "'", '', '', 'arrange', 'ASC');
                $html = '';
                if ($getPhoto !== FALSE) {
                    $i = 0;
                    $li_html = '';
                    $item_html = '';
                    $photo_path = base_url() . 'photo/carousel/';
                    foreach ($getPhoto as $value) {
                        $active = '';
                        $class_active = '';
                        if ($i == 0) {
                            $active = ' active';
                            $class_active = ' class="active"';
                        }
                        if ($value['caption'] && $value['caption'] != NULL) {
                            $caption = '<div class="carousel-caption">' . $value['caption'] . '</div>';
                            $alt_img = ' alt="' . $value['caption'] . '"';
                        } else {
                            $caption = '';
                            $alt_img = ' alt="' . $getCarousel->name . '"';
                        }
                        if ($value['carousel_type'] == 'multiimages' && $value['file_upload'] && $value['file_upload'] != NULL) {
                            $item_add = '<img src="' . $photo_path . $value['file_upload'] . '" class="img-responsive" width="100%"' . $alt_img . '>';
                        } else if ($value['carousel_type'] == 'multiimages' && $value['photo_url'] && $value['photo_url'] != NULL) {
                            $item_add = '<img src="' . $value['photo_url'] . '" class="img-responsive" width="100%"' . $alt_img . '>';
                        } else if ($value['carousel_type'] == 'youtubevideos' && $value['youtube_url']) {
                            $youtube_script_replace = array("http://", "https://", "www.youtube.com/watch?v=", "m.youtube.com/watch?v=", "youtu.be/", "www.youtube.com/embed/", "m.youtube.com/embed/");
                            $youtube_value = str_replace($youtube_script_replace, '', $value['youtube_url']);
                            $item_add = '<div class="embed-responsive embed-responsive-16by9" style="background-color: #000;"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' . $youtube_value . '" allowfullscreen="allowfullscreen" width="100%"></iframe></div>';
                        }
                        $li_html .= '<li data-target="#myCarousel-' . $getCarousel->carousel_widget_id . '" data-slide-to="' . $i . '"' . $class_active . '></li>';
                        $item_html .= '<div class="item' . $active . '"><div class="fill">' . $item_add . '</div>' . $caption . '</div>';
                        $i++;
                    }
                    $html = '<cszcarouseltag' . $getCarousel->carousel_widget_id . '><div id="myCarousel-' . $getCarousel->carousel_widget_id . '" class="carousel slide">';
                    $html .= '<ol class="carousel-indicators">';
                    $html .= $li_html;
                    $html .= '</ol><div class="carousel-inner">';
                    $html .= $item_html;
                    $html .= '</div><a class="left carousel-control" href="#myCarousel-' . $getCarousel->carousel_widget_id . '" data-slide="prev"><span class="icon-prev"></span></a><a class="right carousel-control" href="#myCarousel-' . $getCarousel->carousel_widget_id . '" data-slide="next"><span class="icon-next"></span></a>';
                    $html .= '</div></cszcarouseltag' . $getCarousel->carousel_widget_id . '>';
                }
            }
        }
        return str_replace('[?]{=carousel:' . $id . '}[?]', $html, $content);
    }
}
