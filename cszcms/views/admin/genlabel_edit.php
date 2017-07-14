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
        <div class="h2 sub-header"><?php echo  $this->lang->line('genlabel_edit_header') ?> <a href="<?php echo $this->Csz_model->base_link(). '/admin/genlabel/synclang'?>" class="btn btn-primary" onclick="return confirm('<?php echo $this->lang->line('delete_message');?>')"><i class="glyphicon glyphicon-refresh"></i> <?php echo $this->lang->line('btn_label_synclang')?></a></div>
        <?php echo form_open($this->Csz_model->base_link(). '/admin/genlabel/updated/'.$this->uri->segment(4)); ?>

        <div class="control-group">	
            <label class="control-label"><?php echo $this->lang->line('genlabel_name'); ?> <?php if($genlab->remark){ ?><span class="remark"><em>(<?php echo $genlab->remark;?>)</em></span></label><?php } ?>
            <div class="well well-sm"><b><?php echo $genlab->name;?></b></div>
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label">English</label>
            <div class="well well-sm"><b><?php echo $this->Csz_model->getValue('lang_en', 'general_label', 'general_label_id', $this->uri->segment(4), 1)->lang_en; ?></b></div>
        </div> <!-- /control-group -->
        <?php foreach ($lang as $l) { ?>
            <div class="control-group">	
                <label class="control-label" for="lang_<?php echo $l['lang_iso'];?>"><?php echo $l['lang_name']; ?></label>
                <?php
                if(!$this->db->field_exists('lang_'.$l['lang_iso'], 'general_label')){
                    echo '<br><span class="remark"><em><b>'.$this->lang->line('genlabel_plssync_alert').'</b></em></span>';
                }else{ ?>									
                    <?php
                    $obj_key = 'lang_'.$l['lang_iso'];
                    $data = array(
                        'name' => 'lang_'.$l['lang_iso'],
                        'id' => 'lang_'.$l['lang_iso'],
                        'class' => 'form-control',
                        'value' => set_value('lang_'.$l['lang_iso'], $genlab->$obj_key)
                    );
                    echo form_input($data);
                } ?>
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
            <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex(); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
        </div> <!-- /form-actions -->
        <?php echo form_close(); ?>
        <!-- /widget-content --> 
    </div>
</div>
