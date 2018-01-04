<style type="text/css">.galleryimgs img{width:100%!important;height:250px!important;object-fit:cover;margin:20px 0}</style>
<div class="jumbotron">
    <div class="container">
        <h1><?php echo $album->album_name ?></h1>
        <span class="h5"><em><?php echo $this->Csz_model->getLabelLang('article_postdate') ?>: <?php echo $album->timestamp_create ?></em></span>
        <br><br><br>
        <span class="h4"><?php echo $album->short_desc ?></span>
        <br><br><br><p><a class="btn btn-primary btn-lg" href="<?php echo $this->Csz_model->base_link().'/plugin/gallery' ?>" role="button"><?php echo $this->Csz_model->getLabelLang('btn_back') ?></a></p>
    </div>
</div>
<div class="container">
    <div class="row">
        <?php 
        if($image !== FALSE){
            $i = 1;
            foreach ($image as $value) { ?>
                <div class="col-md-3 text-center galleryimgs" style="padding-bottom:15px;">
                    <?php if($value['gallery_type'] == 'multiimages'){ ?>
                        <a href="<?php echo ($value['file_upload']) ? base_url() .'photo/plugin/gallery/'.$value['file_upload'] : base_url() .'photo/no_image.png' ?>" data-toggle="lightbox" data-gallery="multiimages"<?php echo ($value['caption'])?' data-title="'.$value['caption'].'"' : '' ?>>
                            <img class="lazy img-responsive img-thumbnail" data-src="<?php echo ($value['file_upload']) ? base_url() .'photo/plugin/gallery/'.$value['file_upload'] : base_url() .'photo/no_image.png' ?>" alt="<?php echo $value['caption'] ?>">
                        </a>
                    <?php }else if($value['gallery_type'] == 'youtubevideos'){ 
                        $youtube_script_replace = array("http://youtu.be/", "http://www.youtube.com/watch?v=", "https://youtu.be/", "https://www.youtube.com/watch?v=", "http://www.youtube.com/embed/", "https://www.youtube.com/embed/");
                        $youtube_value = str_replace($youtube_script_replace, '', $value['youtube_url']); ?>
                        <a href="https://www.youtube.com/embed/<?php echo $youtube_value?>" data-toggle="lightbox" data-gallery="youtubevideos"<?php echo ($value['caption'])?' data-title="'.$value['caption'].'"' : '' ?>>
                            <span style="position:absolute;margin-top:30px;margin-left:15px;z-index:10;font-size:44px;" class="fa fa-youtube-play"></span>
                            <img class="lazy img-responsive img-thumbnail" data-src="<?php echo ($value['youtube_url']) ? '//i1.ytimg.com/vi/'.$youtube_value.'/mqdefault.jpg' : base_url() .'photo/no_image.png' ?>" alt="<?php echo $value['caption'] ?>">
                        </a>
                    <?php } ?>                    
                </div>
                <?php if ($i % 4 == 0) { ?>
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