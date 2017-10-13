<?php
defined('FCPATH') OR exit('No direct script access allowed');
/*  Cached list for support with CSZ CMS
 *  'file', # This is default cached. This is support for all server. #
 *  'apc', # Alternative PHP Cache (APC) Caching. #
 *  'memcached', # Memcached file config is 'memcached.comfig.inc.php' #
 *  'redis', # Redis file config is 'redis.comfig.inc.php' #
 * 
 *  Please make sure your server been support for apc, memcached, redis 
 */
define('CACHE_TYPE', 'file'); 
