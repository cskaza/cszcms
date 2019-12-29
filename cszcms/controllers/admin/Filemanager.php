<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * CSZ CMS
 *
 * An open source content management system
 *
 * Copyright (c) 2019, Chinawut Phongphasook (CSKAZA).
 *
 * Astian Develop Public License (ADPL)
 * 
 * This Source Code Form is subject to the terms of the Astian Develop Public
 * License, v. 1.0. If a copy of the APL was not distributed with this
 * file, You can obtain one at http://astian.org/about-ADPL
 * 
 * @author	CSKAZA
 * @copyright   Copyright (c) 2019, Chinawut Phongphasook (CSKAZA).
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
        $this->load->library('elfinder_lib');
    }

    public function _init() {
        $this->template->set('core_css', $this->Csz_admin_model->coreCss());
        $this->template->set('core_js', $this->Csz_admin_model->coreJs());
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
        $this->template->setJS("<script data-main=\"".base_url('', '', TRUE)."assets/js/plugins/elfinder/elfinder_main.js\" src=\"//cdnjs.cloudflare.com/ajax/libs/require.js/2.3.5/require.min.js\"></script>
            <script>
            define('elFinderConfig', {
                defaultOpts : {
                    url : '" . $connect_url . "', /* connector URL (REQUIRED)*/
                    rememberLastDir : false,
                    useBrowserHistory : false,
                    defaultView : 'list',
                    sync : 5000,
                    themes : {
                        'dark-slim'     : 'https://johnfort.github.io/elFinder.themes/dark-slim/manifest.json',
                        'material'      : 'https://nao-pon.github.io/elfinder-theme-manifests/material-default.json',
                        'material-gray' : 'https://nao-pon.github.io/elfinder-theme-manifests/material-gray.json',
                        'material-light': 'https://nao-pon.github.io/elfinder-theme-manifests/material-light.json',
                        'bootstrap'     : 'https://nao-pon.github.io/elfinder-theme-manifests/bootstrap.json',
                        'moono'         : 'https://nao-pon.github.io/elfinder-theme-manifests/moono.json',
                        'win10'         : 'https://nao-pon.github.io/elfinder-theme-manifests/win10.json'
                    },    
                    commandsOptions : {
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
            </script>");
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
                    'disabled' => array('rm', 'duplicate', 'paste', 'mkdir', 'mkfile', 'archive', 'extract', 'resize', 'chmod', 'upload'),
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
    
    public function allowPhotoType(){
        return array(
            'image/bmp', 'image/x-bmp', 'image/x-bitmap', 'image/x-xbitmap', 'image/x-win-bitmap', 'image/x-windows-bmp', 'image/ms-bmp', 'image/x-ms-bmp', 'application/bmp', 'application/x-bmp', 'application/x-win-bitmap', 
            'image/gif', 
            'image/jpeg', 'image/pjpeg', 
            'image/png',  'image/x-png', 
            'image/x-icon', 'image/x-ico', 'image/vnd.microsoft.icon', 
            'text/plain', 
            'application/msword', 'application/vnd.ms-office', 
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword', 
            'application/pdf', 'application/force-download', 'application/x-download', 'binary/octet-stream',
            'application/powerpoint', 'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/x-zip', 'application/zip', 'application/x-zip-compressed', 'application/s-compressed', 'multipart/x-zip',
            'application/x-rar', 'application/rar', 'application/x-rar-compressed',
        ); /* images,css,js,doc,xls,ppt,zip,rar */
    }
    
    public function allowAssetsType(){
        return array(
            'image/bmp', 'image/x-bmp', 'image/x-bitmap', 'image/x-xbitmap', 'image/x-win-bitmap', 'image/x-windows-bmp', 'image/ms-bmp', 'image/x-ms-bmp', 'application/bmp', 'application/x-bmp', 'application/x-win-bitmap', 
            'image/gif', 
            'image/jpeg', 'image/pjpeg', 
            'image/png',  'image/x-png', 
            'image/x-icon', 'image/x-ico', 'image/vnd.microsoft.icon', 
            'text/plain',  
            'text/javascript', 'text/x-javascript', 
            'text/css',
        ); /* images,css,js */
    }
    
    public function allowMainType(){
        return array(
            'application/x-httpd-php', 'application/php', 'application/x-php', 'text/php', 'text/x-php', 'application/x-httpd-php-source', 
            'text/html', 
        ); /* php,html,html */
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
                    'URL' => base_url('', '', TRUE) . 'photo',
                    'alias' => 'File Upload',
                    'mimeDetect' => 'internal',
                    'trashHash' => 't1_Lw', // elFinder's hash of trash folder
                    'winHashFix' => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                    'accessControl' => array($this, 'elfinderAccess'), // disable and hide dot starting files (OPTIONAL)
                    'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
                    'uploadAllow'   => $this->allowPhotoType(), // Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
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
                    'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
                    'uploadAllow'   => $this->allowAssetsType(), // Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
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
                    'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
                    'uploadAllow'   => $this->allowMainType(), // Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
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
                    'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
                    'uploadAllow'   => $this->allowMainType(), // Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
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
                    'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
                    'uploadAllow'   => $this->allowMainType(), // Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
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
                    'URL' => base_url('', '', TRUE) . 'photo',
                    'alias' => 'File Upload',
                    'mimeDetect' => 'internal',
                    'winHashFix' => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                    'accessControl' => array($this, 'elfinderAccess'), // disable and hide dot starting files (OPTIONAL)
                    'disabled' => array('rm', 'mkdir', 'mkfile' , 'archive', 'extract', 'resize', 'chmod', 'upload'),
                    'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
                    'uploadAllow'   => $this->allowPhotoType(), // Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
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
                    'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
                    'uploadAllow'   => $this->allowAssetsType(), // Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
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
                    'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
                    'uploadAllow'   => $this->allowMainType(), // Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
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
                    'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
                    'uploadAllow'   => $this->allowMainType(), // Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
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
                    'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
                    'uploadAllow'   => $this->allowMainType(), // Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
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
