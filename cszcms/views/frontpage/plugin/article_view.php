<div class="container">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <br><br>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-9 col-md-9">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <h2><?php echo $article->title ?></h2>
                    <p><small><em><b><?php echo $this->Csz_model->getLabelLang('article_category_menu') ?>: <a href="<?php echo BASE_URL.'/plugin/article/category/'.$this->Csz_model->rw_link($category_name)?>" title="<?php echo $category_name ?>"><?php echo $category_name ?></a></b> <b>| <?php echo $this->Csz_model->getLabelLang('article_postdate') ?>:</b> <?php echo $article->timestamp_create ?> <b>| <?php if($article->timestamp_create !== $article->timestamp_update){ echo $this->Csz_model->getLabelLang('article_updatedate').':</b> '.$article->timestamp_update.' <b>|';}?> <?php echo $this->Csz_model->getLabelLang('article_postby') ?>:</b> <?php echo ucfirst($this->Csz_admin_model->getUser($article->user_admin_id)->name) ?></em></small></p>
                    <hr>
                    <p><b><?php echo $article->short_desc?></b></p><br>
                    <?php if($article->main_picture){
                        echo '<center><img src="'.BASE_URL.'/photo/plugin/article/'.$article->main_picture.'" class="img-responsive img-thumbnail" alt="'.$article->title.'"></center><br>';
                    } ?>
                    <?php echo $article->content ?>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <?php echo $this->Article_model->categoryMenu($this->session->userdata('fronlang_iso')); ?>
        </div>
    </div>
</div>