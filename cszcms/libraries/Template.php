<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template {
    var $template_data = array();
    var $data_sub = array();
    var $use_template_file  = '';
    var $use_template  = '';

    /**
     * Set variable for using in the templates views (main file)
     */
    function set($name, $value)
    {
        $this->template_data[$name] = $value;
    }
    
    /**
     * Set variable for using in the views (views file)
     */
    function setSub($name, $value)
    {
        $this->data_sub[$name] = $value;
    }

    /**
     * Set template name
     */
    function set_template($name, $file = 'main')
    {
        $this->use_template = $name;
        $this->use_template_file = $file;
    }

    /**
     * Load view with sub views
    */
    function loadSub($view = '')
    {
        $this->CI =& get_instance();
        return $this->load($view, $this->data_sub);
    }
    
    /**
     * Load view
     */
    function load($view = '' , $view_data = array(), $template = '', $return = FALSE)
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