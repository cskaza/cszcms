<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i><span class="glyphicon glyphicon-stats"></span></i> <?php echo $this->lang->line('banner_header') ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="h2 sub-header"><a role="button" href="<?php echo ($this->uri->segment(5))?$this->csz_referrer->getIndex('view'):$this->csz_referrer->getIndex()?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo  $this->lang->line('btn_back') ?></a></div>
        <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-primary">
                <div class="widget-user-image">
                    <?php ($banner->img_path && $banner->img_path !== NULL) ? $img = base_url() . 'photo/banner/' . $banner->img_path : $img = base_url() . 'photo/no_image.png'; ?>
                    <img class="img-thumbnail" src="<?php echo $img ?>" alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username"><?php echo $banner->name; ?> <?php if($this->uri->segment(5)){ echo '('.$this->uri->segment(5).')'; } ?></h3>
                <h5 class="widget-user-desc"><?php echo $this->lang->line('id_col_table'); ?> <?php echo $this->uri->segment(4); ?> | <?php echo $this->lang->line('banner_count').': '.$click_allcount?></h5>
            </div>
            <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                    <?php if($this->uri->segment(5)){ 
                        if ($bannerstat !== FALSE) {
                            $bannerdate_arr = array();
                            foreach ($bannerstat as $u) {
                                if(!in_array($u['bannerdate'], $bannerdate_arr)){
                                    $bannerdate_arr[] = $u['bannerdate'];
                                    $search_arr_d = "banner_mgt_id = '".$this->uri->segment(4)."' AND timestamp_create LIKE '".$u['bannerdate']."%'";
                                    $count_d = $this->Csz_model->countData('banner_statistic', $search_arr_d); ?>
                                    <li><a><?php echo $u['bannerdateF'] ?> <span class="pull-right badge bg-aqua-gradient"><?php echo $count_d ?></span></a></li>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php }else{ ?>
                        <?php if ($year !== FALSE) { ?>
                            <?php foreach ($year as $u) {
                                $bannermonth_arr = array();
                                $search_arr_y = "banner_mgt_id = '".$this->uri->segment(4)."' AND YEAR(timestamp_create) = '".$u['banner_year']."'"; 
                                $month = $this->Csz_model->getValueArray("MONTHNAME(timestamp_create) AS banner_month_name, MONTH(timestamp_create) AS banner_month", 'banner_statistic', $search_arr_y, '', 0, 'banner_month', 'DESC'); /* Can't group with sql only_full_group_by sql mode */
                                if ($month !== FALSE) { 
                                    foreach ($month as $m) {
                                        if(!in_array($m['banner_month'], $bannermonth_arr)){
                                            $bannermonth_arr[] = $m['banner_month'];
                                            $search_arr_m = "banner_mgt_id = '".$this->uri->segment(4)."' AND YEAR(timestamp_create) = '".$u['banner_year']."' AND MONTH(timestamp_create) = '".$m['banner_month']."'";
                                            $count_m = $this->Csz_model->countData('banner_statistic', $search_arr_m); ?>
                                            <li><a href="<?php echo $this->Csz_model->base_link().'/admin/banner/view/' . $this->uri->segment(4) . '/' . $u['banner_year'] . '-' . str_pad($m['banner_month'], 2, '0', STR_PAD_LEFT) ; ?>"><?php echo $u['banner_year'].' '.$m['banner_month_name'] ?> <span class="pull-right badge bg-red"><?php echo $count_m ?></span></a></li>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <!-- /.widget-user -->
    </div>
</div>
