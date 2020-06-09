<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <!-- Start Admin Menu -->
        <?php echo $this->Article_model->AdminMenu() ?>
        <!-- End Admin Menu -->
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
        <div class="h2 sub-header"><div class="row"><div class="text-left col-xs-8"><?php echo  $this->lang->line('article_header') ?> <a role="button" href="<?php echo $this->Csz_model->base_link()?>/admin/plugin/article/artadd" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('article_new_header') ?></a></div><div class="text-right col-xs-4"><a class="btn btn-default btn-sm" href="<?php echo $this->csz_referrer->getIndex('article'); ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $this->lang->line('btn_back'); ?></a></div></div></div>
        <form action="<?php echo current_url(); ?>" method="get">
            <div class="control-group">
                <label class="control-label" for="search"><?php echo $this->lang->line('search'); ?>: <input type="text" name="search" id="search" class="form-control-static" value="<?php echo $this->input->get('search');?>"></label> &nbsp;&nbsp;&nbsp; 
                <label class="control-label" for="category"><?php echo $this->lang->line('category_header'); ?>:
                    <select name="category" id="category">
                        <option value=""><?php echo $this->lang->line('option_all'); ?></option>
                        <?php
                        if(!empty($category)){
                            foreach ($category as $c) { 
                                $cat_arr[$c['article_db_id']] = $c['category_name']; ?>
                                <option value="<?php echo $c['article_db_id'] ?>"<?php echo ($this->input->get('category') == $c['article_db_id'])?' selected="selected"':''?>><?php echo $c['category_name'] ?></option>
                        <?php }
                        }
                        ?>
                    </select>	
                </label> &nbsp;&nbsp;&nbsp; 
                <label class="control-label" for="category"><?php echo  $this->lang->line('lang_header') ?>: <select name="lang" id="lang">
                        <option value=""><?php echo  $this->lang->line('option_all') ?></option>
                        <?php foreach ($lang as $lg) { ?>
                            <option value="<?php echo $lg->lang_iso?>"<?php echo ($this->input->get('lang') == $lg->lang_iso)?' selected="selected"':''?>><?php echo $lg->lang_name?></option>
                        <?php } ?>
                    </select></label> &nbsp;&nbsp;&nbsp; 
                <input type="submit" name="submit" id="submit" class="btn btn-default" value="<?php echo $this->lang->line('search'); ?>">
            </div>
        </form>
        <br><br>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="40%" class="text-center"><?php echo $this->lang->line('article_title'); ?></th>
                        <th width="10%" class="text-center"><?php echo $this->lang->line('category_header'); ?></th>
                        <th width="10%" class="text-center"><?php echo $this->lang->line('article_author'); ?></th>
                        <th width="10%" class="text-center"><?php echo $this->lang->line('pages_lang'); ?></th>
                        <th width="10%" class="text-center"><?php echo $this->lang->line('article_datetime'); ?></th>
                        <th width="20%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($article === FALSE) { ?>
                        <tr>
                            <td colspan="7" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
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
                            echo '<td'.$inactive.'>';
                            echo '<b>'.$u['title'].'</b><br>';
                            echo '<span style="color:red;"><small><em>'.$u['keyword'].'</em></small></span><br>';
                            echo $u['short_desc'];
                            echo '</td>';
                            echo '<td'.$inactive.' class="text-center" style="vertical-align: middle;">';
                            if($u['cat_id'] && $u['cat_id'] != NULL){
                                echo $cat_arr[$u['cat_id']];
                            }else{
                                echo '-';
                            }
                            echo '</td>';
                            echo '<td'.$inactive.' class="text-center" style="vertical-align: middle;">' . ucfirst($this->Csz_admin_model->getUser($u['user_admin_id'])->name) . '</td>';
                            echo '<td class="text-center"'.$inactive.' style="vertical-align: middle;"><i class="flag-icon flag-icon-'.$this->Csz_model->getCountryCode($u['lang_iso']).'"></i></td>';
                            echo '<td'.$inactive.' class="text-center" style="vertical-align: middle;">' . $u['timestamp_update'] . '</td>';
                            if($u['file_upload']){
                                $viewstat = '<a href="'.$this->Csz_model->base_link().'/admin/plugin/article/articleDownloadStat/' . $u['article_db_id'] . '" class="btn btn-default btn-sm" role="button" title="'.$this->lang->line('linkstats_count').' ('.$this->lang->line('uploadfile_download').')"><i class="glyphicon glyphicon-download-alt"></i></a> ';
                            }else{
                                $viewstat = '';
                            }
                            echo '<td class="text-center" style="vertical-align: middle;"><a href="'.$this->Csz_model->base_link().'/plugin/article/view/' . $u['article_db_id'] . '/' . $u['url_rewrite'] . '" class="btn btn-default btn-sm" role="button" title="'.$this->lang->line('btn_view').'" target="_blank"><i class="fa fa-eye"></i></a> '.$viewstat.'<br><br><a onclick="return confirm(\''.$this->lang->line('delete_message').'\')"  href="'.$this->Csz_model->base_link().'/admin/plugin/article/asCopy/' . $u['article_db_id'] . '" class="btn btn-default btn-sm" role="button" title="'.$this->lang->line('btn_ascopy').'"><i class="glyphicon glyphicon-duplicate"></i> <i class="glyphicon glyphicon-plus"></i></a> <a href="'.$this->Csz_model->base_link().'/admin/plugin/article/artedit/' . $u['article_db_id'] . '" class="btn btn-default btn-sm" role="button" title="'.$this->lang->line('btn_edit').'"><i class="glyphicon glyphicon-pencil"></i></a> <a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.$this->Csz_model->base_link().'/admin/plugin/article/artdel/'.$u['article_db_id'].'" title="'.$this->lang->line('btn_delete').'"><i class="glyphicon glyphicon-remove"></i></a></td>';
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