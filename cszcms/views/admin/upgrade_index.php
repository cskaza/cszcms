<!-- Page Heading -->
<div class="row">
    <div class="col-lg-6 col-md-6">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-gift"></span></i> <?php echo $this->lang->line('manual_upgrade') . ' / ' . $this->lang->line('pluginmgr_install') ?>
            </li>
        </ol>
        <?php echo form_open_multipart(BASE_URL . '/admin/upgrade/install'); ?>
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
        <?php echo form_open(BASE_URL . '/admin/upgrade/clearAllCache'); ?>
        <?php
        $data = array(
            'name' => 'submit',
            'id' => 'submit',
            'class' => 'btn btn-danger',
            'value' => $this->lang->line('btn_clearallcache'),
            'onclick' => "return confirm('" . $this->lang->line('delete_message') . "');",
        );
        echo form_submit($data);
        ?>
        <?php echo form_close(); ?>
        <br>
        <?php echo form_open(BASE_URL . '/admin/upgrade/clearAllDBCache'); ?>
        <?php
        $data = array(
            'name' => 'submit',
            'id' => 'submit',
            'class' => 'btn btn-danger',
            'value' => $this->lang->line('btn_clearalldbcache'),
            'onclick' => "return confirm('" . $this->lang->line('delete_message') . "');",
        );
        echo form_submit($data);
        ?>
        <?php echo form_close(); ?>
        <br>
        <?php echo form_open(BASE_URL . '/admin/upgrade/clearAllSession'); ?>
        <?php
        $data = array(
            'name' => 'submit',
            'id' => 'submit',
            'class' => 'btn btn-danger',
            'value' => $this->lang->line('btn_clear_sess'),
            'onclick' => "return confirm('" . $this->lang->line('clear_sess_message') . "');",
        );
        echo form_submit($data);
        ?>
        <?php echo form_close(); ?>
        <br>
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-object-align-top"></span></i> <?php echo $this->lang->line('logs_download_header') ?>
            </li>
        </ol>
        <a href="<?php echo BASE_URL . '/admin/upgrade/clearAllErrLog' ?>" class="btn btn-danger" onclick="return confirm('<?php echo $this->lang->line('delete_message') ?>');"><?php echo $this->lang->line('btn_clear_logs') ?></a>
        <br><br>
        <?php echo form_open(BASE_URL . '/admin/upgrade/downloadErrLog'); ?>
        <?php
        $att = 'id="errlogfile" class="form-control-static"';
        $data = array();
        $data[''] = $this->lang->line('option_choose');
        if(!empty($logsdir)){
            foreach ($logsdir as $t) {
                if (!is_dir($t)) {
                    $t = str_replace("\\", "", $t);
                    $t = str_replace("/", "", $t);
                    if (($t != "index.html") && ($t != ".htaccess")) {
                        $data[$t] = str_replace('.php', '', $t);
                    }
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
        <?php echo form_open(BASE_URL . '/admin/upgrade/download'); ?>
        <?php
        $data = array(
            'name' => 'submit',
            'id' => 'submit',
            'class' => 'btn btn-primary',
            'value' => $this->lang->line('btn_upgrade'),
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
                <i><span class="glyphicon glyphicon-object-align-top"></span></i> <?php echo $this->lang->line('database_maintain_header') ?>
            </li>
        </ol>
        <?php echo form_open(BASE_URL . '/admin/upgrade/optimize'); ?>
        <?php
        $data = array(
            'name' => 'submit',
            'id' => 'submit',
            'class' => 'btn btn-primary',
            'value' => $this->lang->line('btn_optimize_db'),
        );
        echo form_submit($data);
        ?>   
        <?php echo form_close(); ?>
        <br><a href="<?php echo BASE_URL . '/admin/upgrade/backup' ?>" target="_blank" class="btn btn-primary"><?php echo $this->lang->line('btn_backup_db') ?></a>
        <br><br>
    </div>
</div>