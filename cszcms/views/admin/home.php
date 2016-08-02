<?php $config = $this->Csz_admin_model->load_config(); ?>
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('dash_welcome') ?></div>
        <p><?php echo  $this->lang->line('dash_message') ?></p>
        <p><b><a href="http://www.cszcms.com" target="_blank">The official of CSZ-CMS website</a></b></p>
        <br><br>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-dashboard"></span></i> <?php echo $this->lang->line('nav_dash') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-4 col-md-4">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <h1><i><span class="glyphicon glyphicon-list-alt"></span></i></h1>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $total_member ?></div>
                        <div><?php echo $this->lang->line('dashboard_totalmember') ?>!</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo BASE_URL.'/admin/users' ?>">
                <div class="panel-footer">
                    <span class="pull-left"><?php echo $this->lang->line('dashboard_viewdetail') ?></span>
                    <span class="pull-right"><i><span class="glyphicon glyphicon-expand"></span></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <h1><i><span class="glyphicon glyphicon-list-alt"></span></i></h1>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php if($config->link_statistic_active){ echo $total_linkstats; }else{ echo '-'; } ?></div>
                        <div><?php echo $this->lang->line('dashboard_totallink') ?>!</div>
                    </div>
                </div>
            </div>
            <a href="<?php if($config->link_statistic_active){ echo BASE_URL.'/admin/linkstats'; }else{ echo '#'; } ?>">
                <div class="panel-footer">
                    <span class="pull-left"><?php if($config->link_statistic_active){ echo $this->lang->line('dashboard_viewdetail'); }else{ echo '<span class="error"><b>'.$this->lang->line('pluginmgr_disable').'!</b></span>'; } ?></span>
                    <span class="pull-right"><i><span class="glyphicon glyphicon-expand"></span></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <h1><i><span class="glyphicon glyphicon-envelope"></span></i></h1>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $total_emaillogs ?></div>
                        <div><?php echo $this->lang->line('dashboard_totalemail') ?>!</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo BASE_URL.'/admin/forms' ?>">
                <div class="panel-footer">
                    <span class="pull-left"><?php echo $this->lang->line('dashboard_viewdetail') ?></span>
                    <span class="pull-right"><i><span class="glyphicon glyphicon-expand"></span></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i><span class="glyphicon glyphicon-envelope"></span></i> <?php echo $this->lang->line('dashboard_emailrecent') ?></h3>
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <?php if ($visitor_admin != 0 && $_SESSION['admin_type'] != 'admin'){ ?>
                        <div class="list-group-item">
                            <span class="badge"><?php echo date('Y-m-d H:i:s')?></span>
                            <b><?php echo  $this->lang->line('user_not_allow_txt') ?></b>
                        </div> 
                    <?php }else{
                        if ($email_logs === FALSE) { ?>
                            <div class="list-group-item">
                                <span class="badge"><?php echo date('Y-m-d H:i:s')?></span>
                                <b><?php echo  $this->lang->line('data_notfound') ?></b>
                            </div>                          
                        <?php } else { ?>
                            <?php foreach ($email_logs as $el) { 
                                $i = 0;
                                if($el['email_result'] != 'success'){
                                    $error_rs = '<span class="error">Error - '.strip_tags($el['email_result']).'</span>';
                                }else{
                                    $error_rs = '<span class="success">Success</span>';
                                }
                                $i++;
                            ?>
                            <span class="list-group-item">
                                <span class="badge"><?php echo $el['timestamp_create'] ?></span>
                                <b><?php echo $this->lang->line('forms_subject') ?>:</b> <?php echo $el['subject'] ?><br>
                                <span style="font-size:12px;"><b><?php echo $this->lang->line('dashboard_fromemail') ?>: <?php echo $el['from_email'] ?> | <?php echo $this->lang->line('dashboard_toemail') ?>: <?php echo $el['to_email'] ?></b></span> [<span style="font-style: italic; font-size:12px;"><?php echo $el['ip_address'] ?></span>] [<span style="font-style: italic; font-size:12px;"><?php echo $el['user_agent'] ?></span>] [<b><?php echo $error_rs?></b>]<br>
                                <pre><?php echo strip_tags($el['message']) ?></pre>
                                <div class="control-group text-right">
                                    <a class="btn btn-danger btn-sm" role="button" onclick="return confirm('<?php echo $this->lang->line('delete_message')?>')" href="<?php echo BASE_URL.'/admin/admin/deleteEmailLogs/'.$el['email_logs_id']?>">
                                        <i class="glyphicon glyphicon-remove"></i>
                                    </a>
                                </div>
                            </span>
                            <?php } ?>        
                        <?php } 
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
<?php if($config->link_statistic_active){
?>
<div class="row">
    <div class="col-lg-12" style="word-wrap:break-word;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i><span class="glyphicon glyphicon-envelope"></span></i> <?php echo $this->lang->line('dashboard_linkrecent') ?></h3>
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <?php if ($link_stats === FALSE) { ?>
                        <div class="list-group-item">
                            <span class="badge"><?php echo date('Y-m-d H:i:s')?></span>
                            <b><?php echo  $this->lang->line('data_notfound') ?></b>
                        </div>                          
                    <?php } else { ?>
                        <?php foreach ($link_stats as $ls) { ?>
                        <a class="list-group-item" href="<?php echo BASE_URL.'/admin/linkstats/view/'.$ls['link_statistic_id'] ?>">
                            <span class="badge"><?php echo $ls['timestamp_create'] ?></span>
                            <b>[<?php echo $ls['ip_address'] ?>]</b> - <?php echo $ls['link'] ?>
                        </a>
                        <?php } ?>
                    <?php } ?>
                </div>               
                <div class="text-right">
                    <a href="<?php echo BASE_URL.'/admin/linkstats' ?>" style="text-decoration: none;"><?php echo $this->lang->line('dashboard_viewdetail') ?> <i><span class="glyphicon glyphicon-expand"></span></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
<?php } ?>