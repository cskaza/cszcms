<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <!-- Start Shop Admin Menu -->
        <?php echo $this->Shop_model->AdminMenu() ?>
        <!-- End Shop Admin Menu -->
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-cog"></span></i> <?php echo $this->lang->line('shop_config_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<?php echo form_open_multipart(BASE_URL . '/admin/plugin/shop/configSave'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('shop_config_header') ?></div>
            <div class="control-group">										
                <label class="form-control-static" for="stat_new_show">
                <?php
                if($settings->stat_new_show){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $data = array(
                    'name' => 'stat_new_show',
                    'id' => 'stat_new_show',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('shop_stat_new_show'); ?></label> <span class="remark"><em>*</em></span>
            </div> <!-- /control-group -->
            <div class="control-group">										
                <label class="form-control-static" for="stat_hot_show">
                <?php
                if($settings->stat_hot_show){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $data = array(
                    'name' => 'stat_hot_show',
                    'id' => 'stat_hot_show',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('shop_stat_hot_show'); ?></label> <span class="remark"><em>*</em></span>
            </div> <!-- /control-group -->
            <div class="control-group">										
                <label class="form-control-static" for="stat_bestseller_show">
                <?php
                if($settings->stat_bestseller_show){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $data = array(
                    'name' => 'stat_bestseller_show',
                    'id' => 'stat_bestseller_show',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('shop_stat_bestseller_show'); ?></label> <span class="remark"><em>*</em></span>	
            </div> <!-- /control-group -->
            <div class="control-group">										
                <label class="form-control-static" for="stat_soldout_show">
                <?php
                if($settings->stat_soldout_show){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $data = array(
                    'name' => 'stat_soldout_show',
                    'id' => 'stat_soldout_show',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('shop_stat_soldout_show'); ?></label> <span class="remark"><em>*</em></span>
            </div> <!-- /control-group -->
            <span class="remark"><em>* <?php echo $this->lang->line('shop_stat_remark'); ?></em></span>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('shop_payment_header') ?></div>
            <div class="control-group">										
                <label class="form-control-static" for="paypal_active">
                <?php
                if($settings->paypal_active){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $data = array(
                    'name' => 'paypal_active',
                    'id' => 'paypal_active',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('shop_paypal_active'); ?></label>	
            </div> <!-- /control-group -->
            <div class="control-group">										
                <label class="form-control-static" for="sanbox_active">
                <?php
                if($settings->sanbox_active){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $data = array(
                    'name' => 'sanbox_active',
                    'id' => 'sanbox_active',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('shop_sanbox_active'); ?></label> <span class="remark"><em><?php echo $this->lang->line('shop_sanbox_remark'); ?></em></span>
            </div> <!-- /control-group -->
            <div class="control-group">	
                <label class="control-label" for="paypal_email"><?php echo $this->lang->line('shop_paypal_email'); ?></label>
                <div class="controls">
                    <?php
                    $data = array(
                        'name' => 'paypal_email',
                        'id' => 'paypal_email',
                        'class' => 'form-control',
                        'value' => set_value('paypal_email', $settings->paypal_email, FALSE)
                    );
                    echo form_input($data); ?>
                </div> <!-- /controls -->				
            </div> <!-- /control-group -->
            <div class="control-group">										
                <label class="form-control-static" for="paysbuy_active">
                <?php
                if($settings->paysbuy_active){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $data = array(
                    'name' => 'paysbuy_active',
                    'id' => 'paysbuy_active',
                    'value' => '1',
                    'checked' => $checked
                );
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('shop_paysbuy_active'); ?></label>  <span class="remark"><em>**</em></span>
            </div> <!-- /control-group -->
            <div class="control-group">	
                <label class="control-label" for="paysbuy_email"><?php echo $this->lang->line('shop_paysbuy_email'); ?></label>  <span class="remark"><em>**</em></span>
                <div class="controls">
                    <?php
                    $data = array(
                        'name' => 'paysbuy_email',
                        'id' => 'paysbuy_email',
                        'class' => 'form-control',
                        'value' => set_value('paysbuy_email', $settings->paysbuy_email, FALSE)
                    );
                    echo form_input($data); ?>
                    <span class="remark"><em>** <?php echo $this->lang->line('shop_paysbuy_remark'); ?></em></span>
                </div> <!-- /controls -->				
            </div> <!-- /control-group -->
            <br>
            <div class="control-group">	
                <label class="control-label" for="bank_detail"><?php echo $this->lang->line('shop_bank_detail'); ?></label>
                <textarea name="bank_detail" id="bank_detail" class="form-control body-tinymce"><?php echo  $settings->bank_detail ?></textarea>
            </div> <!-- /control-group -->
            <div class="control-group">
                <label class="control-label" for="currency_code"><?php echo $this->lang->line('shop_currency_code'); ?></label>
                <div class="controls">
                    <?php
                    $att = 'id="currency_code" class="form-control"';
                    $data = array();
                    foreach ($currency_code as $key => $value) {
                        $data[$key] = $value.' ('.$key.')';
                    }
                    echo form_dropdown('currency_code', $data, $settings->currency_code, $att);
                    ?>
                    <span class="remark"><em></em></span>
                </div> <!-- /controls -->				
            </div> <!-- /control-group -->
            <br>
            <div class="h2 sub-header"><?php echo  $this->lang->line('shop_email_header') ?></div>
            <div class="control-group">	
                <label class="control-label" for="seller_email"><?php echo $this->lang->line('shop_seller_email'); ?></label>
                <div class="controls">
                    <?php
                    $data = array(
                        'name' => 'seller_email',
                        'id' => 'seller_email',
                        'class' => 'form-control',
                        'value' => set_value('seller_email', $settings->seller_email, FALSE)
                    );
                    echo form_input($data);
                    ?>
                </div> <!-- /controls -->				
            </div> <!-- /control-group -->
            <div class="control-group">	
                <label class="control-label" for="order_subject"><?php echo $this->lang->line('shop_order_subject'); ?></label>
                <div class="controls">
                    <?php
                    $data = array(
                        'name' => 'order_subject',
                        'id' => 'order_subject',
                        'class' => 'form-control',
                        'value' => set_value('order_subject', $settings->order_subject, FALSE)
                    );
                    echo form_input($data);
                    ?>
                </div> <!-- /controls -->				
            </div> <!-- /control-group -->
            <div class="control-group">	
                <label class="control-label" for="order_body"><?php echo $this->lang->line('shop_order_body'); ?></label>
                <textarea name="order_body" id="order_body" class="form-control body-tinymce"><?php echo  $settings->order_body ?></textarea>
            </div> <!-- /control-group -->
            <div class="control-group">	
                <label class="control-label" for="payment_subject"><?php echo $this->lang->line('shop_payment_subject'); ?></label>
                <div class="controls">
                    <?php
                    $data = array(
                        'name' => 'payment_subject',
                        'id' => 'payment_subject',
                        'class' => 'form-control',
                        'value' => set_value('payment_subject', $settings->payment_subject, FALSE)
                    );
                    echo form_input($data);
                    ?>
                </div> <!-- /controls -->				
            </div> <!-- /control-group -->
            <div class="control-group">	
                <label class="control-label" for="payment_body"><?php echo $this->lang->line('shop_payment_body'); ?></label>
                <textarea name="payment_body" id="payment_body" class="form-control body-tinymce"><?php echo  $settings->payment_body ?></textarea>
            </div> <!-- /control-group -->
            <div class="control-group">	
                <label class="control-label" for="signature"><?php echo $this->lang->line('shop_signature'); ?></label>
                <textarea name="signature" id="signature" class="form-control body-tinymce"><?php echo  $settings->signature ?></textarea>
            </div> <!-- /control-group -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <hr />
        <?php
        $data = array(
            'name' => 'submit',
            'id' => 'submit',
            'class' => 'btn btn-primary',
            'value' => $this->lang->line('btn_save'),
        );
        echo form_submit($data);
        ?>       
    </div>
</div>
<?php echo form_close(); ?>