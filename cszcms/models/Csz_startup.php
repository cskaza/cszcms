<?php
/**
 * CSZ CMS
 *
 * An open source content management system
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
 * 
 * For plugin config file
 * $plugin_config['backend_startup'] is function name from 'admin/plugin/plugin_name/functionName' url. 
 * Just allow only one function for startup run.
 $plugin_config['backend_startup'] = 'functionName';
 * $plugin_config['frontend_startup'] is function name from 'plugin/plugin_name/functionName' url. 
 * Just allow only one function for startup run.
 $plugin_config['frontend_startup'] = 'functionName';
 * 
 */
defined('BASEPATH') || exit('No direct script access allowed');

/* For Startup on login */
class Csz_startup extends CI_Model {
    
    public $plugin;
    public $func_arr = array();
    public $run_func_arr = array();
       
    function __construct() {
        parent::__construct();
        if (CACHE_TYPE == 'file') {
            $this->load->driver('cache', array('adapter' => 'file', 'key_prefix' => EMAIL_DOMAIN . '_'));
        } else {
            $this->load->driver('cache', array('adapter' => CACHE_TYPE, 'backup' => 'file', 'key_prefix' => EMAIL_DOMAIN . '_'));
        }
        $this->load->database();
        $this->db->cache_on();
        $this->func_arr = $this->session->userdata('set_startup_url');
        $this->run_func_arr = $this->session->userdata('run_startup_url');
        $this->plugin = $this->Csz_model->getValueArray('plugin_config_filename', 'plugin_manager', "plugin_active = '1' AND plugin_config_filename != ''", '', 0, 'timestamp_update', 'DESC');
    }
    
    /**
     * setStaticURL
     *
     * Function for set the url into array
     * 
     * @param string $url url
     */
    public function setStaticURL($url){
        /* set static url. Return array */
        $this->func_arr[] = $url;
        $this->session->unset_userdata('set_startup_url');
        $this->session->set_userdata(array('set_startup_url' => $this->func_arr));
    }
    
    /**
     * setRunURl
     *
     * Function for set the url been run finish into array
     * 
     * @param string $url url
     */
    public function setRunURL($url){
        /* set static url. Return array */
        $this->run_func_arr[] = $url;
        $this->session->unset_userdata('run_startup_url');
        $this->session->set_userdata(array('run_startup_url' => $this->run_func_arr));
    }

    /**
     * run
     *
     * Function for run the startup
     * 
     * @param   bool $backend TRUE is for backend, FALSE is for frontend
     * @return	mixed  url or FALSE
     */
    public function run($backend = TRUE) {
        if($backend){
            $getBackend = (array)$this->getPluginBackend();
            if(!empty($getBackend)){
                foreach ($getBackend as $value) {
                    if($value) $this->setStaticURL($value);
                }
            }
        }else{
            $getFrontend = (array)$this->getPluginFrontend();
            if(!empty($getFrontend)){
                foreach ($getFrontend as $value) {
                    if($value) $this->setStaticURL($value);
                }
            }
        }
        unset($getBackend, $getFrontend, $backend);
        $return = FALSE;
        if(!empty($this->func_arr)){
            foreach ($this->func_arr as $value) {
                if($value && !in_array($value, (array)$this->run_func_arr)){
                    $this->setRunURL($value);
                    $return = $value;
                    break;
                }
            }
            unset($value);
        }
        return $return;
    }
    
    /**
     * getPluginBackend
     *
     * Function for get the plugin function from config file for backend
     *
     * @return	array
     */
    public function getPluginBackend() {
        if (!$this->cache->get('startupPluginBackend')) {
            $return = array();
            if(!empty($this->plugin)){
                foreach ($this->plugin as $value) {
                    $config = $this->Csz_model->getPluginConfig($value['plugin_config_filename'], 'backend_startup');
                    $base_url = $this->Csz_model->base_link().'/admin/plugin/'.$this->Csz_model->getPluginConfig($value['plugin_config_filename'], 'plugin_urlrewrite').'/';
                    if($config !== FALSE && $base_url !== FALSE){
                        if($config) $return[] = $base_url.$config;
                    }
                }
            }
            ($this->Csz_model->load_config()->pagecache_time == 0) ? $cache_time = 1 : $cache_time = $this->Csz_model->load_config()->pagecache_time;
            $this->cache->save('startupPluginBackend', $return, ($cache_time * 60));
            unset($return, $config, $base_url, $cache_time);
        }
        return $this->cache->get('startupPluginBackend');
    }
    
    /**
     * getPluginFrontend
     *
     * Function for get the plugin function from config file for frontend
     *
     * @return	array
     */
    public function getPluginFrontend() {
        if (!$this->cache->get('startupPluginFrontend')) {
            $return = array();
            if(!empty($this->plugin)){
                foreach ($this->plugin as $value) {
                    $config = $this->Csz_model->getPluginConfig($value['plugin_config_filename'], 'frontend_startup');
                    $base_url = $this->Csz_model->base_link().'/plugin/'.$this->Csz_model->getPluginConfig($value['plugin_config_filename'], 'plugin_urlrewrite').'/';
                    if($config !== FALSE && $base_url !== FALSE){
                        if($config) $return[] = $base_url.$config;
                    }
                }
            }
            ($this->Csz_model->load_config()->pagecache_time == 0) ? $cache_time = 1 : $cache_time = $this->Csz_model->load_config()->pagecache_time;
            $this->cache->save('startupPluginFrontend', $return, ($cache_time * 60));
            unset($return, $config, $base_url, $cache_time);
        }
        return $this->cache->get('startupPluginFrontend');
    }
    
    /**
     * clearStartup
     *
     * Function for clear the startup
     * 
     */
    public function clearStartup(){
        $this->session->unset_userdata('set_startup_url');
        $this->session->unset_userdata('run_startup_url');
        unset($this->run_func_arr, $this->func_arr);
        $this->run_func_arr = array();
        $this->func_arr = array();
    }
    
    /**
     * chkStartRun
     *
     * Function for check and run the startup
     * 
     * @param   bool $backend TRUE is for backend, FALSE is for frontend
     */
    public function chkStartRun($backend = TRUE) {
        if($this->config->item('runStartupEnable') !== false){
            $startup = $this->run($backend);
            if($startup !== FALSE){
                redirect($startup, 'refresh');
            }
            unset($startup);
        }
    }
    
}