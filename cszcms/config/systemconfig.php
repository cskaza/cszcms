<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
/* 
 * For CSZ CMS version config
 */
$config['csz_version'] = '1.1.4'; /* For CMS Version */
$config['csz_release'] = 'release'; /* For release or beta */

/* 
 * For CSZ CMS check lastest version xml url
 * Defualt url https://www.cszcms.com/downloads/lastest_version.xml
 * Backup url https://cszcms-d99bf.firebaseapp.com/lastest_version.xml
 */
$config['csz_chkverxmlurl_main'] = 'https://www.cszcms.com/downloads/lastest_version.xml';
$config['csz_chkverxmlurl_backup'] = 'https://cszcms-d99bf.firebaseapp.com/lastest_version.xml';

/* 
 * For CSZ CMS upgrade server file path Ex. https://www.cszcms.com/downloads/upgrade/upgrade-to-1.1.4.zip
 * The upgrade file is "upgrade-to-1.1.4.zip" (Can't change the file upgrade name to other name. This format only)
 * Please set the server with path only https://www.cszcms.com/downloads/upgrade/
 */
$config['csz_upgrade_server_1'] = 'http://jaist.dl.sourceforge.net/project/cszcms/upgrade/';
$config['csz_upgrade_server_2'] = 'https://www.cszcms.com/downloads/upgrade/';
