<?php
defined('BASEPATH') || exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="generator" content="CSZ CMS | Open Source Content Management with responsive" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <link href="<?php echo BASE_URL ?>/templates/admin/imgs/favicon.ico" rel="shortcut icon" type="image/ico" />
        <title>A PHP Error was encountered</title>
        <!-- Bootstrap Core CSS -->
        <link href="<?php echo BASE_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body id="page-top" class="index">        
        <!-- Start For Content -->
        <div class="jumbotron">
            <div class="container">
                <h4>An uncaught Exception was encountered</h4>
                <p>Type: <?php echo get_class($exception); ?></p>
                <p>Message: <?php echo $message; ?></p>
                <p>Filename: <?php echo $exception->getFile(); ?></p>
                <p>Line Number: <?php echo $exception->getLine(); ?></p>

                <?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

                        <p>Backtrace:</p>
                        <?php foreach ($exception->getTrace() as $error): ?>

                                <?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

                                        <p style="margin-left:10px">
                                        File: <?php echo $error['file']; ?><br />
                                        Line: <?php echo $error['line']; ?><br />
                                        Function: <?php echo $error['function']; ?>
                                        </p>
                                <?php endif ?>

                        <?php endforeach ?>

                <?php endif ?>
                <br>
                <a class="btn btn-primary btn-lg" href="<?php echo BASE_URL?>" role="button">Back to Home &raquo;</a>
            </div>
        </div>
        <!-- End For Content -->
        <div class="container">
            <footer>
                <div class="container">
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <span>Powered by <a href="https://www.cszcms.com" target="_blank" style="color: gray;">CSZ CMS</a> | Open Source Content Management with responsive</span>
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