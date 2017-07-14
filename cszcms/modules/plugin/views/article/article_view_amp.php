<div class="container">
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2><?php echo $article->title ?></h2>
                    <p><small><em><b><?php echo $this->Csz_model->getLabelLang('article_category_menu') ?>: <a href="<?php echo $this->Csz_model->base_link().'/plugin/article/category/'.$this->Csz_model->rw_link($category_name)?>" title="<?php echo $category_name ?>"><?php echo $category_name ?></a></b> <b>| <?php echo $this->Csz_model->getLabelLang('article_postdate') ?>:</b> <?php echo $article->timestamp_create ?> <b>| <?php if($article->timestamp_create !== $article->timestamp_update){ echo $this->Csz_model->getLabelLang('article_updatedate').':</b> '.$article->timestamp_update.' <b>|';}?> <?php echo $this->Csz_model->getLabelLang('article_postby') ?>:</b> <?php echo ucfirst($this->Csz_admin_model->getUser($article->user_admin_id)->name) ?></em></small></p>
                    <hr>
                    <p><b><?php echo $article->short_desc?></b></p><br>
                    <?php if($article->main_picture){
                        echo '<center><amp-img src="'.base_url().'photo/plugin/article/'.$article->main_picture.'" layout="responsive" width="250" height="250" sizes="(min-width: 320px) 288px, 100vw" alt="' . $article->title . '"></amp-img></center><br>';
                    } ?>
                    <?php echo $this->Csz_model->getHtmlContent($article->content, $this->uri->segment(6)) ?>
                </div>
            </div>
        </div>
    </div>
</div>