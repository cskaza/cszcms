<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-globe"></span></i> <?php echo  $this->lang->line('pages_addnew') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('pages_addnew') ?>  <a role="button" href="<?php echo  BASE_URL ?>/admin/pages/new" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('pages_addnew') ?></a></div>
        <?php echo form_open(BASE_URL . '/admin/pages/insert'); ?>

        <div class="control-group">	
            <?php echo form_error('page_name', '<div class="error">', '</div>'); ?>
            <label class="control-label" for="page_name"><?php echo $this->lang->line('pages_name'); ?>*</label>
            <?php
            $data = array(
                'name' => 'page_name',
                'id' => 'page_name',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'value' => set_value('page_name', '', FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->

        <div class="control-group">	
            <?php echo form_error('page_title', '<div class="error">', '</div>'); ?>									
            <label class="control-label" for="page_title"><?php echo $this->lang->line('pages_title'); ?>*</label>
            <?php
            $data = array(
                'name' => 'page_title',
                'id' => 'page_title',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'value' => set_value('page_title', '', FALSE)
            );
            echo form_input($data);
            ?>				
        </div> <!-- /control-group -->
        
        <div class="control-group">	
            <?php echo form_error('page_keywords', '<div class="error">', '</div>'); ?>									
            <label class="control-label" for="page_keywords"><?php echo $this->lang->line('pages_keywords'); ?>*</label>
            <?php
            $data = array(
                'name' => 'page_keywords',
                'id' => 'page_keywords',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'value' => set_value('page_keywords', '', FALSE)
            );
            echo form_input($data);
            ?>				
        </div> <!-- /control-group -->

        <div class="control-group">
            <?php echo form_error('page_desc', '<div class="error">', '</div>'); ?>
            <label class="control-label" for="page_desc"><?php echo $this->lang->line('pages_desc'); ?>*</label>
            <?php
            $data = array(
                'name' => 'page_desc',
                'id' => 'page_desc',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'value' => set_value('page_desc', '', FALSE)
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
                echo form_dropdown('lang_iso', $data, '', $att);
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
        <br>
        <div class="control-group">
            <?php
             $starter_html = '<br><br><div class="container">
                            <div class="row">
                            <div class="col-md-12">
                            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>
                            </div>
                            </div>
                            </div>';
            ?>
            <label class="control-label" for="content"><?php echo $this->lang->line('pages_content'); ?></label>
            <textarea name="content" id="content" class="form-control body-tinymce"><?php echo $starter_html?></textarea>
        </div> <!-- /control-group -->
        <br>
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
            <a class="btn btn-lg" href="<?php echo BASE_URL; ?>/admin/pages"><?php echo $this->lang->line('btn_cancel'); ?></a>
        </div> <!-- /form-actions -->
        <?php echo form_close(); ?>
        <!-- /widget-content --> 
    </div>
</div>