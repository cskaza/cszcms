<?php
defined('FCPATH') OR exit('No direct script access allowed');
/* Proxy config 
|--------------------------------------------------------------------------
| Reverse Proxy IPs
|--------------------------------------------------------------------------
|
| If your server is behind a reverse proxy, you must whitelist the proxy
| IP addresses from which CodeIgniter should trust headers such as
| HTTP_X_FORWARDED_FOR and HTTP_CLIENT_IP in order to properly identify
| the visitor's IP address.
|
| You can use both an array or a comma-separated list of proxy addresses,
| as well as specifying whole subnets. Here are a few examples:
|
| Important! Please not remove 103.21.244.0/22 to 199.27.128.0/21 because for Cloudflare
| IP Address example:	'10.0.1.200 or 192.168.5.0/24'
*/
$proxy_ip_arr = array(
    /* Important! Please not remove this! */
    /* (Start Cloudflare) */
    /* IPv4 */
    '103.21.244.0/22',
    '103.22.200.0/22',
    '103.31.4.0/22',
    '104.16.0.0/12',
    '108.162.192.0/18',
    '131.0.72.0/22',
    '141.101.64.0/18',
    '162.158.0.0/15',
    '172.64.0.0/13',
    '173.245.48.0/20',
    '188.114.96.0/20',
    '190.93.240.0/20',
    '197.234.240.0/22',
    '198.41.128.0/17',
    '199.27.128.0/21',
    /* IPv6 */
    '2400:cb00::/32',
    '2405:8100::/32',
    '2405:b500::/32',
    '2606:4700::/32',
    '2803:f800::/32',
    '2c0f:f248::/32',
    '2a06:98c0::/29',
    /* (End Cloudflare) */
    /* Please add new after this. Example: '10.0.1.200', */
    #'127.0.0.1',
    #'127.1.0.0/24',
    
);

$proxy_ip = implode(',', $proxy_ip_arr);
define('PROXY_IP_CONFIG', $proxy_ip); 