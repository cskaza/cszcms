<?php $row = $this->Csz_model->load_config(); ?>
<div class="container">
    <div class="row">
        <div class="col-md-3 hidden-sm hidden-xs"></div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="text-center"><span style="font-size:36px;color:#ff6f00;font-family: 'Kaushan Script','Helvetica Neue',Helvetica,Arial,cursive;"><a href="<?php echo BASE_URL ?>" target="_blank"><?php echo $this->Headfoot_html->getLogo(); ?></a></span></div>
            <br><br>
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h4 class="panel-title form-signin-heading"><?php echo $this->lang->line('login_heading') ?></h4>
                </div>
                <div class="panel-body text-left">
                    <div class="text-center">
                    <?php
                    if ($error) {
                        if ($error == 'INVALID') {
                            echo "<span class=\"error\">" . $this->lang->line('login_incorrect') . "</span><br><br>";
                        }
                        if ($error == 'CAPTCHA_WRONG') {
                            echo "<span class=\"error\">" . $this->lang->line('captcha_wrong') . "</span><br><br>";
                        }
                    }
                    ?>
                    </div>
                    <?php echo form_open(BASE_URL . '/admin/login/check') ?>
                    <label for="email" class="sr-only"><?php echo $this->lang->line('login_email') ?></label>
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
                    <label for="password" class="sr-only"><?php echo $this->lang->line('login_password') ?>:</label>
                    <?php
                    $data = array(
                        'name' => 'password',
                        'id' => 'password',
                        'class' => 'form-control',
                        'required' => 'required',
                        'value' => set_value('password'),
                        'placeholder' => $this->lang->line('login_password')
                    );
                    echo form_password($data);
                    ?>
                    <br>
                    <div class="text-center"><?php echo $this->Csz_model->showCaptcha(); ?></div>
                    <br>
                    <button class="btn btn-lg btn-primary btn-block" type="submit" id="login_submit"><?php echo $this->lang->line('login_signin'); ?></button>
                    <?php echo form_close() ?>
                </div>
                <div class="panel-footer text-center"><a href="<?php echo BASE_URL; ?>/admin/user/forgot"><?php echo $this->lang->line('login_forgetpwd'); ?></a></div>
            </div>
        </div>
        <div class="col-md-3 hidden-sm hidden-xs"></div>
    </div>
</div>