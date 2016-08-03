<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-user"></span></i> <?php echo  $this->lang->line('user_edit_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('user_edit_header') ?>  <a role="button" href="<?php echo  BASE_URL ?>/admin/users/new" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('user_addnew') ?></a></div>
        <?php echo form_open_multipart(BASE_URL.'/admin/users/edited/'.$this->uri->segment(4)); ?>
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
                $data['member'] = 'Member';
                echo form_dropdown('user_type', $data, $users->user_type, $att);
            ?>		
        </div> <!-- /control-group -->
        <br>
        <div class="control-group">										
            <label class="form-control-static" for="backend_visitor">
            <?php
            if($users->backend_visitor){
                $checked = 'checked';
            }else{
                $checked = '';
            }
            $data = array(
                'name' => 'backend_visitor',
                'id' => 'backend_visitor',
                'value' => '1',
                'checked' => $checked               
            );
            if($this->uri->segment(4) == '1' || $this->session->userdata('admin_type') == 'editor' || $this->session->userdata('user_admin_id') == $this->uri->segment(4)){
                $data['disabled'] = 'disabled';
            }
            echo form_checkbox($data);
            ?> <?php echo $this->lang->line('user_backend_visitor'); ?></label> &nbsp; <span class="remark">(<?php echo $this->lang->line('user_notapply_member'); ?>)</span>
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
            if($this->uri->segment(4) == '1' || $this->session->userdata('admin_type') == 'editor' || $this->session->userdata('user_admin_id') == $this->uri->segment(4)){
                $data['disabled'] = 'disabled';
            }
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
                'value' => set_value('first_name', $users->first_name, FALSE)
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
                'value' => set_value('last_name', $users->last_name, FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">										
            <label class="control-label" for="birthday"><?php echo $this->lang->line('user_birthday'); ?></label><br>
            <?php
                list($year,$month,$day) = explode('-', $users->birthday);
                $att = 'id="year" class="form-control-static" ';
                $data = array();
                $data[''] = $this->lang->line('year_txt');
                for($i=(date('Y')-90);$i<=(date('Y')-12);$i++) {
                    $data[$i] = $i;
                }
                echo form_dropdown('year', $data, $year, $att);
            ?> - 
            <?php
                $att = 'id="month" class="form-control-static" ';
                $data = array();
                $data[''] = $this->lang->line('month_txt');
                for($i=1;$i<=12;$i++) {
                    $i = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $data[$i] = $i;
                }
                echo form_dropdown('month', $data, $month, $att);
            ?> - 
            <?php
                $att = 'id="day" class="form-control-static" ';
                $data = array();
                $data[''] = $this->lang->line('day_txt');
                for($i=1;$i<=31;$i++) {
                    $i = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $data[$i] = $i;
                }
                echo form_dropdown('day', $data, $day, $att);
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
                echo form_dropdown('gender', $data, $users->gender, $att);
            ?>	
        </div> <!-- /control-group -->
        <div class="control-group">
            <label class="control-label" for="address"><?php echo $this->lang->line('user_address'); ?></label>
            <textarea name="address" id="address" class="form-control"><?php echo $users->address; ?></textarea>
        </div> <!-- /control-group -->
        <div class="control-group">										
            <label class="control-label" for="phone"><?php echo $this->lang->line('user_phone'); ?></label>
            <?php
            $data = array(
                'name' => 'phone',
                'id' => 'phone',
                'maxlength' => '100',
                'class' => 'form-control',
                'value' => set_value('phone', $users->phone, FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <br>
        <div class="control-group">											
            <label class="control-label" for="picture"><?php echo $this->lang->line('user_picture'); ?></label>
            <div class="controls">
                <div><img src="<?php
                              if ($users->picture != "") {
                                  echo BASE_URL . '/photo/profile/' . $users->picture;
                              }
                              ?>" id="logo_preloaded" <?php
                    if ($users->picture == "") {
                        echo "style='display:none;'";
                    }
                    ?> width="50%"></div>
                    <?php if ($users->picture != "") { ?><label for="del_file"><input type="checkbox" name="del_file" id="del_file" value="<?php echo $users->picture?>"> <span class="remark">Delete File</span></label><?php } ?>
                    <img src="<?php echo BASE_URL; ?>templates/admin/imgs/ajax-loader.gif" style="margin:-7px 5px 0 5px;display:none;" id="loading_pic" />
                    <?php
                    $data = array(
                        'name' => 'file_upload',
                        'id' => 'file_upload',
                        'class' => 'span5'
                    );
                    echo form_upload($data);
                    ?>
                <input type="hidden" id="picture" name="picture" value="<?php echo $users->picture?>"/>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <br>
        <div class="control-group">		
            <?php echo form_error('cur_password', '<div class="error">', '</div>'); ?>									
            <label class="control-label" for="cur_password"><?php echo $this->lang->line('user_cur_pass'); ?>*</label>
            <?php
            $data = array(
                'name' => 'cur_password',
                'id' => 'cur_password',
                'class' => 'form-control',
                'required' => 'required',
                'value' => set_value('cur_password')
            );
            echo form_password($data);
            ?>			
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
