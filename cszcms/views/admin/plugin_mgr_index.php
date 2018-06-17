<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-gift"></span></i> <?php echo $this->lang->line('pluginmgr_header') ?> & <?php echo $this->lang->line('pluginmgr_install') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('pluginmgr_header') ?></div>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="20%" class="text-center"><?php echo $this->lang->line('pluginmgr_status'); ?></th>
                        <th width="20%" class="text-center"><?php echo $this->lang->line('pluginmgr_name'); ?></th>
                        <th width="15%" class="text-center"><?php echo $this->lang->line('pluginmgr_version'); ?></th>
                        <th width="20%" class="text-center"><?php echo $this->lang->line('pluginmgr_owner'); ?></th>
                        <th width="25%"></th>
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
                                $status = '<span style="color:red;">'.$this->lang->line('pluginmgr_disable').'</span>';
                            }else{
                                $inactive = '';
                                $status = '<span style="color:green;">'.$this->lang->line('pluginmgr_enable').'</span>';
                            }
                            
                            echo '<tr>';
                            echo '<td class="text-center" style="vertical-align: middle;">' . $status . '</td>';
                            echo '<td'.$inactive.' class="text-center" style="vertical-align: middle;">' . $this->Csz_model->getPluginConfig($u['plugin_config_filename'], 'plugin_name') . ' (' . $u['plugin_config_filename'] . ')</td>';
                            echo '<td'.$inactive.' class="text-center" style="vertical-align: middle;">' . $this->Csz_model->getPluginConfig($u['plugin_config_filename'], 'plugin_version') . '</td>';
                            echo '<td'.$inactive.' class="text-center" style="vertical-align: middle;">' . ucfirst($this->Csz_model->getPluginConfig($u['plugin_config_filename'], 'plugin_author')) . '</td>';
                            echo '<td class="text-center" style="vertical-align: middle;">';
                            if($u['plugin_active']){
                                echo '<a href="'.$this->Csz_model->base_link().'/admin/plugin/' . $this->Csz_model->getPluginConfig($u['plugin_config_filename'], 'plugin_urlrewrite') . '" class="btn btn-primary btn-sm" role="button"><i class="glyphicon glyphicon-cog"></i> '.$this->lang->line('pluginmgr_manage').'</a> &nbsp;&nbsp; ';
                            }
                            if(!$u['plugin_active']){
                                echo '<a role="button" class="btn btn-success btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.$this->Csz_model->base_link().'/admin/plugin/setstatus/'.$u['plugin_manager_id'].'"><i class="glyphicon glyphicon-ok"></i> '.$this->lang->line('pluginmgr_enable').'</a>';
                            }else{
                                echo '<a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.$this->Csz_model->base_link().'/admin/plugin/setstatus/'.$u['plugin_manager_id'].'"><i class="glyphicon glyphicon-remove"></i> '.$this->lang->line('pluginmgr_disable').'</a>';
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <b><?php echo $this->lang->line('total').' '.$total_row.' '.$this->lang->line('records');?></b>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('pluginmgr_store') ?></div>
        <form action="<?php echo $this->Csz_model->base_link(). '/admin/plugin/'; ?>" method="get">
            <div class="control-group">
                <label class="control-label" for="search"><?php echo $this->lang->line('pluginmgr_config_filename').' '.$this->lang->line('search'); ?>:</label><br><input type="text" name="search" id="search" class="form-control-static" value="<?php echo $this->input->get('search');?>"> &nbsp;&nbsp;&nbsp; <input type="submit" name="submit" id="submit" class="btn btn-default" value="<?php echo $this->lang->line('search'); ?>">
            </div>
        </form>
        <br><br>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="20%" class="text-center"><?php echo $this->lang->line('pluginmgr_config_filename'); ?></th>
                        <th width="30%" class="text-center"><?php echo $this->lang->line('pluginmgr_desc'); ?></th>
                        <th width="15%" class="text-center"><?php echo $this->lang->line('pluginmgr_latest_version'); ?></th>
                        <th width="15%" class="text-center"><?php echo $this->lang->line('pluginmgr_version'); ?></th>
                        <th width="20%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($this->Csz_admin_model->chkVerUpdate($this->Csz_model->getVersion()) !== FALSE){ ?>
                        <tr>
                            <td colspan="5" class="text-center"><a href="<?php echo $this->Csz_model->base_link()?>/admin/upgrade"><span class="h6 error"><?php echo $this->lang->line('upgrade_newlast_alert') ?></span></a></td>
                        </tr>
                    <?php }
                    if ($plugin_list === FALSE) { ?>
                        <tr>
                            <td colspan="5" class="text-center"><span class="h6 error"><?php echo $this->lang->line('data_notfound') ?></span></td>
                        </tr>
                    <?php } else { ?>
                        <?php
                        foreach ($plugin_list as $xml) {
                            $last_ver = &$xml->version;
                            $filename = &$xml->filename;
                            echo '<tr>';
                            echo '<td class="text-center" style="vertical-align: middle;">' . $filename . '</td>';
                            echo '<td style="vertical-align: middle;">' . $xml->desc . '</td>';
                            echo '<td class="text-center" style="vertical-align: middle;">' . $last_ver . '</td>';
                            echo '<td class="text-center" style="vertical-align: middle;">';
                            if($this->Csz_admin_model->chkPluginInst($filename) !== FALSE){
                                $cur_ver = $this->Csz_model->getPluginConfig($filename, 'plugin_version');
                                if($this->Csz_admin_model->chkPluginUpdate($cur_ver, $last_ver) !== FALSE){
                                    echo '<span style="color:red;"><b>'.$cur_ver.'</b></span>';
                                }else{
                                    echo $cur_ver;
                                }
                            }else{
                                echo '-';
                            }
                            echo '</td>';
                            echo '<td class="text-center" style="vertical-align: middle;">';
                            if ($this->Csz_admin_model->chkPluginInst($filename) !== FALSE) {
                                if ($this->Csz_admin_model->chkPluginUpdate($cur_ver, $last_ver) !== FALSE && $this->Csz_admin_model->chkVerUpdate($this->Csz_model->getVersion()) === FALSE) {
                                    echo '<a role="button" class="btn btn-warning btn-sm" role="button" onclick="return confirm(\'' . $this->lang->line('delete_message') . '\')" href="' . $this->Csz_model->base_link() . '/admin/plugin/upgrade/' . $filename . '">' . $this->lang->line('pluginmgr_upgrade') . '</a> &nbsp;&nbsp; ';
                                }
                                if($filename != 'article' && $filename != 'gallery'){
                                    echo '<a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\'' . $this->lang->line('delete_message') . '\')" href="' . $this->Csz_model->base_link() . '/admin/plugin/uninstall/' . $filename . '" title="' . $this->lang->line('btn_delete') . '"><i class="glyphicon glyphicon-trash"></i></a>';
                                }
                            } else {
                                if($filename != 'article' && $filename != 'gallery'){
                                    echo '<a role="button" class="btn btn-success btn-sm" role="button" onclick="return confirm(\'' . $this->lang->line('delete_message') . '\')" href="' . $this->Csz_model->base_link() . '/admin/plugin/install/' . $filename . '">' . $this->lang->line('btn_install') . '</a>';
                                }
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->pagination->create_links(); ?> <b><?php echo $this->lang->line('total').' '.$total_xml.' '.$this->lang->line('records');?></b>
    </div>
</div>
<!-- /.row -->