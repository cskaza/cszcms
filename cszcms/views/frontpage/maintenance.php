<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="generator" content="CSZ CMS | Open Source Content Management with responsive" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <link href="<?php echo base_url() ?>templates/admin/imgs/favicon.ico" rel="shortcut icon" type="image/ico" />
        <title>Site Maintenance! | <?php echo $site_name ?></title>
        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">.navbar-brand>img{margin-top:-15px}</style>
    </head>
    <body id="page-top" class="index">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll">
                    <a class="navbar-brand page-scroll" href="<?php echo base_url() ?>"><?php echo $this->Headfoot_html->getLogo();?></a>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
        <br><br>
        <!-- Start For Content -->
        <div class="jumbotron">
            <div class="container">
                <h1><i class="glyphicon glyphicon-exclamation-sign"></i> Site Maintenance.<br>We&rsquo;ll be back soon!</h1>
                <br><p>Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment.<br>If you need to you can always <a href="mailto:<?php echo $default_email ?>">contact us</a>, otherwise we&rsquo;ll be back online shortly!</p>
                <br><p>&mdash; <?php echo $site_name ?></p>
            </div>
        </div>
        <!-- End For Content -->
        <div class="container">
            <footer>
                <div class="container">
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <span class="copyright"><?php echo $this->Headfoot_html->footer();?></span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>        
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?php echo BASE_URL ?>/assets/js/jquery-1.12.4.min.js"></script>
        <script src="<?php echo BASE_URL ?>/assets/js/bootstrap.min.js"></script>
    </body>
</html>
