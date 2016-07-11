<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-edit"></span></i> <?php echo  $this->lang->line('article_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><div class="row"><div class="text-left col-xs-8"><?php echo  $this->lang->line('article_category') ?> <a role="button" href="<?php echo BASE_URL?>/admin/plugin/article/add?is_category=1" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('category_new_header') ?></a></div><div class="text-right col-xs-4"><a class="btn btn-default btn-sm" href="<?php echo $this->csz_referrer->getIndex(); ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $this->lang->line('btn_back'); ?></a></div></div></div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="10%" class="text-center"><?php echo $this->lang->line('id_col_table'); ?></th>
                        <th width="10%" class="text-center"><?php echo $this->lang->line('category_main'); ?></th>
                        <th width="50%" class="text-center"><?php echo $this->lang->line('category_name'); ?></th>
                        <th width="10%" class="text-center"><?php echo $this->lang->line('article_datetime'); ?></th>
                        <th width="20%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($category === FALSE) { ?>
                        <tr>
                            <td colspan="5" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($category as $c) {
                            $cat_arr[$c['article_db_id']] = $c['category_name'];
                            if(!$c['active']){
                                $inactive = ' style="vertical-align: middle;color:red;text-decoration:line-through;"';
                            }else{
                                $inactive = '';
                            }
                            if($c['main_cat_id']){
                                $main_cat = '<b>['.$this->lang->line('id_col_table').' '.$c['main_cat_id'].']</b>';
                            }else{
                                $main_cat = '<i class="glyphicon glyphicon-ok"></i>';
                            }
                            echo '<tr>';
                            echo '<td'.$inactive.' class="text-center">' . $c['article_db_id'] . '</td>';
                            echo '<td'.$inactive.' class="text-center">' . $main_cat . '</td>';
                            echo '<td'.$inactive.' class="text-center">' . $c['category_name'] . '</td>';
                            echo '<td'.$inactive.' class="text-center">' . $c['timestamp_update'] . '</td>';
                            echo '<td class="text-center"><a href="'.BASE_URL.'/admin/plugin/article/edit' . $c['article_db_id'] . '?is_category=1" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i> '.$this->lang->line('user_edit_btn').'</a> &nbsp;&nbsp; <a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('user_delete_message').'\')" href="'.BASE_URL.'/admin/plugin/article/delete/'.$c['article_db_id'].'"><i class="glyphicon glyphicon-remove"></i> '.$this->lang->line('user_delete_btn').'</a></td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('article_header') ?> <a role="button" href="<?php echo BASE_URL?>/admin/plugin/article/add" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('article_new_header') ?></a></div>
        <form action="<?php echo current_url(); ?>" method="get">
            <div class="control-group">
                <label class="control-label" for="search"><?php echo $this->lang->line('search'); ?>: <input type="text" name="search" id="search" class="form-control-static" value="<?php echo $this->input->get('search');?>"></label> &nbsp;&nbsp;&nbsp; 
                <label class="control-label" for="category"><?php echo $this->lang->line('category_header'); ?>:
                    <select name="category" id="category">
                        <option value=""><?php echo $this->lang->line('option_all'); ?></option>
                        <?php
                        if(isset($cat_arr)){
                            foreach ($cat_arr as $key => $value) { ?>
                                <option value="<?php echo $key ?>"<?php echo ($this->input->get('category') == $key)?' selected="selected"':''?>><?php echo $value ?></option>
                        <?php }
                        }
                        ?>
                    </select>	
                </label> &nbsp;&nbsp;&nbsp; 
                <input type="submit" name="submit" id="submit" class="btn btn-default" value="<?php echo $this->lang->line('search'); ?>">
            </div>
        </form>
        <br><br>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="13%" class="text-center"><?php echo $this->lang->line('article_mainpic'); ?></th>
                        <th width="30%" class="text-center"><?php echo $this->lang->line('article_title'); ?></th>
                        <th width="15%" class="text-center"><?php echo $this->lang->line('article_category'); ?></th>
                        <th width="15%" class="text-center"><?php echo $this->lang->line('article_author'); ?></th>
                        <th width="15%" class="text-center"><?php echo $this->lang->line('article_datetime'); ?></th>
                        <th width="12%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($article === FALSE) { ?>
                        <tr>
                            <td colspan="6" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($article as $u) {
                            if(!$u['active']){
                                $inactive = ' style="vertical-align: middle;color:red;text-decoration:line-through;"';
                            }else{
                                $inactive = '';
                            }
                            echo '<tr>';
                            echo '<td'.$inactive.' class="text-center">';
                            if($u["main_picture"]){
                                echo '<img src="'.BASE_URL.'/photo/plugin/article/'.$u["main_picture"].'" width="85">';
                            }else{
                                echo '<img src="'.BASE_URL.'/photo/no_image.png" width="85">';
                            }
                            echo '</td>';
                            echo '<td'.$inactive.'>';
                            echo '<b>'.$u['title'].'</b><br>';
                            echo '<small>'.$u['keyword'].'</small><br>';
                            echo '<em>'.$u['short_desc'].'</em><br>';
                            echo '</td>';
                            echo '<td'.$inactive.' class="text-center">' . $cat_arr[$u['cat_id']] . '</td>';
                            echo '<td'.$inactive.' class="text-center">' . ucfirst($this->Csz_admin_model->getUser($u['user_admin_id'])->name) . '</td>';
                            echo '<td'.$inactive.' class="text-center">' . $u['timestamp_update'] . '</td>';
                            echo '<td class="text-center"><a href="'.BASE_URL.'/admin/plugin/article/edit' . $u['content_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i> '.$this->lang->line('user_edit_btn').'</a> &nbsp;&nbsp; <a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('user_delete_message').'\')" href="'.BASE_URL.'/admin/plugin/article/delete/'.$u['content_id'].'"><i class="glyphicon glyphicon-remove"></i> '.$this->lang->line('user_delete_btn').'</a></td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->pagination->create_links(); ?> <b><?php echo $this->lang->line('total').' '.$total_row.' '.$this->lang->line('records');?></b>
        <!-- /widget-content --> 
    </div>
</div>
