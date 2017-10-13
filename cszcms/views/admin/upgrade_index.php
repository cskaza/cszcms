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
    <div class="col-lg-6 col-md-6">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-gift"></span></i> <?php echo $this->lang->line('manual_upgrade') ?>
            </li>
        </ol>
        <?php echo form_open_multipart($this->Csz_model->base_link(). '/admin/upgrade/install'); ?>
        <?php
        $data = array(
            'name' => 'file_upload',
            'id' => 'file_upload',
            'class' => 'form-control-static',
            'accept' => '.zip'
        );
        echo form_upload($data);
        ?>
        <blockquote class="remark">
            <em><?php echo $this->lang->line('pluginmgr_zip_remark') ?></em>
        </blockquote>
        <?php
        $data = array(
            'name' => 'submit',
            'id' => 'submit',
            'class' => 'btn btn-primary form-inline',
            'value' => $this->lang->line('btn_install'),
            'onclick' => "return confirm('" . $this->lang->line('delete_message') . "');",
        );
        echo form_submit($data);
        ?>
        <?php echo form_close(); ?>
        <br><br>
    </div>
    <div class="col-lg-6 col-md-6">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-object-align-top"></span></i> <?php echo $this->lang->line('maintenance_header') ?>
            </li>
        </ol>
        <a href="<?php echo $this->Csz_model->base_link(). '/admin/upgrade/clearAllCache' ?>" class="btn btn-danger" onclick="return confirm('<?php echo $this->lang->line('delete_message') ?>');"><?php echo $this->lang->line('btn_clearallcache') ?></a>
        <br><br>
        <a href="<?php echo $this->Csz_model->base_link(). '/admin/upgrade/clearAllDBCache' ?>" class="btn btn-danger" onclick="return confirm('<?php echo $this->lang->line('delete_message') ?>');"><?php echo $this->lang->line('btn_clearalldbcache') ?></a>
        <br><br>
        <a href="<?php echo $this->Csz_model->base_link(). '/admin/upgrade/clearAllSession' ?>" class="btn btn-danger" onclick="return confirm('<?php echo $this->lang->line('clear_sess_message') ?>');"><?php echo $this->lang->line('btn_clear_sess') ?></a>
        <br><br>
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-object-align-top"></span></i> <?php echo $this->lang->line('logs_download_header') ?>
            </li>
        </ol>
        <a href="<?php echo $this->Csz_model->base_link(). '/admin/upgrade/clearAllErrLog' ?>" class="btn btn-danger" onclick="return confirm('<?php echo $this->lang->line('delete_message') ?>');"><?php echo $this->lang->line('btn_clear_logs') ?></a>
        <br><br>
        <?php echo form_open($this->Csz_model->base_link(). '/admin/upgrade/downloadErrLog'); ?>
        <?php
        $att = 'id="errlogfile" class="form-control-static"';
        $data = array();
        $data[''] = $this->lang->line('option_choose');
        if(!empty($logsdir)){
            $data['all'] = $this->lang->line('option_all');
            foreach ($logsdir as $t) {
                $t = str_replace("\\", "", $t);
                $t = str_replace("/", "", $t);
                if (($t[0] != ".") && ($t != "index.html") && is_file(APPPATH . '/logs/' . $t)) {
                    $data[$t] = str_replace('.php', '', $t);
                }
            }
        }
        echo form_dropdown('errlogfile', $data, '', $att); ?>
        <?php
        $data = array(
            'name' => 'submit',
            'id' => 'submit',
            'class' => 'btn btn-primary',
            'value' => $this->lang->line('btn_logs_download'),
        );
        echo form_submit($data);
        ?>
        <?php echo form_close(); ?>
        <br><br>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-6 col-md-6">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-object-align-top"></span></i> <?php echo $this->lang->line('upgrade_header') ?>
            </li>
        </ol>
        <div class="panel panel-default">
            <div class="panel-body">
                <b><?php echo $this->lang->line('upgrade_curver'); ?> <i><?php echo $cur_version ?></i></b> | <b><?php echo $this->lang->line('upgrade_lastver'); ?> <i><?php echo $last_version ?></i></b>
            </div>
        </div>
        <span class="error"><small><?php echo $this->lang->line('upgrade_text'); ?></small></span>
        <br><br>
        <a href="<?php echo $this->Csz_model->base_link(). '/admin/upgrade/download' ?>" class="btn btn-primary" onclick="return confirm('<?php echo $this->lang->line('delete_message') ?>');"><?php echo $this->lang->line('btn_upgrade') ?></a>
        <br><br>
    </div>
    <div class="col-lg-6 col-md-6">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-object-align-top"></span></i> <?php echo $this->lang->line('database_maintain_header') ?>
            </li>
        </ol>
        <a href="<?php echo $this->Csz_model->base_link(). '/admin/upgrade/optimize' ?>" class="btn btn-primary"><?php echo $this->lang->line('btn_optimize_db') ?></a>
        <br><br><a href="<?php echo $this->Csz_model->base_link(). '/admin/upgrade/backup' ?>" target="_blank" class="btn btn-primary"><?php echo $this->lang->line('btn_backup_db') ?></a>
        <br><br><a href="<?php echo $this->Csz_model->base_link(). '/admin/upgrade/filebackup' ?>" target="_blank" class="btn btn-primary"><?php echo $this->lang->line('btn_backup_file') ?></a>
        <br><br><a href="<?php echo $this->Csz_model->base_link(). '/admin/upgrade/photobackup' ?>" target="_blank" class="btn btn-primary"><?php echo $this->lang->line('btn_backup_photo') ?></a>
        <br><br>
    </div>
</div>