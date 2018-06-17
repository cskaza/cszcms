<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-globe"></span></i> <?php echo  $this->lang->line('forms_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('forms_header') ?>  <a role="button" href="<?php echo $this->Csz_model->base_link()?>/admin/forms/new" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('forms_addnew') ?></a></div>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="18%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('forms_name'); ?></th>
                        <th width="10%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('forms_enctype'); ?></th>
                        <th width="10%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('forms_method'); ?></th>
                        <th width="10%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('forms_save_to_db'); ?></th>
                        <th width="10%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('forms_sendmail'); ?></th>
                        <th width="10%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('forms_send_to_visitor'); ?></th> 
                        <th width="10%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('forms_captcha'); ?></th>
                        <th width="22%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($forms === FALSE) { ?>
                        <tr>
                            <td colspan="7" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('forms_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php foreach ($forms as $u) {
                            if(!$u['active']){
                                $inactive = ' style="vertical-align: middle;color:red;text-decoration:line-through;"';
                            }else{
                                $inactive = '';
                            }
                            if($u['sendmail']){
                                $sendmail = '<i class="success glyphicon glyphicon-ok"></i>';
                            }else{
                                $sendmail = '<i class="error glyphicon glyphicon-remove"></i>';
                            }
                            if($u['send_to_visitor']){
                                $send_to_visitor = '<i class="success glyphicon glyphicon-ok"></i>';
                            }else{
                                $send_to_visitor = '<i class="error glyphicon glyphicon-remove"></i>';
                            }
                            if($u['captcha']){
                                $captcha = '<i class="success glyphicon glyphicon-ok"></i>';
                            }else{
                                $captcha = '<i class="error glyphicon glyphicon-remove"></i>';
                            }
                            if($u['save_to_db']){
                                $save_to_db = '<i class="success glyphicon glyphicon-ok"></i>';
                            }else{
                                $save_to_db = '<i class="error glyphicon glyphicon-remove"></i>';
                            }
                            echo '<tr>';
                            echo '<td class="text-center"'.$inactive.' style="vertical-align:middle;">' . $u['form_name'] . '</td>'; ?>
                            <td class="text-center"<?php echo $inactive?> style="vertical-align:middle;"><?php echo ($u['form_enctype'])?$u['form_enctype']:'-'?></td>
                            <?php echo '<td class="text-center"'.$inactive.' style="vertical-align:middle;">' . $u['form_method'] . '</td>';
                            echo '<td class="text-center"'.$inactive.' style="vertical-align:middle;">' . $save_to_db . '</td>';
                            echo '<td class="text-center"'.$inactive.' style="vertical-align:middle;">' . $sendmail . '</td>';
                            echo '<td class="text-center"'.$inactive.' style="vertical-align:middle;">' . $send_to_visitor . '</td>';
                            echo '<td class="text-center"'.$inactive.' style="vertical-align:middle;">' . $captcha . '</td>';
                            echo '<td class="text-center" style="vertical-align:middle;"><a href="'.$this->Csz_model->base_link().'/admin/forms/view/' . $u['form_main_id'] . '" class="btn btn-primary btn-sm" role="button"><i class="glyphicon glyphicon-eye-open"></i></a> &nbsp;&nbsp;&nbsp; <a href="'.$this->Csz_model->base_link().'/admin/forms/edit/' . $u['form_main_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>  '.$this->lang->line('btn_edit').'</a> &nbsp;&nbsp;&nbsp; <a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('forms_delete_msg').'\')" href="'.$this->Csz_model->base_link().'/admin/forms/delete/'.$u['form_main_id'].'"><i class="glyphicon glyphicon-remove"></i> '.$this->lang->line('btn_delete').'</a></td>';
                            echo '</tr>';
                        } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <span class="remark"><?php echo $this->lang->line('forms_indexremark'); ?></span>
        <?php echo $this->pagination->create_links(); ?>
        <!-- /widget-content --> 
    </div>
</div>
