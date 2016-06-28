<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-object-align-top"></span></i> <?php echo  $this->lang->line('navpage_new_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('navpage_new_header') ?>  <a role="button" href="<?php echo  BASE_URL ?>/admin/navigation/new" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('navpage_addnew') ?></a></div>
        <?php echo form_open(BASE_URL . '/admin/navigation/update/'.$nav->page_menu_id); ?>
        <?php if(!$nav->drop_menu){ ?>
        <div id="main_menu"<?php echo ($nav->drop_page_menu_id)?' style="display:none;"':''?>>           
            <div class="control-group">		
                <label class="control-label" for="dropdown"><?php echo $this->lang->line('navpage_dropmenu'); ?>: </label>
                <label class="form-control-static" for="dropdown">
                    <?php
                    $data = array(
                        'name' => 'dropdown',
                        'id' => 'dropdown',
                        'onclick' => "ChkHideShow('drop_menu');ChkHideShow('menu-type');",
                        'value' => '1'
                    );
                    if($nav->drop_menu) $data['checked'] = "checked";
                    echo form_checkbox($data);
                    ?> <?php echo $this->lang->line('option_yes'); ?></label>	
            </div> <!-- /control-group -->
        </div>
        <?php }else{ ?>
            <div class="control-group">		
                <label class="control-label" for="dropdown"><?php echo $this->lang->line('navpage_dropmenu'); ?>: </label>
                <input type="hidden" name="dropdown" id="dropdown" value="1"><?php echo $this->lang->line('option_yes'); ?>
            </div> <!-- /control-group -->
        <?php } ?>
        <div class="control-group">										
            <label class="control-label" for="name"><?php echo $this->lang->line('navpage_menuname'); ?>*</label>
            <?php
            $data = array(
                'name' => 'name',
                'id' => 'name',
                'required' => 'required',
                'autofocus' => 'true',
                'class' => 'form-control',
                'value' => set_value('name', $nav->menu_name, FALSE)
            );
            echo form_input($data);
            ?>			
        </div> <!-- /control-group -->
        <div class="control-group">										
            <label class="control-label" for="lang_iso"><?php echo $this->lang->line('navpage_menulang'); ?>*</label>
            <?php
                $att = 'id="lang_iso" class="form-control"';
                $data = array();
                foreach ($lang as $lg) {
                    $data[$lg->lang_iso] = $lg->lang_name;
                }
                echo form_dropdown('lang_iso', $data, $nav->lang_iso, $att);
            ?>		
        </div> <!-- /control-group -->
        <hr>
        <div class="control-group" id="menu-type"<?php echo ($nav->drop_menu)?' style="display:none;"':''?>>	
            <label class="control-label" for="menuType"><?php echo $this->lang->line('navpagesub_desc'); ?>: </label>
            <label class="form-control-static" for="menuType">
                <?php
                $data = array(
                    'name' => 'menuType',
                    'id' => 'menuType',
                    'onclick' => "ChkHideShow('sub_menu');ChkHideShow('main_menu');",
                    'value' => '1'
                );
                if($nav->drop_page_menu_id) $data['checked'] = "checked";
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('option_yes'); ?></label>	
        </div> <!-- /control-group -->
        
        <div id="drop_menu"<?php echo ($nav->drop_menu)?' style="display:none;"':''?>>
            <div class="control-group">
                <label class="control-label" for="pageUrl"><?php echo $this->lang->line('navpage_pagelink'); ?></label>
                <div class="controls">
                    <?php
                    $att = 'name="pageUrl" id="pageUrl" class="form-control"';
                    $data = array();
                    $data[''] = $this->lang->line('navpage_link');
                    foreach ($pages as $p) {
                        $data[$p['pages_id']] = $p['page_name'].' ('.$p['lang_iso'].')';
                    }
                    echo form_dropdown('pageUrl', $data, $nav->pages_id, $att);
                    ?>
                </div> <!-- /controls -->				
            </div> <!-- /control-group -->
            <br>
            <div class="control-group">										
                <label class="control-label" for="url_link"><?php echo $this->lang->line('navpage_link'); ?></label>
                <?php
                $data = array(
                    'name' => 'url_link',
                    'id' => 'url_link',
                    'class' => 'form-control',
                    'placeholder' => $this->lang->line('navpage_link'),
                    'value' => set_value('url_link', $nav->other_link, FALSE)
                );
                echo form_input($data);
                ?>			
            </div> <!-- /control-group -->
        </div>
        <div id="sub_menu"<?php echo (!$nav->drop_page_menu_id)?' style="display:none;"':''?>>
            <br>
            <div class="control-group">
                <label class="control-label" for="dropMenu"><?php echo $this->lang->line('navpage_dropmenu'); ?></label>
                <div class="controls">
                    <?php
                    $att = 'name="dropMenu" id="dropMenu" class="form-control"';
                    $data = array();
                    $data[0] = $this->lang->line('option_choose');
                    foreach ($dropmenu as $d) {
                        $data[$d['page_menu_id']] = $d['menu_name'].' ('.$d['lang_iso'].')';
                    }
                    echo form_dropdown('dropMenu', $data, $nav->drop_page_menu_id, $att);
                    ?>
                </div> <!-- /controls -->				
            </div> <!-- /control-group -->
        </div>
        <br>
        <div class="control-group">										
            <label class="form-control-static" for="active">
                <?php
                $data = array(
                    'name' => 'active',
                    'id' => 'active',
                    'value' => '1'
                );
                if($nav->active) $data['checked'] = "checked";
                echo form_checkbox($data);
                ?> <?php echo $this->lang->line('user_new_active'); ?></label>	
        </div> <!-- /control-group -->

        <br><br>
        <div class="form-actions">
            <?php
            $data = array(
                'name' => 'submit',
                'id' => 'submit',
                'class' => 'btn btn-lg btn-primary',
                'value' => $this->lang->line('btn_save'),
            );
            echo form_submit($data);
            ?> 
            <a class="btn btn-lg" href="<?php echo $this->csz_referrer->getIndex(); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
        </div> <!-- /form-actions -->
<?php echo form_close(); ?>
        <!-- /widget-content --> 
    </div>
</div>
<script>
    $("#menuType").change(function () {
        alert("Handler for .change() called.");
    });
</script>