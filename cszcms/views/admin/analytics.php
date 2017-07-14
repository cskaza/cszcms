<style type="text/css">
.chart {
  width: 100%;
  position: relative;
}
</style>
<div class="box box-success">
    <div class="box-header with-border">
        <h2 class="box-title"><?php echo $this->lang->line('ga_last30'); ?></h2>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <?php if($settings->ga_client_id != NULL && $settings->ga_view_id != NULL){ ?>
                    <section id="auth-button"></section>
                <?php }else{ ?>
                    <div class="callout callout-danger">
                        <?php echo $this->lang->line('ga_no_settings'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- /.box -->
<?php if($settings->ga_client_id != NULL && $settings->ga_view_id != NULL){ ?>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h2 class="box-title"><?php echo $this->lang->line('ga_maps'); ?></h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <section id="timeline-map" class="chart"></section>                
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h2 class="box-title"><?php echo $this->lang->line('ga_sessions'); ?></h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <section id="timeline-sessions" class="chart"></section>
            </div>
        </div>
    </div>
</div>
<!-- /.box -->
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h2 class="box-title"><?php echo $this->lang->line('ga_devices'); ?></h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <section id="timeline-device" class="chart"></section>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h2 class="box-title"><?php echo $this->lang->line('ga_sources'); ?></h2>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <section id="timeline-source" class="chart">
            </div>
        </div>
    </div>
</div>
<!-- /.box -->
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $this->lang->line('ga_allpage'); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <section id="timeline-allpage"></section>
            </div>
        </div>
        <!-- /.box -->
    </div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $this->lang->line('ga_refer'); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <section id="timeline-refer"></section>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>

<?php } ?>
