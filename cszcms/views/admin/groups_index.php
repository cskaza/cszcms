<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-gift"></span></i> <?php echo  $this->lang->line('user_group_txt') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('user_group_txt') ?>  <a role="button" href="<?php echo $this->Csz_model->base_link()?>/admin/groups/add" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('user_group_new') ?></a></div>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="8%" class="text-center" style="vertical-align: middle;"><?php echo $this->lang->line('id_col_table'); ?></th>
                        <th width="30%" class="text-center" style="vertical-align: middle;"><?php echo $this->lang->line('user_group_name'); ?></th>
                        <th width="36%" class="text-center" style="vertical-align: middle;"><?php echo $this->lang->line('user_group_definition'); ?></th>
                        <th width="26%" style="vertical-align: middle;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($groups === FALSE) { ?>
                        <tr>
                            <td colspan="4" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($groups as $u) {
                            echo '<tr>';
                            echo '<td class="text-center" style="vertical-align: middle;">' . $u['user_groups_id'] . '</td>';
                            echo '<td class="text-center" style="vertical-align: middle;">' . $u['name'] . '</td>';
                            echo '<td style="vertical-align: middle;">' . $u['definition'] . '</td>';
                            if($u['user_groups_id'] != 1){
                                $ascopy = '<a onclick="return confirm(\''.$this->lang->line('delete_message').'\')"  href="'.$this->Csz_model->base_link().'/admin/groups/asCopy/' . $u['user_groups_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-duplicate"></i>  '.$this->lang->line('btn_ascopy').'</a> &nbsp;&nbsp; ';
                            }else{
                                $ascopy = '';
                            }
                            echo '<td class="text-center" style="vertical-align: middle;">'.$ascopy.'<a href="'.$this->Csz_model->base_link().'/admin/groups/edit/' . $u['user_groups_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>  '.$this->lang->line('btn_edit').'</a> &nbsp;&nbsp; <a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.$this->Csz_model->base_link().'/admin/groups/delete/'.$u['user_groups_id'].'"><i class="glyphicon glyphicon-remove"></i> '.$this->lang->line('btn_delete').'</a></td>';
                            echo '</tr>';
                        }
                    }    ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->pagination->create_links(); ?> <b><?php echo $this->lang->line('total').' '.$total_row.' '.$this->lang->line('records');?></b>
        <!-- /widget-content --> 
    </div>
</div>
