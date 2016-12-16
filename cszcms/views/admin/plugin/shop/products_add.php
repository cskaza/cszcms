<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <!-- Start Shop Admin Menu -->
        <?php echo $this->Shop_model->AdminMenu() ?>
        <!-- End Shop Admin Menu -->
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-edit"></span></i> <?php echo $this->lang->line('shop_products_addnew') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('shop_products_addnew') ?> <a class="btn btn-default btn-sm" href="<?php echo $this->csz_referrer->getIndex('shop'); ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $this->lang->line('btn_back'); ?></a></div>
        <?php echo form_open(BASE_URL . '/admin/plugin/shop/productNewSave'); ?>
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
                'value' => set_value('product_name', '', FALSE)
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
                echo form_dropdown('shop_category_id', $data, '', $att);
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
                'value' => set_value('keyword', '', FALSE)
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
                'value' => set_value('short_desc', '', FALSE)
            );
            echo form_input($data);
            ?>
        </div> <!-- /control-group -->
        <div class="control-group">
            <?php
            $starter_html = '<div class="row">
                                <div class="col-md-12">
                                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>
                                </div>
                                </div><br>';
            ?>
            <label class="control-label" for="content"><?php echo $this->lang->line('shop_products_full_desc'); ?></label>
            <textarea name="full_desc" id="full_desc" class="form-control body-tinymce"><?php echo $starter_html ?></textarea>
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
                'value' => set_value('price', '', FALSE)
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
                'value' => set_value('discount', '', FALSE)
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
                'value' => set_value('stock', '', FALSE)
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
                'value' => set_value('product_code', '', FALSE)
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
                echo form_dropdown('product_status', $data, '', $att);
                ?>
            </div> <!-- /controls -->
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
                ?> <?php echo $this->lang->line('shop_active'); ?></label>	
        </div> <!-- /control-group -->
        <hr>
        <div class="control-group">										
            <label class="form-control-static" for="fb_comment_active">
            <?php
            $data = array(
                'name' => 'fb_comment_active',
                'id' => 'fb_comment_active',
                'value' => '1',
                'checked' => 'checked'
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
                echo form_dropdown('fb_comment_limit', $data, 5, $att);
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
                echo form_dropdown('fb_comment_sort', $data, '', $att);
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
            <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex('shop'); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
        </div> <!-- /form-actions -->
        <?php echo form_close(); ?>
        <!-- /widget-content --> 
        <br><br>
        <span class="remark"><em><?php echo $this->lang->line('shop_products_remark'); ?></em></span>
    </div>
</div>