<?php $config = $this->Csz_model->load_config(); ?>
<div class="jumbotron">
    <div class="container">
        <h1><i class="glyphicon glyphicon-exclamation-sign"></i> Site Maintenance.<br>We&rsquo;ll be back soon!</h1>
        <br><p>Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment.<br>If you need to you can always <a href="mailto:<?php echo $config->default_email ?>">contact us</a>, otherwise we&rsquo;ll be back online shortly!</p>
        <br><p>&mdash; <?php echo $config->site_name ?></p>
    </div>
</div>