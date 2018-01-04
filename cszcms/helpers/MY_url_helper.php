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
