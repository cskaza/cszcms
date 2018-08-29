<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-pencil"></span></i> <?php echo $this->lang->line('carousel_edit'); ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('carousel_picture') ?> <a class="btn btn-default btn-sm" href="<?php echo $this->csz_referrer->getIndex(); ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $this->lang->line('btn_back'); ?></a></div>
        <div class="row">
            <div class="col-md-4">
                <div class="h4 sub-header"><?php echo  $this->lang->line('carousel_youtube_head') ?></div>
                <?php echo form_open($this->Csz_model->base_link(). '/admin/carousel/addYoutube/'.$this->uri->segment(4)) ?>
                <input type="hidden" name="carousel_type" value="youtubevideos">
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <div class="input-group-addon"><b><?php echo  $this->lang->line('carousel_youtube_url') ?></b></div>
                        <input style="z-index: 1;" type="text" class="form-control" id="youtube_url" name="youtube_url" maxlength="255" required>
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
            <div class="col-md-4">
                <div class="h4 sub-header"><?php echo  $this->lang->line('carousel_url_head') ?></div>
                <?php echo form_open($this->Csz_model->base_link(). '/admin/carousel/addUrl/'.$this->uri->segment(4)) ?>
                <input type="hidden" name="carousel_type" value="multiimages">
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <div class="input-group-addon"><b><?php echo  $this->lang->line('carousel_photo_url') ?></b></div>
                        <input style="z-index: 1;" type="text" class="form-control" id="photo_url" name="photo_url" maxlength="512" required>
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
            <div class="col-md-4">  
                <div class="h4 sub-header"><?php echo  $this->lang->line('uploadfile_uploadtools') ?></div>
                <?php echo form_open_multipart($this->Csz_model->base_link(). '/admin/carousel/filesUpload/'.$this->uri->segment(4)) ?>
                <input type="hidden" name="carousel_type" value="multiimages">
                <div class="row form-control-static">
                    <div class="col-md-12">
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
                <br>
                <blockquote class="remark">
                    <em><?php echo  $this->lang->line('carousel_fileallow') ?></em>
                </blockquote>
            </div>
        </div>
        <?php echo  form_open($this->Csz_model->base_link(). '/admin/carousel/filesSave'); ?>
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
                                    <input type="hidden" name="carousel_picture_id[]" value="<?php echo $file["carousel_picture_id"]?>">
                                    <input type="checkbox" name="filedel[]" id="filedel" class="selall-chkbox" value="<?php echo $file["carousel_picture_id"] ?>">
                                </td>
                                <td class="text-center" style="vertical-align:middle;">
                                    <?php 
                                    $ext = strtolower(pathinfo($file["file_upload"], PATHINFO_EXTENSION));
                                    if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' && $file["carousel_type"] == 'multiimages' && $file["file_upload"] && $file["file_upload"] != NULL){ ?>
                                    <img src="<?php echo base_url() .'photo/carousel/'.$file["file_upload"]?>" width="100" class="img-responsive img-thumbnail">
                                    <?php }else if($file["carousel_type"] == 'multiimages' && $file["photo_url"] && $file["photo_url"] != NULL){ ?>
                                    <img src="<?php echo $file["photo_url"] ?>" width="100" class="img-responsive img-thumbnail">
                                    <?php }else{ ?>
                                        <i class="glyphicon glyphicon-facetime-video"></i> YOUTUBE
                                    <?php } ?>
                                </td>
                                <td style="vertical-align:middle;">
                                    <span class="h5"><b>
                                        <?php if($file["carousel_type"] == 'multiimages' && $file["file_upload"] && $file["file_upload"] != NULL){ ?>
                                            <a href="<?php echo base_url().'photo/carousel/'.$file["file_upload"]; ?>" target="_blank"><?php echo base_url().'photo/carousel/'.$file["file_upload"]; ?></a>
                                        <?php }else if($file["carousel_type"] == 'multiimages' && $file["photo_url"] && $file["photo_url"] != NULL){ ?>
                                            <a href="<?php echo $file["photo_url"]; ?>" target="_blank"><?php echo $file["photo_url"]; ?></a>
                                        <?php }else if($file["carousel_type"] == 'youtubevideos'){ ?>
                                            <a href="<?php echo $file["youtube_url"]; ?>" target="_blank"><?php echo $file["youtube_url"]; ?></a>
                                        <?php } ?>
                                    </b></span><?php if($file['arrange'] == 1){ ?> <i class="glyphicon glyphicon-book"></i><?php } ?>
                                    <div class="form-group has-feedback">
                                        <div class="input-group">
                                            <div class="input-group-addon"><b><?php echo  $this->lang->line('carousel_caption') ?></b></div>
                                            <input style="z-index: 1;" type="text" class="form-control" id="caption" name="caption[<?php echo $file["carousel_picture_id"] ?>]" value="<?php  echo $file["caption"]; ?>">
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align:middle;">
                                    <span class="h5"><b><?php echo $file["timestamp_create"] ?></b></span>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
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
                <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex(); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
            </div>
        </div>
        <?php echo  form_close(); ?>
        <!-- /widget-content --> 
        <br><br>
        <b><?php echo $this->lang->line('total').' '.$total_row.' '.$this->lang->line('records');?></b>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('carousel_edit'); ?></div>
        <?php echo form_open_multipart($this->Csz_model->base_link(). '/admin/carousel/update/'.$this->uri->segment(4)); ?>
        <div class="control-group">	
            <?php echo form_error('name', '<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>'); ?>
            <label class="control-label" for="name"><?php echo $this->lang->line('carousel_name'); ?>*</label>
            <?php
            $data = array(
                'name' => 'name',
                'id' => 'name',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('name', $carousel->name, FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <br>
        <div class="panel panel-default"> 
            <div class="panel-heading">
                <label class="checkbox-inline">
                    <?php
                    if($carousel->custom_temp_active){
                        $checked = 'checked';
                    }else{
                        $checked = '';
                    }
                    $data = array(
                        'name' => 'custom_temp_active',
                        'id' => 'custom_temp_active',
                        'value' => '1',
                        "onclick" => "ChkHideShow('custom-template-id');",
                        'checked' => $checked
                    );
                    echo form_checkbox($data);
                    ?> <?php echo $this->lang->line('carousel_customtemp_active'); ?>
                </label>
            </div>
            <?php if($carousel->custom_temp_active){
                $style_display = '';
            }else{
                $style_display = ' style="display: none;"';
            } ?>
            <div class="panel-body" id="custom-template-id"<?php echo $style_display ?>>
                <div class="control-group">            
                    <label class="control-label" for="custom_template"><?php echo $this->lang->line('carousel_customtemp_txt'); ?></label>
                    <?php
                    $data = array(
                        'name' => 'custom_template',
                        'id' => 'custom_template',
                        'class' => 'form-control',
                        'value' => set_value('custom_template', $carousel->custom_template, FALSE)
                    );
                    echo form_textarea($data);
                    ?>			
                </div> <!-- /control-group -->
            </div>
        </div>
        <br>
        <div class="control-group">										
            <label class="form-control-static" for="active">
                <?php
                if($carousel->active){
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
            alert('<?php echo  $this->lang->line('carousel_fileallow') ?>');
            this.value='';
            var list = document.getElementById('filelist');
            list.innerHTML = '';
            list.style.display = 'none';
    }
};
</script>
<script src="<?php echo base_url()?>assets/js/jquery.mobile-1.4.0-alpha.2.min.js"></script>