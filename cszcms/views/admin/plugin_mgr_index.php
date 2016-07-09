<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-gift"></span></i> <?php echo  $this->lang->line('pluginmgr_header') ?>
            </li>
        </ol>
        <div class="h2 sub-header"><?php echo  $this->lang->line('pluginmgr_install') ?></div>
        <?php echo form_open_multipart(BASE_URL . '/admin/plugin/install'); ?>
        <?php
        $data = array(
            'name' => 'file_upload',
            'id' => 'file_upload',
            'class' => 'form-control-static',
            'accept' => '.zip'
        );
        echo form_upload($data); ?>
        <blockquote class="remark">
            <em><?php echo  $this->lang->line('pluginmgr_zip_remark') ?></em>
        </blockquote>
        <?php
        $data = array(
            'name' => 'submit',
            'id' => 'submit',
            'class' => 'btn btn-primary form-inline',
            'value' => $this->lang->line('btn_install'),
            'onclick' => "return confirm('".$this->lang->line('delete_message')."');",
        );
        echo form_submit($data); ?>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('pluginmgr_header') ?></div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="20%" class="text-center"><?php echo $this->lang->line('pluginmgr_status'); ?></th>
                        <th width="20%" class="text-center"><?php echo $this->lang->line('pluginmgr_name'); ?></th>
                        <th width="20%" class="text-center"><?php echo $this->lang->line('pluginmgr_version'); ?></th>
                        <th width="20%" class="text-center"><?php echo $this->lang->line('pluginmgr_owner'); ?></th>
                        <th width="20%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($plugin_mgr === FALSE) { ?>
                        <tr>
                            <td colspan="5" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($plugin_mgr as $u) {
                            if(!$u['plugin_active']){
                                $inactive = ' style="vertical-align: middle;color:red;text-decoration:line-through;"';
                                $status = '<span style="color:red;">Deactivated</span>';
                            }else{
                                $inactive = '';
                                $status = '<span style="color:green;">Activated</span>';
                            }
                            
                            echo '<tr>';
                            echo '<td'.$inactive.' class="text-center">' . $status . '</td>';
                            echo '<td'.$inactive.' class="text-center">' . $u['plugin_name'] . '</td>';
                            echo '<td'.$inactive.' class="text-center">' . $u['plugin_version'] . '</td>';
                            echo '<td'.$inactive.' class="text-center">' . ucfirst($u['plugin_owner']) . '</td>';
                            echo '<td class="text-center">';
                            if($u['plugin_active']){
                                echo '<a href="'.BASE_URL.'/admin/plugin/' . $u['plugin_urlrewrite'] . '" class="btn btn-primary btn-sm" role="button"><i class="glyphicon glyphicon-cog"></i> '.$this->lang->line('pluginmgr_manage').'</a> &nbsp;&nbsp; ';
                            }
                            if(!$u['plugin_active']){
                                echo '<a role="button" class="btn btn-success btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.BASE_URL.'/admin/plugin/setstatus/'.$u['plugin_manager_id'].'"><i class="glyphicon glyphicon-ok"></i> '.$this->lang->line('pluginmgr_enable').'</a>';
                            }else{
                                echo '<a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.BASE_URL.'/admin/plugin/setstatus/'.$u['plugin_manager_id'].'"><i class="glyphicon glyphicon-remove"></i> '.$this->lang->line('pluginmgr_disable').'</a>';
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->pagination->create_links(); ?> <b><?php echo $this->lang->line('total').' '.$total_row.' '.$this->lang->line('records');?></b>
    </div>
</div>