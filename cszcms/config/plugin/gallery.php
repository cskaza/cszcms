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
$plugin_config['plugin_version']   = '1.0.6';
$plugin_config['plugin_description']   = 'gallery plugin'; /* For your plugin description */

/* for menu inside member zone. If not have please blank. 
 * Example: $plugin_config['plugin_member_menu'] = 'link_name';
 * The link automatic to {base_url}/plugin/{your_plugin_urlrewrite}
 * plugin_menu_permission_name is permission name from user_perms table on DB
 */
$plugin_config['plugin_member_menu'] = '';
$plugin_config['plugin_menu_permission_name'] = '';
$plugin_config['plugin_back_permission_name_backend'] = 'gallery';

/* Database Config */
$plugin_config['plugin_db_table']   = array(
    'gallery_db',
    'gallery_picture',
    'gallery_config',
); /* Please input all your pludin db table name */

/* Sitemap Generater Config (for content view page only) 
 * If don't want to use sitemap for your plugin. Please blank.
 */
$plugin_config['plugin_sitemap_viewtable']   = 'gallery_db';
/* for sitemap sql extra condition for this view table. If not have please blank. */
$plugin_config['plugin_sqlextra_condition']   = "active = '1' AND url_rewrite != ''";

/* Sitemap Generater Config (for content category page only) 
 * If don't want to use sitemap for your plugin. Please blank.
 */
$plugin_config['plugin_sitemap_cattable']   = '';
/* for sitemap sql extra condition for this category table. If not have please blank. */
$plugin_config['plugin_sqlextra_catcondition']   = "";

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
    FCPATH . '/cszcms/modules/plugin/views/templates/cszdefault/gallery/',
    FCPATH . '/cszcms/views/admin/plugin/gallery/',
    FCPATH . '/cszcms/language/dutch/plugin/gallery_lang.php',
    FCPATH . '/cszcms/language/english/plugin/gallery_lang.php',
    FCPATH . '/cszcms/language/italian/plugin/gallery_lang.php',
    FCPATH . '/cszcms/language/spanish/plugin/gallery_lang.php',
    FCPATH . '/cszcms/language/thai/plugin/gallery_lang.php',
);

/* Plugin widget Config (for content view page only) 
 * If don't have the widget for your plugin. Please blank.
 */
$plugin_config['plugin_widget_viewtable']   = 'gallery_db';
/* for sql extra condition for this view table. If not have please blank. */
$plugin_config['plugin_widget_condition']   = "active = '1' AND url_rewrite != ''";
/* for select the field from the database with array('field_name'). If not have please blank. */
$plugin_config['plugin_widget_sel_field']   = array(
    'gallery_db_id',
    'album_name',
    'url_rewrite',
    'keyword',
    'short_desc',
    'timestamp_create',
    'timestamp_update',
);
/* for sql table join with view table when have view ID. If not have please blank. */
$plugin_config['plugin_widget_othertable']   = 'gallery_picture';
$plugin_config['plugin_widget_othertable_idkey']   = 'gallery_db_id';
$plugin_config['plugin_widget_othertable_condition']   = "file_upload != ''";
/* for select the field from the table join with array('field_name'). If not have please blank. */
$plugin_config['plugin_widget_othertable_selfield']   = array(
    'file_upload',
    'caption',
);

/* End System Config (Important) */

/* Custom config (For your plugin config)
 * Please add your config after this section
 */
$plugin_config['backend_startup'] = '';
$plugin_config['frontend_startup'] = '';