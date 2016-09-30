<div class="container">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <br><br>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-3">
            <?php echo $this->Shop_model->rightCatMenu(); ?>
        </div>
        <div class="col-md-9">
            <?php /* Start Hot Product */ ?>
            <?php if($shop_config->stat_hot_show){ ?>
            <div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-fire"></i> <?php echo $this->Csz_model->getLabelLang('shop_hot_product') ?></b></div>
                <div class="panel-body">
                    <?php
                    if ($hot_product === FALSE) {
                        echo '<h3>' . $this->Csz_model->getLabelLang('shop_notfound') . '</h3>';
                    } else {
                        $i = 1; ?>
                        <div class="row">
                        <?php foreach ($hot_product as $a) { ?>
                            <div class="col-lg-4 col-md-4 ">
                                <div class="panel panel-default">
                                    <div class="panel-body text-center">
                                        <a href="<?php echo BASE_URL.'/plugin/shop/view/'.$a['shop_product_id'].'/'.$a['url_rewrite'] ?>" title="<?php echo $a['product_name'] ?>"><img src="<?php echo $this->Shop_model->getFirstImgs($a['shop_product_id']); ?>" class="img-responsive img-thumbnail" alt="<?php echo $a['product_name'] ?>"></a>
                                        <a href="<?php echo BASE_URL.'/plugin/shop/view/'.$a['shop_product_id'].'/'.$a['url_rewrite'] ?>" title="<?php echo $a['product_name'] ?>"><h2><?php echo $a['product_name'] ?></h2></a>
                                        <p><?php echo $a['short_desc'] ?></p>
                                        <?php if($a['discount']){ ?>
                                            <h5><span style="color:red;text-decoration:line-through;"><?php echo number_format($a['price'],2).' '.$shop_config->currency_code ?></span></h5>
                                            <h4><?php echo number_format($a['price']-$a['discount'],2).' '.$shop_config->currency_code ?></h4>
                                        <?php }else{ ?>
                                            <h4><?php echo number_format($a['price'],2).' '.$shop_config->currency_code ?></h4>
                                        <?php } ?>
                                        <br>
                                        <a class="btn btn-default" href="<?php echo BASE_URL.'/plugin/shop/view/'.$a['shop_product_id'].'/'.$a['url_rewrite'] ?>" title="<?php echo $this->Csz_model->getLabelLang('shop_view_btn') ?>"><?php echo $this->Csz_model->getLabelLang('shop_view_btn') ?></a>
                                    </div>
                                </div>                                
                            </div>
                        <?php if ($i % 3 == 0) { ?>
                        </div>
                        <div class="row">
                        <?php }
                 $i++;  } ?>
                        </div>
                <?php } ?>
                </div>
                <div class="panel-footer text-right">
                    <a class="btn btn-primary" href="<?php echo BASE_URL.'/plugin/shop/hotProduct' ?>" title="<?php echo $this->Csz_model->getLabelLang('shop_see_more') ?>"><?php echo $this->Csz_model->getLabelLang('shop_see_more') ?></a>
                </div>
            </div>
            <?php } ?>
            <?php /* Start Best Seller Product */ ?>
            <?php if($shop_config->stat_bestseller_show){ ?>
            <div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-thumbs-up"></i> <?php echo $this->Csz_model->getLabelLang('shop_bestseller_product') ?></b></div>
                <div class="panel-body">
                    <?php
                    if ($best_product === FALSE) {
                        echo '<h3>' . $this->Csz_model->getLabelLang('shop_notfound') . '</h3>';
                    } else {
                        $i = 1; ?>
                        <div class="row">
                        <?php foreach ($best_product as $a) { ?>
                            <div class="col-lg-4 col-md-4 ">
                                <div class="panel panel-default">
                                    <div class="panel-body text-center">
                                        <a href="<?php echo BASE_URL.'/plugin/shop/view/'.$a['shop_product_id'].'/'.$a['url_rewrite'] ?>" title="<?php echo $a['product_name'] ?>"><img src="<?php echo $this->Shop_model->getFirstImgs($a['shop_product_id']); ?>" class="img-responsive img-thumbnail" alt="<?php echo $a['product_name'] ?>"></a>
                                        <a href="<?php echo BASE_URL.'/plugin/shop/view/'.$a['shop_product_id'].'/'.$a['url_rewrite'] ?>" title="<?php echo $a['product_name'] ?>"><h2><?php echo $a['product_name'] ?></h2></a>
                                        <p><?php echo $a['short_desc'] ?></p>
                                        <?php if($a['discount']){ ?>
                                            <h5><span style="color:red;text-decoration:line-through;"><?php echo number_format($a['price'],2).' '.$shop_config->currency_code ?></span></h5>
                                            <h4><?php echo number_format($a['price']-$a['discount'],2).' '.$shop_config->currency_code ?></h4>
                                        <?php }else{ ?>
                                            <h4><?php echo number_format($a['price'],2).' '.$shop_config->currency_code ?></h4>
                                        <?php } ?>
                                        <br>
                                        <a class="btn btn-default" href="<?php echo BASE_URL.'/plugin/shop/view/'.$a['shop_product_id'].'/'.$a['url_rewrite'] ?>" title="<?php echo $this->Csz_model->getLabelLang('shop_view_btn') ?>"><?php echo $this->Csz_model->getLabelLang('shop_view_btn') ?></a>
                                    </div>
                                </div>                                
                            </div>
                        <?php if ($i % 3 == 0) { ?>
                        </div>
                        <div class="row">
                        <?php }
                 $i++;  } ?>
                        </div>
                <?php } ?>
                </div>
                <div class="panel-footer text-right">
                    <a class="btn btn-primary" href="<?php echo BASE_URL.'/plugin/shop/bestSeller' ?>" title="<?php echo $this->Csz_model->getLabelLang('shop_see_more') ?>"><?php echo $this->Csz_model->getLabelLang('shop_see_more') ?></a>
                </div>
            </div>
            <?php } ?>
            <?php /* Start New Product */ ?>
            <?php if($shop_config->stat_new_show){ ?>
            <div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-star"></i> <?php echo $this->Csz_model->getLabelLang('shop_new_product') ?></b></div>
                <div class="panel-body">
                    <?php
                    if ($new_product === FALSE) {
                        echo '<h3>' . $this->Csz_model->getLabelLang('shop_notfound') . '</h3>';
                    } else {
                        $i = 1; ?>
                        <div class="row">
                        <?php foreach ($new_product as $a) { ?>
                            <div class="col-lg-4 col-md-4 ">
                                <div class="panel panel-default">
                                    <div class="panel-body text-center">
                                        <a href="<?php echo BASE_URL.'/plugin/shop/view/'.$a['shop_product_id'].'/'.$a['url_rewrite'] ?>" title="<?php echo $a['product_name'] ?>"><img src="<?php echo $this->Shop_model->getFirstImgs($a['shop_product_id']); ?>" class="img-responsive img-thumbnail" alt="<?php echo $a['product_name'] ?>"></a>
                                        <a href="<?php echo BASE_URL.'/plugin/shop/view/'.$a['shop_product_id'].'/'.$a['url_rewrite'] ?>" title="<?php echo $a['product_name'] ?>"><h2><?php echo $a['product_name'] ?></h2></a>
                                        <p><?php echo $a['short_desc'] ?></p>
                                        <?php if($a['discount']){ ?>
                                            <h5><span style="color:red;text-decoration:line-through;"><?php echo number_format($a['price'],2).' '.$shop_config->currency_code ?></span></h5>
                                            <h4><?php echo number_format($a['price']-$a['discount'],2).' '.$shop_config->currency_code ?></h4>
                                        <?php }else{ ?>
                                            <h4><?php echo number_format($a['price'],2).' '.$shop_config->currency_code ?></h4>
                                        <?php } ?>
                                        <br>
                                        <a class="btn btn-default" href="<?php echo BASE_URL.'/plugin/shop/view/'.$a['shop_product_id'].'/'.$a['url_rewrite'] ?>" title="<?php echo $this->Csz_model->getLabelLang('shop_view_btn') ?>"><?php echo $this->Csz_model->getLabelLang('shop_view_btn') ?></a>
                                    </div>
                                </div>                                
                            </div>
                        <?php if ($i % 3 == 0) { ?>
                        </div>
                        <div class="row">
                        <?php }
                 $i++;  } ?>
                        </div>
                <?php } ?>
                </div>
                <div class="panel-footer text-right">
                    <a class="btn btn-primary" href="<?php echo BASE_URL.'/plugin/shop/newProduct' ?>" title="<?php echo $this->Csz_model->getLabelLang('shop_see_more') ?>"><?php echo $this->Csz_model->getLabelLang('shop_see_more') ?></a>
                </div>
            </div>
            <?php } ?>
            <?php /* Start Sold Out Product */ ?>
            <?php if($shop_config->stat_soldout_show){ ?>
            <div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-bell"></i> <?php echo $this->Csz_model->getLabelLang('shop_soldout_product') ?></b></div>
                <div class="panel-body">
                    <?php
                    if ($sold_product === FALSE) {
                        echo '<h3>' . $this->Csz_model->getLabelLang('shop_notfound') . '</h3>';
                    } else {
                        $i = 1; ?>
                        <div class="row">
                        <?php foreach ($sold_product as $a) { ?>
                            <div class="col-lg-4 col-md-4 ">
                                <div class="panel panel-default">
                                    <div class="panel-body text-center">
                                        <a href="<?php echo BASE_URL.'/plugin/shop/view/'.$a['shop_product_id'].'/'.$a['url_rewrite'] ?>" title="<?php echo $a['product_name'] ?>"><img src="<?php echo $this->Shop_model->getFirstImgs($a['shop_product_id']); ?>" class="img-responsive img-thumbnail" alt="<?php echo $a['product_name'] ?>"></a>
                                        <a href="<?php echo BASE_URL.'/plugin/shop/view/'.$a['shop_product_id'].'/'.$a['url_rewrite'] ?>" title="<?php echo $a['product_name'] ?>"><h2><?php echo $a['product_name'] ?></h2></a>
                                        <p><?php echo $a['short_desc'] ?></p>
                                        <div class="h4 error"><?php echo $this->Csz_model->getLabelLang('shop_soldout_product') ?></div>
                                        <br>
                                        <a class="btn btn-default" href="<?php echo BASE_URL.'/plugin/shop/view/'.$a['shop_product_id'].'/'.$a['url_rewrite'] ?>" title="<?php echo $this->Csz_model->getLabelLang('shop_view_btn') ?>"><?php echo $this->Csz_model->getLabelLang('shop_view_btn') ?></a>
                                    </div>
                                </div>                                
                            </div>
                        <?php if ($i % 3 == 0) { ?>
                        </div>
                        <div class="row">
                        <?php }
                 $i++;  } ?>
                        </div>
                <?php } ?>
                </div>
                <div class="panel-footer text-right">
                    <a class="btn btn-primary" href="<?php echo BASE_URL.'/plugin/shop/soldOut' ?>" title="<?php echo $this->Csz_model->getLabelLang('shop_see_more') ?>"><?php echo $this->Csz_model->getLabelLang('shop_see_more') ?></a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>