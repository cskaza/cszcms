<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="text-center"><span style="font-size:36px;color:#ff6f00;font-family: 'Kaushan Script','Helvetica Neue',Helvetica,Arial,cursive;"><a href="<?=BASE_URL?>" target="_blank"><?= $this->Headfoot_html->getLogo(); ?></a></span></div>
            <div class="text-center" style="padding:30px;">
                <h4 class="form-signin-heading"><?= $this->lang->line('login_heading') ?></h4>
                <? if ($error){
                    if($error == 'INVALID'){
                        echo "<span class=\"error\">" . $this->lang->line('login_incorrect') . "</span><br><br>";
                    }
                    if($error == 'CAPTCHA_WRONG'){
                        echo "<span class=\"error\">" . $this->lang->line('captcha_wrong') . "</span><br><br>";
                    }
                } ?>
                <?= form_open(BASE_URL . '/admin/login/check') ?>
                <label for="email" class="sr-only"><?= $this->lang->line('login_email') ?></label>
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
                <label for="password" class="sr-only"><?= $this->lang->line('login_password') ?>:</label>
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
                <img src="<?=BASE_URL.'/viewcaptcha?'.mt_rand(1000000000, 9999999999).'+'.time()?>" alt="CAPTCHA IMG" />
                <label for="captcha" class="sr-only"><?= $this->lang->line('captcha_text') ?></label>
                <?php
                $data = array(
                    'name' => 'captcha',
                    'id' => 'captcha',
                    'class' => 'form-control',
                    'required' => 'required',
                    'autofocus' => 'true',
                    'maxlength' => '6',
                    'value' => set_value('captcha'),
                    'placeholder' => $this->lang->line('captcha_text')
                );
                echo form_input($data);
                ?><br>
                <button class="btn btn-lg btn-primary btn-block" type="submit" id="login_submit"><?php echo $this->lang->line('login_signin'); ?></button>
                <?= form_close() ?>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6" style="padding-left:45px;">
            <a href="<?php echo BASE_URL; ?>/admin/user/forgot"><?php echo $this->lang->line('login_forgetpwd'); ?></a>
        </div>
        <div class="col-md-3"></div>        
    </div>
</div>