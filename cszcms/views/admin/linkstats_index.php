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
        <div class="h2 sub-header"><?php echo  $this->lang->line('linkstats_header') ?> <a role="button" href="<?php echo $this->Csz_model->base_link()?>/admin/linkstats/new" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('linkstats_newbtn') ?></a></div>
        <form action="<?php echo $this->Csz_model->base_link(). '/admin/linkstats/'; ?>" method="get">
            <div class="control-group">
                <label class="control-label" for="search"><?php echo $this->lang->line('linkstats_url'); ?>: <input type="text" name="search" id="search" class="form-control-static" value="<?php echo $this->input->get('search');?>"></label>
                <input type="submit" name="submit" id="submit" class="btn btn-default" value="<?php echo $this->lang->line('search'); ?>">
            </div>
        </form>
        <br><br>
        <?php echo  form_open($this->Csz_model->base_link(). '/admin/linkstats/deleteindexurl'); ?>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="8%" class="text-center" style="vertical-align:middle;"><label><input id="sel-chkbox-all" type="checkbox"> <?php echo  $this->lang->line('btn_delete') ?></label></th>
                        <th width="57%" class="text-center"><?php echo $this->lang->line('linkstats_url'); ?></th>
                        <th width="10%" class="text-center"><?php echo $this->lang->line('linkstats_count'); ?></th>
                        <th width="15%" class="text-center"><?php echo $this->lang->line('linkstats_dateime'); ?></th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($linkstats === FALSE) { ?>
                        <tr>
                            <td colspan="5" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($linkstats as $u) {
                            echo '<tr>';
                            echo '<td class="text-center" style="vertical-align:middle;">
                                    <input type="checkbox" name="delR[]" id="delR" class="selall-chkbox" value="'.$u['link_stat_mgt_id'].'">
                                </td>'; ?>
                            <td style="vertical-align:middle;">
                                <div class="form-group has-warning">
                                    <div class="input-group">
                                        <div class="input-group-addon"><b><?php echo  $this->lang->line('uploadfile_urlpath') ?></b></div>
                                        <input type="text" readonly class="form-control" id="full_url" value="<?php echo $this->Csz_model->base_link() ?>/link/<?php echo $u['link_stat_mgt_id'] ?>#<?php echo $u['url'] ?>" onfocus="this.select();" onmouseup="return false;">
                                    </div>
                                </div>
                            </td>
                            <?php $where_arr = array('link'=>$u['url']);
                            echo '<td class="text-center" style="vertical-align:middle;">' . number_format($this->Csz_model->countData('link_statistic', $where_arr)) . '</td>';
                            echo '<td class="text-center" style="vertical-align:middle;">' . $u['timestamp_create'] . '</td>';
                            echo '<td class="text-center" style="vertical-align:middle;"><a href="'.$this->Csz_model->base_link().'/admin/linkstats/view/' . $u['link_stat_mgt_id'] . '" class="btn btn-primary btn-sm" role="button"><i class="glyphicon glyphicon-eye-open"></i>  '.$this->lang->line('btn_view').'</a>';
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
