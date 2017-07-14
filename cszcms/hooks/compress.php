<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function compress()
{
    @ini_set("pcre.recursion_limit", "16777");
    $CI =& get_instance();
    $buffer = $CI->output->get_output();
    $config = $CI->Csz_model->load_config();
    $new_buffer = NULL;
    if($config->html_optimize_disable != 1){
        $search = array(
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        );
        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );
        $new_buffer = preg_replace($search, $replace, $buffer);
    }
    // We are going to check if processing has working
    if ($new_buffer === null)
    {
        $new_buffer = $buffer;
    }
    $CI->output->set_output($new_buffer);
    $CI->output->_display();
}

/* End of file compress.php */
/* Location: ./system/application/hooks/compress.php */