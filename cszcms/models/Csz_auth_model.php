<?php

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
 * 
 * This auth model is get idea from CodeIgniter-Aauth
 * https://github.com/emreakay/CodeIgniter-Aauth
 * 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Csz_auth_model extends CI_Model {

    public $pm_clean_max_age = "3 months";
    
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get group id
     * Get group id from group name
     * @param string $max_age Max age default 3 months
     */
    public function set_pm_clean_max_age($max_age) {
        if($max_age) $this->pm_clean_max_age = $max_age;
    }

    /**
     * Get group id
     * Get group id from group name
     * @param int|string $group_parm Group id or name to get
     * @return int Group id or FALSE
     */
    public function get_group_id($group_parm) {
        if (is_numeric($group_parm)) {
            return $group_parm;
        } else {
            return $this->Csz_model->getID('user_groups', 'user_groups_id', "name = '" . $group_parm . "'");
        }
    }

    /**
     * Get get_group_all
     * Get all group
     * @param string $sortby Sort by
     * @return array Group
     */
    public function get_group_all($sortby = '') {
        if($sortby){
            return $this->Csz_admin_model->getIndexData('user_groups', 0, 0, $sortby);
        }else{
            return $this->Csz_admin_model->getIndexData('user_groups', 0, 0, 'user_groups_id', 'asc');
        }
    }
    
    /**
     * Get get_perms_all
     * Get all group
     * @param string $type Permission type (backend or frontend)
     * @return array Perms
     */
    public function get_perms_all($type) {
        if($type){
            return $this->Csz_admin_model->getIndexData('user_perms', 0, 0, 'user_perms_id', 'asc', "permstype = '".$type."'");
        }else{
            return FALSE;
        }
    }

    /**
     * Get permission id
     * Get permission id from permisison name or id
     * @param int|string $perm_parm Permission id or name to get
     * @param string $type Permission type (backend or frontend) if $perms is id this type can NULL
     * @return int Permission id or NULL if perm does not exist
     */
    public function get_perm_id($perm_parm, $type = '') {
        if (is_numeric($perm_parm)) {
            return $perm_parm;
        } else {
            return $this->Csz_model->getID('user_perms', 'user_perms_id', "name = '" . $perm_parm . "' AND permstype = '".$type."'");
        }
    }

    /**
     * Get user from groups
     * Get groups a user is in
     * @param int $user_id User id to get or NULL for current user
     * @return array Groups (only 1 row) or FALSE
     */
    public function get_groups_fromuser($user_id = '') {
        if (!$user_id) {
            $user_id = $this->session->userdata('user_admin_id');
        }
        if ($user_id) {
            $this->db->join('user_groups', "user_groups.user_groups_id = user_to_group.user_groups_id");
            $this->db->where('user_to_group.user_admin_id', $user_id);
            $this->db->limit(1,0);
            $query = $this->db->get('user_to_group');            
            if ($query->num_rows() === 1) {
                return $query->first_row();
            }else{
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * create_usergroup
     *
     * Function for create user group
     *
     * @param	string	$group_name    group name
     * @param	string	$definition    for group definition
     * @param	string	$perms    for ferms field array
     * @return  bool TRUE or FALSE
     */
    public function create_group($group_name, $definition = '', $perms = '') {
        $query = $this->db->get_where('user_groups', array('name' => $group_name));
        if ($query->num_rows() === 0) {
            $data = array(
                'name' => $group_name,
                'definition' => $definition
            );
            $this->db->insert('user_groups', $data);
            $id = $this->db->insert_id();
            if(is_array($perms) && !empty($perms)){
                foreach($perms as $key => $value){
                    if($value && $value == 'allow'){
                        $this->allow_group($id, $key);
                    }
                }
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * update_usergroup
     *
     * Function for update user group
     *
     * @param	string	$user_groups_id    group id
     * @param	string	$group_name    group name
     * @param	string	$definition    for group definition
     */
    public function update_group($user_groups_id, $group_name = '', $definition = '', $perms = '') {
        if ($group_name != FALSE) {
            $data['name'] = $group_name;
        }
        if ($definition != FALSE) {
            $data['definition'] = $definition;
        }
        $this->db->where('user_groups_id', $user_groups_id);
        $this->db->update('user_groups', $data);
        if(is_array($perms) && !empty($perms)){
            foreach($perms as $key => $value){
                if($value && $user_groups_id != 1){
                    if($value == 'allow'){
                        $this->allow_group($user_groups_id, $key);
                    }else{
                        $this->deny_group($user_groups_id, $key);
                    }
                }
             }
        }
    }

    /**
     * delete_usergroup
     *
     * Function for delete user group
     *
     * @param	string	$user_groups_id    group id
     */
    public function delete_group($user_groups_id) {
        if($user_groups_id != 1 && $user_groups_id != 2 && $user_groups_id != 3 && $user_groups_id != 4){
            $this->Csz_admin_model->removeData('user_to_group', 'user_groups_id', $user_groups_id);
            $this->Csz_admin_model->removeData('user_perm_to_group', 'user_groups_id', $user_groups_id);
            $this->Csz_admin_model->removeData('user_groups', 'user_groups_id', $user_groups_id);
        }
    }

    /**
     * add_user_group
     * Add a user to a group
     * @param int $user_admin_id User id to add to group
     * @param int|string $group_parm Group id or name to add user
     * @return bool
     */
    public function add_user_group($user_admin_id, $group_parm) {
        $user_groups_id = $this->get_group_id($group_parm);
        $data = array(
            'user_admin_id' => $user_admin_id,
            'user_groups_id' => $user_groups_id
        );
        $count = $this->Csz_model->countData('user_to_group', $data);
        if ($count === FALSE || $count < 1) {
            $this->db->insert('user_groups', $data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * remove_user_group
     * Remove a user from a group
     * @param int $user_admin_id User id to remove from group
     * @param int|string $group_parm Group id or name to remove user
     */
    public function remove_user_group($user_admin_id, $group_parm) {
        $user_groups_id = $this->get_group_id($group_parm);
        $data = array(
            'user_admin_id' => $user_admin_id,
            'user_groups_id' => $user_groups_id
        );
        $this->Csz_admin_model->removeData('user_to_group', $data);
    }

    /**
     * Remove member
     * Remove a user from all groups
     * @param int $user_admin_id User id to remove from all groups
     * @return bool Remove success/failure
     */
    public function remove_user_from_allgroup($user_admin_id) {
        $this->Csz_admin_model->removeData('user_to_group', array('user_admin_id' => $user_admin_id));
    }

    /**
     * Is in group
     * Check if current user is a member of a group
     * @param int|string $group_par Group id or name to check
     * @param int $user_admin_id User id, if not given current user
     * @return bool
     */
    public function is_in_group($group_par, $user_admin_id = '') {
        // if user_id NULL (not given), current user
        if (!$user_admin_id) {
            $user_admin_id = $this->session->userdata('user_admin_id');
        }
        $user_groups_id = $this->get_group_id($group_par);
        if ($user_groups_id) {
            $data = array(
                'user_admin_id' => $user_admin_id,
                'user_groups_id' => $user_groups_id,
            );
            $count = $this->Csz_model->countData('user_to_group', $data);
            if ($count !== FALSE && $count != 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * is_useractive
     * Check if current user is a member of the admin group
     * @param int $user_admin_id User id to check, if it is not given checks current user
     * @return bool
     */
    public function is_useractive($user_admin_id = '') {
        if (!$user_admin_id) {
            $user_admin_id = $this->session->userdata('user_admin_id');
        }
        $data = array(
            'user_admin_id' => $user_admin_id,
            'active' => '1'
        );
        $count = $this->Csz_model->countData('user_admin', $data);
        if ($count !== FALSE && $count !== 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Is Group allowed
     * Check if group is allowed to do specified action, admin always allowed
     * @param int|string $perm_par Permission id or name to check
     * @param string $type Permission type (backend or frontend) if $perms is id this type can NULL
     * @param int|string $group_par Group id or name to check, or if NULL checks all user groups
     * @return bool
     */
    public function is_group_allowed($perm_par, $type = '', $group_par = '') {
        $perm_id = $this->get_perm_id($perm_par, $type);
        $group_id = '';
        // if group par is given
        if ($group_par) {
            $group_id = $this->get_group_id($group_par);
            $data = array(
                'user_perms_id' => $perm_id,
                'user_groups_id' => $group_id,
            );
            $count = $this->Csz_model->countData('user_perm_to_group', $data);
            if ($count !== FALSE && $count !== 0 || $group_id == 1) {
                return TRUE;
            }else{
                return FALSE;
            }
        } else {
            if ($this->is_in_group(1, $this->session->userdata('user_admin_id')) !== FALSE) { /* In Admin group */
                return TRUE;
            }else{
                $group_rs = $this->get_groups_fromuser();
                if ($group_rs !== FALSE) {
                    $data = array(
                        'user_perms_id' => $perm_id,
                        'user_groups_id' => $group_rs->user_groups_id,
                    );
                    $count = $this->Csz_model->countData('user_perm_to_group', $data);
                    if ($count !== FALSE && $count != 0) {
                        return TRUE;
                    }else{
                        return FALSE;
                    }
                }
            }
        }
    }

    /**
     * Allow Group
     * Add group to permission
     * @param int|string|bool $group_par Group id or name to allow
     * @param int $perm_par Permission id or name to allow
     * @param string $type Permission type (backend or frontend) if $perms is id this type can NULL
     * @return bool Allow success/failure
     */
    public function allow_group($group_par, $perm_par, $type = '') {
        $perm_id = $this->get_perm_id($perm_par, $type);
        $group_id = $this->get_group_id($group_par);
        if ($perm_id && $group_id) {
            $data = array(
                'user_perms_id' => $perm_id,
                'user_groups_id' => $group_id,
            );
            $count = $this->Csz_model->countData('user_perm_to_group', $data);
            if ($count === FALSE || $count < 1) {
                $this->db->insert('user_perm_to_group', $data);
            }
        }
    }

    /**
     * Deny Group
     * Remove group from permission
     * @param int|string|bool $group_par Group id or name to deny
     * @param int $perm_par Permission id or name to deny
     * @param string $type Permission type (backend or frontend) if $perms is id this type can NULL
     * @return bool Deny success/failure
     */
    public function deny_group($group_par, $perm_par, $type = '') {
        $perm_id = $this->get_perm_id($perm_par, $type);
        $group_id = $this->get_group_id($group_par);
        $data = array(
            'user_perms_id' => $perm_id,
            'user_groups_id' => $group_id
        );
        $this->Csz_admin_model->removeData('user_perm_to_group', $data);
    }

    ########################
    # Private Message Functions
    ########################
    /**
     * Send multiple Private Messages
     * Send multiple private messages to another users
     * @param int $sender_id User id of private message sender
     * @param array $receiver_id Array of User ids of private message receiver 
     * @param string $title Message title/subject
     * @param string $message Message body/content
     * @return array/bool Array with User ID's as key and TRUE or a specific error message OR FALSE if sender doesn't exist
     */
    public function send_pm($receiver_ids, $title, $message, $sender_id = '') {
        if (!$sender_id) {
            $sender_id = $this->session->userdata('user_admin_id');
        }
        if ($sender_id && (!$this->is_useractive($sender_id))) {
            return FALSE;
        }else{
            if ($receiver_ids && is_numeric($receiver_ids) && $sender_id != $receiver_ids) {
                $data = array(
                    'sender_id' => $sender_id,
                    'receiver_id' => $receiver_ids,
                    'title' => $title,
                    'message' => $message,
                    'date_sent' => date('Y-m-d H:i:s')
                );
                $this->db->insert('user_pms', $data);
                return TRUE;
            }else{
                return FALSE;
            }
        }
    }
    
    /**
     * List Private Messages
     * If receiver id not given retruns current user's pms, if sender_id given, it returns only pms from given sender
     * @param int $limit Number of private messages to be returned
     * @param int $offset Offset for private messages to be returned (for pagination)
     * @param int $sender_id User id of private message sender
     * @param int $receiver_id User id of private message receiver
     * @return object Array of private messages
     */
    public function list_pms($limit = 5, $offset = 0, $receiver_id = NULL, $sender_id = NULL, $unread = FALSE) {
        $search_sql = ' 1=1 ';
        if (is_numeric($receiver_id)) {
            $search_sql.= " AND receiver_id = '$receiver_id' ";
            $search_sql.= " AND pm_deleted_receiver IS NULL ";
        }
        if (is_numeric($sender_id)) {
            $search_sql.= " AND sender_id = '$sender_id' ";
            $search_sql.= " AND pm_deleted_sender IS NULL ";
        }
        if($unread){
            $search_sql.= " AND (date_read IS NULL OR date_read = '0000-00-00 00:00:00') ";
        }
        $rs = $this->Csz_admin_model->getIndexData('user_pms', $limit, $offset, 'id', 'desc', $search_sql);
        if($rs !== FALSE){
            return $rs;
        }else{
            return FALSE;
        }
    }

    /**
     * Get Private Message
     * Get private message by id
     * @param int $pm_id Private message id to be returned
     * @param int $user_id User ID of Sender or Receiver
     * @param bool $set_as_read Whether or not to mark message as read
     * @return object Private message
     */
    public function get_pm($pm_id, $user_admin_id = NULL, $set_as_read = TRUE) {
        if (!$user_admin_id) {
            $user_admin_id = $this->session->userdata('user_admin_id');
        }
        if (!is_numeric($user_admin_id) || !is_numeric($pm_id)) {
            return FALSE;
        }else{
            $query = $this->db->where('id', $pm_id);
            $query = $this->db->where('pm_deleted_sender', NULL);
            $query = $this->db->where('pm_deleted_receiver', NULL);
            $query = $this->db->group_start();
            $query = $this->db->where('receiver_id', $user_admin_id);
            $query = $this->db->or_where('sender_id', $user_admin_id);
            $query = $this->db->group_end();
            $query = $this->db->get('user_pms');
            if ($query->num_rows() < 1) {
                return FALSE;
            }else{
                $result = $query->row();
                if ($user_admin_id == $result->receiver_id && $set_as_read) {
                    $this->set_as_read_pm($pm_id);
                }
                return $result;
            }
        }
    }

    /**
     * Delete Private Message
     * Delete private message by id
     * @param int $pm_id Private message id to be deleted
     * @return bool Delete success/failure
     */
    public function delete_pm($pm_id, $user_admin_id = NULL) {
        if (!$user_admin_id) {
            $user_admin_id = $this->session->userdata('user_admin_id');
        }
        if (!is_numeric($user_admin_id) || !is_numeric($pm_id)) {
            return FALSE;
        }else{
            $query = $this->db->where('id', $pm_id);
            $query = $this->db->group_start();
            $query = $this->db->where('receiver_id', $user_admin_id);
            $query = $this->db->or_where('sender_id', $user_admin_id);
            $query = $this->db->group_end();
            $query = $this->db->get('user_pms');
            $result = $query->row();
            if ($user_admin_id == $result->sender_id) {
                if ($result->pm_deleted_receiver == 1) {
                    $this->Csz_admin_model->removeData('user_pms', array('id' => $pm_id));
                }
                $this->db->update('user_pms', array('pm_deleted_sender' => 1), array('id' => $pm_id));
            } else if ($user_admin_id == $result->receiver_id) {
                if ($result->pm_deleted_sender == 1) {
                    $this->Csz_admin_model->removeData('user_pms', array('id' => $pm_id));
                }
                $this->db->update('user_pms', array('pm_deleted_receiver' => 1, 'date_read' => date('Y-m-d H:i:s')), array('id' => $pm_id));
            }
            return TRUE;
        }
    }

    /**
     * Cleanup PMs 
     * Removes PMs older than 'pm_cleanup_max_age' (definied in aauth config).
     * recommend for a cron job
     */
    public function cleanup_pms() {
        $date_sent = date('Y-m-d H:i:s', strtotime("now -" . $this->pm_clean_max_age));
        $this->Csz_admin_model->removeData('user_pms', "date_sent < '".$date_sent."'");
    }

    /**
     * Count unread Private Message
     * Count number of unread private messages
     * @param int|bool $receiver_id User id for message receiver, if FALSE returns for current user
     * @return int Number of unread messages
     */
    public function count_unread_pms($receiver_id = FALSE) {
        if (!$receiver_id) {
            $receiver_id = $this->session->userdata('user_admin_id');
        }
        $data = array(
            'receiver_id' => $receiver_id,
            'date_read' => NULL,
            'pm_deleted_sender' => NULL,
            'pm_deleted_receiver' => NULL,
        );
        $count = $this->Csz_model->countData('user_pms', $data);
        if ($count !== FALSE && $count > 0) {
            return $count;
        }else{
            return 0;
        }
    }

    
    /**
     * Set Private Message as read
     * Set private message as read
     * @param int $pm_id Private message id to mark as read
     */
    public function set_as_read_pm($pm_id) {
        $data = array(
            'date_read' => date('Y-m-d H:i:s')
        );
        $this->db->update('user_pms', $data, "id = '".$pm_id."' AND receiver_id = '".$this->session->userdata('user_admin_id')."'");
    }
    
    /**
     * Set Private Message as unread
     * Set private message as unread
     * @param int $pm_id Private message id to mark as read
     */
    public function set_as_unread_pm($pm_id) {
        $data = array(
            'date_read' => NULL
        );
        $this->db->update('user_pms', $data, "id = '".$pm_id."' AND receiver_id = '".$this->session->userdata('user_admin_id')."'");
    }

}
