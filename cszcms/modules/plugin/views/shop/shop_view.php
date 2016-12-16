<div class="container">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <br><br>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-3">
            <?php echo $this->Shop_model->rightCatMenu(); ?>
        </div>
        <div class="col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading text-right"><a class="btn btn-default btn-sm" href="<?php echo $this->csz_referrer->getIndex('front_shop'); ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $this->Csz_model->getLabelLang('btn_back'); ?></a></div>
                <div class="panel-body">
                    <h1><?php echo $product->product_name ?></h1>
                    <p><small><em><b><?php echo $this->Csz_model->getLabelLang('shop_product_category') ?>: <a href="<?php echo BASE_URL . '/plugin/shop/category/' . $this->Csz_model->rw_link($category_name) ?>" title="<?php echo $category_name ?>"><?php echo $category_name ?></a></b></em></small><br>
                    <b><?php echo $this->Csz_model->getLabelLang('shop_product_code_txt') ?>:</b> <?php echo ($product->product_code) ? $product->product_code : '-'; ?></p>
                    <hr>
                    <p><b><?php echo $product->short_desc ?></b></p><br>
                    <div class="row">
                        <?php
                        if ($image !== FALSE) {
                            $i = 1;
                            foreach ($image as $value) {
                                ?>
                                <div class="col-md-3" style="padding-bottom:15px;">
                                    <a href="<?php echo ($value['file_upload']) ? BASE_URL . '/photo/plugin/shop/' . $value['file_upload'] : BASE_URL . '/photo/no_image.png' ?>" data-toggle="lightbox" data-gallery="multiimages"<?php echo ($value['caption']) ? ' data-title="' . $value['caption'] . '"' : '' ?>>
                                        <img class="img-responsive img-thumbnail" src="<?php echo ($value['file_upload']) ? BASE_URL . '/photo/plugin/shop/' . $value['file_upload'] : BASE_URL . '/photo/no_image.png' ?>" alt="<?php echo $value['caption'] ?>">
                                    </a>                 
                                </div>
                                <?php if ($i % 4 == 0) { ?>
                                </div>
                                <div class="row">
                                    <?php
                                }
                                $i++;
                            }
                        } else {
                            ?>
                            <center><img src="<?php echo BASE_URL . '/photo/no_image.png' ?>" class="img-responsive img-thumbnail" alt="<?php echo $product->product_name ?>" width="150"></center><br>
                        <?php } ?>
                    </div>
                    <br><br>
                    <?php echo $this->Csz_model->getHtmlContent($product->full_desc, $this->uri->segment(6)) ?>
                    <hr>
                    <?php if ($product->stock) { ?>
                        <?php echo form_open(BASE_URL . '/plugin/shop/addCart/'.$product->shop_product_id); ?>
                        <?php                       
                        if ($form_option !== FALSE) {
                            echo '<h4>'.$this->Csz_model->getLabelLang('shop_option_txt').':</h4>';
                            foreach ($form_option as $value) {
                                $html = '';
                                if ($value['field_type'] == 'checkbox' || $value['field_type'] == 'radio' || $value['field_type'] == 'text') {
                                    $html.= '<label class="control-label">' . $value['field_label'] . '</label>
                                    <div class="controls">
                                        <input type="' . $value['field_type'] . '" name="' . $value['field_name'] . '" value="' . $value['field_value'] . '" class="form-control" placeholder="' . $value['field_placeholder'] . '"/>
                                    </div>';
                                } else if ($value['field_type'] == 'datepicker') {
                                    $html.= '<label class="control-label">' . $value['field_label'] . '</label>
                                    <div class="controls">
                                        <input type="text" name="' . $value['field_name'] . '" value="' . $value['field_value'] . '" class="form-control form-datepicker" placeholder="' . $value['field_placeholder'] . '"/>
                                    </div>';
                                } else if ($value['field_type'] == 'selectbox') {
                                    $opt_html = '';
                                    if ($value['field_sel_value']) {
                                        $opt_arr = explode(",", $value['field_sel_value']);
                                        foreach ($opt_arr as $opt) {
                                            list($val, $show) = explode("=>", $opt);
                                            $opt_html.= '<option value="' . trim($val) . '">' . trim($show) . '</option>';
                                        }
                                    }
                                    ($value['field_placeholder']) ? $placehol = '<option value="">' . $value['field_placeholder'] . '</option>' : $placehol = '';
                                    $html.= '<label class="control-label">' . $value['field_label'] . '</label>
                                    <select name="' . $value['field_name'] . '" class="form-control">
                                        ' . $placehol . '
                                        ' . $opt_html . '
                                    </select>';
                                } else if ($value['field_type'] == 'textarea') {
                                    $html.= '<label class="control-label">' . $value['field_label'] . '</label>
                                    <div class="controls">
                                        <textarea name="' . $value['field_name'] . '" class="form-control" placeholder="' . $value['field_placeholder'] . '" rows="4">' . $value['field_value'] . '</textarea>
                                    </div>';
                                } else if ($value['field_type'] == 'label') {
                                    $html.= '<label class="control-label">' . $value['field_label'] . '</label><br>';
                                }
                                echo $html;
                            }
                            echo '<br>';
                        }
                        if($product->discount){ ?>
                            <h4><span style="color:red;text-decoration:line-through;"><?php echo $this->Csz_model->getLabelLang('shop_price_txt') ?>: <?php echo number_format(($product->price),2).' '.$shop_config->currency_code ?></span></h4>
                            <h3><?php echo $this->Csz_model->getLabelLang('shop_special_price') ?>: <?php echo number_format(($product->price)-($product->discount),2).' '.$shop_config->currency_code ?></h3>
                        <?php }else{ ?>
                            <h3><?php echo $this->Csz_model->getLabelLang('shop_price_txt') ?>: <?php echo number_format(($product->price),2).' '.$shop_config->currency_code ?></h3>
                        <?php } ?>                        
                        <div class="control-group">
                            <label class="control-label" for="themes"><?php echo $this->Csz_model->getLabelLang('shop_qty_txt'); ?></label>
                            <div class="controls">
                                <?php
                                $att = 'id="qty" class="form-control"';
                                $data = array();
                                for($i=1;$i<=$product->stock;$i++) {
                                    $data[$i] = $i;
                                }
                                echo form_dropdown('qty', $data, '', $att);
                                ?>
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                        <hr>
                        <div class="form-actions">
                            <?php
                            $data = array(
                                'name' => 'submit',
                                'id' => 'submit',
                                'class' => 'btn btn-lg btn-primary',
                                'value' => $this->Csz_model->getLabelLang('shop_add_to_cart_btn'),
                            );
                            echo form_submit($data);
                            ?>
                        </div> <!-- /form-actions -->
                        <?php echo form_close(); ?>
                    <?php } else { ?>
                        <center><div class="h3 error"><?php echo $this->Csz_model->getLabelLang('shop_soldout_product') ?></div></center>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php if($product->fb_comment_active){ ?>
    <!-- Facebook Comments -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <?php 
            $fb_comment = $this->Csz_model->getFBComments(BASE_URL.'/plugin/shop/view/'.$product->shop_product_id.'/'.$product->url_rewrite, $product->fb_comment_limit, $product->fb_comment_sort, $this->session->userdata('fronlang_iso'));
            if($fb_comment !== FALSE){ echo $fb_comment; } ?>
        </div>
    </div>
    <!-- Facebook Comments -->
    <?php } ?>
</div>