<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-cog"></span></i> <?= $this->lang->line('settings_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?= $this->lang->line('settings_header') ?></div>
        <div class="control-group">	
            <?php
                echo form_open_multipart(BASE_URL . '/admin/settings/update');
                ?>
                <?php echo form_error('siteTitle', '<div class="error">', '</div>'); ?>									
                <label class="control-label" for="siteTitle"><?php echo $this->lang->line('settings_name'); ?></label>
                <div class="controls">
                    <?php
                    $data = array(
                        'name' => 'siteTitle',
                        'id' => 'siteTitle',
                        'class' => 'form-control',
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
                <label class="control-label" for="siteEmail"><?php echo $this->lang->line('settings_email'); ?></label>
                <div class="controls">
                    <?php
                    $data = array(
                        'name' => 'siteEmail',
                        'id' => 'siteEmail',
                        'class' => 'form-control',
                        'value' => set_value('siteEmail', $settings->default_email, FALSE)
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
                        'value' => set_value('siteKeyword', $settings->keywords, FALSE)
                    );
                    echo form_input($data);
                    ?>
                </div> <!-- /controls -->				
            </div> <!-- /control-group -->
            <div class="control-group">
                <label class="control-label" for="themes"><?php echo $this->lang->line('settings_theme'); ?></label>
                <div class="controls">
                    <?php
                    $att = 'id="siteTheme" class="form-control"';
                    $data = array();
                    foreach ($themesdir as $t) {
                        if (!is_dir($t)) {
                            $t = str_replace("\\", "", $t);
                            $t = str_replace("/", "", $t);
                            if (($t != "index.html") && ($t != "admin")) {
                                $data[$t] = $t;
                            }
                        }
                    }
                    echo form_dropdown('siteTheme', $data, $settings->themes_config, $att);
                    ?>
                </div> <!-- /controls -->				
            </div> <!-- /control-group -->
            <div class="control-group">
                <label class="control-label" for="themes"><?php echo $this->lang->line('settings_lang'); ?></label>
                <div class="controls">
                    <?php
                    $att = 'id="siteLang" class="form-control"';
                    $data = array();
                    foreach ($langdir as $l) {
                        if (!is_dir($l)) {
                            $l = str_replace("\\", "", $l);
                            $l = str_replace("/", "", $l);
                            if ($l != "index.html") {
                                $data[$l] = $l;
                            }
                        }
                    }
                    echo form_dropdown('siteLang', $data, $settings->admin_lang, $att);
                    ?>
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
            <hr />
            <div class="control-group">		
            <?php echo form_error('file_upload', '<div class="error">', '</div>'); ?>									
                <label class="control-label" for="file_upload"><?php echo $this->lang->line('settings_logo'); ?></label>
                <div class="controls">
                    <div><img src="<?php
                              if ($settings->site_logo != "") {
                                  echo BASE_URL . '/photo/logo/' . $settings->site_logo;
                              }
                              ?>" id="logo_preloaded" <?php
                    if ($settings->site_logo == "") {
                        echo "style='display:none;'";
                    }
                    ?>></div>
                    <? if ($settings->site_logo != "") { ?><label for="del_file"><input type="checkbox" name="del_file" id="del_file" value="<?=$settings->site_logo?>"> <span class="remark">Delete File</span></label><? } ?>
                    <img src="<?php echo BASE_URL; ?>templates/admin/imgs/ajax-loader.gif" style="margin:-7px 5px 0 5px;display:none;" id="loading_pic" />
                    <?php
                    $data = array(
                        'name' => 'file_upload',
                        'id' => 'file_upload',
                        'class' => 'span5'
                    );
                    echo form_upload($data);
                    ?>
                    <input type="hidden" id="siteLogo" name="siteLogo" value="<?=$settings->site_logo?>"/>
                </div> <!-- /controls -->				
            </div> <!-- /control-group -->
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
    <?php
    echo form_close();
?>
    </div>
</div>