<style type="text/css">
.inactive-data{color:red;text-decoration:line-through}
</style>
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-object-align-top"></span></i> <?php echo  $this->lang->line('nav_nav_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('nav_nav_header') ?>  <a role="button" href="<?php echo $this->Csz_model->base_link()?>/admin/navigation/new" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('navpage_addnew') ?></a></div>       
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <form id="lang_sel">
                    <?php echo  $this->lang->line('lang_header') ?>: <select onchange="this.options[this.selectedIndex].value && (window.location = '<?php echo $this->Csz_model->base_link()?>/admin/navigation/'+this.options[this.selectedIndex].value);" onblur="this.options[this.selectedIndex].value && (window.location = '<?php echo $this->Csz_model->base_link()?>/admin/navigation/'+this.options[this.selectedIndex].value);">
                        <?php foreach ($lang as $lg) { ?>
                            <option value="<?php echo $lg->lang_iso?>"<?php echo ($this->uri->segment(3) == $lg->lang_iso)?' selected="selected"':''?>><?php echo $lg->lang_name?></option>
                        <?php } ?>
                    </select>
                </form>
                <hr>
            </div>
        </div>
        <span class="warning">** <?php echo $this->lang->line('navpage_index_remark_txt') ?></span>
        <br>
        <?php echo  form_open($this->Csz_model->base_link(). '/admin/navigation/save'); ?>
        <?php if(!empty($position)){
            foreach ($position as $key => $val) { 
                $nav = $this->Csz_admin_model->getAllMenu('', $cur_lang, $key); ?>
                <div class="row">           
                    <div class="col-md-12">
                        <div class="page-header">
                            <h3><i class="glyphicon <?php echo ($key == 1) ? 'glyphicon-object-align-bottom': 'glyphicon-object-align-top';?>"></i> <?php echo $val ?></h3>
                        </div>
                    </div>
                </div>
                <div class="row">           
                    <div class="col-lg-6 col-md-6">
                        <ol class="breadcrumb">
                            <li class="active">
                                <i><span class="glyphicon <?php echo ($key == 1) ? 'glyphicon-object-align-bottom': 'glyphicon-object-align-top';?>"></span></i> <?php echo  $this->lang->line('navpage_header') ?>
                            </li>
                        </ol>
                        <ul class="ui-sortable">
                        <?php if(!empty($nav)){
                        foreach ($nav as $n) { ?>
                            <li class="ui-state-default">
                                <div style="float: left;"<?php echo (!$n->active)?' class="inactive-data"':''?>>
                                    <i class="glyphicon glyphicon-resize-vertical"></i> <i class="flag-icon flag-icon-<?php echo $this->Csz_model->getCountryCode($n->lang_iso)?>"></i> <?php echo $n->menu_name?><?php echo ($n->drop_menu)?' <span class="caret"></span>':''?>
                                    <input type="hidden" name="menu_id[]" value="<?php echo $n->page_menu_id?>">
                                </div>
                                <div style="float: right;">
                                    <a href="<?php echo $this->Csz_model->base_link()?>/admin/navigation/edit/<?php echo $n->page_menu_id?>" style="padding-left:10px;"><i class="glyphicon glyphicon-pencil"></i></a>
                                    <a href="<?php echo $this->Csz_model->base_link()?>/admin/navigation/delete/<?php echo $n->page_menu_id?>" onclick="return confirm('<?php echo $this->lang->line('delete_message')?>')" style="padding-left:10px;"><i class="glyphicon glyphicon-remove"></i></a>
                                </div>                        
                            </li>
                        <?php } 
                        }?>   
                        </ul>
                        <br>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <ol class="breadcrumb">
                            <li class="active">
                                <i><span class="glyphicon <?php echo ($key == 1) ? 'glyphicon-object-align-bottom': 'glyphicon-object-align-top';?>"></span></i> <?php echo  $this->lang->line('navpagesub_header') ?>
                            </li>
                        </ol>
                        <?php if(!empty($nav)){
                        foreach ($nav as $n) { 
                            if($n->drop_menu){ ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading<?php echo (!$n->active)?' inactive-data':''?>"><?php echo $n->menu_name?> <span class="caret"></span></div>
                                    <div class="panel-body">
                                        <ul class="ui-sortable">
                                        <?php
                                        if(!$this->uri->segment(3)){
                                            $lang = $this->Csz_model->getDefualtLang();
                                        }else{
                                            $lang = $this->uri->segment(3);
                                        }
                                        $drop_menu = $this->Csz_admin_model->getAllMenu($n->page_menu_id,$lang);
                                        if(is_array($drop_menu)){
                                            foreach ($drop_menu as $rs1){ ?>                              
                                                    <li class="ui-state-default">
                                                        <div style="float: left;"<?php echo (!$rs1->active)?' class="inactive-data"':''?>>
                                                            <i class="glyphicon glyphicon-resize-vertical"></i> <i class="flag-icon flag-icon-<?php echo $this->Csz_model->getCountryCode($rs1->lang_iso)?>"></i> <?php echo $rs1->menu_name?>
                                                            <input type="hidden" name="menusub_id[<?php echo $n->page_menu_id?>][]" value="<?php echo $rs1->page_menu_id?>">
                                                        </div>
                                                        <div style="float: right;">
                                                            <a href="<?php echo $this->Csz_model->base_link()?>/admin/navigation/edit/<?php echo $rs1->page_menu_id?>" style="padding-left:10px;"><i class="glyphicon glyphicon-pencil"></i></a>
                                                            <a href="<?php echo $this->Csz_model->base_link()?>/admin/navigation/delete/<?php echo $rs1->page_menu_id?>" onclick="return confirm('<?php echo $this->lang->line('delete_message')?>')" style="padding-left:10px;"><i class="glyphicon glyphicon-remove"></i></a>
                                                        </div>                                                
                                                    </li>  
                                            <?php }
                                        } ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php }
                         }
                        }?>
                    </div>          
                </div>
            <?php }
        } ?>
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
    </div>
</div>