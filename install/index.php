<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); /* HTTP 1.1. */
header("Pragma: no-cache"); /* HTTP 1.0. */
header("Expires: 0"); /* Proxies. */
if (file_exists('../config.inc.php')) {
    header("Location: ../?nocache=".time());
    exit();
}
/**
 * CSZ CMS Installer
 *
 * An open source content management system application with development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2016 by CSKAZA for CSZ CMS
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CSZCMS_Installer
 * @author	CSKAZA Dev Team
 * @copyright   Copyright (c) 2016, CSKAZA for CSZ CMS. (https://www.cszcms.com)
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 */
require './include/Database.php';
$success = 0;
$chk_pass = 0;
if (!empty($_POST) && $_POST['baseurl'] && $_POST['dbhost'] && $_POST['dbuser'] && $_POST['dbpass'] && $_POST['dbname']) {
    /* Prepare Input Data */
    /* $dbdsn = $_POST['dbdsn']; */
    $url_replace = array('https://', 'http://');
    $baseurl = $_POST['protocal'] . str_replace($url_replace, '', $_POST['baseurl']);
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

    if ($email && $_POST['password']) {
        /* Database Insert */
        $filename = 'cszcms_app.sql';
        $db->mysqli_multi_query_file($mysqli, $filename);

        $insert_user = "INSERT INTO `user_admin` (`user_admin_id`, `name`, `email`, `password`, `user_type`, `active`, `md5_hash`, `md5_lasttime`, `timestamp_create`, `timestamp_update`) VALUES (1, 'Admin User', '" . $email . "', '" . sha1(md5($_POST['password'])) . "', 'admin', 1, '" . md5(time() + mt_rand(1, 99999999)) . "', NOW(), NOW(), NOW())";
        $mysqli->query($insert_user);
        $update_sql = "UPDATE `settings` SET `default_email` = '" . $email . "' WHERE `settings_id` = 1";
        $mysqli->query($update_sql);
    } else {
        /* Database Insert */
        $filename = 'cszcms_app_default.sql';
        $db->mysqli_multi_query_file($mysqli, $filename);
    }
    $result = $mysqli->prepare("SELECT * FROM user_admin");
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
        $config_txt .= "/* Database DSN */ \n";
        $config_txt .= "define('DB_DSN', ''); \n\n";
        $config_txt .= "/* Database Host */ \n";
        $config_txt .= "define('DB_HOST', '" . $dbhost . "'); \n\n";
        $config_txt .= "/* Database Username */ \n";
        $config_txt .= "define('DB_USERNAME', '" . $dbuser . "'); \n\n";
        $config_txt .= "/* Database Password */ \n";
        $config_txt .= "define('DB_PASS', '" . $dbpass . "'); \n\n";
        $config_txt .= "/* Database Name */ \n";
        $config_txt .= "define('DB_NAME', '" . $dbname . "'); \n\n";
        $config_txt .= "/* Database Driver */ \n";
        $config_txt .= "define('DB_DRIVER', 'mysqli'); \n\n";
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
        $success = 1;
        $db->closeDB();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <meta name="robots" content="no-cache" />
        <meta name="description" content="Backend System for CSZ Content Management" />
        <meta name="keywords" content="CMS, Contact Management System, HTML, CSS, JS, JavaScript, framework, bootstrap, web development, thai, english" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="author" content="CSKAZA" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <link href="../templates/admin/imgs/favicon.ico" rel="shortcut icon" type="image/ico" />
        <title>Install System | CSZ-CMS System</title>

        <!-- Bootstrap Core CSS -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/jquery-ui-themes-1.11.4/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />         

        <!-- Custom CSS -->
        <link href="assets/css/styles.css" rel="stylesheet" type="text/css" />

        <!-- Custom Fonts -->        
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />

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
                $baseurl = $_POST['protocal'] . str_replace($url_replace, '', $_POST['baseurl']);
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <br><br>
                        <div class="text-center"><a href="<?php echo $baseurl; ?>/?nocache=<?php echo time() ?>" target="_blank" title="Home"><img alt="Site Logo" class="site-logo" src="assets/images/logo.png"></a></div>
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
                                <a href="<?php echo $baseurl; ?>/admin?nocache=<?php echo time() ?>" class="btn btn-lg btn-success">Go to Backend login</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col-md-12">
                        <br><br>
                        <div class="text-center"><a href="https://www.cszcms.com" target="_blank" title="CSZ CMS Official Website"><img alt="Site Logo" class="site-logo" src="assets/images/logo.png"></a></div>
                        <br><br>
                        <div class="text-center">
                            <div class="well"><h3 class="form-signin-heading">Install CSZ-CMS</h3></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <b><u>System Checking</u></b><br><br>
                        <b>
                                PHP 5.3.7 or higher [<?php if (version_compare(phpversion(), '5.3.7', '>=') !== FALSE) {
                                echo '<span class="success">PASS</span>';
                                $php = 1;
                            } else {
                                echo '<span class="error">FAIL</span>';
                                $php = 0;
                            } ?>]<br>
                                MySQLi Driver [<?php if (extension_loaded('mysqli') !== FALSE) {
                                echo '<span class="success">PASS</span>';
                                $sqli = 1;
                            } else {
                                echo '<span class="error">FAIL</span>';
                                $sqli = 0;
                            } ?>]<br>
                                MOD_REWRITE Enable [<?php if (in_array('mod_rewrite', apache_get_modules()) !== FALSE) {
                                echo '<span class="success">PASS</span>';
                                $modrw = 1;
                            } else {
                                echo '<span class="error">FAIL</span>';
                                $modrw = 0;
                            } ?>]<br>
                                cURL Enable [<?php if (function_exists('curl_version') !== FALSE) {
                                echo '<span class="success">PASS</span>';
                                $curl = 1;
                            } else {
                                echo '<span class="error">FAIL</span>';
                                $curl = 0;
                            } ?>]<br>
                                Config Write Permission [<?php if (is_writable('../config_example.inc.php')) {
                                echo '<span class="success">PASS</span>';
                                $config_per = 1;
                            } else {
                                echo '<span class="error">FAIL</span>';
                                $config_per = 0;
                            } ?>]<br>
                                ci_session Write Permission [<?php if (is_writable('../ci_session/index.html')) {
                                echo '<span class="success">PASS</span>';
                                $sess_per = 1;
                            } else {
                                echo '<span class="error">FAIL</span>';
                                $sess_per = 0;
                            } ?>]<br>
                                Cache Write Permission [<?php if (is_writable('../cszcms/cache/index.html')) {
                                echo '<span class="success">PASS</span>';
                                $cache_per = 1;
                            } else {
                                echo '<span class="error">FAIL</span>';
                                $cache_per = 0;
                            } ?>]<br>
                                DB_Cache Write Permission [<?php if (is_writable('../cszcms/db_cache/index.html')) {
                                echo '<span class="success">PASS</span>';
                                $dbcache_per = 1;
                            } else {
                                echo '<span class="error">FAIL</span>';
                                $dbcache_per = 0;
                            } ?>]
                            <?php
                            if ($sqli == 1 && $php == 1 && $modrw == 1 && $curl == 1 && $config_per == 1 && $sess_per == 1 && $cache_per == 1 && $dbcache_per == 1) {
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
                                        <label for="dbpass">Database Password*: </label>
                                        <input id="dbpass" name="dbpass" type="password" class="form-control" placeholder="Password for DB" required>
                                        <label for="dbname">Database Name*: </label>
                                        <input id="dbname" name="dbname" type="text" class="form-control" placeholder="DB Name for CSZ-CMS" required>
                                        <br><span class="remark">
                                            <b>Your PHP Version: <u><?php echo phpversion(); ?></u></b><br>
                                            <b>* Required for <u>MySQLi</u> (PHP 5.3.7 or higher, MySQL 5.0 or higher)</b><br>
                                            <b>* Please create the database on your hosting control panel.</b><br><br>
                                            <b>When you have problem or question. Please contact us at</b><br>
                                            <a href="https://www.cszcms.com/contact-us" target="_blank" class="btn btn-info btn-sm" title="Contact us now!"><b>CONTACT NOW</b></a>
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
                                        <span class="remark"><em>If you want install on sub-directory Example. <b>http://www.ex.com/subdir</b> or <b>http://localhost/subdir</b> on localhost. subdir is directory when you extract file from zip file</em></span><br>
                                        <label for="timezone">Time Zone*: </label>
                                        <input id="timezone" name="timezone" type="text" class="form-control" placeholder="Asia/Bangkok" required>
                                        <span class="remark"><em>See at <a href="http://php.net/manual/en/timezones.php" target="_blank"><b>Here</b></a> for Timezone list</em></span>
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
                                        <input id="password" name="password" type="password" class="form-control" placeholder="Password for Backend Login">
                                        <span class="remark"><em>Please <b>blank</b>. If you want default backend login account<br>Email: <b>demo@cszcms.com</b> | Password: <b>123456</b></em></span>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-lg btn-primary" type="submit" id="submit">Install Now</button>
                            </div>
                        </div>
                    </form>
                    <?php }else{ ?>
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
                        <span class="copyright">Copyright &copy; <?php echo date('Y'); ?> CSZ CMS Installer</span>
                        <small style="color:gray;"><br><span class="copyright">Installer for CSZ CMS Version <?php echo $version->getVersion(); ?></span></small>
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
    </body>
</html>