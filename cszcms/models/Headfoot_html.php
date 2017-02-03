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

class Headfoot_html extends CI_Model {
    
    function __construct() {
            parent::__construct();
            $this->load->model('Csz_admin_model');
            $this->lang->load('admin', $this->Csz_admin_model->getLang());
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
            $logo = '<img alt="Site Logo" class="site-logo" src="'.base_url().'photo/logo/'.$row->site_logo.'">';
        }else{
            $logo = $row->site_name;
        }       
        return $logo;
    }

    /**
     * topmenu
     *
     * Function for get the top menu on frontend
     *
     * @param	string	$cur_page    current page
     * @return  string
     */
    public function topmenu($cur_page){
        $menu_list = '';
        $cur_page_lang = $this->Csz_model->getValue('lang_iso', 'pages', 'page_url', $cur_page, 1);
        if($cur_page_lang === FALSE){
            $cur_page_lang_iso = $this->session->userdata('fronlang_iso');
        }else{
            $cur_page_lang_iso = $cur_page_lang->lang_iso;
            $this->Csz_model->setSiteLang($cur_page_lang_iso);
        }
        $get_mainmenu = $this->Csz_model->main_menu('', $cur_page_lang_iso);
        if($get_mainmenu === FALSE){
            $get_mainmenu = $this->Csz_model->main_menu('', $this->Csz_model->getDefualtLang());
        }
        if(!empty($get_mainmenu)){
            foreach ($get_mainmenu as $rs){
                $page_url_rs = $this->Csz_model->getPageUrlFromID($rs->pages_id);
                if($page_url_rs && (!$rs->other_link && !$rs->plugin_menu) || ($rs->other_link == NULL && $rs->plugin_menu == NULL)){
                    $page_link = base_url().$page_url_rs;
                    $target = '';
                }else if($rs->other_link && (!$page_url_rs && !$rs->plugin_menu) || ($page_url_rs == NULL && $rs->plugin_menu == NULL)){
                    $page_link = $rs->other_link;
                    if (substr($rs->other_link, 0, 1) === '#') {
                        $target = '';
                    }else{
                        $target = ' target="_blank"';
                    }
                }else if((!$rs->other_link && !$page_url_rs) || ($rs->other_link == NULL && $page_url_rs == NULL) && $rs->plugin_menu){
                    if($rs->plugin_menu == 'member'){
                        $page_link = base_url().$rs->plugin_menu;
                    }else{
                        $page_link = base_url().'plugin/'.$rs->plugin_menu;
                    }
                    $target = '';
                }else{
                    $page_link = '#';
                    $target = '';
                }
                if($page_url_rs == $cur_page || $rs->plugin_menu == $cur_page){
                    $active = ' id="active"';
                }else{
                    $active = "";
                }
                if($rs->drop_menu){
                    $menu_list.= '<li class="dropdown">
                    <a aria-expanded="true" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#" title="'.$rs->menu_name.'">'.$rs->menu_name.' <span class="caret"></span></a>
                    <ul class="dropdown-menu">';
                    $drop_menu = $this->Csz_model->main_menu($rs->page_menu_id, $cur_page_lang_iso);
                    if($drop_menu === FALSE){
                        $drop_menu = $this->Csz_model->main_menu($rs->page_menu_id, $this->Csz_model->getDefualtLang());
                    }
                    if(!empty($drop_menu)){
                        foreach ($drop_menu as $rs_sub){
                            $page_url_rs_sub = $this->Csz_model->getPageUrlFromID($rs_sub->pages_id);
                            if($page_url_rs_sub && (!$rs_sub->other_link && !$rs_sub->plugin_menu) || ($rs_sub->other_link == NULL && $rs_sub->plugin_menu == NULL)){
                                $page_link_sub = base_url().$page_url_rs_sub;
                                $target_sub = '';      
                            }else if($rs_sub->other_link && (!$page_url_rs_sub  && !$rs_sub->plugin_menu) || ($page_url_rs_sub == NULL  && $rs_sub->plugin_menu == NULL)){
                                $page_link_sub = $rs_sub->other_link;
                                if (substr($rs_sub->other_link, 0, 1) === '#') {
                                    $target_sub = '';
                                }else{
                                    $target_sub = ' target="_blank"';
                                }  
                            }else if((!$page_url_rs_sub && !$rs_sub->other_link) || ($page_url_rs_sub == NULL && $rs_sub->other_link == NULL) && $rs_sub->plugin_menu){
                                if($rs_sub->plugin_menu == 'member'){
                                    $page_link_sub = base_url().$rs_sub->plugin_menu;
                                }else{
                                    $page_link_sub = base_url().'plugin/'.$rs_sub->plugin_menu;
                                }
                                $target_sub = '';
                            }else{
                                $page_link_sub = '#';
                                $target_sub = '';
                            }
                            $menu_list.= '<li><a href="'.$page_link_sub.'"'.$target_sub.' title="'.$rs_sub->menu_name.'">'.$rs_sub->menu_name.'</a></li>';
                        }    
                    }   
                    $menu_list.= '</ul></li>';
                }else{
                    $menu_list.= '<li><a'.$active.' href="'.$page_link.'"'.$target.' title="'.$rs->menu_name.'">'.$rs->menu_name.'</a></li>';
                }
            } 
        }
        return $menu_list;
    }
    
    /**
     * getSocial
     *
     * Function for get social
     *
     * @return  string
     */
    public function getSocial(){
        $social_list = '';
        if($this->Csz_model->getSocial()){
            foreach ($this->Csz_model->getSocial() as $rs){
                if($rs->social_url){
                    $socail_url = $rs->social_url;
                    $target = ' target="_blank"';
                }else{
                    $socail_url = '#';
                    $target = '';
                }
                $social_list.= '<li><a href="'.$socail_url.'"'.$target.' rel="nofollow external" title="'.$rs->social_name.'"><i class="fa fa-'.$rs->social_name.'"></i></a></li>';
            }
        }
        $html = '<ul class="list-inline social-buttons">
                    '.$social_list.'
                </ul>';
        return $html;
    }
    
    /**
     * langMenu
     *
     * Function for language menu
     *
     * @param	string	$type    language menu type 1=Show flag only, 2=Show flag and Language, 3=Show flag and Country or null=Show Full detail
     * @return  string
     */
    public function langMenu($type = ''){
        $lang_list = '';
        $i = 0;
        foreach ($this->Csz_model->loadAllLang(1) as $rs){
            ($rs->lang_iso) ? $lang_url = base_url().'lang/'.$rs->lang_iso : $lang_url = base_url().'lang/';
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
    private function admin_leftli($cur_page,$page_chk,$url,$menu_name,$icon){
        $active = '';
        $glyp_icon = '';
        if($cur_page == $page_chk){
            $active = ' class="active"';
        }
        if($icon){
            $glyp_icon = '<i class="'.$icon.'"></i> ';
        }
        $html = '<li'.$active.'><a href="'.base_url().''.$url.'">'.$glyp_icon.'<span>'.$menu_name.'</span></a></li>';
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
        if(admin_helper::is_a_member($this->session->userdata('admin_type')) === FALSE){
            $config = $this->Csz_admin_model->load_config();
            $html = $this->admin_leftli($cur_page,'admin','admin',$this->lang->line('nav_dash'),'fa fa-dashboard');
            $html.= $this->admin_leftli($cur_page,'analytics','admin/analytics',$this->lang->line('nav_analytics'),'fa fa-google');
            /* Start Content Menu */
            if($cur_page == 'navigation' || $cur_page == 'pages' || $cur_page == 'uploadindex' || $cur_page == 'forms'  || $cur_page == 'linkstats'){
                $content_display = "active ";
            }else{
                $content_display = "";
            }
            $html.= '<li class="'.$content_display.'treeview"><a href="#"><i class="glyphicon glyphicon-menu-hamburger"></i><span>'.$this->lang->line('nav_content_menu').'</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
            $html.= '<ul class="treeview-menu">';
            $html.= $this->admin_leftli($cur_page,'forms','admin/forms',$this->lang->line('forms_header'),'glyphicon glyphicon-modal-window');
            $html.= $this->admin_leftli($cur_page,'widget','admin/widget',$this->lang->line('widget_header'),'glyphicon glyphicon-gift');
            $html.= $this->admin_leftli($cur_page,'uploadindex','admin/uploadindex',$this->lang->line('uploadfile_header'),'glyphicon glyphicon-picture');
            $html.= $this->admin_leftli($cur_page,'pages','admin/pages',$this->lang->line('pages_header'),'glyphicon glyphicon-file');
            $html.= $this->admin_leftli($cur_page,'navigation','admin/navigation',$this->lang->line('nav_nav_header'),'glyphicon glyphicon-object-align-top');       
            if($config->link_statistic_active) $html.= $this->admin_leftli($cur_page,'linkstats','admin/linkstats',$this->lang->line('linkstats_header'),'glyphicon glyphicon-stats');
            $html.= '</ul></li>';
            /* End Content Menu */
            /* Start General Menu */
            if($cur_page == 'users' || $cur_page == 'social' || $cur_page == 'settings' || $cur_page == 'lang' || $cur_page == 'upgrade' || $cur_page == 'genlabel' || $cur_page == 'plugin'){
                $gel_settings_display = "active ";
            }else{
                $gel_settings_display = "";
            }
            $html.= '<li class="'.$gel_settings_display.'treeview"><a href="#"><i class="glyphicon glyphicon-menu-hamburger"></i><span>'.$this->lang->line('nav_gel_settings').'</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
            $html.= '<ul class="treeview-menu">';
            $html.= $this->admin_leftli($cur_page,'lang','admin/lang',$this->lang->line('lang_header'),'glyphicon glyphicon-globe');
            if($this->session->userdata('admin_type') == 'admin'){ 
                $html.= $this->admin_leftli($cur_page,'genlabel','admin/genlabel',$this->lang->line('genlabel_header'),'glyphicon glyphicon-globe'); 
                $html.= $this->admin_leftli($cur_page,'settings','admin/settings',$this->lang->line('settings_header'),'glyphicon glyphicon-cog'); 
            }
            $html.= $this->admin_leftli($cur_page,'social','admin/social',$this->lang->line('social_header'),'glyphicon glyphicon-share');
            if($this->session->userdata('admin_type') == 'admin'){ $html.= $this->admin_leftli($cur_page,'upgrade','admin/upgrade',$this->lang->line('maintenance_header'),'glyphicon glyphicon-compressed'); }        
            $html.= $this->admin_leftli($cur_page,'plugin','admin/plugin',$this->lang->line('pluginmgr_header'),'glyphicon glyphicon-gift');
            $html.= $this->admin_leftli($cur_page,'users','admin/users',$this->lang->line('nav_admin_users'),'glyphicon glyphicon-user');
            $html.= '</ul></li>';
            /* End General Menu */
            /* Start Plugin Menu */
            $plugin_arr = $this->Csz_model->getValueArray('plugin_name,plugin_urlrewrite', 'plugin_manager', "plugin_urlrewrite != '' AND plugin_active = '1'", '', 0);
            $plugin_menu = '';
            if($plugin_arr !== FALSE){
                foreach ($plugin_arr as $value) {
                    $plugin_url[] = $value['plugin_urlrewrite'];
                    $plugin_menu.= $this->admin_leftli($cur_page,$value['plugin_urlrewrite'],'admin/plugin/'.$value['plugin_urlrewrite'],$value['plugin_name'],'glyphicon glyphicon-gift');
                }
            }
            (in_array($cur_page, $plugin_url)) ? $plugin_display = "" : $plugin_display = "display: none;";
            $html.= '<li class="'.$plugin_display.'treeview"><a href="#"><i class="glyphicon glyphicon-menu-hamburger"></i><span>'.$this->lang->line('pluginmgr_header').'</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
            $html.= '<ul class="treeview-menu">';
            $html.= $plugin_menu;
            $html.= '</ul></li>';            
            /* End Plugin Menu */
            /* Start brute force login protection Menu */
            if($this->session->userdata('admin_type') == 'admin'){
                if($cur_page == 'loginlogs' || $cur_page == 'bfsettings' || $cur_page == 'emaillogs'){
                    $bf_login_display = "active ";
                }else{
                    $bf_login_display = "";
                }
                $html.= '<li class="'.$bf_login_display.'treeview"><a href="#"><i class="glyphicon glyphicon-menu-hamburger"></i><span>'.$this->lang->line('bf_protection_header').'</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
                $html.= '<ul class="treeview-menu">';
                $html.= $this->admin_leftli($cur_page,'emaillogs','admin/emaillogs',$this->lang->line('emaillogs_header'),'glyphicon glyphicon-envelope');
                $html.= $this->admin_leftli($cur_page,'loginlogs','admin/loginlogs',$this->lang->line('loginlogs_header'),'glyphicon glyphicon-list-alt');
                $html.= $this->admin_leftli($cur_page,'bfsettings','admin/bfsettings',$this->lang->line('bf_settings'),'glyphicon glyphicon-cog');
                $html.= '</ul></li>';
            }
            /* End brute force login protection Menu */
            $html.= '<br><li><a href="' . base_url() . 'admin/logout"><i class="fa fa-sign-out text-red"></i> <span>' . $this->lang->line('nav_logout') . '</span></a></li>';
            return $html;
        }
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
    public function getLastVerAlert() {
        if(!$this->session->userdata('fronlang_iso')) {
            $lang_iso = 'en';
        }else{
            $lang_iso = $this->session->userdata('fronlang_iso');
        }
        $lang_name = $this->Csz_admin_model->getLangNamefromISO($lang_iso);
        $this->lang->load('admin', $lang_name);
        $html = '';
        if($this->session->flashdata('f_error_message') != ''){ 
            $html.= $this->session->flashdata('f_error_message');
        }
        if(!$this->session->userdata('cszcms_chkver')){
            $data = array('cszcms_chkver' => $this->Csz_admin_model->chkVerUpdate($this->Csz_model->getVersion()));
            $this->session->set_userdata($data);
        }
        if($this->session->userdata('cszcms_chkver') !== FALSE){
            $html.= '<div class="alert alert-warning text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$this->lang->line('upgrade_newlast_alert').'</div>';
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
    public function memberleftMenu() {
        $html = '<div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-menu-hamburger"></i> '.$this->Csz_model->getLabelLang('member_menu').'</b></div>
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">';
                        if ($this->session->userdata('admin_type') != 'member') {
                            $html.= '<li role="presentation" class="text-left"><a href="'.BASE_URL.'/admin" target="_blank"><i class="glyphicon glyphicon-briefcase"></i> '.$this->Csz_model->getLabelLang('backend_system').'</a></li>';
                        }
                        $html.= '<li role="presentation" class="text-left"><a href="'.BASE_URL.'/member"><i class="glyphicon glyphicon-user"></i> '.$this->Csz_model->getLabelLang('your_profile').'</a></li>
                        <li role="presentation" class="text-left"><a href="'.BASE_URL.'/member/edit"><i class="glyphicon glyphicon-edit"></i> '.$this->Csz_model->getLabelLang('edit_profile').'</a></li>
                        <li role="presentation" class="text-left"><a href="'.BASE_URL.'/member/logout"><i class="glyphicon glyphicon-log-out"></i> '.$this->Csz_model->getLabelLang('log_out').'</a></li>
                    </ul>
                </div>
            </div>';
        return $html;
    }
}

