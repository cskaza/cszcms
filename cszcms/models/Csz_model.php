<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Csz_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model('Csz_admin_model');
        $this->load->helper('url');
    }
    
    function countData($table,$where_field = '', $where_val = '') {
        if($where_field){
            $this->db->where($where_field, $where_val);
        }
        return $this->db->count_all($table);
    }

    public function getCurPages() {
        $totSegments = $this->uri->total_segments();
	if(!is_numeric($this->uri->segment($totSegments))){
            $pageURL = $this->uri->segment($totSegments);
	} else if(is_numeric($this->uri->segment($totSegments))){
            $pageURL = $this->uri->segment($totSegments-1);
	}
	if ($pageURL == ""){ $pageURL = $this->getDefualtPage($this->session->userdata('fronlang_iso')); }
        return $pageURL;
    }

    public function getValue($sel_field = '*', $table, $where_field, $where_val, $limit = '',  $orderby = '', $sort = ''){
        $this->db->select($sel_field);
        if(is_array($where_field) && is_array($where_val)){
            for ($i = 0; $i < count($where_field); $i++) {
                $this->db->where($where_field[$i], $where_val[$i]);
            }
        }else{
            $this->db->where($where_field, $where_val);
        } 
        if($orderby && $sort){ $this->db->order_by($orderby, $sort); }
        if($limit){ $this->db->limit($limit, 0); }
        $query = $this->db->get($table);
        if($query->num_rows() > 0){
            if($query->num_rows() == 1){
                $row = $query->row();
            }else if($query->num_rows() > 1){
                $row = $query->result();
            }
            return $row;
        }else{
            return FALSE;
        }
    }

    public function load_config(){
	$this->db->limit(1, 0);
        $query = $this->db->get('settings');
        if($query->num_rows() > 0){
            $row = $query->row();
            return $row;
        }else{
            return FALSE;
        }
    }
    
    function getLang() {
        $this->db->limit(1, 0);
        $query = $this->db->get('settings');
        if($query->num_rows() > 0){
            $row = $query->row();
            return $row->admin_lang;
        }
    }
    
    public function getCountryCode($lang) {
        $this->db->limit(1, 0);
        $this->db->where("lang_iso", $lang);
        $query = $this->db->get('lang_iso');
        if($query->num_rows() > 0){
            $row = $query->row();
            return $row->country_iso;
        }
    }
    
    public function getPageUrlFromID($id) {
        $this->db->limit(1, 0);
        $this->db->where("pages_id", $id);
        $query = $this->db->get('pages');
        if($query->num_rows() > 0){
            $row = $query->row();
            return $row->page_url;
        }
    }
    
    public function getDefualtPage($lang){
        $this->db->where("lang_iso", $lang);
        $this->db->limit(1, 0);
        $this->db->order_by('pages_id ASC');
        $query = $this->db->get('pages');
        if($query->num_rows() > 0){
            $row = $query->row();
            return $row->page_url;
        }
    }
    
    public function getDefualtLang(){
        $this->db->limit(1, 0);
        $this->db->where("lang_iso_id", 1);
        $query = $this->db->get('lang_iso');
        if($query->num_rows() > 0){
            $row = $query->row();
            return $row->lang_iso;
        }
    }

    public function chkLangAlive($lang_iso) {
        $this->db->where("lang_iso", $lang_iso);
        $this->db->where("active", 1);
        $query = $this->db->get('lang_iso');
        return $query->num_rows();            
    }

    public function setSiteLang($lang_iso = ''){       
        if(!$lang_iso){
            $set_lang_iso = $this->getDefualtLang();
        }else{
            if($this->chkLangAlive($lang_iso) > 0){
                $set_lang_iso = $lang_iso;
            }else{
                $set_lang_iso = $this->getDefualtLang();
            }
        }
        $this->session->set_userdata('fronlang_iso', $set_lang_iso);
    }
    
    public function loadAllLang($active = 0){
        $this->db->select("*");
        if($active) $this->db->where("active", 1);
        $this->db->order_by("lang_iso_id", "asc");
        $query = $this->db->get('lang_iso');
        if($query->num_rows() > 0){
            $row = $query->result();
            return $row;
        }else{
            return FALSE;
        }
    }

        public function load_page($pageurl, $lang){
        $this->db->where("page_url", $pageurl);
        $this->db->where("lang_iso", $lang);
        $this->db->where("active", 1);
	$this->db->limit(1, 0);
        $query = $this->db->get('pages');
        if($query->num_rows() > 0){
            $row = $query->row();
            return $row;
        }else{
            return FALSE;
        }       
    }
    
    public function main_menu($drop_page_menu_id = 0, $lang){
        if($drop_page_menu_id){
            $this->db->where("drop_page_menu_id", $drop_page_menu_id);
        }else{
            $this->db->where("drop_page_menu_id", 0);
        }
        $this->db->where("lang_iso", $lang);
        $this->db->where("active", 1);
        $this->db->order_by("arrange", "asc");
        $query = $this->db->get('page_menu');
        if($query->num_rows() > 0){
            $row = $query->result();
            return $row;
        }else{
            return FALSE;
        }
    }
    
    public function getSocial() {
        $this->db->select("*");
        $this->db->where("active", 1);
        $this->db->order_by("social_name", "asc");
        $query = $this->db->get('footer_social');
        if($query->num_rows() > 0){
            $row = $query->result();
            return $row;
        }else{
            return FALSE;
        }
    }
    
    public function cszCopyright(){
        $csz_copyright = $this->Csz_admin_model->cszCopyright();
        return $csz_copyright;
    }

    public function coreCss(){
        $core_css = link_tag('assets/css/bootstrap.min.css');
        $core_css.= link_tag('assets/font-awesome/css/font-awesome.min.css');
        $core_css.= link_tag('assets/css/flag-icon.min.css');
        return $core_css;
    }
    
    public function coreJs(){
        $core_js = '<script src="' . base_url() . 'assets/js/jquery-1.10.2.min.js"></script>';
        $core_js.= '<script src="' . base_url() . 'assets/js/bootstrap.min.js"></script>';       
        $core_js.= '<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>';
        $core_js.= '<script src="' . base_url() . 'assets/js/validator.min.js"></script>';
        $core_js.= '<script src="' . base_url() . 'assets/js/scripts.js"></script>';
        return $core_js;
    }
    
    public function coreMetatags($desc_txt, $keywords){
        $meta = array(
                array('name' => 'robots', 'content' => 'no-cache'),
                array('name' => 'description', 'content' => $desc_txt),
                array('name' => 'keywords', 'content' => $keywords),
                array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1'),
                array('name' => 'author', 'content' => $this->load_config()->site_name),
                array('name' => 'designer', 'content' => 'Web-Design and Development by CSKAZA'),
                array('name' => 'X-UA-Compatible', 'content' => 'IE=edge', 'type' => 'equiv'),
                array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
        );
        $return_meta = meta($meta);
        return $return_meta;
    }
    
    public function rw_link($val) {
        $val = strip_tags($val);
        $val = strtolower($val);
        $val = trim($val);
        $val = trim($val);
        $val = trim($val);
        $val = str_replace('&amp', 'and', $val);
        $val = str_replace('–', '-', $val);
        $val = str_replace(' ', '-', $val);
        $val = str_replace("'s-", '-', $val);
        $val = str_replace("’s-", '-', $val);
        $val = str_replace('!', '-', $val);
        $val = str_replace('@', '-', $val);
        $val = str_replace('#', '-', $val);
        $val = str_replace('$', '-', $val);
        $val = str_replace('%', '-', $val);
        $val = str_replace('^', '-', $val);
        $val = str_replace('&', '-', $val);
        $val = str_replace('*', '-', $val);
        $val = str_replace('(', '-', $val);
        $val = str_replace(')', '-', $val);
        $val = str_replace('_', '-', $val);
        $val = str_replace('+', '-', $val);
        $val = str_replace('|', '-', $val);
        $val = str_replace('{', '-', $val);
        $val = str_replace('}', '-', $val);
        $val = str_replace(':', '-', $val);
        $val = str_replace('"', '', $val);
        $val = str_replace('‘', '', $val);
        $val = str_replace('’', '', $val);
        $val = str_replace('<', '-', $val);
        $val = str_replace('>', '-', $val);
        $val = str_replace('?', '-', $val);
        $val = str_replace('/', '-', $val);
        $val = str_replace('.', '-', $val);
        $val = str_replace(',', '-', $val);
        $val = str_replace("'", '', $val);
        $val = str_replace(';', '-', $val);
        $val = str_replace(']', '-', $val);
        $val = str_replace('[', '-', $val);
        $val = str_replace('=', '-', $val);
        $val = str_replace('----', '-', $val);
        $val = str_replace('---', '-', $val);
        $val = str_replace('--', '-', $val);
        $val = str_replace('--', '-', $val);
        return $val;
    }
    
    public function customFindArr($keyword, $arrayToSearch){
        foreach($arrayToSearch as $key => $arrayItem){
            if( stristr( $arrayItem, $keyword ) ){
                return $key;
            }
        }
    }
    
    public function frmNameInHtml($content) {
        $txt_nonhtml = strip_tags($content);
        if (strpos($txt_nonhtml, '[?]{=forms:') !== false){
            $txt_nonline = str_replace(PHP_EOL, '', $txt_nonhtml);
            $array = explode("[?]", $txt_nonline);
            $searchword = '{=forms:';
            $key = $this->customFindArr($searchword, $array);   
            $rep_arr = array('{=forms:','}');
            $form_name = str_replace($rep_arr, '', $array[$key]);
            return $form_name;
        }else{
            return FALSE;
        }
    }
    
    public function addFrmToHtml($content, $frm_name, $cur_page = '', $status = '') {
        $where_arr = array('form_name','active');
        $val_arr = array($frm_name,1);
        $form_data = $this->getValue('*', 'form_main', $where_arr, $val_arr, 1);
        if($form_data){
            $html_btn = '';
            if($status == 1){
                $sts_msg = '<p class="text-center"><span class="success">Send Successfully!</span><br></p>';
            }else if($status == 2){
                $sts_msg = '<p class="text-center"><span class="error">The Security Check was not input correctly. Please try again.</span><br></p>';
            }else if($status == 3){
                $sts_msg = '<p class="text-center"><span class="error">Error! Please try again.</span><br></p>';
            }else{
                $sts_msg = '';
            }
            $html = $sts_msg;
            $html.= '<form action="'.BASE_URL.'/formsaction/'.$form_data->form_main_id.'" name="'.$frm_name.'" method="'.$form_data->form_method.'" id="validate-form" data-toggle="validator" role="form" enctype="'.$form_data->form_enctype.'" accept-charset="utf-8">';
            $html.= '<input type="hidden" name="cur_page" id="cur_page" value="'.$cur_page.'">';
            $field_data = $this->getValue('*', 'form_field', 'form_main_id', $form_data->form_main_id, '', 'form_field_id', 'asc');
            foreach ($field_data as $field) {
                if($field->field_required){ 
                    $f_req = ' required="required" autofocus="true"';
                    $star_req = ' <i style="color:red;">*</i>';
                }else{
                    $f_req = '';
                    $star_req = '';
                }
                if($field->field_type == 'checkbox' || $field->field_type == 'email' || $field->field_type == 'password' || $field->field_type == 'radio' || $field->field_type == 'text'){
                    $html.= '<label class="control-label" for="'.$field->field_id.'">'.$field->field_label.$star_req.'</label>
                    <div class="controls">
                        <input type="'.$field->field_type.'" name="'.$field->field_name.'" value="'.$field->field_value.'" id="'.$field->field_id.'" class="'.$field->field_class.'" placeholder="'.$field->field_placeholder.'"'.$f_req.'/>
                    </div>';
                }else if($field->field_type == 'selectbox'){
                    $opt_html = '';
                    if($field->sel_option_val){                        
                        $opt_arr = explode(",", $field->sel_option_val);
                        foreach ($opt_arr as $opt) {
                            list($val, $show) = explode("=>", $opt);
                            $opt_html.= '<option value="'.trim($val).'">'.trim($show).'</option>';
                        }
                    }
                    ($field->field_placeholder) ? $placehol = '<option value="">'.$field->field_placeholder.'</option>' : $placehol = '';
                    $html.= '<label class="control-label" for="'.$field->field_id.'">'.$field->field_label.$star_req.'</label>
                            <select id="'.$field->field_id.'" name="'.$field->field_name.'" class="'.$field->field_class.'"'.$f_req.'>
                                '.$placehol.'
                                '.$opt_html.'
                            </select>';
                }else if($field->field_type == 'textarea'){
                    $html.= '<label class="control-label" for="'.$field->field_id.'">'.$field->field_label.$star_req.'</label>
                    <div class="controls">
                        <textarea name="'.$field->field_name.'" id="'.$field->field_id.'" class="'.$field->field_class.'" placeholder="'.$field->field_placeholder.'"'.$f_req.' rows="4">'.$field->field_value.'</textarea>
                    </div>';
                }else if($field->field_type == 'button' || $field->field_type == 'reset' || $field->field_type == 'submit'){                   
                    $html_btn.= '<input type="'.$field->field_type.'" name="'.$field->field_name.'" value="'.$field->field_value.'" id="'.$field->field_id.'" class="'.$field->field_class.'" placeholder="'.$field->field_placeholder.'"'.$f_req.'/> ';
                }              
            }
            if($form_data->captcha){
                $html.= '<br><img src="'.BASE_URL.'/viewcaptcha?'.mt_rand(1000000000, 9999999999).'+'.time().'" alt="CAPTCHA IMG" />';
                $html.= '<div class="controls">
                    <input type="text" name="captcha" id="captcha" class="form-control" required="required" autofocus="true" maxlength="6" placeholder="Security Check"/>
                </div>';
            }
            $html.= '<br><div class="form-actions">'.$html_btn.'</div>';
            $html.= '</form>';
            $new_content = str_replace('[?]{=forms:'.$frm_name.'}[?]', $html, $content);
            return $new_content;
        }else{
            return $content;
        }
    }
}
