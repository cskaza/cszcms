<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CSZ CMS
 *
 * An open source content management system
 *
 * Copyright (c) 2016, Astian Foundation.
 *
 * Astian Develop Public License (ADPL)
 * 
 * This Source Code Form is subject to the terms of the Astian Develop Public
 * License, v. 1.0. If a copy of the APL was not distributed with this
 * file, You can obtain one at http://astian.org/about-ADPL
 * 
 * @author	CSKAZA
 * @copyright   Copyright (c) 2016, Astian Foundation.
 * @license	http://astian.org/about-ADPL	ADPL License
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 */
class Formsaction extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
        if($this->Csz_model->load_config()->maintenance_active){
            //Return to home page
            redirect('./', 'refresh');
            exit;
        }
    }

    public function index() {
        $form_id = $this->uri->segment(2);
        if ($form_id) {
            //Get form data
            $frm_rs = $this->Csz_model->getValue('*', 'form_main', 'form_main_id', $form_id, 1);
            if ($frm_rs !== FALSE && $frm_rs->active) {
                $cur_page = $this->session->userdata('cszfrm_cururl');
                $field_rs = $this->Csz_model->getValue('*', 'form_field', 'form_main_id', $form_id);
                if ($frm_rs->captcha) {
                    if ($this->Csz_model->chkCaptchaRes() == '') {
                        //Return to last page: Captcha invalid
                        redirect($cur_page . '/2', 'refresh');
                        exit;
                    }
                }
                $data = array();
                foreach ($field_rs as $f_val) {
                    if($frm_rs->form_method == 'post'){
                            if($f_val->field_required && !$this->input->post($f_val->field_name, TRUE) && $f_val->field_type != 'button' && $f_val->field_type != 'reset' && $f_val->field_type != 'submit' && $f_val->field_type != 'label'){
                                //Return to last page: Error
                               redirect($cur_page . '/3', 'refresh'); 
                               exit;
                            }
                    }elseif($frm_rs->form_method == 'get'){
                            if($f_val->field_required && !$this->input->get($f_val->field_name, TRUE) && $f_val->field_type != 'button' && $f_val->field_type != 'reset' && $f_val->field_type != 'submit' && $f_val->field_type != 'label'){
                                //Return to last page: Error
                               redirect($cur_page . '/3', 'refresh'); 
                               exit;
                            }
                    }
                    if ($f_val->field_type != 'button' && $f_val->field_type != 'reset' && $f_val->field_type != 'submit' && $f_val->field_type != 'label') {      
                        if($frm_rs->form_method == 'post'){
                            if($f_val->field_type == 'email'){
                                $data[$f_val->field_name] = $this->Csz_model->cleanEmailFormat($this->input->post($f_val->field_name, TRUE));
                            }else{
                                $data[$f_val->field_name] = $this->input->post($f_val->field_name, TRUE);
                            }
                        }elseif($frm_rs->form_method == 'get'){
                            if($f_val->field_type == 'email'){
                                $data[$f_val->field_name] = $this->Csz_model->cleanEmailFormat($this->input->get($f_val->field_name, TRUE));
                            }else{
                                $data[$f_val->field_name] = $this->input->get($f_val->field_name, TRUE);
                            }
                        }
                    }                    
                }
                $this->db->set('ip_address', $this->input->ip_address(), TRUE);
                $this->db->set('timestamp_create', 'NOW()', FALSE);
                $this->db->insert('form_' . $frm_rs->form_name, $data);
                $email_from = 'no-reply@' . EMAIL_DOMAIN;
                $this->sendMail($frm_rs->sendmail, $frm_rs->email, $email_from, $frm_rs->subject, $field_rs, $frm_rs->form_method);
                
                if($frm_rs->send_to_visitor && $frm_rs->email_field_id){
                    $visit_field = $this->Csz_model->getValue('field_name', 'form_field', 'form_field_id', $frm_rs->email_field_id, 1);
                    if($visit_field->field_name && $frm_rs->visitor_subject){
                        if($frm_rs->form_method == 'post'){
                            $visit_email = $this->Csz_model->cleanEmailFormat($this->input->post($visit_field->field_name, TRUE));
                        }elseif($frm_rs->form_method == 'get'){
                            $visit_email = $this->Csz_model->cleanEmailFormat($this->input->get($visit_field->field_name, TRUE));
                        }
                        $webconfig = $this->Csz_admin_model->load_config();
                        @$this->Csz_model->sendEmail($visit_email, $frm_rs->visitor_subject, $frm_rs->visitor_body, $email_from, $webconfig->site_name);
                    }
                }
                //Return to last page: Success
                redirect($cur_page . '/1', 'refresh');
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
                $to_email = $this->Csz_model->cleanEmailFormat($email_to);
            }else{
                $to_email = $webconfig->default_email;
            }            
            $message_html = $this->Csz_model->getLabelLang('email_dear') . $to_email . ',<br><br>';
            if ($field_val) {
                foreach ($field_val as $val) {
                    if ($val->field_type != 'button' && $val->field_type != 'reset' && $val->field_type != 'submit' && $val->field_type != 'label') {
                        ($val->field_label)?$field_label = $val->field_label:$field_label = $val->field_name;
                        if($val->field_type == 'textarea'){
                            if($form_method == 'post'){
                                $message_html.= '<b>' . $field_label . ':</b><br>' . $this->input->post($val->field_name, TRUE) . '<br><br>';
                            }elseif($form_method == 'get'){
                                $message_html.= '<b>' . $field_label . ':</b><br>' . $this->input->get($val->field_name, TRUE) . '<br><br>';
                            }
                        }else{
                            if($form_method == 'post'){
                                if($val->field_type == 'email'){
                                    $message_html.= '<b>' . $field_label . ':</b> ' . $this->Csz_model->cleanEmailFormat($this->input->post($val->field_name, TRUE)) . '<br>';
                                }else{
                                    $message_html.= '<b>' . $field_label . ':</b> ' . $this->input->post($val->field_name, TRUE) . '<br>';
                                }
                            }elseif($form_method == 'get'){
                                if($val->field_type == 'email'){
                                    $message_html.= '<b>' . $field_label . ':</b> ' . $this->Csz_model->cleanEmailFormat($this->input->get($val->field_name, TRUE)) . '<br>';
                                }else{
                                    $message_html.= '<b>' . $field_label . ':</b> ' . $this->input->get($val->field_name, TRUE) . '<br>';
                                }
                            }                           
                        } 
                    }
                }
            }
            $message_html.= '<br><br>' . $this->Csz_model->getLabelLang('email_footer') . ' <br><a href="' . $this->Csz_model->base_link(). '" target="_blank"><b>' . $webconfig->site_name . '</b></a>';           
            @$this->Csz_model->sendEmail($to_email, $subject, $message_html, $from_email, $from_name);
        } else {
            return FALSE;
        }
    }

}
