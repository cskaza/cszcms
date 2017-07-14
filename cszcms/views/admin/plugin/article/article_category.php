<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <!-- Start Admin Menu -->
        <?php echo $this->Article_model->AdminMenu() ?>
        <!-- End Admin Menu -->
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-edit"></span></i> <?php echo  $this->lang->line('category_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><div class="row"><div class="text-left col-xs-8"><?php echo  $this->lang->line('category_header') ?> <a role="button" href="<?php echo $this->Csz_model->base_link()?>/admin/plugin/article/catadd" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('category_new_header') ?></a></div><div class="text-right col-xs-4"><a class="btn btn-default btn-sm" href="<?php echo $this->csz_referrer->getIndex('article'); ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $this->lang->line('btn_back'); ?></a></div></div></div>
        <form action="<?php echo current_url(); ?>" method="get">
            <div class="control-group">
                <label class="control-label" for="search"><?php echo $this->lang->line('search'); ?>: <input type="text" name="search" id="search" class="form-control-static" value="<?php echo $this->input->get('search');?>"></label> &nbsp;&nbsp;&nbsp; 
                <label class="control-label" for="main_cat_id"><?php echo $this->lang->line('category_main'); ?>:
                    <select name="main_cat_id" id="main_cat_id">
                        <option value=""><?php echo $this->lang->line('option_all'); ?></option>
                        <?php
                        if(!empty($main_category)){
                            foreach ($main_category as $mc) { 
                                $cat_arr[$mc['article_db_id']] = $mc['category_name']; ?>
                                <option value="<?php echo $mc['article_db_id'] ?>"<?php echo ($this->input->get('main_cat_id') == $mc['article_db_id'])?' selected="selected"':''?>><?php echo $mc['category_name'] ?></option>
                        <?php }
                        }
                        ?>
                    </select>	
                </label> &nbsp;&nbsp;&nbsp; 
                <label class="control-label" for="lang"><?php echo  $this->lang->line('lang_header') ?>: <select name="lang" id="lang">
                        <option value=""><?php echo  $this->lang->line('option_all') ?></option>
                        <?php foreach ($lang as $lg) { ?>
                            <option value="<?php echo $lg->lang_iso?>"<?php echo ($this->input->get('lang') == $lg->lang_iso)?' selected="selected"':''?>><?php echo $lg->lang_name?></option>
                        <?php } ?>
                    </select></label> &nbsp;&nbsp;&nbsp; 
                <input type="submit" name="submit" id="submit" class="btn btn-default" value="<?php echo $this->lang->line('search'); ?>">
            </div>
        </form>
        <br><br>
        <?php echo  form_open($this->Csz_model->base_link(). '/admin/plugin/article/catIndexSave'); ?>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="2%" class="text-center" style="vertical-align:middle;"><i class="glyphicon glyphicon-sort"></i></th>
                        <th width="8%" class="text-center"><?php echo $this->lang->line('id_col_table'); ?></th>
                        <th width="15%" class="text-center"><?php echo $this->lang->line('category_main'); ?></th>
                        <th width="37%" class="text-center"><?php echo $this->lang->line('category_name'); ?></th>
                        <th width="8%" class="text-center"><?php echo $this->lang->line('pages_lang'); ?></th>
                        <th width="10%" class="text-center"><?php echo $this->lang->line('article_datetime'); ?></th>
                        <th width="20%"></th>
                    </tr>
                </thead>
                <tbody class="ui-sortable">
                    <?php if ($category === FALSE) { ?>
                        <tr>
                            <td colspan="7" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($category as $c) {
                            if(!$c['active']){
                                $inactive = ' style="vertical-align: middle;color:red;text-decoration:line-through;"';
                            }else{
                                $inactive = '';
                            }
                            if($c['main_cat_id']){
                                $main_cat = '<b>'.$this->Article_model->getCatNameFromID($c['main_cat_id']).'</b>';
                            }else{
                                $main_cat = '<i class="glyphicon glyphicon-ok"></i>';
                            }
                            echo '<tr class="ui-state-default">';
                            echo '<td class="text-center" style="vertical-align:middle;">
                                    <i class="glyphicon glyphicon-resize-vertical"></i>
                                    <input type="hidden" name="article_db_id[]" value="'.$c['article_db_id'].'">
                                </td>';
                            echo '<td'.$inactive.' class="text-center" style="vertical-align: middle;">' . $c['article_db_id'] . '</td>';
                            echo '<td'.$inactive.' class="text-center" style="vertical-align: middle;">' . $main_cat . '</td>';
                            echo '<td'.$inactive.' class="text-center" style="vertical-align: middle;">' . $c['category_name'] . '</td>';
                            echo '<td class="text-center"'.$inactive.' style="vertical-align: middle;"><i class="flag-icon flag-icon-'.$this->Csz_model->getCountryCode($c['lang_iso']).'"></i></td>';
                            echo '<td'.$inactive.' class="text-center" style="vertical-align: middle;">' . $c['timestamp_update'] . '</td>';
                            echo '<td class="text-center" style="vertical-align: middle;" width="20%"><a href="'.$this->Csz_model->base_link().'/admin/plugin/article/catedit/' . $c['article_db_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i> '.$this->lang->line('btn_edit').'</a> &nbsp;&nbsp; <a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.$this->Csz_model->base_link().'/admin/plugin/article/catdel/'.$c['article_db_id'].'"><i class="glyphicon glyphicon-remove"></i> '.$this->lang->line('btn_delete').'</a></td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <hr>
                <?php $data = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'class' => 'btn btn-primary',
                    'value' => $this->lang->line('btn_save'),
                );
                echo form_submit($data);
                ?>
            </div>
        </div>
        <?php echo form_close();?>
        <!-- /widget-content -->
        <b><?php echo $this->lang->line('total').' '.$total_row.' '.$this->lang->line('records');?></b>
        <!-- /widget-content --> 
    </div>
</div>