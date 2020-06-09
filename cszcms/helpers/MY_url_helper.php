<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter URL Helpers
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
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 */
 
if ( ! function_exists('url_title'))
{
	/**
	 * Create URL Title
	 *
	 * Takes a "title" string as input and creates a
	 * human-friendly URL string with a "separator" string
	 * as the word separator.
	 *
	 * @todo	Remove old 'dash' and 'underscore' usage in 3.1+.
	 * @param	string	$str		Input string
	 * @param	string	$separator	Word separator
	 *			(usually '-' or '_')
	 * @param	bool	$lowercase	Whether to transform the output string to lowercase
	 * @return	string
	 */
	function url_title($str, $separator = '-', $lowercase = FALSE)
	{
		if ($separator === 'dash')
		{
			$separator = '-';
		}
		elseif ($separator === 'underscore')
		{
			$separator = '_';
		}

		$q_separator = preg_quote($separator, '#');

		$trans = array(
			'&.+?;'			=> '',
			'[^\w\d _-ก-ฮะาิีุูเะแำไใๆ่้๊๋ั็์ึื]'		=> '', /* Fix here for Thai */
			'\s+'			=> $separator,
			'('.$q_separator.')+'	=> $separator
		);

		$str = strip_tags($str);
		foreach ($trans as $key => $val)
		{
			$str = preg_replace('#'.$key.'#i'.(UTF8_ENABLED ? 'u' : ''), $val, $str);
		}

		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}

		return trim(trim($str, $separator));
	}
        
        if ( ! function_exists('base_url'))
        {
                /**
                 * Base URL
                 *
                 * Create a local URL based on your basepath.
                 * Segments can be passed in as a string or an array, same as site_url
                 * or a URL to a file can be passed in, e.g. to an image file.
                 *
                 * @param	string	$uri
                 * @param	string	$protocol
                 * @param	bool	$static
                 * @return	string
                 */
                function base_url($uri = '', $protocol = NULL, $static = FALSE)
                {
                        return get_instance()->config->base_url($uri, $protocol, $static);
                }
        }
}

if ( ! function_exists('redirect'))
{
	/**
	 * Header Redirect
	 *
	 * Header redirect in two flavors
	 * For very fine grained control over headers, you could use the Output
	 * Library's set_header() function.
	 *
	 * @param	string	$uri	URL
	 * @param	string	$method	Redirect method
	 *			'auto', 'location' or 'refresh'
	 * @param	int	$code	HTTP Response status code
         * @param	bool	$jsredirect	for use javascript redierect
	 * @return	void
	 */
	function redirect($uri = '', $method = 'auto', $code = NULL, $jsredirect = TRUE, $delay = 100)
	{
		if ( ! preg_match('#^(\w+:)?//#i', $uri))
		{
			$uri = site_url($uri);
		}
                if($jsredirect === FALSE){
                    // IIS environment likely? Use 'refresh' for better compatibility
                    if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== FALSE)
                    {
                            $method = 'refresh';
                    }
                    elseif ($method !== 'refresh' && (empty($code) OR ! is_numeric($code)))
                    {
                            if (isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1')
                            {
                                    $code = ($_SERVER['REQUEST_METHOD'] !== 'GET')
                                            ? 303	// reference: http://en.wikipedia.org/wiki/Post/Redirect/Get
                                            : 307;
                            }
                            else
                            {
                                    $code = 302;
                            }
                    }

                    switch ($method)
                    {
                            case 'refresh':
                                    header('Refresh:0;url='.$uri);
                                    break;
                            default:
                                    header('Location: '.$uri, TRUE, $code);
                                    break;
                    }
                    exit;
                }else{
                    echo '<center><div style="position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);font-size:14px"><img src="'.base_url('', '', TRUE).'assets/images/loading.gif" class="img-responsive" width="32"/><br>Loading...</div></center>';
                    echo '<script>window.setTimeout(function(){window.location = "'.$uri.'"; },'.$delay.');</script>';
                    exit(0);
                }
	}
}