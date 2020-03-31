<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="<?php echo $this->session->userdata('fronlang_iso') ?>" prefix="op: http://media.facebook.com/op#">
    <head>
        <meta charset="utf-8">
        <?php echo $canonical ?>
        <meta property="op:markup_version" content="v1.0">
        <meta property="og:title" content="<?php echo $article->title ?>">
        <meta property="og:description" content="<?php echo $article->short_desc ?>">
        <?php if ($article->main_picture) { ?>
            <meta property="og:image" content="<?php echo base_url('', '', TRUE) . 'photo/plugin/article/' . $article->main_picture ?>">
            <meta property="og:image:alt" content="<?php echo $article->title ?>">
        <?php } ?>
        <meta property="fb:article_style" content="default">
    </head>
    <body>
        <article>
            <header>
                <?php if ($article->main_picture) { ?>
                    <!-- The cover image shown inside your article --> 
                    <figure data-mode=aspect-fit>
                        <img src="<?php echo base_url('', '', TRUE) . 'photo/plugin/article/' . $article->main_picture ?>" />
                    </figure>   
                <?php } ?>
                <!-- The title and subtitle shown in your Instant Article -->
                <h1><?php echo $title ?></h1>
                <!-- A kicker for your article --> 
                <h3 class="op-kicker">
                    <?php echo $article->short_desc ?>
                </h3>
                <!-- The date and time when your article was originally published -->
                <time class="op-published" datetime="<?php echo date('c', strtotime($article->timestamp_create)) ?>"><?php echo date('F jS, g:i A', strtotime($article->timestamp_create)) ?></time>
                <!-- The date and time when your article was last updated -->
                <time class="op-modified" dateTime="<?php echo date('c', strtotime($article->timestamp_update)) ?>"><?php echo date('F jS, g:i A', strtotime($article->timestamp_update)) ?></time>
            </header>
            <h2><?php echo $article->title ?></h2>
            <?php if ($article->main_picture) { ?>
                <!-- The cover image shown inside your article --> 
                <figure data-feedback="fb:likes, fb:comments">
                    <img src="<?php echo base_url('', '', TRUE) . 'photo/plugin/article/' . $article->main_picture ?>" />
                    <figcaption><?php echo $article->title ?></figcaption>
                </figure>   
            <?php } ?>
            <!-- Body text for your article -->
            <?php echo $this->Csz_model->remove_empty_htmltags(str_replace(array('<br>', '<p>&nbsp;</p>'), '', $article->content)) ?>
            <!-- End Body text for your article -->
            <hr>
            <footer>
                <!-- Credits for your article -->
                <aside><?php echo $this->Csz_model->remove_empty_htmltags(str_replace(array('%YEAR%', '%YEAR', '%Y%', '%y%'), date('Y'), $config->site_footer)) ?></aside>
                <!-- Copyright details for your article -->
                <small><?php echo $this->Csz_admin_model->cszCopyright() ?></small>
            </footer>
        </article>
    </body>

</html>

