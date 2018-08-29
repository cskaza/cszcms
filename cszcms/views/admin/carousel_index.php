<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-picture"></span></i> <?php echo $this->lang->line('carousel_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('carousel_header') ?> <a role="button" href="<?php echo $this->Csz_model->base_link()?>/admin/carousel/add" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('carousel_new') ?></a></div>        
        <?php echo  form_open($this->Csz_model->base_link(). '/admin/carousel/deleteIndex'); ?>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="10%" class="text-center" style="vertical-align:middle;"><label><input id="sel-chkbox-all" type="checkbox"> <?php echo  $this->lang->line('btn_delete') ?></label></th>
                        <th width="15%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('id_col_table'); ?></th>
                        <th width="35%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('carousel_name'); ?></th>
                        <th width="20%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('carousel_customtemp_active'); ?></th>                      
                        <th width="20%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($carousel === FALSE) { ?>
                        <tr>
                            <td colspan="4" class="text-center"><span class="h6 error"><?php echo $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($carousel as $u) {
                            if(!$u['active']){
                                $inactive = ' style="vertical-align:middle;color:red;text-decoration:line-through;"';
                            }else{
                                $inactive = ' style="vertical-align:middle;"';
                            }
                            if($u['custom_temp_active']){
                                $custom_temp_active = '<i class="success glyphicon glyphicon-ok"></i>';
                            }else{
                                $custom_temp_active = '<i class="error glyphicon glyphicon-remove"></i>';
                            }
                            echo '<tr>';
                            echo '<td class="text-center" style="vertical-align:middle;">
                                    <input type="checkbox" name="delR[]" id="delR" class="selall-chkbox" value="'.$u['carousel_widget_id'].'">
                                </td>'; 
                            echo '<td class="text-center"'.$inactive.'>' . $u['carousel_widget_id'] . '</td>';
                            echo '<td class="text-center"'.$inactive.'>' . $u['name'] . '</td>';
                            echo '<td class="text-center"'.$inactive.'>' . $custom_temp_active . '</td>';
                            echo '<td class="text-center"'.$inactive.'><a href="'.$this->Csz_model->base_link().'/admin/carousel/edit/' . $u['carousel_widget_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>  '.$this->lang->line('btn_edit').'</a>';
                            echo '</td></tr>';
                        }
                        ?>
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
                    'class' => 'btn btn-primary',
                    'value' => $this->lang->line('btn_delete'),
                    'onclick' => "return confirm('".$this->lang->line('delete_message')."');",
                );
                echo form_submit($data);
                ?>
            </div>
        </div>
        <?php echo  form_close(); ?><br>
        <span class="remark"><?php echo $this->lang->line('carousel_indexremark'); ?></span><br><br>
        <?php echo $this->pagination->create_links(); ?> <b><?php echo $this->lang->line('total').' '.$total_row.' '.$this->lang->line('records');?></b>
        <!-- /widget-content -->
    </div>
</div>
