<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-globe"></span></i> <?= $this->lang->line('forms_view') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?=$form_name?>  <a role="button" href="<?=BASE_URL?>/admin/forms" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-arrow-left"></i> <?= $this->lang->line('btn_back') ?></a></div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="8%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('id_col_table'); ?></th>
                        <? $i = 3; 
                        foreach ($field_rs as $field) { 
                            if($field->field_type != 'button' && $field->field_type != 'reset' && $field->field_type != 'submit'){ ?>                            
                                <th class="text-center" style="vertical-align:middle;"><?=$field->field_label?></th>
                            <? $i++; }                    
                        } ?>
                        <th width="10%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('formpost_ipaddress'); ?></th>
                        <th width="10%" class="text-center" style="vertical-align:middle;"></th>
                    </tr>
                </thead>
                <tbody>
                    <? if ($post_rs === FALSE) { ?>
                        <tr>
                            <td colspan="<?=$i?>" class="text-center"><span class="h6 error"><?= $this->lang->line('formpost_notfound') ?></span></td>
                        </tr>                           
                    <? } else { ?>
                        <? foreach ($post_rs as $u) {
                            echo '<tr>';
                            echo '<td class="text-center" style="vertical-align:middle;">' . $u['form_'.$form_name.'_id'] . '</td>';
                            foreach ($field_rs as $field) { 
                                if($field->field_type != 'button' && $field->field_type != 'reset' && $field->field_type != 'submit'){ ?>
                                    <td class="text-center" style="vertical-align:middle;"><?=($u[$field->field_name])?$u[$field->field_name]:'-'?></td>
                                <? }
                            }
                            echo '<td class="text-center" style="vertical-align:middle;">' . $u['ip_address'] . '<br><em style="font-size:10px;">('.$u['timestamp_create'].')</em></td>';
                            echo '<td class="text-center" style="vertical-align:middle;"><a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('forms_delete_msg').'\')" href="'.BASE_URL.'/admin/forms/view/'.$this->uri->segment(4).'/delete/' . $u['form_'.$form_name.'_id'] . '"><i class="glyphicon glyphicon-remove"></i> '.$this->lang->line('btn_delete').'</a></td>';
                            echo '</tr>';
                        } ?>
                    <? } ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->pagination->create_links(); ?>
        <!-- /widget-content --> 
    </div>
</div>
