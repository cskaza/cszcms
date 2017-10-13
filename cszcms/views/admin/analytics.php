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
                    <label class="control-label" for="last_days"><?php echo $this->lang->line('ga_last_txt'); ?></label>
                    <?php
                    $att = 'id="last_days" class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = \''.$this->Csz_model->base_link().'/admin/analytics/\'+this.options[this.selectedIndex].value);" onblur="this.options[this.selectedIndex].value && (window.location = \''.$this->Csz_model->base_link().'/admin/analytics/\'+this.options[this.selectedIndex].value);"';
                    $data = array();
                    $data['30'] = '30 '.$this->lang->line('ga_days');
                    $data['1'] = '1 '.$this->lang->line('ga_days');
                    $data['3'] = '3 '.$this->lang->line('ga_days');
                    $data['5'] = '5 '.$this->lang->line('ga_days');
                    $data['7'] = '7 '.$this->lang->line('ga_days');
                    $data['15'] = '15 '.$this->lang->line('ga_days');
                    $data['60'] = '60 '.$this->lang->line('ga_days');
                    $data['90'] = '90 '.$this->lang->line('ga_days');
                    $data['120'] = '120 '.$this->lang->line('ga_days');
                    $data['180'] = '180 '.$this->lang->line('ga_days');
                    $data['240'] = '240 '.$this->lang->line('ga_days');
                    $data['300'] = '300 '.$this->lang->line('ga_days');
                    $data['360'] = '360 '.$this->lang->line('ga_days');
                    echo form_dropdown('last_days', $data, $this->uri->segment(3), $att);
                    ?><br><br>
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
    <div class="col-md-12">
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
</div>
<!-- /.box -->    
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $this->lang->line('pages_keywords'); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <section id="timeline-allkeyword"></section>
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
