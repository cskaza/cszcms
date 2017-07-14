<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-gift"></span></i> <?php echo $this->lang->line('user_group_txt') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('user_group_new') ?>  <a role="button" href="<?php echo $this->Csz_model->base_link() ?>/admin/groups/add" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo $this->lang->line('user_group_new') ?></a></div>
        <?php echo form_open($this->Csz_model->base_link(). '/admin/groups/update/' . $group->user_groups_id); ?>
        <div class="control-group">
            <?php echo form_error('name', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label h4" for="name"><b><?php echo $this->lang->line('user_group_name'); ?>*</b></label>
            <?php
            $data = array(
                'name' => 'name',
                'id' => 'name',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '100',
                'value' => set_value('name', $group->name, FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">
            <label class="control-label h4" for="definition"><b><?php echo $this->lang->line('user_group_definition'); ?></b></label>
            <?php
            $data = array(
                'name' => 'definition',
                'id' => 'definition',
                'class' => 'form-control',
                'value' => set_value('definition', $group->definition, FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <br>
        <div class="control-group">
            <label class="control-label h4"><b><?php echo $this->lang->line('user_permission_txt'); ?></b></label>
            <div class="row">
                <div class="col-md-6">
                    <label class="control-label"><?php echo $this->lang->line('user_backend_txt'); ?>:</label><br><br>
                    <div class="box box-body no-padding">
                        <table class="table table-hover table-striped">
                        <?php foreach($b_perms as $value){ 
                            if($this->Csz_auth_model->is_group_allowed($value['user_perms_id'], 'backend', $group->user_groups_id) !== FALSE){
                                $allowactive = ' active';
                                $denyactive = '';
                                $allowchk = ' checked';
                                $denychk = '';
                            }else{
                                $allowactive = '';
                                $denyactive = ' active';
                                $allowchk = '';
                                $denychk = ' checked';
                            }
                            ?>
                            <tr style="vertical-align: middle;">
                                <td width="55%">
                                    <label class="control-label"><?php echo ucfirst($value['name']); ?></label>
                                    <br><span class="remark"><em><?php echo $value['definition']; ?></em></span>
                                </td>
                                <td width="45%" class="text-right">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-primary<?php echo $denyactive ?>"><input type="radio" name="perms[<?php echo $value['user_perms_id']; ?>]" autocomplete="off" value="deny"<?php echo $denychk ?>><?php echo $this->lang->line('user_perm_deny'); ?></label>
                                        <label class="btn btn-primary<?php echo $allowactive ?>"><input type="radio" name="perms[<?php echo $value['user_perms_id']; ?>]" autocomplete="off" value="allow"<?php echo $allowchk ?>><?php echo $this->lang->line('user_perm_allow'); ?></label>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="control-label"><?php echo $this->lang->line('user_frontend_txt'); ?>:</label><br><br>
                    <div class="box box-body no-padding">
                        <table class="table table-hover table-striped">
                        <?php foreach($f_perms as $value){ 
                            if($this->Csz_auth_model->is_group_allowed($value['user_perms_id'], 'frontend', $group->user_groups_id) !== FALSE){
                                $fallowactive = ' active';
                                $fdenyactive = '';
                                $fallowchk = ' checked';
                                $fdenychk = '';
                            }else{
                                $fallowactive = '';
                                $fdenyactive = ' active';
                                $fallowchk = '';
                                $fdenychk = ' checked';
                            }
                            ?>
                            <tr style="vertical-align: middle;">
                                <td width="55%">
                                    <label class="control-label"><?php echo ucfirst($value['name']); ?></label>
                                    <br><span class="remark"><em><?php echo $value['definition']; ?></em></span>
                                </td>
                                <td width="45%" class="text-right">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-primary<?php echo $fdenyactive ?>"><input type="radio" name="perms[<?php echo $value['user_perms_id']; ?>]" autocomplete="off" value="deny"<?php echo $fdenychk ?>><?php echo $this->lang->line('user_perm_deny'); ?></label>
                                        <label class="btn btn-primary<?php echo $fallowactive ?>"><input type="radio" name="perms[<?php echo $value['user_perms_id']; ?>]" autocomplete="off" value="allow"<?php echo $fallowchk ?>><?php echo $this->lang->line('user_perm_allow'); ?></label>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
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
