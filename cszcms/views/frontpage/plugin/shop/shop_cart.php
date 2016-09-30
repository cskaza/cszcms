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
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center" style="vertical-align:middle;">#</th>
                                    <th width="13%" class="text-center" style="vertical-align:middle;"><?php echo $this->Csz_model->getLabelLang('shop_product_code_txt'); ?></th>
                                    <th width="40%" class="text-center" style="vertical-align:middle;"><?php echo $this->Csz_model->getLabelLang('shop_product_name_txt'); ?></th>
                                    <th width="13%" class="text-center" style="vertical-align:middle;"><?php echo $this->Csz_model->getLabelLang('shop_price_txt'); ?><br>(<?php echo $shop_config->currency_code ?>)</th>
                                    <th width="5%" class="text-center" style="vertical-align:middle;"><?php echo $this->Csz_model->getLabelLang('shop_qty_txt'); ?></th>
                                    <th width="17%" class="text-center" style="vertical-align:middle;"><?php echo $this->Csz_model->getLabelLang('shop_amount_txt'); ?><br>(<?php echo $shop_config->currency_code ?>)</th>
                                    <th width="7%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($cart_check)) { ?>
                                    <tr>
                                        <td colspan="7" class="text-center"><span class="h3 error"><?php echo $this->Csz_model->getLabelLang('shop_notfound') ?></span></td>
                                    </tr>                           
                                <?php } else { ?>
                                    <?php
                                    $i = 1;
                                    foreach ($cart_check as $u) {
                                        echo '<tr>';
                                        echo '<td class="text-center" style="vertical-align:middle;">'.$i.'</td>';
                                        echo '<td class="text-center" style="vertical-align:middle;">' . $u['id'] . '</td>';
                                        echo '<td style="vertical-align:middle;">';
                                        echo '<b>'.$u['name'].'</b> <a href="#" onclick="window.open(\''.BASE_URL.'/plugin/shop/view/'.$u['shop_product_id'].'/'.$u['url_rewrite'].'\', \'newwindow\', \'width=640, height=800, scrollbars=yes\'); return false;"><i class="glyphicon glyphicon-search"></i></a><br>';
                                        $opt_product = $this->cart->product_options($u['rowid']);
                                        if(!empty($opt_product)){
                                            $opt_arr = array();
                                            echo '<span class="error small"><em>';
                                            foreach ($opt_product as $key => $opt) {
                                                $opt_arr[] = $key.'='.$opt;
                                            }
                                            $opt_show = implode(', ', $opt_arr);
                                            echo $opt_show.'</em></span>';
                                        }                                       
                                        echo '</td>';
                                        echo '<td class="text-center" style="vertical-align:middle;">' . number_format($u['price'], 2) . '</td>';  
                                        echo '<td class="text-center" style="vertical-align:middle;">' . number_format($u['qty']) . '</b></td>';
                                        echo '<td class="text-center" style="vertical-align:middle;">' . number_format($u['subtotal'], 2) . '</td>';
                                        echo '<td class="text-center" style="vertical-align:middle;"><a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->Csz_model->getLabelLang('shop_delete_alert').'\')" href="'.BASE_URL . '/plugin/shop/removeCartItem/'.$u['rowid'].'"><i class="glyphicon glyphicon-remove"></i></a></td>';
                                        echo '</tr>';
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        <a role="button" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo $this->Csz_model->getLabelLang('shop_delete_alert')?>')" href="<?php echo BASE_URL . '/plugin/shop/clearAllCart'?>"><i class="glyphicon glyphicon-trash"></i> <?php echo $this->Csz_model->getLabelLang('shop_clear_cart_txt')?></a>
                    </div><br>
                    <div class="text-left">
                        <h4><?php echo $this->Csz_model->getLabelLang('shop_order_total_txt'). ': ' . number_format($this->cart->total(), 2) . ' '. $shop_config->currency_code ?></h4>                        
                    </div>                  
                </div>
                <div class="panel-footer text-left">
                    <a role="button" class="btn btn-primary" href="<?php echo BASE_URL . '/plugin/shop/placeOrder'?>"><i class="glyphicon glyphicon-shopping-cart"></i> <?php echo $this->Csz_model->getLabelLang('shop_place_order_txt')?></a>
                </div>
            </div>
        </div>
    </div>
</div>