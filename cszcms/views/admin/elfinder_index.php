<?php if($this->Csz_auth_model->is_group_allowed('server info', 'backend') !== FALSE){ ?>
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
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-server"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">(<?php echo $this->Csz_admin_model->getSoftwareInfo('n') ?>)</span>
                <span class="info-box-number"><?php echo $this->Csz_admin_model->getServerIp() ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-microchip"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><?php echo $this->lang->line('serverstatus_phpmem_use') ?></span>
                    <span class="info-box-number"><?php echo $this->Csz_admin_model->memUsage() ?> / <?php echo $this->Csz_admin_model->getMemLimit() ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-hdd-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><?php echo $this->lang->line('serverstatus_disk_use') ?></span>
                    <span class="info-box-number"><?php echo $this->Csz_admin_model->usageSpace() ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
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
                <b><?php echo $this->lang->line('serverstatus_php_disabled') ?>:</b> <?php echo $this->Csz_admin_model->getDisabledFunctions() ?><br>
                <b>PHPINFO:</b> <a class="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal"><?php echo $this->lang->line('dashboard_viewdetail') ?></a>
                <!-- Modal HTML -->
                <div id="myModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content"><iframe src="<?php echo $this->Csz_model->base_link(). '/admin/upgrade/phpinfo' ?>" width="100%" height="500"></iframe></div>
                    </div>
                </div>
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