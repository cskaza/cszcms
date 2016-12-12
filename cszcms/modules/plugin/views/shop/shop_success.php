<div class="container">
    <!-- /.row -->
    <div class="row hidden-print">
        <div class="col-lg-12 col-md-12">
            <br><br>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-3 hidden-print">
            <?php echo $this->Shop_model->rightCatMenu(); ?>
        </div>
        <div class="col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading"><div class="row"><div class="text-left col-xs-8"><b><i class="glyphicon glyphicon-shopping-cart"></i> <?php echo $this->Csz_model->getLabelLang('shop_cart_text') ?></b></div><div class="text-right col-xs-4 hidden-print"><a class="btn btn-default btn-sm" href="<?php echo $this->csz_referrer->getIndex('front_shop'); ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $this->Csz_model->getLabelLang('btn_back'); ?></a></div></div></div>
                <div class="panel-body">
                    <div class="text-right hidden-print">
                        <a href="<?php echo BASE_URL . '/plugin/shop/bankTransfer/'.$this->uri->segment(4);?>" onclick="window.print();"><i class="glyphicon glyphicon-print"></i> Print</a><br>
                    </div>
                    <?php echo $shop_config->payment_body ?>
                    <?php echo $payment->order_detail ?>
                </div>
                <div class="panel-footer text-left">
                    <?php if($payment->payment_status == 'Completed'){ ?>
                        <h3 class="success"><?php echo $this->Csz_model->getLabelLang('shop_success_order_txt')?></h3>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>