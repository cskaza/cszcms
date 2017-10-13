<?php
defined('FCPATH') OR exit('No direct script access allowed');
/* 
 * For .htaccess file support.
 * For mod_rewrite is not support and .htaccess is not support. Please config the 'HTACCESS_FILE' to FALSE 
 * Default is TRUE
 */
define('REDIS_SOCKET_TYPE', 'tcp'); /* `tcp` or `unix` */
define('REDIS_SOCKET', '/var/run/redis.sock'); /* in case of `unix` socket type */
define('REDIS_HOST', '127.0.0.1');
define('REDIS_PASSWORD', '');
define('REDIS_PORT', 6379);
define('REDIS_TIMEOUT', 0);
