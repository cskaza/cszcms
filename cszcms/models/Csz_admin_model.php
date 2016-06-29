<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Csz_admin_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('Csz_model');
        $this->load->database();
    }

    public function load_config() {
        $this->db->limit(1, 0);
        $query = $this->db->get('settings');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row;
        } else {
            return FALSE;
        }
    }
    
    public function getLatestVersion($xml_url = '') {
        if (!$xml_url)
            $xml_url = 'http://www.cszcms.com/downloads/lastest_version.xml';
        $xml = simplexml_load_file($xml_url) or die("Error: Cannot create object");
        return $xml;
    }

    public function chkVerUpdate($cur_ver, $xml_url = '') {
        $ver_r = array();
        $cur_r = array();
        $xml = $this->getLatestVersion($xml_url);
        if ($xml->version) {
            $cur_ver = str_replace(' ', '.', $cur_ver);
            $cur_r = explode('.', $cur_ver);
            $ver_r = explode('.', $xml->version);
            if (($ver_r[0] == $cur_r[0] && $ver_r[1] == $cur_r[1] && $ver_r[2] > $cur_r[2]) || ($ver_r[0] == $cur_r[0] && $ver_r[1] > $cur_r[1]) || ($ver_r[0] > $cur_r[0])) {
                return $xml->version;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    public function findNextVersion($cur_ver, $xml_url = '') {
        /* sub version is limit x.9.9 */
        $cur_r = array();
        $pre_r = array();
        $xml = $this->getLatestVersion($xml_url);
        $last_ver = $xml->version;
        if ($cur_ver && $last_ver) {
            $cur_ver = str_replace(' ', '.', $cur_ver);
            $cur_r = explode('.', $cur_ver);
            if($cur_ver == $last_ver){
                return $last_ver;
            }else{
                if($cur_r[1] <= 9 && $cur_r[2] < 9){
                    return $cur_r[0] . '.' . $cur_r[1] . '.' . ($cur_r[2] + 1);
                }else if($cur_r[1] < 9 && $cur_r[2] == 9){
                    return $cur_r[0] . '.' . ($cur_r[1] + 1) . '.0';
                }else if($cur_r[1] == 9 && $cur_r[2] == 9){
                    return ($cur_r[0] + 1) . '.0.0';
                }else{
                    return FALSE;
                }
            }
        } else {
            return FALSE;
        }
    }

    public function getLang() {
        /* Get Lang for Admin */
        $row = $this->load_config();
        return $row->admin_lang;
    }

    public function getCurPages() {
        $totSegments = $this->uri->total_segments();
        if (!is_numeric($this->uri->segment($totSegments)) && $this->uri->segment($totSegments) != 'new' && $this->uri->segment($totSegments) != 'add') {
            $pageURL = $this->uri->segment($totSegments);
        } else if (is_numeric($this->uri->segment($totSegments)) || $this->uri->segment($totSegments) == 'new' || $this->uri->segment($totSegments) == 'add') {
            if ($this->uri->segment($totSegments - 1) == 'edit' || $this->uri->segment($totSegments - 1) == 'view') {
                $pageURL = $this->uri->segment($totSegments - 2);
            } else {
                $pageURL = $this->uri->segment($totSegments - 1);
            }
        }
        if ($pageURL == "") {
            $pageURL = "admin";
        }
        return $pageURL;
    }

    public function countTable($table) {
        return $this->db->count_all($table);
    }

    public function pageSetting($base_url, $total_row, $result_per_page, $num_link) {
        $this->load->library('pagination');
        $config = array();
        $config["base_url"] = $base_url;
        $config["total_rows"] = $total_row;
        $config["per_page"] = $result_per_page;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = $num_link;
        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
    }

    public function getIndexData($table, $limit = 0, $offset = 0, $orderby = 'timestamp_create', $sort = 'desc', $search_sql = '', $groupby = '') {
        // Get a list of all user accounts
        $this->db->select('*');
        if($search_sql){
            if(is_array($search_sql)){
                /* $search = array('field'=>'value') */
                foreach ($search_sql as $key => $value) {
                    $this->db->where($key, $value);
                }
            }else{
                /* $search = "name='Joe' AND status LIKE '%boss%' OR status1 LIKE '%active%'"*/
                $this->db->where($search_sql);
            }
        }
        $this->db->order_by($orderby, $sort);
        if ($groupby) $this->db->group_by($groupby);
        if ($limit){
            if(!$offset) $offset = 1;
            $start = (($offset) * $limit) - $limit;
            $this->db->limit($limit, $start);
        }
        
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
            return $row;
        } else {
            return FALSE;
        }
    }

    function getUser($id) {
        // Get the user details
        $this->db->select("*");
        $this->db->where("user_admin_id", $id);
        $this->db->limit(1, 0);
        $query = $this->db->get('user_admin');
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row;
        } else {
            return FALSE;
        }
    }

    function getUserEmail($id) {
        // Get the user email address
        $this->db->select("email");
        $this->db->where("user_admin_id", $id);
        $query = $this->db->get('user_admin');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $email = $rows->email;
                return $email;
            }
        }
    }

    function createUser() {
        // Create the user account
        if ($this->input->post('active')) {
            $active = $this->input->post('active', TRUE);
        } else {
            $active = 0;
        }
        $data = array(
            'name' => $this->input->post('name', TRUE),
            'email' => $this->input->post('email', TRUE),
            'password' => md5($this->input->post('password', TRUE)),
            'user_type' => $this->input->post('user_type', TRUE),
            'active' => $active,
            'md5_hash' => md5(time() + mt_rand(1, 99999999)),
        );
        $this->db->set('md5_lasttime', 'NOW()', FALSE);
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->insert('user_admin', $data);
    }

    function updateUser($id) {
        // update the user account
        if ($this->input->post('active')) {
            $active = $this->input->post('active', TRUE);
        } else {
            $active = 0;
        }
        $this->db->set('name', $this->input->post("name", TRUE), TRUE);
        $this->db->set('email', $this->input->post('email', TRUE), TRUE);
        if ($this->input->post('password') != '') {
            $this->db->set('password', md5($this->input->post('password', TRUE)), TRUE);
            $this->db->set('md5_hash', md5(time() + mt_rand(1, 99999999)), TRUE);
            $this->db->set('md5_lasttime', 'NOW()', FALSE);
        }
        if($id != 1 && $this->session->userdata('admin_type') == 'admin'){
            $this->db->set('user_type', $this->input->post("user_type", TRUE), TRUE);
        }
        if ($this->session->userdata('user_admin_id') != $id) {
            $this->db->set('active', $active, FALSE);
        }
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->where('user_admin_id', $id);
        $this->db->update('user_admin');
    }

    public function removeUser($id) {
        // Delete a user account
        if ($id != 1) {
            $this->db->delete('user_admin', array('user_admin_id' => $id));
        }
    }

    public function removeData($table, $id_field, $id_val) {
        if ($table && $id_field && $id_val) {
            // Delete a data from table
            $this->db->delete($table, array($id_field => $id_val));
        } else {
            return FALSE;
        }
    }

    public function dropTable($table_name) {
        $this->load->dbforge();
        if ($table_name) {
            $this->dbforge->drop_table($table_name, TRUE);
        } else {
            return FALSE;
        }
    }

    public function chkMd5Time($md5, $table = '') {
        if(!$table) $table = 'user_admin';
        $this->db->select("*");
        $this->db->where("md5_hash", $md5);
        $this->db->where("md5_lasttime < DATE_SUB(NOW(), INTERVAL 30 MINUTE)");
        $this->db->limit(1, 0);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            $this->db->set('md5_hash', md5(time() + mt_rand(1, 99999999)), TRUE);
            $this->db->set('md5_lasttime', 'NOW()', FALSE);
            $this->db->where('md5_hash', $md5);
            $this->db->update($table);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function login($email, $password) {
        if ($this->Csz_model->chkCaptchaRes() == '') {
            return 'CAPTCHA_WRONG';
        } else {
            $this->db->select("*");
            $this->db->where("email", $email);
            $this->db->where("password", $password);
            $this->db->where("user_type != 'member'");
            $this->db->where("active", '1');
            $this->db->limit(1, 0);
            $query = $this->db->get("user_admin");
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                    $data = array(
                        'user_admin_id' => $rows->user_admin_id,
                        'admin_name' => $rows->name,
                        'admin_email' => $rows->email,
                        'admin_type' => $rows->user_type,
                        'admin_logged_in' => TRUE,
                    );
                    $this->session->set_userdata($data);
                    return 'SUCCESS';
                }
            } else {
                return 'INVALID';
            }
        }
    }
    
    public function getLangISOfromName($lang_name) {
        /* Get Language ISO from language config file (for backend system) */
        $this->config->load('language');
        $lang_config = $this->config->item('admin_language_iso');
        return $lang_config[$lang_name];
    }
    
    public function getLangNamefromISO($lang_iso) {
        /* Get Language ISO from language config file (for backend system) */
        $this->config->load('language');
        $lang_config = $this->config->item('admin_language_iso');
        $key = array_search($lang_iso, $lang_config);
        if($key){
            return $key;
        }else{
            return 'english';
        }
        
    }

    public function cszCopyright() {
        $csz_copyright = '<br><span class="copyright">Powered by CSZ-CMS V.' . $this->Csz_model->getVersion() . '</span>';
        return $csz_copyright;
    }

    public function coreCss() {
        $core_css = link_tag('assets/css/bootstrap.min.css');
        $core_css.= link_tag('assets/css/jquery-ui-themes-1.11.4/themes/smoothness/jquery-ui.min.css');
        $core_css.= link_tag('assets/font-awesome/css/font-awesome.min.css');
        $core_css.= link_tag('assets/css/flag-icon.min.css');
        return $core_css;
    }

    public function coreJs() {
        if(LANG){
            $hl = '?hl='.$this->getLangISOfromName(LANG);
        }else{
            $hl = '';
        }
        $core_js = '<script src="' . base_url() . 'assets/js/jquery-1.10.2.min.js"></script>';
        $core_js.= '<script src="' . base_url() . 'assets/js/bootstrap.min.js"></script>';
        $core_js.= '<script src="' . base_url() . 'assets/js/jquery-ui.min.js"></script>';
        $core_js.= '<script src="' . base_url() . 'assets/js/jquery.ui.touch-punch.min.js"></script>';
        $core_js.= '<script src="' . base_url() . 'assets/js/tinymce/tinymce.min.js"></script>';
        $core_js.= '<script src="https://www.google.com/recaptcha/api.js'.$hl.'"></script>';
        return $core_js;
    }

    public function coreMetatags($desc_txt) {
        $meta = array(
            array('name' => 'robots', 'content' => 'no-cache'),
            array('name' => 'description', 'content' => $desc_txt),
            array('name' => 'keywords', 'content' => $this->load_config()->keywords),
            array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1'),
            array('name' => 'author', 'content' => 'CSKAZA'),
            array('name' => 'X-UA-Compatible', 'content' => 'IE=edge', 'type' => 'equiv'),
            array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
        );
        $return_meta = meta($meta);
        return $return_meta;
    }

    public function getSocial() {
        $this->db->select("*");
        $this->db->order_by("footer_social_id", "asc");
        $query = $this->db->get('footer_social');
        if ($query->num_rows() > 0) {
            $row = $query->result();
            return $row;
        } else {
            return FALSE;
        }
    }

    public function updateSocial() {
        $this->db->select("*");
        $query = $this->db->get("footer_social");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array();
                $data['social_url'] = $this->input->post($rows->social_name, TRUE);
                if (isset($_POST['checkbox' . $rows->social_name])) {
                    $data['active'] = $this->input->post('checkbox' . $rows->social_name, TRUE);
                } else {
                    $data['active'] = 0;
                }
                $this->db->set('timestamp_update', 'NOW()', FALSE);
                $this->db->where("social_name", $rows->social_name);
                $this->db->update('footer_social', $data);
            }
        }
    }

    public function updateSettings() {
        $add_js_clean = array('<script type="text/javascript">', '<script>', '</script>', '[removed]');
        $additional_js = str_replace($add_js_clean, '', $this->input->post('additional_js'));
        $data = array(
            'themes_config' => $this->input->post('siteTheme', TRUE),
            'admin_lang' => $this->input->post('siteLang', TRUE),
            'site_footer' => $this->input->post('siteFooter', TRUE),
            'default_email' => $this->input->post('siteEmail', TRUE),
            'keywords' => $this->input->post('siteKeyword', TRUE),
            'additional_js' => $additional_js,
            'additional_metatag' => $this->input->post('additional_metatag'),
            'googlecapt_active' => $this->input->post('googlecapt_active', TRUE),
            'googlecapt_sitekey' => $this->input->post('googlecapt_sitekey', TRUE),
            'googlecapt_secretkey' => $this->input->post('googlecapt_secretkey', TRUE),
            'link_statistic_active' => $this->input->post('link_statistic_active', TRUE)
        );

        if ($this->input->post('del_file')) {
            $upload_file = '';
            unlink('photo/logo/' . $this->input->post('del_file', TRUE));
        } else {
            $upload_file = $this->input->post('siteLogo');
            if ($_FILES['file_upload']['type'] == 'image/png' || $_FILES['file_upload']['type'] == 'image/jpg' || $_FILES['file_upload']['type'] == 'image/jpeg') {
                $paramiter = '_1';
                $photo_id = time();
                $uploaddir = 'photo/logo/';
                $file_f = $_FILES['file_upload']['tmp_name'];
                $file_name = $_FILES['file_upload']['name'];
                $upload_file = $this->file_upload($file_f, $file_name, $this->input->post('siteLogo', TRUE), $uploaddir, $photo_id, $paramiter);
            }
        }
        $data['site_logo'] = $upload_file;
        if ($this->input->post('siteTitle') != "")
            $data['site_name'] = $this->input->post('siteTitle', TRUE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->where("settings_id", 1);
        $this->db->update('settings', $data);
    }

    public function file_upload($photo, $photo_name, $tmp_photo, $uploaddir, $photo_id, $paramiter, $yearR = '', $maxSizeR = 1900) {
        if ($yearR) {
            $year = $yearR . "/";
        } else {
            $year = date("Y") . "/";
        }

        if ($uploaddir) {
            if (file_exists($uploaddir) === FALSE) {
                mkdir($uploaddir, 0777);
            }
            if (file_exists($uploaddir . $year) === FALSE) {
                mkdir($uploaddir . $year, 0777);
            }
        }
        if (!$photo) {
            $photo = $tmp_photo;
        } else {
            $ext = explode(".", $photo_name);
            $ext_n = count($ext) - 1;
            if (strtoupper($ext[$ext_n]) == "JPG" || strtoupper($ext[$ext_n]) == "JPEG" || strtoupper($ext[$ext_n]) == "PNG" || strtoupper($ext[$ext_n]) == "GIF") {
                $org_filename = $photo_id . $paramiter . "-org." . $ext[$ext_n];
                $newfile = $uploaddir . $year . $org_filename;
                if (is_uploaded_file($photo)) { // upload original image
                    if (!copy($photo, "$newfile")) {
                        echo "<script>alert('Error: not copy');</script>";
                    }
                }
                if (@filesize($newfile) > (1024 * 1024 * 5)) {
                    $photo = "";
                    unlink($newfile);
                } else {
                    list($w, $h) = getimagesize($newfile);
                    if (($w > $maxSizeR) || ($h > $maxSizeR) && (!strtoupper($ext[$ext_n]) == "GIF")) {
                        $im = $this->thumbnail($org_filename, $uploaddir . $year, $maxSizeR); //resize image
                        $small_filename = $photo_id . $paramiter . "." . $ext[$ext_n];
                        $this->imageToFile($im, $uploaddir . $year . $small_filename); //make image to file for resize
                        $photo = $year . $small_filename;
                        unlink($newfile);
                    } else {
                        $photo = $year . $org_filename;
                    }
                }
                if ($tmp_photo)
                    unlink($uploaddir . $tmp_photo);
            } else if (strtoupper($ext[$ext_n]) == "PDF" || strtoupper($ext[$ext_n]) == "DOC" || strtoupper($ext[$ext_n]) == "DOCX" || strtoupper($ext[$ext_n]) == "ODT" || strtoupper($ext[$ext_n]) == "TXT" || strtoupper($ext[$ext_n]) == "ODG" || strtoupper($ext[$ext_n]) == "ODP" || strtoupper($ext[$ext_n]) == "ODS" || strtoupper($ext[$ext_n]) == "ZIP" || strtoupper($ext[$ext_n]) == "RAR" || strtoupper($ext[$ext_n]) == "PSD" || strtoupper($ext[$ext_n]) == "CSV" || strtoupper($ext[$ext_n]) == "XLS" || strtoupper($ext[$ext_n]) == "XLSX" || strtoupper($ext[$ext_n]) == "PPT" || strtoupper($ext[$ext_n]) == "PPTX" || strtoupper($ext[$ext_n]) == "MP3" || strtoupper($ext[$ext_n]) == "WAV" || strtoupper($ext[$ext_n]) == "MP4" || strtoupper($ext[$ext_n]) == "FLV" || strtoupper($ext[$ext_n]) == "WMA" || strtoupper($ext[$ext_n]) == "AVI" || strtoupper($ext[$ext_n]) == "MOV" || strtoupper($ext[$ext_n]) == "M4V" || strtoupper($ext[$ext_n]) == "WMV" || strtoupper($ext[$ext_n]) == "M3U" || strtoupper($ext[$ext_n]) == "PLS") {
                $final_filename = $photo_id . $paramiter . "." . $ext[$ext_n];
                $newfile = $uploaddir . $year . $final_filename;
                if (is_uploaded_file($photo)) {
                    if (!copy($photo, "$newfile")) {
                        print "Error Uploading File.";
                        exit();
                    }
                }
                $photo = $year . $final_filename;
                if (@filesize($newfile) > (1024 * 1024 * 100)) { // Limit 100 MB
                    $photo = "";
                    unlink($newfile);
                }
                if ($tmp_photo)
                    unlink($uploaddir . $tmp_photo);
            }else {
                $photo = "";
            }
        }
        return $photo;
    }

    /**
     * Create a thumbnail image from $inputFileName no taller or wider than
     * $maxSize. Returns the new image resource or false on error.
     * Author: mthorn.net
     */
    public function thumbnail($inputFileName, $uploaddir, $maxSize = 500) {
        $info = @getimagesize($uploaddir . $inputFileName);
        $type = isset($info['type']) ? $info['type'] : $info[2];
        // Check support of file type
        if (!(imagetypes() & $type)) {
            // Server does not support file type
            return false;
        }
        $width = isset($info['width']) ? $info['width'] : $info[0];
        $height = isset($info['height']) ? $info['height'] : $info[1];
        // Calculate aspect ratio
        $wRatio = $maxSize / $width;
        $hRatio = $maxSize / $height;
        // Using imagecreatefromstring will automatically detect the file type
        $sourceImage = imagecreatefromstring(file_get_contents($uploaddir . $inputFileName));
        // Calculate a proportional width and height no larger than the max size.
        if (($width <= $maxSize) && ($height <= $maxSize)) {
            // Input is smaller than thumbnail, do nothing
            return $sourceImage;
        } elseif (($wRatio * $height) < $maxSize) {
            // Image is horizontal
            $tHeight = ceil($wRatio * $height);
            $tWidth = $maxSize;
        } else {
            // Image is vertical
            $tWidth = ceil($hRatio * $width);
            $tHeight = $maxSize;
        }
        $thumb = imagecreatetruecolor($tWidth, $tHeight);
        if ($sourceImage === false) {
            // Could not load image
            return false;
        }
        // Copy resampled makes a smooth thumbnail
        imagecopyresampled($thumb, $sourceImage, 0, 0, 0, 0, $tWidth, $tHeight, $width, $height);
        imagedestroy($sourceImage);
        return $thumb;
    }

    /**
     * Save the image to a file. Type is determined from the extension.
     * $quality is only used for jpegs.
     * Author: mthorn.net
     */
    public function imageToFile($im, $fileName, $quality = 80) {
        if (!$im || file_exists($fileName)) {
            return false;
        }
        $ext = strtolower(substr($fileName, strrpos($fileName, '.')));
        switch ($ext) {
            case '.gif':
                imagegif($im, $fileName);
                break;
            case '.jpg':
            case '.jpeg':
                imagejpeg($im, $fileName, $quality);
                break;
            case '.png':
                imagepng($im, $fileName);
                break;
            case '.bmp':
                imagewbmp($im, $fileName);
                break;
            default:
                return false;
        }
        return true;
    }

    public function sortNav() {
        $i = 0;
        $main_arrange = 1;
        $menu_id = $this->input->post('menu_id', TRUE);
        while ($i < count($menu_id)) {
            if ($menu_id[$i]) {
                $this->db->set('arrange', $main_arrange, FALSE);
                $this->db->set('timestamp_update', 'NOW()', FALSE);
                $this->db->where("page_menu_id", $menu_id[$i]);
                $this->db->update('page_menu');
                $main_arrange++;
            }
            $i++;
        }
        $menusub_id = $this->input->post('menusub_id', TRUE);
        if (!empty($menusub_id)) {
            foreach (array_keys($menusub_id) as $key) {
                $sub_arrange = 1;
                for ($i = 0; $i < count($menusub_id[$key]); $i++) {
                    if ($menusub_id[$key][$i]) {
                        $this->db->set('arrange', $sub_arrange, FALSE);
                        $this->db->set('timestamp_update', 'NOW()', FALSE);
                        $this->db->where("page_menu_id", $menusub_id[$key][$i]);
                        $this->db->where("drop_page_menu_id", $key);
                        $this->db->update('page_menu');
                        $sub_arrange++;
                    }
                }
            }
        }
    }

    public function getPagesAll() {
        $this->db->select("*");
        $query = $this->db->get('pages');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    public function getAllMenu($drop_page_menu_id = 0, $lang) {
        if ($drop_page_menu_id) {
            $this->db->where("drop_page_menu_id", $drop_page_menu_id);
        } else {
            $this->db->where("drop_page_menu_id", 0);
        }
        $this->db->where("lang_iso", $lang);
        $this->db->order_by("arrange", "asc");
        $query = $this->db->get('page_menu');
        if ($query->num_rows() > 0) {
            $row = $query->result();
            return $row;
        } else {
            return FALSE;
        }
    }

    public function getDropMenuAll() {
        $this->db->select("*");
        $this->db->where('drop_menu', 1);
        $query = $this->db->get('page_menu');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    public function getMenuArrange($mainmenu_id = 0) {
        $this->db->select("*");
        if ($mainmenu_id) {
            $this->db->where('drop_menu', 0);
        }
        $this->db->where('drop_page_menu_id', $mainmenu_id);
        $query = $this->db->get('page_menu');
        return ($query->num_rows()) + 1;
    }

    public function insertMenu() {
        // Create the new menu
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        ($this->input->post('dropdown')) ? $dropdown = $this->input->post('dropdown', TRUE) : $dropdown = 0;
        ($this->input->post('dropMenu')) ? $dropMenu = $this->input->post('dropMenu', TRUE) : $dropMenu = 0;
        ($this->input->post('menuType')) ? $arrange = $this->getMenuArrange($this->input->post('dropMenu')) : $arrange = $this->getMenuArrange();
        $data = array(
            'menu_name' => $this->input->post('name', TRUE),
            'lang_iso' => $this->input->post('lang_iso', TRUE),
            'pages_id' => $this->input->post('pageUrl', TRUE),
            'other_link' => $this->input->post('url_link', TRUE),
            'drop_menu' => $dropdown,
            'drop_page_menu_id' => $dropMenu,
            'active' => $active,
            'arrange' => $arrange,
        );
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->insert('page_menu', $data);
    }

    public function updateMenu($id) {
        // Update the menu
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        ($this->input->post('dropdown')) ? $dropdown = $this->input->post('dropdown', TRUE) : $dropdown = 0;
        ($this->input->post('dropMenu')) ? $dropMenu = $this->input->post('dropMenu', TRUE) : $dropMenu = 0;
        $this->db->set('menu_name', $this->input->post("name", TRUE), TRUE);
        $this->db->set('lang_iso', $this->input->post("lang_iso", TRUE), TRUE);
        $this->db->set('pages_id', $this->input->post('pageUrl', TRUE), TRUE);
        $this->db->set('other_link', $this->input->post('url_link', TRUE), TRUE);
        $this->db->set('drop_menu', $dropdown, TRUE);
        $this->db->set('drop_page_menu_id', $dropMenu, TRUE);
        $this->db->set('active', $active, TRUE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->where('page_menu_id', $id);
        $this->db->update('page_menu');
    }

    public function findLangDataUpdate($lang_iso) {
        /* When delete Lang, wiil update all page of lang to default */
        $query = $this->db->get_where($table = 'pages', 'lang_iso = \'' . $lang_iso . '\'');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $this->db->set('lang_iso', $this->Csz_model->getDefualtLang(), TRUE);
                $this->db->set('timestamp_update', 'NOW()', FALSE);
                $this->db->where("pages_id", $rows->pages_id);
                $this->db->update('pages');
            }
        }
        $query = $this->db->get_where($table = 'page_menu', 'lang_iso = \'' . $lang_iso . '\'');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $this->db->set('lang_iso', $this->Csz_model->getDefualtLang(), TRUE);
                $this->db->set('timestamp_update', 'NOW()', FALSE);
                $this->db->where("page_menu_id", $rows->page_menu_id);
                $this->db->update('page_menu');
            }
        }
        $this->load->dbforge();
        $this->dbforge->drop_column('general_label', 'lang_'.$lang_iso);
    }

    public function insertLang() {
        // Create the new lang
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        $data = array(
            'lang_name' => $this->input->post('lang_name', TRUE),
            'lang_iso' => $this->input->post('lang_iso', TRUE),
            'country' => $this->input->post('country', TRUE),
            'country_iso' => $this->input->post('country_iso', TRUE),
            'active' => $active,
        );
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->insert('lang_iso', $data);
        if(!$this->db->field_exists('lang_'.$this->input->post("lang_iso", TRUE), 'general_label')){
            $this->load->dbforge();
            $fields = array('lang_'.$this->input->post('lang_iso', TRUE) => array('type' => 'TEXT', 'null' => FALSE));
            $this->dbforge->add_column('general_label', $fields);
        }
    }

    public function updateLang($id) {
        // Update the lang
        $old_lang = $this->Csz_model->getValue('lang_iso', 'lang_iso', 'lang_iso_id', $id, 1);
        if(!$this->db->field_exists('lang_'.$this->input->post("lang_iso", TRUE), 'general_label') && $old_lang->lang_iso != $this->input->post("lang_iso", TRUE)){
            $this->load->dbforge();
            $fields = array(
                'lang_'.$old_lang->lang_iso => array(
                        'name' => 'lang_'.$this->input->post("lang_iso", TRUE),
                        'type' => 'TEXT',
                ),
            );
            $this->dbforge->modify_column('general_label', $fields);
        }       
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        $this->db->set('lang_name', $this->input->post("lang_name", TRUE), TRUE);
        $this->db->set('lang_iso', $this->input->post("lang_iso", TRUE), TRUE);
        $this->db->set('country', $this->input->post('country', TRUE), TRUE);
        $this->db->set('country_iso', $this->input->post('country_iso', TRUE), TRUE);
        if ($id != 1) {
            $this->db->set('active', $active, FALSE);
        }
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->where('lang_iso_id', $id);
        $this->db->update('lang_iso');
    }
    
    public function syncLabelLang() {
        /* For synchronize with language */
        $lang = $this->Csz_model->getValueArray('lang_iso', 'lang_iso', "lang_iso != ''", '');
        foreach ($lang as $value) {
            if(!$this->db->field_exists('lang_'.$value['lang_iso'], 'general_label') && $value['lang_iso']){
                $this->load->dbforge();
                $fields = array('lang_'.$value['lang_iso'] => array('type' => 'TEXT', 'null' => FALSE));
                $this->dbforge->add_column('general_label', $fields);
            }
        }
    }
    
    public function updateLabel($id) {
        $lang = $this->Csz_model->getValueArray('lang_iso', 'lang_iso', "lang_iso != ''", '');
        foreach ($lang as $value) {
            $this->db->set('lang_'.$value['lang_iso'], $this->input->post("lang_".$value['lang_iso'], TRUE), TRUE);
        }
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->where('general_label_id', $id);
        $this->db->update('general_label');
    }

    public function insertPage() {
        // Create the new page
        $page_name_input = $this->input->post('page_name', TRUE);
        if ($page_name_input == 'assets' || $page_name_input == 'cszcms' ||
                $page_name_input == 'install' || $page_name_input == 'photo' ||
                $page_name_input == 'system' || $page_name_input == 'templates' ||
                $page_name_input == 'admin' || $page_name_input == 'ci_session' || $page_name_input == 'member') {
            $page_name_input = 'pages_' . $this->input->post('page_name', TRUE);
        }
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        $page_url = $this->Csz_model->rw_link($page_name_input);
        $content2 = $this->input->post('content', FALSE);
        $content1 = str_replace('&lt;', '<', $content2);
        $content = str_replace('&gt;', '>', $content1);
        $data = array(
            'page_name' => $page_name_input,
            'page_url' => $page_url,
            'lang_iso' => $this->input->post('lang_iso', TRUE),
            'page_title' => $this->input->post('page_title', TRUE),
            'page_keywords' => $this->input->post('page_keywords', TRUE),
            'page_desc' => $this->input->post('page_desc', TRUE),
            'content' => $content,
            'active' => $active,
        );
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->insert('pages', $data);
    }

    public function updatePage($id) {
        // Update the page
        $page_name_input = $this->input->post('page_name', TRUE);
       if ($page_name_input == 'assets' || $page_name_input == 'cszcms' ||
                $page_name_input == 'install' || $page_name_input == 'photo' ||
                $page_name_input == 'system' || $page_name_input == 'templates' ||
                $page_name_input == 'admin' || $page_name_input == 'ci_session' || $page_name_input == 'member') {
            $page_name_input = 'pages_' . $this->input->post('page_name', TRUE);
        }
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        $page_url = $this->Csz_model->rw_link($page_name_input);
        $content2 = $this->input->post('content', FALSE);
        $content1 = str_replace('&lt;', '<', $content2);
        $content = str_replace('&gt;', '>', $content1);
        $this->db->set('page_name', $page_name_input, TRUE);
        $this->db->set('page_url', $page_url, TRUE);
        $this->db->set('lang_iso', $this->input->post('lang_iso', TRUE), TRUE);
        $this->db->set('page_title', $this->input->post('page_title', TRUE), TRUE);
        $this->db->set('page_keywords', $this->input->post('page_keywords', TRUE), TRUE);
        $this->db->set('page_desc', $this->input->post('page_desc', TRUE), TRUE);
        $this->db->set('content', $content, TRUE);
        if ($id != 1) {
            $this->db->set('active', $active, FALSE);
        }
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->where('pages_id', $id);
        $this->db->update('pages');
        $this->Csz_model->clear_uri_cache($this->config->item('base_url').$page_url);
    }

    public function insertFileUpload($year, $fileupload) {
        $data = array(
            'year' => $year,
            'file_upload' => $fileupload,
        );
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->insert('upload_file', $data);
    }

    public function insertForms() {
        $this->load->dbforge();
        // Create the new forms
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        ($this->input->post('sendmail')) ? $sendmail = $this->input->post('sendmail', TRUE) : $sendmail = 0;
        ($this->input->post('captcha')) ? $captcha = $this->input->post('captcha', TRUE) : $captcha = 0;
        $str_arr = array(' ', '-');
        $form_name = str_replace($str_arr, '_', strtolower($this->input->post('form_name', TRUE)));
        $data = array(
            'form_name' => $form_name,
            'form_enctype' => $this->input->post('form_enctype', TRUE),
            'form_method' => $this->input->post('form_method', TRUE),
            'success_txt' => $this->input->post('success_txt', TRUE),
            'captchaerror_txt' => $this->input->post('captchaerror_txt', TRUE),
            'error_txt' => $this->input->post('error_txt', TRUE),
            'sendmail' => $sendmail,
            'email' => $this->input->post('email', TRUE),
            'subject' => $this->input->post('subject', TRUE),
            'active' => $active,
            'captcha' => $captcha,
        );
        $this->db->set('timestamp_create', 'NOW()', FALSE);
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->insert('form_main', $data);
        $form_main_id = $this->db->insert_id();

        $field_name = $this->input->post('field_name', TRUE);
        $field_type = $this->input->post('field_type', TRUE);
        $field_id = $this->input->post('field_id', TRUE);
        $field_class = $this->input->post('field_class', TRUE);
        $field_placeholder = $this->input->post('field_placeholder', TRUE);
        $field_value = $this->input->post('field_value', TRUE);
        $field_label = $this->input->post('field_label', TRUE);
        $sel_option_val = $this->input->post('sel_option_val', TRUE);
        $field_required = $this->input->post('field_required', TRUE);
        $fields = array(
            'form_' . $form_name . '_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
        );
        $this->dbforge->add_field($fields);
        if (count($field_name) > 0) {
            for ($i = 0; $i < count($field_name); $i++) {
                if ($field_name[$i]) {
                    $data = array(
                        'form_main_id' => $form_main_id,
                        'field_type' => $field_type[$i],
                        'field_name' => $field_name[$i],
                        'field_id' => $field_id[$i],
                        'field_class' => $field_class[$i],
                        'field_placeholder' => $field_placeholder[$i],
                        'field_value' => $field_value[$i],
                        'field_label' => $field_label[$i],
                        'sel_option_val' => $sel_option_val[$i],
                        'field_required' => $field_required[$i],
                    );
                    $this->db->set('timestamp_create', 'NOW()', FALSE);
                    $this->db->set('timestamp_update', 'NOW()', FALSE);
                    $this->db->insert('form_field', $data);
                    $fields = $this->preTypeFields($field_type[$i], $field_name[$i]);
                    $this->dbforge->add_field($fields);
                }
            }
        }
        $fields = array(
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '255'
            ),
            'timestamp_create' => array(
                'type' => 'datetime'
            ),
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('form_' . $form_name . '_id', TRUE);
        $attributes = array('ENGINE' => 'MyISAM', 'CHARACTER SET' => 'utf8', 'COLLATE' => 'utf8_general_ci', ' AUTO_INCREMENT' => '1');
        $this->dbforge->create_table('form_' . $form_name, TRUE, $attributes);
    }

    public function updateForms($id) {
        $this->load->dbforge();
        ($this->input->post('active')) ? $active = $this->input->post('active', TRUE) : $active = 0;
        ($this->input->post('sendmail')) ? $sendmail = $this->input->post('sendmail', TRUE) : $sendmail = 0;
        ($this->input->post('captcha')) ? $captcha = $this->input->post('captcha', TRUE) : $captcha = 0;
        $str_arr = array(' ', '-');
        $form_name = str_replace($str_arr, '_', strtolower($this->input->post('form_name', TRUE)));
        $data = array(
            'form_name' => $form_name,
            'form_enctype' => $this->input->post('form_enctype', TRUE),
            'form_method' => $this->input->post('form_method', TRUE),
            'success_txt' => $this->input->post('success_txt', TRUE),
            'captchaerror_txt' => $this->input->post('captchaerror_txt', TRUE),
            'error_txt' => $this->input->post('error_txt', TRUE),
            'sendmail' => $sendmail,
            'email' => $this->input->post('email', TRUE),
            'subject' => $this->input->post('subject', TRUE),
            'active' => $active,
            'captcha' => $captcha,
        );
        $this->db->set('timestamp_update', 'NOW()', FALSE);
        $this->db->where('form_main_id', $id);
        $this->db->update('form_main', $data);
        /* Rename Field */
        $form_field_id = $this->input->post('form_field_id', TRUE);
        $field_name1 = $this->input->post('field_name1', TRUE);
        $field_oldname = $this->input->post('field_oldname', TRUE);
        $field_type1 = $this->input->post('field_type1', TRUE);
        $field_id1 = $this->input->post('field_id1', TRUE);
        $field_class1 = $this->input->post('field_class1', TRUE);
        $field_placeholder1 = $this->input->post('field_placeholder1', TRUE);
        $field_value1 = $this->input->post('field_value1', TRUE);
        $field_label1 = $this->input->post('field_label1', TRUE);
        $sel_option_val1 = $this->input->post('sel_option_val1', TRUE);
        $field_required1 = $this->input->post('field_required1', TRUE);
        if (count($field_oldname) > 0) {
            for ($i = 0; $i < count($field_oldname); $i++) {
                if ($field_oldname[$i]) {
                    $data = array(
                        'form_main_id' => $id,
                        'field_type' => $field_type1[$i],
                        'field_name' => $field_name1[$i],
                        'field_id' => $field_id1[$i],
                        'field_class' => $field_class1[$i],
                        'field_placeholder' => $field_placeholder1[$i],
                        'field_value' => $field_value1[$i],
                        'field_label' => $field_label1[$i],
                        'sel_option_val' => $sel_option_val1[$i],
                        'field_required' => $field_required1[$i],
                    );
                    $this->db->set('timestamp_update', 'NOW()', FALSE);
                    $this->db->where('form_field_id', $form_field_id[$i]);
                    $this->db->update('form_field', $data);
                    if ($field_oldname[$i] != $field_name1[$i]) {
                        $fields = $this->renameFields($field_type1[$i], $field_oldname[$i], $field_name1[$i]);
                        $this->dbforge->modify_column('form_' . $form_name, $fields);
                    }
                }
            }
        }

        /* Add New Field */
        $field_name = $this->input->post('field_name', TRUE);
        $field_type = $this->input->post('field_type', TRUE);
        $field_id = $this->input->post('field_id', TRUE);
        $field_class = $this->input->post('field_class', TRUE);
        $field_placeholder = $this->input->post('field_placeholder', TRUE);
        $field_value = $this->input->post('field_value', TRUE);
        $field_label = $this->input->post('field_label', TRUE);
        $sel_option_val = $this->input->post('sel_option_val', TRUE);
        $field_required = $this->input->post('field_required', TRUE);
        if (count($field_name) > 0) {
            for ($i = 0; $i < count($field_name); $i++) {
                if ($field_name[$i]) {
                    $data = array(
                        'form_main_id' => $id,
                        'field_type' => $field_type[$i],
                        'field_name' => $field_name[$i],
                        'field_id' => $field_id[$i],
                        'field_class' => $field_class[$i],
                        'field_placeholder' => $field_placeholder[$i],
                        'field_value' => $field_value[$i],
                        'field_label' => $field_label[$i],
                        'sel_option_val' => $sel_option_val[$i],
                        'field_required' => $field_required[$i],
                    );
                    $this->db->set('timestamp_create', 'NOW()', FALSE);
                    $this->db->set('timestamp_update', 'NOW()', FALSE);
                    $this->db->insert('form_field', $data);
                    $fields = $this->preTypeFields($field_type[$i], $field_name[$i]);
                    $this->dbforge->add_column('form_' . $form_name, $fields);
                }
            }
        }
        $this->Csz_model->clear_all_cache();
    }

    public function preTypeFields($type, $name) {
        $fields = array();
        switch ($type) {
            case 'checkbox':
                $fields = array(
                    $name => array(
                        'type' => 'INT',
                        'constraint' => 11
                    ),
                );
                break;
            case 'email':
            case 'password':
            case 'radio':
            case 'selectbox':
            case 'text':
                $fields = array(
                    $name => array(
                        'type' => 'VARCHAR',
                        'constraint' => '255',
                    ),
                );
                break;
            case 'textarea':
                $fields = array(
                    $name => array(
                        'type' => 'TEXT',
                    ),
                );
                break;
            default:
                break;
        }
        return $fields;
    }

    public function renameFields($type, $oldname, $newname) {
        $fields = array();
        switch ($type) {
            case 'checkbox':
                $fields = array(
                    $oldname => array(
                        'name' => $newname,
                        'type' => 'INT',
                        'constraint' => 11
                    ),
                );
                break;
            case 'email':
            case 'password':
            case 'radio':
            case 'selectbox':
            case 'text':
                $fields = array(
                    $oldname => array(
                        'name' => $newname,
                        'type' => 'VARCHAR',
                        'constraint' => '255',
                    ),
                );
                break;
            case 'textarea':
                $fields = array(
                    $oldname => array(
                        'name' => $newname,
                        'type' => 'TEXT',
                    ),
                );
                break;
            default:
                break;
        }
        return $fields;
    }

    public function execSqlFile($sql_file) {
        if (file_exists($sql_file)) {
            $this->load->helper('file');
            $backup = read_file($sql_file);
            $backup = str_replace('\n', '', $backup);
            $sql_r = explode(";", $backup);
            for($i=0;$i < count($sql_r);$i++){
                if ($sql_r[$i]) {
                    $sql = trim($sql_r[$i]);
                    $this->db->query($sql);
                }
            }
        }else{
            return FALSE;
        }
    }

}
