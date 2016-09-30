<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <!-- Start Shop Admin Menu -->
        <?php echo $this->Shop_model->AdminMenu() ?>
        <!-- End Shop Admin Menu -->
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-plane"></span></i> <?php echo $this->lang->line('shop_shipping_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('shop_shipping_header') ?></div>
        <form action="<?php echo current_url(); ?>" method="get">
            <div class="control-group">
                <label class="control-label" for="search"><?php echo $this->lang->line('search'); ?>: <input type="text" name="search" id="search" class="form-control-static" value="<?php echo $this->input->get('search');?>"></label> &nbsp;&nbsp;&nbsp;               
                <input type="submit" name="submit" id="submit" class="btn btn-default" value="<?php echo $this->lang->line('search'); ?>">
            </div>
        </form>
        <br><br>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="45%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('shop_order_detail'); ?></th>
                        <th width="15%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('shop_shipping_name'); ?></th>
                        <th width="10%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('shop_shipping_id'); ?></th>
                        <th width="20%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('shop_shipping_note'); ?></th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($shipping === FALSE) { ?>
                        <tr>
                            <td colspan="6" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($shipping as $u) {
                            $payment = $this->Csz_model->getValue('order_detail', 'shop_payment', "inv_id = '".$u['inv_id']."' AND payment_status = 'Completed'", '', 1);
                            echo '<tr>';                                 
                            echo '<td style="vertical-align: middle;">' . $payment->order_detail . '</td>';
                            echo '<td class="text-center" style="vertical-align: middle;">' . $u['shipping_name'] . '</td>';
                            echo '<td class="text-center" style="vertical-align: middle;">' . $u['shipping_id'] . '</td>';
                            echo '<td class="text-center" style="vertical-align: middle;">';
                            echo ($u['note']) ? $u['note'] : '-';
                            echo '</td>';
                            echo '<td class="text-center" style="vertical-align: middle;"><a href="'.BASE_URL.'/admin/plugin/shop/shippingEdit/' . $u['shop_shipping_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp;&nbsp; <a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.BASE_URL.'/admin/plugin/shop/shippingDel/'.$u['shop_shipping_id'].'/'.$u['inv_id'].'"><i class="glyphicon glyphicon-remove"></i></a></td>';
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