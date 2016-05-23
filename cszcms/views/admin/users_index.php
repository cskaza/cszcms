<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-user"></span></i> <?= $this->lang->line('nav_admin_users') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?= $this->lang->line('user_header') ?><? if($this->session->userdata('admin_type') == 'admin'){ ?> <a role="button" href="<?=BASE_URL?>/admin/users/new" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?= $this->lang->line('user_addnew') ?></a><? } ?></div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="10%" class="text-center"><?php echo $this->lang->line('user_status'); ?></th>
                        <th width="8%" class="text-center"><?php echo $this->lang->line('id_col_table'); ?></th>
                        <th width="20%"><?php echo $this->lang->line('user_name'); ?></th>
                        <th width="30%"><?php echo $this->lang->line('user_email'); ?></th>
                        <th width="12%" class="text-center"><?php echo $this->lang->line('user_new_type'); ?></th>
                        <? if($this->session->userdata('admin_type') == 'admin'){ ?>
                        <th width="20%"></th>
                        <? } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $u) {
                        if(!$u['active']){
                            $inactive = ' style="vertical-align: middle;color:red;text-decoration:line-through;"';
                            $status = '<span style="color:red;">Deactivated</span>';
                        }else{
                            $inactive = '';
                            $status = '<span style="color:green;">Activated</span>';
                        }
                        if($u['user_admin_id'] == 1){
                            $default_txt = ' <i class="glyphicon glyphicon-lock"></i>';
                        }else{
                            $default_txt = '';
                        }
                        echo '<tr>';
                        echo '<td'.$inactive.' class="text-center">' . $status . '</td>';
                        echo '<td'.$inactive.' class="text-center">' . $u['user_admin_id'] . '</td>';
                        echo '<td'.$inactive.'>' . $u['name'] . ''.$default_txt.'</td>';
                        echo '<td'.$inactive.'>' . $u['email'] . '</td>';
                        echo '<td'.$inactive.' class="text-center">' . ucfirst($u['user_type']) . '</td>';
                        if($this->session->userdata('admin_type') == 'admin'){
                            echo '<td class="text-center"><a href="'.BASE_URL.'/admin/users/edit/' . $u['user_admin_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>  '.$this->lang->line('user_edit_btn').'</a> &nbsp;&nbsp;&nbsp; <a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('user_delete_message').'\')" href="'.BASE_URL.'/admin/users/delete/'.$u['user_admin_id'].'"><i class="glyphicon glyphicon-remove"></i> '.$this->lang->line('user_delete_btn').'</a></td>';
                        }
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->pagination->create_links(); ?>
        <!-- /widget-content --> 
        <br>
        <span class="warning"><i class="glyphicon glyphicon-lock"></i> <?= $this->lang->line('default_data_remark') ?></span>
    </div>
</div>
