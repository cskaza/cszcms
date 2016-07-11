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
            <div class="control-group">	
                <?php echo form_error('title', '<div class="error">', '</div>'); ?>
                <label class="control-label" for="title"><?php echo $this->lang->line('article_title'); ?>*</label>
                <?php
                $data = array(
                    'name' => 'title',
                    'id' => 'title',
                    'required' => 'required',
                    'autofocus' => 'true',
                    'class' => 'form-control',
                    'value' => set_value('title', '', FALSE)
                );
                echo form_input($data);
                ?>			
            </div> <!-- /control-group -->
            <div class="control-group">	
                <label class="control-label" for="keyword"><?php echo $this->lang->line('article_keyword'); ?></label>
                <?php
                $data = array(
                    'name' => 'keyword',
                    'id' => 'keyword',
                    'class' => 'form-control',
                    'value' => set_value('keyword', '', FALSE)
                );
                echo form_input($data);
                ?>			
            </div> <!-- /control-group -->
            <div class="control-group">	
                <?php echo form_error('short_desc', '<div class="error">', '</div>'); ?>
                <label class="control-label" for="short_desc"><?php echo $this->lang->line('article_short_desc'); ?>*</label>
                <?php
                $data = array(
                    'name' => 'short_desc',
                    'id' => 'short_desc',
                    'required' => 'required',
                    'autofocus' => 'true',
                    'class' => 'form-control',
                    'value' => set_value('short_desc', '', FALSE)
                );
                echo form_input($data);
                ?>			
            </div> <!-- /control-group -->
            <div class="control-group">
                <?php echo form_error('cat_id', '<div class="error">', '</div>'); ?>
                <label class="control-label" for="cat_id"><?php echo $this->lang->line('category_header'); ?>*</label>
                <div class="controls">
                    <?php
                    $att = 'id="cat_id" class="form-control" required="required"';
                    $data = array();
                    $data[''] = $this->lang->line('option_choose');
                    if(isset($cat_arr)){
                        foreach ($cat_arr as $key => $value) {
                            $data[$key] = $value;
                        }
                    }
                    echo form_dropdown('cat_id', $data, '', $att);
                    ?>
                </div> <!-- /controls -->
            </div> <!-- /control-group -->
            <div class="control-group">
                <?php
                 $starter_html = '<div class="container">
                                <div class="row">
                                <div class="col-md-12">
                                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>
                                </div>
                                </div>
                                </div><br><br>';
                ?>
                <label class="control-label" for="content"><?php echo $this->lang->line('article_content'); ?></label>
                <textarea name="content" id="content" class="form-control body-tinymce"><?php echo $starter_html?></textarea>
            </div> <!-- /control-group -->
            <hr />
            <div class="control-group">		
            <?php echo form_error('file_upload', '<div class="error">', '</div>'); ?>									
                <label class="control-label" for="file_upload"><?php echo $this->lang->line('article_mainpic'); ?></label>
                <div class="controls">
                    <?php
                    $data = array(
                        'name' => 'file_upload',
                        'id' => 'file_upload',
                        'class' => 'span5'
                    );
                    echo form_upload($data);
                    ?>
                </div> <!-- /controls -->				
            </div> <!-- /control-group --> 
            <hr>
        <?php } ?>
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
