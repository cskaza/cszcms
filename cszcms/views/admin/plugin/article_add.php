<?php 
if($category !== FALSE){
    foreach ($category as $c) {
        $cat_arr[$c['article_db_id']] = $c['category_name'];
    }
}
?>
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-edit"></span></i> <?php if($this->input->get('is_category',TRUE)){  echo  $this->lang->line('category_new_header');  }else{ echo  $this->lang->line('article_new_header'); } ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php if($this->input->get('is_category',TRUE)){  echo  $this->lang->line('category_new_header');  }else{ echo  $this->lang->line('article_new_header'); } ?></div>
        <?php echo form_open(BASE_URL . '/admin/plugin/article/addsave'); ?>
        <input type="hidden" name="is_category" id="is_category" value="<?php if($this->input->get('is_category',TRUE)){  echo  '1';  }else{ echo  '0'; } ?>">
        <?php if($this->input->get('is_category',TRUE)){ ?>
            <div class="control-group">	
                <?php echo form_error('category_name', '<div class="error">', '</div>'); ?>
                <label class="control-label" for="category_name"><?php echo $this->lang->line('category_name'); ?>*</label>
                <?php
                $data = array(
                    'name' => 'category_name',
                    'id' => 'category_name',
                    'required' => 'required',
                    'autofocus' => 'true',
                    'class' => 'form-control',
                    'value' => set_value('category_name', '', FALSE)
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
                    if(isset($cat_arr)){
                        foreach ($cat_arr as $key => $value) {
                            $data[$key] = $value;
                        }
                    }
                    echo form_dropdown('main_cat_id', $data, '', $att);
                    ?>
                </div> <!-- /controls -->
            </div> <!-- /control-group -->
        <?php }else{ ?>
            
        <?php } ?>
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
            <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex('article'); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
        </div> <!-- /form-actions -->
        <?php echo form_close(); ?>
        <!-- /widget-content --> 
    </div>
</div>
