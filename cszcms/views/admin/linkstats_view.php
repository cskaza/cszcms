<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-stats"></span></i> <?php echo  $this->lang->line('linkstats_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h4 sub-header"><b><?php echo  $this->lang->line('btn_view') ?>:</b> <?php echo $url_link; ?>  <a role="button" href="<?php echo $this->csz_referrer->getIndex()?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo  $this->lang->line('btn_back') ?></a></div>
        <form action="<?php echo BASE_URL . '/admin/linkstats/view/'.$this->uri->segment(4).'/'; ?>" method="get">
            <div class="control-group">
                <label class="control-label" for="search"><?php echo $this->lang->line('ip_address'); ?>: <input type="text" name="search" id="search" class="form-control-static" value="<?php echo $this->input->get('search');?>"></label>
                <label class="control-label" for="start_date"><?php echo $this->lang->line('startdate_field'); ?>: <input type="text" name="start_date" id="start_date" class="form-control-static form-datepicker" value="<?php echo $this->input->get('start_date');?>"></label>
                <label class="control-label" for="end_date"><?php echo $this->lang->line('enddate_field'); ?>: <input type="text" name="end_date" id="end_date" class="form-control-static form-datepicker" value="<?php echo $this->input->get('end_date');?>"></label>
                <input type="submit" name="submit" id="submit" class="btn btn-default" value="<?php echo $this->lang->line('search'); ?>">
            </div>
        </form>
        <br><br>
        <?php echo  form_open(BASE_URL . '/admin/linkstats/deleteviewid'); ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="8%" class="text-center" style="vertical-align:middle;"><label><input id="sel-chkbox-all" type="checkbox"> <?php echo  $this->lang->line('btn_delete') ?></label></th>
                        <th width="37%" class="text-center"><?php echo $this->lang->line('ip_address'); ?></th>
                        <th width="45%" class="text-center"><?php echo $this->lang->line('linkstats_dateime'); ?></th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($linkstats === FALSE) { ?>
                        <tr>
                            <td colspan="4" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($linkstats as $u) {
                            echo '<tr>';
                            echo '<td class="text-center" style="vertical-align:middle;">
                                    <input type="checkbox" name="delR[]" id="delR" class="selall-chkbox" value="'.$u['link_statistic_id'].'">
                                </td>';
                            echo '<td class="text-center">' . $u['ip_address'] . '</td>';
                            echo '<td class="text-center">' . $u['timestamp_create'] . '</td>';
                            echo '<td class="text-center">';
                            if($this->session->userdata('admin_type') == 'admin'){
                                echo '<a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.BASE_URL.'/admin/linkstats/deleteid/'.$u['link_statistic_id'].'"><i class="glyphicon glyphicon-remove"></i> '.$this->lang->line('btn_delete').'</a>';
                            }else{
                                echo '&nbsp;-&nbsp;';
                            }
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
        <?php echo $this->pagination->create_links(); ?> <b><?php echo $this->lang->line('total').' '.$total_row.' '.$this->lang->line('records');?></b>
        <!-- /widget-content -->
    </div>
</div>
