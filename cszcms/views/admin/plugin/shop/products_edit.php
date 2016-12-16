<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <!-- Start Shop Admin Menu -->
        <?php echo $this->Shop_model->AdminMenu() ?>
        <!-- End Shop Admin Menu -->
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-edit"></span></i> <?php echo $this->lang->line('shop_products_edit') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('shop_products_edit') ?> <a class="btn btn-default btn-sm" href="<?php echo $this->csz_referrer->getIndex('shop'); ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $this->lang->line('btn_back'); ?></a></div>
        <?php echo form_open_multipart(BASE_URL . '/admin/plugin/shop/productEditSave/'.$this->uri->segment(5)); ?>
        <div class="control-group">	
            <label class="control-label" for="product_name"><?php echo $this->lang->line('shop_products_name'); ?>*</label>
            <?php
            $data = array(
                'name' => 'product_name',
                'id' => 'product_name',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('product_name', $product->product_name, FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="shop_category_id"><?php echo $this->lang->line('shop_category_header'); ?>*</label>
            <div class="controls">
                <?php
                $att = 'id="shop_category_id" class="form-control" required="required"';
                $data = array();
                $data[''] = $this->lang->line('option_choose');
                if (!empty($category)) {
                    foreach ($category as $c) {
                        $data[$c['shop_category_id']] = $c['name'];
                    }
                }
                echo form_dropdown('shop_category_id', $data, $product->shop_category_id, $att);
                ?>
            </div> <!-- /controls -->
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="keyword"><?php echo $this->lang->line('shop_cat_keyword'); ?></label>
            <?php
            $data = array(
                'name' => 'keyword',
                'id' => 'keyword',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('keyword', $product->keyword, FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">	
            <?php echo form_error('short_desc', '<div class="error">', '</div>'); ?>
            <label class="control-label" for="short_desc"><?php echo $this->lang->line('shop_cat_short_desc'); ?>*</label>
            <?php
            $data = array(
                'name' => 'short_desc',
                'id' => 'short_desc',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('short_desc', $product->short_desc, FALSE)
            );
            echo form_input($data);
            ?>
        </div> <!-- /control-group -->
        <div class="control-group">
            <label class="control-label" for="full_desc"><?php echo $this->lang->line('shop_products_full_desc'); ?></label>
            <textarea name="full_desc" id="full_desc" class="form-control body-tinymce"><?php echo $product->full_desc; ?></textarea>
        </div> <!-- /control-group -->
        <div class="control-group">	
            <?php echo form_error('price', '<div class="error">', '</div>'); ?>
            <label class="control-label" for="price"><?php echo $this->lang->line('shop_products_fullprice'); ?>*</label>
            <?php
            $data = array(
                'name' => 'price',
                'id' => 'price',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control keypress-number',
                'value' => set_value('price', $product->price, FALSE)
            );
            echo form_input($data);
            ?>
        </div> <!-- /control-group -->
        <div class="control-group">	
            <?php echo form_error('discount', '<div class="error">', '</div>'); ?>
            <label class="control-label" for="discount"><?php echo $this->lang->line('shop_products_discount'); ?></label>
            <?php
            $data = array(
                'name' => 'discount',
                'id' => 'discount',
                'class' => 'form-control keypress-number',
                'value' => set_value('discount', $product->discount, FALSE)
            );
            echo form_input($data);
            ?>
        </div> <!-- /control-group -->
        <div class="control-group">	
            <?php echo form_error('stock', '<div class="error">', '</div>'); ?>
            <label class="control-label" for="stock"><?php echo $this->lang->line('shop_products_stock'); ?>*</label>
            <?php
            $data = array(
                'name' => 'stock',
                'id' => 'stock',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control keypress-number',
                'maxlength' => '3',
                'value' => set_value('stock', $product->stock, FALSE)
            );
            echo form_input($data);
            ?>
        </div> <!-- /control-group -->
        <div class="control-group">	
            <?php echo form_error('product_code', '<div class="error">', '</div>'); ?>
            <label class="control-label" for="product_code"><?php echo $this->lang->line('shop_products_code'); ?></label>
            <?php
            $data = array(
                'name' => 'product_code',
                'id' => 'product_code',
                'class' => 'form-control',
                'maxlength' => '100',
                'value' => set_value('product_code', $product->product_code, FALSE)
            );
            echo form_input($data);
            ?>
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="product_status"><?php echo $this->lang->line('shop_products_status'); ?></label>
            <div class="controls">
                <?php
                $att = 'id="product_status" class="form-control"';
                $data = array();
                $data[''] = $this->lang->line('option_choose');
                if (!empty($product_status)) {
                    foreach ($product_status as $key => $value) {
                        $data[$key] = $value;
                    }
                }
                echo form_dropdown('product_status', $data, $product->product_status, $att);
                ?>
            </div> <!-- /controls -->
        </div> <!-- /control-group -->
        <br>
        <div class="control-group">										
            <label class="form-control-static" for="active">
                <?php
                if ($product->active) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $data = array(
                    'name' => 'active',
                    'id' => 'active',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('shop_active'); ?></label>	
        </div> <!-- /control-group -->
        <hr>
        <div class="control-group">										
            <label class="form-control-static" for="fb_comment_active">
            <?php
            if($product->fb_comment_active){
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
                echo form_dropdown('fb_comment_limit', $data, $product->fb_comment_limit, $att);
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
                echo form_dropdown('fb_comment_sort', $data, $product->fb_comment_sort, $att);
                ?>
            </div> <!-- /controls -->				
        </div> <!-- /control-group -->
        <div class="h2 sub-header"><?php echo $this->lang->line('shop_products_options') ?></div>
        <div class="addfields">
            <?php
            if (!empty($field_rs)) {
                foreach ($field_rs as $field_val) {
                    ?>    
                    <div class="panel panel-primary">
                        <div class="panel-body row">
                            <div class="col-md-6">
                                <input type="hidden" name="shop_product_option_id[]" id="shop_product_option_id" value="<?php echo $field_val['shop_product_option_id'] ?>">
                                <div class="control-group">
                                    <label class="control-label" for="field_type1"><?php echo $this->lang->line('field_type'); ?></label>
                                    <?php
                                    $att = 'id="field_type1" class="form-control"';
                                    $data = array();
                                    $data['checkbox'] = 'checkbox';
                                    $data['datepicker'] = 'datepicker';
                                    $data['label'] = 'label';
                                    $data['radio'] = 'radio';
                                    $data['selectbox'] = 'selectbox';
                                    $data['text'] = 'text';
                                    $data['textarea'] = 'textarea';
                                    echo form_dropdown('field_type1[]', $data, $field_val['field_type'], $att);
                                    ?>
                                </div>            
                                <div class="control-group">	
                                    <label class="control-label" for="field_name1"><?php echo $this->lang->line('field_name'); ?>*</label>
                                    <input type="text" name="field_name1[]" id="field_name1" class="form-control" value="<?php echo $field_val['field_name'] ?>">
                                    <input type="hidden" name="field_oldname[]" id="field_oldname" value="<?php echo $field_val['field_name'] ?>">
                                </div>
                                <div class="control-group">	
                                    <label class="control-label" for="field_placeholder1"><?php echo $this->lang->line('field_placeholder'); ?></label>
                                    <input type="text" name="field_placeholder1[]" id="field_placeholder1" class="form-control" value="<?php echo $field_val['field_placeholder'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">	
                                    <label class="control-label" for="field_value1"><?php echo $this->lang->line('field_value'); ?></label>
                                    <input type="text" name="field_value1[]" id="field_value1" class="form-control" value="<?php echo $field_val['field_value'] ?>">
                                </div>
                                <div class="control-group">	
                                    <label class="control-label" for="field_label1"><?php echo $this->lang->line('field_label'); ?>*</label>
                                    <input type="text" name="field_label1[]" id="field_label1" class="form-control" value="<?php echo $field_val['field_label'] ?>">
                                </div>
                                <div class="control-group">	
                                    <label class="control-label" for="field_sel_value1"><?php echo $this->lang->line('sel_option_val'); ?></label>
                                    <input type="text" name="field_sel_value1[]" id="field_sel_value1" class="form-control" value="<?php echo $field_val['field_sel_value'] ?>">
                                    <span class="remark"><em><?php echo $this->lang->line('sel_option_val_info'); ?></em></span>
                                </div>
                                <br>
                                <div class="control-group text-right">
                                    <a class="btn btn-danger" role="button" onclick="return confirm('<?php echo $this->lang->line('forms_delete_msg') ?>')" href="<?php echo BASE_URL . '/admin/plugin/shop/delProductField/' . $field_val['shop_product_option_id'] ?>">
                                        <span class="glyphicon glyphicon-minus"></span>
                                    </a>
                                </div>
                            </div>                   
                        </div>
                    </div>
                <?php }
            }
            ?>
            <div class="entry panel panel-default">
                <div class="panel-body row">
                    <div class="col-md-6">
                        <div class="control-group">
                            <label class="control-label" for="field_type"><?php echo $this->lang->line('field_type'); ?></label>
                            <select id="field_type" name="field_type[]" class="form-control">
                                <option value="checkbox">checkbox</option>
                                <option value="datepicker">datepicker</option>
                                <option value="label">label</option>
                                <option value="radio">radio</option>
                                <option value="selectbox">selectbox</option>
                                <option value="text">text</option>
                                <option value="textarea">textarea</option>
                            </select>
                        </div>            
                        <div class="control-group">	
                            <label class="control-label" for="field_name"><?php echo $this->lang->line('field_name'); ?>*</label>
                            <input type="text" name="field_name[]" id="field_name" class="form-control">
                        </div>
                        <div class="control-group">	
                            <label class="control-label" for="field_placeholder"><?php echo $this->lang->line('field_placeholder'); ?></label>
                            <input type="text" name="field_placeholder[]" id="field_placeholder" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="control-group">	
                            <label class="control-label" for="field_value"><?php echo $this->lang->line('field_value'); ?></label>
                            <input type="text" name="field_value[]" id="field_value" class="form-control">
                        </div>
                        <div class="control-group">	
                            <label class="control-label" for="field_label"><?php echo $this->lang->line('field_label'); ?>*</label>
                            <input type="text" name="field_label[]" id="field_label" class="form-control">
                        </div>
                        <div class="control-group">	
                            <label class="control-label" for="field_sel_value"><?php echo $this->lang->line('sel_option_val'); ?></label>
                            <input type="text" name="field_sel_value[]" id="field_sel_value" class="form-control">
                            <span class="remark"><em><?php echo $this->lang->line('sel_option_val_info'); ?></em></span>
                        </div>
                        <br>
                        <div class="control-group text-right">
                            <button class="btn btn-success btn-fields-add" type="button">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
        <div class="text-right"><?php echo $this->lang->line('field_addtxtinfo') ?></div>
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
            <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex('shop'); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
        </div> <!-- /form-actions -->
<?php echo form_close(); ?>
        <!-- /widget-content --> 
    </div>
</div>
<!-- /.row -->
<br><br>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('shop_products_upload') ?></div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
<?php echo form_open_multipart(BASE_URL . '/admin/plugin/shop/htmlUpload/' . $this->uri->segment(5)) ?>
                <div class="row form-control-static">
                    <div class="col-lg-12 col-md-12">
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span><?php echo $this->lang->line('uploadfile_add_file') ?></span>
                            <input type="file" name="files[]" id="files" multiple required accept=".jpg, .jpeg, .png, .gif">
                        </span>
                        <button type="submit" class="btn btn-primary">
                            <i class="glyphicon glyphicon-upload"></i>
                            <span><?php echo $this->lang->line('btn_upload') ?></span>
                        </button>
                        <button type="reset" class="btn btn-warning" id="reset">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span><?php echo $this->lang->line('btn_cancel') ?></span>
                        </button>
                        <pre id="filelist" style="display:none;"></pre>
                    </div>
                </div>
<?php echo form_close(); ?>       
            </div>
        </div>
        <br>
        <blockquote class="remark">
            <em><?php echo $this->lang->line('shop_products_fileallow') ?></em>
        </blockquote>
<?php echo form_open(BASE_URL . '/admin/plugin/shop/uploadIndexSave'); ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="2%" class="text-center" style="vertical-align:middle;"><i class="glyphicon glyphicon-sort"></i></th>
                        <th width="8%" class="text-center" style="vertical-align:middle;"><label><input id="sel-chkbox-all" type="checkbox"> <?php echo $this->lang->line('btn_delete') ?></label></th>                           
                        <th width="15%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('uploadfile_thumbnail') ?></th>
                        <th width="60%" style="vertical-align:middle;"><?php echo $this->lang->line('uploadfile_filename') ?></th>
                        <th width="15%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('uploadfile_uploadtime') ?></th>
                    </tr>
                </thead>
                <tbody class="ui-sortable">
<?php if ($showfile === FALSE) { ?>
                        <tr>
                            <td colspan="5" class="text-center"><span class="h6 error"><?php echo $this->lang->line('uploadfile_filenotfound') ?></span></td>
                        </tr>                           
<?php } else { ?>
    <?php foreach ($showfile as $file) { ?>
                            <tr class="ui-state-default">
                                <td class="text-center" style="vertical-align:middle;"><i class="glyphicon glyphicon-resize-vertical"></i></td>
                                <td class="text-center" style="vertical-align:middle;">
                                    <input type="hidden" name="shop_product_imgs_id[]" value="<?php echo $file["shop_product_imgs_id"] ?>">
                                    <input type="checkbox" name="filedel[]" id="filedel" class="selall-chkbox" value="<?php echo $file["shop_product_imgs_id"] ?>">
                                </td>
                                <td class="text-center" style="vertical-align:middle;">
                                    <?php
                                    $ext = strtolower(pathinfo($file["file_upload"], PATHINFO_EXTENSION));
                                    if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                                        ?>
                                        <img src="<?php echo BASE_URL . '/photo/plugin/shop/' . $file["file_upload"] ?>" width="100">
                                    <?php } else { ?>
                                        <i class="glyphicon glyphicon-file"></i> OTHER
        <?php } ?>
                                </td>
                                <td style="vertical-align:middle;">
                                    <span class="h5"><b><?php echo $file["file_upload"]; ?></b></span>
                                    <div class="form-group has-feedback">
                                        <div class="input-group">
                                            <div class="input-group-addon"><b><?php echo $this->lang->line('shop_products_caption') ?></b></div>
                                            <input style="z-index: 1;" type="text" class="form-control" id="caption" name="caption[<?php echo $file["shop_product_imgs_id"] ?>]" value="<?php echo $file["caption"] ?>">
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
                    'onclick' => "return confirm('" . $this->lang->line('delete_message') . "');",
                );
                echo form_submit($data);
                ?>
                <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex('shop'); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
            </div>
        </div>
<?php echo form_close(); ?>
        <!-- /widget-content --> 
        <br><br>
        <b><?php echo $this->lang->line('total') . ' ' . $total_row . ' ' . $this->lang->line('records'); ?></b>
    </div>
</div>
<script type="text/javascript">
    document.getElementById('files').addEventListener('change', function (e) {
        var list = document.getElementById('filelist');
        list.innerHTML = '';
        for (var i = 0; i < this.files.length; i++) {
            list.innerHTML += (i + 1) + '. ' + this.files[i].name + '\n';
        }
        if (list.innerHTML == '')
            list.style.display = 'none';
        else
            list.style.display = 'block';
    });
    document.getElementById('reset').addEventListener('click', function (e) {
        var list = document.getElementById('filelist');
        list.innerHTML = '';
        list.style.display = 'none';
    });
    var fl = document.getElementById('files');

    fl.onchange = function (e) {
        var exts = this.value.substring(this.value.lastIndexOf('.') + 1).toLowerCase();
        var ext = exts.toLowerCase();
        switch (ext)
        {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                break;
            default:
                alert('<?php echo $this->lang->line('shop_products_fileallow') ?>');
                this.value = '';
                var list = document.getElementById('filelist');
                list.innerHTML = '';
                list.style.display = 'none';
        }
    };
</script>
<script src="<?php echo base_url() ?>assets/js/jquery.mobile-1.4.0-alpha.2.min.js"></script>