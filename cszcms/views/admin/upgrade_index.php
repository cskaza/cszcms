<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-object-align-top"></span></i> <?php echo  $this->lang->line('upgrade_header') ?>
            </li>
        </ol>
        <div class="h2 sub-header"><?php echo  $this->lang->line('maintenance_header') ?></div>
        <?php echo form_open(BASE_URL . '/admin/upgrade/clearAllCache'); ?>
        <?php
        $data = array(
            'name' => 'submit',
            'id' => 'submit',
            'class' => 'btn btn-danger',
            'value' => $this->lang->line('btn_clearallcache'),
            'onclick' => "return confirm('".$this->lang->line('delete_message')."');",
        );
        echo form_submit($data);
        ?>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="h2 sub-header"><?php echo  $this->lang->line('upgrade_header') ?></div>
        <div class="panel panel-default">
            <div class="panel-body">
                <b><?php echo $this->lang->line('upgrade_curver'); ?> <i><?php echo  $cur_version ?></i></b> | <b><?php echo $this->lang->line('upgrade_lastver'); ?> <i><?php echo  $last_version ?></i></b>
            </div>
        </div>
        <span class="error"><b><?php echo $this->lang->line('upgrade_text'); ?></b></span>
        <br><br>
        <?php echo form_open(BASE_URL . '/admin/upgrade/download'); ?>
        <?php
        $data = array(
            'name' => 'submit',
            'id' => 'submit',
            'class' => 'btn btn-primary',
            'value' => $this->lang->line('btn_upgrade'),
            'onclick' => "return confirm('".$this->lang->line('delete_message')."');",
        );
        echo form_submit($data);
        ?>   
        <?php echo form_close(); ?>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="h2 sub-header"><?php echo  $this->lang->line('database_maintain_header') ?></div>

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
        <br><a href="<?php echo BASE_URL . '/admin/upgrade/backup'?>" target="_blank" class="btn btn-primary"><?php echo $this->lang->line('btn_backup_db')?></a>
    </div>
</div>
<?php if($this->session->flashdata('error_message') != ''){ ?>
<br><br>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <?php echo $this->session->flashdata('error_message'); ?>
    </div>
</div>
<?php } ?>