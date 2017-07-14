<?php $row = $this->Csz_model->load_config(); ?>
<div class="container">
    <div class="row">
        <div class="col-md-3 hidden-sm hidden-xs"></div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <center><span style="font-size:36px;color:#ff6f00;"><a href="<?php echo $this->Csz_model->base_link() ?>" target="_blank"><?php echo $this->Headfoot_html->getLogo(); ?></a></span></center>
            <br><br>
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h4 class="panel-title form-signin-heading"><?php echo $this->lang->line('login_heading') ?></h4>
                </div>
                <div class="panel-body text-left">
                    <div class="text-center">
                    <?php
                    if ($error) {
                        echo '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        if ($error == 'INVALID') {
                            echo $this->lang->line('login_incorrect');
                        }
                        if ($error == 'CAPTCHA_WRONG') {
                            echo $this->lang->line('captcha_wrong');
                        }
                        if ($error == 'IP_BANNED') {
                            echo $this->lang->line('bf_ip_banned_alert');
                        }
                        echo '</div>';
                    }
                    ?>
                    </div>
                    <?php echo form_open($this->Csz_model->base_link(). '/admin/login/check') ?>
                    <?php echo form_error('email', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                    <div class="form-group has-feedback">
                        <label for="email" class="control-label"><?php echo $this->lang->line('login_email') ?>*</label>
                        <?php
                        $data = array(
                            'name' => 'email',
                            'id' => 'email',
                            'type' => 'email',
                            'class' => 'form-control',
                            'required' => 'required',
                            'autofocus' => 'true',
                            'value' => set_value('email'),
                            'placeholder' => $this->lang->line('login_email')
                        );
                        echo form_input($data);
                        ?>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <?php echo form_error('password', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                    <div class="form-group has-feedback">
                        <label for="password" class="control-label"><?php echo $this->lang->line('login_password') ?>*</label>
                        <?php
                        $data = array(
                            'name' => 'password',
                            'id' => 'password',
                            'class' => 'form-control',
                            'required' => 'required',
                            'value' => set_value('password'),
                            'placeholder' => $this->lang->line('login_password'),
                            'autocomplete' => 'off'
                        );
                        echo form_password($data);
                        ?>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <br>
                    <div class="text-center"><?php echo $this->Csz_model->showCaptcha(); ?></div>
                    <br>
                    <button class="btn btn-lg btn-primary btn-block" type="submit" id="login_submit"><?php echo $this->lang->line('login_signin'); ?></button>
                    <?php echo form_close() ?>
                </div>
                <div class="panel-footer text-center"><a href="<?php echo $this->Csz_model->base_link(); ?>/admin/user/forgot"><?php echo $this->lang->line('login_forgetpwd'); ?></a></div>
            </div>
        </div>
        <div class="col-md-3 hidden-sm hidden-xs"></div>
    </div>
</div>