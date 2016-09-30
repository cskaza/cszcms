<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-gift"></span></i> <?php echo $this->lang->line('widget_edit_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('widget_edit_header') ?>  <a role="button" href="<?php echo BASE_URL ?>/admin/widget/addWidget" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo $this->lang->line('widget_new_header') ?></a></div>
        <?php echo form_open(BASE_URL . '/admin/widget/edited/'.$this->uri->segment(4)); ?>

        <div class="control-group">	
            <?php echo form_error('widget_name', '<div class="error">', '</div>'); ?>
            <label class="control-label" for="widget_name"><?php echo $this->lang->line('widget_name'); ?>*</label>
            <?php
            $data = array(
                'name' => 'widget_name',
                'id' => 'widget_name',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'value' => set_value('widget_name', $widget->widget_name, FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->

        <div class="control-group">	
            <?php echo form_error('xml_url', '<div class="error">', '</div>'); ?>									
            <label class="control-label" for="xml_url"><?php echo $this->lang->line('widget_xml_url'); ?>*</label>
            <?php
            $data = array(
                'name' => 'xml_url',
                'id' => 'xml_url',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'value' => set_value('xml_url', $widget->xml_url, FALSE)
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
                echo form_dropdown('limit_view', $data, $widget->limit_view, $att);
                ?>
            </div> <!-- /controls -->				
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
                ?> <?php echo $this->lang->line('widget_active'); ?></label>	
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
