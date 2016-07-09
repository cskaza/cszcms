<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-user"></span></i> <?php echo  $this->lang->line('nav_admin_users') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading"><div class="row"><div class="text-left col-xs-6"><b><i class="glyphicon glyphicon-user"></i> <?php echo $users->name; ?></b></div><div class="text-right col-xs-6"><a href="<?php echo $this->csz_referrer->getIndex()?>" style="color:#fff;"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $this->lang->line('btn_back') ?></a></div></div></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 text-center">
                                <?php if($users->picture){ ?>
                                <img src="<?php echo BASE_URL . '/photo/profile/' . $users->picture; ?>" class="img-circle" alt="Profile Photo" width="120" height="120">
                                <?php }else{ ?>
                                <img src="<?php echo BASE_URL . '/photo/profile/no_image.png'; ?>" class="img-circle" alt="Profile Photo" width="120" height="120">
                                <?php } ?>
                                <br><br>
                            </div>
                            <div class="col-lg-5 col-md-5">
                                <p><b><?php echo $this->lang->line('user_new_name') ?>:</b> <?php echo ($users->name) ? $users->name : '-'; ?></p>
                                <p><b><?php echo $this->lang->line('user_new_email') ?>:</b> <?php echo ($users->email) ? $users->email : '-'; ?></p>
                                <p><b><?php echo $this->lang->line('user_new_type') ?>:</b> <?php echo ucfirst($users->user_type); ?></p>
                                <p><b><?php echo $this->lang->line('user_first_name') ?> - <?php echo $this->lang->line('user_last_name') ?>:</b> <?php echo ($users->first_name) ? ucfirst($users->first_name) : '-'; ?> <?php echo ($users->last_name) ? ucfirst($users->last_name) : '-'; ?></p>
                            </div>
                            <div class="col-lg-5 col-md-5">
                                <p><b><?php echo $this->lang->line('user_birthday') ?>:</b> <?php echo ($users->birthday && $users->birthday != '0000-00-00') ? date('d F Y', strtotime($users->birthday)) : '-'; ?></p>
                                <p><b><?php echo $this->lang->line('user_gender') ?>:</b> <?php echo ($users->gender) ? ucfirst($users->gender) : '-'; ?></p>
                                <p><b><?php echo $this->lang->line('user_phone') ?>:</b> <?php echo ($users->phone) ? $users->phone : '-'; ?></p>
                                <p><b><?php echo $this->lang->line('user_address') ?>:</b> <?php echo($users->address) ? $users->address : '-'; ?></p>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
