<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-gift"></span></i> <?php echo $this->lang->line('pwidget_edit_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('pwidget_edit_header') ?> <a role="button" href="<?php echo $this->Csz_model->base_link() ?>/admin/pwidget/addWidget" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo $this->lang->line('pwidget_new_header') ?></a></div>
        <?php echo form_open($this->Csz_model->base_link(). '/admin/pwidget/edited/'.$this->uri->segment(4)); ?>
        <div class="control-group">	
            <?php echo form_error('name', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="name"><?php echo $this->lang->line('pwidget_name'); ?>*</label>
            <?php
            $data = array(
                'name' => 'name',
                'id' => 'name',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('name', $widget->name, FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">
            <?php echo form_error('plugin_filename', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="plugin_filename"><?php echo $this->lang->line('pwidget_plugin'); ?>*</label>
            <div class="controls">
                <?php
                $att = 'id="plugin_filename" class="form-control" required';
                $data = array();
                $data[''] = $this->lang->line('option_choose');
                if(!empty($getPlugin)){
                    foreach ($getPlugin as $value) {
                        $data[$value] = $this->Csz_model->getPluginConfig($value, 'plugin_name');
                    }
                }
                echo form_dropdown('plugin_filename', $data, $widget->plugin_filename, $att);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">
            <?php echo form_error('sort_by', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="sort_by"><?php echo $this->lang->line('pwidget_sort_by'); ?>*</label>
            <div class="controls">
                <div class="input-group">
                    <?php
                    $att = 'id="sort_by" class="form-control" required';
                    $data = array();
                    $data[$widget->sort_by] = $widget->sort_by;
                    echo form_dropdown('sort_by', $data, $widget->sort_by, $att);
                    ?>
                    <div class="input-group-addon">
                        <?php
                        $att = 'id="order_by"';
                        $data = array();
                        $data['ASC'] = 'ASC';
                        $data['DESC'] = 'DESC';
                        echo form_dropdown('order_by', $data, $widget->order_by, $att);
                        ?>
                    </div>
                </div>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">
            <label class="control-label" for="data_limit"><?php echo $this->lang->line('pwidget_limit_view'); ?></label>
            <div class="controls">
                <?php
                $att = 'id="data_limit" class="form-control"';
                $data = array();
                for ($i = 1; $i <= 20; $i++) {
                    $data[$i] = $i;
                }
                $data[30] = 30;
                $data[40] = 40;
                $data[50] = 50;
                $data[100] = 100;
                echo form_dropdown('data_limit', $data, $widget->data_limit, $att);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">
            <?php echo form_error('view_id', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="view_id"><?php echo $this->lang->line('pwidget_plugin_view_id'); ?></label>
            <?php
            $data = array(
                'name' => 'view_id',
                'id' => 'view_id',
                'class' => 'form-control keypress-number',
                'maxlength' => '11',
                'value' => set_value('view_id', $widget->view_id, FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <br>
        <input type="button" class="btn btn-info" onclick="genCode()" value="<?php echo $this->lang->line('pwidget_gen_short_code'); ?>">
        <br><br>
        <div class="control-group">
            <label class="control-label"><?php echo $this->lang->line('pwidget_main_short_code'); ?></label>
            <div>{loop} {endloop} {base_url} {base_url_plugin} {base_url_photo_plugin} <span id="main_field_rs"></span></div>
        </div>
        <br>
        <div class="control-group">
            <label class="control-label"><?php echo $this->lang->line('pwidget_loop_short_code'); ?></label>
            <div><span id="field_rs">-</span></div>
        </div>
        <br>
        <div class="control-group">            
            <label class="control-label" for="template_code"><?php echo $this->lang->line('pwidget_body'); ?></label>
            <?php
            $data = array(
                'name' => 'template_code',
                'id' => 'template_code',
                'class' => 'form-control body-tinymce',
                'value' => set_value('template_code', $widget->template_code, FALSE)
            );
            echo form_textarea($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="lang_iso"><?php echo $this->lang->line('pages_lang'); ?></label>
            <?php
                $att = 'id="lang_iso" class="form-control"';
                $data = array();
                $data[''] = $this->lang->line('option_all');
                if (!empty($lang)) {
                    foreach ($lang as $lg) {
                        $data[$lg->lang_iso] = $lg->lang_name;
                    }
                }
                echo form_dropdown('lang_iso', $data, $widget->lang_iso, $att);
            ?>	
        </div> <!-- /control-group -->
        <br>
        <div class="control-group">										
            <label class="form-control-static" for="active">
                <?php
                if($widget->active){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $data = array(
                    'name' => 'active',
                    'id' => 'active',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('lang_active'); ?></label>	
        </div> <!-- /control-group -->
        <br><br>
        <div class="form-actions">
            <?php
            $data = array(
                'name' => 'submit',
                'id' => 'submit',
                'class' => 'btn btn-lg btn-primary',
                'value' => $this->lang->line('btn_save'),
            );
            echo form_submit($data);
            ?> 
            <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex(); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
        </div> <!-- /form-actions -->
        <?php echo form_close(); ?>
        <!-- /widget-content --> 
    </div>
</div>
