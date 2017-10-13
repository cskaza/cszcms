<div class="container">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="h2 sub-header"><?php echo $this->Csz_model->getLabelLang('member_dashboard_text') ?></div>
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
                <div class="panel-heading"><div class="row"><div class="text-left col-xs-6"><b><i class="glyphicon glyphicon-user"></i> <b>ID:</b> <?php echo $users->user_admin_id; ?> | <?php echo $users->name ?></b></div><div class="text-right col-xs-6"><a href="<?php echo $this->csz_referrer->getIndex('member') ?>" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $this->Csz_model->getLabelLang('btn_back') ?></a></div></div></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 text-center">
                            <?php if ($users->picture) { ?>
                                <img src="<?php echo base_url() . 'photo/profile/' . $users->picture; ?>" class="img-circle" alt="Profile Photo" width="160" height="160">
                            <?php } else { ?>
                                <img src="<?php echo base_url() . 'photo/no_image.png'; ?>" class="img-circle" alt="Profile Photo" width="160" height="160">
                            <?php } ?>
                            <br><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <p><b><?php echo $this->Csz_model->getLabelLang('display_name') ?>:</b><br><?php echo ($users->name) ? $users->name : '-'; ?></p>
                            <p><b><?php echo $this->Csz_model->getLabelLang('first_name') ?> - <?php echo $this->Csz_model->getLabelLang('last_name') ?>:</b><br><?php echo ($users->first_name) ? ucfirst($users->first_name) : '-'; ?> <?php echo ($users->last_name) ? ucfirst($users->last_name) : ''; ?></p>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <p><b><?php echo $this->Csz_model->getLabelLang('gender') ?>:</b><br><?php echo ($users->gender) ? ucfirst($users->gender) : '-'; ?></p>
                            <p><b><?php echo $this->Csz_model->getLabelLang('birthday') ?>:</b><br><?php echo ($users->birthday && $users->birthday != '0000-00-00') ? date('d F Y', strtotime($users->birthday)) : '-'; ?></p>
                            <p><b><?php echo $this->Csz_model->getLabelLang('address') ?>:</b><br><?php echo($users->address) ? $users->address : '-'; ?></p>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="panel-footer"><a href="<?php echo $this->Csz_model->base_link().'/member/newpm/' . $users->user_admin_id; ?>" class="btn btn-primary" role="button"><i class="glyphicon glyphicon-envelope"></i> <?php echo $this->Csz_model->getLabelLang('pm_send_txt') ?></a></div>
            </div>
        </div>
    </div>
</div>