<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$row = $this->Csz_admin_model->load_config();
/**
 * Main file for Template.
 * Don't change the file name
 */
?>
<?php echo doctype('html5') ?>
<html lang="<?php echo $row->admin_lang ?>">
    <head>
        <?php echo $meta_tags ?>
        <?php echo link_tag('templates/admin/favicon.ico', 'shortcut icon', 'image/ico'); ?>
        <title><?php echo $title ?></title>

        <!-- Bootstrap Core CSS -->
        <?php echo $core_css ?>

        <!-- Custom Fonts -->        
        <?php echo link_tag('https://code.cdn.mozilla.net/fonts/fira.css') ?>

        <!-- Ionicons -->
        <?php echo link_tag('https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css') ?>
        <!-- jvectormap -->
        <?php echo link_tag('assets/js/plugins/jvectormap/jquery-jvectormap-1.2.2.css') ?>
        <!-- Theme style -->
        <?php echo link_tag('templates/admin/css/AdminLTE.min.css') ?>
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <?php echo link_tag('templates/admin/css/skins/_all-skins.min.css') ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <?php if($this->session->userdata('user_admin_id') && $this->session->userdata('admin_email') && $this->session->userdata('admin_type') != 'member'){ ?>
            <?php $users = $this->Csz_admin_model->getUser($this->session->userdata('user_admin_id')); /* Get admin user information */
            ($users->picture) ? $user_img = BASE_URL . '/photo/profile/' . $users->picture : $user_img = BASE_URL . '/photo/no_image.png'; ?>
            <div class="wrapper">
                <!-- Start topbar -->
                <header class="main-header">
                    <!-- Logo -->
                    <a class="logo" href="<?php echo base_url(); ?>admin">
                        <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini"><b>CSZ</b></span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg"><b><?php echo $this->lang->line('backend_system'); ?></b></span>                        
                    </a>
                    <!-- Header Navbar: style can be found in header.less -->
                    <nav class="navbar navbar-static-top">
                        <!-- Sidebar toggle button-->
                        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                            <span class="sr-only">Toggle navigation</span>
                        </a>
                        <!-- Navbar Right Menu -->
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <li>
                                    <a href="<?php echo base_url(); ?>" target="_blank">
                                        <i class="fa fa-eye"></i>
                                        <span class="hidden-xs"><?php echo $this->lang->line('nav_view_site'); ?></span>
                                    </a>
                                </li>
                                <!-- User Account: style can be found in dropdown.less -->
                                <li class="dropdown user user-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="<?php echo $user_img; ?>" class="user-image" alt="User Image">
                                        <span class="hidden-xs"><?php echo $users->name; ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- User image -->
                                        <li class="user-header">
                                            <img src="<?php echo $user_img; ?>" class="img-circle" alt="User Image">
                                            <p>
                                                <b><?php echo $users->name; ?></b>
                                                <small><em><?php echo $this->lang->line('user_new_type'); ?>: <?php echo ucfirst($this->session->userdata('admin_type')); ?></em></small>
                                            </p>
                                        </li>
                                        <!-- Menu Body -->
                                        <!--<li class="user-body">
                                            <div class="row">
                                                <div class="col-xs-12 text-center"></div>
                                            </div>
                                        </li>-->
                                        <!-- Menu Footer-->
                                        <li class="user-footer">
                                            <div class="pull-left">
                                                <a href="<?php echo base_url(); ?>admin/users/edit/<?php echo $this->session->userdata('user_admin_id'); ?>" class="btn btn-default btn-flat"><i class="fa fa-edit"></i> <?php echo $this->lang->line('user_edit_header'); ?></a>
                                            </div>
                                            <div class="pull-right">
                                                <a href="<?php echo base_url(); ?>admin/logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out text-red"></i> <?php echo $this->lang->line('nav_logout'); ?></a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <!-- Control Sidebar Toggle Button -->
                                <li>
                                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>
                <!-- End topbar -->
                
                <!-- Start Left side menu -->
                <!-- Left side column. contains the logo and sidebar -->
                <aside class="main-sidebar">
                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar">
                        <!-- Sidebar user panel -->
                        <div class="user-panel">
                            <div class="pull-left image">
                                <img src="<?php echo $user_img; ?>" class="img-circle" alt="User Image">
                            </div>
                            <div class="pull-left info">
                                <p><b><?php echo $users->name; ?></b></p>
                                <a href="<?php echo base_url(); ?>admin/users/edit/<?php echo $this->session->userdata('user_admin_id'); ?>"><i class="fa fa-edit"></i> <b><?php echo $this->lang->line('user_edit_header'); ?></b></a>
                            </div>
                        </div>
                        <!-- sidebar menu: : style can be found in sidebar.less -->
                        <ul class="sidebar-menu">
                            <li class="header"><?php echo strtoupper($title); ?></li>
                            <?php echo  $this->Headfoot_html->admin_leftmenu($cur_page) ?>
                        </ul>
                    </section>
                    <!-- /.sidebar -->
                </aside>
                <!-- End Left side menu -->
                
                <!-- Start Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <div class="container-fluid">
                        <br>
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
                        <!-- Main content -->
                        <?php echo $content; ?>
                        <!-- /.content -->
                        <br><br>
                        
                    </div>
                    <div class="footer" style="position:absolute;bottom:0%;right:2%;transform:translateY(-100%);">
                        <div class="row col-md-12 text-center">
                            <a href="#top" title="To Top" style="text-decoration:none;">
                                <span class="h2"><i class="glyphicon glyphicon-chevron-up"></i></span>
                            </a><br><br>
                        </div>
                    </div>
                </div>
                <!-- End Content Wrapper. Contains page content -->
                    

                <!-- Start Footer -->
                <?php echo  $this->Headfoot_html->admin_footer() ?>
                <!-- End Footer -->
                
                <!-- Start Control Sidebar For Theme Settings -->
                <aside class="control-sidebar control-sidebar-dark">
                    <!-- Create the tabs -->
                    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-copyright"></i></a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- /.tab-pane -->
                        <!-- Settings tab content -->
                        <div class="tab-pane" id="control-sidebar-home-tab">
                            <h2 class="control-sidebar-heading">AdminLTE Template 2.3.7</h2>
                            <p>
                                <b>MIT License</b><br>
                                <em>Copyright &copy; 2014-<?php echo date('Y') ?> <a href="http://almsaeedstudio.com" target="_blank" rel="nofollow external">Almsaeed Studio</a>. All rights reserved.</em>
                            </p>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                </aside>
                <!-- End Control Sidebar For Theme Settings -->
                
                <!-- Add the sidebar's background. This div must be placed
                     immediately after the control sidebar -->
                <div class="control-sidebar-bg"></div>
            </div>
            <!-- ./wrapper -->
        <?php }else{ ?>
            <!-- Check upgrade version -->
            <?php if($this->Csz_admin_model->chkVerUpdate($this->Csz_model->getVersion()) !== FALSE){ ?>
                <div class="col-md-3 hidden-sm hidden-xs"></div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <a href="<?php echo BASE_URL ?>/admin/upgrade" title="<?php echo $this->lang->line('btn_upgrade') ?>"><div class="alert alert-warning text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo $this->lang->line('upgrade_newlast_alert') ?></div></a>
                </div>
                <div class="col-md-3 hidden-sm hidden-xs"></div>                       
            <?php } ?>
            <br><br><br>
            <!-- Start For Content -->
            <?php echo $content; ?>
            <!-- End For Content -->
            <br><br><br>
            <?php echo $this->Headfoot_html->admin_footer() ?>
        <?php } ?>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <?php echo $core_js ?>

        <!-- FastClick -->
        <script src="<?php echo base_url() ?>assets/js/plugins/fastclick/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url() ?>templates/admin/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url() ?>templates/admin/js/demo.js"></script>
        <!-- Custom Plugin JavaScript -->
        <script src="<?php echo base_url() ?>templates/admin/js/script.js"></script>  
        <script type="text/javascript">
            $(function () {
                tinymce.init({
                    selector: '.body-tinymce',
                    height: '500px',
                    content_css: [
                        '<?php echo BASE_URL; ?>/assets/css/bootstrap.min.css',
                        '<?php echo BASE_URL; ?>/templates/<?php echo $row->themes_config; ?>/css/<?php echo $row->themes_config; ?>.min.css',
                        '<?php echo BASE_URL; ?>/assets/font-awesome/css/font-awesome.min.css'
                    ],
                    remove_trailing_brs: false,
                    convert_urls : false,
                    extended_valid_elements : "*[*],script[charset|defer|language|src|type]",
                    valid_elements: "*[*],script[charset|defer|language|src|type]",
                    plugins: "advlist autolink link image lists charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code codesample fullscreen insertdatetime media nonbreaking table contextmenu directionality emoticons paste textcolor glyphicons b_button jumbotron row_cols boots_panels boot_alert form_insert fontawesome",
                    toolbar1: "insertfile undo redo | styleselect fontselect fontsizeselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage codesample",
                    toolbar2: "forecolor backcolor emoticons glyphicons fontawesome | b_button jumbotron row_cols boots_panels boot_alert form_insert",
                    image_advtab: true,
                    image_class_list: [
                        {title: 'None', value: ''},
                        {title: 'Responsive', value: 'img-responsive'},
                        {title: 'Rounded & Responsive', value: 'img-responsive img-rounded'},
                        {title: 'Circle & Responsive', value: 'img-responsive img-circle'},
                        {title: 'Thumbnail & Responsive', value: 'img-responsive img-thumbnail'}
                    ],
                    style_formats: [
                        { title: 'Text', items: [
                            {title: 'Muted text', inline: 'span', classes: 'text-muted'},
                            {title: 'Primary text', inline: 'span', classes: 'text-primary'},
                            {title: 'Success text', inline: 'span', classes: 'text-success'},
                            {title: 'Info text', inline: 'span', classes: 'text-info'},
                            {title: 'Warning text', inline: 'span', classes: 'text-warning'},
                            {title: 'Danger text', inline: 'span', classes: 'text-danger'},
                            {title: 'Badges', inline: 'span', classes: 'badge'}
                        ] },
                        { title: 'Label', items: [
                            {title: 'Default Label', inline: 'span', classes: 'label label-default'},
                            {title: 'Primary Label', inline: 'span', classes: 'label label-primary'},
                            {title: 'Success Label', inline: 'span', classes: 'label label-success'},
                            {title: 'Info Label', inline: 'span', classes: 'label label-info'},
                            {title: 'Warning Label', inline: 'span', classes: 'label label-warning'},
                            {title: 'Danger Label', inline: 'span', classes: 'label label-danger'}
                        ] },
                        { title: 'Headers', items: [
                            { title: 'h1', block: 'h1' },
                            { title: 'h2', block: 'h2' },
                            { title: 'h3', block: 'h3' },
                            { title: 'h4', block: 'h4' },
                            { title: 'h5', block: 'h5' },
                            { title: 'h6', block: 'h6' }
                        ] },
                        { title: 'Blocks', items: [
                            { title: 'p', block: 'p' },
                            { title: 'div', block: 'div' },
                            { title: 'pre', block: 'pre' }
                        ] },
                        { title: 'Containers', items: [
                            { title: 'section', block: 'section', wrapper: true, merge_siblings: false },
                            { title: 'article', block: 'article', wrapper: true, merge_siblings: false },
                            { title: 'blockquote', block: 'blockquote', wrapper: true },
                            { title: 'hgroup', block: 'hgroup', wrapper: true },
                            { title: 'aside', block: 'aside', wrapper: true },
                            { title: 'figure', block: 'figure', wrapper: true }
                        ] }
                    ]
                });
            });
        $(document).ready(function(){
            runTinyMCE(<?php echo $row->themes_config; ?>);
        });
        </script>
        <!-- Load Extra JavaScript -->
        <?php if(!empty($extra_js)){ 
        echo $extra_js;
        } ?>
    </body>
</html>