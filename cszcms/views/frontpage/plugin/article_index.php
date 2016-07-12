<div class="container">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="h2 sub-header"><?php echo $this->Csz_model->getLabelLang('article_index_header') ?></div>
            <hr>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-3">
            <?php echo $this->Article_model->categoryMenu(); ?>
        </div>
        <div class="col-md-9">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <?php
                    if ($article === FALSE) {
                        echo '<h3>' . $this->Csz_model->getLabelLang('article_not_found') . '</h3>';
                    } else {
                        foreach ($article as $a) { ?>
                            <div class="row sub-header">
                                <div class="col-lg-3 col-md-3">
                                    
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    
                                </div>
                            </div>
                  <?php }
                    } ?>
                </div>
                <div class="panel-footer">
                    <?php echo $this->pagination->create_links(); ?> <b><?php echo $this->lang->line('total') . ' ' . $total_row . ' ' . $this->lang->line('records'); ?></b>
                </div>
            </div>
        </div>
    </div>
</div>