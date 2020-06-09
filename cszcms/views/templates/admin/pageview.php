<?php
defined('BASEPATH') || exit('No direct script access allowed');
header("Cache-Control: no-cache, no-store, must-revalidate"); /* HTTP 1.1. */
header("Pragma: no-cache"); /* HTTP 1.0. */
header("Expires: Sun, 01 Jan 2014 00:00:00 GMT"); /* Proxies. */
$row = $this->Csz_admin_model->load_config();
/**
 * Main file for Template.
 * Don't change the file name
 */
?>
<?php echo doctype('html5') ?>
<html lang="<?php echo $row->admin_lang ?>">
    <head>
        <meta http-equiv="refresh" content="7205;url=<?php echo $this->Csz_model->base_link().'/admin/logout'; ?>" />
        <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
        <meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT"/>
	<meta http-equiv="pragma" content="no-cache" />
        <meta name="robots" content="noindex,nofollow">
        <?php echo $meta_tags ?>
        <?php echo link_tag(base_url('', '', TRUE).'templates/admin/favicon.ico', 'shortcut icon', 'image/ico','','', FALSE); ?>
        <!-- Bootstrap Core CSS -->
        <?php echo $core_css ?>
        <link rel="icon" type="image/x-icon" href="<?php echo base_url('', '', TRUE) ?>templates/admin/favicon.ico" />
	<link rel="icon" sizes="192x192" href="<?php echo base_url('', '', TRUE) ?>templates/admin/img/cszcms_icon_192.png">
	<link rel="apple-touch-icon" sizes="128x128" href="<?php echo base_url('', '', TRUE) ?>templates/admin/img/cszcms_icon_128.png" />
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url('', '', TRUE) ?>templates/admin/img/cszcms_icon_152.png" />
        <link rel="manifest" href="<?php echo $this->Csz_model->base_link() ?>/admin/manifest">
	<meta name="theme-color" content="#337ab7">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="mobile-web-app-capable" content="yes">
        <title><?php echo $title ?></title>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body id="page-top" class="index">
        <?php $users = $this->Csz_admin_model->getUser($this->session->userdata('user_admin_id')); ?>
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainmenu-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a style="font-size:18px !important;" class="navbar-brand page-scroll" href="<?php echo $back_url ?>" title="<?php echo $this->lang->line('btn_back'); ?>"><i class="glyphicon glyphicon-chevron-left"></i> <?php echo $this->lang->line('backend_system'); ?></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="mainmenu-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="<?php echo $this->lang->line('dash_cur_time'); ?> <?php echo date('Y-m-d H:i:s'); ?>">
                                <i class="glyphicon glyphicon-time"></i><span class="visible-sm-inline visible-xs-inline"> <?php echo $this->lang->line('dash_cur_time'); ?></span> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" style="padding:10px;">
                                <li><b><?php echo $this->lang->line('dash_cur_time'); ?></b></li>
                                <li><?php echo date('Y-m-d H:i:s'); ?></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo $view_url; ?>" target="_blank">
                                <i class="fa fa-eye"></i> <?php echo $this->lang->line('nav_view_site'); ?>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i> <?php echo $users->name; ?> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo $this->Csz_model->base_link(); ?>/admin/users/edit/<?php echo $this->session->userdata('user_admin_id'); ?>"><i class="fa fa-edit"></i> <?php echo $this->lang->line('user_edit_header'); ?></a></li>
                                <li><a href="<?php echo $this->Csz_model->base_link(); ?>/admin/logout"><i class="fa fa-sign-out text-red"></i> <?php echo $this->lang->line('nav_logout'); ?></a></li>
                            </ul>
                        </li>
                        <?php if($this->Csz_auth_model->is_group_allowed('maintenance', 'backend') !== FALSE || $this->Csz_auth_model->is_group_allowed('export', 'backend') !== FALSE){ ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-compressed"></i><span class="visible-sm-inline visible-xs-inline"> <?php echo $this->lang->line('maintenance_header'); ?></span> <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <?php if($this->Csz_auth_model->is_group_allowed('maintenance', 'backend') !== FALSE){ ?>
                                        <li><a href="<?php echo $this->Csz_model->base_link(). '/admin/upgrade/optimize' ?>"><i class="fa fa-compress"></i> <?php echo $this->lang->line('btn_optimize_db') ?></a></li>
                                        <li><a href="<?php echo $this->Csz_model->base_link(). '/admin/upgrade/clearAllCache' ?>" onclick="return confirm('<?php echo $this->lang->line('delete_message') ?>');"><i class="fa fa-trash"></i> <?php echo $this->lang->line('btn_clearallcache') ?></a></li>
                                        <li><a href="<?php echo $this->Csz_model->base_link(). '/admin/upgrade/clearAllDBCache' ?>" onclick="return confirm('<?php echo $this->lang->line('delete_message') ?>');"><i class="fa fa-trash"></i> <?php echo $this->lang->line('btn_clearalldbcache') ?></a></li>
                                        <?php if($this->Csz_auth_model->is_group_allowed('delete', 'backend') !== FALSE){ ?><li><a href="<?php echo $this->Csz_model->base_link(). '/admin/upgrade/clearAllSession' ?>" onclick="return confirm('<?php echo $this->lang->line('clear_sess_message') ?>');"><i class="fa fa-sign-out text-red"></i> <?php echo $this->lang->line('btn_clear_sess') ?></a></li><?php } ?>
                                        <?php } ?>
                                        <?php if($this->Csz_auth_model->is_group_allowed('export', 'backend') !== FALSE){ ?><li><a href="<?php echo $this->Csz_model->base_link(). '/admin/export' ?>"><i class="glyphicon glyphicon-export"></i> <?php echo $this->lang->line('export_import_csv_btn') ?></a></li><?php } ?>
                                    </ul>
                                </li>
                        <?php } ?>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
        
        <!-- Start For Content -->
        <?php echo $content; ?>
        <!-- End For Content -->
        <br><br>
        <div class="container">
            <footer>
                <!-- Check upgrade version -->
                <?php if ($this->Csz_admin_model->chkVerUpdate($this->Csz_model->getVersion()) !== FALSE) { ?>
                    <a href="<?php echo $this->Csz_model->base_link() ?>/admin/upgrade" title="<?php echo $this->lang->line('btn_upgrade') ?>"><div class="alert alert-warning text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo $this->lang->line('upgrade_newlast_alert') ?></div></a>
                <?php } ?>
                <?php if ($this->session->flashdata('error_message') != '') { ?>
                    <?php echo $this->session->flashdata('error_message'); ?>
                <?php } ?>
                <?php echo $this->Headfoot_html->getLastVerAlert(); ?>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a href="#top" title="To Top" style="text-decoration:none;">
                            <span class="h2"><i class="glyphicon glyphicon-chevron-up"></i></span>
                        </a><br>
                        <?php echo $this->lang->line('backend_system'); ?> | <?php echo $this->Headfoot_html->footer(); ?>
                    </div>
                </div>
            </footer>
        </div>
        <!-- Custom CSS -->
        <?php echo link_tag(base_url('', '', TRUE).'templates/'. $row->themes_config .'/css/'. $row->themes_config .'.min.css') ?>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <?php echo $core_js ?>
        <script type="text/javascript">
            $(function(){tinymce.init({selector:".body-tinymce-inline",menubar:true,inline:true,hidden_input:true,content_css:["<?php echo base_url('', '', TRUE); ?>assets/css/bootstrap.min.css","<?php echo base_url('', '', TRUE); ?>assets/font-awesome/css/font-awesome.min.css"],allow_conditional_comments:false,allow_html_in_named_anchor:true,element_format:"html",entity_encoding:"raw",protect:['/\<\/?(if|endif)\>/g','/\<xsl\:[^>]+\>/g','/<\?php.*?\?>/g'],remove_trailing_brs:false,convert_urls:false,keep_styles:true,plugins:"advlist autolink link image lists charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code codesample fullscreen insertdatetime media nonbreaking table directionality emoticons paste textcolor colorpicker imagetools glyphicons b_button jumbotron row_cols boots_panels boot_alert form_insert fontawesome cszfile",external_filemanager_path:"<?php echo $this->Csz_model->base_link(); ?>/admin/",relative_urls:!1,toolbar1:"insertfile undo redo | styleselect fontselect fontsizeselect",toolbar2:"bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist",toolbar3:"link image media | print outdent indent codesample",toolbar4:"forecolor backcolor emoticons glyphicons fontawesome",toolbar5:"b_button jumbotron row_cols boots_panels boot_alert form_insert",image_advtab:true,image_class_list:[{title:"None",value:""},{title:"Responsive",value:"img-responsive"},{title:"Rounded & Responsive",value:"img-responsive img-rounded"},{title:"Circle & Responsive",value:"img-responsive img-circle"},{title:"Thumbnail & Responsive",value:"img-responsive img-thumbnail"}],style_formats:[{title:"Text",items:[{title:"Muted text",inline:"span",classes:"text-muted"},{title:"Primary text",inline:"span",classes:"text-primary"},{title:"Success text",inline:"span",classes:"text-success"},{title:"Info text",inline:"span",classes:"text-info"},{title:"Warning text",inline:"span",classes:"text-warning"},{title:"Danger text",inline:"span",classes:"text-danger"},{title:"Badges",inline:"span",classes:"badge"}]},{title:"Label",items:[{title:"Default Label",inline:"span",classes:"label label-default"},{title:"Primary Label",inline:"span",classes:"label label-primary"},{title:"Success Label",inline:"span",classes:"label label-success"},{title:"Info Label",inline:"span",classes:"label label-info"},{title:"Warning Label",inline:"span",classes:"label label-warning"},{title:"Danger Label",inline:"span",classes:"label label-danger"}]},{title:"Headers",items:[{title:"h1",block:"h1"},{title:"h2",block:"h2"},{title:"h3",block:"h3"},{title:"h4",block:"h4"},{title:"h5",block:"h5"},{title:"h6",block:"h6"}]},{title:"Blocks",items:[{title:"p",block:"p"},{title:"div",block:"div"},{title:"pre",block:"pre"}]},{title:"Containers",items:[{title:"section",block:"section",wrapper:!0,merge_siblings:!1},{title:"article",block:"article",wrapper:!0,merge_siblings:!1},{title:"blockquote",block:"blockquote",wrapper:!0},{title:"hgroup",block:"hgroup",wrapper:!0},{title:"aside",block:"aside",wrapper:!0},{title:"figure",block:"figure",wrapper:!0}]}]})});
        </script>
        <!-- Load Extra JavaScript -->
        <?php if(!empty($extra_js)){ 
        echo $extra_js;
        } ?>
    </body>
</html>