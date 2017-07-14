<div class="container">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="h2 sub-header"><?php echo $this->Csz_model->getLabelLang('pm_txt') ?></div>
            <hr>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-3">
            <?php echo $this->Headfoot_html->memberleftMenu(); ?>
        </div>
        <div class="col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-envelope"></i> <?php echo $this->Csz_model->getLabelLang('pm_inbox_txt') ?></b></div>
                <div class="panel-body">
                    <a role="button" href="<?php echo $this->Csz_model->base_link()?>/member/newpm" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo $this->Csz_model->getLabelLang('pm_newmsg_txt') ?></a>
                    <br><br>
                    <?php echo  form_open($this->Csz_model->base_link(). '/member/indexpmsave'); ?>
                    <div class="box box-body table-responsive no-padding">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th width="6%" class="text-center" style="vertical-align:middle;"><label><input id="sel-chkbox-all" type="checkbox"> <?php echo $this->Csz_model->getLabelLang('pm_delete_txt') ?></label></th>
                                    <th width="7%" class="text-center" style="vertical-align:middle;"></th>
                                    <th width="20%" class="text-center"><?php echo $this->Csz_model->getLabelLang('pm_from_txt'); ?></th>
                                    <th width="50%" class="text-center"><?php echo $this->Csz_model->getLabelLang('pm_subject_txt'); ?></th>
                                    <th width="17%" class="text-center"><?php echo $this->Csz_model->getLabelLang('pm_datetime_txt'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($msg === FALSE) { ?>
                                    <tr>
                                        <td colspan="5" class="text-center"><span class="h6 error"><?php echo $this->Csz_model->getLabelLang('error_txt') ?></span></td>
                                    </tr>                           
                                <?php } else { ?>
                                    <?php
                                    foreach ($msg as $u) {
                                        echo '<tr>';
                                        echo '<td class="text-center" style="vertical-align:middle;">
                                                <input type="checkbox" name="delR[]" id="delR" class="selall-chkbox" value="'.$u['id'].'">
                                            </td>';
                                        echo '<td class="text-center h3" style="vertical-align:middle;">';
                                        if($u['date_read'] == NULL){
                                            echo '<a href="'.$this->Csz_model->base_link(). '/member/setread/'.$u['id'].'"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
                                            $b_start = '<b>';
                                            $b_end = '</b>';
                                        }else{
                                            echo '<a href="'.$this->Csz_model->base_link(). '/member/setunread/'.$u['id'].'"><i class="fa fa-envelope-open-o" aria-hidden="true"></i></a>';
                                            $b_start = '';
                                            $b_end = '';
                                        }
                                        echo '</td>';
                                        echo '<td class="text-center" style="vertical-align:middle;"><a href="'.$this->Csz_model->base_link(). '/member/viewpm/'.$u['id'].'">' . $b_start . $this->Csz_admin_model->getUser($u['sender_id'])->name . $b_end . '</a></td>';
                                        echo '<td class="text-center" style="vertical-align:middle;"><a href="'.$this->Csz_model->base_link(). '/member/viewpm/'.$u['id'].'">' . $b_start . $u['title'] . $b_end . '</a></td>';
                                        echo '<td class="text-center" style="vertical-align:middle;"><a href="'.$this->Csz_model->base_link(). '/member/viewpm/'.$u['id'].'">' . $b_start . $u['date_sent'] . $b_end . '</a></td>';
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
                                'onclick' => "return confirm('".$this->Csz_model->getLabelLang('shop_delete_alert')."');",
                            );
                            echo form_submit($data);
                            ?>
                        </div>
                    </div>
                    <?php echo form_close(); ?><br>
                    <?php echo $this->pagination->create_links(); ?> <b><?php echo $this->Csz_model->getLabelLang('total_txt') . ' ' . $total_row . ' ' . $this->Csz_model->getLabelLang('records_txt'); ?></b>
                    <!-- /widget-content -->
                </div>
            </div>
        </div>
    </div>
</div>