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