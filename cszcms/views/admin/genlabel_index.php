<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-globe"></span></i> <?php echo $this->lang->line('genlabel_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo $this->lang->line('genlabel_header') ?> <a href="<?php echo $this->Csz_model->base_link(). '/admin/genlabel/synclang'?>" class="btn btn-primary" onclick="return confirm('<?php echo $this->lang->line('delete_message');?>')"><i class="glyphicon glyphicon-refresh"></i> <?php echo $this->lang->line('btn_label_synclang')?></a></div>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="7%" class="text-center"><?php echo $this->lang->line('id_col_table'); ?></th>
                        <th width="50%" class="text-center"><?php echo $this->lang->line('genlabel_name'); ?></th>
                        <th width="33%" class="text-center"><?php echo $this->lang->line('genlabel_lang'); ?></th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($genlab === FALSE) { ?>
                        <tr>
                            <td colspan="3" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($genlab as $gl) {
                            $lang_show = '';
                            echo '<tr>';
                            echo '<td class="text-center">' . $gl['general_label_id'] . '</td>';
                            echo '<td class="text-center">' . $gl['name'] . '</td>';
                            echo '<td class="text-center">';
                            foreach ($lang as $key => $value) { 
                                if($this->db->field_exists('lang_'.$key, 'general_label')){
                                    if($gl['lang_'.$key]){
                                        $lang_show.= '<span class="success">'.$value.'</span>, ';
                                    }else{
                                        $lang_show.= '<span class="error"><b>'.$value.'</b></span>, ';
                                    }
                                }
                            }
                            echo rtrim($lang_show, ", ");
                            echo '</td>';
                            echo '<td class="text-center"><a href="'.$this->Csz_model->base_link().'/admin/genlabel/edit/' . $gl['general_label_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i>  '.$this->lang->line('btn_edit').'</a></td>';
                            echo '</tr>';
                        } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->pagination->create_links(); ?>
        <!-- /widget-content --> 
    </div>
</div>
