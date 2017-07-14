<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-stats"></span></i> <?php echo $this->lang->line('banner_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('banner_new') ?>  <a role="button" href="<?php echo $this->Csz_model->base_link() ?>/admin/banner/new" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo $this->lang->line('banner_new') ?></a></div>
        <?php echo form_open_multipart($this->Csz_model->base_link(). '/admin/banner/insert'); ?>

        <div class="control-group">	
            <?php echo form_error('name', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="name"><?php echo $this->lang->line('banner_name'); ?>*</label>
            <?php
            $data = array(
                'name' => 'name',
                'id' => 'name',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('name', '', FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">	
            <?php echo form_error('width', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="width"><?php echo $this->lang->line('banner_width'); ?></label>
            <?php
            $data = array(
                'name' => 'width',
                'id' => 'width',
                'maxlength' => '5',
                'class' => 'form-control keypress-number',
                'value' => set_value('width', '', FALSE)
            );
            echo form_input($data);
            ?>
        </div> <!-- /control-group -->
        <div class="control-group">	
            <?php echo form_error('height', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="height"><?php echo $this->lang->line('banner_height'); ?></label>
            <?php
            $data = array(
                'name' => 'height',
                'id' => 'height',
                'maxlength' => '5',
                'class' => 'form-control keypress-number',
                'value' => set_value('height', '', FALSE)
            );
            echo form_input($data);
            ?>
        </div> <!-- /control-group -->
        <div class="control-group">
            <?php echo form_error('link', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
            <label class="control-label" for="link"><?php echo $this->lang->line('banner_link'); ?>*</label>
            <?php
            $data = array(
                'name' => 'link',
                'id' => 'link',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('link', '', FALSE)
            );
            echo form_input($data);
            ?>
        </div> <!-- /control-group -->
        <div class="control-group">	
            <?php echo form_error('start_date', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="start_date"><?php echo $this->lang->line('startdate_field'); ?>*</label>
            <?php
            $data = array(
                'name' => 'start_date',
                'id' => 'start_date',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control form-datepicker',
                'value' => set_value('start_date', '', FALSE)
            );
            echo form_input($data);
            ?>
        </div> <!-- /control-group -->
        <div class="control-group">	
            <?php echo form_error('end_date', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="end_date"><?php echo $this->lang->line('enddate_field'); ?>*</label>
            <?php
            $data = array(
                'name' => 'end_date',
                'id' => 'end_date',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control form-datepicker',
                'value' => set_value('end_date', '', FALSE)
            );
            echo form_input($data);
            ?>
        </div> <!-- /control-group -->
        <div class="control-group">            
            <label class="control-label" for="note"><?php echo $this->lang->line('bf_note'); ?></label>
            <?php
            $data = array(
                'name' => 'note',
                'id' => 'note',
                'class' => 'form-control',
                'value' => set_value('note', '', FALSE)
            );
            echo form_textarea($data);
            ?>			
        </div> <!-- /control-group -->
        <br>
        <div class="control-group">										
            <label class="form-control-static" for="nofollow">
                <?php
                $data = array(
                    'name' => 'nofollow',
                    'id' => 'nofollow',
                    'value' => '1'
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('banner_nofollow'); ?></label>	
        </div> <!-- /control-group -->
        <div class="control-group">										
            <label class="form-control-static" for="active">
                <?php
                $data = array(
                    'name' => 'active',
                    'id' => 'active',
                    'value' => '1'
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('lang_active'); ?></label>	
        </div> <!-- /control-group -->
        <br>
        <div class="control-group">											
            <label class="control-label" for="photo"><?php echo $this->lang->line('banner_img'); ?></label>
            <div class="controls">
                <?php
                $data = array(
                    'name' => 'file_upload',
                    'id' => 'file_upload',
                    'class' => 'span5'
                );
                echo form_upload($data); ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
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
