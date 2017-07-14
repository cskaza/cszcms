<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <!-- Start Admin Menu -->
        <?php echo $this->Article_model->AdminMenu() ?>
        <!-- End Admin Menu -->
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-edit"></span></i> <?php echo  $this->lang->line('category_edit_header'); ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('category_edit_header') . ' <a class="btn btn-default btn-sm" href="'.$this->csz_referrer->getIndex('article_cat').'"><span class="glyphicon glyphicon-arrow-left"></span> '.$this->lang->line('btn_back').'</a>'; ?></div>
        <?php echo form_open_multipart($this->Csz_model->base_link(). '/admin/plugin/article/editCatSave/'.$this->uri->segment(5)); ?>
            <div class="control-group">	
                <label class="control-label" for="category_name"><?php echo $this->lang->line('category_name'); ?>*</label>
                <?php
                $data = array(
                    'name' => 'category_name',
                    'id' => 'category_name',
                    'required' => 'required',
                    'autofocus' => 'true',
                    'class' => 'form-control',
                    'maxlength' => '255',
                    'value' => set_value('category_name', $category->category_name, FALSE)
                );
                echo form_input($data);
                ?>			
            </div> <!-- /control-group -->
            <div class="control-group">	
                <label class="control-label" for="main_cat_id"><?php echo $this->lang->line('category_main'); ?></label>
                <div class="controls">
                    <?php
                    $att = 'id="main_cat_id" class="form-control"';
                    $data = array();
                    $data[''] = $this->lang->line('option_choose');
                    if(!empty($main_category)){
                        foreach ($main_category as $c) {
                            if(!$c['main_cat_id'] && $c['article_db_id'] != $this->uri->segment(5)){
                                $data[$c['article_db_id']] = $c['category_name'].' ('.$c['lang_iso'].')';
                            }
                        }
                    }
                    echo form_dropdown('main_cat_id', $data, $category->main_cat_id, $att);
                    ?>
                </div> <!-- /controls -->
            </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="lang_iso"><?php echo $this->lang->line('pages_lang'); ?>*</label>
            <?php
                $att = 'id="lang_iso" class="form-control"';
                $data = array();
                if(!empty($lang)){
                    foreach ($lang as $lg) {
                        $data[$lg->lang_iso] = $lg->lang_name;
                    }
                }
                echo form_dropdown('lang_iso', $data, $category->lang_iso, $att);
            ?>	
        </div> <!-- /control-group -->
        <br>
        <div class="control-group">										
            <label class="form-control-static" for="active">
            <?php
            if($category->active){
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
            <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex('article_cat'); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
        </div> <!-- /form-actions -->
        <?php echo form_close(); ?>
        <!-- /widget-content --> 
    </div>
</div>
