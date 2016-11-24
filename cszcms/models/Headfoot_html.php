<?php
/**
 * CSZ CMS
 *
 * An open source content management system
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2016, CSZ CMS Team
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * @package	Headfoot_html
 * @author	CSKAZA Dev Team
 * @copyright   Copyright (c) 2016, CSKAZA for CSZ CMS. (https://www.cszcms.com)
 * @license	http://opensource.org/licenses/MIT	MIT License
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
                if($page_url_rs && !$rs->other_link && !$rs->plugin_menu){
                    $page_link = base_url().$page_url_rs;
                    $target = '';
                }else if($rs->other_link && !$page_url_rs && !$rs->plugin_menu){
                    $page_link = $rs->other_link;
                    $target = ' target="_blank"';
                }else if(!$rs->other_link && !$page_url_rs && $rs->plugin_menu){
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
                            if($page_url_rs_sub && !$rs_sub->other_link && !$rs_sub->plugin_menu){
                                $page_link_sub = base_url().$page_url_rs_sub;
                                $target_sub = '';      
                            }else if($rs_sub->other_link && !$page_url_rs_sub  && !$rs_sub->plugin_menu){
                                $page_link_sub = $rs_sub->other_link;
                                $target_sub = ' target="_blank"';       
                            }else if(!$page_url_rs_sub && !$rs_sub->other_link && $rs_sub->plugin_menu){
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
     * admin_topmenu
     *
     * Function for top menu on backend
     *
     * @return  string
     */
    public function admin_topmenu(){
        if(admin_helper::is_a_member($this->session->userdata('admin_type')) === FALSE){
            $config = $this->Csz_admin_model->load_config();
            $userdata = $this->Csz_admin_model->getUser($this->session->userdata('user_admin_id'));
            $html = '<nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="'.base_url().'admin">'.$this->lang->line('backend_system').'</a>
                    </div>            
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="'.base_url().'" target="_blank"><span class="glyphicon glyphicon-eye-open"></span> '.$this->lang->line('nav_view_site').'</a></li>                        
                            <li><a href="'.base_url().'admin/users/edit/'.$this->session->userdata('user_admin_id').'"><span class="glyphicon glyphicon-user"></span> '.$userdata->name.'</a></li>
                            <li class="dropdown">
                                <a aria-expanded="true" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="glyphicon glyphicon-menu-hamburger"></i> '.$this->lang->line('nav_content_menu').'</a>
                                <ul class="dropdown-menu">
                                    <li><a href="'.base_url().'admin/forms"><i class="glyphicon glyphicon-modal-window"></i> '.$this->lang->line('forms_header').'</a></li>
                                    <li><a href="'.base_url().'admin/widget"><i class="glyphicon glyphicon-gift"></i> '.$this->lang->line('widget_header').'</a></li>
                                    <li><a href="'.base_url().'admin/uploadindex"><i class="glyphicon glyphicon-picture"></i> '.$this->lang->line('uploadfile_header').'</a></li>
                                    <li><a href="'.base_url().'admin/pages"><i class="glyphicon glyphicon-file"></i> '.$this->lang->line('pages_header').'</a></li> 
                                    <li><a href="'.base_url().'admin/navigation"><i class="glyphicon glyphicon-object-align-top"></i> '.$this->lang->line('nav_nav_header').'</a></li>';                             
                                    if($config->link_statistic_active) $html.= '<li><a href="'.base_url().'admin/linkstats"><i class="glyphicon glyphicon-stats"></i> '.$this->lang->line('linkstats_header').'</a></li>';
                                $html.= '</ul>
                            </li>
                            <li class="dropdown">
                                <a aria-expanded="true" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="glyphicon glyphicon-menu-hamburger"></i> '.$this->lang->line('nav_general_menu').'</a>
                                <ul class="dropdown-menu">
                                    <li><a href="'.base_url().'admin/lang"><i class="glyphicon glyphicon-globe"></i> '.$this->lang->line('lang_header').'</a></li>';
                            if($this->session->userdata('admin_type') == 'admin'){ 
                                $html.= '<li><a href="'.base_url().'admin/genlabel"><i class="glyphicon glyphicon-globe"></i> '.$this->lang->line('genlabel_header').'</a></li>'; 
                                $html.= '<li><a href="'.base_url().'admin/settings"><i class="glyphicon glyphicon-cog"></i> '.$this->lang->line('settings_header').'</a></li>'; 
                            }
                            $html.= '<li><a href="'.base_url().'admin/social"><i class="glyphicon glyphicon-share"></i> '.$this->lang->line('social_header').'</a></li>';
                            if($this->session->userdata('admin_type') == 'admin'){ $html.= '<li><a href="'.base_url().'admin/upgrade"><i class="glyphicon glyphicon-compressed"></i> '.$this->lang->line('maintenance_header').'</a></li>'; }   
                            $html.= '<li><a href="'.base_url().'admin/plugin"><i class="glyphicon glyphicon-gift"></i> '.$this->lang->line('pluginmgr_header').'</a></li>';
                            $html.= '<li><a href="'.base_url().'admin/users"><i class="glyphicon glyphicon-user"></i> '.$this->lang->line('nav_admin_users').'</a></li>
                                     <hr><li><a href="'.BASE_URL.'/admin/upgrade/clearAllCache" onclick="return confirm(\''.$this->lang->line('delete_message').'\');"><i class="glyphicon glyphicon-erase"></i> '.$this->lang->line('btn_clearallcache').'</a></li>
                                         <li><a href="'.BASE_URL.'/admin/upgrade/clearAllDBCache" onclick="return confirm(\''.$this->lang->line('delete_message').'\');"><i class="glyphicon glyphicon-erase"></i> '.$this->lang->line('btn_clearalldbcache').'</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a aria-expanded="true" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="glyphicon glyphicon-menu-hamburger"></i> '.$this->lang->line('pluginmgr_header').'</a>
                                <ul class="dropdown-menu">';
                                    $plugin_arr = $this->Csz_model->getValueArray('plugin_name,plugin_urlrewrite', 'plugin_manager', "plugin_urlrewrite != '' AND plugin_active = '1'", '', 0);
                                    if($plugin_arr !== FALSE){
                                        foreach ($plugin_arr as $value) {
                                            $html.= '<li><a href="'.base_url().'admin/plugin/'.$value['plugin_urlrewrite'].'"><i class="glyphicon glyphicon-gift"></i> '.$value['plugin_name'].'</a></li>';
                                        }
                                    }
                                $html.= '</ul>
                            </li>
                            <li><a href="'.base_url().'admin/logout"><i class="glyphicon glyphicon-log-out"></i> '.$this->lang->line('nav_logout').'</a></li>
                        </ul> 
                    </div>           
                </div>
            </nav>';
            return $html;
        }
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
    private function admin_leftli($cur_page,$page_chk,$url,$menu_name,$icon,$submenu = FALSE){
        $active = '';
        $glyp_icon = '';
        $sub_menu = '';
        if($cur_page == $page_chk){
            $active = ' class="active"';
        }
        if($icon){
            $glyp_icon = '<span class="glyphicon '.$icon.'"></span> ';
        }
        if($submenu){
            $sub_menu = '- ';
        }
        $html = '<li'.$active.'><a href="'.base_url().''.$url.'">'.$sub_menu.''.$glyp_icon.''.$menu_name.'</a></li>';
        return $html;
    }

    /**
     * admin_leftmenu
     *
     * Function for left menu on backend
     *
     * @param	string	$cur_page   Current page
     * @return  string
     */
    public function admin_leftmenu($cur_page){
        if(admin_helper::is_a_member($this->session->userdata('admin_type')) === FALSE){
            $config = $this->Csz_admin_model->load_config();
            $html = '<ul class="nav nav-sidebar">';
            $html.= $this->admin_leftli($cur_page,'admin','admin',$this->lang->line('nav_dash'),'glyphicon-dashboard');
            $html.= '</ul><hr>';
            $html.= '<ul class="nav nav-sidebar">';
            $html.= '<li><a href="#" title="'.$this->lang->line('nav_content_menu').'" onclick="ChkHideShow(\'content_menu\');"><span class="glyphicon glyphicon-menu-hamburger"></span> '.$this->lang->line('nav_content_menu').'</a></li>';
            if($cur_page == 'navigation' || $cur_page == 'pages' || $cur_page == 'uploadindex' || $cur_page == 'forms'  || $cur_page == 'linkstats'){
                $gel_settings_display = "";
            }else{
                $gel_settings_display = "display: none;";
            }
            $html.= '<ul id="content_menu" class="nav nav-sidebar" style="'.$gel_settings_display.'padding: 0 25px;">';
            $html.= $this->admin_leftli($cur_page,'forms','admin/forms',$this->lang->line('forms_header'),'glyphicon-modal-window',TRUE);
            $html.= $this->admin_leftli($cur_page,'widget','admin/widget',$this->lang->line('widget_header'),'glyphicon-gift',TRUE);
            $html.= $this->admin_leftli($cur_page,'uploadindex','admin/uploadindex',$this->lang->line('uploadfile_header'),'glyphicon-picture',TRUE);
            $html.= $this->admin_leftli($cur_page,'pages','admin/pages',$this->lang->line('pages_header'),'glyphicon-file',TRUE);
            $html.= $this->admin_leftli($cur_page,'navigation','admin/navigation',$this->lang->line('nav_nav_header'),'glyphicon-object-align-top',TRUE);       
            if($config->link_statistic_active) $html.= $this->admin_leftli($cur_page,'linkstats','admin/linkstats',$this->lang->line('linkstats_header'),'glyphicon-stats',TRUE);
            $html.= '</ul></ul><hr>';
            $html.= '<ul class="nav nav-sidebar">';
            $html.= '<li><a href="#" title="'.$this->lang->line('nav_gel_settings').'" onclick="ChkHideShow(\'gel_settings\');"><span class="glyphicon glyphicon-menu-hamburger"></span> '.$this->lang->line('nav_gel_settings').'</a></li>';
            if($cur_page == 'users' || $cur_page == 'social' || $cur_page == 'settings' || $cur_page == 'lang' || $cur_page == 'upgrade' || $cur_page == 'genlabel' || $cur_page == 'plugin'){
                $gel_settings_display = "";
            }else{
                $gel_settings_display = "display: none;";
            }
            $html.= '<ul id="gel_settings" class="nav nav-sidebar" style="'.$gel_settings_display.'padding: 0 25px;">';
            $html.= $this->admin_leftli($cur_page,'lang','admin/lang',$this->lang->line('lang_header'),'glyphicon-globe',TRUE);
            if($this->session->userdata('admin_type') == 'admin'){ 
                $html.= $this->admin_leftli($cur_page,'genlabel','admin/genlabel',$this->lang->line('genlabel_header'),'glyphicon-globe',TRUE); 
                $html.= $this->admin_leftli($cur_page,'settings','admin/settings',$this->lang->line('settings_header'),'glyphicon-cog',TRUE); 
            }
            $html.= $this->admin_leftli($cur_page,'social','admin/social',$this->lang->line('social_header'),'glyphicon-share',TRUE);
            if($this->session->userdata('admin_type') == 'admin'){ $html.= $this->admin_leftli($cur_page,'upgrade','admin/upgrade',$this->lang->line('maintenance_header'),'glyphicon-compressed',TRUE); }        
            $html.= $this->admin_leftli($cur_page,'plugin','admin/plugin',$this->lang->line('pluginmgr_header'),'glyphicon-gift',TRUE);
            $html.= $this->admin_leftli($cur_page,'users','admin/users',$this->lang->line('nav_admin_users'),'glyphicon-user',TRUE);
            $html.= '</ul></ul><hr>';
            
            $html.= '<ul class="nav nav-sidebar">';
            $html.= '<li><a href="#" title="'.$this->lang->line('pluginmgr_header').'" onclick="ChkHideShow(\'plugins\');"><span class="glyphicon glyphicon-menu-hamburger"></span> '.$this->lang->line('pluginmgr_header').'</a></li>';
            $plugin_arr = $this->Csz_model->getValueArray('plugin_name,plugin_urlrewrite', 'plugin_manager', "plugin_urlrewrite != '' AND plugin_active = '1'", '', 0);
            $plugin_menu = '';
            if($plugin_arr !== FALSE){
                foreach ($plugin_arr as $value) {
                    $plugin_url[] = $value['plugin_urlrewrite'];
                    $plugin_menu.= $this->admin_leftli($cur_page,$value['plugin_urlrewrite'],'admin/plugin/'.$value['plugin_urlrewrite'],$value['plugin_name'],'glyphicon-gift',TRUE);
                }
            }
            (in_array($cur_page, $plugin_url)) ? $plugin_display = "" : $plugin_display = "display: none;";
            $html.= '<ul id="plugins" class="nav nav-sidebar" style="'.$plugin_display.'padding: 0 25px;">';
            $html.= $plugin_menu;
            $html.= '</ul></ul><hr>';
            $html.= '<ul class="nav nav-sidebar">
                        <li><a href="'.base_url().'admin/logout"><span class="glyphicon glyphicon-log-out"></span> '.$this->lang->line('nav_logout').'</a></li>
                    </ul>';
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
        $html = '<footer>
                    <hr>
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

