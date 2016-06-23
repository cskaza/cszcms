<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-globe"></span></i> <?php echo  $this->lang->line('genlabel_edit_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('genlabel_edit_header') ?></div>
        <?php echo form_open(BASE_URL . '/admin/genlabel/updated/'.$this->uri->segment(4)); ?>

        <div class="control-group">	
            <label class="control-label"><?php echo $this->lang->line('genlabel_name'); ?> <span class="remark"><em>(<?php echo $genlab->remark;?>)</em></span></label>
            <div class="well well-sm"><b><?php echo $genlab->name;?></b></div>
        </div> <!-- /control-group -->
        <?php foreach ($lang as $l) { ?>
            <div class="control-group">	
                <?php echo form_error('lang_'.$l['lang_iso'], '<div class="error">', '</div>'); ?>									
                <label class="control-label" for="lang_<?php echo $l['lang_iso'];?>"><?php echo $l['lang_name']; ?></label>
                <?php
                $obj_key = 'lang_'.$l['lang_iso'];
                $data = array(
                    'name' => 'lang_'.$l['lang_iso'],
                    'id' => 'lang_'.$l['lang_iso'],
                    'class' => 'form-control',
                    'value' => set_value('lang_'.$l['lang_iso'], $genlab->$obj_key)
                );
                echo form_input($data);
                ?>
            </div> <!-- /control-group -->
        <?php } ?>
        <br><br>
        <div class="form-actions">
            <?php
            $data = array(
                'name' => 'submit',
                'id' => 'submit',
                'class' => 'btn btn-lg btn-primary',
                'value' => $this->lang->line('btn_save'),
            );
            echo form_submit($data);
            ?> 
            <a class="btn btn-lg" href="<?php echo BASE_URL; ?>/admin/genlabel"><?php echo $this->lang->line('btn_cancel'); ?></a>
        </div> <!-- /form-actions -->
        <?php echo form_close(); ?>
        <!-- /widget-content --> 
    </div>
</div>
