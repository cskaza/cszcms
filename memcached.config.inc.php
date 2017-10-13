<?php
defined('FCPATH') OR exit('No direct script access allowed');
/* 
 * For .htaccess file support.
 * For mod_rewrite is not support and .htaccess is not support. Please config the 'HTACCESS_FILE' to FALSE 
 * Default is TRUE
 */
define('MEMCACHED_HOST', '127.0.0.1');
define('MEMCACHED_PORT', 11211);
define('MEMCACHED_WEIGHT', 1);