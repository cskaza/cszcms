<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function compress()
{   
    if (function_exists('ini_set')) {
        @ini_set('max_execution_time', 600);
        @ini_set("pcre.recursion_limit", "16777");
    }
    $CI =& get_instance();
    $config = $CI->Csz_model->load_config();
    if($CI->Csz_model->chkIPBaned() !== FALSE){
        set_status_header(403);
        echo '<!DOCTYPE html><html lang="en"><head><title>403 Forbidden! IP Address can not access to this website</title>';
        echo link_tag(base_url('', '', TRUE).'templates/cszdefault/imgs/favicon.ico', 'shortcut icon', 'image/ico');
        echo '<meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="author" content="'.$config->site_name.'" />
        <meta name="generator" content="'.$CI->Csz_admin_model->cszGenerateMeta().'" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />';
        echo '</head><body><center>';
        echo '<h1 style="font-size:150px;color:red;margin-bottom:0px;">403</h1>';
        echo '<h2>403 Forbidden!</h2>';
        echo '<h3>Access is forbidden to the requested page. Your IP Address can not access to this website.<br>';
        echo 'Please contact to website administrator for allow to access.<br>at '.str_replace('@', '(at)', $config->default_email).'</h3><br><br>';
        echo $CI->Headfoot_html->footer();
        echo '</center></body></html>';
        exit(0);
    }
    if($config->html_optimize_disable != 1 && DEV_TOOLS_BAR === FALSE){
        $CI->output->set_output($CI->Csz_model->compress_html($CI->output->get_output()));
        $CI->output->_display();
    }else{
        $CI->output->_display();
    }
}

/* End of file compress.php */
/* Location: ./system/application/hooks/compress.php */