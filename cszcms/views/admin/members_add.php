<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-user"></span></i> <?php echo  $this->lang->line('user_member_txt') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('user_addnew') ?>  <a role="button" href="<?php echo  $this->Csz_model->base_link() ?>/admin/members/new" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('user_addnew') ?></a></div>
        <?php echo form_open_multipart($this->Csz_model->base_link(). '/admin/members/new/add'); ?>
        <div class="control-group">
            <?php echo form_error('name', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="name"><?php echo $this->lang->line('user_new_name'); ?>*</label>
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
            <?php echo form_error('email', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
            <label class="control-label" for="email"><?php echo $this->lang->line('user_new_email'); ?>*</label>
            <?php
            $data = array(
                'name' => 'email',
                'id' => 'email',
                'type' => 'email',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('email', '', FALSE)
            );
            echo form_input($data);
            ?>				
        </div> <!-- /control-group -->

        <div class="control-group">		
            <?php echo form_error('password', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
            <label class="control-label" for="password"><?php echo $this->lang->line('user_new_pass'); ?>*</label>
            <?php
            $data = array(
                'name' => 'password',
                'id' => 'password',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('password', '', FALSE),
                'autocomplete' => 'off'
            );
            echo form_password($data);
            ?>			
        </div> <!-- /control-group -->

        <div class="control-group">	
            <?php echo form_error('con_password', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
            <label class="control-label" for="con_password"><?php echo $this->lang->line('user_new_confirm'); ?>*</label>
            <?php
            $data = array(
                'name' => 'con_password',
                'id' => 'con_password',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('con_password', '', FALSE),
                'autocomplete' => 'off'
            );
            echo form_password($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="group"><?php echo $this->lang->line('user_group_txt'); ?>*</label>
            <?php
                $att = 'id="group" class="form-control"';
                $data = array();
                if (!empty($group)) {
                    foreach ($group as $lg) {
                        $data[$lg['user_groups_id']] = $lg['name'];
                    }
                }
                echo form_dropdown('group', $data, '', $att);
            ?>	
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="pass_change"><?php echo $this->lang->line('user_req_changepwd'); ?>*</label>
            <?php
                $att = 'id="pass_change" class="form-control"';
                $data = array();
                $data['yes'] = $this->lang->line('option_yes');
                $data['no'] = $this->lang->line('option_no');
                echo form_dropdown('pass_change', $data, '', $att);
            ?>	
        </div> <!-- /control-group -->
        <br>
        <div class="control-group">										
            <label class="form-control-static" for="active">
            <?php
            $data = array(
                'name' => 'active',
                'id' => 'active',
                'value' => '1'
            );
            echo form_checkbox($data);
            ?> <?php echo $this->lang->line('user_new_active'); ?></label>	
        </div> <!-- /control-group -->
        <hr>
        <div class="control-group">										
            <label class="control-label" for="first_name"><?php echo $this->lang->line('user_first_name'); ?></label>
            <?php
            $data = array(
                'name' => 'first_name',
                'id' => 'first_name',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('first_name', '', FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">										
            <label class="control-label" for="last_name"><?php echo $this->lang->line('user_last_name'); ?></label>
            <?php
            $data = array(
                'name' => 'last_name',
                'id' => 'last_name',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('last_name', '', FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">										
            <label class="control-label" for="birthday"><?php echo $this->lang->line('user_birthday'); ?></label><br>
            <?php
                $att = 'id="year" class="form-control-static" ';
                $data = array();
                $data[''] = $this->lang->line('year_txt');
                for($i=(date('Y')-90);$i<=(date('Y')-12);$i++) {
                    $data[$i] = $i;
                }
                echo form_dropdown('year', $data, '', $att);
            ?> - 
            <?php
                $att = 'id="month" class="form-control-static" ';
                $data = array();
                $data[''] = $this->lang->line('month_txt');
                for($i=1;$i<=12;$i++) {
                    $i = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $data[$i] = $i;
                }
                echo form_dropdown('month', $data, '', $att);
            ?> - 
            <?php
                $att = 'id="day" class="form-control-static" ';
                $data = array();
                $data[''] = $this->lang->line('day_txt');
                for($i=1;$i<=31;$i++) {
                    $i = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $data[$i] = $i;
                }
                echo form_dropdown('day', $data, '', $att);
            ?>
        </div> <!-- /control-group -->
        <div class="control-group">										
            <label class="control-label" for="gender"><?php echo $this->lang->line('user_gender'); ?></label>
            <?php
                $att = 'id="gender" class="form-control" ';
                $data = array();
                $data[''] = $this->lang->line('option_choose');
                $data['male'] = 'Male';
                $data['female'] = 'Female';
                echo form_dropdown('gender', $data, '', $att);
            ?>	
        </div> <!-- /control-group -->
        <div class="control-group">
            <label class="control-label" for="address"><?php echo $this->lang->line('user_address'); ?></label>
            <textarea name="address" id="address" class="form-control"></textarea>
        </div> <!-- /control-group -->
        <div class="control-group">										
            <label class="control-label" for="phone"><?php echo $this->lang->line('user_phone'); ?></label>
            <?php
            $data = array(
                'name' => 'phone',
                'id' => 'phone',
                'maxlength' => '100',
                'class' => 'form-control',
                'value' => set_value('phone', '', FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <br>
        <div class="control-group">											
            <label class="control-label" for="picture"><?php echo $this->lang->line('user_picture'); ?></label>
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
