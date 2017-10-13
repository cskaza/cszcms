<div class="container">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="h2 sub-header"><?php echo $this->Csz_model->getLabelLang('pm_txt') ?></div>
            <hr>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-3">
            <?php echo $this->Headfoot_html->memberleftMenu(); ?>
        </div>
        <div class="col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading"><div class="row"><div class="text-left col-xs-6"><b><i class="glyphicon glyphicon-envelope"></i> <?php echo $this->Csz_model->getLabelLang('pm_from_txt') ?>: <?php echo $this->Csz_admin_model->getUser($pm->sender_id)->name; ?> | <?php echo $this->Csz_model->getLabelLang('pm_to_txt') ?>: <?php echo $this->Csz_admin_model->getUser($pm->receiver_id)->name; ?></b></div><div class="text-right col-xs-6"><a href="<?php echo $this->csz_referrer->getIndex('member') ?>" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $this->Csz_model->getLabelLang('btn_back') ?></a></div></div></div>
                <div class="panel-body">
                    <span class="badge"><?php echo $pm->date_sent ?></span>
                    <h3><?php echo $pm->title; ?></h3>
                    <br>
                    <p><?php echo $pm->message; ?></p>
                    <br><br>
                </div>
                <div class="panel-footer"><a href="<?php echo $this->Csz_model->base_link(). '/member/deletepm/' . $pm->id; ?>" class="btn btn-danger" role="button" onclick="return confirm('<?php echo $this->Csz_model->getLabelLang('shop_delete_alert'); ?>')"><?php echo $this->Csz_model->getLabelLang('pm_delete_txt') ?></a></div>
            </div>
        </div>
    </div>
</div>