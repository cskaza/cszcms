<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="text-center"><span style="font-size:36px;color:#ff6f00;font-family: 'Kaushan Script','Helvetica Neue',Helvetica,Arial,cursive;"><?php echo $this->Headfoot_html->getLogo();?></span></div>
            <div class="text-center" style="padding:30px;">
                <h4 class="form-signin-heading"><?php echo  $this->lang->line('forgot_reset') ?></h4>
                <?php if(!$chksts){ ?>
                    <?php echo  form_open(BASE_URL . '/admin/user/forgot') ?>
                    <?php echo form_error('email', '<div class="error">', '</div>'); ?>	
                    <label for="email" class="sr-only"><?php echo  $this->lang->line('forgot_email') ?></label>
                    <?php
                    $data = array(
                        'name' => 'email',
                        'id' => 'email',
                        'type' => 'email',
                        'class' => 'form-control',
                        'required' => 'required',
                        'autofocus' => 'true',
                        'value' => set_value('email'),
                        'placeholder' => $this->lang->line('forgot_email')
                    ); echo form_input($data); ?>
                    <br>
                    <img src="<?php echo BASE_URL.'/viewcaptcha?'.mt_rand(1000000000, 9999999999).'+'.time()?>" alt="CAPTCHA IMG" />
                    <?php if($error_chk){ ?>
                        <div class="error"><?php echo $this->lang->line('captcha_wrong'); ?></div>                    
                    <?php } ?>
                    <label for="captcha" class="sr-only"><?php echo  $this->lang->line('captcha_text') ?></label>
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
                    ?>
                    <br>
                    <button class="btn btn-lg btn-primary" type="submit" id="forget_submit"><?php echo $this->lang->line('forgot_btn'); ?></button> &nbsp;&nbsp; <a class="btn btn-lg" name="newsletter_cancel" id="contact_database_cancel" href="<?php echo BASE_URL . '/admin'?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
                    <?php echo  form_close() ?>
                <?php }if($chksts){ ?>
                    <p class="success"><?php echo $this->lang->line('forgot_check_email'); ?></p>
                    <br>
                    <a class="btn btn-lg btn-primary" name="reset_back" id="reset_back" href="<?php echo BASE_URL . '/admin'?>"><?php echo $this->lang->line('btn_back'); ?></a>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>