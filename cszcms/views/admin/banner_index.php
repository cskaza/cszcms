<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-stats"></span></i> <?php echo $this->lang->line('banner_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('banner_header') ?> <a role="button" href="<?php echo $this->Csz_model->base_link()?>/admin/banner/new" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('banner_new') ?></a></div>
        <form action="<?php echo $this->Csz_model->base_link(). '/admin/banner/'; ?>" method="get">
            <div class="control-group">
                <label class="control-label" for="search"><?php echo $this->lang->line('linkstats_url'); ?>: <input type="text" name="search" id="search" class="form-control-static" value="<?php echo $this->input->get('search');?>"></label>
                <label class="control-label" for="start_date"><?php echo $this->lang->line('startdate_field'); ?>: <input type="text" name="start_date" id="start_date" class="form-control-static form-datepicker" value="<?php echo $this->input->get('start_date');?>"></label>
                <label class="control-label" for="end_date"><?php echo $this->lang->line('enddate_field'); ?>: <input type="text" name="end_date" id="end_date" class="form-control-static form-datepicker" value="<?php echo $this->input->get('end_date');?>"></label>
                <input type="submit" name="submit" id="submit" class="btn btn-default" value="<?php echo $this->lang->line('search'); ?>">
            </div>
        </form>
        <br><br>
        <?php echo  form_open($this->Csz_model->base_link(). '/admin/banner/deleteindex'); ?>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="8%" class="text-center" style="vertical-align:middle;"><label><input id="sel-chkbox-all" type="checkbox"> <?php echo  $this->lang->line('btn_delete') ?></label></th>
                        <th width="7%" class="text-center"><?php echo $this->lang->line('id_col_table'); ?></th>
                        <th width="15%" class="text-center"><?php echo $this->lang->line('banner_img'); ?></th>
                        <th width="43%" class="text-center"><?php echo $this->lang->line('banner_name'); ?></th>
                        <th width="10%" class="text-center"><?php echo $this->lang->line('banner_count'); ?></th>
                        <th width="17%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($banner === FALSE) { ?>
                        <tr>
                            <td colspan="6" class="text-center"><span class="h6 error"><?php echo $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($banner as $u) {
                            if(!$u['active']){
                                $inactive = ' style="vertical-align:middle;color:red;text-decoration:line-through;"';
                            }else{
                                $inactive = ' style="vertical-align:middle;"';
                            }
                            echo '<tr>';
                            echo '<td class="text-center" style="vertical-align:middle;">
                                    <input type="checkbox" name="delR[]" id="delR" class="selall-chkbox" value="'.$u['banner_mgt_id'].'">
                                </td>'; 
                            echo '<td class="text-center"'.$inactive.'>' . $u['banner_mgt_id'] . '</td>';
                            echo '<td class="text-center"'.$inactive.'>'; 
                            ($u['img_path'] && $u['img_path'] !== NULL) ? $img = base_url() . 'photo/banner/' . $u['img_path'] : $img = base_url() . 'photo/no_image.png';
                            echo '<img src="'.$img.'" width="100"></td>'; ?>
                            <td style="vertical-align:middle;">
                                <?php
                                if(strtotime(date('Y-m-d')) > strtotime($u['end_date'])){
                                    $expired = ' <span class="error">('.$this->lang->line('banner_expired').')</span>';
                                }else{
                                    $expired = '';
                                }
                                ?>
                                <h4><b><?php echo $u['name'].$expired; ?></b></h4>
                                <?php echo ($u['width']) ? $this->lang->line('banner_width').': <b>'.$u['width'].'</b> ' :'' ?><?php echo ($u['height']) ? $this->lang->line('banner_height').': <b>'.$u['height'].'</b>' :'' ?><br>
                                <?php echo $this->lang->line('banner_date_period') ?>: <?php echo '<b>' . $u['start_date'] . '</b> '.$this->lang->line('dashboard_toemail').' <b>' . $u['end_date'] . '</b>'; ?><br>
                                <span><?php echo $this->lang->line('banner_link') ?>: <b><?php echo $u['link']; ?></b></span><br>
                                <?php echo $this->lang->line('bf_note') ?>: <b><?php echo ($u['note'] && $u['note'] !== NULL) ? $u['note'] : '-'; ?></b>
                            </td>
                            <?php $where_arr = array('banner_mgt_id' => $u['banner_mgt_id']);
                            echo '<td class="text-center"'.$inactive.'>' . number_format($this->Csz_model->countData('banner_statistic', $where_arr)) . '</td>';
                            echo '<td class="text-center"'.$inactive.'><a href="'.$this->Csz_model->base_link().'/admin/banner/edit/' . $u['banner_mgt_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>  '.$this->lang->line('btn_edit').'</a> &nbsp;&nbsp;&nbsp; <a href="'.$this->Csz_model->base_link().'/admin/banner/view/' . $u['banner_mgt_id'] . '" class="btn btn-primary btn-sm" role="button"><i class="glyphicon glyphicon-stats"></i>  '.$this->lang->line('btn_view').'</a>';
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
        <span class="remark"><?php echo $this->lang->line('banner_indexremark'); ?></span><br><br>
        <?php echo $this->pagination->create_links(); ?> <b><?php echo $this->lang->line('total').' '.$total_row.' '.$this->lang->line('records');?></b>
        <!-- /widget-content -->
    </div>
</div>
