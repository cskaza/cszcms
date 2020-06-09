<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CSZ CMS
 *
 * An open source content management system
 *
 * Copyright (c) 2016 - 2017, Astian Foundation.
 *
 * Astian Develop Public License (ADPL)
 * 
 * This Source Code Form is subject to the terms of the Astian Develop Public
 * License, v. 1.0. If a copy of the APL was not distributed with this
 * file, You can obtain one at http://astian.org/about-ADPL
 * 
 * @author	CSKAZA
 * @copyright   Copyright (c) 2016 - 2017, Astian Foundation.
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
            redirect(base_url(), 'refresh');
        }
    }

    public function index() {
        $form_id = $this->uri->segment(2);
        if ($form_id) {
            $cur_page = $this->session->userdata('cszfrm_cururl');
            //Get form data
            $frm_rs = $this->Csz_model->getValue('*', 'form_main', 'form_main_id', $form_id, 1);
            if ($frm_rs !== FALSE && $frm_rs->active && ($frm_rs->sendmail || $frm_rs->save_to_db)) {
                $field_rs = $this->Csz_model->getValue('*', 'form_field', 'form_main_id', $form_id, '', array('arrange','form_field_id'), 'ASC');
                if ($frm_rs->captcha) {
                    if ($this->Csz_model->chkCaptchaRes() == '') {
                        //Return to last page: Captcha invalid
                        $this->session->set_flashdata('formtag_error_message','<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $frm_rs->captchaerror_txt . '</div>');
                        redirect($cur_page, 'refresh');
                        exit(1);
                    }
                }
                $data = array();
                $ext_accept = array();
                $file_sql = '';
                $field_filename = '';
                foreach ($field_rs as $f_val) {
                    if ($f_val->field_required && !$this->input->post_get($f_val->field_name, TRUE) && $f_val->field_type != 'button' && $f_val->field_type != 'reset' && $f_val->field_type != 'submit' && $f_val->field_type != 'label' && $f_val->field_type != 'file') {
                        //Return to last page: Error
                        $this->session->set_flashdata('formtag_error_message', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $frm_rs->error_txt . '</div>');
                        redirect($cur_page, 'refresh');
                    }
                    if ($f_val->field_type != 'button' && $f_val->field_type != 'reset' && $f_val->field_type != 'submit' && $f_val->field_type != 'label' && $f_val->field_type != 'file') {
                        if ($f_val->field_type == 'email') {
                            $data[$f_val->field_name] = $this->Csz_model->cleanEmailFormat($this->input->post_get($f_val->field_name, TRUE));
                        } else if ($f_val->field_type == 'textarea') {
                            $data[$f_val->field_name] = $this->Csz_model->cleanOSCommand(strip_tags($this->input->post_get($f_val->field_name, TRUE)));
                        } else {
                            $data[$f_val->field_name] = $this->input->post_get($f_val->field_name, TRUE);
                        }
                        if($f_val->sel_option_val){
                            $opt_arr = explode(",", str_replace(' ', '', $f_val->sel_option_val));
                            foreach ($opt_arr as $opt) {
                                list($maxlengthnum, $minlengthnum) = explode("=>", $opt);
                                if(is_numeric($maxlengthnum) && $maxlengthnum > 0){
                                    $data[$f_val->field_name] = substr($data[$f_val->field_name], 0, $maxlengthnum);
                                    break;
                                }
                            }
                        }
                    }else if($frm_rs->form_method == 'post' && $f_val->field_type == 'file'){
                        if ($f_val->field_required && !isset($_FILES[$f_val->field_name]) && (!$_FILES[$f_val->field_name]['tmp_name'] || !$_FILES[$f_val->field_name]['name'])) {
                            //Return to last page: Error
                            $this->session->set_flashdata('formtag_error_message', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $frm_rs->error_txt . ' (FIELD_REQUIRED)</div>');
                            redirect($cur_page, 'refresh');
                        } 
                        if (isset($_FILES[$f_val->field_name]) && $_FILES[$f_val->field_name]['tmp_name'] && $_FILES[$f_val->field_name]['name']) {
                            $ext = str_replace('.', '', strrchr($_FILES[$f_val->field_name]['name'], "."));
                            $file_name = (Date("dmy_His") . '.' . $ext);
                            if ($f_val->sel_option_val != NULL && $f_val->sel_option_val) {
                                $sel_opt = trim(str_replace('.', '', strtoupper($f_val->sel_option_val)));
                                $ext_accept = explode(',', str_replace(' ', '', $sel_opt));
                                if (is_array($ext_accept) && !empty($ext_accept) && !in_array(strtoupper($ext), $ext_accept)) {
                                    //Return to last page: Error
                                    $this->session->set_flashdata('formtag_error_message', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $frm_rs->error_txt . ' (FILE_NOT_SUPPORT)</div>');
                                    redirect($cur_page, 'refresh');
                                }
                                unset($ext, $ext_accept, $sel_opt);
                            }
                            $path = FCPATH . "/photo/forms/" . $this->Csz_model->cleanEmailFormat($frm_rs->form_name) . "/" . $this->Csz_model->cleanEmailFormat($f_val->field_name) . "/";
                            $paramiter = '_1';
                            $file_id = time() . "_" . rand(1111, 9999);
                            $file_f = $_FILES[$f_val->field_name]['tmp_name'];
                            $file_sql = $this->Csz_admin_model->file_upload($file_f, $file_name, '', $path, $file_id, $paramiter);
                            $data[$f_val->field_name] = $file_sql;
                            $field_filename = $f_val->field_name;
                        }
                    }
                }
                if($frm_rs->dont_repeat_field && $this->Csz_admin_model->countTable('form_' . $frm_rs->form_name, $frm_rs->dont_repeat_field." = '".$data[$frm_rs->dont_repeat_field]."'") > 0){
                    //Return to last page: Captcha invalid
                    if($field_filename){
                        @unlink(FCPATH . "/photo/" . str_replace(FCPATH . "/photo/", '', rtrim('forms/'.$this->Csz_model->cleanEmailFormat($frm_rs->form_name).'/'.$this->Csz_model->cleanEmailFormat($field_filename), '/')) . '/' . $data[$field_filename]);
                    }
                    $this->session->set_flashdata('formtag_error_message','<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $frm_rs->repeat_txt . '</div>');
                    redirect($cur_page, 'refresh');
                }
                if($frm_rs->save_to_db == 1){
                    $this->db->set('ip_address', $this->input->ip_address(), TRUE);
                    $this->db->set('timestamp_create', $this->Csz_model->timeNow(), TRUE);
                    $this->db->insert('form_' . $frm_rs->form_name, $data);
                }
                $email_from = 'no-reply@' . EMAIL_DOMAIN;
                $visit_email = '';
                if($frm_rs->send_to_visitor && $frm_rs->email_field_id){
                    $visit_field = $this->Csz_model->getValue('field_name', 'form_field', 'form_field_id', $frm_rs->email_field_id, 1);
                    if($visit_field->field_name && $frm_rs->visitor_subject){
                        $visit_email = $this->Csz_model->cleanEmailFormat($this->input->post_get($visit_field->field_name, TRUE));
                        $webconfig = $this->Csz_admin_model->load_config();
                        @$this->Csz_model->sendEmail($visit_email, $frm_rs->visitor_subject, $frm_rs->visitor_body, $email_from, $webconfig->site_name, '', $email_from);
                    }
                }
                $this->sendMail($frm_rs->sendmail, $frm_rs->email, $email_from, $frm_rs->subject, $field_rs, $frm_rs->form_method, $frm_rs->form_name, $file_sql, $visit_email);
                //Return to last page: Success
                $this->session->set_flashdata('formtag_error_message','<div class="alert alert-success text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $frm_rs->success_txt . '</div>');
                redirect($cur_page, 'refresh');
            } else {
                //Return to last page: Error, Form not active and (not save to DB or not send to email)
                $this->session->set_flashdata('formtag_error_message', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $frm_rs->error_txt . ' (FORM_IS_DISABLED)</div>');
                redirect($cur_page, 'refresh');
            }
        } else {
            //Return to home page
            redirect(base_url(), 'refresh');
        }
    }

    private function sendMail($active = '', $email_to = '', $email_from = '', $subject = '', $field_val = '', $form_method = '', $form_name = '', $file_upload = '', $reply_to = '') {
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
            if ($field_val) {
                $file_attach = array();
                $message_html = $this->Csz_model->getLabelLang('email_dear') . $to_email . ',<br><br>';
                foreach ($field_val as $val) {
                    if ($val->field_type != 'button' && $val->field_type != 'reset' && $val->field_type != 'submit' && $val->field_type != 'label') {
                        ($val->field_label)?$field_label = $val->field_label:$field_label = $val->field_name;
                        if($val->field_type == 'textarea'){
                            $message_html.= '<b>' . $field_label . ':</b> <br>' . $this->Csz_model->cleanOSCommand(strip_tags($this->input->post_get($val->field_name, TRUE))) . '<br><br>';
                        }else{
                            if ($val->field_type == 'email') {
                                $message_html .= '<b>' . $field_label . ':</b> ' . $this->Csz_model->cleanEmailFormat($this->input->post_get($val->field_name, TRUE)) . '<br>';
                            } else if ($form_method != 'get' && $val->field_type == 'file' && $file_upload) {
                                $file_attach[] = FCPATH . "photo/forms/" . $this->Csz_model->cleanEmailFormat($form_name) . '/' . $this->Csz_model->cleanEmailFormat($val->field_name) . '/' . $file_upload;
                            } else if($val->field_type != 'file') {
                                $message_html .= '<b>' . $field_label . ':</b> ' . $this->input->post_get($val->field_name, TRUE) . '<br>';
                            }
                        } 
                    }
                }
                $message_html.= '<br><br>' . $this->Csz_model->getLabelLang('email_footer') . ' <br><a href="' . $this->Csz_model->base_link(). '" target="_blank"><b>' . $webconfig->site_name . '</b></a>';           
                @$this->Csz_model->sendEmail($to_email, $subject, $message_html, $from_email, $from_name, '', $reply_to, '', $file_attach);
            }else{
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

}
