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
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-menu-hamburger"></i> <?php echo $this->Csz_model->getLabelLang('member_menu') ?></b></div>
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation" class="text-left"><a href="<?php echo BASE_URL; ?>/member"><i class="glyphicon glyphicon-user"></i> <?php echo $this->Csz_model->getLabelLang('your_profile') ?></a></li>
                        <?php if ($this->session->userdata('admin_type') != 'member') { ?>
                            <li role="presentation" class="text-left"><a href="<?php echo BASE_URL; ?>/admin" target="_blank"><i class="glyphicon glyphicon-briefcase"></i> <?php echo $this->Csz_model->getLabelLang('backend_system') ?></a></li>
                        <?php } ?>
                        <li role="presentation" class="text-left"><a href="<?php echo BASE_URL; ?>/member/edit"><i class="glyphicon glyphicon-edit"></i> <?php echo $this->Csz_model->getLabelLang('edit_profile') ?></a></li>
                        <li role="presentation" class="text-left"><a href="<?php echo BASE_URL; ?>/member/logout"><i class="glyphicon glyphicon-log-out"></i> <?php echo $this->Csz_model->getLabelLang('log_out') ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-user"></i> <?php echo $this->Csz_model->getLabelLang('your_profile') ?></b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 text-center">
                            <?php if ($users->picture) { ?>
                                <img src="<?php echo BASE_URL . '/photo/profile/' . $users->picture; ?>" class="img-circle" alt="Profile Photo" width="160" height="160">
                            <?php } else { ?>
                                <img src="<?php echo BASE_URL . '/photo/profile/no_image.png'; ?>" class="img-circle" alt="Profile Photo" width="160" height="160">
                            <?php } ?>
                            <br><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <p><b><?php echo $this->Csz_model->getLabelLang('display_name') ?>:</b> <?php echo ($users->name) ? $users->name : '-'; ?></p>
                            <p><b><?php echo $this->Csz_model->getLabelLang('email_address') ?>:</b> <?php echo ($users->email) ? $users->email : '-'; ?></p>
                            <p><b><?php echo $this->Csz_model->getLabelLang('user_type') ?>:</b> <?php echo ucfirst($users->user_type); ?></p>
                            <p><b><?php echo $this->Csz_model->getLabelLang('first_name') ?> - <?php echo $this->Csz_model->getLabelLang('last_name') ?>:</b> <?php echo ($users->first_name) ? ucfirst($users->first_name) : '-'; ?> <?php echo ($users->last_name) ? ucfirst($users->last_name) : '-'; ?></p>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <p><b><?php echo $this->Csz_model->getLabelLang('birthday') ?>:</b> <?php echo ($users->birthday && $users->birthday != '0000-00-00') ? date('d F Y', strtotime($users->birthday)) : '-'; ?></p>
                            <p><b><?php echo $this->Csz_model->getLabelLang('gender') ?>:</b> <?php echo ($users->gender) ? ucfirst($users->gender) : '-'; ?></p>
                            <p><b><?php echo $this->Csz_model->getLabelLang('phone') ?>:</b> <?php echo ($users->phone) ? $users->phone : '-'; ?></p>
                            <p><b><?php echo $this->Csz_model->getLabelLang('address') ?>:</b> <?php echo($users->address) ? $users->address : '-'; ?></p>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>