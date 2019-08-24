<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-user"></span></i> <?php echo  $this->lang->line('pm_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading"><div class="row"><div class="text-left col-xs-6"><b><i class="glyphicon glyphicon-envelope"></i> <?php echo $this->lang->line('pm_from') ?>: <?php echo $this->Csz_admin_model->getUser($pm->sender_id)->name; ?> | <?php echo $this->lang->line('pm_to') ?>: <?php echo $this->Csz_admin_model->getUser($pm->receiver_id)->name; ?></b></div><div class="text-right col-xs-6"><a href="<?php echo $this->csz_referrer->getIndex()?>"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $this->lang->line('btn_back') ?></a></div></div></div>
                    <div class="panel-body">
                        <span class="badge"><?php echo $pm->date_sent?></span>
                        <h3><?php echo $pm->title; ?></h3>
                        <br>
                        <pre style="overflow-x:auto;white-space:pre-wrap;white-space: -moz-pre-wrap;white-space: -pre-wrap;white-space: -o-pre-wrap;word-wrap: break-word;"><?php echo $pm->message; ?></pre>
                        <br><br>
                    </div>
                    <div class="panel-footer"><a href="<?php echo $this->Csz_model->base_link(). '/admin/pm/newpm/' . $pm->receiver_id . '/' . $pm->id; ?>" class="btn btn-default" role="button"><?php echo $this->Csz_model->getLabelLang('pm_newmsg_txt') ?></a> &nbsp;&nbsp; <a href="<?php echo $this->Csz_model->base_link(). '/admin/pm/delete/'.$pm->id; ?>" class="btn btn-danger" role="button" onclick="return confirm('<?php echo $this->lang->line('delete_message'); ?>')"><?php echo $this->lang->line('btn_delete') ?></a></div>
                </div>
            </div>
        </div>
    </div>
</div>
