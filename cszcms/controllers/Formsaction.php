<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Formsaction extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
    }

    public function index() {
        $form_id = $this->uri->segment(2);
        if ($form_id) {
            //Get form data
            $frm_rs = $this->Csz_model->getValue('*', 'form_main', 'form_main_id', $form_id, 1);
            if ($frm_rs->active) {
                if($frm_rs->form_method == 'post'){
                    $cur_page = $this->input->post('cur_page', TRUE);
                }elseif($frm_rs->form_method == 'get'){
                    $cur_page = $this->input->get('cur_page', TRUE);
                }
                $field_rs = $this->Csz_model->getValue('*', 'form_field', 'form_main_id', $form_id);
                if ($frm_rs->captcha) {
                    if ($this->Csz_model->chkCaptchaRes() == '') {
                        //Return to last page: Captcha invalid
                        redirect(urlencode($cur_page) . '/2', 'refresh');
                        exit;
                    }
                }
                $data = array();
                foreach ($field_rs as $f_val) {
                    if($frm_rs->form_method == 'post'){
                            if($f_val->field_required && !$this->input->post($f_val->field_name, TRUE)){
                                //Return to last page: Error
                               redirect(urlencode($cur_page) . '/3', 'refresh'); 
                               exit;
                            }
                    }elseif($frm_rs->form_method == 'get'){
                            if($f_val->field_required && !$this->input->get($f_val->field_name, TRUE)){
                                //Return to last page: Error
                               redirect(urlencode($cur_page) . '/3', 'refresh'); 
                               exit;
                            }
                    }
                    if ($f_val->field_type != 'button' && $f_val->field_type != 'reset' && $f_val->field_type != 'submit') {      
                        if($frm_rs->form_method == 'post'){
                            $data[$f_val->field_name] = $this->input->post($f_val->field_name, TRUE);
                        }elseif($frm_rs->form_method == 'get'){
                            $data[$f_val->field_name] = $this->input->get($f_val->field_name, TRUE);
                        }
                    }                    
                }
                $this->db->set('ip_address', $this->input->ip_address(), TRUE);
                $this->db->set('timestamp_create', 'NOW()', FALSE);
                $this->db->insert('form_' . $frm_rs->form_name, $data);
                $email_from = 'no-reply@' . EMAIL_DOMAIN;
                $this->sendMail($frm_rs->sendmail, $frm_rs->email, $email_from, $frm_rs->subject, $field_rs, $frm_rs->form_method);
                //Return to last page: Success
                redirect(urlencode($cur_page) . '/1', 'refresh');
                exit;
            } else {
                //Return to home page
                redirect('./', 'refresh');
                exit;
            }
        } else {
            //Return to home page
            redirect('./', 'refresh');
            exit;
        }
    }

    private function sendMail($active = '', $email_to = '', $email_from = '', $subject = '', $field_val = '', $form_method) {
        if ($active) {
            $webconfig = $this->Csz_admin_model->load_config();
            # ---- set from, to, bcc --#
            $from_name = $webconfig->site_name;
            $from_email = $email_from;
            if($email_to){
                $to_email = $email_to;
            }else{
                $to_email = $webconfig->default_email;
            }            
            $message_html = 'Dear ' . $to_email . ',<br><br>';
            $message_html.= 'Please see below detail<br><br>';
            if ($field_val) {
                foreach ($field_val as $val) {
                    if ($val->field_type != 'button' && $val->field_type != 'reset' && $val->field_type != 'submit') {
                        ($val->field_label)?$field_label = $val->field_label:$field_label = $val->field_name;
                        if($val->field_type == 'textarea'){
                            if($form_method == 'post'){
                                $message_html.= '<b>' . $field_label . ':</b><br>' . $this->input->post($val->field_name, TRUE) . '<br><br>';
                            }elseif($form_method == 'get'){
                                $message_html.= '<b>' . $field_label . ':</b><br>' . $this->input->get($val->field_name, TRUE) . '<br><br>';
                            }
                        }else{
                            if($form_method == 'post'){
                                $message_html.= '<b>' . $field_label . ':</b> ' . $this->input->post($val->field_name, TRUE) . '<br>';
                            }elseif($form_method == 'get'){
                                $message_html.= '<b>' . $field_label . ':</b> ' . $this->input->get($val->field_name, TRUE) . '<br>';
                            }                           
                        } 
                    }
                }
            }
            $message_html.= '<br><br>Regards,<br>' . $webconfig->site_name;           
            @$this->Csz_model->sendEmail($to_email, $subject, $message_html, $from_email, $from_name);
        } else {
            return FALSE;
        }
    }

}
