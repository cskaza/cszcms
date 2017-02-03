<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <!-- Start Shop Admin Menu -->
        <?php echo $this->Shop_model->AdminMenu() ?>
        <!-- End Shop Admin Menu -->
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-edit"></span></i> <?php echo $this->lang->line('shop_category_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('shop_category_header') ?>  <a role="button" href="<?php echo BASE_URL?>/admin/plugin/shop/catNew" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('shop_category_addnew') ?></a></div>
        <?php echo  form_open(BASE_URL . '/admin/plugin/shop/catIndexSave'); ?>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="2%" class="text-center" style="vertical-align:middle;"><i class="glyphicon glyphicon-sort"></i></th>
                        <th width="58%" class="text-center"><?php echo $this->lang->line('shop_category_name'); ?></th>
                        <th width="20%" class="text-center"><?php echo $this->lang->line('shop_main_category'); ?></th>
                        <th width="20%"></th>
                    </tr>
                </thead>
                <tbody class="ui-sortable">
                    <?php if ($category === FALSE) { ?>
                        <tr>
                            <td colspan="4" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($category as $u) {
                            if(!$u['active']){
                                $inactive = ' style="vertical-align: middle;color:red;text-decoration:line-through;"';
                            }else{
                                $inactive = ' style="vertical-align: middle;"';
                            }
                            echo '<tr class="ui-state-default">';
                            echo '<td class="text-center" style="vertical-align:middle;" width="2%">
                                    <i class="glyphicon glyphicon-resize-vertical"></i>
                                    <input type="hidden" name="shop_category_id[]" value="'.$u['shop_category_id'].'">
                                </td>';
                            echo '<td'.$inactive.' width="58%">';
                            echo '<b>'.$u['name'].'</b><br>';
                            echo '<span style="color:red;"><small><em>'.$u['keyword'].'</em></small></span><br>';
                            echo $u['short_desc'];
                            echo '</td>';
                            echo '<td class="text-center"'.$inactive.' width="20%">'.$this->Shop_model->getMainCatName($u['shop_category_main_id']).'</td>';
                            echo '<td class="text-center" style="vertical-align: middle;" width="20%"><a href="'.BASE_URL.'/admin/plugin/shop/catEdit/' . $u['shop_category_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i> '.$this->lang->line('btn_edit').'</a> &nbsp;&nbsp; <a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.BASE_URL.'/admin/plugin/shop/catDel/'.$u['shop_category_id'].'"><i class="glyphicon glyphicon-remove"></i> '.$this->lang->line('btn_delete').'</a></td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <hr>
                <?php $data = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'class' => 'btn btn-primary',
                    'value' => $this->lang->line('btn_save'),
                );
                echo form_submit($data);
                ?>
            </div>
        </div>
        <?php echo form_close();?>
        <b><?php echo $this->lang->line('total').' '.$total_row.' '.$this->lang->line('records');?></b>
        <!-- /widget-content --> 
    </div>
</div>