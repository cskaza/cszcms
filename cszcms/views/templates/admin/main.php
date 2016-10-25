<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$row = $this->Csz_admin_model->load_config();
/**
 * Main file for Template.
 * Don't change the file name
 */
?>
<?php echo  doctype('html5') ?>
<html lang="<?php echo $row->admin_lang ?>">
    <head>
        <?php echo  $meta_tags ?>
        <?php echo  link_tag('templates/admin/imgs/favicon.ico', 'shortcut icon', 'image/ico'); ?>
        <title><?php echo  $title ?></title>

        <!-- Bootstrap Core CSS -->
        <?php echo  $core_css ?>

        <!-- Custom CSS -->
        <?php echo  link_tag('templates/admin/css/dashboard.css') ?>
        <?php echo  link_tag('templates/admin/css/styles.css') ?>

        <!-- Custom Fonts -->        
        <?php echo  link_tag('https://fonts.googleapis.com/css?family=Montserrat:400,700') ?>
        <?php echo  link_tag('https://fonts.googleapis.com/css?family=Kaushan+Script') ?>
        <?php echo  link_tag('https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic') ?>
        <?php echo  link_tag('https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700') ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php if ($this->session->userdata('user_admin_id') && $this->session->userdata('admin_email') && $this->session->userdata('admin_type') != 'member') { ?>
            <?php echo  $this->Headfoot_html->admin_topmenu() ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-3 col-md-2 sidebar hidden-print">
                        <?php echo  $this->Headfoot_html->admin_leftmenu($cur_page) ?>
                    </div>
                    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                        <!-- Check upgrade version -->
                        <?php if($this->Csz_admin_model->chkVerUpdate($this->Csz_model->getVersion()) !== FALSE){ ?>
                        <a href="<?php echo BASE_URL?>/admin/upgrade" title="<?php echo $this->lang->line('btn_upgrade')?>"><div class="alert alert-warning text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo $this->lang->line('upgrade_newlast_alert')?></div></a>
                        <?php } ?>
                        <?php if($this->session->flashdata('error_message') != ''){ ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <?php echo $this->session->flashdata('error_message'); ?>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- Start For Content -->
                        <?php echo $content; ?>                       
                        <!-- End For Content -->
                        <br><br><br>
                        <?php echo  $this->Headfoot_html->admin_footer() ?>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <!-- Check upgrade version -->
            <?php if($this->Csz_admin_model->chkVerUpdate($this->Csz_model->getVersion()) !== FALSE){ ?>
                <div class="container">
                    <div class="col-md-3 hidden-sm hidden-xs"></div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <a href="<?php echo BASE_URL?>/admin/upgrade" title="<?php echo $this->lang->line('btn_upgrade')?>"><div class="alert alert-warning text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo $this->lang->line('upgrade_newlast_alert')?></div></a>
                    </div>
                    <div class="col-md-3 hidden-sm hidden-xs"></div>
                </div>                        
            <?php } ?>            
            <!-- Start For Content -->
            <?php echo $content; ?>
            <!-- End For Content -->
            <br><br><br>
            <div class="container">
                <?php echo  $this->Headfoot_html->admin_footer() ?>
            </div>
        <?php } ?>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <?php echo  $core_js ?>

        <!-- Custom Plugin JavaScript -->  
        <script src="<?php echo  base_url() ?>templates/admin/js/script.js"></script>        
    </body>
</html>