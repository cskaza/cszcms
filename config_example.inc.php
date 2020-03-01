<?php
/* This is example for config file */
defined('FCPATH') OR exit('No direct script access allowed');

/* Database Host */
define('DB_HOST', 'localhost');

/* Database Username */
define('DB_USERNAME', 'db_username');

/* Database Password */
define('DB_PASS', 'db_password');

/* Database Name */
define('DB_NAME', 'db_name');

/* Base URL */
define('BASE_URL', 'http://www.example.com');

/* Email Domain */
define('EMAIL_DOMAIN', 'example.com');

/* Time Zone see at http://php.net/manual/en/timezones.php */
define('TIME_ZONE', 'Asia/Bangkok');

/* If you want to ue other database without MySQLi. Please export the MySQL database and import to your other database */
/* The full DSN string describe a connection to the database. For connect other DB without MySQLi */
define('DB_DSN', '');

/* The database driver. e.g.: mysqli, mssql, postgre, sqlite, sqlite3 */
define('DB_DRIVER', 'mysqli');