<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* Fix by CSKAZA */
require APPPATH . "third_party/MX/Config.php";
class MY_Config Extends MX_Config {
	/**
	 * Site URL
	 *
	 * Returns base_url . index_page [. uri_string]
	 *
	 * @uses	CI_Config::_uri_string()
	 *
	 * @param	string|string[]	$uri	URI string or an array of segments
	 * @param	string	$protocol
         * @param	bool	$static
	 * @return	string
	 */
	public function site_url($uri = '', $protocol = NULL, $static = FALSE)
	{       $CI =& get_instance();
                $CI->load->model('Csz_model');
                $cszconfig = $CI->Csz_model->load_config();
                if($static && $cszconfig->assets_static_active && $cszconfig->assets_static_domain){
                    $base_url = rtrim($cszconfig->assets_static_domain, '/').'/';
                }else{
                    $base_url = (HTACCESS_FILE === FALSE) ? $this->slash_item('base_url').'index.php/' : $this->slash_item('base_url');
                }
                if($protocol == NULL){
                    $protocol = parse_url($base_url, PHP_URL_SCHEME);
                }
		if (isset($protocol))
		{
			// For protocol-relative links
			if ($protocol === '')
			{
				$base_url = substr($base_url, strpos($base_url, '//'));
			}
			else
			{
				$base_url = $protocol.substr($base_url, strpos($base_url, '://'));
			}
		}

		if (empty($uri))
		{
			return $base_url;
		}

		$uri = $this->_uri_string($uri);

		if ($this->item('enable_query_strings') === FALSE)
		{
			$suffix = isset($this->config['url_suffix']) ? $this->config['url_suffix'] : '';

			if ($suffix !== '')
			{
				if (($offset = strpos($uri, '?')) !== FALSE)
				{
					$uri = substr($uri, 0, $offset).$suffix.substr($uri, $offset);
				}
				else
				{
					$uri .= $suffix;
				}
			}

			return $base_url.$uri;
		}
		elseif (strpos($uri, '?') === FALSE)
		{
			$uri = '?'.$uri;
		}

		return $base_url.$uri;
	}

	// -------------------------------------------------------------

	/**
	 * Base URL
	 *
	 * Returns base_url [. uri_string]
	 *
	 * @uses	CI_Config::_uri_string()
	 *
	 * @param	string|string[]	$uri	URI string or an array of segments
	 * @param	string	$protocol
         * @param	bool	$static
	 * @return	string
	 */
	public function base_url($uri = '', $protocol = NULL, $static = FALSE)
	{
		$CI =& get_instance();
                $CI->load->model('Csz_model');
                $cszconfig = $CI->Csz_model->load_config();
                if($static && $cszconfig->assets_static_active && $cszconfig->assets_static_domain){
                    $base_url = rtrim($cszconfig->assets_static_domain, '/').'/';
                }else{
                    $base_url = $this->slash_item('base_url');
                }
                if($protocol == NULL){
                    $protocol = parse_url($base_url, PHP_URL_SCHEME);
                }
		if (isset($protocol))
		{
			// For protocol-relative links
			if ($protocol === '')
			{
				$base_url = substr($base_url, strpos($base_url, '//'));
			}
			else
			{
				$base_url = $protocol.substr($base_url, strpos($base_url, '://'));
			}
		}

		return $base_url.$this->_uri_string($uri);
	}
}
