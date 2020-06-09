<?php
defined('BASEPATH') || exit('No direct script access allowed');

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
$config['csz_version'] = '1.2.9'; /* For CMS Version */
$config['csz_release'] = 'release'; /* For release or beta */

/* 
 * For CSZ CMS Credit
 * Please do not remove or change this credit
 */
$config['cszcms_credit'] = 'Powered by <a href="https://www.cszcms.com" target="_blank" style="color: gray;">CSZ CMS</a>'; /* Please do not remove or change this credit */

/* 
 * For CSZ CMS check lastest version xml url
 * Defualt url https://cszcms.sourceforge.io/xml/lastest_version.xml
 * Backup url https://www.cszcms.com/downloads/lastest_version.xml
 */
$config['csz_chkverxmlurl_main'] = 'https://cszcms.sourceforge.io/xml/lastest_version.xml';
$config['csz_chkverxmlurl_backup'] = 'https://www.cszcms.com/downloads/lastest_version.xml';

/* 
 * For CSZ CMS upgrade server file path Ex. https://www.cszcms.com/downloads/upgrade/upgrade-to-1.1.4.zip
 * The upgrade file is "upgrade-to-1.1.4.zip" (Can't change the file upgrade name to other format. This format only)
 * Please set the server with path only https://www.cszcms.com/downloads/upgrade/
 */
$config['csz_upgrade_server_1'] = 'https://sourceforge.net/projects/cszcms/files/upgrade/';
$config['csz_upgrade_server_2'] = 'https://www.cszcms.com/downloads/upgrade/';

/* 
 * For CSZ CMS Official Website News RSS Feed URL on Backend Dashboard
 * Defualt Url https://www.cszcms.com/plugin/article/rss
 */
$config['csz_backend_feed_url'] = 'https://cszcms.sourceforge.io/xml/cszcms-backend-feed.xml';
$config['csz_backend_feed_backup_url'] = 'https://www.cszcms.com/plugin/article/rss';

/* 
 * For CSZ CMS plugin version checking xml url
 * Defualt url https://cszcms-plugin.sourceforge.io/plugin_list.xml
 * Backup url https://www.cszcms.com/downloads/plugins/plugin_list.xml
 */
$config['csz_pluginxmlurl_main'] = 'https://cszcms-plugin.sourceforge.io/plugin_list.xml';
$config['csz_pluginxmlurl_backup'] = 'https://www.cszcms.com/downloads/plugins/plugin_list.xml';

/* 
 * For CSZ CMS plugin install server file path Ex. https://www.cszcms.com/downloads/plugins/install/shop_install_1.0.6.zip
 * The upgrade file is "shop_install_1.0.6.zip" (Can't change the file install name to other format. This format only)
 * Please set the server with path only https://www.cszcms.com/downloads/plugins/install/
 */
$config['csz_plugin_install_server_1'] = 'https://sourceforge.net/projects/cszcms-plugin/files/install/';
$config['csz_plugin_install_server_2'] = 'https://www.cszcms.com/downloads/plugins/install/';

/* 
 * For CSZ CMS plugin upgrade server file path Ex. https://www.cszcms.com/downloads/plugins/upgrade/shop_upgrade_1.0.6.zip
 * The upgrade file is "shop_upgrade_1.0.6.zip" (Can't change the file upgrade name to other format. This format only)
 * Please set the server with path only https://www.cszcms.com/downloads/plugins/upgrade/
 */
$config['csz_plugin_upgrade_server_1'] = 'https://sourceforge.net/projects/cszcms-plugin/files/upgrade/';
$config['csz_plugin_upgrade_server_2'] = 'https://www.cszcms.com/downloads/plugins/upgrade/';

/* 
 * For CI upgrade server file path Ex. https://www.cszcms.com/downloads/ci_update/ci-3.1.9.zip
 * The upgrade file is "ci-3.1.9.zip" (Can't change the file upgrade name to other format. This format only)
 * Please set the server with path only https://www.cszcms.com/downloads/ci_update/
 */
$config['ci_update_server_1'] = 'https://sourceforge.net/projects/cszcms-plugin/files/ci_update/';
$config['ci_update_server_2'] = 'https://www.cszcms.com/downloads/ci_update/';