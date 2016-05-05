<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-dashboard"></span></i> <?= $this->lang->line('nav_dash') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?= $this->lang->line('dash_welcome') ?></div>
        <p><?= $this->lang->line('dash_message') ?></p>
        <p><b>Current Date/Time: <em><?=date('d-m-Y H:i:s')?></em></b></p>
    </div>
</div>
<!-- /.row -->
<br><br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i><span class="glyphicon glyphicon-file"></span></i> <?= $this->lang->line('dash_recent') ?></h3>
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <center><?= $this->lang->line('dash_no_recent') ?></center>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->