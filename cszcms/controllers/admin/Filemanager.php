<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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
 */
class Filemanager extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->lang->load('admin', $this->Csz_admin_model->getLang());
        $this->template->set_template('admin');
        $this->_init();
    }

    public function _init() {
        $this->template->set('core_css', $this->Csz_admin_model->coreCss());
        $this->template->set('core_js', $this->Csz_admin_model->coreJs('//cdnjs.cloudflare.com/ajax/libs/require.js/2.3.2/require.min.js'));
        $this->template->set('title', 'Backend System | ' . $this->Csz_admin_model->load_config()->site_name);
        $this->template->set('meta_tags', $this->Csz_admin_model->coreMetatags('Backend System for CSZ Content Management System'));
        $this->template->set('cur_page', $this->Csz_admin_model->getCurPages());
    }

    public function index() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('file manager');
        admin_helper::is_allowchk('save');
        $this->csz_referrer->setIndex('filemanager');
        $this->load->helper('form');
        $settings = $this->Csz_admin_model->load_config();
        ($settings->adobe_cc_apikey && $settings->adobe_cc_apikey != NULL) ? $adobe_cc_apikey = $settings->adobe_cc_apikey : $adobe_cc_apikey = '';
        if($this->Csz_auth_model->is_group_allowed('delete', 'backend') !== FALSE){
            $connect_url = $this->Csz_model->base_link() . "/admin/filemanager/connector/";
        }else{
            $connect_url = $this->Csz_model->base_link() . "/admin/filemanager/connectorNodel/";
        }
        $this->template->setJS("<script>
            define('elFinderConfig', {
                defaultOpts : {
                    rememberLastDir : false,
                    useBrowserHistory : false,
                    defaultView : 'list',
                    url : '" . $connect_url . "' /* connector URL (REQUIRED)*/
                    ,commandsOptions : {
                        edit : {
                            extraOptions : {
                                /* set API key to enable Creative Cloud image editor
                                see https://console.adobe.io/ */
                                creativeCloudApiKey : '".$adobe_cc_apikey."',
                                /* browsing manager URL for CKEditor, TinyMCE
                                 uses self location with the empty value */
                                managerUrl : ''
                            }
                        }
                        ,quicklook : {
                            /* to enable preview with Google Docs Viewer */
                            googleDocsMimes : ['application/pdf', 'image/tiff', 'application/vnd.ms-office', 'application/msword', 'application/vnd.ms-word', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
                        }
                    }
                    /* bootCalback calls at before elFinder boot up */
                    ,bootCallback : function(fm, extraObj) {
                        /* any bind functions etc. */
                        fm.bind('init', function() {
                            /* any your code*/
                        });
                        /* for example set document.title dynamically.*/
                        var title = document.title;
                        fm.bind('open', function() {
                            var path = '',
                                cwd  = fm.cwd();
                            if (cwd) {
                                path = fm.path(cwd.hash) || null;
                            }
                            document.title = path? path + ':' + title : title;
                        }).bind('destroy', function() {
                            document.title = title;
                        });
                    }
                },
                managers : {
                    'elfinder': {}
                }
            });
            define('returnVoid', void 0);
            (function(){
                var /* elFinder version */
                    elver = '2.1.27',
                    /* jQuery and jQueryUI version*/
                    jqver = '3.2.1',
                    uiver = '1.12.1',
                    /* Detect language (optional)*/
                    lang = (function() {
                        var locq = window.location.search,
                            fullLang, locm, lang;
                        if (locq && (locm = locq.match(/lang=([a-zA-Z_-]+)/))) {
                            /* detection by url query (?lang=xx)*/
                            fullLang = locm[1];
                        } else {
                            /* detection by browser language*/
                            fullLang = (navigator.browserLanguage || navigator.language || navigator.userLanguage);
                        }
                        lang = fullLang.substr(0,2);
                        if (lang === 'ja') lang = 'jp';
                        else if (lang === 'pt') lang = 'pt_BR';
                        else if (lang === 'ug') lang = 'ug_CN';
                        else if (lang === 'zh') lang = (fullLang.substr(0,5).toLowerCase() === 'zh-tw')? 'zh_TW' : 'zh_CN';
                        return lang;
                    })(),
                    /* Start elFinder (REQUIRED)*/
                    start = function(elFinder, editors, config) {
                        /* load jQueryUI CSS*/
                        elFinder.prototype.loadCss('//cdnjs.cloudflare.com/ajax/libs/jqueryui/'+uiver+'/themes/smoothness/jquery-ui.css');
                        $(function() {
                            var optEditors = {
                                    commandsOptions: {
                                        edit: {
                                            editors: Array.isArray(editors)? editors : []
                                        }
                                    }
                                },
                                opts = {};
                            /* Interpretation of 'elFinderConfig'*/
                            if (config && config.managers) {
                                $.each(config.managers, function(id, mOpts) {
                                    opts = Object.assign(opts, config.defaultOpts || {});
                                    /* editors marges to opts.commandOptions.edit*/
                                    try {
                                        mOpts.commandsOptions.edit.editors = mOpts.commandsOptions.edit.editors.concat(editors || []);
                                    } catch(e) {
                                        Object.assign(mOpts, optEditors);
                                    }
                                    /* Make elFinder*/
                                    $('#' + id).elfinder(
                                        /* 1st Arg - options*/
                                        $.extend(true, { lang: lang }, opts, mOpts || {}),
                                        /* 2nd Arg - before boot up function*/
                                        function(fm, extraObj) {
                                            /* `init` event callback function*/
                                            fm.bind('init', function() {
                                                /* Optional for Japanese decoder 'extras/encoding-japanese.min'*/
                                                delete fm.options.rawStringDecoder;
                                                if (fm.lang === 'jp') {
                                                    require(
                                                        [ 'extras/encoding-japanese.min' ],
                                                        function(Encoding) {
                                                            if (Encoding.convert) {
                                                                fm.options.rawStringDecoder = function(s) {
                                                                    return Encoding.convert(s,{to:'UNICODE',type:'string'});
                                                                };
                                                            }
                                                        }
                                                    );
                                                }
                                            });
                                        }
                                    );
                                });
                            } else {
                                alert('\"elFinderConfig\" object is wrong.');
                            }
                        });
                    },                   
                    /* JavaScript loader (REQUIRED)*/
                    load = function() {
                        require(
                            [
                                'elfinder'
                                , 'extras/editors.default'       /* load text, image editors*/
                                , 'elFinderConfig'
                            /*  , 'extras/quicklook.googledocs'  // optional preview for GoogleApps contents on the GoogleDrive volume */
                            ],
                            start,
                            function(error) {
                                alert(error.message);
                            }
                        );
                    },                    
                    /* is IE8? for determine the jQuery version to use (optional)*/
                    ie8 = (typeof window.addEventListener === 'undefined' && typeof document.getElementsByClassName === 'undefined');
                /* config of RequireJS (REQUIRED)*/
                require.config({
                    baseUrl : '//cdnjs.cloudflare.com/ajax/libs/elfinder/'+elver+'/js',
                    paths : {
                        'jquery'   : '//cdnjs.cloudflare.com/ajax/libs/jquery/'+(ie8? '1.12.4' : jqver)+'/jquery.min',
                        'jquery-ui': '//cdnjs.cloudflare.com/ajax/libs/jqueryui/'+uiver+'/jquery-ui.min',
                        'elfinder' : 'elfinder.min'
                    },
                    waitSeconds : 10 /* optional*/
                });
                /* load JavaScripts (REQUIRED)*/
                load();
            })();</script>");
        $this->template->loadSub('admin/elfinder_index');
    }
    
    private function cmsConfigAdmin() {
        if($this->Csz_auth_model->is_in_group(1)){
            return array(
                    'driver' => 'LocalFileSystem',
                    'path' => FCPATH,
                    'URL' => '',
                    'alias' => 'CSZCMS System Config',
                    'defaults' => array('read' => true, 'write' => true, 'hidden' => true, 'locked' => true),
                    'winHashFix' => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                    'accessControl' => array($this, 'elfinderAccess'), // disable and hide dot starting files (OPTIONAL)
                    'disabled' => array('rm', 'duplicate', 'paste', 'mkdir', 'archive', 'extract', 'resize', 'chmod'),
                    'attributes' => array(
                        array(
                            'pattern' => '/\.inc.php$/',
                            'read' => true, 'write' => true, 'hidden' => false, 'locked' => false,
                        ),
                        array(
                            'pattern' => '/.htaccess/',
                            'read' => true, 'write' => true, 'hidden' => false, 'locked' => false,
                        ),
                        array(
                            'pattern' => '/\.bak$/',
                            'read' => true, 'write' => true, 'hidden' => false, 'locked' => false,
                        ),
                        array(
                            'pattern' => '/\.zip$/',
                            'read' => true, 'write' => true, 'hidden' => false, 'locked' => false,
                        ),
                    ),
                );
        }else{
            return array();
        }
    }
    
    public function connector() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('file manager');
        admin_helper::is_allowchk('save');
        admin_helper::is_allowchk('delete');
        $opts = array(
            'roots' => array(
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => FCPATH . 'photo',
                    'URL' => base_url() . 'photo',
                    'alias' => 'File Upload',
                    'mimeDetect' => 'internal',
                    'trashHash' => 't1_Lw', // elFinder's hash of trash folder
                    'winHashFix' => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                    'accessControl' => array($this, 'elfinderAccess'), // disable and hide dot starting files (OPTIONAL)
                    'attributes' => array(
                        array(
                            'pattern' => '/trash/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                        array(
                            'pattern' => '/index.html/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                        array(
                            'pattern' => '/.htaccess/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                    ),
                ),
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => FCPATH . 'templates',
                    'URL' => '',
                    'alias' => 'Template Assets',
                    'trashHash' => 't1_Lw', // elFinder's hash of trash folder
                    'winHashFix' => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                    'accessControl' => array($this, 'elfinderAccess'), // disable and hide dot starting files (OPTIONAL)
                    'attributes' => array(
                        array(
                            'pattern' => '/admin$/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                        array(
                            'pattern' => '/index.html/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                        array(
                            'pattern' => '/.htaccess/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                    ),
                ),
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => FCPATH . 'cszcms/views/templates',
                    'URL' => '',
                    'alias' => 'Template Main',
                    'trashHash' => 't1_Lw', // elFinder's hash of trash folder
                    'winHashFix' => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                    'accessControl' => array($this, 'elfinderAccess'), // disable and hide dot starting files (OPTIONAL)
                    'attributes' => array(
                        array(
                            'pattern' => '/admin$/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                        array(
                            'pattern' => '/index.html/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                        array(
                            'pattern' => '/.htaccess/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                    ),
                ),
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => FCPATH . 'cszcms/modules/plugin/views/templates',
                    'URL' => '',
                    'alias' => 'Template Plugin',
                    'trashHash' => 't1_Lw', // elFinder's hash of trash folder
                    'winHashFix' => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                    'accessControl' => array($this, 'elfinderAccess'), // disable and hide dot starting files (OPTIONAL)
                    'attributes' => array(
                        array(
                            'pattern' => '/index.html/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                        array(
                            'pattern' => '/.htaccess/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                    ),
                ),
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => FCPATH . 'cszcms/views/frontpage/templates',
                    'URL' => '',
                    'alias' => 'More Frontpage',
                    'trashHash' => 't1_Lw', // elFinder's hash of trash folder
                    'winHashFix' => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                    'accessControl' => array($this, 'elfinderAccess'), // disable and hide dot starting files (OPTIONAL)
                    'attributes' => array(
                        array(
                            'pattern' => '/index.html/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                        array(
                            'pattern' => '/.htaccess/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                    ),
                ),
                array(
                    'id' => '1',
                    'driver' => 'Trash',
                    'path' => FCPATH . 'photo/trash',
                    'tmbURL' => FCPATH . 'photo/trash/.tmb/',
                    'winHashFix' => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                    'accessControl' => array($this, 'elfinderAccess'), // disable and hide dot starting files (OPTIONAL)
                    'attributes' => array(
                        array(
                            'pattern' => '/index.html/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                        array(
                            'pattern' => '/.htaccess/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                    ),
                ),
                $this->cmsConfigAdmin(),
            ),
        );
        $this->load->library('elfinder_lib');
        $this->elfinder_lib->run($opts);
    }
    
    public function connectorNodel() {
        admin_helper::is_logged_in($this->session->userdata('admin_email'));
        admin_helper::is_allowchk('file manager');
        admin_helper::is_allowchk('save');
        $opts = array(
            'roots' => array(
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => FCPATH . 'photo',
                    'URL' => base_url() . 'photo',
                    'alias' => 'File Upload',
                    'mimeDetect' => 'internal',
                    'winHashFix' => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                    'accessControl' => array($this, 'elfinderAccess'), // disable and hide dot starting files (OPTIONAL)
                    'disabled' => array('rm', 'mkdir', 'mkfile' , 'archive', 'extract', 'resize', 'chmod', 'upload'),
                    'attributes' => array(
                        array(
                            'pattern' => '/trash/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                        array(
                            'pattern' => '/index.html/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                        array(
                            'pattern' => '/.htaccess/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                    ),
                ),
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => FCPATH . 'templates',
                    'URL' => '',
                    'alias' => 'Template Assets',
                    'winHashFix' => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                    'accessControl' => array($this, 'elfinderAccess'), // disable and hide dot starting files (OPTIONAL)
                    'disabled' => array('rm', 'mkdir', 'mkfile' , 'archive', 'extract', 'resize', 'chmod', 'upload'),
                    'attributes' => array(
                        array(
                            'pattern' => '/admin$/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                        array(
                            'pattern' => '/index.html/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                        array(
                            'pattern' => '/.htaccess/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                    ),
                ),
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => FCPATH . 'cszcms/views/templates',
                    'URL' => '',
                    'alias' => 'Template Main',
                    'winHashFix' => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                    'accessControl' => array($this, 'elfinderAccess'), // disable and hide dot starting files (OPTIONAL)
                    'disabled' => array('rm', 'mkdir', 'mkfile' , 'archive', 'extract', 'resize', 'chmod', 'upload'),
                    'attributes' => array(
                        array(
                            'pattern' => '/admin$/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                        array(
                            'pattern' => '/index.html/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                        array(
                            'pattern' => '/.htaccess/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                    ),
                ),
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => FCPATH . 'cszcms/modules/plugin/views/templates',
                    'URL' => '',
                    'alias' => 'Template Plugin',
                    'winHashFix' => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                    'accessControl' => array($this, 'elfinderAccess'), // disable and hide dot starting files (OPTIONAL)
                    'disabled' => array('rm', 'mkdir', 'mkfile' , 'archive', 'extract', 'resize', 'chmod', 'upload'),
                    'attributes' => array(
                        array(
                            'pattern' => '/index.html/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                        array(
                            'pattern' => '/.htaccess/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                    ),
                ),
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => FCPATH . 'cszcms/views/frontpage/templates',
                    'URL' => '',
                    'alias' => 'More Frontpage',
                    'winHashFix' => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                    'accessControl' => array($this, 'elfinderAccess'), // disable and hide dot starting files (OPTIONAL)
                    'disabled' => array('rm', 'mkdir', 'mkfile' , 'archive', 'extract', 'resize', 'chmod', 'upload'),
                    'attributes' => array(
                        array(
                            'pattern' => '/index.html/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                        array(
                            'pattern' => '/.htaccess/', //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => true
                        ),
                    ),
                ),
            ),
        );
        $this->load->library('elfinder_lib');
        $this->elfinder_lib->run($opts);
    }

    public function elfinderAccess($attr, $path, $data, $volume, $isDir, $relpath) {
        $basename = basename($path);
        return $basename[0] === '.'                  // if file/folder begins with '.' (dot)
                && $basename !== '.htaccess'                  // ignore .htaccess
                && strlen($relpath) !== 1           // but with out volume root
                ? !($attr == 'read' || $attr == 'write') // set read+write to false, other (locked+hidden) set to true
                : null;                                 // else elFinder decide it itself
    }
    
    public function templateCopy() {
        admin_helper::is_allowchk('file manager');
        admin_helper::is_allowchk('save');
        $template_name = $this->security->sanitize_filename($this->input->post('templatename', TRUE));
        $template_assets_path = FCPATH . 'templates' . DIRECTORY_SEPARATOR;
        $template_main_path = APPPATH . 'views' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
        $template_plugin_path = APPPATH . 'modules' . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
        $template_morefront_path = APPPATH . 'views' . DIRECTORY_SEPARATOR . 'frontpage' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
        if (is_dir($template_assets_path . $template_name) || is_dir($template_main_path . $template_name) || is_dir($template_plugin_path . $template_name) || is_dir($template_morefront_path . $template_name)) {
            $this->session->set_flashdata('error_message', '<div class="alert alert-danger" role="alert">' . $this->lang->line('error_message_alert') . '</div>');
            redirect($this->csz_referrer->getIndex('filemanager'), 'refresh');
            exit(1);
        }
        $this->Csz_model->copy_recursive($template_assets_path . 'cszdefault', $template_assets_path . $template_name);
        $this->Csz_model->copy_recursive($template_main_path . 'cszdefault', $template_main_path . $template_name);
        $this->Csz_model->copy_recursive($template_plugin_path . 'cszdefault', $template_plugin_path . $template_name);
        $this->Csz_model->copy_recursive($template_morefront_path . 'cszdefault', $template_morefront_path . $template_name);
        if (file_exists($template_assets_path . $template_name . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'cszdefault.min.css') && file_exists($template_assets_path . $template_name . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'cszdefault.css')) {
            @rename($template_assets_path . $template_name . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'cszdefault.min.css', $template_assets_path . $template_name . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . $template_name . '.min.css');
            @rename($template_assets_path . $template_name . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'cszdefault.css', $template_assets_path . $template_name . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . $template_name . '.css');
            $path_to_main = $template_main_path . $template_name . DIRECTORY_SEPARATOR . 'main.php';
            $main_contents = @file_get_contents($path_to_main);
            $main_contents1 = str_replace("cszdefault", $template_name, $main_contents);
            @file_put_contents($path_to_main, $main_contents1);
        }
        $this->session->set_flashdata('error_message', '<div class="alert alert-success" role="alert">' . $this->lang->line('success_message_alert') . '</div>');
        redirect($this->csz_referrer->getIndex('filemanager'), 'refresh');
    }
    
}
