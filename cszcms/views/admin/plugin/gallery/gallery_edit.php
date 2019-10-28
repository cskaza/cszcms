<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-edit"></span></i> <?php echo $this->lang->line('btn_edit').' '.$this->lang->line('gallery_new_header'); ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('btn_edit').' '.$this->lang->line('gallery_new_header'); ?> <a role="button" onclick="return confirm('<?php echo $this->lang->line('delete_message') ?>')" href="<?php echo $this->Csz_model->base_link()?>/admin/plugin/gallery/asCopy/<?php echo $album->gallery_db_id?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-duplicate"></i> <?php echo $this->lang->line('btn_ascopy') ?></a> <a class="btn btn-default btn-sm" href="<?php echo $this->csz_referrer->getIndex('gallery'); ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $this->lang->line('btn_back'); ?></a></div>
        <?php echo form_open_multipart($this->Csz_model->base_link(). '/admin/plugin/gallery/editSave/'.$this->uri->segment(5)); ?>
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
                'value' => set_value('album_name', $album->album_name, FALSE)
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
                'value' => set_value('keyword', $album->keyword, FALSE)
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
                'value' => set_value('short_desc', $album->short_desc, FALSE)
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
            echo form_dropdown('lang_iso', $data, $album->lang_iso, $att);
            ?>	
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="user_groups_idS"><?php echo $this->lang->line('pages_user_groups_id'); ?></label>
            <select data-placeholder="<?php echo $this->lang->line('pages_user_groups_id') ?>:" name="user_groups_idS[]" id="select_contactS" class="form-control select2" multiple="multiple" tabindex="4">
            <?php
                $user_groups_idSR = array();
                if($album->user_groups_idS && $album->user_groups_idS){
                    $user_groups_idSR = explode(',', $album->user_groups_idS);
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
                if($album->active){
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
            <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex('gallery'); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
        </div> <!-- /form-actions -->
        <?php echo form_close(); ?>
        <!-- /widget-content --> 
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('gallery_picture') ?></div>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="h4 sub-header"><?php echo  $this->lang->line('gallery_youtube_head') ?></div>
                <?php echo  form_open($this->Csz_model->base_link(). '/admin/plugin/gallery/addYoutube/'.$this->uri->segment(5)) ?>
                <input type="hidden" name="gallery_type" value="youtubevideos">
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <div class="input-group-addon"><b><?php echo  $this->lang->line('gallery_youtube_url') ?></b></div>
                        <input style="z-index: 1;" type="text" class="form-control" id="youtube_url" name="youtube_url" required>
                    </div>
                </div>
                <?php
                $data = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'class' => 'btn btn-primary',
                    'value' => $this->lang->line('btn_add'),
                );
                echo form_submit($data);
                ?> 
                <?php echo form_close(); ?>               
            </div>
            <div class="col-lg-6 col-md-6">  
                <div class="h4 sub-header"><?php echo  $this->lang->line('uploadfile_uploadtools') ?></div>
                <?php echo  form_open_multipart($this->Csz_model->base_link(). '/admin/plugin/gallery/htmlUpload/'.$this->uri->segment(5)) ?>
                <input type="hidden" name="gallery_type" value="multiimages">
                <div class="row form-control-static">
                    <div class="col-lg-12 col-md-12">
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span><?php echo  $this->lang->line('uploadfile_add_file') ?></span>
                            <input type="file" name="files[]" id="files" multiple required accept=".jpg, .jpeg, .png, .gif">
                        </span>
                        <button type="submit" class="btn btn-primary">
                            <i class="glyphicon glyphicon-upload"></i>
                            <span><?php echo  $this->lang->line('btn_upload') ?></span>
                        </button>
                        <button type="reset" class="btn btn-warning" id="reset">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span><?php echo  $this->lang->line('btn_cancel') ?></span>
                        </button>
                        <pre id="filelist" style="display:none;"></pre>
                    </div>
                </div>
                <?php echo form_close(); ?>       
            </div>
        </div>
        <br>
        <blockquote class="remark">
            <em><?php echo  $this->lang->line('gallery_fileallow') ?></em>
        </blockquote>
        <?php echo  form_open($this->Csz_model->base_link(). '/admin/plugin/gallery/uploadIndexSave'); ?>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="2%" class="text-center" style="vertical-align:middle;"><i class="glyphicon glyphicon-sort"></i></th>
                        <th width="8%" class="text-center" style="vertical-align:middle;"><label><input id="sel-chkbox-all" type="checkbox"> <?php echo  $this->lang->line('btn_delete') ?></label></th>                           
                        <th width="15%" class="text-center" style="vertical-align:middle;"><?php echo  $this->lang->line('uploadfile_thumbnail') ?></th>
                        <th width="60%" style="vertical-align:middle;"><?php echo  $this->lang->line('uploadfile_filename') ?></th>
                        <th width="15%" class="text-center" style="vertical-align:middle;"><?php echo  $this->lang->line('uploadfile_uploadtime') ?></th>
                    </tr>
                </thead>
                <tbody class="ui-sortable">
                    <?php if ($showfile === FALSE) { ?>
                        <tr>
                            <td colspan="5" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('uploadfile_filenotfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php 
                        foreach ($showfile as $file) { ?>
                            <tr class="ui-state-default">
                                <td class="text-center" style="vertical-align:middle;"><i class="glyphicon glyphicon-resize-vertical"></i></td>
                                <td class="text-center" style="vertical-align:middle;">
                                    <input type="hidden" name="gallery_picture_id[]" value="<?php echo $file["gallery_picture_id"]?>">
                                    <input type="checkbox" name="filedel[]" id="filedel" class="selall-chkbox" value="<?php echo $file["gallery_picture_id"] ?>">
                                </td>
                                <td class="text-center" style="vertical-align:middle;">
                                    <?php 
                                    $ext = strtolower(pathinfo($file["file_upload"], PATHINFO_EXTENSION));
                                    if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' && $file["gallery_type"] == 'multiimages'){ ?>
                                    <img src="<?php echo base_url() .'photo/plugin/gallery/'.$file["file_upload"]?>" width="100">
                                    <?php }else{ ?>
                                        <i class="glyphicon glyphicon-facetime-video"></i> YOUTUBE
                                    <?php } ?>
                                </td>
                                <td style="vertical-align:middle;">
                                    <span class="h5"><b>
                                        <?php 
                                        if($file["gallery_type"] == 'multiimages'){
                                            echo $file["file_upload"];
                                        }else if($file["gallery_type"] == 'youtubevideos'){ ?>
                                            <a href="<?php echo $file["youtube_url"]; ?>" target="_blank"><?php echo $file["youtube_url"]; ?></a>
                                        <?php } ?>
                                    </b></span><?php if($file['arrange'] == 1){ ?> <i class="glyphicon glyphicon-book"></i><?php } ?>
                                    <div class="form-group has-feedback">
                                        <div class="input-group">
                                            <div class="input-group-addon"><b><?php echo  $this->lang->line('gallery_caption') ?></b></div>
                                            <input style="z-index: 1;" type="text" class="form-control" id="caption" name="caption[<?php echo $file["gallery_picture_id"] ?>]" value="<?php echo $file["caption"] ?>">
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align:middle;">
                                    <span class="h5"><b><?php echo  $file["timestamp_create"] ?></b></span>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">                
                <span class="warning">
                    <i class="glyphicon glyphicon-book"></i> <?php echo  $this->lang->line('gallery_list_remark') ?><br>
                </span>
                <br><br>
                <?php
                $data = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'class' => 'btn btn-lg btn-primary',
                    'value' => $this->lang->line('btn_save'),
                    'onclick' => "return confirm('".$this->lang->line('delete_message')."');",
                );
                echo form_submit($data);
                ?>
                <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex('gallery'); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
            </div>
        </div>
        <?php echo  form_close(); ?>
        <!-- /widget-content --> 
        <br><br>
        <b><?php echo $this->lang->line('total').' '.$total_row.' '.$this->lang->line('records');?></b>
    </div>
</div>
<script type="text/javascript">
document.getElementById('files').addEventListener('change', function(e) {
  var list = document.getElementById('filelist');
  list.innerHTML = '';
  for (var i = 0; i < this.files.length; i++) {
    list.innerHTML += (i + 1) + '. ' + this.files[i].name + '\n';
  }
  if (list.innerHTML == '') list.style.display = 'none';
  else list.style.display = 'block';
});
document.getElementById('reset').addEventListener('click', function(e) {
  var list = document.getElementById('filelist');
  list.innerHTML = '';
  list.style.display = 'none';
});
var fl = document.getElementById('files');

fl.onchange = function(e){ 
    var exts = this.value.substring(this.value.lastIndexOf('.') + 1).toLowerCase();
    var ext = exts.toLowerCase();
    switch(ext)
    {
        case 'jpg': 
            case 'jpeg':
            case 'png':
            case 'gif':
            break;
        default:
            alert('<?php echo  $this->lang->line('gallery_fileallow') ?>');
            this.value='';
            var list = document.getElementById('filelist');
            list.innerHTML = '';
            list.style.display = 'none';
    }
};
</script>
<script src="<?php echo base_url()?>assets/js/jquery.mobile-1.4.0-alpha.2.min.js"></script>