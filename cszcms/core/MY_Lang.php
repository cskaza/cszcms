<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* load the MX_Lang class */
require APPPATH . "third_party/MX/Lang.php";

class MY_Lang extends MX_Lang {

    public function load($langfile1, $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '', $_module = '') {
        $found = FALSE;
        $config =& get_config();
        if (empty($config['language'])) {
            $default_lang = 'english';
        } else {
            $default_lang = $config['language'];
        }
        if (is_array($langfile1)) {
            foreach ($langfile1 as $value) {
                $this->load($value, $idiom, $return, $add_suffix, $alt_path, $_module);
            }
            return;
        }
        if (empty($idiom) OR ! preg_match('/^[a-z_-]+$/i', $idiom)) {
            $idiom = $default_lang;
	}
        $langfile = str_replace('.php', '', $langfile1);
        $langfile = preg_replace('/_lang$/', '', $langfile) . '_lang.php';
        foreach (get_instance()->load->get_package_paths(TRUE) as $package_path) {
            $package_path .= 'language/' . $idiom . '/' . $langfile;
            if (file_exists($package_path)) {
                $found = TRUE;
                break;
            }
        }
        if ($found !== TRUE) {
            log_message('error', 'Unable to load the requested language file: language/' . $idiom . '/' . $langfile);
            $idiom = $default_lang;
        }
        parent::load($langfile1, $idiom, $return, $add_suffix, $alt_path, $_module);
    }

}
