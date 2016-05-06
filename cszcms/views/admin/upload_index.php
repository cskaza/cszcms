<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-object-align-top"></span></i> <?= $this->lang->line('uploadfile_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?= $this->lang->line('uploadfile_header') ?></div>
        <div class="row">
            <div class="col-lg-12 col-md-12">  
                <h4><?= $this->lang->line('uploadfile_uploadtools') ?></h4>
                <?= form_open_multipart(BASE_URL . '/admin/filehtmlupload') ?>
                <div class="row form-control-static">
                    <div class="col-lg-12 col-md-12">
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span><?= $this->lang->line('uploadfile_add_file') ?></span>
                            <input type="file" name="files[]" id="files" multiple required accept=".jpg, .jpeg, .png, .gif, .pdf, .doc, .docx, .odt, .txt, .odg, .odp, .ods, .zip, .rar, .psv, .xls, .xlsx, .ppt, .pptx, .mp3, .wav, .mp4, .wma, .flv, .avi, .mov, .m4v, .wmv, .m3u, .pls">
                        </span>
                        <button type="submit" class="btn btn-primary">
                            <i class="glyphicon glyphicon-upload"></i>
                            <span><?= $this->lang->line('btn_upload') ?></span>
                        </button>
                        <button type="reset" class="btn btn-warning" id="reset">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span><?= $this->lang->line('btn_cancel') ?></span>
                        </button>
                        <pre id="filelist" style="display:none;"></pre>
                    </div>
                </div>
                <? echo form_close(); ?>       
            </div>    
        </div>
        <br>
        <blockquote class="remark">
            <em><?= $this->lang->line('uploadfile_fileallow') ?></em>
        </blockquote>
        <?= form_open(BASE_URL . '/admin/uploadindex_save'); ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="8%" class="text-center" style="vertical-align:middle;"><label><input id="sel-chkbox-all" type="checkbox"> <?= $this->lang->line('btn_delete') ?></label></th>                           
                        <th width="15%" class="text-center" style="vertical-align:middle;"><?= $this->lang->line('uploadfile_thumbnail') ?></th>
                        <th width="52%" style="vertical-align:middle;"><?= $this->lang->line('uploadfile_filename') ?></th>
                        <th width="15%" class="text-center" style="vertical-align:middle;"><?= $this->lang->line('uploadfile_uploadtime') ?></th>
                        <th width="10%" class="text-center" style="vertical-align:middle;"><?= $this->lang->line('uploadfile_download') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <? if ($showfile === FALSE) { ?>
                        <tr>
                            <td colspan="5" class="text-center"><span class="h6 error"><?= $this->lang->line('uploadfile_filenotfound') ?></span></td>
                        </tr>                           
                    <? } else { ?>
                        <? foreach ($showfile as $file) { ?>
                            <tr>
                                <td class="text-center" style="vertical-align:middle;">
                                    <input type="checkbox" name="filedel[]" id="filedel" class="selall-chkbox" value="<?= $file["upload_file_id"] ?>">
                                </td>
                                <td class="text-center" style="vertical-align:middle;">
                                    <? 
                                    $ext = strtolower(pathinfo($file["file_upload"], PATHINFO_EXTENSION));
                                    if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif'){ ?>
                                    <img src="<?=BASE_URL.'/photo/upload/'.$file["file_upload"]?>" width="100">
                                    <? }else{ ?>
                                        <i class="glyphicon glyphicon-file"></i> <?=strtoupper($ext)?>
                                    <? } ?>
                                </td>
                                <td style="vertical-align:middle;">
                                    <span class="h5"><b><?= $file["file_upload"] ?></b></span>
                                    <div class="form-group has-warning">
                                        <div class="input-group">
                                            <div class="input-group-addon"><b><?= $this->lang->line('uploadfile_urlpath') ?></b></div>
                                            <input type="text" readonly class="form-control" id="full_url" value="<?= BASE_URL ?>/photo/upload/<?= $file["file_upload"] ?>" onfocus="this.select();" onmouseup="return false;">
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align:middle;">
                                    <span class="h5"><b><?= $file["timestamp_create"] ?></b></span>
                                </td>
                                <td class="text-center" style="vertical-align:middle;">
                                    <a href="<?= BASE_URL ?>/photo/upload/<?= $file["file_upload"] ?>" class="btn btn-primary" role="button" title="<?= $this->lang->line('uploadfile_download') ?>" target="_blank"><i class="glyphicon glyphicon-download"></i></a>
                                </td>
                            </tr>
                        <? } ?>
                    <? } ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <?
                $data = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'class' => 'btn btn-primary',
                    'value' => $this->lang->line('btn_delete'),
                    'onclick' => "return confirm('Are you sure you want to delete?');",
                );
                echo form_submit($data);
                ?>
            </div>
        </div>
        <?= form_close(); ?>
        <!-- /widget-content --> 
        <?php echo $this->pagination->create_links(); ?>
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
            case 'pdf':
            case 'doc':
            case 'docx':
            case 'odt':
            case 'txt':
            case 'odg':
            case 'odp':
            case 'ods':
            case 'zip':
            case 'rar':
            case 'psv':
            case 'xls':
            case 'xlsx':
            case 'ppt':
            case 'pptx':
            case 'mp3':
            case 'wav':
            case 'mp4':
            case 'wma':
            case 'flv':
            case 'avi':
            case 'mov':
            case 'm4v':
            case 'wmv':
            case 'm3u':
            case 'pls':
            break;
        default:
            alert('<?= $this->lang->line('uploadfile_fileallow') ?>');
            this.value='';
            var list = document.getElementById('filelist');
            list.innerHTML = '';
            list.style.display = 'none';
    }
};
</script>