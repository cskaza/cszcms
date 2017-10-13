<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <br><br><br>         
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h4 class="panel-title form-signin-heading"><?php echo $this->Csz_model->getLabelLang('login_forgetpwd') ?></h4>
                </div>
                <div class="panel-body text-left">
                    <?php if(!$success_chk){ ?>
                    <b><?php echo $this->Csz_model->getLabelLang('login_email'); ?>: <?php echo $email?></b>
                    <?php echo form_open() ?>
                    <?php echo form_error('password', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                    <div class="form-group has-feedback">
                        <label for="password" class="control-label"><?php echo $this->Csz_model->getLabelLang('new_password') ?>*</label>
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
                        <label for="con_password" class="control-label"><?php echo $this->Csz_model->getLabelLang('confirm_password') ?>*</label>
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
                    <center><button class="btn btn-primary" type="submit" id="forget_submit"><?php echo $this->Csz_model->getLabelLang('member_reset_btn'); ?></button> &nbsp;&nbsp; <a class="btn btn-default" name="newsletter_cancel" id="contact_database_cancel" href="<?php echo $this->Csz_model->base_link(). '/member' ?>"><?php echo $this->Csz_model->getLabelLang('btn_cancel'); ?></a></center>
                    <?php echo  form_close() ?>
                    <?php }if($success_chk){ ?>
                        <center>
                            <p class="success"><?php echo $this->Csz_model->getLabelLang('member_forgot_complete'); ?></p>
                            <br>
                            <a class="btn btn-lg btn-primary" name="reset_back" id="reset_back" href="<?php echo $this->Csz_model->base_link(). '/member'?>"><?php echo $this->Csz_model->getLabelLang('btn_back'); ?></a>
                        </center>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>