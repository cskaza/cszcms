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
                $field_rs = $this->Csz_model->getValue('*', 'form_field', 'form_main_id', $form_id);
                if ($frm_rs->captcha) {
                    if ($this->Csz_model->chkCaptchaRes() == '') {
                        //Return to last page: Captcha invalid
                        redirect(urlencode($this->input->post('cur_page', TRUE)) . '/2', 'refresh');
                        exit;
                    }
                }
                $data = array();
                foreach ($field_rs as $f_val) {
                    if($f_val->field_required && !$this->input->post($f_val->field_name, TRUE)){
                         //Return to last page: Error
                        redirect(urlencode($this->input->post('cur_page', TRUE)) . '/3', 'refresh'); 
                        exit;
                    }
                    if ($f_val->field_type != 'button' && $f_val->field_type != 'reset' && $f_val->field_type != 'submit') {                        
                        $data[$f_val->field_name] = $this->input->post($f_val->field_name, TRUE);
                        if ($f_val->field_type == 'email') {
                            $email_from = $this->input->post($f_val->field_name, TRUE);
                        }
                    }                    
                }
                $this->db->set('ip_address', $this->input->ip_address(), TRUE);
                $this->db->set('timestamp_create', 'NOW()', FALSE);
                $this->db->insert('form_' . $frm_rs->form_name, $data);
                $this->sendMail($frm_rs->sendmail, $frm_rs->email, $email_from, $frm_rs->subject, $field_rs);
                //Return to last page: Success
                redirect(urlencode($this->input->post('cur_page', TRUE)) . '/1', 'refresh');
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

    private function sendMail($active = '', $email_to = '', $email_from = '', $subject = '', $field_val = '') {
        if ($active) {
            $webconfig = $this->Csz_admin_model->load_config();
            # ---- set from, to, bcc --#
            $from_name = $email_from;
            $from_email = $email_from;
            if($email_from){
                $to_email = $email_to;
            }else{
                $to_email = $webconfig->default_email;
            }
            # ---- set header --#
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers.= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers.= 'From: ' . $from_name . ' <' . $from_email . '>' . "\r\n";
            $message_html = 'Dear ' . $email_to . ',<br><br>';
            $message_html.= 'Please see below detail<br><br>';
            if ($field_val) {
                foreach ($field_val as $val) {
                    if ($val->field_type != 'button' && $val->field_type != 'reset' && $val->field_type != 'submit') {
                        ($val->field_label)?$field_label = $val->field_label:$field_label = $val->field_name;
                        if($val->field_type == 'textarea'){
                            $message_html.= '<b>' . $field_label . ':</b><br>' . $this->input->post($val->field_name, TRUE) . '<br><br>';
                        }else{
                            $message_html.= '<b>' . $field_label . ':</b> ' . $this->input->post($val->field_name, TRUE) . '<br>';
                        } 
                    }
                }
            }
            $message_html.= '<br><br>Regards,<br>' . $webconfig->site_name;
            # ---- send mail --#
            @mail($to_email, $subject, $message_html, $headers);
        } else {
            return FALSE;
        }
    }

}
