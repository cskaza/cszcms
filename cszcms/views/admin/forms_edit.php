<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-globe"></span></i> <?php echo  $this->lang->line('forms_edit') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('forms_edit') ?>  <a role="button" href="<?php echo  $this->Csz_model->base_link() ?>/admin/forms/new" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('forms_addnew') ?></a></div>
        <?php echo form_open_multipart($this->Csz_model->base_link(). '/admin/forms/edited/'.$this->uri->segment(4)); ?>

        <div class="control-group">	
            <?php echo form_error('form_name', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="form_name"><?php echo $this->lang->line('forms_name'); ?>*</label>
            <input type="hidden" name="form_name_old" value="<?php echo $form_rs->form_name; ?>">
            <?php
            $data = array(
                'name' => 'form_name',
                'id' => 'form_name',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('form_name', $form_rs->form_name, FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->

        <div class="control-group">	
            <?php echo form_error('form_enctype', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
            <label class="control-label" for="form_enctype"><?php echo $this->lang->line('forms_enctype'); ?></label>
            <?php
            $data = array(
                'name' => 'form_enctype',
                'id' => 'form_enctype',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('form_enctype', $form_rs->form_enctype, FALSE)
            );
            echo form_input($data);
            ?>				
        </div> <!-- /control-group -->

        <div class="control-group">	
            <label class="control-label" for="form_method"><?php echo $this->lang->line('forms_method'); ?></label>
            <?php
            $att = 'id="form_method" class="form-control"';
            $data = array();
            $data['post'] = 'post';
            $data['get'] = 'get';
            echo form_dropdown('form_method', $data, $form_rs->form_method, $att);
            ?>	
        </div> <!-- /control-group -->
        
        <div class="control-group">	
            <?php echo form_error('success_txt', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
            <label class="control-label" for="success_txt"><?php echo $this->lang->line('forms_success_txt'); ?></label>
            <?php
            $data = array(
                'name' => 'success_txt',
                'id' => 'success_txt',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('success_txt', $form_rs->success_txt, FALSE)
            );
            echo form_input($data);
            ?>				
        </div> <!-- /control-group -->
        <div class="control-group">	
            <?php echo form_error('captchaerror_txt', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
            <label class="control-label" for="captchaerror_txt"><?php echo $this->lang->line('forms_captchaerror_txt'); ?></label>
            <?php
            $data = array(
                'name' => 'captchaerror_txt',
                'id' => 'captchaerror_txt',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('captchaerror_txt', $form_rs->captchaerror_txt, FALSE)
            );
            echo form_input($data);
            ?>				
        </div> <!-- /control-group -->
        <div class="control-group">	
            <?php echo form_error('error_txt', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
            <label class="control-label" for="error_txt"><?php echo $this->lang->line('forms_error_txt'); ?></label>
            <?php
            $data = array(
                'name' => 'error_txt',
                'id' => 'error_txt',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('error_txt', $form_rs->error_txt, FALSE)
            );
            echo form_input($data);
            ?>				
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="dont_repeat_field"><?php echo $this->lang->line('forms_dont_repeat_field'); ?></label>
            <?php
            $att = 'id="dont_repeat_field" class="form-control"';
            $data = array();
            $data[''] = $this->lang->line('option_choose');
            if(!empty($field_rs)){
                foreach ($field_rs as $field_val1) {
                    $data[$field_val1['field_name']] = $field_val1['field_name'];
                }
            }
            echo form_dropdown('dont_repeat_field', $data, $form_rs->dont_repeat_field, $att);
            ?>	
        </div> <!-- /control-group -->
        <div class="control-group">	
            <?php echo form_error('repeat_txt', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
            <label class="control-label" for="repeat_txt"><?php echo $this->lang->line('forms_repeat_txt'); ?></label>
            <?php
            $data = array(
                'name' => 'repeat_txt',
                'id' => 'repeat_txt',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('repeat_txt', $form_rs->repeat_txt, FALSE)
            );
            echo form_input($data);
            ?>				
        </div> <!-- /control-group -->
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <label class="checkbox-inline" style="width: 100%;">
                    <?php
                    ($form_rs->sendmail)?$checked = 'checked':$checked = '';
                    $data = array(
                        'name' => 'sendmail',
                        'id' => 'sendmail',
                        'onclick' => "ChkHideShow('chk-sendmail');",
                        'value' => '1',
                        'checked' => $checked
                    );
                    echo form_checkbox($data);
                    ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $this->lang->line('forms_sendmail'); ?></b>
                </label>
            </div>
            <div class="panel-body" id="chk-sendmail"<?php if(!$form_rs->sendmail){ ?> style="display: none;"<?php } ?>>
                <div class="control-group">	
                    <?php echo form_error('email', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
                    <label class="control-label" for="email"><?php echo $this->lang->line('forms_email'); ?></label>
                    <?php
                    $data = array(
                        'name' => 'email',
                        'id' => 'email',
                        'class' => 'form-control',
                        'maxlength' => '255',
                        'value' => set_value('email', $form_rs->email, FALSE)
                    );
                    echo form_input($data);
                    ?>				
                </div> <!-- /control-group -->

                <div class="control-group">	
                    <?php echo form_error('subject', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
                    <label class="control-label" for="subject"><?php echo $this->lang->line('forms_subject'); ?></label>
                    <?php
                    $data = array(
                        'name' => 'subject',
                        'id' => 'subject',
                        'class' => 'form-control',
                        'maxlength' => '255',
                        'value' => set_value('subject', $form_rs->subject, FALSE)
                    );
                    echo form_input($data);
                    ?>				
                </div> <!-- /control-group -->
            </div>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <label class="checkbox-inline" style="width: 100%;">
                    <?php
                    ($form_rs->send_to_visitor)?$checked = 'checked':$checked = '';
                    $data = array(
                        'name' => 'send_to_visitor',
                        'id' => 'send_to_visitor',
                        'onclick' => "ChkHideShow('chk-visitor');",
                        'value' => '1',
                        'checked' => $checked
                    );
                    echo form_checkbox($data);
                    ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $this->lang->line('forms_send_to_visitor'); ?></b>
                </label>
            </div>
            <div class="panel-body" id="chk-visitor"<?php if(!$form_rs->send_to_visitor){ ?> style="display: none;"<?php } ?>>
                <div class="control-group">
                    <?php echo form_error('email_field_id', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
                    <label class="control-label" for="email_field_id"><?php echo $this->lang->line('forms_email_field_name'); ?></label>
                    <?php
                    $att = 'id="email_field_id" class="form-control"';
                    $data = array();
                    $data[''] = $this->lang->line('option_choose');
                    if(!empty($field_email)){
                        foreach ($field_email as $lg) {
                            $data[$lg['form_field_id']] = $lg['field_name'];
                        }
                    }
                    echo form_dropdown('email_field_id', $data, $form_rs->email_field_id, $att);
                    ?>	
                </div> <!-- /control-group -->

                <div class="control-group">	
                    <?php echo form_error('visitor_subject', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
                    <label class="control-label" for="visitor_subject"><?php echo $this->lang->line('forms_visitor_subject'); ?></label>
                    <?php
                    $data = array(
                        'name' => 'visitor_subject',
                        'id' => 'visitor_subject',
                        'class' => 'form-control',
                        'maxlength' => '255',
                        'value' => set_value('visitor_subject', $form_rs->visitor_subject, FALSE)
                    );
                    echo form_input($data);
                    ?>				
                </div> <!-- /control-group -->
                <label class="control-label" for="visitor_body"><?php echo $this->lang->line('forms_visitor_body'); ?></label>
                <textarea name="visitor_body" id="visitor_body" class="form-control body-tinymce"><?php echo $form_rs->visitor_body ?></textarea>
            </div>
        </div>

        <div class="control-group">										
            <label class="form-control-static" for="active">
                <?php
                ($form_rs->active)?$checked = 'checked':$checked = '';
                $data = array(
                    'name' => 'active',
                    'id' => 'active',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('lang_active'); ?></label>	
        </div> <!-- /control-group -->
        <div class="control-group">										
            <label class="form-control-static" for="captcha">
                <?php
                ($form_rs->captcha)?$checked = 'checked':$checked = '';
                $data = array(
                    'name' => 'captcha',
                    'id' => 'captcha',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('forms_captcha'); ?></label>	
        </div> <!-- /control-group -->
        <div class="control-group">										
            <label class="form-control-static" for="save_to_db">
                <?php
                ($form_rs->save_to_db)?$checked = 'checked':$checked = '';
                $data = array(
                    'name' => 'save_to_db',
                    'id' => 'save_to_db',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('forms_save_to_db'); ?></label>	
        </div> <!-- /control-group -->
        <div class="h2 sub-header"><?php echo  $this->lang->line('field_editheader') ?></div>
        <div class="addfields">
            <?php if(!empty($field_rs)){ ?>
            <div class="ui-sortable">
                <?php foreach ($field_rs as $field_val) { ?>    
                    <div class="panel panel-primary ui-state-default">
                        <div class="panel-body row">
                            <div class="col-md-12">
                                <i class="glyphicon glyphicon-sort"></i><br>
                                <input type="hidden" name="form_field_id[]" id="form_field_id" value="<?php echo $field_val['form_field_id']?>">
                                <div class="control-group">
                                    <label class="control-label" for="field_type1"><?php echo $this->lang->line('field_type'); ?></label>
                                    <?php
                                    $att = 'id="field_type1" class="form-control"';
                                    $data = array();
                                    $data['button'] = 'button';
                                    $data['checkbox'] = 'checkbox';
                                    $data['datepicker'] = 'datepicker';
                                    $data['timepicker'] = 'timepicker';
                                    $data['number'] = 'number';
                                    $data['email'] = 'email';
                                    $data['file'] = 'file';
                                    $data['label'] = 'label';
                                    $data['password'] = 'password';
                                    $data['reset'] = 'reset';
                                    $data['submit'] = 'submit';
                                    $data['selectbox'] = 'selectbox';
                                    $data['text'] = 'text';
                                    $data['textarea'] = 'textarea';
                                    echo form_dropdown('field_type1[]', $data, $field_val['field_type'], $att);
                                    ?>
                                    <input type="hidden" name="field_oldtype[]" id="field_oldtype" value="<?php echo $field_val['field_type']?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">	
                                    <label class="control-label" for="field_div_class1"><?php echo $this->lang->line('field_div_class'); ?></label>
                                    <input type="text" name="field_div_class1[]" id="field_div_class1" class="form-control" maxlength="255" value="<?php echo $field_val['field_div_class']?>">
                                </div>
                                <div class="control-group">	
                                    <label class="control-label" for="field_name1"><?php echo $this->lang->line('field_name'); ?>*</label>
                                    <input type="text" name="field_name1[]" id="field_name1" class="form-control" maxlength="255" value="<?php echo $field_val['field_name']?>" required="required">
                                    <input type="hidden" name="field_oldname[]" id="field_oldname" value="<?php echo $field_val['field_name']?>">
                                </div>
                                <div class="control-group">	
                                    <label class="control-label" for="field_id1"><?php echo $this->lang->line('field_id'); ?></label>
                                    <input type="text" name="field_id1[]" id="field_id1" class="form-control" maxlength="255" value="<?php echo $field_val['field_id']?>">
                                </div>
                                <div class="control-group">	
                                    <label class="control-label" for="field_class1"><?php echo $this->lang->line('field_class'); ?></label>
                                    <input type="text" name="field_class1[]" id="field_class1" class="form-control" maxlength="255" value="<?php echo $field_val['field_class']?>">
                                </div>
                                <div class="control-group">	
                                    <label class="control-label" for="field_placeholder1"><?php echo $this->lang->line('field_placeholder'); ?></label>
                                    <input type="text" name="field_placeholder1[]" id="field_placeholder1" class="form-control" maxlength="255" value="<?php echo $field_val['field_placeholder']?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">	
                                    <label class="control-label" for="field_value1"><?php echo $this->lang->line('field_value'); ?></label>
                                    <input type="text" name="field_value1[]" id="field_value1" class="form-control" maxlength="255" value="<?php echo $field_val['field_value']?>">
                                </div>
                                <div class="control-group">	
                                    <label class="control-label" for="field_label1"><?php echo $this->lang->line('field_label'); ?></label>
                                    <input type="text" name="field_label1[]" id="field_label1" class="form-control" maxlength="255" value="<?php echo $field_val['field_label']?>">
                                </div>
                                <div class="control-group">	
                                    <label class="control-label" for="sel_option_val1"><?php echo $this->lang->line('sel_option_val'); ?></label>
                                    <input type="text" name="sel_option_val1[]" id="sel_option_val1" class="form-control" value="<?php echo $field_val['sel_option_val']?>">
                                    <span class="remark"><em><?php echo $this->lang->line('sel_option_val_info'); ?></em></span>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="field_required1"><?php echo $this->lang->line('field_require'); ?></label>
                                    <?php
                                    $att = 'id="field_required1" class="form-control"';
                                    $data = array();
                                    $data['0'] = 'No';
                                    $data['1'] = 'Yes';
                                    echo form_dropdown('field_required1[]', $data, $field_val['field_required'], $att);
                                    ?>
                                </div>
                                <br>
                                <div class="control-group text-right">
                                    <a class="btn btn-danger" role="button" onclick="return confirm('<?php echo $this->lang->line('forms_delete_msg')?>')" href="<?php echo $this->Csz_model->base_link().'/admin/forms/deleteField/'.$form_rs->form_main_id.'/'.$field_val['form_field_id']?>">
                                        <span class="glyphicon glyphicon-minus"></span>
                                    </a>
                                </div>
                            </div>                   
                        </div>
                    </div>
                <?php } ?>
                </div>
            <?php } ?>
            <div class="entry panel panel-default">
                <div class="panel-body row">
                    <div class="col-md-12">
                        <div class="control-group">
                            <label class="control-label" for="field_type"><?php echo $this->lang->line('field_type'); ?></label>
                            <select id="field_type" name="field_type[]" class="form-control">
                                <option value="button">button</option>
                                <option value="checkbox">checkbox</option>
                                <option value="datepicker">datepicker</option>
                                <option value="timepicker">timepicker</option>
                                <option value="number">number</option>
                                <option value="email">email</option>
                                <option value="file">file</option>
                                <option value="label">label</option>
                                <option value="password">password</option>
                                <option value="reset">reset</option>
                                <option value="submit">submit</option>
                                <option value="selectbox">selectbox</option>
                                <option value="text">text</option>
                                <option value="textarea">textarea</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="control-group">	
                            <label class="control-label" for="field_div_class"><?php echo $this->lang->line('field_div_class'); ?></label>
                            <input type="text" name="field_div_class[]" id="field_div_class" class="form-control" maxlength="255">
                        </div>
                        <div class="control-group">	
                            <label class="control-label" for="field_name"><?php echo $this->lang->line('field_name'); ?>*</label>
                            <input type="text" name="field_name[]" id="field_name" class="form-control" maxlength="255">
                        </div>
                        <div class="control-group">	
                            <label class="control-label" for="field_id"><?php echo $this->lang->line('field_id'); ?></label>
                            <input type="text" name="field_id[]" id="field_id" class="form-control" maxlength="255">
                        </div>
                        <div class="control-group">	
                            <label class="control-label" for="field_class"><?php echo $this->lang->line('field_class'); ?></label>
                            <input type="text" name="field_class[]" id="field_class" class="form-control" maxlength="255">
                        </div>
                        <div class="control-group">	
                            <label class="control-label" for="field_placeholder"><?php echo $this->lang->line('field_placeholder'); ?></label>
                            <input type="text" name="field_placeholder[]" id="field_placeholder" class="form-control" maxlength="255">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="control-group">	
                            <label class="control-label" for="field_value"><?php echo $this->lang->line('field_value'); ?></label>
                            <input type="text" name="field_value[]" id="field_value" class="form-control" maxlength="255">
                        </div>
                        <div class="control-group">	
                            <label class="control-label" for="field_label"><?php echo $this->lang->line('field_label'); ?></label>
                            <input type="text" name="field_label[]" id="field_label" class="form-control" maxlength="255">
                        </div>
                        <div class="control-group">	
                            <label class="control-label" for="sel_option_val"><?php echo $this->lang->line('sel_option_val'); ?></label>
                            <input type="text" name="sel_option_val[]" id="sel_option_val" class="form-control">
                            <span class="remark"><em><?php echo $this->lang->line('sel_option_val_info'); ?></em></span>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="field_required"><?php echo $this->lang->line('field_require'); ?></label>
                            <select id="field_required" name="field_required[]" class="form-control">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <br>
                        <div class="control-group text-right">
                            <button class="btn btn-success btn-fields-add" type="button">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
        <div class="text-right"><?php echo $this->lang->line('field_addtxtinfo')?></div>
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