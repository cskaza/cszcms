<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <!-- Start Admin Menu -->
        <?php echo $this->Article_model->AdminMenu() ?>
        <!-- End Admin Menu -->
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-edit"></span></i> <?php if($article->is_category){  echo  $this->lang->line('category_new_header');  }else{ echo  $this->lang->line('article_new_header'); } ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php if($this->input->get('is_category',TRUE)){  echo  $this->lang->line('category_new_header') . ' <a class="btn btn-default btn-sm" href="'.$this->csz_referrer->getIndex('article_cat').'"><span class="glyphicon glyphicon-arrow-left"></span> '.$this->lang->line('btn_back').'</a>';  }else{ echo  $this->lang->line('article_new_header') . ' <a class="btn btn-default btn-sm" href="'.$this->csz_referrer->getIndex('article_art').'"><span class="glyphicon glyphicon-arrow-left"></span> '.$this->lang->line('btn_back').'</a>'; } ?></div>
        <?php echo form_open_multipart(BASE_URL . '/admin/plugin/article/editsave/'.$this->uri->segment(5)); ?>
        <input type="hidden" name="is_category" id="is_category" value="<?php echo $article->is_category; ?>">
        <?php if($article->is_category){ ?>
            <div class="control-group">	
                <label class="control-label" for="category_name"><?php echo $this->lang->line('category_name'); ?>*</label>
                <?php
                $data = array(
                    'name' => 'category_name',
                    'id' => 'category_name',
                    'required' => 'required',
                    'autofocus' => 'true',
                    'class' => 'form-control',
                    'value' => set_value('category_name', $article->category_name, FALSE)
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
                    if(isset($category)){
                        foreach ($category as $c) {
                            if(!$c['main_cat_id'] && $c['article_db_id'] != $this->uri->segment(5)){
                                $data[$c['article_db_id']] = $c['category_name'].' ('.$c['lang_iso'].')';
                            }
                        }
                    }
                    echo form_dropdown('main_cat_id', $data, $article->main_cat_id, $att);
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
                    'value' => set_value('title', $article->title, FALSE)
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
                    'value' => set_value('keyword', $article->keyword, FALSE)
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
                    'maxlength' => '255',
                    'value' => set_value('short_desc', $article->short_desc, FALSE)
                );
                echo form_input($data);
                ?>
            </div> <!-- /control-group -->
            <div class="control-group">
                <?php echo form_error('cat_id', '<div class="error">', '</div>'); ?>
                <label class="control-label" for="cat_id"><?php echo $this->lang->line('category_header'); ?>*</label>
                <div class="controls">
                    <?php
                    $att = 'id="cat_id" class="form-control" required="required" autofocus="true"';
                    $data = array();
                    $data[''] = $this->lang->line('option_choose');
                    if(isset($category)){
                        foreach ($category as $c) {
                            $data[$c['article_db_id']] = $c['category_name'].' ('.$c['lang_iso'].')';
                        }
                    }
                    echo form_dropdown('cat_id', $data, $article->cat_id, $att);
                    ?>
                </div> <!-- /controls -->
            </div> <!-- /control-group -->
            <div class="control-group">
                <label class="control-label" for="content"><?php echo $this->lang->line('article_content'); ?></label>
                <textarea name="content" id="content" class="form-control body-tinymce"><?php echo $article->content?></textarea>
            </div> <!-- /control-group -->
            <hr />
            <div class="control-group">		
            <?php echo form_error('file_upload', '<div class="error">', '</div>'); ?>									
                <label class="control-label" for="file_upload"><?php echo $this->lang->line('article_mainpic'); ?></label>
                <div class="controls">
                    <div><img src="<?php
                              if ($article->main_picture != "") {
                                  echo BASE_URL . '/photo/plugin/article/' . $article->main_picture;
                              }
                              ?>" id="logo_preloaded" <?php
                    if ($article->main_picture == "") {
                        echo "style='display:none;'";
                    }
                    ?>></div>
                    <?php if ($article->main_picture != "") { ?><label for="del_file"><input type="checkbox" name="del_file" id="del_file" value="<?php echo $article->main_picture?>"> <span class="remark">Delete File</span></label><?php } ?>
                    <img src="<?php echo BASE_URL; ?>templates/admin/imgs/ajax-loader.gif" style="margin:-7px 5px 0 5px;display:none;" id="loading_pic" />
                    <?php
                    $data = array(
                        'name' => 'file_upload',
                        'id' => 'file_upload',
                        'class' => 'span5'
                    );
                    echo form_upload($data);
                    ?>
                    <input type="hidden" id="mainPicture" name="mainPicture" value="<?php echo $article->main_picture?>"/>
                </div> <!-- /controls -->				
            </div> <!-- /control-group -->
            <hr>
        <?php } ?>
        <div class="control-group">	
            <label class="control-label" for="lang_iso"><?php echo $this->lang->line('pages_lang'); ?>*</label>
            <?php
                $att = 'id="lang_iso" class="form-control"';
                $data = array();
                foreach ($lang as $lg) {
                    $data[$lg->lang_iso] = $lg->lang_name;
                }
                echo form_dropdown('lang_iso', $data, $article->lang_iso, $att);
            ?>	
        </div> <!-- /control-group -->
        <br>
        <div class="control-group">										
            <label class="form-control-static" for="active">
            <?php
            if($article->active){
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
            <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex('article'); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
        </div> <!-- /form-actions -->
        <?php echo form_close(); ?>
        <!-- /widget-content --> 
    </div>
</div>
