<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <!-- Start Shop Admin Menu -->
        <?php echo $this->Shop_model->AdminMenu() ?>
        <!-- End Shop Admin Menu -->
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-edit"></span></i> <?php echo $this->lang->line('shop_category_addnew') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('shop_category_addnew') ?> <a class="btn btn-default btn-sm" href="<?php echo $this->csz_referrer->getIndex('shop'); ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $this->lang->line('btn_back'); ?></a></div>
        <?php echo form_open(BASE_URL . '/admin/plugin/shop/catNewSave'); ?>
        <div class="control-group">	
            <label class="control-label" for="shop_category_main_id"><?php echo $this->lang->line('shop_main_category'); ?></label>
            <div class="controls">
                <?php
                $att = 'id="shop_category_main_id" class="form-control"';
                $data = array();
                $data[''] = $this->lang->line('option_no');
                if (!empty($main_category)) {
                    foreach ($main_category as $c) {
                        $data[$c['shop_category_id']] = $c['name'];
                    }
                }
                echo form_dropdown('shop_category_main_id', $data, '', $att);
                ?>
            </div> <!-- /controls -->
        </div> <!-- /control-group -->
        <div class="control-group">	
            <label class="control-label" for="name"><?php echo $this->lang->line('shop_category_name'); ?>*</label>
            <?php
            $data = array(
                'name' => 'name',
                'id' => 'name',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'maxlength' => '255',
                'value' => set_value('name', '', FALSE)
            );
            echo form_input($data);
            ?>			
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