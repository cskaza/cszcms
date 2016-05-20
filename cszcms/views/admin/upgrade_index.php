<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-object-align-top"></span></i> <?= $this->lang->line('upgrade_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?= $this->lang->line('upgrade_header') ?></div>
        <div class="panel panel-default">
            <div class="panel-body">
                <b><?php echo $this->lang->line('upgrade_curver'); ?> <i><?= $cur_version ?></i></b> | <b><?php echo $this->lang->line('upgrade_lastver'); ?> <i><?= $last_version ?></i></b>
            </div>
        </div>
        <span class="error"><b><?php echo $this->lang->line('upgrade_text'); ?></b></span>
        <br><br>
        <?php echo form_open(BASE_URL . '/admin/upgrade/download'); ?>
        <?
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
        
        <? if($error == 'lastver'){ ?>
            <br><br>
            <div class="alert alert-success" role="alert"><?=$this->lang->line('upgrade_lastver_alert')?></div>
        <? }else if($error == 'success'){ ?>
            <br><br>
            <div class="alert alert-success" role="alert"><?=$this->lang->line('upgrade_success_alert')?></div>
            <a href="<?=BASE_URL?>/admin/upgrade" class="btn btn-success btn-lg"><?=$this->lang->line('btn_refresh')?></a>
        <? }else if($error == 'error'){  ?>
            <br><br>
            <div class="alert alert-danger" role="alert"><?=$this->lang->line('upgrade_error_alert')?></div>
        <? } ?>       
    </div>
</div>