<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter HTML Helpers
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
if ( ! function_exists('link_tag'))
{
	/**
	 * Link
	 *
	 * Generates link to a CSS file
	 *
	 * @param	mixed	stylesheet hrefs or an array
	 * @param	string	rel
	 * @param	string	type
	 * @param	string	title
	 * @param	string	media
	 * @param	bool	should index_page be added to the css path
	 * @return	string
	 */
	function link_tag($href = '', $rel = 'stylesheet', $type = 'text/css', $title = '', $media = '', $index_page = FALSE)
	{
		$CI =& get_instance();
		$link = '<link ';

		if (is_array($href))
		{
			foreach ($href as $k => $v)
			{
				if ($k === 'href' && ! preg_match('#^([a-z]+:)?//#i', $v))
				{
					if ($index_page === TRUE)
					{
						$link .= 'href="'.rtrim(BASE_URL, '/').'/'.$CI->config->item('index_page').'/'.$v.'" ';
					}
					else
					{
						$link .= 'href="'.$CI->config->site_url($v, '', TRUE).'" ';
					}
				}
				else
				{
					$link .= $k.'="'.$v.'" ';
				}
			}
		}
		else
		{
			if (preg_match('#^([a-z]+:)?//#i', $href))
			{
				$link .= 'href="'.$href.'" ';
			}
			elseif ($index_page === TRUE)
			{
				$link .= 'href="'.rtrim(BASE_URL, '/').'/'.$CI->config->item('index_page').'/'.$href.'" ';
			}
			else
			{
				$link .= 'href="'.$CI->config->site_url($href, '', TRUE).'" ';
			}

			$link .= 'rel="'.$rel.'" type="'.$type.'" ';

			if ($media !== '')
			{
				$link .= 'media="'.$media.'" ';
			}

			if ($title !== '')
			{
				$link .= 'title="'.$title.'" ';
			}
		}

		return $link."/>\n";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('meta'))
{
	/**
	 * Generates meta tags from an array of key/values
	 *
	 * @param	array
	 * @param	string
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function meta($name = '', $content = '', $type = 'name', $newline = "\n")
	{
		/* Since we allow the data to be passes as a string, a simple array */
		/* or a multidimensional one, we need to do a little prepping.*/
		if ( ! is_array($name))
		{
			$name = array(array('name' => $name, 'content' => $content, 'type' => $type, 'newline' => $newline));
		}
		elseif (isset($name['name']))
		{
			/* Turn single array into multidimensional*/
			$name = array($name);
		}

		$str = '';
		foreach ($name as $meta)
		{
                        if(isset($meta['type']) && $meta['type'] !== 'name'){
                            if($meta['type'] == 'equiv'){
                                $type = 'http-equiv';
                            }else{
                                $type = $meta['type'];
                            }
                        }else{
                            $type = 'name';
                        }
			$name		= isset($meta['name'])					? $meta['name'] : '';
			$content	= isset($meta['content'])				? $meta['content'] : '';
			$newline	= isset($meta['newline'])				? $meta['newline'] : "\n";

			$str .= '<meta '.$type.'="'.$name.'" content="'.$content.'" />'.$newline;
		}

		return $str;
	}
}