<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-edit"></span></i> <?php echo $this->lang->line('gallery_new_header'); ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('gallery_new_header'); ?> <a class="btn btn-default btn-sm" href="<?php echo $this->csz_referrer->getIndex('gallery'); ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $this->lang->line('btn_back'); ?></a></div>
        <?php echo form_open_multipart($this->Csz_model->base_link(). '/admin/plugin/gallery/addSave'); ?>
        <div class="control-group">	
            <?php echo form_error('album_name', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="album_name"><?php echo $this->lang->line('gallery_albumname'); ?>*</label>
            <?php
            $data = array(
                'name' => 'album_name',
                'id' => 'album_name',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('album_name', $this->Csz_admin_model->getDraftArray('album_name'), FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="keyword"><?php echo $this->lang->line('gallery_keyword'); ?></label>
            <?php
            $data = array(
                'name' => 'keyword',
                'id' => 'keyword',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('keyword', $this->Csz_admin_model->getDraftArray('keyword'), FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">	
            <?php echo form_error('short_desc', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="short_desc"><?php echo $this->lang->line('gallery_short_desc'); ?>*</label>
            <?php
            $data = array(
                'name' => 'short_desc',
                'id' => 'short_desc',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'value' => set_value('short_desc', $this->Csz_admin_model->getDraftArray('short_desc'), FALSE)
            );
            echo form_input($data);
            ?>
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="lang_iso"><?php echo $this->lang->line('pages_lang'); ?>*</label>
            <?php
            $att = 'id="lang_iso" class="form-control"';
            $data = array();
            foreach ($lang as $lg) {
                $data[$lg->lang_iso] = $lg->lang_name;
            }
            echo form_dropdown('lang_iso', $data, $this->Csz_admin_model->getDraftArray('lang_iso'), $att);
            ?>	
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="user_groups_idS"><?php echo $this->lang->line('pages_user_groups_id'); ?></label>
            <?php
                $att = 'data-placeholder="'.$this->lang->line('pages_user_groups_id').':" id="user_groups_idS" class="form-control select2" multiple="multiple"';
                $data = array();
                if (!empty($user_groups)) {
                    foreach ($user_groups as $ug) {
                        $data[$ug['user_groups_id']] = $ug['name'];
                    }
                }
                echo form_dropdown('user_groups_idS[]', $data, '', $att);
            ?>	
        </div> <!-- /control-group -->
        <br>
        <div class="control-group">										
            <label class="form-control-static" for="active">
                <?php
                $data = array(
                    'name' => 'active',
                    'id' => 'active',
                    'value' => '1'
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('lang_active'); ?></label>	
        </div> <!-- /control-group -->
        <br><br>
        <?php
            $data = array(
                'type' => 'button',
                'name' => 'save_draft',
                'id' => 'save_draft',
                'class' => 'btn btn-lg btn-warning',
                'value' => $this->lang->line('btn_save_draft'),
            );
            echo form_input($data);
            ?> <span id="save_draft_res" class="text-success"></span>
            <input type="hidden" name="current_url" id="current_url" value="<?php echo current_url(); ?>">
        <br><br>
        <div class="form-actions">
            <?php
            $data = array(
                'name' => 'submit',
                'id' => 'submit',
                'class' => 'btn btn-lg btn-primary',
                'value' => $this->lang->line('btn_save_exit'),
            );
            echo form_submit($data);
            ?> 
            <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex('gallery'); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
        </div> <!-- /form-actions -->
        <?php echo form_close(); ?>
        <!-- /widget-content --> 
        <br><br>
        <span class="remark"><em><?php echo $this->lang->line('gallery_remark'); ?></em></span>
    </div>
</div>