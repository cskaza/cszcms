<div class="container">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="h2 sub-header"><?php echo $this->Csz_model->getLabelLang('member_dashboard_text') ?></div>
            <hr>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-3">
            <?php echo $this->Headfoot_html->memberleftMenu(); ?>
        </div>
        <div class="col-md-9">         
            <div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-edit"></i> <?php echo $this->Csz_model->getLabelLang('edit_profile') ?></b></div>
                <div class="panel-body text-left">
                    <?php echo form_open_multipart($this->Csz_model->base_link().'/member/edit/save'); ?>
                    <div class="control-group">	
                        <?php echo form_error('name', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                        <label class="control-label" for="name"><?php echo $this->Csz_model->getLabelLang('display_name'); ?>*</label>
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
                        <?php echo form_error('email', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
                        <label class="control-label" for="email"><?php echo $this->Csz_model->getLabelLang('email_address'); ?>*</label>
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
                    <br>
                    <div class="panel panel-default">
                        <div class="panel-heading" onclick="ChkHideShow('newpassword');"><a href="#"><b><?php echo $this->Csz_model->getLabelLang('change_password'); ?></b></a></div>
                        <div class="panel-body" id="newpassword" style="display:none;">
                            <div class="control-group">		
                                <?php echo form_error('password', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
                                <label class="control-label" for="password"><?php echo $this->Csz_model->getLabelLang('new_password'); ?></label>
                                <?php
                                $data = array(
                                    'name' => 'password',
                                    'id' => 'password',
                                    'class' => 'form-control',
                                    'value' => set_value('password'),
                                    'autocomplete' => 'off'
                                );
                                echo form_password($data);
                                ?>			
                            </div> <!-- /control-group -->

                            <div class="control-group">	
                                <?php echo form_error('con_password', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
                                <label class="control-label" for="con_password"><?php echo $this->Csz_model->getLabelLang('confirm_password'); ?></label>
                                <?php
                                $data = array(
                                    'name' => 'con_password',
                                    'id' => 'con_password',
                                    'class' => 'form-control',
                                    'value' => set_value('con_password'),
                                    'autocomplete' => 'off'
                                );
                                echo form_password($data);
                                ?>			
                            </div> <!-- /control-group -->
                        </div>
                    </div>
                    <hr>
                    <div class="control-group">										
                        <label class="control-label" for="first_name"><?php echo $this->Csz_model->getLabelLang('first_name'); ?></label>
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
                        <label class="control-label" for="last_name"><?php echo $this->Csz_model->getLabelLang('last_name'); ?></label>
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
                        <label class="control-label" for="birthday"><?php echo $this->Csz_model->getLabelLang('birthday'); ?></label><br>
                        <?php
                            if($users->birthday === NULL) $users->birthday = '0000-00-00';
                            list($year,$month,$day) = explode('-', $users->birthday);
                            $att = 'id="year" class="form-control-static" ';
                            $data = array();
                            $data[''] = 'Year';
                            for($i=(date('Y')-90);$i<=(date('Y')-12);$i++) {
                                $data[$i] = $i;
                            }
                            echo form_dropdown('year', $data, $year, $att);
                        ?> - 
                        <?php
                            $att = 'id="month" class="form-control-static" ';
                            $data = array();
                            $data[''] = 'Month';
                            for($i=1;$i<=12;$i++) {
                                $i = str_pad($i, 2, '0', STR_PAD_LEFT);
                                $data[$i] = $i;
                            }
                            echo form_dropdown('month', $data, $month, $att);
                        ?> - 
                        <?php
                            $att = 'id="day" class="form-control-static" ';
                            $data = array();
                            $data[''] = 'Day';
                            for($i=1;$i<=31;$i++) {
                                $i = str_pad($i, 2, '0', STR_PAD_LEFT);
                                $data[$i] = $i;
                            }
                            echo form_dropdown('day', $data, $day, $att);
                        ?>
                    </div> <!-- /control-group -->
                    <div class="control-group">										
                        <label class="control-label" for="gender"><?php echo $this->Csz_model->getLabelLang('gender'); ?></label>
                        <?php
                            $att = 'id="gender" class="form-control" ';
                            $data = array();
                            $data[''] = '-- Please Choose --';
                            $data['male'] = 'Male';
                            $data['female'] = 'Female';
                            echo form_dropdown('gender', $data, $users->gender, $att);
                        ?>	
                    </div> <!-- /control-group -->
                    <div class="control-group">
                        <label class="control-label" for="address"><?php echo $this->Csz_model->getLabelLang('address'); ?></label>
                        <textarea name="address" id="address" class="form-control"><?php echo $users->address; ?></textarea>
                    </div> <!-- /control-group -->
                    <div class="control-group">										
                        <label class="control-label" for="phone"><?php echo $this->Csz_model->getLabelLang('phone'); ?></label>
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
                        <label class="control-label" for="picture"><?php echo $this->Csz_model->getLabelLang('picture'); ?></label>
                        <div class="controls">
                            <div><img src="<?php
                                          if ($users->picture != "") {
                                              echo base_url() . 'photo/profile/' . $users->picture;
                                          }
                                          ?>" id="logo_preloaded" <?php
                                if ($users->picture == "") {
                                    echo "style='display:none;'";
                                }
                                ?> width="50%"></div>
                                <?php if ($users->picture != "") { ?><label for="del_file"><input type="checkbox" name="del_file" id="del_file" value="<?php echo $users->picture?>"> <span class="remark">Delete File</span></label><?php } ?>                              
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
                        <?php echo form_error('cur_password', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
                        <label class="control-label" for="cur_password"><?php echo $this->Csz_model->getLabelLang('login_password'); ?>*</label>
                        <?php
                        $data = array(
                            'name' => 'cur_password',
                            'id' => 'cur_password',
                            'class' => 'form-control',
                            'required' => 'required',
                            'value' => set_value('cur_password'),
                            'autocomplete' => 'off'
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
                            'value' => $this->Csz_model->getLabelLang('save_btn'),
                        );
                        echo form_submit($data);
                        ?> 
                        <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex('member'); ?>"><?php echo $this->Csz_model->getLabelLang('cancel_btn'); ?></a>
                    </div> <!-- /form-actions -->
                    <?php echo form_close(); ?>
                    <!-- /widget-content --> 
                </div>
            </div>
        </div>
    </div>
</div>