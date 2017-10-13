<?php if($this->Csz_auth_model->is_group_allowed('save', 'backend') !== FALSE){ ?>
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="fa fa-server"></span></i> <?php echo $this->lang->line('serverstatus_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- Info boxes -->
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-2">
                        <h1><i class="fa fa-server"></i></h1>
                    </div>
                    <div class="col-xs-10 text-right">
                        <div class="huge"><small style="font-size:60%"><?php echo $this->Csz_admin_model->getServerIp() ?></small></div>
                        <div>(<?php echo $this->Csz_admin_model->getSoftwareInfo('n') ?>)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col -->
    <div class="col-md-3">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-2">
                        <h1><i class="fa fa-microchip"></i></h1>
                    </div>
                    <div class="col-xs-10 text-right">
                        <div class="huge"><small style="font-size:60%"><?php echo $this->Csz_admin_model->memUsage() ?> / <?php echo $this->Csz_admin_model->getMemLimit() ?></small></div>
                        <div><?php echo $this->lang->line('serverstatus_phpmem_use') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col -->
    <div class="col-md-3">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-2">
                        <h1><i class="fa fa-hdd-o"></i></h1>
                    </div>
                    <div class="col-xs-10 text-right">
                        <div class="huge"><small style="font-size:60%"><?php echo $this->Csz_admin_model->usageSpace() ?></small></div>
                        <div><?php echo $this->lang->line('serverstatus_disk_use') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body" style="word-wrap:break-word;">
                <b><?php echo $this->lang->line('serverstatus_os') ?>:</b> <?php echo $this->Csz_admin_model->getSoftwareInfo('s') ?> <?php echo $this->Csz_admin_model->getSoftwareInfo('r') ?> <?php echo $this->Csz_admin_model->getSoftwareInfo('v') ?> <?php echo $this->Csz_admin_model->getSoftwareInfo('m') ?><br>
                <b><?php echo $this->lang->line('serverstatus_php_version') ?>:</b> <?php echo phpversion(); ?><br>
                <b>allow_url_fopen:</b> <?php if(ini_get('allow_url_fopen')){ echo $this->lang->line('option_yes'); }else{ echo $this->lang->line('option_no'); } ?><br>
                <b>APC Support:</b> <?php if(extension_loaded('apc') && ini_get('apc.enabled')){ echo $this->lang->line('option_yes'); }else{ echo $this->lang->line('option_no'); } ?><br>
                <b>Memcached Support:</b> <?php if(extension_loaded('memcached') || extension_loaded('memcache')){ echo $this->lang->line('option_yes'); }else{ echo $this->lang->line('option_no'); } ?><br>
                <b>Redis Support:</b> <?php if(extension_loaded('redis')){ echo $this->lang->line('option_yes'); }else{ echo $this->lang->line('option_no'); } ?><br>
                <b><?php echo $this->lang->line('serverstatus_php_disabled') ?>:</b> <?php echo $this->Csz_admin_model->getDisabledFunctions() ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-file"></span></i> <?php echo $this->lang->line('filemanager_template_create'); ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <?php echo form_open($this->Csz_model->base_link().'/admin/filemanager/templateCopy'); ?>
        <div class="control-group">	
            <label class="control-label" for="templatename"><?php echo $this->lang->line('filemanager_template_name'); ?> *</label>
            <div class="controls">
                <div class="input-group">
                    <?php
                    $data = array(
                        'name' => 'templatename',
                        'id' => 'templatename',
                        'required' => 'required',
                        'autofocus' => 'true',
                        'class' => 'form-control',
                        'maxlength' => '100',
                    );
                    echo form_input($data);
                    ?>
                    <div class="input-group-btn">
                        <?php
                        $data = array(
                            'name' => 'submit',
                            'id' => 'submit',
                            'class' => 'btn btn-primary',
                            'value' => $this->lang->line('filemanager_template_create'),
                        );
                        echo form_submit($data);
                        ?>
                    </div>
                </div>
                <span class="remark"><em><a href="<?php echo $this->Csz_model->base_link(); ?>/admin/settings" title="<?php echo '(' . $this->lang->line('settings_theme') . ') ' . $this->lang->line('settings_header') . ' ' .$this->lang->line('banner_link'); ?>!"><b><?php echo '(' . $this->lang->line('settings_theme') . ') ' . $this->lang->line('settings_header') . ' ' .$this->lang->line('banner_link'); ?>!</b></a></em></span>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <?php echo form_close(); ?>
    </div>
</div>
<br><br>
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-cloud"></span></i> <?php echo $this->lang->line('filemanager_header'); ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <!-- Element where elFinder will be created (REQUIRED) -->
        <div id="elfinder"></div>
    </div>
</div>