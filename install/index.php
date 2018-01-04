<?php
$fullurl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . str_replace(array('/install','/index.php'), '', $_SERVER['REQUEST_URI']);
$curdomain = rtrim(preg_replace('/\\?.*/', '', $fullurl),'/');
header("Cache-Control: no-cache, no-store, must-revalidate"); /* HTTP 1.1. */
header("Pragma: no-cache"); /* HTTP 1.0. */
header("Expires: 0"); /* Proxies. */
if (file_exists('../config.inc.php')) {
    header("Location: ../?nocache=" . time());
    exit();
}
/* Start register the varible same CI index */
/**
 * CSZ CMS
 *
 * An open source content management system
 *
 * Copyright (c) 2016, Astian Foundation.
 *
 * Astian Develop Public License (ADPL)
 * 
 * This Source Code Form is subject to the terms of the Astian Develop Public
 * License, v. 1.0. If a copy of the APL was not distributed with this
 * file, You can obtain one at http://astian.org/about-ADPL
 * 
 * @author	CSKAZA
 * @copyright   Copyright (c) 2016, Astian Foundation.
 * @license	http://astian.org/about-ADPL	ADPL License
 * @link        https://www.cszcms.com
 * 
 */

// Path to the system directory
define('BASEPATH', '../system');
/* End register the varible same CI index */

