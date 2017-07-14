<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-cog"></span></i> <?php echo $this->lang->line('settings_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<?php echo form_open_multipart($this->Csz_model->base_link().'/admin/settings/update'); ?>
<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="h2 sub-header"><?php echo $this->lang->line('settings_header') ?></div>
        <div class="control-group">
            <?php echo form_error('siteTitle', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
            <label class="control-label" for="siteTitle"><?php echo $this->lang->line('settings_name'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'siteTitle',
                    'id' => 'siteTitle',
                    'class' => 'form-control',
                    'maxlength' => '255',
                    'value' => set_value('siteTitle', $settings->site_name, FALSE)
                );
                echo form_input($data);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="siteFooter"><?php echo $this->lang->line('settings_footer'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'siteFooter',
                    'id' => 'siteFooter',
                    'class' => 'form-control',
                    'value' => set_value('siteFooter', $settings->site_footer, FALSE)
                );
                echo form_input($data);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="siteKeyword"><?php echo $this->lang->line('settings_keyword'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'siteKeyword',
                    'id' => 'siteKeyword',
                    'class' => 'form-control',
                    'maxlength' => '255',
                    'value' => set_value('siteKeyword', $settings->keywords, FALSE)
                );
                echo form_input($data);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">
            <label class="control-label" for="siteTheme"><?php echo $this->lang->line('settings_theme'); ?></label>
            <div class="controls">
                <?php
                $att = 'id="siteTheme" class="form-control"';
                $data = array();
                if(!empty($themesdir)){
                    foreach($themesdir as $t){
                        if(!is_dir($t)){
                            $t = str_replace("\\", "", $t);
                            $t = str_replace("/", "", $t);
                            if(($t != "index.html") && ($t != "admin") && (strpos($t, 'admin') === false)){
                                $data[$t] = $t;
                            }
                        }
                    }
                }
                echo form_dropdown('siteTheme', $data, $settings->themes_config, $att);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">
            <label class="control-label" for="siteLang"><?php echo $this->lang->line('settings_lang'); ?></label>
            <div class="controls">
                <?php
                $att = 'id="siteLang" class="form-control"';
                $data = array();
                if(!empty($langdir)){
                    foreach($langdir as $l){
                        if(!is_dir($l)){
                            $l = str_replace("\\", "", $l);
                            $l = str_replace("/", "", $l);
                            if($l != "index.html"){
                                $data[$l] = $l;
                            }
                        }
                    }
                }
                echo form_dropdown('siteLang', $data, $settings->admin_lang, $att);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->  
        <div class="control-group">
            <label class="control-label" for="additional_metatag"><?php echo $this->lang->line('settings_add_meta'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'additional_metatag',
                    'id' => 'additional_metatag',
                    'class' => 'form-control'
                );
                echo form_textarea($data, $settings->additional_metatag);
                ?>
                <span class="remark"><em><?php echo $this->lang->line('settings_add_meta_remark'); ?></em></span>
            </div> <!-- /controls -->				
        </div> <!-- /control-group --> 
        <div class="control-group">
            <label class="control-label" for="additional_js"><?php echo $this->lang->line('settings_add_js'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'additional_js',
                    'id' => 'additional_js',
                    'class' => 'form-control'
                );
                echo form_textarea($data, $settings->additional_js);
                ?>
                <span class="remark"><em><?php echo $this->lang->line('settings_add_js_remark'); ?></em></span>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">
            <label class="control-label" for="pagecache_time"><?php echo $this->lang->line('settings_pagecache_time'); ?></label>
            <div class="controls">
                <?php
                $att = 'id="pagecache_time" class="form-control"';
                $data = array();
                $data['0'] = $this->lang->line('settings_pagecache_time_off');
                $data['1'] = '1 '.$this->lang->line('settings_pagecache_time_min');
                $data['2'] = '2 '.$this->lang->line('settings_pagecache_time_min');
                $data['5'] = '5 '.$this->lang->line('settings_pagecache_time_min');
                $data['10'] = '10 '.$this->lang->line('settings_pagecache_time_min');
                $data['15'] = '15 '.$this->lang->line('settings_pagecache_time_min');
                $data['20'] = '20 '.$this->lang->line('settings_pagecache_time_min');
                $data['30'] = '30 '.$this->lang->line('settings_pagecache_time_min');
                $data['45'] = '45 '.$this->lang->line('settings_pagecache_time_min');
                $data['60'] = '60 '.$this->lang->line('settings_pagecache_time_min');
                $data['90'] = '90 '.$this->lang->line('settings_pagecache_time_min');
                $data['120'] = '120 '.$this->lang->line('settings_pagecache_time_min');
                $data['180'] = '180 '.$this->lang->line('settings_pagecache_time_min');
                $data['240'] = '240 '.$this->lang->line('settings_pagecache_time_min');
                $data['300'] = '300 '.$this->lang->line('settings_pagecache_time_min');
                $data['360'] = '360 '.$this->lang->line('settings_pagecache_time_min');
                $data['720'] = '720 '.$this->lang->line('settings_pagecache_time_min');
                $data['1440'] = '1440 '.$this->lang->line('settings_pagecache_time_min');
                $data['10080'] = '10080 '.$this->lang->line('settings_pagecache_time_min');
                $data['21600'] = '21600 '.$this->lang->line('settings_pagecache_time_min');
                $data['43200'] = '43200 '.$this->lang->line('settings_pagecache_time_min');
                echo form_dropdown('pagecache_time', $data, $settings->pagecache_time, $att);
                ?>
                <span class="remark"><em><?php echo $this->lang->line('settings_pagecache_time_remark'); ?></em></span>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">										
            <label class="form-control-static" for="maintenance_active">
                <?php
                if($settings->maintenance_active){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $data = array(
                    'name' => 'maintenance_active',
                    'id' => 'maintenance_active',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('settings_maintenance_active'); ?></label>
        </div> <!-- /control-group -->
        <div class="control-group">										
            <label class="form-control-static" for="html_optimize_disable">
                <?php
                if($settings->html_optimize_disable){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $data = array(
                    'name' => 'html_optimize_disable',
                    'id' => 'html_optimize_disable',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('settings_html_optimize_disable'); ?></label>
        </div> <!-- /control-group -->
        <hr />
        <div class="control-group">		
            <?php echo form_error('file_upload', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
            <label class="control-label" for="file_upload"><?php echo $this->lang->line('settings_logo'); ?></label>
            <div class="controls">
                <div><img class="img-responsive img-thumbnail" src="<?php
                    if($settings->site_logo != "" && $settings->site_logo != NULL){
                        echo base_url() . 'photo/logo/'.$settings->site_logo;
                    }
                    ?>" id="logo_preloaded" <?php
                          if($settings->site_logo == "" || $settings->site_logo == NULL){
                              echo "style='display:none;'";
                          }
                          ?>></div>
                <?php if($settings->site_logo != "" && $settings->site_logo != NULL){ ?><label for="del_file"><input type="checkbox" name="del_file" id="del_file" value="<?php echo $settings->site_logo ?>"> <span class="remark">Delete File</span></label><?php } ?>                   
                <?php
                $data = array(
                    'name' => 'file_upload',
                    'id' => 'file_upload',
                    'class' => 'span5'
                );
                echo form_upload($data);
                ?>
                <input type="hidden" id="siteLogo" name="siteLogo" value="<?php echo $settings->site_logo ?>"/>
                <span class="remark"><em><?php echo $this->lang->line('settings_logo_remark'); ?></em></span>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <br>
        <div class="control-group">		
            <?php echo form_error('og_image', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
            <label class="control-label" for="og_image"><?php echo $this->lang->line('settings_og_image'); ?></label>
            <div class="controls">
                <div><img class="img-responsive img-thumbnail" src="<?php
                    if($settings->og_image != "" && $settings->og_image != NULL){
                        echo base_url().'photo/logo/'.$settings->og_image;
                    }
                    ?>" id="logo_preloaded" <?php
                          if($settings->og_image == "" || $settings->og_image == NULL){
                              echo "style='display:none;'";
                          }
                          ?>></div>
                <?php if($settings->og_image != "" && $settings->og_image != NULL){ ?><label for="del_og_image"><input type="checkbox" name="del_og_image" id="del_og_image" value="<?php echo $settings->og_image ?>"> <span class="remark">Delete File</span></label><?php } ?>                    
                <?php
                $data = array(
                    'name' => 'og_image',
                    'id' => 'og_image',
                    'class' => 'span5'
                );
                echo form_upload($data);
                ?>
                <input type="hidden" id="ogImage" name="ogImage" value="<?php echo $settings->og_image ?>"/>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="h2 sub-header"><?php echo $this->lang->line('settings_member_header') ?></div>
        <div class="control-group">										
            <label class="form-control-static" for="member_confirm_enable">
                <?php
                if($settings->member_confirm_enable){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $data = array(
                    'name' => 'member_confirm_enable',
                    'id' => 'member_confirm_enable',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('settings_member_confirm_active'); ?></label>
        </div> <!-- /control-group -->
        <div class="control-group">										
            <label class="form-control-static" for="member_close_regist">
                <?php
                if($settings->member_close_regist){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $data = array(
                    'name' => 'member_close_regist',
                    'id' => 'member_close_regist',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('settings_member_close_regist'); ?></label>
        </div> <!-- /control-group -->
        <div class="h2 sub-header"><?php echo $this->lang->line('settings_fbappid_header') ?></div>    
        <div class="control-group">	
            <label class="control-label" for="googlecapt_secretkey"><?php echo $this->lang->line('settings_fbapp_id'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'fbapp_id',
                    'id' => 'fbapp_id',
                    'class' => 'form-control',
                    'maxlength' => '255',
                    'value' => set_value('fbapp_id', $settings->fbapp_id, FALSE)
                );
                echo form_input($data);
                ?>
                <span class="remark"><em><?php echo $this->lang->line('settings_fbappid_remark'); ?></em></span>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <br>   
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="h2 sub-header"><?php echo $this->lang->line('settings_sitemap_header') ?></div>
        <a href="<?php echo $this->Csz_model->base_link().'/admin/settings/gensitemap' ?>" class="btn btn-success" title="<?php echo $this->lang->line('settings_sitemap_header') ?>"><?php echo $this->lang->line('settings_sitemap_runnow') ?></a><br>
        <b><?php echo $this->lang->line('settings_sitemap_lasttime') ?>: </b><b><?php if($sitemaptime !== FALSE){
                    echo '<span class="success"><em>'.$sitemaptime.'</em></span>';
                }else{
                    echo '<span class="error"><em>-</em></span>';
                } ?></b>
        <br><br>
        <div class="h2 sub-header"><?php echo $this->lang->line('settings_email_header') ?></div>
        <div class="control-group">	
            <label class="control-label" for="siteEmail"><?php echo $this->lang->line('settings_email'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'siteEmail',
                    'id' => 'siteEmail',
                    'class' => 'form-control',
                    'maxlength' => '255',
                    'value' => set_value('siteEmail', $settings->default_email, FALSE)
                );
                echo form_input($data);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">										
            <label class="control-label" for="email_protocal"><?php echo $this->lang->line('settings_email_protocal'); ?></label>
            <?php
            $att = 'id="email_protocal" class="form-control"';
            $data = array();
            $data['mail'] = 'Mail';
            $data['sendmail'] = 'Sendmail';
            $data['smtp'] = 'SMTP';
            echo form_dropdown('email_protocal', $data, $settings->email_protocal, $att);
            ?>		
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="smtp_host"><?php echo $this->lang->line('settings_smtp_host'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'smtp_host',
                    'id' => 'smtp_host',
                    'class' => 'form-control',
                    'maxlength' => '255',
                    'value' => set_value('smtp_host', $settings->smtp_host, FALSE)
                );
                echo form_input($data);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="smtp_user"><?php echo $this->lang->line('settings_smtp_user'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'smtp_user',
                    'id' => 'smtp_user',
                    'class' => 'form-control',
                    'maxlength' => '255',
                    'value' => set_value('smtp_user', $settings->smtp_user, FALSE)
                );
                echo form_input($data);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="smtp_pass"><?php echo $this->lang->line('settings_smtp_pass'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'smtp_pass',
                    'id' => 'smtp_pass',
                    'class' => 'form-control',
                    'maxlength' => '255',
                    'value' => set_value('smtp_pass', '', FALSE)
                );
                echo form_password($data);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="smtp_port"><?php echo $this->lang->line('settings_smtp_port'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'smtp_port',
                    'id' => 'smtp_port',
                    'class' => 'form-control',
                    'maxlength' => '5',
                    'value' => set_value('smtp_port', $settings->smtp_port, FALSE)
                );
                echo form_input($data);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="sendmail_path"><?php echo $this->lang->line('settings_sendmail_path'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'sendmail_path',
                    'id' => 'sendmail_path',
                    'class' => 'form-control',
                    'maxlength' => '255',
                    'value' => set_value('sendmail_path', $settings->sendmail_path, FALSE)
                );
                echo form_input($data);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <br>
        <div class="h2 sub-header"><?php echo $this->lang->line('settings_google_config') ?></div>
        <div class="control-group">										
            <label class="form-control-static" for="googlecapt_active">
                <?php
                if($settings->googlecapt_active){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $data = array(
                    'name' => 'googlecapt_active',
                    'id' => 'googlecapt_active',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('settings_googlecapt_active'); ?></label>	
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="googlecapt_sitekey"><?php echo $this->lang->line('settings_googlecapt_sitekey'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'googlecapt_sitekey',
                    'id' => 'googlecapt_sitekey',
                    'class' => 'form-control',
                    'maxlength' => '255',
                    'value' => set_value('googlecapt_sitekey', $settings->googlecapt_sitekey, FALSE)
                );
                echo form_input($data);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="googlecapt_secretkey"><?php echo $this->lang->line('settings_googlecapt_secretkey'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'googlecapt_secretkey',
                    'id' => 'googlecapt_secretkey',
                    'class' => 'form-control',
                    'maxlength' => '255',
                    'value' => set_value('googlecapt_secretkey', $settings->googlecapt_secretkey, FALSE)
                );
                echo form_input($data);
                ?>
                <span class="remark"><em><?php echo $this->lang->line('settings_googlecapt_remark'); ?></em></span>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="ga_client_id"><?php echo $this->lang->line('settings_ga_client_id'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'ga_client_id',
                    'id' => 'ga_client_id',
                    'class' => 'form-control',
                    'maxlength' => '255',
                    'value' => set_value('ga_client_id', $settings->ga_client_id, FALSE)
                );
                echo form_input($data);
                ?>
                <span class="remark"><em><?php echo $this->lang->line('settings_ga_client_id_remark'); ?></em></span>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="ga_view_id"><?php echo $this->lang->line('settings_ga_view_id'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'ga_view_id',
                    'id' => 'ga_view_id',
                    'class' => 'form-control',
                    'maxlength' => '255',
                    'value' => set_value('ga_view_id', $settings->ga_view_id, FALSE)
                );
                echo form_input($data);
                ?>
                <span class="remark"><em><?php echo $this->lang->line('settings_ga_view_id_remark'); ?></em></span>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">										
            <label class="form-control-static" for="gsearch_active">
                <?php
                if($settings->gsearch_active){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $data = array(
                    'name' => 'gsearch_active',
                    'id' => 'gsearch_active',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('settings_gsearch_active'); ?></label>	
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="gsearch_cxid"><?php echo $this->lang->line('settings_gsearch_cxid'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'gsearch_cxid',
                    'id' => 'gsearch_cxid',
                    'class' => 'form-control',
                    'maxlength' => '255',
                    'value' => set_value('gsearch_cxid', $settings->gsearch_cxid, FALSE)
                );
                echo form_input($data);
                ?>
                <span class="remark"><em><?php echo $this->lang->line('settings_gsearch_remark'); ?></em></span>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="gmaps_key"><?php echo $this->lang->line('settings_gmaps_key'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'gmaps_key',
                    'id' => 'gmaps_key',
                    'class' => 'form-control',
                    'maxlength' => '255',
                    'value' => set_value('gmaps_key', $settings->gmaps_key, FALSE)
                );
                echo form_input($data);
                ?>
                <span class="remark"><em><?php echo $this->lang->line('settings_gmaps_key_remark'); ?></em></span>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="gmaps_lat"><?php echo $this->lang->line('settings_gmaps_lat'); ?></label>
            <div class="controls">
                <?php
                if(empty($settings->gmaps_lat) && $settings->gmaps_lat == NULL){
                    $settings->gmaps_lat = '-28.621975';
                }
                $data = array(
                    'name' => 'gmaps_lat',
                    'id' => 'gmaps_lat',
                    'class' => 'form-control',
                    'maxlength' => '100',
                    'value' => set_value('gmaps_lat', $settings->gmaps_lat, FALSE)
                );
                echo form_input($data);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="gmaps_lng"><?php echo $this->lang->line('settings_gmaps_lng'); ?></label>
            <div class="controls">
                <?php
                if(empty($settings->gmaps_lng) && $settings->gmaps_lng == NULL){
                    $settings->gmaps_lng = '150.689082';
                }
                $data = array(
                    'name' => 'gmaps_lng',
                    'id' => 'gmaps_lng',
                    'class' => 'form-control',
                    'maxlength' => '100',
                    'value' => set_value('gmaps_lng', $settings->gmaps_lng, FALSE)
                );
                echo form_input($data);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <hr />
        <?php
        $data = array(
            'name' => 'submit',
            'id' => 'submit',
            'class' => 'btn btn-primary',
            'value' => $this->lang->line('btn_save'),
        );
        echo form_submit($data);
        ?>       
    </div>
</div>
<?php echo form_close(); ?>