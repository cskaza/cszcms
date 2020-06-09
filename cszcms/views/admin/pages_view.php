<?php echo form_open($this->Csz_model->base_link() . '/admin/pages/viewPageSaved/' . $pages->pages_id); ?>
<div class="body-tinymce-inline" id="content">
    <?php echo $this->Headfoot_html->getAdminContent($pages->content); ?>
</div>
<br><br><hr>
<div class="container form-actions text-center">
    <?php
    $data = array(
        'name' => 'submit',
        'id' => 'submit',
        'class' => 'btn btn-lg btn-primary',
        'value' => $this->lang->line('btn_save'),
    );
    echo form_submit($data);
    ?> 
    <a class="btn btn-lg btn-default" href="<?php echo $this->csz_referrer->getIndex(); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
</div> <!-- /form-actions -->
<?php echo form_close();