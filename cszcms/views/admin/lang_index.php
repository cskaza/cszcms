<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-globe"></span></i> <?php echo  $this->lang->line('lang_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('lang_header') ?>  <a role="button" href="<?php echo BASE_URL?>/admin/lang/new" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('lang_addnew') ?></a></div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="8%" class="text-center"><?php echo $this->lang->line('id_col_table'); ?></th>
                        <th width="26%" class="text-center"><?php echo $this->lang->line('lang_name'); ?></th>
                        <th width="10%" class="text-center"><?php echo $this->lang->line('lang_iso'); ?></th>
                        <th width="26%" class="text-center"><?php echo $this->lang->line('lang_country'); ?></th>
                        <th width="10%" class="text-center"><?php echo $this->lang->line('lang_country_iso'); ?></th>
                        <th width="20%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($lang as $u) {
                        if(!$u['active']){
                            $inactive = ' style="vertical-align: middle;color:red;text-decoration:line-through;"';
                        }else{
                            $inactive = '';
                        }
                        if($u['lang_iso_id'] == 1){
                            $default_txt = ' <i class="glyphicon glyphicon-lock"></i>';
                        }else{
                            $default_txt = '';
                        }
                        echo '<tr>';
                        echo '<td'.$inactive.' class="text-center">' . $u['lang_iso_id'] . '</td>';
                        echo '<td'.$inactive.'>' . $u['lang_name'] . ''.$default_txt.'</td>';
                        echo '<td'.$inactive.' class="text-center"'.$inactive.'>' . $u['lang_iso'] . '</td>';
                        echo '<td'.$inactive.'>' . $u['country'] . '</td>';
                        echo '<td class="text-center"'.$inactive.'>' . $u['country_iso'] . '</td>';
                        echo '<td class="text-center"><a href="'.BASE_URL.'/admin/lang/edit/' . $u['lang_iso_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>  '.$this->lang->line('btn_edit').'</a> &nbsp;&nbsp;&nbsp; <a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('lang_delete_message').'\')" href="'.BASE_URL.'/admin/lang/delete/'.$u['lang_iso_id'].'"><i class="glyphicon glyphicon-remove"></i> '.$this->lang->line('btn_delete').'</a></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->pagination->create_links(); ?>
        <!-- /widget-content --> 
        <br>
        <span class="warning"><i class="glyphicon glyphicon-lock"></i> <?php echo  $this->lang->line('default_data_remark') ?></span>
    </div>
</div>
