<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <!-- Start Shop Admin Menu -->
        <?php echo $this->Shop_model->AdminMenu() ?>
        <!-- End Shop Admin Menu -->
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-shopping-cart"></span></i> <?php echo $this->lang->line('shop_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-4 col-md-4">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <h1><i><span class="glyphicon glyphicon-usd"></span></i></h1>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $total_complete ?> / <?php echo $total_order ?></div>
                        <div><?php echo $this->lang->line('shop_dashboard_totalcomplete') ?> / <?php echo $this->lang->line('shop_dashboard_totalorder') ?>!</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo BASE_URL . '/admin/plugin/shop/order' ?>">
                <div class="panel-footer">
                    <span class="pull-left"><?php echo $this->lang->line('dashboard_viewdetail') ?></span>
                    <span class="pull-right"><i><span class="glyphicon glyphicon-expand"></span></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <h1><i><span class="glyphicon glyphicon-plane"></span></i></h1>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $total_shipping ?></div>
                        <div><?php echo $this->lang->line('shop_dashboard_totalshipping') ?>!</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo BASE_URL . '/admin/plugin/shop/shipping' ?>">
                <div class="panel-footer">
                    <span class="pull-left"><?php echo $this->lang->line('dashboard_viewdetail') ?></span>
                    <span class="pull-right"><i><span class="glyphicon glyphicon-expand"></span></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <h1><i><span class="glyphicon glyphicon-shopping-cart"></span></i></h1>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $total_product ?></div>
                        <div><?php echo $this->lang->line('shop_dashboard_totalproduct') ?>!</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo BASE_URL . '/admin/plugin/shop/products' ?>">
                <div class="panel-footer">
                    <span class="pull-left"><?php echo $this->lang->line('dashboard_viewdetail') ?></span>
                    <span class="pull-right"><i><span class="glyphicon glyphicon-expand"></span></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12" style="word-wrap:break-word;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i><span class="glyphicon glyphicon-usd"></span></i> <?php echo $this->lang->line('shop_paymentrecent') ?></h3>
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <?php if ($payment === FALSE) { ?>
                        <div class="list-group-item">
                            <span class="badge"><?php echo date('Y-m-d H:i:s') ?></span>
                            <b><?php echo $this->lang->line('data_notfound') ?></b>
                        </div>                          
                    <?php } else { ?>
                        <?php
                        foreach ($payment as $ls) {
                            $i = 0;
                            if ($ls['payment_status'] == 'Completed') {
                                $error_rs = '<span class="success">Completed</span>';
                            } else if ($ls['payment_status'] == 'Pending') {
                                $error_rs = '<span>Pending</span>';
                            } else {
                                $error_rs = '<span class="error">Not Completed</span>';
                            }
                            $i++;
                            ?>
                            <span class="list-group-item">
                                <span class="badge"><?php echo $ls['timestamp_create'] ?></span>
                                <span style="font-size:12px;"> [<span style="font-style: italic; font-size:12px;"><?php echo $ls['ip_address'] ?></span>] [<span style="font-style: italic; font-size:12px;"><?php echo $ls['user_agent'] ?></span>] [<b><?php echo $error_rs ?></b>]</span><br>
                                <div class="well">
                                    <b>Invoice ID: <?php echo $ls['inv_id'] ?></b><br>
                                    <b><?php echo $this->lang->line('shop_products_price') ?>: <?php echo number_format(($ls['price_total']),2).' '.$shop_config->currency_code ?></b>
                                </div>
                            </span>
                        <?php } ?>
                    <?php } ?>
                </div>               
                <div class="text-right">
                    <a href="<?php echo BASE_URL . '/admin/plugin/shop/order' ?>" style="text-decoration: none;"><?php echo $this->lang->line('dashboard_viewdetail') ?> <i><span class="glyphicon glyphicon-expand"></span></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->