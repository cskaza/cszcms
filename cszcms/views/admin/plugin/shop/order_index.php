<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <!-- Start Shop Admin Menu -->
        <?php echo $this->Shop_model->AdminMenu() ?>
        <!-- End Shop Admin Menu -->
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-usd"></span></i> <?php echo $this->lang->line('shop_order') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('shop_order') ?></div>
        <form action="<?php echo current_url(); ?>" method="get">
            <div class="control-group">
                <label class="control-label" for="search"><?php echo $this->lang->line('search'); ?>: <input type="text" name="search" id="search" class="form-control-static" value="<?php echo $this->input->get('search');?>"></label> &nbsp;&nbsp;&nbsp;                 
                <label class="control-label" for="payment_status"><?php echo $this->lang->line('shop_payment_status') ?>: <select name="payment_status" id="payment_status">
                    <option value=""><?php echo  $this->lang->line('option_all') ?></option>
                    <option value="Completed"<?php echo ($this->input->get('payment_status') == 'Completed')?' selected="selected"':''?>><?php echo $this->lang->line('shop_payment_Completed') ?></option>
                    <option value="Pending"<?php echo ($this->input->get('payment_status') == 'Pending')?' selected="selected"':''?>><?php echo $this->lang->line('shop_payment_Pending') ?></option>
                    <option value="Refunded"<?php echo ($this->input->get('payment_status') == 'Refunded')?' selected="selected"':''?>><?php echo $this->lang->line('shop_payment_Refunded') ?></option>
                    <option value="Canceled"<?php echo ($this->input->get('payment_status') == 'Canceled')?' selected="selected"':''?>><?php echo $this->lang->line('shop_payment_Canceled') ?></option>
                </select></label> &nbsp;&nbsp;&nbsp; 
                <input type="submit" name="submit" id="submit" class="btn btn-default" value="<?php echo $this->lang->line('search'); ?>">
            </div>
        </form>
        <br><br>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="5%"></th>
                        <th width="65%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('shop_order_detail'); ?></th>
                        <th width="15%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('shop_payment_status'); ?></th>                        
                        <th width="15%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($payment === FALSE) { ?>
                        <tr>
                            <td colspan="7" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($payment as $u) {
                            $payment_stat_color = '';
                            $inactive = '';
                            if($u['payment_status'] == 'Canceled' || $u['payment_status'] == 'Refunded'){
                                $inactive = ' style="color:red;text-decoration:line-through;"';
                                $payment_stat_color = ' class="error"';
                            }else{
                                if($u['payment_status'] == 'Completed'){
                                    $payment_stat_color = ' class="success"';
                                }
                            }
                            
                            echo '<tr>';     
                            echo '<td class="text-center" style="vertical-align: middle;"><a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.BASE_URL.'/admin/plugin/shop/orderDel/'.$u['shop_payment_id'].'"><i class="glyphicon glyphicon-remove"></i></a></td>';
                            echo '<td'.$inactive.' style="vertical-align: middle;">' . $u['order_detail'] . '</td>';
                            echo '<td class="text-center" style="vertical-align: middle;">';
                            echo '<span'.$payment_stat_color.'><b>' . $this->lang->line('shop_payment_'.$u['payment_status']) . '</b></span>';
                            if($u['payment_status'] == 'Completed'){
                                echo '<br><br><a role="button" class="btn btn-primary btn-sm" role="button" href="'.BASE_URL.'/admin/plugin/shop/shippingCreate/'.$u['inv_id'].'"><i class="glyphicon glyphicon-plane"></i> '.$this->lang->line('shop_shipping_create').'</a>';
                            }
                            echo '</td>';
                            echo '<td class="text-center" style="vertical-align: middle;">';
                            if($u['payment_status'] == 'Pending'){
                                echo '<a role="button" class="btn btn-success btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.BASE_URL.'/admin/plugin/shop/orderConfirmed/'.$u['shop_payment_id'].'"><i class="glyphicon glyphicon-ok"></i> '.$this->lang->line('shop_payment_Completed').'</a><br><br>';
                                echo '<a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.BASE_URL.'/admin/plugin/shop/orderCanceled/'.$u['shop_payment_id'].'"><i class="glyphicon glyphicon-ban-circle"></i> '.$this->lang->line('shop_payment_Canceled').'</a><br><br>';
                            }else if($u['payment_status'] == 'Completed'){
                                echo '<a role="button" class="btn btn-warning btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.BASE_URL.'/admin/plugin/shop/orderPending/'.$u['shop_payment_id'].'"><i class="glyphicon glyphicon-piggy-bank"></i> '.$this->lang->line('shop_payment_Pending').'</a><br><br>';
                                echo '<a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.BASE_URL.'/admin/plugin/shop/orderRefunded/'.$u['shop_payment_id'].'"><i class="glyphicon glyphicon-repeat"></i> '.$this->lang->line('shop_payment_Refunded').'</a><br><br>';
                            }else if($u['payment_status'] == ''){
                                echo '<a role="button" class="btn btn-success btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.BASE_URL.'/admin/plugin/shop/orderConfirmed/'.$u['shop_payment_id'].'"><i class="glyphicon glyphicon-ok"></i> '.$this->lang->line('shop_payment_Completed').'</a><br><br>';
                                echo '<a role="button" class="btn btn-warning btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.BASE_URL.'/admin/plugin/shop/orderPending/'.$u['shop_payment_id'].'"><i class="glyphicon glyphicon-piggy-bank"></i> '.$this->lang->line('shop_payment_Pending').'</a><br><br>';
                                echo '<a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.BASE_URL.'/admin/plugin/shop/orderCanceled/'.$u['shop_payment_id'].'"><i class="glyphicon glyphicon-ban-circle"></i> '.$this->lang->line('shop_payment_Canceled').'</a><br><br>';
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->pagination->create_links(); ?> <b><?php echo $this->lang->line('total').' '.$total_row.' '.$this->lang->line('records');?></b>
        <!-- /widget-content --> 
    </div>
</div>