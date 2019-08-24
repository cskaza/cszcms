<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-stats"></span></i> <?php echo  $this->lang->line('pm_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('pm_send') ?> <a role="button" href="<?php echo $this->Csz_model->base_link()?>/admin/pm/newpm" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo $this->lang->line('pm_new_msg') ?></a></div>
        <?php echo  form_open($this->Csz_model->base_link(). '/admin/pm/indexsave'); ?>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="6%" class="text-center" style="vertical-align:middle;"><label><input id="sel-chkbox-all" type="checkbox"> <?php echo  $this->lang->line('btn_delete') ?></label></th>
                        <th width="27%" class="text-center"><?php echo $this->lang->line('pm_to'); ?></th>
                        <th width="50%" class="text-center"><?php echo $this->lang->line('pm_subject'); ?></th>
                        <th width="17%" class="text-center"><?php echo $this->lang->line('linkstats_dateime'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($msg === FALSE) { ?>
                        <tr>
                            <td colspan="4" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($msg as $u) {
                            echo '<tr>';
                            echo '<td class="text-center" style="vertical-align:middle;">
                                    <input type="checkbox" name="delR[]" id="delR" class="selall-chkbox" value="'.$u['id'].'">
                                </td>';
                            echo '<td class="text-center" style="vertical-align:middle;"><a href="'.$this->Csz_model->base_link(). '/admin/pm/viewSendMSG/'.$u['id'].'">' . $this->Csz_admin_model->getUser($u['receiver_id'])->name . '</a></td>';
                            echo '<td class="text-center" style="vertical-align:middle;"><a href="'.$this->Csz_model->base_link(). '/admin/pm/viewSendMSG/'.$u['id'].'">' . $u['title'] . '</a></td>';
                            echo '<td class="text-center" style="vertical-align:middle;"><a href="'.$this->Csz_model->base_link(). '/admin/pm/viewSendMSG/'.$u['id'].'">' . $u['date_sent'] . '</a></td>';
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
