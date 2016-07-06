<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Member extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
        $this->load->database();
        $row = $this->Csz_model->load_config();
        if ($row->themes_config) {
            $this->template->set_template($row->themes_config);
            define('THEME', $row->themes_config);
        }
        if (!$this->session->userdata('fronlang_iso')) {
            $this->Csz_model->setSiteLang();
        }
        if ($this->Csz_model->chkLangAlive($this->session->userdata('fronlang_iso')) == 0) {
            $this->session->unset_userdata('fronlang_iso');
            $this->Csz_model->setSiteLang();
        }
        $this->_init();
    }

    public function _init() {
        $this->template->set('core_css', $this->Csz_model->coreCss());
        $this->template->set('core_js', $this->Csz_model->coreJs());
        $row = $this->Csz_model->load_config();
        $pageURL = $this->Csz_model->getCurPages();
        $this->page_url = $pageURL;
        $this->template->set('additional_js', $row->additional_js);
        $this->template->set('additional_metatag', $row->additional_metatag);
        $this->template->set('title', 'Member | ' . $row->site_name);
        $this->template->set('meta_tags', $this->Csz_model->coreMetatags('CSZ CMS | Member', $row->keywords));
        $this->template->set('cur_page', $pageURL);
    }

    public function index() {
        Member_helper::is_logged_in($this->session->userdata('admin_email'));
        $this->csz_referrer->setIndex('member');
        $this->template->setSub('users', $this->Csz_admin_model->getUser($this->session->userdata('user_admin_id')));
        $this->template->loadSub('frontpage/member/home');
    }

    public function login() {
        Member_helper::login_already($this->session->userdata('admin_email'));
        //Load the form helper

        $this->template->setSub('error', '');
        $this->load->helper('form');
        $this->template->loadSub('frontpage/member/login');
    }

    public function loginCheck() {
        Member_helper::login_already($this->session->userdata('admin_email'));
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $result = $this->Csz_model->memberLogin($email, $password);
        if ($result == 'SUCCESS') {
            $url_return = $this->input->post('url_return', TRUE);
            if($url_return){
                redirect($url_return, 'refresh');
            }else{
                redirect('member', 'refresh');
            }
        } else {
            $this->template->setSub('error', $result);
            $this->load->helper('form');
            $this->template->loadSub('frontpage/member/login');
        }
    }

    public function logout() {
        $data = array(
            'user_admin_id' => '',
            'admin_name' => '',
            'admin_email' => '',
            'admin_type' => '',
            'admin_logged_in' => FALSE,
        );
        $this->session->unset_userdata($data);
        $this->session->sess_destroy();
        redirect('member', 'refresh');
    }

    public function registMember() {
        Member_helper::login_already($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');
        //Load the view
        $this->template->setSub('chksts', 0);
        $this->template->loadSub('frontpage/member/regist');
    }

    public function saveMember() {
        Member_helper::login_already($this->session->userdata('admin_email'));
        $row = $this->Csz_model->load_config();
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('email', 'email address', 'trim|required|valid_email|is_unique[user_admin.email]');
        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('con_password', 'confirm password', 'trim|required|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $this->template->setSub('chksts', 0);
            $this->form_validation->set_message('email', $this->Csz_model->getLabelLang('email_already'));
            $this->template->loadSub('frontpage/member/regist');
        } else if ($this->Csz_model->chkCaptchaRes() == '') {
            $this->template->setSub('chksts', 0);
            $this->template->loadSub('frontpage/member/regist');
        } else {
            $email = $this->input->post('email', TRUE);
            $md5_hash = $this->Csz_model->createMember();
            //now we will send an email
            # ---- set subject --#
            $subject = $this->Csz_model->getLabelLang('email_confirm_subject');
            # ---- set from, to, bcc --#
            $from_name = $row->site_name;
            $from_email = 'no-reply@' . EMAIL_DOMAIN;
            $to_email = $email;
            # ---- set header --#
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers.= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers.= 'From: ' . $from_name . ' <' . $from_email . '>' . "\r\n";
            $message_html = $this->Csz_model->getLabelLang('email_dear') . $email . ',<br><br>' . $this->Csz_model->getLabelLang('email_confirm_message') . '<br><a href="' . BASE_URL . '/member/confirm/' . $md5_hash . '" target="_blank"><b>' . BASE_URL . '/member/confirm/' . $md5_hash . '</b></a><br><br>' . $this->Csz_model->getLabelLang('email_footer') . '<a href="' . BASE_URL . '" target="_blank"><b>' . $row->site_name . '</b></a>';
            # ---- send mail --#
            @mail($to_email, $subject, $message_html, $headers);
            $this->template->setSub('chksts', 1);
            $this->template->loadSub('frontpage/member/regist');
        }
    }

    public function confirmedMember() {
        Member_helper::login_already($this->session->userdata('admin_email'));
        $md5_hash = $this->uri->segment(3);
        $user_rs = $this->Csz_model->getValue('*', 'user_admin', 'md5_hash', $md5_hash, 1);
        if (!$user_rs) {
            show_error('Sorry!!! Invalid Request!');
        } else {
            $data = array(
                'active' => 1,
                'md5_hash' => md5(time() + mt_rand(1, 99999999)),
            );
            $this->db->set('md5_lasttime', 'NOW()', FALSE);
            $this->db->where('user_type', 'member');
            $this->db->where('md5_hash', $md5_hash);
            $this->db->where('user_admin_id', $user_rs->user_admin_id);
            $this->db->update('user_admin', $data);
            redirect('member', 'refresh');
        }
    }

    public function editMember() {
        Member_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form helper
        $this->load->helper('form');
        if ($this->session->userdata('user_admin_id')) {
            //Get user details from database
            $this->template->setSub('users', $this->Csz_admin_model->getUser($this->session->userdata('user_admin_id')));
            //Load the view
            $this->template->loadSub('frontpage/member/edit');
        }
    }

    public function saveEditMember() {
        Member_helper::is_logged_in($this->session->userdata('admin_email'));
        //Load the form validation library
        $this->load->library('form_validation');
        //Set validation rules
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|is_unique[user_admin.email.user_admin_id.' . $this->session->userdata('user_admin_id') . ']');
        $this->form_validation->set_rules('password', 'New Password', 'trim|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('con_password', 'Confirm Password', 'trim|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            //Validation failed
            $this->editMember();
        } else {
            //Validation passed
            //Update the user
            $this->Csz_model->updateMember($this->session->userdata('user_admin_id'));
            //Return to user list
            redirect('member', 'refresh');
        }
    }

    /*     * ************ Forgotten Password Resets ************* */

    public function forgot() {
        Member_helper::login_already($this->session->userdata('admin_email'));
        $row = $this->Csz_model->load_config();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');
        if ($this->form_validation->run() == FALSE) {
            $this->template->setSub('chksts', 0);
            $this->template->setSub('error_chk', 0);
            $this->template->loadSub('frontpage/member/email_forgot');
        } else if ($this->Csz_model->chkCaptchaRes() == '') {
            $this->template->setSub('chksts', 0);
            $this->template->setSub('error_chk', 1);
            $this->template->loadSub('frontpage/member/email_forgot');
        } else {
            $email = $this->input->post('email');
            $this->db->set('md5_hash', md5(time() + mt_rand(1, 99999999)), TRUE);
            $this->db->set('md5_lasttime', 'NOW()', FALSE);
            $this->db->where('email', $email);
            $this->db->update('user_admin');
            $this->load->helper('string');
            $user_rs = $this->Csz_model->getValue('md5_hash', 'user_admin', 'email', $email, 1);
            $md5_hash = $user_rs->md5_hash;

            //now we will send an email
            # ---- set subject --#
            $subject = $this->Csz_model->getLabelLang('email_reset_subject');
            # ---- set from, to, bcc --#
            $from_name = $row->site_name;
            $from_email = 'no-reply@' . EMAIL_DOMAIN;
            $to_email = $email;
            # ---- set header --#
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers.= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers.= 'From: ' . $from_name . ' <' . $from_email . '>' . "\r\n";
            $message_html = $this->Csz_model->getLabelLang('email_dear') . $email . ',<br><br>' . $this->Csz_model->getLabelLang('email_reset_message') . '<br><a href="' . BASE_URL . '/member/reset/' . $md5_hash . '" target="_blank"><b>' . BASE_URL . '/member/reset/' . $md5_hash . '</b></a><br><br>' . $this->Csz_model->getLabelLang('email_footer') . '<a href="' . BASE_URL . '" target="_blank"><b>' . $row->site_name . '</b></a>';
            # ---- send mail --#
            @mail($to_email, $subject, $message_html, $headers);
            $this->template->setSub('error_chk', 0);
            $this->template->setSub('chksts', 1);
            $this->template->loadSub('frontpage/member/email_forgot');
        }
    }

    public function email_check($str) {
        Member_helper::login_already($this->session->userdata('admin_email'));
        $this->db->where('email', $str);
        $this->db->limit(1, 0);
        $query = $this->db->get('user_admin');
        if ($query->num_rows() == 1) {
            return true;
        } else {
            $this->form_validation->set_message('email_check', $this->Csz_model->getLabelLang('email_check'));
            return false;
        }
    }

    public function getPassword() {
        Member_helper::login_already($this->session->userdata('admin_email'));
        $md5_hash = $this->uri->segment(3);
        $this->Csz_admin_model->chkMd5Time($md5_hash);
        $user_rs = $this->Csz_model->getValue('*', 'user_admin', 'md5_hash', $md5_hash, 1);
        if (!$user_rs) {
            redirect('member/forgot', 'refresh');
        } else {
            $this->template->setSub('email', $user_rs->email);
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]|matches[con_password]');
            $this->form_validation->set_rules('con_password', 'Password Confirmation', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $this->template->setSub('success_chk', 0);
                $this->template->loadSub('frontpage/member/resetform');
            } else {
                if (!$user_rs->email) {
                    show_error('Sorry!!! Invalid Request!');
                } else {
                    $data = array(
                        'password' => md5($this->input->post('password')),
                        'md5_hash' => md5(time() + mt_rand(1, 99999999)),
                    );
                    $this->db->set('md5_lasttime', 'NOW()', FALSE);
                    $this->db->where('md5_hash', $md5_hash);
                    $this->db->update('user_admin', $data);

                    $this->template->setSub('success_chk', 1);
                    $this->template->loadSub('frontpage/member/resetform');
                }
            }
        }
    }

}
