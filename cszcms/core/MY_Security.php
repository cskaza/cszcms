<?php
defined('BASEPATH') || exit('No direct script access allowed');
class MY_Security extends CI_Security {

    protected $ip_address = FALSE;
    protected $_enable_xss = FALSE;

    public function csrf_verify() {
        $headers = $this->getallheaders();
        if (isset($headers[$this->_csrf_token_name])) {
            $_POST[$this->_csrf_token_name] = $headers[$this->_csrf_token_name];
        }
        parent::csrf_verify();
    }

    private function getallheaders() {
        if (!function_exists('getallheaders')) {
            if (!is_array($_SERVER)) {
                return array();
            }
            $headers = array();
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
            return $headers;
        } else {
            return @getallheaders();
        }
    }

    /**
     * Show CSRF Error
     *
     * @return	void
     */
    public function csrf_show_error() {
        $ipaddress = $this->ip_address();
        $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASS, DB_NAME);
        $query = $mysqli->prepare("SELECT ip_address FROM login_logs WHERE ip_address = '" . $mysqli->escape_string(strip_tags($ipaddress)) . "' AND result = 'CSRF_INVALID' AND timestamp_create >= DATE_SUB('".$this->timeNow()."',INTERVAL 5 MINUTE)");
        $query->execute();
        $query->store_result();
        $count = $query->num_rows;
        if($count < 21){
            $sql = "INSERT INTO login_logs (email_login, note, result, user_agent, ip_address, timestamp_create)
            VALUES ('', 'CSRF Protection Invalid', 'CSRF_INVALID', '".$mysqli->escape_string(strip_tags($_SERVER['HTTP_USER_AGENT']))."', '".$mysqli->escape_string(strip_tags($ipaddress))."', '".$this->timeNow()."')";
            $mysqli->query($sql);
        }
        $mysqli->close();
        $base_urlconfig = config_item('base_url');
        if (!empty($_SERVER["HTTP_REFERER"])) {
            $referer_host = @parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
            $own_host = parse_url($base_urlconfig, PHP_URL_HOST);
            $this->clearCSRFcookie();
            if (($referer_host && $referer_host === $own_host)) {
                echo '<script>window.setTimeout(function(){window.location = "' . $_SERVER["HTTP_REFERER"] . '?nocache=' . time().'"; },2000);</script>';
                show_error('The action is not allowed by CSRF Protection. Please clear your browser cache. Redirecting..., Please wait.', 403);
            }else{
                echo '<script>window.setTimeout(function(){window.location = "' . $base_urlconfig . '?nocache=' . time().'"; },2000);</script>';
                show_error('The action is not allowed by CSRF Protection. Please clear your browser cache. Redirecting..., Please wait.', 403);               
            }
        }else{
            $this->clearCSRFcookie();
            echo '<script>window.setTimeout(function(){window.location = "' . $base_urlconfig . '?nocache=' . time().'"; },2000);</script>';
            show_error('The action is not allowed by CSRF Protection. Please clear your browser cache. Redirecting..., Please wait.', 403);
        }
    }

    /**
     * Fetch the IP Address
     *
     * Determines and validates the visitor's IP address.
     *
     * @return	string	IP address
     */
    private function ip_address() {
        if ($this->ip_address !== FALSE) {
            return $this->ip_address;
        }
        $proxy_ips = config_item('proxy_ips');
        if (!empty($proxy_ips) && !is_array($proxy_ips)) {
            $proxy_ips = explode(',', str_replace(' ', '', $proxy_ips));
        }

        $this->ip_address = $this->server('REMOTE_ADDR');

        if ($proxy_ips) {
            foreach (array('HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'HTTP_X_CLIENT_IP', 'HTTP_X_CLUSTER_CLIENT_IP') as $header) {
                if (($spoof = $this->server($header)) !== NULL) {
                    // Some proxies typically list the whole chain of IP
                    // addresses through which the client has reached us.
                    // e.g. client_ip, proxy_ip1, proxy_ip2, etc.
                    sscanf($spoof, '%[^,]', $spoof);

                    if (!$this->valid_ip($spoof)) {
                        $spoof = NULL;
                    } else {
                        break;
                    }
                }
            }

            if ($spoof) {
                for ($i = 0, $c = count($proxy_ips); $i < $c; $i++) {
                    // Check if we have an IP address or a subnet
                    if (strpos($proxy_ips[$i], '/') === FALSE) {
                        // An IP address (and not a subnet) is specified.
                        // We can compare right away.
                        if ($proxy_ips[$i] === $this->ip_address) {
                            $this->ip_address = $spoof;
                            break;
                        }

                        continue;
                    }

                    // We have a subnet ... now the heavy lifting begins
                    isset($separator) OR $separator = $this->valid_ip($this->ip_address, 'ipv6') ? ':' : '.';

                    // If the proxy entry doesn't match the IP protocol - skip it
                    if (strpos($proxy_ips[$i], $separator) === FALSE) {
                        continue;
                    }

                    // Convert the REMOTE_ADDR IP address to binary, if needed
                    if (!isset($ip, $sprintf)) {
                        if ($separator === ':') {
                            // Make sure we're have the "full" IPv6 format
                            $ip = explode(':', str_replace('::', str_repeat(':', 9 - substr_count($this->ip_address, ':')), $this->ip_address
                                    )
                            );

                            for ($j = 0; $j < 8; $j++) {
                                $ip[$j] = intval($ip[$j], 16);
                            }

                            $sprintf = '%016b%016b%016b%016b%016b%016b%016b%016b';
                        } else {
                            $ip = explode('.', $this->ip_address);
                            $sprintf = '%08b%08b%08b%08b';
                        }

                        $ip = vsprintf($sprintf, $ip);
                    }

                    // Split the netmask length off the network address
                    sscanf($proxy_ips[$i], '%[^/]/%d', $netaddr, $masklen);

                    // Again, an IPv6 address is most likely in a compressed form
                    if ($separator === ':') {
                        $netaddr = explode(':', str_replace('::', str_repeat(':', 9 - substr_count($netaddr, ':')), $netaddr));
                        for ($j = 0; $j < 8; $j++) {
                            $netaddr[$j] = intval($netaddr[$j], 16);
                        }
                    } else {
                        $netaddr = explode('.', $netaddr);
                    }

                    // Convert to binary and finally compare
                    if (strncmp($ip, vsprintf($sprintf, $netaddr), $masklen) === 0) {
                        $this->ip_address = $spoof;
                        break;
                    }
                }
            }
        }

        if (!$this->valid_ip($this->ip_address)) {
            return $this->ip_address = '0.0.0.0';
        }

        return $this->ip_address;
    }

    private function server($index, $xss_clean = TRUE) {
        return $this->_fetch_from_array($_SERVER, $index, $xss_clean);
    }

    protected function _fetch_from_array(&$array, $index = NULL, $xss_clean = NULL) {
        is_bool($xss_clean) OR $xss_clean = $this->_enable_xss;

        // If $index is NULL, it means that the whole $array is requested
        isset($index) OR $index = array_keys($array);

        // allow fetching multiple keys at once
        if (is_array($index)) {
            $output = array();
            foreach ($index as $key) {
                $output[$key] = $this->_fetch_from_array($array, $key, $xss_clean);
            }

            return $output;
        }

        if (isset($array[$index])) {
            $value = $array[$index];
        } elseif (($count = preg_match_all('/(?:^[^\[]+)|\[[^]]*\]/', $index, $matches)) > 1) { // Does the index contain array notation
            $value = $array;
            for ($i = 0; $i < $count; $i++) {
                $key = trim($matches[0][$i], '[]');
                if ($key === '') { // Empty notation will return the value as array
                    break;
                }

                if (isset($value[$key])) {
                    $value = $value[$key];
                } else {
                    return NULL;
                }
            }
        } else {
            return NULL;
        }

        return ($xss_clean === TRUE) ? $this->xss_clean($value) : $value;
    }

    private function valid_ip($ip, $which = '') {
        switch (strtolower($which)) {
            case 'ipv4':
                $which = FILTER_FLAG_IPV4;
                break;
            case 'ipv6':
                $which = FILTER_FLAG_IPV6;
                break;
            default:
                $which = NULL;
                break;
        }

        return (bool) filter_var($ip, FILTER_VALIDATE_IP, $which);
    }
    
    private function get_config(Array $replace = array())
	{
		static $config;

		if (empty($config))
		{
			$file_path = APPPATH.'config/config.php';
			$found = FALSE;
			if (file_exists($file_path))
			{
				$found = TRUE;
				require($file_path);
			}

			// Is the config file in the environment folder?
			if (file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/config.php'))
			{
				require($file_path);
			}
			elseif ( ! $found)
			{
				set_status_header(503);
				echo 'The configuration file does not exist.';
				exit(3); // EXIT_CONFIG
			}

			// Does the $config array exist in the file?
			if ( ! isset($config) OR ! is_array($config))
			{
				set_status_header(503);
				echo 'Your config file does not appear to be formatted correctly.';
				exit(3); // EXIT_CONFIG
			}
		}

		// Are any values being dynamically added or replaced?
		foreach ($replace as $key => $val)
		{
			$config[$key] = $val;
		}

		return $config;
	}
        
        private function clearCSRFcookie() {
            $find_arr = @parse_url(BASE_URL);
            $domain = @$find_arr['host'];
            $csrfcookiename = 'cszcookie_'.md5(BASE_URL).'csrf_cookie_csz';
            $csrfsessionname = md5(BASE_URL).'_cszsesscsrf_cookie_csz';
            if (isset($_SESSION[$csrfsessionname])) {            
                unset($_SESSION[$csrfsessionname]);           
            }
            setcookie($csrfcookiename, null, time()-1000);
            setcookie($csrfcookiename, null, time()-1000, '/');
        }
        
        /**
        * Time now into database
        *
        * @return   string
        */
        private function timeNow() {
           return date('Y-m-d H:i:s').'.000000';
        }

}
