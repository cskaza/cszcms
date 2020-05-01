<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h2 class="box-title"><b><?php echo $this->lang->line('dash_welcome') ?></b></h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <p><?php echo $this->lang->line('dash_message') ?></p>
            </div>
            <div class="box-footer">
                <p><b><a href="https://www.cszcms.com" target="_blank"><?php echo $this->lang->line('dash_cszcms_link') ?></a></b></p>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
<!-- Page Heading -->
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i><span class="fa fa-rss"></span></i> <?php echo $this->lang->line('dashboard_rssnews') ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12" style="word-wrap:break-word;">
                        <?php echo $rss; /* get rss feed */?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>