<div class="container">
    <div class="row">
        <div class="col-md-12"><br><br><br></div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <br><br><br>         
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h4 class="panel-title form-signin-heading"><?php echo $this->Csz_model->getLabelLang('login_register') ?></h4>
                </div>
                <div class="panel-body text-left">
                    <?php if(!$chksts){ ?>
                        <?php echo  form_open(BASE_URL . '/member/register/save') ?>
                        <div class="control-group">
                            <?php echo form_error('email', '<div class="error">', '</div>'); ?>	
                            <label for="email" class="control-label"><?php echo $this->Csz_model->getLabelLang('login_email') ?>*</label>
                            <?php
                            $data = array(
                                'name' => 'email',
                                'id' => 'email',
                                'type' => 'email',
                                'class' => 'form-control',
                                'required' => 'required',
                                'autofocus' => 'true',
                                'value' => set_value('email', '', FALSE),
                            ); echo form_input($data); ?>
                        </div> <!-- /control-group -->
                        
                        <div class="control-group">		
                            <?php echo form_error('password', '<div class="error">', '</div>'); ?>									
                            <label class="control-label" for="password"><?php echo $this->Csz_model->getLabelLang('login_password'); ?>*</label>
                            <?php
                            $data = array(
                                'name' => 'password',
                                'id' => 'password',
                                'required' => 'required',
                                'autofocus' => 'true',
                                'class' => 'form-control',
                                'value' => set_value('password', '', FALSE)
                            );
                            echo form_password($data);
                            ?>			
                        </div> <!-- /control-group -->

                        <div class="control-group">	
                            <?php echo form_error('con_password', '<div class="error">', '</div>'); ?>									
                            <label class="control-label" for="con_password"><?php echo $this->Csz_model->getLabelLang('login_confirmpassword'); ?>*</label>
                            <?php
                            $data = array(
                                'name' => 'con_password',
                                'id' => 'con_password',
                                'required' => 'required',
                                'autofocus' => 'true',
                                'class' => 'form-control',
                                'value' => set_value('con_password', '', FALSE)
                            );
                            echo form_password($data);
                            ?>			
                        </div> <!-- /control-group -->
                        <br>
                        <div class="text-center"><?php echo $this->Csz_model->showCaptcha(); ?></div>
                        <br>
                        <div class="text-center"><button class="btn btn-primary" type="submit" id="forget_submit"><?php echo $this->Csz_model->getLabelLang('login_register'); ?></button> &nbsp;&nbsp; <a class="btn btn-default" name="newsletter_cancel" id="contact_database_cancel" href="<?php echo BASE_URL . '/member'?>"><?php echo $this->Csz_model->getLabelLang('btn_cancel'); ?></a></div>
                        <?php echo  form_close() ?>
                    <?php }if($chksts){ ?>
                        <p class="success"><?php echo $this->Csz_model->getLabelLang('member_forget_chkmail'); ?></p>
                        <br>
                        <a class="btn btn-lg btn-primary" name="reset_back" id="reset_back" href="<?php echo BASE_URL . '/member'?>"><?php echo $this->Csz_model->getLabelLang('btn_back'); ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>