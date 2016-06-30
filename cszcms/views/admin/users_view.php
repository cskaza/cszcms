<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-stats"></span></i> <?php echo  $this->lang->line('nav_admin_users') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h4 sub-header"><?php echo $this->lang->line('nav_admin_users') ?> <a role="button" href="<?php echo $this->csz_referrer->getIndex()?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo  $this->lang->line('btn_back') ?></a></div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading"><b><i class="glyphicon glyphicon-user"></i> <?php echo $users->name; ?></b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 text-center">
                                <?php if($users->picture){ ?>
                                <img src="<?php echo BASE_URL . '/photo/profile/' . $users->picture; ?>" class="img-circle" alt="Profile Photo" width="120" height="120">
                                <?php }else{ ?>
                                <img src="http://placehold.it/120x120&text=No%20Image" class="img-circle" alt="Profile Photo" width="120" height="120">
                                <?php } ?>
                                <br><br>
                            </div>
                            <div class="col-lg-5 col-md-5">
                                <p><b><?php echo $this->lang->line('user_new_name') ?>:</b> <?php echo $users->name; ?></p>
                                <p><b><?php echo $this->lang->line('user_new_email') ?>:</b> <?php echo $users->email; ?></p>
                                <p><b><?php echo $this->lang->line('user_new_type') ?>:</b> <?php echo ucfirst($users->user_type); ?></p>
                                <p><b><?php echo $this->lang->line('user_first_name') ?> - <?php echo $this->lang->line('user_last_name') ?>:</b> <?php echo $users->first_name; ?> <?php echo $users->last_name; ?></p>
                            </div>
                            <div class="col-lg-5 col-md-5">
                                <p><b><?php echo $this->lang->line('user_birthday') ?>:</b> <?php echo date('d F Y',strtotime($users->birthday)); ?></p>
                                <p><b><?php echo $this->lang->line('user_gender') ?>:</b> <?php echo $users->gender; ?></p>
                                <p><b><?php echo $this->lang->line('user_phone') ?>:</b> <?php echo ucfirst($users->phone); ?></p>
                                <p><b><?php echo $this->lang->line('user_address') ?>:</b> <?php echo ucfirst($users->address); ?></p>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
