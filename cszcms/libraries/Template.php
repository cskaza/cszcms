<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CSZ CMS
 *
 * An open source content management system
 *
 * Copyright (c) 2016, Astian Foundation
 *
 * @author	CSKAZA
 * @copyright   Copyright (c) 2016, Astian Foundation.
 * @license	https://astian.org/APL/1.0/	APL License
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 */

class Template {
    var $template_data = array();
    var $data_sub = array();
    var $use_template_file  = '';
    var $use_template  = '';

    /**
     * set
     *
     * Set variable for using in templates views file (main file)
     *
     * @param	string	$name    Variable name for use in main file
     * @param	string	$value   Value of variable
     */
    function set($name, $value)
    {
        $this->template_data[$name] = $value;
    }
    
    /**
     * setSub
     *
     * Set variable for using in views file (views file)
     *
     * @param	string	$name    Variable name for use in view file
     * @param	string	$value   Value of variable
     */
    function setSub($name, $value)
    {
        $this->data_sub[$name] = $value;
    }

    /**
     * set_template
     *
     * Set template name
     *
     * @param	string	$name    Template name for use
     * @param	string	$file   Template file name Defualt is main
     */
    function set_template($name, $file = 'main')
    {
        $this->use_template = $name;
        $this->use_template_file = $file;
    }

    /**
     * loadSub
     *
     * Load view with sub views
     *
     * @param	string	$view    View file for load
     */
    function loadSub($view = '')
    {
        $this->CI =& get_instance();
        return $this->load($view, $this->data_sub);
    }
    
    private function load($view = '' , $view_data = array(), $template = '', $return = FALSE)
    {
        $this->CI =& get_instance();

        if (empty($this->use_template_file)) {
            $template_file = $this->CI->config->item('template_master');
        }

        if (!empty($this->use_template_file)) {
            $template_file = $this->use_template_file;
        }
        
        if (empty($template)) {
            $template = $this->CI->config->item('template_name');
        }

        if (!empty($this->use_template)) {
            $template = $this->use_template;
        }

        $this->set($this->CI->config->item('data_container'), $this->CI->load->view($view, array_merge($view_data, array ('template' => $this->template_data)), true));
        return $this->CI->load->view($this->CI->config->item('template_folder') . '/' . $template . '/'  . $template_file, $this->template_data, $return);
    }
}