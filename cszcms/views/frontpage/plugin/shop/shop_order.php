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
                <div class="panel-heading"><div class="row"><div class="text-left col-xs-8"><b><i class="glyphicon glyphicon-shopping-cart"></i> <?php echo $this->Csz_model->getLabelLang('shop_place_order_txt') ?></b></div><div class="text-right col-xs-4"><a class="btn btn-default btn-sm" href="<?php echo $this->csz_referrer->getIndex('front_shop'); ?>"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $this->Csz_model->getLabelLang('btn_back'); ?></a></div></div></div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center" style="vertical-align:middle;">#</th>
                                    <th width="13%" class="text-center" style="vertical-align:middle;"><?php echo $this->Csz_model->getLabelLang('shop_product_code_txt'); ?></th>
                                    <th width="47%" class="text-center" style="vertical-align:middle;"><?php echo $this->Csz_model->getLabelLang('shop_product_name_txt'); ?></th>
                                    <th width="13%" class="text-center" style="vertical-align:middle;"><?php echo $this->Csz_model->getLabelLang('shop_price_txt'); ?><br>(<?php echo $shop_config->currency_code ?>)</th>
                                    <th width="5%" class="text-center" style="vertical-align:middle;"><?php echo $this->Csz_model->getLabelLang('shop_qty_txt'); ?></th>
                                    <th width="17%" class="text-center" style="vertical-align:middle;"><?php echo $this->Csz_model->getLabelLang('shop_amount_txt'); ?><br>(<?php echo $shop_config->currency_code ?>)</th>
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
                                        echo '</tr>';
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-left">
                        <h3 class="error"><?php echo $this->Csz_model->getLabelLang('shop_order_total_txt'). ': ' . number_format($this->cart->total(), 2) . ' '. $shop_config->currency_code ?></h3>
                    </div>                  
                </div>
                <div class="panel-footer">
                    <?php echo form_open(BASE_URL . '/plugin/shop/paymentNow'); ?>
                    <br><br>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h4><?php echo $this->Csz_model->getLabelLang('login_heading')?>:</h4>
                            <?php if(!$this->session->userdata('user_admin_id')){ ?>
                                <a role="button" class="btn btn-primary" href="<?php echo BASE_URL . '/member/login?url_return='.BASE_URL.'/plugin/shop/placeOrder'?>"><i class="glyphicon glyphicon-user"></i> <?php echo $this->Csz_model->getLabelLang('login_signin')?></a>
                                <br><br>
                                <h4><?php echo $this->Csz_model->getLabelLang('shop_contact_detail_txt')?>:</h4>
                                <div class="control-group">	
                                    <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                                    <label class="control-label" for="email"><?php echo $this->Csz_model->getLabelLang('email_address'); ?> <i style="color:red;">*</i></label>
                                    <?php
                                    $data = array(
                                        'name' => 'email',
                                        'id' => 'email',
                                        'type' => 'email',
                                        'required' => 'required',
                                        'autofocus' => 'true',
                                        'class' => 'form-control',
                                        'value' => set_value('email', '', FALSE)
                                    );
                                    echo form_input($data);
                                    ?>
                                </div> <!-- /control-group -->
                                <div class="control-group">	
                                    <?php echo form_error('name', '<div class="error">', '</div>'); ?>
                                    <label class="control-label" for="name"><?php echo $this->Csz_model->getLabelLang('first_name').' - '.$this->Csz_model->getLabelLang('last_name'); ?> <i style="color:red;">*</i></label>
                                    <?php
                                    $data = array(
                                        'name' => 'name',
                                        'id' => 'name',
                                        'required' => 'required',
                                        'autofocus' => 'true',
                                        'class' => 'form-control',
                                        'value' => set_value('name', '', FALSE)
                                    );
                                    echo form_input($data);
                                    ?>
                                </div> <!-- /control-group -->
                                <div class="control-group">	
                                    <?php echo form_error('phone', '<div class="error">', '</div>'); ?>
                                    <label class="control-label" for="phone"><?php echo $this->Csz_model->getLabelLang('phone'); ?> <i style="color:red;">*</i></label>
                                    <?php
                                    $data = array(
                                        'name' => 'phone',
                                        'id' => 'phone',
                                        'required' => 'required',
                                        'autofocus' => 'true',
                                        'class' => 'form-control',
                                        'value' => set_value('phone', '', FALSE)
                                    );
                                    echo form_input($data);
                                    ?>
                                </div> <!-- /control-group -->
                                <div class="control-group">
                                    <label class="control-label" for="address"><?php echo $this->Csz_model->getLabelLang('address'); ?> <i style="color:red;">*</i></label>
                                    <div class="controls">
                                        <textarea name="address" id="address" class="form-control" required="required" autofocus="true" rows="4"></textarea>
                                    </div>
                                </div> <!-- /control-group -->
                            <?php }else{ ?>
                                <div class="alert alert-success" role="alert"><?php echo $this->Csz_model->getLabelLang('shop_your_email_login').' <b>['.$user->email.']</b>'; ?></div>
                                <h4><?php echo $this->Csz_model->getLabelLang('shop_contact_detail_txt')?>:</h4>
                                <div class="control-group">	
                                    <?php echo form_error('email', '<div class="error">', '</div>'); ?>
                                    <label class="control-label" for="email"><?php echo $this->Csz_model->getLabelLang('email_address'); ?> <i style="color:red;">*</i></label>
                                    <?php
                                    $data = array(
                                        'name' => 'email',
                                        'id' => 'email',
                                        'type' => 'email',
                                        'required' => 'required',
                                        'autofocus' => 'true',
                                        'class' => 'form-control',
                                        'value' => set_value('email', $user->email, FALSE)
                                    );
                                    echo form_input($data);
                                    ?>
                                </div> <!-- /control-group -->
                                <div class="control-group">	
                                    <?php echo form_error('name', '<div class="error">', '</div>'); ?>
                                    <label class="control-label" for="name"><?php echo $this->Csz_model->getLabelLang('first_name').' - '.$this->Csz_model->getLabelLang('last_name'); ?> <i style="color:red;">*</i></label>
                                    <?php
                                    if(!$user->first_name && !$user->last_name){
                                        $show_name = $user->name;
                                    }else{
                                        $show_name = $user->first_name.' '.$user->last_name;
                                    }
                                    $data = array(
                                        'name' => 'name',
                                        'id' => 'name',
                                        'required' => 'required',
                                        'autofocus' => 'true',
                                        'class' => 'form-control',
                                        'value' => set_value('name', $show_name, FALSE)
                                    );
                                    echo form_input($data);
                                    ?>
                                </div> <!-- /control-group -->
                                <div class="control-group">	
                                    <?php echo form_error('phone', '<div class="error">', '</div>'); ?>
                                    <label class="control-label" for="phone"><?php echo $this->Csz_model->getLabelLang('phone'); ?> <i style="color:red;">*</i></label>
                                    <?php
                                    $data = array(
                                        'name' => 'phone',
                                        'id' => 'phone',
                                        'required' => 'required',
                                        'autofocus' => 'true',
                                        'class' => 'form-control',
                                        'value' => set_value('phone', $user->phone, FALSE)
                                    );
                                    echo form_input($data);
                                    ?>
                                </div> <!-- /control-group -->
                                <div class="control-group">
                                    <label class="control-label" for="address"><?php echo $this->Csz_model->getLabelLang('address'); ?> <i style="color:red;">*</i></label>
                                    <div class="controls">
                                        <textarea name="address" id="address" class="form-control" required="required" autofocus="true" rows="4"><?php echo $user->address ?></textarea>
                                    </div>
                                </div> <!-- /control-group -->
                            <?php } ?>
                            <div class="control-group">										
                                <label class="control-label" for="payment_methods"><?php echo $this->Csz_model->getLabelLang('shop_payment_methods'); ?></label>
                                <?php
                                    $att = 'id="payment_methods" class="form-control" ';
                                    $data = array();
                                    if($shop_config->paypal_active){
                                        $data['paypal'] = 'Paypal';
                                    }
                                    if($shop_config->paysbuy_active){
                                        $data['paysbuy'] = 'Paysbuy';
                                    }
                                    $data['banktransfer'] = $this->Csz_model->getLabelLang('shop_bank_transfer');
                                    echo form_dropdown('payment_methods', $data, '', $att);
                                ?>	
                            </div> <!-- /control-group -->
                        </div>
                    </div>
                    <br><br>
                    <div class="form-actions">
                        <?php
                        $data = array(
                            'name' => 'submit',
                            'id' => 'submit',
                            'class' => 'btn btn-lg btn-primary',
                            'value' => $this->Csz_model->getLabelLang('shop_payment_btn'),
                        );
                        echo form_submit($data);
                        ?> 
                    </div> <!-- /form-actions -->
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>