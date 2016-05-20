<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$row = $this->Csz_admin_model->load_config();
/**
 * Main file for Template.
 * Don't change the file name
 */
?>
<?= doctype('html5') ?>
<html lang="en">
    <head>
        <?= $meta_tags ?>
        <?= link_tag('templates/admin/imgs/favicon.ico', 'shortcut icon', 'image/ico'); ?>
        <title><?= $title ?></title>

        <!-- Bootstrap Core CSS -->
        <?= $core_css ?>

        <!-- Custom CSS -->
        <?= link_tag('templates/admin/css/dashboard.css') ?>
        <?= link_tag('templates/admin/css/styles.css') ?>

        <!-- Custom Fonts -->        
        <?= link_tag('https://fonts.googleapis.com/css?family=Montserrat:400,700') ?>
        <?= link_tag('https://fonts.googleapis.com/css?family=Kaushan+Script') ?>
        <?= link_tag('https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic') ?>
        <?= link_tag('https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700') ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <? if ($this->session->userdata('user_admin_id') && $this->session->userdata('admin_email')) { ?>
            <?= $this->Headfoot_html->admin_topmenu() ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-3 col-md-2 sidebar hidden-print">
                        <?= $this->Headfoot_html->admin_leftmenu($cur_page) ?>
                    </div>
                    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                        <!-- Check upgrade version -->
                        <?php if($this->Csz_admin_model->chkVerUpdate($this->Csz_model->getVersion()) !== FALSE){ ?>
                        <a href="<?=BASE_URL?>/admin/upgrade" title="<?=$this->lang->line('btn_upgrade')?>"><div class="alert alert-info" role="alert"><?=$this->lang->line('upgrade_newlast_alert')?></div></a>
                        <?php } ?>
                        <!-- Start For Content -->
                        <?php echo $content; ?>
                        <!-- End For Content -->
                        <br><br><br>
                        <?= $this->Headfoot_html->admin_footer() ?>
                    </div>
                </div>
            </div>
        <? } else { ?>
            <!-- Start For Content -->
            <?php echo $content; ?>
            <!-- End For Content -->
            <br><br><br>
            <div class="container">
                <?= $this->Headfoot_html->admin_footer() ?>
            </div>
        <? } ?>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <?= $core_js ?>

        <!-- Custom Plugin JavaScript -->  
        <script src="<?= base_url() ?>templates/admin/js/script.js"></script>        
    </body>
</html>