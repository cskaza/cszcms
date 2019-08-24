<div class="container">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="h2 sub-header"><?php echo $this->Csz_model->getLabelLang('pm_txt') ?></div>
            <hr>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-3">
            <?php echo $this->Headfoot_html->memberleftMenu(); ?>
        </div>
        <div class="col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-send"></i> <?php echo $this->Csz_model->getLabelLang('pm_newmsg_txt') ?></b></div>
                <div class="panel-body">
                    <a role="button" href="<?php echo $this->Csz_model->base_link()?>/member/newpm" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo $this->Csz_model->getLabelLang('pm_newmsg_txt') ?></a>
                    <br><br>
                    <?php echo form_open($this->Csz_model->base_link(). '/member/insertpm/'.$this->uri->segment(4)); ?>
                    <?php if($this->uri->segment(3)){ ?>
                        <div class="control-group">	
                            <b><?php echo $this->Csz_model->getLabelLang('pm_to_txt') ?>:</b> <?php echo $receiver->name; ?>
                            <input type="hidden" name="to[]" id="to" value="<?php echo $receiver->user_admin_id ?>">
                        </div> <!-- /control-group -->
                        <?php if($this->uri->segment(4)){ ?>
                            <div class="control-group">
                                <b><?php echo $this->Csz_model->getLabelLang('pm_subject_txt') ?></b> Re: <?php echo str_replace('Re: ', '', $main_pm->title); ?>
                                <input type="hidden" name="title" id="title" value="Re: <?php echo str_replace('Re: ', '', $main_pm->title); ?>">
                            </div> <!-- /control-group -->
                            <div class="control-group">
                                <b><?php echo $this->lang->line('pm_message'); ?>: </b><pre style="overflow-x:auto;white-space:pre-wrap;white-space: -moz-pre-wrap;white-space: -pre-wrap;white-space: -o-pre-wrap;word-wrap: break-word;"><?php echo $main_pm->message; ?></pre>
                                <input type="hidden" name="re_message" id="re_message" value="<?php echo $main_pm->message ?>">
                            </div>
                        <?php } ?>
                        <br>
                    <?php }else{ ?>
                        <?php echo form_open($this->Csz_model->base_link(). '/member/insertpm'); ?>
                        <div class="control-group">	
                            <?php echo form_error('to', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                            <label class="control-label" for="to"><?php echo $this->Csz_model->getLabelLang('pm_to_txt'); ?>*</label>
                            <?php
                                $att = 'name="to[]" id="to" class="form-control select2" multiple="multiple" required="required" autofocus="true"';
                                $data = array();
                                if (!empty($users) && $users !== FALSE) {
                                    foreach ($users as $u) {
                                        $data[$u['user_admin_id']] = $u['name'];
                                    }
                                }
                                echo form_dropdown('', $data, ($this->uri->segment(3) && is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : '', $att);
                            ?>
                        </div> <!-- /control-group -->
                    <?php } ?>
                    <?php if(!$this->uri->segment(4)){ ?>
                        <div class="control-group">	
                            <?php echo form_error('title', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                            <label class="control-label" for="title"><?php echo $this->Csz_model->getLabelLang('pm_subject_txt'); ?>*</label>
                            <?php
                            $data = array(
                                'name' => 'title',
                                'id' => 'title',
                                'required' => 'required',
                                'autofocus' => 'true',
                                'class' => 'form-control',
                                'maxlength' => '255',
                                'value' => set_value('title', '', FALSE)
                            );
                            echo form_input($data);
                            ?>			
                        </div> <!-- /control-group -->
                    <?php } ?>    
                    <div class="control-group">	
                        <?php echo form_error('message', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                        <label class="control-label" for="message"><?php echo $this->Csz_model->getLabelLang('pm_msg_txt'); ?>*</label>
                        <?php
                            $data = array(
                                'name' => 'message',
                                'id' => 'message',
                                'required' => 'required',
                                'autofocus' => 'true',
                                'class' => 'form-control',
                                'value' => set_value('message', '', FALSE)
                            );
                            echo form_textarea($data);
                        ?>			
                    </div> <!-- /control-group -->
                    <br><br>
                    <div class="form-actions">
                        <?php
                        $data = array(
                            'name' => 'submit',
                            'id' => 'submit',
                            'class' => 'btn btn-primary',
                            'value' => $this->Csz_model->getLabelLang('pm_send_txt'),
                        );
                        echo form_submit($data);
                        ?> 
                        <a class="btn btn-default" href="<?php echo $this->csz_referrer->getIndex('member'); ?>"><?php echo $this->Csz_model->getLabelLang('btn_cancel'); ?></a>
                    </div> <!-- /form-actions -->
                    <?php echo form_close(); ?>
                    <!-- /widget-content -->
                </div>
            </div>
        </div>
    </div>
</div>