<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-edit"></span></i> <?php echo  $this->lang->line('gallery_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><div class="row"><div class="text-left col-xs-8"><?php echo  $this->lang->line('gallery_header') ?> <a role="button" href="<?php echo BASE_URL?>/admin/plugin/gallery/add" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('gallery_new_header') ?></a></div><div class="text-right col-xs-4"><a class="btn btn-default btn-sm" href="<?php echo $this->csz_referrer->getIndex(); ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $this->lang->line('btn_back'); ?></a></div></div></div>
        <form action="<?php echo current_url(); ?>" method="get">
            <div class="control-group">
                <label class="control-label" for="search"><?php echo $this->lang->line('search'); ?>: <input type="text" name="search" id="search" class="form-control-static" value="<?php echo $this->input->get('search');?>"></label> &nbsp;&nbsp;&nbsp; 
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
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="55%" class="text-center"><?php echo $this->lang->line('gallery_album'); ?></th>
                        <th width="8%" class="text-center"><?php echo $this->lang->line('pages_lang'); ?></th>
                        <th width="20%" class="text-center"><?php echo $this->lang->line('gallery_datetime'); ?></th>
                        <th width="17%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($gallery === FALSE) { ?>
                        <tr>
                            <td colspan="4" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($gallery as $u) {
                            if(!$u['active']){
                                $inactive = ' style="vertical-align: middle;color:red;text-decoration:line-through;"';
                            }else{
                                $inactive = '';
                            }
                            echo '<tr>';
                            echo '<td'.$inactive.'>';
                            echo '<b>'.$u['album_name'].'</b><br>';
                            echo '<span style="color:red;"><small><em>'.$u['keyword'].'</em></small></span><br>';
                            echo $u['short_desc'];
                            echo '</td>';
                            echo '<td class="text-center"'.$inactive.' style="vertical-align: middle;"><i class="flag-icon flag-icon-'.$this->Csz_model->getCountryCode($u['lang_iso']).'"></i></td>';
                            echo '<td'.$inactive.' class="text-center" style="vertical-align: middle;">' . $u['timestamp_update'] . '</td>';
                            echo '<td class="text-center" style="vertical-align: middle;"><a href="'.BASE_URL.'/admin/plugin/gallery/edit/' . $u['gallery_db_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i> '.$this->lang->line('btn_edit').'</a> &nbsp;&nbsp; <a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.BASE_URL.'/admin/plugin/gallery/delete/'.$u['gallery_db_id'].'"><i class="glyphicon glyphicon-remove"></i> '.$this->lang->line('btn_delete').'</a></td>';
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
<br><br>
<!-- /.row -->