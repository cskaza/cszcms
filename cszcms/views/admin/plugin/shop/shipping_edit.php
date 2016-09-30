<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <!-- Start Shop Admin Menu -->
        <?php echo $this->Shop_model->AdminMenu() ?>
        <!-- End Shop Admin Menu -->
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-edit"></span></i> <?php echo $this->lang->line('shop_shipping_edit') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('shop_shipping_edit') ?> <a class="btn btn-default btn-sm" href="<?php echo $this->csz_referrer->getIndex('shop'); ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $this->lang->line('btn_back'); ?></a></div>
        <h4><?php echo $this->lang->line('shop_order_detail') ?></h4>
        <?php echo $payment->order_detail ?>
        <hr>
        <?php echo form_open(BASE_URL . '/admin/plugin/shop/editShippingSave/'.$shipping->shop_shipping_id); ?>
        <div class="control-group">	
            <label class="control-label" for="shipping_name"><?php echo $this->lang->line('shop_shipping_name'); ?>*</label>
            <?php
            $data = array(
                'name' => 'shipping_name',
                'id' => 'shipping_name',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('shipping_name', $shipping->shipping_name, FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="shipping_id"><?php echo $this->lang->line('shop_shipping_id'); ?>*</label>
            <?php
            $data = array(
                'name' => 'shipping_id',
                'id' => 'shipping_id',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '100',
                'value' => set_value('shipping_id', $shipping->shipping_id, FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">	
            <?php echo form_error('note', '<div class="error">', '</div>'); ?>
            <label class="control-label" for="note"><?php echo $this->lang->line('shop_shipping_note'); ?></label>
            <?php
            $data = array(
                'name' => 'note',
                'id' => 'note',
                'class' => 'form-control',
                'value' => set_value('note', $shipping->note, FALSE)
            );
            echo form_textarea($data);
            ?>
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
    </div>
</div>