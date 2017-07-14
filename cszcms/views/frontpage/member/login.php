<div class="container">
    <div class="row">
        <div class="col-md-3 hidden-sm hidden-xs"></div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <br><br><br>
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h4 class="panel-title form-signin-heading"><?php echo $this->Csz_model->getLabelLang('login_heading') ?></h4>
                </div>
                <div class="panel-body text-left">
                    <div class="text-center">
                    <?php
                    if ($error) {
                        echo '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        if ($error == 'INVALID') {
                            echo $this->Csz_model->getLabelLang('login_incorrect');
                        }
                        if ($error == 'CAPTCHA_WRONG') {
                            echo $this->Csz_model->getLabelLang('captcha_wrong');
                        }
                        if ($error == 'IP_BANNED') {
                            echo 'Your IP Address been banned!';
                        }
                        echo '</div>';
                    }
                    ?>
                    </div>
                    <?php echo form_open($this->Csz_model->base_link(). '/member/login/check') ?>
                    <div class="form-group has-feedback">
                        <label for="email" class="control-label"><?php echo $this->Csz_model->getLabelLang('login_email') ?>*</label>
                        <?php
                        $data = array(
                            'name' => 'email',
                            'id' => 'email',
                            'type' => 'email',
                            'class' => 'form-control',
                            'required' => 'required',
                            'autofocus' => 'true',
                            'value' => set_value('email'),
                            'placeholder' => $this->Csz_model->getLabelLang('login_email')
                        );
                        echo form_input($data);
                        ?>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="password" class="control-label"><?php echo $this->Csz_model->getLabelLang('login_password') ?>*</label>
                        <?php
                        $data = array(
                            'name' => 'password',
                            'id' => 'password',
                            'class' => 'form-control',
                            'required' => 'required',
                            'value' => set_value('password'),
                            'placeholder' => $this->Csz_model->getLabelLang('login_password'),
                            'autocomplete' => 'off'
                        );
                        echo form_password($data);
                        ?>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <br>
                    <div class="text-center"><?php echo $this->Csz_model->showCaptcha(); ?></div>
                    <br>
                    <button class="btn btn-lg btn-primary btn-block" type="submit" id="login_submit"><?php echo $this->Csz_model->getLabelLang('login_signin'); ?></button>
                    <?php echo form_close() ?>
                </div>
                <div class="panel-footer text-center"><?php if(!$config->member_close_regist){ ?><a href="<?php echo $this->Csz_model->base_link(); ?>/member/register"><?php echo $this->Csz_model->getLabelLang('login_register'); ?></a> &nbsp;&nbsp;|&nbsp;&nbsp; <?php } ?><a href="<?php echo $this->Csz_model->base_link(); ?>/member/forgot"><?php echo $this->Csz_model->getLabelLang('login_forgetpwd'); ?></a></div>
            </div>
        </div>
        <div class="col-md-3 hidden-sm hidden-xs"></div>
    </div>
</div>