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
$config['csz_version'] = '1.1.7'; /* For CMS Version */
$config['csz_release'] = 'release'; /* For release or beta */

/* 
 * For CSZ CMS check lastest version xml url
 * Defualt url https://www.cszcms.com/downloads/lastest_version.xml
 * Backup url https://cszcms.sourceforge.io/xml/lastest_version.xml
 */
$config['csz_chkverxmlurl_main'] = 'https://www.cszcms.com/downloads/lastest_version.xml';
$config['csz_chkverxmlurl_backup'] = 'https://cszcms.sourceforge.io/xml/lastest_version.xml';

/* 
 * For CSZ CMS upgrade server file path Ex. https://www.cszcms.com/downloads/upgrade/upgrade-to-1.1.4.zip
 * The upgrade file is "upgrade-to-1.1.4.zip" (Can't change the file upgrade name to other format. This format only)
 * Please set the server with path only https://www.cszcms.com/downloads/upgrade/
 */
$config['csz_upgrade_server_1'] = 'http://jaist.dl.sourceforge.net/project/cszcms/upgrade/';
$config['csz_upgrade_server_2'] = 'https://www.cszcms.com/downloads/upgrade/';

/* 
 * For CSZ CMS Official Website News RSS Feed URL on Backend Dashboard
 * Defualt Url https://www.cszcms.com/plugin/article/rss
 */
$config['csz_backend_feed_url'] = 'https://www.cszcms.com/plugin/article/rss';
$config['csz_backend_feed_backup_url'] = 'http://astian.org/plugin/article/rss';

/* 
 * For CSZ CMS plugin version checking xml url
 * Defualt url http://localhost/plugintest/plugin_list.xml
 * Backup url http://localhost/plugintest/plugin_list.xml
 */
$config['csz_pluginxmlurl_main'] = 'https://www.cszcms.com/downloads/plugins/plugin_list.xml';
$config['csz_pluginxmlurl_backup'] = 'https://cszcms-plugin.sourceforge.io/plugin_list.xml';

/* 
 * For CSZ CMS plugin install server file path Ex. http://localhost/plugintest/install/shop_install_1.0.6.zip
 * The upgrade file is "shop_install_1.0.6.zip" (Can't change the file install name to other format. This format only)
 * Please set the server with path only http://localhost/plugintest/install/
 */
$config['csz_plugin_install_server_1'] = 'http://jaist.dl.sourceforge.net/project/cszcms-plugin/install/';
$config['csz_plugin_install_server_2'] = 'https://www.cszcms.com/downloads/plugins/install/';

/* 
 * For CSZ CMS plugin upgrade server file path Ex. http://localhost/plugintest/upgrade/shop_upgrade_1.0.6.zip
 * The upgrade file is "shop_upgrade_1.0.6.zip" (Can't change the file upgrade name to other format. This format only)
 * Please set the server with path only http://localhost/plugintest/upgrade/
 */
$config['csz_plugin_upgrade_server_1'] = 'http://jaist.dl.sourceforge.net/project/cszcms-plugin/upgrade/';
$config['csz_plugin_upgrade_server_2'] = 'https://www.cszcms.com/downloads/plugins/upgrade/';
