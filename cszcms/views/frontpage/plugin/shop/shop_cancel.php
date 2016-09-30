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
            <div class="panel panel-primary">
                <div class="panel-heading"><div class="row"><div class="text-left col-xs-8"><b><i class="glyphicon glyphicon-shopping-cart"></i> <?php echo $this->Csz_model->getLabelLang('shop_cart_text') ?></b></div><div class="text-right col-xs-4"><a class="btn btn-default btn-sm" href="<?php echo $this->csz_referrer->getIndex('front_shop'); ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $this->Csz_model->getLabelLang('btn_back'); ?></a></div></div></div>
                <div class="panel-body">
                    <div class="h3 error"><?php echo $this->Csz_model->getLabelLang('shop_cancel_order_txt')?></div>
                </div>
                <div class="panel-footer text-left">
                    <a role="button" class="btn btn-primary" href="<?php echo BASE_URL . '/plugin/shop/cartView'?>"><i class="glyphicon glyphicon-shopping-cart"></i> <?php echo $this->Csz_model->getLabelLang('shop_cart_text')?></a>
                </div>
            </div>
        </div>
    </div>
</div>