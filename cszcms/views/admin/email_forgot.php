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
                <div class="panel-body text-center">
                    <?php if(!$chksts){ ?>
                        <?php echo  form_open($this->Csz_model->base_link(). '/admin/user/forgot') ?>
                        <?php echo form_error('email', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                        <div class="form-group has-feedback">
                            <label for="email" class="control-label"><?php echo $this->lang->line('forgot_email') ?>*</label>
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
                            );
                            echo form_input($data); ?>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <br>
                        <div class="text-center"><?php echo $this->Csz_model->showCaptcha(); ?></div>
                        <br>
                        <button class="btn btn-lg btn-primary" type="submit" id="forget_submit"><?php echo $this->lang->line('forgot_btn'); ?></button> &nbsp;&nbsp; <a class="btn btn-lg" name="newsletter_cancel" id="contact_database_cancel" href="<?php echo $this->Csz_model->base_link(). '/admin'?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
                        <?php echo  form_close() ?>
                    <?php }if($chksts){ ?>
                        <p class="success"><?php echo $this->lang->line('forgot_check_email'); ?></p>
                        <br>
                        <a class="btn btn-lg btn-primary" name="reset_back" id="reset_back" href="<?php echo $this->Csz_model->base_link(). '/admin'?>"><?php echo $this->lang->line('btn_back'); ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>