<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <!-- Start Shop Admin Menu -->
        <?php echo $this->Shop_model->AdminMenu() ?>
        <!-- End Shop Admin Menu -->
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-edit"></span></i> <?php echo $this->lang->line('shop_products_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><?php echo  $this->lang->line('shop_products_header') ?>  <a role="button" href="<?php echo BASE_URL?>/admin/plugin/shop/productNew" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo  $this->lang->line('shop_products_addnew') ?></a></div>
        <form action="<?php echo current_url(); ?>" method="get">
            <div class="control-group">
                <label class="control-label" for="search"><?php echo $this->lang->line('search'); ?>: <input type="text" name="search" id="search" class="form-control-static" value="<?php echo $this->input->get('search');?>"></label> &nbsp;&nbsp;&nbsp; 
                <label class="control-label" for="category"><?php echo $this->lang->line('shop_category_header'); ?>:
                    <select name="category" id="category">
                        <option value=""><?php echo $this->lang->line('option_all'); ?></option>
                        <?php
                        if(!empty($category)){
                            foreach ($category as $c) { 
                                $cat_arr[$c['shop_category_id']] = $c['name']; ?>
                                <option value="<?php echo $c['shop_category_id'] ?>"<?php echo ($this->input->get('category') == $c['shop_category_id'])?' selected="selected"':''?>><?php echo $c['name'] ?></option>
                        <?php }
                        }
                        ?>
                    </select>	
                </label> &nbsp;&nbsp;&nbsp; 
                <label class="control-label" for="product_status"><?php echo  $this->lang->line('shop_products_status') ?>: <select name="product_status" id="product_status">
                        <option value=""><?php echo  $this->lang->line('option_all') ?></option>
                        <?php foreach ($product_status as $key => $value) { 
                            $stat_arr[$key] = $value; ?>
                            <option value="<?php echo $key;?>"<?php echo ($this->input->get('product_status') == $key)?' selected="selected"':''?>><?php echo $value;?></option>
                        <?php } ?>
                    </select></label> &nbsp;&nbsp;&nbsp; 
                <input type="submit" name="submit" id="submit" class="btn btn-default" value="<?php echo $this->lang->line('search'); ?>">
            </div>
        </form>
        <br><br>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="13%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('shop_products_photo'); ?></th>
                        <th width="10%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('shop_products_code'); ?></th>
                        <th width="10%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('shop_category_header'); ?></th>
                        <th width="35%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('shop_products_name'); ?></th>
                        <th width="10%" class="text-center" style="vertical-align:middle;">(<?php echo $this->lang->line('shop_products_fullprice').'-'.$this->lang->line('shop_products_discount').')='.$this->lang->line('shop_products_price'); ?><br>(<?php echo $currency;?>)</th>
                        <th width="10%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('shop_products_stock'); ?></th>
                        <th width="12%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($products === FALSE) { ?>
                        <tr>
                            <td colspan="7" class="text-center"><span class="h6 error"><?php echo  $this->lang->line('data_notfound') ?></span></td>
                        </tr>                           
                    <?php } else { ?>
                        <?php
                        foreach ($products as $u) {
                            if(!$u['active']){
                                $inactive = ' style="vertical-align: middle;color:red;text-decoration:line-through;"';
                            }else{
                                $inactive = '';
                            }
                            if($u['product_status']){
                                $pro_type = ' <em>('.$stat_arr[$u['product_status']].')</em>';
                            }else{
                                $pro_type = '';
                            }
                            echo '<tr>';
                            echo '<td class="text-center" style="vertical-align:middle;"><img src="'. $this->Shop_model->getFirstImgs($u['shop_product_id']) .'" width="100"></td>';
                            echo '<td'.$inactive.' class="text-center">' . $u['product_code'] . '</td>';
                            echo '<td'.$inactive.' class="text-center">' . $cat_arr[$u['shop_category_id']] . '</td>';
                            echo '<td'.$inactive.'>';
                            echo '<b>'.$u['product_name'].'</b>'.$pro_type.'<br>';
                            echo '<span style="color:red;"><small><em>'.$u['keyword'].'</em></small></span><br>';
                            echo $u['short_desc'];
                            echo '</td>';
                            echo '<td'.$inactive.' class="text-center">(' . number_format($u['price'],2) . '-' . number_format($u['discount'],2) . ')<br><b>' . number_format($u['price']-$u['discount'],2) . '</b></td>';
                            echo '<td'.$inactive.' class="text-center">' . number_format($u['stock']) . '</td>';
                            echo '<td class="text-center" style="vertical-align: middle;"><a href="'.BASE_URL.'/admin/plugin/shop/productEdit/' . $u['shop_product_id'] . '" class="btn btn-default btn-sm" role="button"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp;&nbsp; <a role="button" class="btn btn-danger btn-sm" role="button" onclick="return confirm(\''.$this->lang->line('delete_message').'\')" href="'.BASE_URL.'/admin/plugin/shop/productDel/'.$u['shop_product_id'].'"><i class="glyphicon glyphicon-remove"></i></a></td>';
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