require './include/Database.php';
$success = 0;
$chk_pass = 0;
if (!empty($_POST) && $_POST['submitbtn'] && $_POST['baseurl'] && $_POST['dbhost'] && $_POST['dbuser'] && $_POST['dbpass'] && $_POST['dbname']) {
    if (function_exists('ini_set')) {
        @ini_set('max_execution_time', 600);
        @ini_set('memory_limit','512M');
    }
    /* Prepare Input Data */
    /* $dbdsn = $_POST['dbdsn']; */
    $url_replace = array('https://', 'http://');
    $baseurl = $_POST['protocal'] . str_replace($url_replace, '', rtrim($_POST['baseurl'], "/"));
    $dbhost = $_POST['dbhost'];
    $dbuser = $_POST['dbuser'];
    $dbpass = $_POST['dbpass'];
    $dbname = $_POST['dbname'];
    $find_arr = parse_url($baseurl);
    $domain = $find_arr['host'];
    $email_domain = str_replace('www.', '', $domain);
    $email = $_POST['email'];

    /* Database Connect */
    $db = new Database($dbhost, $dbuser, $dbpass, $dbname);
    $mysqli = $db->connectDB();
    $filename = 'cszcms_app.sql';
    $db->mysqli_multi_query_file($mysqli, $filename);
    $cszmodel = new Cszmodel;
    $md5_hash = md5(time() + mt_rand(1, 99999999));
    if ($email && $_POST['password']) {
        /* Database Insert */
        $insert_user = "INSERT INTO `user_admin` (`user_admin_id`, `name`, `email`, `password`, `user_type`, `active`, `md5_hash`, `md5_lasttime`, `pm_sendmail`, `pass_change`, `timestamp_create`, `timestamp_update`) VALUES (1, 'Admin User', '" . $email . "', '" . $cszmodel->pwdEncypt($_POST['password']) . "', 'admin', 1, '" . $md5_hash . "', NOW(), 1, 1, NOW(), NOW())";
        $mysqli->query($insert_user);
        $update_sql = "UPDATE `settings` SET `default_email` = '" . $email . "' WHERE `settings_id` = 1";
        $mysqli->query($update_sql);
    } else {
        /* Database Insert */
        $insert_user = "INSERT INTO `user_admin` (`user_admin_id`, `name`, `email`, `password`, `user_type`, `active`, `md5_hash`, `md5_lasttime`, `pm_sendmail`, `pass_change`, `timestamp_create`, `timestamp_update`) VALUES (1, 'Admin User', 'demo@cszcms.com', '" . $cszmodel->pwdEncypt('123456') . "', 'admin', 1, '" . $md5_hash . "', NOW(), 1, 1, NOW(), NOW())";
        $mysqli->query($insert_user);
        $update_sql = "UPDATE `settings` SET `default_email` = 'demo@cszcms.com' WHERE `settings_id` = 1";
        $mysqli->query($update_sql);
    }
    $result = $mysqli->query("SELECT * FROM user_admin");
    $numrow = $db->numrow($result);
    if (!$numrow) {
        $success = 0;
        $db->closeDB();
        echo '<div class="alert alert-danger text-center" role="alert">Can\'t insert the database into your MySQL server</div>';
    } else {
        /* Prepare data for config.inc.php file */
        $config_file = '../config.inc.php';
        $config_txt = "<?php \n";
        $config_txt .= "defined('FCPATH') OR exit('No direct script access allowed'); \n\n";
        $config_txt .= "/* Database Host */ \n";
        $config_txt .= "define('DB_HOST', '" . $dbhost . "'); \n\n";
        $config_txt .= "/* Database Username */ \n";
        $config_txt .= "define('DB_USERNAME', '" . $dbuser . "'); \n\n";
        $config_txt .= "/* Database Password */ \n";
        $config_txt .= "define('DB_PASS', '" . $dbpass . "'); \n\n";
        $config_txt .= "/* Database Name */ \n";
        $config_txt .= "define('DB_NAME', '" . $dbname . "'); \n\n";
        $config_txt .= "/* Base URL */ \n";
        $config_txt .= "define('BASE_URL', '" . $baseurl . "'); \n\n";
        $config_txt .= "/* Email Domain */ \n";
        $config_txt .= "define('EMAIL_DOMAIN', '" . $email_domain . "'); \n\n";
        $config_txt .= "/* Time Zone */ \n";
        $config_txt .= "define('TIME_ZONE', '" . $_POST['timezone'] . "'); \n\n";
        /* write config.inc.php file */
        $fopen = fopen($config_file, 'wb') or die("can't open file");
        fwrite($fopen, $config_txt);
        fclose($fopen);
        /* Prepare htaccess.config.inc.php file */
        $htaccess_file = '../htaccess.config.inc.php';
        $htaccess_txt = "<?php \n";
        $htaccess_txt .= "defined('FCPATH') OR exit('No direct script access allowed'); \n\n";
        $htaccess_txt .= "/* \n";
        $htaccess_txt .= "* For .htaccess file support. \n";
        $htaccess_txt .= "* For mod_rewrite is not support and .htaccess is not support. Please config the 'HTACCESS_FILE' to FALSE  \n";
        $htaccess_txt .= "* Default is TRUE \n";
        $htaccess_txt .= "*/ \n";
        if($_POST['htaccess']){
            $htaccess_txt .= "define('HTACCESS_FILE', TRUE); \n";
        }else{
            $htaccess_txt .= "define('HTACCESS_FILE', FALSE); \n";
            @rename("../.htaccess", "../bak.htaccess.bak");
        }
        /* write htaccess.config.inc.php file */
        $fopen1 = fopen($htaccess_file, 'wb') or die("can't open file");
        fwrite($fopen1, $htaccess_txt);
        fclose($fopen1);
        $success = 1;
        $db->closeDB();
        if (isset($_COOKIE['csrf_cookie_csz']) || isset($_SESSION['csrf_cookie_csz'])) {
            unset($_COOKIE['csrf_cookie_csz']);
            unset($_SESSION['csrf_cookie_csz']);
            setcookie('csrf_cookie_csz', null, -1, '/');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <link rel="canonical" href="<?php echo $curdomain; ?>/install/"/>
        <meta name="robots" content="no-cache" />
        <meta name="description" content="Backend System for CSZ Content Management" />
        <meta name="keywords" content="CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, english" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="author" content="CSZCMS" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <link href="<?php echo $curdomain; ?>/templates/admin/favicon.ico" rel="shortcut icon" type="image/ico" />
        <title>Installation System | CSZ CMS</title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo $curdomain; ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $curdomain; ?>/assets/css/jquery-ui-themes-1.11.4/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $curdomain; ?>/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />         

        <!-- Custom CSS -->
        <link href="<?php echo $curdomain; ?>/install/assets/css/styles.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- Start For Content -->
        <div class="container">
            <?php
            if ($success) {
                $url_replace = array('https://', 'http://');
                $baseurl = $_POST['protocal'] . str_replace($url_replace, '', rtrim($_POST['baseurl'], "/"));
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <br><br>
                        <div class="text-center"><a href="<?php echo $baseurl; ?>/?nocache=<?php echo time() ?>" target="_blank" title="Home"><img alt="Site Logo" class="site-logo" src="<?php echo $curdomain; ?>/install/assets/images/logo.png"></a></div>
                        <br><br>
                        <div class="text-center">
                            <div class="well"><h3 class="form-signin-heading success">Installation Completed!</h3></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default text-center">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Please login to backend with your Email address and Password was setup.</b></h3>
                            </div>
                            <div class="panel-body">
                                <a href="<?php echo $baseurl; ?>/index.php/admin?nocache=<?php echo time() ?>" class="btn btn-lg btn-success">Go to Backend login</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col-md-12">
                        <br><br>
                        <div class="text-center"><a href="https://www.cszcms.com" target="_blank" title="CSZ CMS Official Website"><img alt="Site Logo" class="site-logo" src="<?php echo $curdomain; ?>/install/assets/images/logo.png"></a></div>
                        <br><br>
                        <div class="text-center">
                            <div class="well"><h3 class="form-signin-heading">CSZ CMS Installation!</h3></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <b><u>System Checking</u></b><br><br>
                        <b>
                            PHP 5.5.0 or higher (<b>Your PHP: <u><?php echo phpversion(); ?></u></b>) [<?php
                            if (version_compare(phpversion(), '5.5.0', '>=') !== FALSE) {
                                echo '<span class="success">PASS</span>';
                                $php = 1;
                            } else {
                                echo '<span class="error">FAIL</span>';
                                $php = 0;
                            }
                            ?>]<br>
                            MySQLi Driver [<?php
                            if (extension_loaded('mysqli') !== FALSE) {
                                echo '<span class="success">PASS</span>';
                                $sqli = 1;
                            } else {
                                echo '<span class="error">FAIL</span>';
                                $sqli = 0;
                            }
                            ?>]<br>
                            cURL Enable [<?php
                            if (function_exists('curl_version') !== FALSE) {
                                echo '<span class="success">PASS</span>';
                                $curl = 1;
                            } else {
                                echo '<span class="error">FAIL</span>';
                                $curl = 0;
                            }
                            ?>]<br>
                            PHP GD library Enable [<?php
                            if (extension_loaded('gd') && function_exists('gd_info')) {
                                echo '<span class="success">PASS</span>';
                                $gd = 1;
                            } else {
                                echo '<span class="error">FAIL</span>';
                                $gd = 0;
                            }
                            ?>]<br>
                            Config Write Permission [<?php
                            if (is_writable('../config_example.inc.php')) {
                                echo '<span class="success">PASS</span>';
                                $config_per = 1;
                            } else {
                                echo '<span class="error">FAIL</span>';
                                $config_per = 0;
                            }
                            ?>]<br>
                            Cache Write Permission [<?php
                            if (is_writable('../cszcms/cache/index.html')) {
                                echo '<span class="success">PASS</span>';
                                $cache_per = 1;
                            } else {
                                echo '<span class="error">FAIL</span>';
                                $cache_per = 0;
                            }
                            ?>]<br>
                            DB_Cache Write Permission [<?php
                            if (is_writable('../cszcms/db_cache/index.html')) {
                                echo '<span class="success">PASS</span>';
                                $dbcache_per = 1;
                            } else {
                                echo '<span class="error">FAIL</span>';
                                $dbcache_per = 0;
                            }
                            ?>]
                            <?php if(function_exists('apache_get_modules') ){ ?>
                                <br>
                                Apache mod_rewrite is enabled [<?php                           
                                    if(in_array('mod_rewrite', apache_get_modules())){
                                        echo '<span class="success">PASS</span>';
                                    }else{
                                        echo '<span class="error">FAIL</span>';
                                    }
                                ?>]
                            <?php } ?>
                                <br>
                                .htaccess is supported [<?php
                                $url = $curdomain . "/admin/login";
                                $ch = curl_init();
                                // set URL and other appropriate options
                                curl_setopt($ch, CURLOPT_URL, $url);
                                if(stripos($url, 'https://') !== FALSE){
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                }
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_HEADER, 0);
                                $content = curl_exec($ch);
                                $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                curl_close($ch);
                                if($code == 404) {
                                    echo '<span class="error">FAIL</span>';
                                } else {
                                    echo '<span class="success">PASS</span>';
                                }
                                unset($url, $ch, $code);
                                ?>]
                            <?php
                            if ($sqli == 1 && $php == 1 && $curl == 1 && $gd == 1 && $config_per == 1 && $cache_per == 1 && $dbcache_per == 1) {
                                $chk_pass = 1;
                            }
                            ?>
                        </b>
                        <hr>
                    </div>
                </div>
                <?php if ($chk_pass == 1) { ?> 
                    <form action="index.php" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><b>Database Setup</b></h3>
                                    </div>
                                    <div class="panel-body">
                                        <label for="dbhost">Database Host*: </label>
                                        <input id="dbhost" name="dbhost" type="text" class="form-control" placeholder="localhost or dbserver.example.com" required>
                                        <label for="dbuser">Database Username*: </label>
                                        <input id="dbuser" name="dbuser" type="text" class="form-control" placeholder="Username for DB" required>
                                        <label for="dbpass">Database Password*: </label> <span class="text-danger">(Blank isn't allowed on password)</span>
                                        <input id="dbpass" name="dbpass" type="password" class="form-control" placeholder="Password for DB" required>
                                        <label for="dbname">Database Name*: </label>
                                        <input id="dbname" name="dbname" type="text" class="form-control" placeholder="DB Name for CSZ-CMS" required>
                                        <br><span class="text-info">
                                            <a href="<?php echo $curdomain; ?>/install/assets/images/change-mysql-root-password-on-phpmyadmin.jpg" title="How to change password for root on phpmyadmin?" target="_blank"><b>How to change password for root on phpmyadmin?</b></a><br><br>
                                            <b>Your PHP Version: <u><?php echo phpversion(); ?></u></b><br>
                                            <b>* Required for <u>MySQLi</u> (PHP 5.5.0 or higher, MySQL 5.0 or higher)</b><br>
                                            <b>* Please create the database on your hosting control panel.</b><br><br>
                                            <b>When you have problem or question. Please contact us at</b><br>
                                            <a href="https://www.cszcms.com/about/contact-us" target="_blank" class="btn btn-info btn-sm" title="Contact us now!"><b>CONTACT NOW</b></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><b>Website Setup</b></h3>
                                    </div>
                                    <div class="panel-body">
                                        <label for="htaccess"><input id="htaccess" name="htaccess" type="checkbox" checked> Yes, your server is support to .htccess and mod_rewrite.</label><br>
                                        <span class="text-info"><em>If mod_rewrite is not support and .htaccess is not support. Please uncheck this box!</em></span><br><br>
                                        <label for="baseurl">Base URL*: </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <select name="protocal">
                                                    <option value="http://">http://</option>
                                                    <option value="https://">https://</option>
                                                </select>
                                            </span>
                                            <input id="baseurl" name="baseurl" type="text" class="form-control" placeholder="www.ex.com or www.ex.com/subdir" required>
                                        </div><!-- /input-group -->
                                        <span class="text-info"><em>If you want install on sub-directory Example. <b>http://www.ex.com/subdir</b> or <b>http://localhost/subdir</b> on localhost. subdir is directory when you extract file from zip file</em></span><br>
                                        <label for="timezone">Time Zone*: </label>
                                        <input id="timezone" name="timezone" type="text" class="form-control" placeholder="Asia/Bangkok" required>
                                        <span class="text-info"><em>See at <a href="http://php.net/manual/en/timezones.php" target="_blank"><b>Here</b></a> for Timezone list</em></span>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><b>Backend Login Setup</b></h3>
                                    </div>
                                    <div class="panel-body">
                                        <label for="email">Email Address: </label>
                                        <input id="email" name="email" type="email" class="form-control" placeholder="Email Address for Backend Login">
                                        <label for="password">Password: </label>
                                        <div class="input-group">
                                            <input id="password" name="password" type="password" class="form-control" placeholder="Password for Backend Login">
                                            <span class="input-group-addon">
                                                <input type="checkbox" id="enable-show" placeholder="Show/Hidden"> <span class="glyphicon glyphicon-eye-open"></span>
                                            </span>
                                        </div><!-- /input-group -->
                                        
                                        <span class="text-info"><em>Please <b>blank</b> email or password field or both. If you want default backend login account<br>Email: <b>demo@cszcms.com</b> | Password: <b>123456</b></em></span>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-lg btn-primary" id="submitbtn" name="submitbtn" value="Install Now">
                            </div>
                        </div>
                    </form>
                <?php } else { ?>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="alert alert-danger" role="alert">Your system isn't compatible. Please check your system and reload this page again.</div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <!-- End For Content -->
        <?php
        $version = new Version;
        ?>
        <br><br><br>
        <div class="container">
            <footer>
                <hr>
                <div class="row">
                    <div class="col-md-8 div-copyright">
                        <?php $version->setTimezone('Asia/Bangkok'); ?>
                        <span class="copyright">Copyright &copy; <?php echo date('Y'); ?> CSZ CMS Installer</span>
                        <small style="color:gray;"><br><span class="copyright">Installer for <a href="https://www.cszcms.com" target="_blank" title="CSZ CMS Official Website">CSZ CMS</a> Version <?php echo $version->getVersion(); ?></span></small>
                    </div>
                </div>
            </footer>            
        </div>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="../assets/js/jquery-1.12.4.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/jquery-ui.min.js"></script>
        <script src="../assets/js/scripts.min.js"></script>
        <script type="text/javascript">
            $.toggleShowPassword({
                field: '#password',
                control: '#enable-show'
            });
        </script>
    </body>
</html>