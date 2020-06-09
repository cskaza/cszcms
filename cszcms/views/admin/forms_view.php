<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-globe"></span></i> <?php echo  $this->lang->line('forms_view') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $form_name?>  <a role="button" href="<?php echo $this->Csz_model->base_link().'/admin/forms/dataAdd/'.$this->uri->segment(4) ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo $this->lang->line('btn_add');?></a> <a role="button" href="<?php echo $this->Csz_model->base_link()?>/admin/forms/dataSaveExcel/<?php echo $this->uri->segment(4) ?>?search=<?php echo $this->input->get('search') ?>&field=<?php echo $this->input->get('field') ?>" class="btn btn-success btn-sm" target="_blank"><span class="fa fa-table"></span> <?php echo $this->lang->line('btn_save') ?></a> <a role="button" href="<?php echo $this->csz_referrer->getIndex()?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $this->lang->line('btn_back') ?></a></div>
        <form action="<?php echo current_url(); ?>" method="get">
            <div class="control-group">
                <label class="control-label" for="search"><?php echo $this->lang->line('search'); ?>: <input type="text" name="search" id="search" class="form-control-static" value="<?php echo $this->input->get('search');?>"></label> &nbsp; 
                <label class="control-label" for="field"><?php echo $this->lang->line('dashboard_fromemail'); ?>: 
                    <?php
                        $att = 'id="field" class="form-control-static"';
                        $data = array();
                        $data['form_'.$form_name.'_id'] = 'ID#';
                        if (!empty($field_rs)) {
                            foreach ($field_rs as $valf) {
                                if($valf['field_type'] == 'text' || $valf['field_type'] == 'email' || $valf['field_type'] == 'number' || $valf['field_type'] == 'textarea' || $valf['field_type'] == 'selectbox') $data[$valf['field_name']] = $valf['field_label'];
                            }
                        }
                        echo form_dropdown('field', $data, $this->input->get('field'), $att);
                    ?>
                </label> &nbsp; 
                <input type="submit" name="submit" id="submit" class="btn btn-primary" value="<?php echo $this->lang->line('search'); ?>"> &nbsp; 
                <a role="button" href="<?php echo $this->Csz_model->base_link()?>/admin/forms/view/<?php echo $this->uri->segment(4) ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-refresh" aria-hidden="true"></i></a>
            </div>
        </form>
        <br><br>
        <?php echo  form_open($this->Csz_model->base_link().'/admin/forms/view/'.$this->uri->segment(4).'/delete'); ?>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="8%" class="text-center" style="vertical-align:middle;"><label><input id="sel-chkbox-all" type="checkbox"> <?php echo  $this->lang->line('btn_delete') ?></label></th>
                        <?php $i = 4;
                        if(!empty($field_rs)){
                            foreach ($field_rs as $field) { 
                                if($field['field_type'] != 'button' && $field['field_type'] != 'reset' && $field['field_type'] != 'submit' && $field['field_type'] != 'label'){ ?>                            
                                    <th class="text-center" style="vertical-align:middle;"><?php echo $field['field_label']?></th>
                                <?php $i++; }                    
                            } 
                        }?>
                        <th width="10%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('formpost_ipaddress'); ?></th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($post_rs === FALSE) { ?>
                        <tr>
                            <td colspan="<?php echo $i?>" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('formpost_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php foreach ($post_rs as $u) {
                            echo '<tr>';
                            echo '<td class="text-center" style="vertical-align:middle;">
                                    <input type="checkbox" name="delR[]" id="delR" class="selall-chkbox" value="'.$u['form_'.$form_name.'_id'].'">
                                </td>';
                            if(!empty($field_rs)){
                                foreach ($field_rs as $field) { 
                                    if($field['field_type'] != 'button' && $field['field_type'] != 'reset' && $field['field_type'] != 'submit' && $field['field_type'] != 'label' && $field['field_type'] != 'file'){ ?>
                                        <td class="text-center" style="vertical-align:middle;"><?php echo ($u[$field['field_name']])?$u[$field['field_name']]:'-'?></td>
                                    <?php }else if($field['field_type'] == 'file'){ 
                                        if($u[$field['field_name']]){
                                            $linkhtml = '<a href="' . base_url() . "photo/forms/" . $this->Csz_model->cleanEmailFormat($form_name) . '/' . $this->Csz_model->cleanEmailFormat($field['field_name']) . '/' . $u[$field['field_name']] . '" target="_blank">' . $u[$field['field_name']] . '</a>';
                                        }else{
                                            $linkhtml = '-';
                                        } ?>
                                        <td class="text-center" width="10%" style="vertical-align:middle;word-wrap:break-word;"><?php echo $linkhtml; ?></td>
                                    <?php }
                                }
                            }
                            echo '<td class="text-center" style="vertical-align:middle;">' . $u['ip_address'] . '<br><em style="font-size:10px;">('.$u['timestamp_create'].')</em></td>';                            
                            echo '<td class="text-center" style="vertical-align:middle;"><a href="'.$this->Csz_model->base_link().'/admin/forms/dataEdit/'.$this->uri->segment(4).'/' . $u['form_'.$form_name.'_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i></a></td>';
                            echo '</tr>';
                        } ?>
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
        <?php echo form_close(); ?><br>
        <?php echo $this->pagination->create_links(); ?> <b><?php echo $this->lang->line('total').' '.$total_row.' '.$this->lang->line('records');?></b>
        <!-- /widget-content -->
    </div>
</div>
