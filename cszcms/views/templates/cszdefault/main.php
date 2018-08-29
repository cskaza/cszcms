<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main file for Template.
 * Don't change the file name
 */
?>
<?php echo doctype('html5')?>
<html lang="<?php echo $this->session->userdata('fronlang_iso') . '-' . strtoupper($this->Csz_model->getCountryCode($this->session->userdata('fronlang_iso'))) ?>" prefix="og: http://ogp.me/ns#">
    <head>
        <?php echo $meta_tags?>
        <?php echo link_tag(base_url('', '', TRUE).'templates/cszdefault/imgs/favicon.ico', 'shortcut icon', 'image/ico');?>
        <!-- Bootstrap Core CSS -->
        <?php echo $core_css ?>
        <title><?php echo $title?></title>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php if($additional_metatag){ ?>
            <?php echo $additional_metatag?>
        <?php } ?>
    </head>
    <body id="page-top" class="index">
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
                    <a class="navbar-brand page-scroll" href="<?php echo base_url() ?>"><?php echo $this->Headfoot_html->getLogo();?></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="mainmenu-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <?php echo $this->Headfoot_html->topmenu($cur_page);?>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
        
        <!-- Start For Content -->
        <?php echo $content; ?>
        <!-- End For Content -->
        
        <div class="container">
            <footer>
                <div class="container">
                    <?php echo $this->Headfoot_html->getLastVerAlert();?>
                    <hr>
                    <div class="row">
                        <div class="col-md-5 div-copyright hidden-sm hidden-xs">
                            <?php /*$this->Headfoot_html->langMenu(1=Show flag only, 
                             * 2=Show flag and Language, 
                             * 3=Show flag and Country,
                             * 4=Google translator tools and next paramiter is default language. Ex $this->Headfoot_html->langMenu(4, 'th');
                             * Null or 0=Show Full detail)*/ ?>
                            <?php echo $this->Headfoot_html->langMenu(2);?>
                            <?php echo $this->Headfoot_html->footer();?>
                        </div>
                        <div class="col-md-2 hidden-sm hidden-xs text-center">
                            <a href="#top" title="To Top" style="text-decoration:none;">
                                <span class="h2"><i class="glyphicon glyphicon-chevron-up"></i></span>
                            </a><br><br>
                        </div>
                        <div class="col-md-5 div-social hidden-sm hidden-xs">
                            <br>
                            <?php echo $this->Headfoot_html->getSocial();?>
                        </div>
                        <div class="col-md-12 visible-sm visible-xs text-center">
                            <a href="#top" title="To Top" style="text-decoration:none;">
                                <span class="h2"><i class="glyphicon glyphicon-chevron-up"></i></span>
                            </a><br><br>
                            <?php /*$this->Headfoot_html->langMenu(1=Show flag only, 
                             * 2=Show flag and Language, 
                             * 3=Show flag and Country,
                             * 4=Google translator tools and next paramiter is default language. Ex $this->Headfoot_html->langMenu(4, 'th');
                             * Null or 0=Show Full detail)*/ ?>
                            <?php echo $this->Headfoot_html->langMenu(2);?>
                            <?php echo $this->Headfoot_html->footer();?>
                            <br><br>
                            <?php echo $this->Headfoot_html->getSocial();?>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- Custom CSS -->
        <?php echo link_tag(base_url('', '', TRUE).'templates/cszdefault/css/cszdefault.min.css') ?>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <?php echo $core_js?>
        <?php if($additional_js){ ?>
        <script type="text/javascript">
            <?php echo $additional_js?>
        </script>
        <?php } ?>
    </body>
</html>