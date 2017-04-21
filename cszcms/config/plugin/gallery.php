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
$plugin_config['plugin_name']  = 'Gallery';
$plugin_config['plugin_urlrewrite']  = 'gallery'; /* Please don't have any blank space */
$plugin_config['plugin_author']  = 'CSZCMS'; /* For your name */
$plugin_config['plugin_version']   = '1.0.3';

/* Database Config */
$plugin_config['plugin_db_table']   = array(
    'gallery_db',
    'gallery_picture',
); /* Please input all your pludin db table name */

/* Sitemap Generater Config (for content view page only) 
 * If don't want to use sitemap for your plugin. Please blank.
 */
$plugin_config['plugin_sitemap_viewtable']   = 'gallery_db';
/* for sitemap sql extra condition for this view table. If not have please blank. */
$plugin_config['plugin_sqlextra_condition']   = "active = '1' AND url_rewrite != ''";

/* All your plugin file path 
 * For directory please put / into the end of path.
 * Filename or Directory name is case sensitive.
 */
$plugin_config['plugin_file_path']   = array(
    FCPATH . '/photo/plugin/gallery/',
    FCPATH . '/cszcms/config/plugin/gallery.php',
    FCPATH . '/cszcms/controllers/admin/plugin/Gallery.php',
    FCPATH . '/cszcms/models/plugin/Gallery_model.php',
    FCPATH . '/cszcms/modules/plugin/controllers/Gallery.php',
    FCPATH . '/cszcms/modules/plugin/views/gallery/',
    FCPATH . '/cszcms/views/admin/plugin/gallery/',
);
/* End System Config (Important) */

/* Custom config (For your plugin config)
 * Please add your config after this section
 */
