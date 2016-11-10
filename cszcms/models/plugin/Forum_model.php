<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forum_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
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
                    <a class="navbar-brand" href="' . BASE_URL . '/admin/plugin/forum">' . $this->lang->line('nav_dash') . '</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li' . $this->AdminMenuActive('config', $cur_page) . '><a href="' . BASE_URL . '/admin/plugin/forum/config">' . $this->lang->line('forum_config') . '</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>';
        return $html;
    }

}
