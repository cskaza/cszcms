<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <!-- Start Admin Menu -->
        <?php echo $this->Article_model->AdminMenu() ?>
        <!-- End Admin Menu -->
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-edit"></span></i> <?php echo $this->lang->line('article_edit_header'); ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('article_edit_header') . ' <a class="btn btn-default btn-sm" href="'.$this->csz_referrer->getIndex('article_art').'"><span class="glyphicon glyphicon-arrow-left"></span> '.$this->lang->line('btn_back').'</a>'; ?></div>
        <?php echo form_open_multipart($this->Csz_model->base_link(). '/admin/plugin/article/editArtSave/'.$this->uri->segment(5)); ?>
            <div class="control-group">	
                <?php echo form_error('title', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                <label class="control-label" for="title"><?php echo $this->lang->line('article_title'); ?>*</label>
                <?php
                $data = array(
                    'name' => 'title',
                    'id' => 'title',
                    'required' => 'required',
                    'autofocus' => 'true',
                    'class' => 'form-control',
                    'maxlength' => '255',
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
                    'maxlength' => '255',
                    'value' => set_value('keyword', $article->keyword, FALSE)
                );
                echo form_input($data);
                ?>			
            </div> <!-- /control-group -->
            <div class="control-group">	
                <?php echo form_error('short_desc', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
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
                <?php echo form_error('cat_id', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
                <label class="control-label" for="cat_id"><?php echo $this->lang->line('category_header'); ?>*</label>
                <div class="controls">
                    <?php
                    $att = 'id="cat_id" class="form-control" required="required" autofocus="true"';
                    $data = array();
                    $data[''] = $this->lang->line('option_choose');
                    if(!empty($category)){
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
            <?php echo form_error('file_upload', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
                <label class="control-label" for="file_upload"><?php echo $this->lang->line('article_mainpic'); ?></label>
                <div class="controls">
                    <div><img src="<?php
                              if ($article->main_picture != "" && $article->main_picture != NULL) {
                                  echo base_url() . 'photo/plugin/article/' . $article->main_picture;
                              }
                              ?>" id="logo_preloaded" <?php
                    if ($article->main_picture == "" || $article->main_picture == NULL) {
                        echo "style='display:none;'";
                    }
                    ?>></div>
                    <?php if ($article->main_picture != "" && $article->main_picture != NULL) { ?><label for="del_file"><input type="checkbox" name="del_file" id="del_file" value="<?php echo $article->main_picture?>"> <span class="remark">Delete File</span></label><?php } ?>                    
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
            <br>
            <div class="control-group">		
            <?php echo form_error('file_upload2', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>									
                <label class="control-label" for="file_upload2"><?php echo $this->lang->line('uploadfile_header'); ?></label>
                <div class="controls">
                    <?php if ($article->file_upload != "" && $article->file_upload != NULL) { ?><label for="del_file2"><input type="checkbox" name="del_file2" id="del_file2" value="<?php echo $article->file_upload?>"> <span class="remark">Delete File</span></label><?php } ?>         
                    <?php
                        if ($article->file_upload != "" && $article->file_upload != NULL) {
                             echo '<a href="'.base_url() . 'photo/plugin/article/' . $article->file_upload.'" title="'.$this->lang->line('uploadfile_download').'" target="_blank">'.$this->lang->line('uploadfile_download').'</a>';
                        } ?>    
                    <?php
                    $data = array(
                        'name' => 'file_upload2',
                        'id' => 'file_upload2',
                        'class' => 'span5'
                    );
                    echo form_upload($data);
                    ?>
                    <input type="hidden" id="mainFile" name="mainFile" value="<?php echo $article->file_upload?>"/>
                </div> <!-- /controls -->				
            </div> <!-- /control-group -->
            <hr>
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
                echo form_dropdown('lang_iso', $data, $article->lang_iso, $att);
            ?>	
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="user_groups_idS"><?php echo $this->lang->line('pages_user_groups_id'); ?></label>
            <select data-placeholder="<?php echo $this->lang->line('pages_user_groups_id') ?>:" name="user_groups_idS[]" id="select_contactS" class="form-control select2" multiple="multiple" tabindex="4">
            <?php
                $user_groups_idSR = array();
                if($article->user_groups_idS && $article->user_groups_idS){
                    $user_groups_idSR = explode(',', $article->user_groups_idS);
                }
                if (!empty($user_groups)) {
                    foreach ($user_groups as $ug) {
                        $selected = '';
                        if (!empty($user_groups_idSR)) {
                            foreach ($user_groups_idSR as $sgr_val) {
                                if ($sgr_val == $ug['user_groups_id']) {
                                    $selected = ' selected="selected"';
                                }
                            }
                        } ?>
                        <option value="<?php echo $ug['user_groups_id'] ?>"<?php echo $selected ?>><?php echo $ug['name'] ?></option>
                <?php }
                } ?>	
                </select>
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
        <hr>
        <div class="control-group">										
            <label class="form-control-static" for="fb_comment_active">
            <?php
            if($article->fb_comment_active){
                $checked = 'checked';
            }else{
                $checked = '';
            }
            $data = array(
                'name' => 'fb_comment_active',
                'id' => 'fb_comment_active',
                'value' => '1',
                'checked' => $checked
            );
            echo form_checkbox($data);
            ?> <?php echo $this->lang->line('fb_comment_active'); ?></label>	
        </div> <!-- /control-group -->
        <div class="control-group">
            <label class="control-label" for="fb_comment_limit"><?php echo $this->lang->line('fb_comment_limit'); ?></label>
            <div class="controls">
                <?php
                $att = 'id="fb_comment_limit" class="form-control"';
                $data = array();
                $data[1] = 1;
                $data[2] = 2;
                $data[5] = 5;
                $data[10] = 10;
                $data[15] = 15;
                $data[20] = 20;
                $data[30] = 30;
                $data[50] = 50;
                echo form_dropdown('fb_comment_limit', $data, $article->fb_comment_limit, $att);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="control-group">
            <label class="control-label" for="fb_comment_sort"><?php echo $this->lang->line('fb_comment_sort'); ?></label>
            <div class="controls">
                <?php
                $att = 'id="fb_comment_sort" class="form-control"';
                $data = array();
                $data['reverse_time'] = $this->lang->line('fb_comment_sort_newest');
                $data['social'] = $this->lang->line('fb_comment_sort_top');
                $data['time'] = $this->lang->line('fb_comment_sort_oldest');
                echo form_dropdown('fb_comment_sort', $data, $article->fb_comment_sort, $att);
                ?>
            </div> <!-- /controls -->				
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
            <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex('article_art'); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
        </div> <!-- /form-actions -->
        <?php echo form_close(); ?>
        <!-- /widget-content --> 
    </div>
</div>
