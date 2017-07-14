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
<div class="row">
    <div class="col-lg-12" style="word-wrap:break-word;">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i><span class="glyphicon glyphicon-link"></span></i> <?php echo $this->lang->line('widget_xml_url') ?></h3></div>
            <div class="panel-body">
                <h5><b><?php echo $this->lang->line('gallery_header') ?>:</b> <?php echo $this->Csz_model->base_link().'/plugin/gallery/getWidget' ?>/{language_iso}</h5>
                <span class="remark"><em><?php echo $this->lang->line('gallery_widget_remark') ?></em></span>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><div class="row"><div class="text-left col-xs-8"><?php echo  $this->lang->line('gallery_header') ?> <a role="button" href="<?php echo $this->Csz_model->base_link()?>/admin/plugin/gallery/add" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('gallery_new_header') ?></a></div><div class="text-right col-xs-4"><a class="btn btn-default btn-sm" href="<?php echo $this->csz_referrer->getIndex(); ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $this->lang->line('btn_back'); ?></a></div></div></div>
        <form action="<?php echo current_url(); ?>" method="get">
            <div class="control-group">
                <label class="control-label" for="search"><?php echo $this->lang->line('search'); ?>: <input type="text" name="search" id="search" class="form-control-static" value="<?php echo $this->input->get('search');?>"></label> &nbsp;&nbsp;&nbsp; 
                <label class="control-label" for="lang"><?php echo  $this->lang->line('lang_header') ?>: <select name="lang" id="lang">
                        <?php foreach ($lang as $lg) { ?>
                            <option value="<?php echo $lg->lang_iso?>"<?php echo ($this->input->get('lang') == $lg->lang_iso)?' selected="selected"':''?>><?php echo $lg->lang_name?></option>
                        <?php } ?>
                    </select></label> &nbsp;&nbsp;&nbsp; 
                <input type="submit" name="submit" id="submit" class="btn btn-default" value="<?php echo $this->lang->line('search'); ?>">
            </div>
        </form>
        <br><br>
        <?php echo form_open($this->Csz_model->base_link(). '/admin/plugin/gallery/albumIndexSave'); ?>
        <div class="box box-body table-responsive no-padding">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="2%" class="text-center" style="vertical-align:middle;"><i class="glyphicon glyphicon-sort"></i></th>
                        <th width="55%" class="text-center"><?php echo $this->lang->line('gallery_album'); ?></th>
                        <th width="8%" class="text-center"><?php echo $this->lang->line('pages_lang'); ?></th>
                        <th width="18%" class="text-center"><?php echo $this->lang->line('gallery_datetime'); ?></th>
                        <th width="17%"></th>
                    </tr>
                </thead>
                <tbody class="ui-sortable">
                    <?php if ($gallery === FALSE) { ?>
                        <tr>
                            <td colspan="5" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($gallery as $u) {
                            if(!$u['active']){
                                $inactive = ' style="vertical-align: middle;color:red;text-decoration:line-through;"';
                            }else{
                                $inactive = '';
                            }
                            echo '<tr class="ui-state-default">';
                            echo '<td class="text-center" style="vertical-align:middle;" width="2%">
                                    <i class="glyphicon glyphicon-resize-vertical"></i>
                                    <input type="hidden" name="gallery_db_id[]" value="'.$u['gallery_db_id'].'">
                                </td>';
                            echo '<td'.$inactive.' width="55%">';
                            echo '<b>'.$u['album_name'].'</b><br>';
                            echo '<span style="color:red;"><small><em>'.$u['keyword'].'</em></small></span><br>';
                            echo $u['short_desc'];
                            echo '</td>';
                            echo '<td class="text-center"'.$inactive.' style="vertical-align: middle;" width="8%"><i class="flag-icon flag-icon-'.$this->Csz_model->getCountryCode($u['lang_iso']).'"></i></td>';
                            echo '<td'.$inactive.' class="text-center" style="vertical-align: middle;" width="18%">' . $u['timestamp_update'] . '</td>';
                            echo '<td class="text-center" style="vertical-align: middle;" width="17%"><a href="'.$this->Csz_model->base_link().'/admin/plugin/gallery/edit/' . $u['gallery_db_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i> '.$this->lang->line('btn_edit').'</a> &nbsp;&nbsp; <a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.$this->Csz_model->base_link().'/admin/plugin/gallery/delete/'.$u['gallery_db_id'].'"><i class="glyphicon glyphicon-remove"></i> '.$this->lang->line('btn_delete').'</a></td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <?php
                $data = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'class' => 'btn btn-lg btn-primary',
                    'value' => $this->lang->line('btn_save'),
                    'onclick' => "return confirm('".$this->lang->line('delete_message')."');",
                );
                echo form_submit($data);
                ?>
                <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex('gallery'); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
            </div>
        </div>
        <?php echo  form_close(); ?>
        <!-- /widget-content --> 
        <br><br>
        <b><?php echo $this->lang->line('total').' '.$total_row.' '.$this->lang->line('records');?></b>
        <!-- /widget-content --> 
    </div>
</div>
<br><br>
<!-- /.row -->