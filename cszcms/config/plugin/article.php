<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* For your plugin config.
 * Importnt! Please Don't change the config item index name (for systems config)
 * 
 * For load plugin config:
 * $this->Csz_model->getPluginConfig('plugin_config_filename', 'item index name');
 * Ex. $this->Csz_model->getPluginConfig('article', 'plugin_name');
 * 
 */

/* Start System Config (Important) */
/* General Config */
$plugin_config['plugin_name']  = 'Article';
$plugin_config['plugin_urlrewrite']  = 'article'; /* Please don't have any blank space */
$plugin_config['plugin_author']  = 'CSZCMS'; /* For your name */
$plugin_config['plugin_version']   = '1.0.4';

/* Database Config */
$plugin_config['plugin_db_table']   = array(
    'article_db',
); /* Please input all your pludin db table name */

/* Sitemap Generater Config (for content view page only) 
 * If don't want to use sitemap for your plugin. Please blank.
 */
$plugin_config['plugin_sitemap_viewtable']   = 'article_db';
/* for sitemap sql extra condition for this view table. If not have please blank. */
$plugin_config['plugin_sqlextra_condition']   = "active = '1' AND url_rewrite != '' AND is_category != '1'";

/* All your plugin file path 
 * For directory please put / into the end of path.
 * Filename or Directory name is case sensitive.
 */
$plugin_config['plugin_file_path']   = array(
    FCPATH . '/photo/plugin/article/',
    FCPATH . '/cszcms/config/plugin/article.php',
    FCPATH . '/cszcms/controllers/admin/plugin/Article.php',
    FCPATH . '/cszcms/models/plugin/Article_model.php',
    FCPATH . '/cszcms/modules/plugin/controllers/Article.php',
    FCPATH . '/cszcms/modules/plugin/views/article/',
    FCPATH . '/cszcms/views/admin/plugin/article/',
);
/* End System Config (Important) */

/* Custom config (For your plugin config)
 * Please add your config after this section
 */
