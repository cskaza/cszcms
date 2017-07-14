<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-globe"></span></i> <?php echo  $this->lang->line('lang_addnew') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('lang_addnew') ?>  <a role="button" href="<?php echo  $this->Csz_model->base_link() ?>/admin/lang/new" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('lang_addnew') ?></a></div>
        <?php echo form_open($this->Csz_model->base_link(). '/admin/lang/edited/'.$this->uri->segment(4)); ?>

        <div class="control-group">	
            <?php echo form_error('lang_name', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="lang_name"><?php echo $this->lang->line('lang_name'); ?>*</label>
            <?php
            $data = array(
                'name' => 'lang_name',
                'id' => 'lang_name',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('lang_name', $lang->lang_name)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->

        <div class="control-group">	
            <?php echo form_error('lang_iso', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
            <label class="control-label" for="lang_iso"><?php echo $this->lang->line('lang_iso'); ?>*</label>
            <?php
            $data = array(
                'name' => 'lang_iso',
                'id' => 'lang_iso',
                'required' => 'required',
                'autofocus' => 'true',
                'maxlength' => '2',
                'class' => 'form-control',
                'value' => set_value('lang_iso', $lang->lang_iso)
            );
            echo form_input($data);
            ?>			
            <span class="remark"><em><?php echo $this->lang->line('lang_iso_remark'); ?></em></span>
        </div> <!-- /control-group -->

        <div class="control-group">
            <?php echo form_error('country', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="country"><?php echo $this->lang->line('lang_country'); ?>*</label>
            <?php
            $data = array(
                'name' => 'country',
                'id' => 'country',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('country', $lang->country)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->

        <div class="control-group">	
            <?php echo form_error('country_iso', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="country_iso"><?php echo $this->lang->line('lang_country_iso'); ?>*</label>
            <?php
            $data = array(
                'name' => 'country_iso',
                'id' => 'country_iso',
                'required' => 'required',
                'autofocus' => 'true',
                'maxlength' => '2',
                'class' => 'form-control',
                'value' => set_value('country_iso', $lang->country_iso)
            );
            echo form_input($data);
            ?>			
            <span class="remark"><em><?php echo $this->lang->line('lang_countryiso_remark'); ?></em></span>
        </div> <!-- /control-group -->
        <br>
        <div class="control-group">										
            <label class="form-control-static" for="active">
            <?php
            if($lang->active){
                $checked = 'checked';
            }else{
                $checked = '';
            }
            $data = array(
                'name' => 'active',
                'id' => 'active',
                'value' => '1',
                'checked' => $checked
            );
            echo form_checkbox($data);
            ?> <?php echo $this->lang->line('lang_active'); ?></label>	
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
