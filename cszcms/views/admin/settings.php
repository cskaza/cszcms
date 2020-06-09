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
    <div class="col-lg-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab"><?php echo $this->lang->line('settings_header') ?></a></li>
              <li><a href="#tab_2" data-toggle="tab"><?php echo $this->lang->line('settings_email_header') ?></a></li>
              <li><a href="#tab_3" data-toggle="tab"><?php echo $this->lang->line('settings_other_api') ?></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="h2 sub-header"><?php echo $this->lang->line('settings_header') ?>*</div>
                    <div class="control-group">
                        <?php echo form_error('siteTitle', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
                        <label class="control-label" for="siteTitle"><?php echo $this->lang->line('settings_name'); ?></label>
                        <div class="controls">
                            <?php
                            $data = array(
                                'name' => 'siteTitle',
                                'id' => 'siteTitle',
                                'required' => 'required',
                                'autofocus' => 'true',
                                'class' => 'form-control',
                                'maxlength' => '255',
                                'value' => set_value('siteTitle', $settings->site_name, FALSE)
                            );
                            echo form_input($data);
                            ?>
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                    <div class="control-group">
                        <label class="control-label" for="title_setting"><?php echo $this->lang->line('settings_titlesetting'); ?></label>
                        <div class="controls">
                            <?php
                            $att = 'id="title_setting" class="form-control"';
                            $data = array();
                            $data['0'] = $this->lang->line('settings_pagecache_time_off');
                            $data['1'] = $this->lang->line('settings_titlesetting_first');
                            $data['2'] = $this->lang->line('settings_titlesetting_last');
                            echo form_dropdown('title_setting', $data, $settings->title_setting, $att);
                            ?>
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                    <div class="control-group">	
                        <label class="control-label" for="siteFooter"><?php echo $this->lang->line('settings_footer'); ?>*</label>
                        <div class="controls">
                            <?php
                            $data = array(
                                'name' => 'siteFooter',
                                'id' => 'siteFooter',
                                'required' => 'required',
                                'autofocus' => 'true',
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
                                    $t = str_replace("\\", "", $t);
                                    $t = str_replace("/", "", $t);
                                    if(($t[0] != ".") && ($t != "index.html") && ($t != "admin") && (strpos($t, 'admin') === false) && is_dir(APPPATH . '/views/templates/'.$t)){
                                            $data[$t] = $t;
                                    }
                                }
                            }
                            echo form_dropdown('siteTheme', $data, $settings->themes_config, $att);
                            ?>
                            <span class="remark"><em><a href="<?php echo $this->Csz_model->base_link(); ?>/admin/filemanager" title="<?php echo $this->lang->line('filemanager_template_create').' '.$this->lang->line('banner_link'); ?>!"><b><?php echo $this->lang->line('filemanager_template_create').' '.$this->lang->line('banner_link'); ?>!</b></a></em></span>
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
                                    $l = str_replace("\\", "", $l);
                                    $l = str_replace("/", "", $l);
                                    if(($l[0] != ".") && ($l != "index.html") && is_dir(APPPATH . '/language/'.$l)){
                                            $data[$l] = $l;
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
                        <label class="control-label" for="assets_static_domain"><?php echo $this->lang->line('settings_assets_static_domain'); ?></label>
                        <div class="controls">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <label for="assets_static_active"><?php
                                    if ($settings->assets_static_active) {
                                        $checked = 'checked';
                                    } else {
                                        $checked = '';
                                    }
                                    $data = array(
                                        'name' => 'assets_static_active',
                                        'id' => 'assets_static_active',
                                        'value' => '1',
                                        'checked' => $checked
                                    );
                                    echo form_checkbox($data);
                                    ?> <?php echo $this->lang->line('lang_active'); ?></label>
                                </div>
                                <?php
                                $data = array(
                                    'name' => 'assets_static_domain',
                                    'id' => 'assets_static_domain',
                                    'class' => 'form-control',
                                    'maxlength' => '255',
                                    'value' => set_value('assets_static_domain', $settings->assets_static_domain, FALSE)
                                );
                                echo form_input($data);
                                ?>
                            </div>
                            <span class="remark"><em><?php echo $this->lang->line('settings_assets_static_domain_remark'); ?></em></span>
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                    <br>
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
                            <?php if($settings->site_logo != "" && $settings->site_logo != NULL){ ?>
                            <div class="col-md-4">
                                <img class="img-responsive img-thumbnail" src="<?php echo base_url() . 'photo/logo/'.$settings->site_logo;?>">
                                <br><label for="del_file"><input type="checkbox" name="del_file" id="del_file" value="<?php echo $settings->site_logo ?>"> <span class="remark">Delete File</span></label>
                            </div>
                            <?php } ?>                   
                            <?php
                            $data = array(
                                'name' => 'file_upload',
                                'id' => 'file_upload',
                                'class' => 'form-control'
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
                            <?php if($settings->og_image != "" && $settings->og_image != NULL){ ?>
                            <div class="col-md-4">
                                <img class="img-responsive img-thumbnail" src="<?php echo base_url().'photo/logo/'.$settings->og_image; ?>">
                                <br><label for="del_og_image"><input type="checkbox" name="del_og_image" id="del_og_image" value="<?php echo $settings->og_image ?>"> <span class="remark">Delete File</span></label>
                            </div>
                            <?php } ?>                    
                            <?php
                            $data = array(
                                'name' => 'og_image',
                                'id' => 'og_image',
                                'class' => 'form-control'
                            );
                            echo form_upload($data);
                            ?>
                            <input type="hidden" id="ogImage" name="ogImage" value="<?php echo $settings->og_image ?>"/>
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <div class="h2 sub-header"><?php echo $this->lang->line('settings_email_header') ?></div>
                    <div class="control-group">	
                        <label class="control-label" for="siteEmail"><?php echo $this->lang->line('settings_email'); ?></label>
                        <div class="controls">
                            <div class="input-group">
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
                                <div class="input-group-btn"><a href="<?php echo $this->Csz_model->base_link().'/admin/settings/testsendmail' ?>" class="btn btn-primary" title="<?php echo $this->lang->line('settings_email_testbtn') ?>"><?php echo $this->lang->line('settings_email_testbtn') ?></a></div>
                            </div>
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                    <div class="control-group">										
                        <label class="control-label" for="email_protocal"><?php echo $this->lang->line('settings_email_protocal'); ?></label>
                        <?php
                        $att = 'id="email_protocal" class="form-control" onchange="mailConfig(this.value)"';
                        $data = array();
                        $data['mail'] = 'Mail';
                        $data['sendmail'] = 'Sendmail';
                        $data['smtp'] = 'SMTP';
                        echo form_dropdown('email_protocal', $data, $settings->email_protocal, $att);
                        ?>		
                    </div> <!-- /control-group -->
                    <div class="control-group" id="smtp1" style="display:none;">	
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
                    <div class="control-group" id="smtp2" style="display:none;">	
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
                    <div class="control-group" id="smtp3" style="display:none;">	
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
                    <div class="control-group" id="smtp4" style="display:none;">	
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
                    <div class="control-group" id="sendmail" style="display:none;">	
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
                    <div class="control-group">										
                        <label class="form-control-static" for="email_logs">
                            <?php
                            if($settings->email_logs){
                                $checked = 'checked';
                            }else{
                                $checked = '';
                            }
                            $data = array(
                                'name' => 'email_logs',
                                'id' => 'email_logs',
                                'value' => '1',
                                'checked' => $checked
                            );
                            echo form_checkbox($data);
                            ?> <?php echo $this->lang->line('settings_email_logs'); ?></label>	
                    </div> <!-- /control-group -->
                    <br>
                    <div class="h2 sub-header"><?php echo $this->lang->line('settings_sitemap_header') ?></div><a href="<?php echo $this->Csz_model->base_link().'/admin/settings/gensitemap' ?>" class="btn btn-success" title="<?php echo $this->lang->line('settings_sitemap_runnow') ?>"><?php echo $this->lang->line('settings_sitemap_runnow') ?></a><br>
                    <b><?php echo $this->lang->line('settings_sitemap_lasttime') ?>: </b><b><?php if($sitemaptime !== FALSE){
                                echo '<span class="success"><em>'.$sitemaptime.'</em></span>';
                            }else{
                                echo '<span class="error"><em>-</em></span>';
                            } ?></b>
                    <br><br>
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
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
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
                    <br>
                    <div class="h2 sub-header"><?php echo $this->lang->line('settings_fbappid_header') ?></div>    
                    <div class="control-group">	
                        <label class="control-label" for="fbapp_id"><?php echo $this->lang->line('settings_fbapp_id'); ?></label>
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
                    <div class="control-group">	
                        <label class="control-label" for="facebook_page_id"><?php echo $this->lang->line('settings_facebook_page_id'); ?></label>
                        <div class="controls">
                            <?php
                            $data = array(
                                'name' => 'facebook_page_id',
                                'id' => 'facebook_page_id',
                                'class' => 'form-control',
                                'maxlength' => '255',
                                'value' => set_value('facebook_page_id', $settings->facebook_page_id, FALSE)
                            );
                            echo form_input($data);
                            ?>
                            <span class="remark"><em><?php echo $this->lang->line('settings_facebook_page_id_remark'); ?></em></span>
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                    <div class="control-group">										
                        <label class="form-control-static" for="fb_messenger">
                            <?php
                            if($settings->fb_messenger){
                                $checked = 'checked';
                            }else{
                                $checked = '';
                            }
                            $data = array(
                                'name' => 'fb_messenger',
                                'id' => 'fb_messenger',
                                'value' => '1',
                                'checked' => $checked
                            );
                            echo form_checkbox($data);
                            ?> <?php echo $this->lang->line('settings_fb_messenger'); ?></label>
                        <br><span class="remark"><em><?php echo $this->lang->line('settings_fb_messenger_remark'); ?></em></span>
                    </div> <!-- /control-group -->
                    <br>
                    <div class="h2 sub-header"><?php echo $this->lang->line('settings_other_api') ?></div>
                    <div class="control-group">	
                        <label class="control-label" for="adobe_cc_apikey"><?php echo $this->lang->line('filemanager_cc_apikey'); ?></label>
                        <div class="controls">
                            <?php
                            $data = array(
                                'name' => 'adobe_cc_apikey',
                                'id' => 'adobe_cc_apikey',
                                'class' => 'form-control',
                                'maxlength' => '255',
                                'value' => set_value('adobe_cc_apikey', $settings->adobe_cc_apikey, FALSE)
                            );
                            echo form_input($data);
                            ?>
                            <span class="remark"><em><?php echo $this->lang->line('filemanager_cc_apikey_remark'); ?></em></span>
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                    <br>
                    <div class="h2 sub-header"><?php echo $this->lang->line('settings_cookie_info_text') ?> <span class="remark"><b><a href="https://cookieinfoscript.com/legal.html" target="_blank" title="?">[?]</a></b></span></div>
                    <div class="control-group">										
                        <label class="form-control-static" for="cookieinfo_active">
                            <?php
                            if($settings->cookieinfo_active){
                                $checked = 'checked';
                            }else{
                                $checked = '';
                            }
                            $data = array(
                                'name' => 'cookieinfo_active',
                                'id' => 'cookieinfo_active',
                                'value' => '1',
                                'checked' => $checked
                            );
                            echo form_checkbox($data);
                            ?> <?php echo $this->lang->line('settings_cookie_info_active'); ?></label>
                    </div> <!-- /control-group -->
                    <br>
                    <div class="control-group">	
                        <label class="control-label" for="cookieinfo_bg"><?php echo $this->lang->line('settings_cookie_info_bg'); ?></label>
                        <div class="controls">
                            <?php
                            $data = array(
                                'name' => 'cookieinfo_bg',
                                'id' => 'cookieinfo_bg',
                                'type' => 'color',
                                'class' => 'form-control',
                                'maxlength' => '7',
                                'value' => set_value('cookieinfo_bg', $settings->cookieinfo_bg, FALSE)
                            );
                            echo form_input($data);
                            ?>
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                    <div class="control-group">	
                        <label class="control-label" for="cookieinfo_fg"><?php echo $this->lang->line('settings_cookie_info_fg'); ?></label>
                        <div class="controls">
                            <?php
                            $data = array(
                                'name' => 'cookieinfo_fg',
                                'id' => 'cookieinfo_fg',
                                'type' => 'color',
                                'class' => 'form-control',
                                'maxlength' => '7',
                                'value' => set_value('cookieinfo_fg', $settings->cookieinfo_fg, FALSE)
                            );
                            echo form_input($data);
                            ?>
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                    <div class="control-group">	
                        <label class="control-label" for="cookieinfo_link"><?php echo $this->lang->line('settings_cookie_info_link'); ?></label>
                        <div class="controls">
                            <?php
                            $data = array(
                                'name' => 'cookieinfo_link',
                                'id' => 'cookieinfo_link',
                                'type' => 'color',
                                'class' => 'form-control',
                                'maxlength' => '7',
                                'value' => set_value('cookieinfo_link', $settings->cookieinfo_link, FALSE)
                            );
                            echo form_input($data);
                            ?>
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                    <div class="control-group">	
                        <label class="control-label" for="cookieinfo_msg"><?php echo $this->lang->line('settings_cookie_info_msg'); ?></label>
                        <div class="controls">
                            <?php
                            $data = array(
                                'name' => 'cookieinfo_msg',
                                'id' => 'cookieinfo_msg',
                                'class' => 'form-control',
                                'maxlength' => '255',
                                'value' => set_value('cookieinfo_msg', $settings->cookieinfo_msg, FALSE)
                            );
                            echo form_input($data);
                            ?>
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                    <div class="control-group">	
                        <label class="control-label" for="cookieinfo_linkmsg"><?php echo $this->lang->line('settings_cookie_info_linkmsg'); ?></label>
                        <div class="controls">
                            <?php
                            $data = array(
                                'name' => 'cookieinfo_linkmsg',
                                'id' => 'cookieinfo_linkmsg',
                                'class' => 'form-control',
                                'maxlength' => '100',
                                'value' => set_value('cookieinfo_linkmsg', $settings->cookieinfo_linkmsg, FALSE)
                            );
                            echo form_input($data);
                            ?>
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                    <div class="control-group">	
                        <label class="control-label" for="cookieinfo_moreinfo"><?php echo $this->lang->line('settings_cookie_info_linkurl'); ?></label>
                        <div class="controls">
                            <?php
                            $data = array(
                                'name' => 'cookieinfo_moreinfo',
                                'id' => 'cookieinfo_moreinfo',
                                'type' => 'url',
                                'class' => 'form-control',
                                'maxlength' => '255',
                                'value' => set_value('cookieinfo_moreinfo', $settings->cookieinfo_moreinfo, FALSE)
                            );
                            echo form_input($data);
                            ?>
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                    <div class="control-group">
                        <label class="control-label" for="cookieinfo_txtalign"><?php echo $this->lang->line('settings_cookie_info_txtalign'); ?></label>
                        <div class="controls">
                            <?php
                            $att = 'id="cookieinfo_txtalign" class="form-control"';
                            $data = array();
                            $data['left'] = $this->lang->line('settings_cookie_info_txtalign_left');
                            $data['center'] = $this->lang->line('settings_cookie_info_txtalign_center');
                            $data['right'] = $this->lang->line('settings_cookie_info_txtalign_right');
                            echo form_dropdown('cookieinfo_txtalign', $data, $settings->cookieinfo_txtalign, $att);
                            ?>
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                    <div class="control-group">	
                        <label class="control-label" for="cookieinfo_close"><?php echo $this->lang->line('settings_cookie_info_closetxt'); ?></label>
                        <div class="controls">
                            <?php
                            $data = array(
                                'name' => 'cookieinfo_close',
                                'id' => 'cookieinfo_close',
                                'class' => 'form-control',
                                'maxlength' => '100',
                                'value' => set_value('cookieinfo_close', $settings->cookieinfo_close, FALSE)
                            );
                            echo form_input($data);
                            ?>
                        </div> <!-- /controls -->				
                    </div> <!-- /control-group -->
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
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
<script type="text/javascript">
window.onload = function() {
    var mailconfig = document.getElementById('email_protocal').value;
    mailConfig(mailconfig);
};
function mailConfig(val){
    if(val == 'sendmail'){
            document.getElementById('sendmail').style.display = 'block';
            document.getElementById('smtp1').style.display = 'none';
            document.getElementById('smtp2').style.display = 'none';
            document.getElementById('smtp3').style.display = 'none';
            document.getElementById('smtp4').style.display = 'none';
    }else if(val == 'smtp'){
            document.getElementById('smtp1').style.display = 'block';
            document.getElementById('smtp2').style.display = 'block';
            document.getElementById('smtp3').style.display = 'block';
            document.getElementById('smtp4').style.display = 'block';
            document.getElementById('sendmail').style.display = 'none';
    }else{
            document.getElementById('sendmail').style.display = 'none';
            document.getElementById('smtp1').style.display = 'none';
            document.getElementById('smtp2').style.display = 'none';
            document.getElementById('smtp3').style.display = 'none';
            document.getElementById('smtp4').style.display = 'none';
    }
}
</script>