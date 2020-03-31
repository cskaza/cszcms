<style type="text/css">.panel-body{word-wrap:break-word}</style>
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
                    <p><small><em><b><?php echo $this->Csz_model->getLabelLang('article_category_menu') ?>: <?php echo $category_name ?></b> <b>| <?php echo $this->Csz_model->getLabelLang('article_postdate') ?>:</b> <?php echo $article->timestamp_create ?> <b>| <?php if($article->timestamp_create !== $article->timestamp_update){ echo $this->Csz_model->getLabelLang('article_updatedate').':</b> '.$article->timestamp_update.' <b>|';}?> <?php echo $this->Csz_model->getLabelLang('article_postby') ?>:</b> <?php echo ucfirst($this->Csz_admin_model->getUser($article->user_admin_id)->name) ?></em></small></p>
                    <hr>
                    <p><b><?php echo $article->short_desc?></b></p><br>
                    <?php if($article->main_picture){
                        echo '<center><img data-src="'.base_url().'photo/plugin/article/'.$article->main_picture.'" class="lazy img-responsive img-thumbnail" alt="'.$article->title.'"></center><br>';
                    } ?>
                    <?php echo $this->Csz_model->getHtmlContent($article->content, $this->uri->segment(6)) ?>
                    <?php if($article->file_upload){ ?>
                    <hr>
                    <h6><?php echo $this->Csz_model->getLabelLang('article_filedownload_text') ?>: <a href="<?php echo $this->Csz_model->base_link(). '/plugin/article/downloadFile/'.$article->article_db_id; ?>" title="<?php echo $this->Csz_model->getLabelLang('article_download_link') ?>"><?php echo $this->Csz_model->getLabelLang('article_download_link') ?></a> (<?php echo $this->Article_model->countDownload($article->article_db_id); ?> <?php echo $this->Csz_model->getLabelLang('article_download_link') ?>)</h6>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <?php echo $this->Article_model->categoryMenu($this->session->userdata('fronlang_iso')); ?>
        </div>
    </div>
    <?php if($article->fb_comment_active){ ?>
    <!-- Facebook Comments -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <?php 
            $fb_comment = $this->Csz_model->getFBComments($this->Csz_model->base_link().'/plugin/article/view/'.$article->article_db_id.'/'.$article->url_rewrite, $article->fb_comment_limit, $article->fb_comment_sort, $this->session->userdata('fronlang_iso'));
            if($fb_comment !== FALSE){ echo $fb_comment; } ?>
        </div>
    </div>
    <!-- Facebook Comments -->
    <?php } ?>
</div>