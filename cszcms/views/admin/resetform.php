<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="text-center"><span style="font-size:36px;color:#ff6f00;font-family: 'Kaushan Script','Helvetica Neue',Helvetica,Arial,cursive;"><a href="<?php echo base_url()?>" target="_blank"><?php echo  $this->Headfoot_html->getLogo(); ?></a></span></div>
            <br><br><br>         
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h4 class="panel-title form-signin-heading"><?php echo  $this->lang->line('forgot_reset') ?></h4>
                </div>
                <div class="panel-body text-left">
                    <?php if(!$success_chk){ ?>
                    <b><?php echo $this->lang->line('forgot_email'); ?>: <?php echo $email?></b>
                    <?php echo form_open() ?>
                    <?php echo form_error('password', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                    <div class="form-group has-feedback">
                        <label for="password" class="control-label"><?php echo $this->lang->line('user_new_pass') ?>*</label>
                        <?php
                        $data = array(
                            'name' => 'password',
                            'id' => 'password',
                            'required' => 'required',
                            'autofocus' => 'true',
                            'class' => 'form-control',
                            'value' => set_value('password', '', FALSE),
                            'autocomplete' => 'off'
                        );
                        echo form_password($data);
                        ?>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div> <!-- /control-group -->
                    <?php echo form_error('con_password', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                    <div class="form-group has-feedback">
                        <label for="con_password" class="control-label"><?php echo $this->lang->line('user_new_confirm') ?>*</label>
                        <?php
                        $data = array(
                            'name' => 'con_password',
                            'id' => 'con_password',
                            'required' => 'required',
                            'autofocus' => 'true',
                            'class' => 'form-control',
                            'value' => set_value('con_password', '', FALSE),
                            'autocomplete' => 'off'
                        );
                        echo form_password($data);
                        ?>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div> <!-- /control-group -->
                    <br>
                    <button class="btn btn-lg btn-primary" type="submit" id="forget_submit"><?php echo $this->lang->line('forgot_btn'); ?></button> &nbsp;&nbsp; <a class="btn btn-lg" name="newsletter_cancel" id="contact_database_cancel" href="<?php echo  $this->Csz_model->base_link(). '/admin' ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
                    <?php echo  form_close() ?>
                    <?php }if($success_chk){ ?>
                        <center>
                            <p class="success"><?php echo $this->lang->line('forgot_complete'); ?></p>
                            <br>
                            <a class="btn btn-lg btn-primary" name="reset_back" id="reset_back" href="<?php echo $this->Csz_model->base_link(). '/admin'?>"><?php echo $this->lang->line('btn_back'); ?></a>
                        </center>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>