<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter HTML Helpers
 *
 * Copyright (c) 2016, Astian Foundation
 *
 * @author	CSKAZA
 * @copyright   Copyright (c) 2016, Astian Foundation.
 * @license	https://astian.org/APL/1.0/	APL License
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 */
 
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