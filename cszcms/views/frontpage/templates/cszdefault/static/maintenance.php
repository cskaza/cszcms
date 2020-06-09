<?php $config = $this->Csz_model->load_config(); ?>
<div class="jumbotron">
    <div class="container">
        <center>
            <i style="font-size:150px;color:red;" class="fa fa-wrench" aria-hidden="true"></i><br><br>
            <h1><?php echo $this->Csz_model->getLabelLang('site_maintenance_title'); ?></h1>
            <h2><?php echo $this->Csz_model->getLabelLang('site_maintenance_subtitle'); ?></h2>
            <br><p><?php echo $this->Csz_model->getLabelLang('site_maintenance_text'); ?></p>
            <br><p><b>&mdash; <?php echo $config->site_name ?> &mdash;</b></p>
            <small><em>[<?php echo $config->timestamp_update ?>]</em></small>
        </center>
    </div>
</div>