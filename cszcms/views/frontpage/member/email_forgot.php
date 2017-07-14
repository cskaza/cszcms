<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <br><br><br>         
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h4 class="panel-title form-signin-heading"><?php echo $this->Csz_model->getLabelLang('login_forgetpwd') ?></h4>
                </div>
                <div class="panel-body text-center">
                    <?php if(!$chksts){ ?>
                        <?php echo form_open($this->Csz_model->base_link(). '/member/forgot') ?>
                        <?php echo form_error('email', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
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
                            echo form_input($data); ?>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <br>
                        <div class="text-center"><?php echo $this->Csz_model->showCaptcha(); ?></div>
                        <br>
                        <button class="btn btn-primary" type="submit" id="forget_submit"><?php echo $this->Csz_model->getLabelLang('member_reset_btn'); ?></button> &nbsp;&nbsp; <a class="btn btn-default" name="newsletter_cancel" id="contact_database_cancel" href="<?php echo $this->Csz_model->base_link(). '/member'?>"><?php echo $this->Csz_model->getLabelLang('btn_cancel'); ?></a>
                        <?php echo  form_close() ?>
                    <?php }if($chksts){ ?>
                        <div class="text-center">
                            <p class="success"><?php echo $this->Csz_model->getLabelLang('member_forget_chkmail'); ?></p>
                            <br>
                            <a class="btn btn-lg btn-primary" name="reset_back" id="reset_back" href="<?php echo $this->Csz_model->base_link(). '/member'?>"><?php echo $this->Csz_model->getLabelLang('btn_back'); ?></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>