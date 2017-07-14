<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-gift"></span></i> <?php echo $this->lang->line('widget_new_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('widget_new_header') ?>  <a role="button" href="<?php echo $this->Csz_model->base_link() ?>/admin/widget/addWidget" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo $this->lang->line('widget_new_header') ?></a></div>
        <?php echo form_open($this->Csz_model->base_link(). '/admin/widget/insert'); ?>

        <div class="control-group">	
            <?php echo form_error('widget_name', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="widget_name"><?php echo $this->lang->line('widget_name'); ?>*</label>
            <?php
            $data = array(
                'name' => 'widget_name',
                'id' => 'widget_name',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('widget_name', $this->Csz_admin_model->getDraftArray('widget_name'), FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->

        <div class="control-group">	
            <?php echo form_error('xml_url', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
            <label class="control-label" for="xml_url"><?php echo $this->lang->line('widget_xml_url'); ?>*</label>
            <?php
            $data = array(
                'name' => 'xml_url',
                'id' => 'xml_url',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('xml_url', $this->Csz_admin_model->getDraftArray('xml_url'), FALSE)
            );
            echo form_input($data);
            ?>
        </div> <!-- /control-group -->
        <div class="control-group">
            <label class="control-label" for="limit_view"><?php echo $this->lang->line('widget_limit_view'); ?></label>
            <div class="controls">
                <?php
                $att = 'id="limit_view" class="form-control"';
                $data = array();
                for ($i = 1; $i <= 20; $i++) {
                    $data[$i] = $i;
                }
                $data[50] = 50;
                $data[100] = 100;
                echo form_dropdown('limit_view', $data, $this->Csz_admin_model->getDraftArray('limit_view'), $att);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <?php
        $widget = (object)'';
        if(empty($widget->widget_open) || $widget->widget_open == NULL){
            $widget->widget_open = '<div class="panel panel-default">
                                    <div class="panel-heading"><b>{widget_header_name}</b></div>
                                    <div class="panel-body">';
        }
        if(empty($widget->widget_content) || $widget->widget_content == NULL){
            $widget->widget_content = '<div class="row">
                                            <div class="col-md-3">
                                                <a href="{sub_url}" title="{title}"><img class="lazy img-responsive img-thumbnail" data-src="{photo}" alt="{title}"></a>
                                            </div>
                                            <div class="col-md-9">
                                                <a href="{sub_url}" title="{title}"><h4>{title}</h4></a><br>
                                                <p>{short_desc}</p>
                                            </div>
                                        </div><hr>';
        }
        if(empty($widget->widget_seemore) || $widget->widget_seemore == NULL){
            $widget->widget_seemore = '<div class="text-right"><a href="{main_url}" class="btn btn-primary btn-sm">{readmore_text}</a></div>';
        }
        if(empty($widget->widget_close) || $widget->widget_close == NULL){
            $widget->widget_close = '</div></div>';
        }
        ?>
        <div class="control-group">            
            <label class="control-label" for="widget_open"><?php echo $this->lang->line('widget_widget_open'); ?></label>
            <?php
            $data = array(
                'name' => 'widget_open',
                'id' => 'widget_open',
                'class' => 'form-control',
                'value' => set_value('widget_open', ($this->Csz_admin_model->getDraftArray('widget_open')) ? $this->Csz_admin_model->getDraftArray('widget_open') : $widget->widget_open, FALSE)
            );
            echo form_textarea($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">            
            <label class="control-label" for="widget_content"><?php echo $this->lang->line('widget_widget_content'); ?></label>
            <?php
            $data = array(
                'name' => 'widget_content',
                'id' => 'widget_content',
                'class' => 'form-control',
                'value' => set_value('widget_content', ($this->Csz_admin_model->getDraftArray('widget_content')) ? $this->Csz_admin_model->getDraftArray('widget_content') : $widget->widget_content, FALSE)
            );
            echo form_textarea($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">            
            <label class="control-label" for="widget_seemore"><?php echo $this->lang->line('widget_widget_seemore'); ?></label>
            <?php
            $data = array(
                'name' => 'widget_seemore',
                'id' => 'widget_seemore',
                'class' => 'form-control',
                'value' => set_value('widget_seemore', ($this->Csz_admin_model->getDraftArray('widget_seemore')) ? $this->Csz_admin_model->getDraftArray('widget_seemore') : $widget->widget_seemore, FALSE)
            );
            echo form_textarea($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">            
            <label class="control-label" for="widget_close"><?php echo $this->lang->line('widget_widget_close'); ?></label>
            <?php
            $data = array(
                'name' => 'widget_close',
                'id' => 'widget_close',
                'class' => 'form-control',
                'value' => set_value('widget_close', ($this->Csz_admin_model->getDraftArray('widget_close')) ? $this->Csz_admin_model->getDraftArray('widget_close') : $widget->widget_close, FALSE)
            );
            echo form_textarea($data);
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
            <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex(); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
        </div> <!-- /form-actions -->
        <?php echo form_close(); ?>
        <!-- /widget-content --> 
    </div>
</div>
