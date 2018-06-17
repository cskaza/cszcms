<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-gift"></span></i> <?php echo $this->lang->line('pwidget_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('pwidget_header') ?> <a role="button" href="<?php echo $this->Csz_model->base_link()?>/admin/pwidget/addWidget" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo $this->lang->line('pwidget_new_header') ?></a></div>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="7%" class="text-center"><?php echo $this->lang->line('id_col_table'); ?></th>
                        <th width="25%" class="text-center" style="vertical-align: middle;"><?php echo $this->lang->line('pwidget_name'); ?></th>
                        <th width="20%" class="text-center" style="vertical-align: middle;"><?php echo $this->lang->line('pwidget_plugin'); ?></th>
                        <th width="15%" class="text-center" style="vertical-align: middle;"><?php echo $this->lang->line('pwidget_limit_view'); ?></th>
                        <th width="8%" class="text-center" style="vertical-align: middle;"><?php echo $this->lang->line('pages_lang'); ?></th>
                        <th width="25%" style="vertical-align: middle;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($widget === FALSE) { ?>
                        <tr>
                            <td colspan="6" class="text-center"><span class="h6 error"><?php echo $this->lang->line('data_notfound') ?></span></td>
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
                            echo '<td'.$inactive.' class="text-center">' . $u['plugin_widget_id'] . '</td>';
                            echo '<td'.$inactive.' class="text-center">' . $u['name'] . '</td>';
                            echo '<td'.$inactive.' class="text-center">' . $u['plugin_filename'] . '</td>';
                            echo '<td'.$inactive.' class="text-center">' . $u['data_limit'] . '</td>';
                            if($u['lang_iso'] && $u['lang_iso'] != NULL){
                                $lang_flag = '<i class="flag-icon flag-icon-'.$this->Csz_model->getCountryCode($u['lang_iso']).'"></i>';
                            }else{
                                $lang_flag = $this->lang->line('option_all');
                            }
                            echo '<td'.$inactive.' class="text-center">'.$lang_flag.'</td>';
                            echo '<td'.$inactive.' class="text-center"><a onclick="return confirm(\''.$this->lang->line('delete_message').'\')"  href="'.$this->Csz_model->base_link().'/admin/pwidget/asCopy/' . $u['plugin_widget_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-duplicate"></i>  '.$this->lang->line('btn_ascopy').'</a> &nbsp;&nbsp; <a href="'.$this->Csz_model->base_link().'/admin/pwidget/editWidget/' . $u['plugin_widget_id'] . '" class="btn btn-default btn-sm" role="button" title="'.$this->lang->line('btn_edit').'"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp;&nbsp;&nbsp; <a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.$this->Csz_model->base_link().'/admin/pwidget/delete/'.$u['plugin_widget_id'].'" title="'.$this->lang->line('btn_delete').'"><i class="glyphicon glyphicon-remove"></i></a></td>';
                            echo '</tr>';
                        }
                    }    ?>
                </tbody>
            </table>
        </div>
        <span class="remark"><?php echo $this->lang->line('pwidget_indexremark'); ?></span>
        <?php echo $this->pagination->create_links(); ?>
        <!-- /widget-content --> 
    </div>
</div>
