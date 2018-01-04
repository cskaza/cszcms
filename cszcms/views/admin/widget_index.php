<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-gift"></span></i> <?php echo  $this->lang->line('widget_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('widget_header') ?>  <a role="button" href="<?php echo $this->Csz_model->base_link()?>/admin/widget/addWidget" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('widget_new_header') ?></a></div>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="7%" class="text-center"><?php echo $this->lang->line('id_col_table'); ?></th>
                        <th width="23%" class="text-center" style="vertical-align: middle;"><?php echo $this->lang->line('widget_name'); ?></th>
                        <th width="38%" class="text-center" style="vertical-align: middle;"><?php echo $this->lang->line('widget_xml_url'); ?></th>
                        <th width="12%" class="text-center" style="vertical-align: middle;"><?php echo $this->lang->line('widget_limit_view'); ?></th>
                        <th width="20%" style="vertical-align: middle;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($widget === FALSE) { ?>
                        <tr>
                            <td colspan="5" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($widget as $u) {
                            if(!$u['active']){
                                $inactive = ' style="vertical-align:middle;color:red;text-decoration:line-through;"';
                            }else{
                                $inactive = ' style="vertical-align:middle;"';
                            }
                            echo '<tr>';
                            echo '<td class="text-center"'.$inactive.'>' . $u['widget_xml_id'] . '</td>';
                            echo '<td'.$inactive.' class="text-center">' . $u['widget_name'] . '</td>';
                            echo '<td'.$inactive.'>' . $u['xml_url'] . '</td>';
                            echo '<td'.$inactive.' class="text-center">' . $u['limit_view'] . '</td>';
                            echo '<td'.$inactive.' class="text-center"><a href="'.$this->Csz_model->base_link().'/admin/widget/editWidget/' . $u['widget_xml_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>  '.$this->lang->line('btn_edit').'</a> &nbsp;&nbsp;&nbsp; <a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.$this->Csz_model->base_link().'/admin/widget/delete/'.$u['widget_xml_id'].'"><i class="glyphicon glyphicon-remove"></i> '.$this->lang->line('btn_delete').'</a></td>';
                            echo '</tr>';
                        }
                    }    ?>
                </tbody>
            </table>
        </div>
        <span class="remark"><?php echo $this->lang->line('widget_indexremark'); ?></span>
        <?php echo $this->pagination->create_links(); ?>
        <!-- /widget-content --> 
    </div>
</div>
