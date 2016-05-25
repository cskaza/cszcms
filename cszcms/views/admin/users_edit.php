<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-user"></span></i> <?= $this->lang->line('user_edit_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?= $this->lang->line('user_edit_header') ?>  <a role="button" href="<?= BASE_URL ?>/admin/users/new" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?= $this->lang->line('user_addnew') ?></a></div>
        <? echo form_open(BASE_URL.'/admin/users/edited/'.$this->uri->segment(4)); ?>

        <div class="control-group">										
            <label class="control-label" for="name"><?php echo $this->lang->line('user_new_name'); ?>*</label>
            <?php
            $data = array(
                'name' => 'name',
                'id' => 'name',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'value' => set_value('name', $users->name)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->

        <div class="control-group">		
            <?php echo form_error('email', '<div class="error">', '</div>'); ?>									
            <label class="control-label" for="email"><?php echo $this->lang->line('user_new_email'); ?>*</label>
            <?php
            $data = array(
                'name' => 'email',
                'id' => 'email',
                'type' => 'email',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'value' => set_value('email', $users->email)
            );
            echo form_input($data);
            ?>				
        </div> <!-- /control-group -->

        <div class="control-group">		
            <?php echo form_error('password', '<div class="error">', '</div>'); ?>									
            <label class="control-label" for="password"><?php echo $this->lang->line('user_new_pass'); ?></label>
            <?php
            $data = array(
                'name' => 'password',
                'id' => 'password',
                'class' => 'form-control',
                'value' => set_value('password')
            );
            echo form_password($data);
            ?>			
        </div> <!-- /control-group -->

        <div class="control-group">	
            <?php echo form_error('con_password', '<div class="error">', '</div>'); ?>									
            <label class="control-label" for="con_password"><?php echo $this->lang->line('user_new_confirm'); ?></label>
            <?php
            $data = array(
                'name' => 'con_password',
                'id' => 'con_password',
                'class' => 'form-control',
                'value' => set_value('con_password')
            );
            echo form_password($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">										
            <label class="control-label" for="user_type"><?php echo $this->lang->line('user_new_type'); ?></label>
            <?php
                $att = 'id="user_type" class="form-control"';
                if($this->uri->segment(4) == '1' || $this->session->userdata('admin_type') == 'editor'){
                    $att.= ' disabled="disabled"';
                }
                $data = array();
                $data['admin'] = 'Admin';
                $data['editor'] = 'Editor';
                echo form_dropdown('user_type', $data, $users->user_type, $att);
            ?>		
        </div> <!-- /control-group -->
        <br>
        <div class="control-group">										
            <label class="form-control-static" for="active">
            <?php
            if($users->active){
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
            ?> <?php echo $this->lang->line('user_new_active'); ?></label>	
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
            <a class="btn btn-lg" href="<?php echo BASE_URL; ?>/admin/users"><?php echo $this->lang->line('btn_cancel'); ?></a>
        </div> <!-- /form-actions -->
        <?php echo form_close(); ?>
        <!-- /widget-content --> 
    </div>
</div>
