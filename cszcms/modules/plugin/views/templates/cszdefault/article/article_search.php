<style type="text/css">.galleryimgs img{width:100%!important;height:150px!important;object-fit:cover;margin:20px 0}</style>
<div class="container">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <br><br>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-edit"></i> <?php echo $this->Csz_model->getLabelLang('article_search_txt').': '.$searchtxt ?></b></div>
                <div class="panel-body">
                    <?php
                    if ($article === FALSE) {
                        echo '<h3>' . $this->Csz_model->getLabelLang('article_not_found') . '</h3>';
                    } else {
                        foreach ($article as $a) { ?>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 galleryimgs">
                                    <center><a href="<?php echo $this->Csz_model->base_link().'/plugin/article/view/'.$a['article_db_id'].'/'.$a['url_rewrite'] ?>" title="<?php echo $a['title'] ?>">
                                    <?php
                                    if($a["main_picture"]){
                                        echo '<img data-src="'.base_url().'photo/plugin/article/'.$a['main_picture'].'" class="lazy img-responsive img-thumbnail" alt="'.$a['title'].'">';
                                    }else{
                                        echo '<img data-src="'.base_url().'photo/no_image.png" class="lazy img-responsive img-thumbnail" alt="'.$a['title'].'">';
                                    }
                                    ?></a></center>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    <h3><a href="<?php echo $this->Csz_model->base_link().'/plugin/article/view/'.$a['article_db_id'].'/'.$a['url_rewrite'] ?>" title="<?php echo $a['title'] ?>"><?php echo $a['title'] ?></a></h3>
                                    <p><small><b><?php echo $this->Csz_model->getLabelLang('article_postdate') ?>: <?php echo $a['timestamp_create'] ?></b></small></p>
                                    <p><?php echo $a['short_desc'] ?></p>
                                    <p><a class="btn btn-primary" href="<?php echo $this->Csz_model->base_link().'/plugin/article/view/'.$a['article_db_id'].'/'.$a['url_rewrite'] ?>" title="<?php echo $a['title'] ?>"><?php echo $this->Csz_model->getLabelLang('article_readmore_text') ?></a></p>
                                </div>
                            </div><hr>
                  <?php }
                    } ?>
                </div>
                <div class="panel-footer">
                    <?php echo $this->pagination->create_links(); ?> <b><?php echo $this->Csz_model->getLabelLang('total_txt') . ' ' . $total_row . ' ' . $this->Csz_model->getLabelLang('records_txt'); ?></b>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <?php echo $this->Article_model->categoryMenu($this->session->userdata('fronlang_iso')); ?>
        </div>
    </div>
</div>