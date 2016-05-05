<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-object-align-top"></span></i> <?= $this->lang->line('nav_nav_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?= $this->lang->line('nav_nav_header') ?>  <a role="button" href="<?=BASE_URL?>/admin/navigation/new" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?= $this->lang->line('navpage_addnew') ?></a></div>       
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <form id="lang_sel">
                    <select onchange="this.options[this.selectedIndex].value && (window.location = '<?=BASE_URL?>/admin/navigation/'+this.options[this.selectedIndex].value);" onblur="this.options[this.selectedIndex].value && (window.location = '<?=BASE_URL?>/admin/navigation/'+this.options[this.selectedIndex].value);">
                        <? foreach ($lang as $lg) { ?>
                            <option value="<?=$lg->lang_iso?>"<?=($this->uri->segment(3) == $lg->lang_iso)?' selected="selected"':''?>><?=$lg->lang_name?></option>
                        <? } ?>
                    </select>
                </form>
                <hr>
            </div>
        </div>
        <?= form_open(BASE_URL . '/admin/navigation/save'); ?>
        <div class="row">           
            <div class="col-lg-6 col-md-6">
                <ol class="breadcrumb">
                    <li class="active">
                        <i><span class="glyphicon glyphicon-object-align-top"></span></i> <?= $this->lang->line('navpage_header') ?>
                    </li>
                </ol>
                <ul class="ui-sortable">
                <? if(!empty($nav)){
                foreach ($nav as $n) { ?>
                    <li class="ui-state-default">
                        <div style="float: left;"<?=(!$n->active)?' class="inactive-data"':''?>>
                            <i class="glyphicon glyphicon-resize-vertical"></i> <i class="flag-icon flag-icon-<?=$this->Csz_model->getCountryCode($n->lang_iso)?>"></i> <?=$n->menu_name?><?=($n->drop_menu)?' <span class="caret"></span>':''?>
                            <input type="hidden" name="menu_id[]" value="<?=$n->page_menu_id?>">
                        </div>
                        <div style="float: right;">
                            <a href="<?=BASE_URL?>/admin/navigation/edit/<?=$n->page_menu_id?>" style="padding-left:10px;"><i class="glyphicon glyphicon-pencil"></i></a>
                            <a href="<?=BASE_URL?>/admin/navigation/delete/<?=$n->page_menu_id?>" onclick="return confirm('<?=$this->lang->line('delete_message')?>')" style="padding-left:10px;"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>                        
                    </li>
                <? } 
                }?>   
                </ul>
                <br>
            </div>
            <div class="col-lg-6 col-md-6">
                <ol class="breadcrumb">
                    <li class="active">
                        <i><span class="glyphicon glyphicon-object-align-top"></span></i> <?= $this->lang->line('navpagesub_header') ?>
                    </li>
                </ol>
                <? if(!empty($nav)){
                foreach ($nav as $n) { 
                    if($n->drop_menu){ ?>
                        <div class="panel panel-default">
                            <div class="panel-heading<?=(!$n->active)?' inactive-data':''?>"><?=$n->menu_name?> <span class="caret"></span></div>
                            <div class="panel-body">
                                <ul class="ui-sortable">
                                <?
                                if(!$this->uri->segment(3)){
                                    $lang = $this->Csz_model->getDefualtLang();
                                }else{
                                    $lang = $this->uri->segment(3);
                                }
                                $drop_menu = $this->Csz_admin_model->getAllMenu($n->page_menu_id,$lang);
                                if(is_array($drop_menu)){
                                    foreach ($drop_menu as $rs1){ ?>                              
                                            <li class="ui-state-default">
                                                <div style="float: left;"<?=(!$rs1->active)?' class="inactive-data"':''?>>
                                                    <i class="glyphicon glyphicon-resize-vertical"></i> <i class="flag-icon flag-icon-<?=$this->Csz_model->getCountryCode($rs1->lang_iso)?>"></i> <?=$rs1->menu_name?>
                                                    <input type="hidden" name="menusub_id[<?=$n->page_menu_id?>][]" value="<?=$rs1->page_menu_id?>">
                                                </div>
                                                <div style="float: right;">
                                                    <a href="<?=BASE_URL?>/admin/navigation/edit/<?=$rs1->page_menu_id?>" style="padding-left:10px;"><i class="glyphicon glyphicon-pencil"></i></a>
                                                    <a href="<?=BASE_URL?>/admin/navigation/delete/<?=$rs1->page_menu_id?>" onclick="return confirm('<?=$this->lang->line('delete_message')?>')" style="padding-left:10px;"><i class="glyphicon glyphicon-remove"></i></a>
                                                </div>                                                
                                            </li>  
                                    <? }
                                } ?>
                                </ul>
                            </div>
                        </div>
                    <? }
                 }
                }?>
            </div>          
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <hr>
                <? $data = array(
                    'name' => 'submit',
                    'id' => 'submit',
                    'class' => 'btn btn-primary',
                    'value' => $this->lang->line('btn_save'),
                );
                echo form_submit($data);
                ?>
            </div>
        </div>
        <?=form_close();?>
        <!-- /widget-content --> 
    </div>
</div>
<script src="<?=base_url()?>assets/js/jquery.mobile-1.4.0-alpha.2.min.js"></script>