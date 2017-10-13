<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Redis settings
| -------------------------------------------------------------------------
| Your Redis servers can be specified below.
|
|	See: http://codeigniter.com/user_guide/libraries/caching.html#redis-caching
|
*/
$config['socket_type'] = REDIS_SOCKET_TYPE; //`tcp` or `unix`
$config['socket'] = REDIS_SOCKET; // in case of `unix` socket type
$config['host'] = REDIS_HOST;
$config['password'] = REDIS_PASSWORD;
$config['port'] = REDIS_PORT;
$config['timeout'] = REDIS_TIMEOUT;