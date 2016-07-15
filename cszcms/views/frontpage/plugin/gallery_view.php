<div class="jumbotron">
    <div class="container">
        <h1><?php echo $album->album_name ?></h1>
        <span class="h5"><em><?php echo $this->Csz_model->getLabelLang('article_postdate') ?>: <?php echo $album->timestamp_create ?></em></span>
        <br><br><br>
        <span class="h4"><?php echo $album->short_desc ?></span>
        <br><br><br><p><a class="btn btn-primary btn-lg" href="<?php echo BASE_URL.'/plugin/gallery' ?>" role="button"><?php echo $this->Csz_model->getLabelLang('btn_back') ?></a></p>
    </div>
</div>
<div class="container">
    <div class="row">
        <?php 
        if($image !== FALSE){
            $i = 1;
            foreach ($image as $value) { ?>
                <div class="col-md-2" style="padding-bottom:15px;">
                    <a href="<?php echo ($value['file_upload']) ? BASE_URL.'/photo/plugin/gallery/'.$value['file_upload'] : BASE_URL.'/photo/no_image.png' ?>" class="gallery-image-link thumbnail" data-lightbox="gallery-set"<?php echo ($value['caption'])?' data-title="'.$value['caption'].'"' : '' ?>>
                        <img class="img-responsive img-thumbnail gallery-image" src="<?php echo ($value['file_upload']) ? BASE_URL.'/photo/plugin/gallery/'.$value['file_upload'] : BASE_URL.'/photo/no_image.png' ?>" alt="<?php echo $value['caption'] ?>">
                    </a>
                </div>
                <?php if ($i % 6 == 0) { ?>
                </div>
                <div class="row">
                <?php }
            $i++; } 
        }else{ ?>
                <center><h2><?php echo $this->Csz_model->getLabelLang('picture_not_found')?></h2></center>
        <?php } ?>
    </div>
    <br><br>
    <?php echo $this->pagination->create_links(); ?> <b><?php echo $this->Csz_model->getLabelLang('total_txt') . ' ' . $total_row . ' ' . $this->Csz_model->getLabelLang('records_txt'); ?></b>
</div>