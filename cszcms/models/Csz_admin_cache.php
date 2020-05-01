<?php
/**
 * CSZ CMS
 *
 * An open source content management system
 *
 * Copyright (c) 2019, Chinawut Phongphasook (CSKAZA).
 *
 * Astian Develop Public License (ADPL)
 * 
 * This Source Code Form is subject to the terms of the Astian Develop Public
 * License, v. 1.0. If a copy of the APL was not distributed with this
 * file, You can obtain one at http://astian.org/about-ADPL
 * 
 * @author	CSKAZA
 * @copyright   Copyright (c) 2019, Chinawut Phongphasook (CSKAZA).
 * @license	http://astian.org/about-ADPL	ADPL License
 * @link	https://www.cszcms.com
 * @since	Version 1.0.0
 */
defined('BASEPATH') || exit('No direct script access allowed');

class Csz_admin_cache extends CI_Model{
    private $cachetime = 0;

    function __construct(){
        parent::__construct();
        $this->load->model('Csz_model');
        if (CACHE_TYPE == 'file') {
            $this->load->driver('cache', array('adapter' => 'file', 'key_prefix' => EMAIL_DOMAIN . '_'));
        } else {
            $this->load->driver('cache', array('adapter' => CACHE_TYPE, 'backup' => 'file', 'key_prefix' => EMAIL_DOMAIN . '_'));
        }
        $this->db->cache_on();
        $config = $this->Csz_model->load_config();
        if($config->pagecache_time == 0){
            $this->setcahetime(1);
        }else{
            $this->setcahetime($config->pagecache_time);
        }
    }
    
    /**
     * setcahetime
     * Set the cache time (In minute)
     * @param   int $minute   the minute of cache time
     */
    private function setcahetime($minute = 0) {
        if(is_numeric($minute)){
            $this->cachetime = $minute;
        }
    }
    
    public function getMailLogsDashboard($limit = 10, $order_by = 'timestamp_create', $sort_by = 'desc'){
        if (!$this->cache->get('MailLogsDashboard-'.$limit.$order_by.$sort_by)) {
            $this->cache->save('MailLogsDashboard-'.$limit.$order_by.$sort_by, $this->Csz_model->getValueArray('*', 'email_logs', "ip_address != ''", '', $limit, $order_by, $sort_by), ($this->cachetime * 60));
        }
        return $this->cache->get('MailLogsDashboard-'.$limit.$order_by.$sort_by);
    }
    
    public function getLinkStatDashboard($limit = 20, $order_by = 'timestamp_create', $sort_by = 'desc'){
        if (!$this->cache->get('LinkStatDashboard-'.$limit.$order_by.$sort_by)) {
            $this->cache->save('LinkStatDashboard-'.$limit.$order_by.$sort_by, $this->Csz_model->getValueArray('*', 'link_statistic', "ip_address != ''", '', $limit, $order_by, $sort_by), ($this->cachetime * 60));
        }
        return $this->cache->get('LinkStatDashboard-'.$limit.$order_by.$sort_by);
    }
    
    public function countMailLogsDashboard(){
        if (!$this->cache->get('countMailLogsDashboard')) {
            $this->cache->save('countMailLogsDashboard', $this->Csz_model->countData('email_logs'), ($this->cachetime * 60));
        }
        return $this->cache->get('countMailLogsDashboard');
    }
    
    public function countLinkStatDashboard(){
        if (!$this->cache->get('countLinkStatDashboard')) {
            $this->cache->save('countLinkStatDashboard', $this->Csz_model->countData('link_statistic'), ($this->cachetime * 60));
        }
        return $this->cache->get('countLinkStatDashboard');
    }
    
    public function countMemberDashboard(){
        if (!$this->cache->get('countMemberDashboard')) {
            $this->cache->save('countMemberDashboard', $this->Csz_model->countData('user_admin',"user_type = 'member'"), ($this->cachetime * 60));
        }
        return $this->cache->get('countMemberDashboard');
    }
}
