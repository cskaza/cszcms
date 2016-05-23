<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Headfoot_html extends CI_Model {
    
    function __construct() {
            parent::__construct();
            $this->load->model('Csz_model');
            $this->load->model('Csz_admin_model');
            $this->lang->load('admin', $this->Csz_admin_model->getLang());
    }
    
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

    public function topmenu($cur_page){
        $menu_list = '';
        foreach ($this->Csz_model->main_menu('', $this->session->userdata('fronlang_iso')) as $rs){
            $page_url_rs = $this->Csz_model->getPageUrlFromID($rs->pages_id);
            if($page_url_rs && !$rs->other_link){
                $page_link = base_url().$page_url_rs;
                $target = '';
            }else if($rs->other_link){
                $page_link = $rs->other_link;
                $target = ' target="_blank"';
            }else{
                $page_link = '#';
                $target = '';
            }
            if($page_url_rs == $cur_page){
                $active = ' id="active"';
            }else{
                $active = "";
            }
            if($rs->drop_menu){
                $drop_menu = $this->Csz_model->main_menu($rs->page_menu_id, $this->session->userdata('fronlang_iso'));
                if(is_array($drop_menu)){
                    foreach ($drop_menu as $rs1){
                        $page_url_rs1 = $this->Csz_model->getPageUrlFromID($rs1->pages_id);
                        if($page_url_rs1 == $cur_page){
                            $active = ' id="active"';
                        }else{
                            $active = "";
                        }
                    }
                }
                $menu_list.= '<li class="dropdown">
                <a aria-expanded="true" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">'.$rs->menu_name.' <span class="caret"></span></a>
                <ul class="dropdown-menu">';
                $drop_menu = $this->Csz_model->main_menu($rs->page_menu_id, $this->session->userdata('fronlang_iso'));
                if(is_array($drop_menu)){
                    foreach ($drop_menu as $rs_sub){
                        $page_url_rs_sub = $this->Csz_model->getPageUrlFromID($rs_sub->pages_id);
                        if($page_url_rs_sub && !$rs_sub->other_link){
                            $page_link_sub = base_url().$page_url_rs_sub;
                            $target_sub = '';      
                        }else if($rs_sub->other_link){
                            $page_link_sub = $rs_sub->other_link;
                            $target_sub = ' target="_blank"';                      
                        }else{
                            $page_link_sub = '#';
                            $target_sub = '';
                        }
                        $menu_list.= '<li><a href="'.$page_link_sub.'"'.$target_sub.'>'.$rs_sub->menu_name.'</a></li>';
                    }    
                }   
                $menu_list.= '</ul></li>';
            }else{
                $menu_list.= '<li><a'.$active.' href="'.$page_link.'"'.$target.'>'.$rs->menu_name.'</a></li>';
            }
        }       
        return $menu_list;
    }
    
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
                $social_list.= '<li><a href="'.$socail_url.'"'.$target.' rel="nofollow external"><i class="fa fa-'.$rs->social_name.'"></i></a></li>';
            }
        }
        $html = '<ul class="list-inline social-buttons">
                    '.$social_list.'
                </ul>';
        return $html;
    }
    
    public function langMenu($type = ''){
        $lang_list = '';
        $i = 0;
        foreach ($this->Csz_model->loadAllLang(1) as $rs){
            ($rs->lang_iso) ? $lang_url = base_url().'lang/'.$rs->lang_iso : $lang_url = base_url().'lang/';
            if($type == 1){ /* Show flag only */
                $lang_list.= '<li><a href="'.$lang_url.'"><span class="flag-icon flag-icon-'.$rs->country_iso.'"></span></a></li>';
            }else if($type == 2){ /* Show flag and Language */
                $lang_list.= '<li><a href="'.$lang_url.'"><span class="flag-icon flag-icon-'.$rs->country_iso.'"></span> '.$rs->lang_name.'</a></li>';
            }else if($type == 3){ /* Show flag and Country */
                $lang_list.= '<li><a href="'.$lang_url.'"><span class="flag-icon flag-icon-'.$rs->country_iso.'"></span> '.$rs->country.'</a></li>';
            }else{ /* Show Full detail */
                $lang_list.= '<li><a href="'.$lang_url.'"><span class="flag-icon flag-icon-'.$rs->country_iso.'"></span> '.$rs->country.'('.$rs->lang_name.')</a></li>';
            } 
            $i++;
        }
        ($i > 1) ? $html = '<ul class="list-inline" id="lang-menu">'.$lang_list.'</ul>' : $html = '';
        return $html;
    }

    public function footer(){
        $row = $this->Csz_model->load_config();
        $html = '<span class="copyright">'.$row->site_footer.'</span>
                <small style="color:gray;">'.$this->Csz_model->cszCopyright().'</small>';
        return $html;
    }
    
    public function admin_topmenu(){
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
                        <li><a href="'.base_url().'admin/users/edit/'.$this->session->userdata('user_admin_id').'"><span class="glyphicon glyphicon-user"></span> '.$this->session->userdata('admin_name').'</a></li>
                        <li class="dropdown">
                            <a aria-expanded="true" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="glyphicon glyphicon-menu-hamburger"></i> '.$this->lang->line('nav_content_menu').'</a>
                            <ul class="dropdown-menu">
                                <li><a href="'.base_url().'admin/forms"><i class="glyphicon glyphicon-modal-window"></i> '.$this->lang->line('forms_header').'</a></li>
                                <li><a href="'.base_url().'admin/uploadindex"><i class="glyphicon glyphicon-picture"></i> '.$this->lang->line('uploadfile_header').'</a></li>
                                <li><a href="'.base_url().'admin/pages"><i class="glyphicon glyphicon-file"></i> '.$this->lang->line('pages_header').'</a></li> 
                                <li><a href="'.base_url().'admin/navigation"><i class="glyphicon glyphicon-object-align-top"></i> '.$this->lang->line('nav_nav_header').'</a></li>                               
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a aria-expanded="true" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="glyphicon glyphicon-menu-hamburger"></i> '.$this->lang->line('nav_general_menu').'</a>
                            <ul class="dropdown-menu">
                                <li><a href="'.base_url().'admin/lang"><i class="glyphicon glyphicon-globe"></i> '.$this->lang->line('lang_header').'</a></li>';
                        if($this->session->userdata('admin_type') == 'admin'){ $html.= '<li><a href="'.base_url().'admin/settings"><i class="glyphicon glyphicon-cog"></i> '.$this->lang->line('settings_header').'</a></li>'; }
                        $html.= '<li><a href="'.base_url().'admin/social"><i class="glyphicon glyphicon-share"></i> '.$this->lang->line('social_header').'</a></li>';
                        if($this->session->userdata('admin_type') == 'admin'){ $html.= '<li><a href="'.base_url().'admin/upgrade"><i class="glyphicon glyphicon-compressed"></i> '.$this->lang->line('upgrade_header').'</a></li>'; }
                        $html.= '<li><a href="'.base_url().'admin/users"><i class="glyphicon glyphicon-user"></i> '.$this->lang->line('nav_admin_users').'</a></li>
                            </ul>
                        </li>
                        <li><a href="'.base_url().'admin/logout"><i class="glyphicon glyphicon-log-out"></i> '.$this->lang->line('nav_logout').'</a></li>
                    </ul> 
                </div>           
            </div>
        </nav>';
        return $html;
    }
    
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

    public function admin_leftmenu($cur_page){
        $html = '<ul class="nav nav-sidebar">';
        $html.= $this->admin_leftli($cur_page,'admin','admin',$this->lang->line('nav_dash'),'glyphicon-dashboard');
        $html.= '</ul><hr>';
        $html.= '<ul class="nav nav-sidebar">';
        $html.= '<li><a href="#" title="'.$this->lang->line('nav_content_menu').'" onclick="ChkHideShow(\'content_menu\');"><span class="glyphicon glyphicon-menu-hamburger"></span> '.$this->lang->line('nav_content_menu').'</a></li>';
        if($cur_page == 'navigation' || $cur_page == 'pages' || $cur_page == 'uploadindex' || $cur_page == 'forms' ){
            $gel_settings_display = "";
        }else{
            $gel_settings_display = "display: none;";
        }
        $html.= '<ul id="content_menu" class="nav nav-sidebar" style="'.$gel_settings_display.'padding: 0 25px;">';
        $html.= $this->admin_leftli($cur_page,'forms','admin/forms',$this->lang->line('forms_header'),'glyphicon-modal-window',TRUE);
        $html.= $this->admin_leftli($cur_page,'uploadindex','admin/uploadindex',$this->lang->line('uploadfile_header'),'glyphicon-picture',TRUE);
        $html.= $this->admin_leftli($cur_page,'pages','admin/pages',$this->lang->line('pages_header'),'glyphicon-file',TRUE);
        $html.= $this->admin_leftli($cur_page,'navigation','admin/navigation',$this->lang->line('nav_nav_header'),'glyphicon-object-align-top',TRUE);        
        $html.= '</ul></ul><hr>';
        $html.= '<ul class="nav nav-sidebar">';
        $html.= '<li><a href="#" title="'.$this->lang->line('nav_gel_settings').'" onclick="ChkHideShow(\'gel_settings\');"><span class="glyphicon glyphicon-menu-hamburger"></span> '.$this->lang->line('nav_gel_settings').'</a></li>';
        if($cur_page == 'users' || $cur_page == 'social' || $cur_page == 'settings' || $cur_page == 'lang' || $cur_page == 'upgrade'){
            $gel_settings_display = "";
        }else{
            $gel_settings_display = "display: none;";
        }
        $html.= '<ul id="gel_settings" class="nav nav-sidebar" style="'.$gel_settings_display.'padding: 0 25px;">';
        $html.= $this->admin_leftli($cur_page,'lang','admin/lang',$this->lang->line('lang_header'),'glyphicon-globe',TRUE);
        if($this->session->userdata('admin_type') == 'admin'){ $html.= $this->admin_leftli($cur_page,'settings','admin/settings',$this->lang->line('settings_header'),'glyphicon-cog',TRUE); }
        $html.= $this->admin_leftli($cur_page,'social','admin/social',$this->lang->line('social_header'),'glyphicon-share',TRUE);
        if($this->session->userdata('admin_type') == 'admin'){ $html.= $this->admin_leftli($cur_page,'upgrade','admin/upgrade',$this->lang->line('upgrade_header'),'glyphicon-compressed',TRUE); }
        $html.= $this->admin_leftli($cur_page,'users','admin/users',$this->lang->line('nav_admin_users'),'glyphicon-user',TRUE);
        $html.= '</ul></ul><hr>';
        $html.= '<ul class="nav nav-sidebar">
                    <li><a href="'.base_url().'admin/logout"><span class="glyphicon glyphicon-log-out"></span> '.$this->lang->line('nav_logout').'</a></li>
                </ul>';
        return $html;
    }

    public function admin_footer(){
        $row = $this->Csz_admin_model->load_config();
        $html = '<footer>
                    <hr>
                    <div class="row">
                        <div class="col-md-8 div-copyright">
                            <span class="copyright">'.$row->site_footer.'</span>
                            <small style="color:gray;">'.$this->Csz_model->cszCopyright().'</small>
                        </div>
                    </div>
            </footer>';
        return $html;
    }
}

