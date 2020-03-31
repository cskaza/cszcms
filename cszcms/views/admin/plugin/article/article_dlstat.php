<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-stats"></span></i> <?php echo $this->lang->line('linkstats_count').' ('.$this->lang->line('uploadfile_download').')'; ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('linkstats_count').' ('.$this->lang->line('uploadfile_download').')' . ' <a class="btn btn-default btn-sm" href="'.$this->csz_referrer->getIndex('article_art').'"><span class="glyphicon glyphicon-arrow-left"></span> '.$this->lang->line('btn_back').'</a>'; ?></div>
        <?php echo form_open($this->Csz_model->base_link(). '/admin/plugin/article/delDowsloadStat'); ?>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="8%" class="text-center" style="vertical-align:middle;"><label><input id="sel-chkbox-all" type="checkbox"> <?php echo  $this->lang->line('btn_delete') ?></label></th>
                        <th width="20%" class="text-center"><?php echo $this->lang->line('uploadfile_header'); ?></th>
                        <th width="40%" class="text-center"><?php echo $this->lang->line('ip_address'); ?></th>
                        <th width="15%" class="text-center"><?php echo $this->lang->line('user_email'); ?></th>
                        <th width="17%" class="text-center"><?php echo $this->lang->line('linkstats_dateime'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($stat === FALSE) { ?>
                        <tr>
                            <td colspan="5" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($stat as $u) {
                            echo '<tr>';
                            echo '<td class="text-center" style="vertical-align:middle;">
                                    <input type="checkbox" name="delR[]" id="delR" class="selall-chkbox" value="'.$u['article_db_downloadstat_id'].'">
                                </td>';
                            echo '<td style="vertical-align:middle;"><b>' . $u['file_upload'] . '</b></td>';
                            echo '<td style="vertical-align:middle;"><b>' . $u['ip_address'] . '</b><br><span style="font-style: italic; font-size:12px;">'.$u['user_agent'].'</span></td>';
                            if($u['user_admin_id']){
                                $email_echo = $this->Csz_admin_model->getUserEmail($u['user_admin_id']);
                            }else{
                                $email_echo = '-';
                            }
                            echo '<td class="text-center" style="vertical-align:middle;">' . $email_echo . '</td>';
                            echo '<td class="text-center" style="vertical-align:middle;">' . $u['timestamp_create'] . '</td>';
                            echo '</tr>';
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
        <?php echo $this->pagination->create_links(); ?> <b><?php echo $this->lang->line('total').' '.$total_row.' '.$this->lang->line('records');?></b>
        <!-- /widget-content -->
    </div>
</div>
