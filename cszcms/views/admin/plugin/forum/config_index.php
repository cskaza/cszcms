<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <!-- Start Shop Admin Menu -->
        <?php echo $this->Forum_model->AdminMenu() ?>
        <!-- End Shop Admin Menu -->
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-cog"></span></i> <?php echo $this->lang->line('forum_config') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<?php echo form_open_multipart(BASE_URL . '/admin/plugin/forum/configSave'); ?>
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