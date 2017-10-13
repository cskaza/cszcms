<div class="container">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="h2 sub-header"><?php echo $this->Csz_model->getLabelLang('member_dashboard_text') ?></div>
            <hr>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-3">
            <?php echo $this->Headfoot_html->memberleftMenu(); ?>
        </div>
        <div class="col-md-9">
            <div class="panel panel-primary">
                <div class="panel-heading"><b><i class="glyphicon glyphicon-user"></i> <?php echo $this->Csz_model->getLabelLang('users_list_txt') ?></b></div>
                <div class="panel-body">
                    <div class="box box-body table-responsive no-padding">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th width="10%" class="text-center" style="vertical-align:middle;">#ID</th>
                                    <th width="20%" class="text-center" style="vertical-align:middle;"><?php echo $this->Csz_model->getLabelLang('picture'); ?></th>
                                    <th width="50%" class="text-center" style="vertical-align:middle;"><?php echo $this->Csz_model->getLabelLang('display_name'); ?></th>
                                    <th width="20%" class="text-center" style="vertical-align:middle;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($users === FALSE) { ?>
                                    <tr>
                                        <td colspan="4" class="text-center"><span class="h6 error"><?php echo $this->Csz_model->getLabelLang('error_txt') ?></span></td>
                                    </tr>                           
                                <?php } else { ?>
                                    <?php
                                    foreach ($users as $u) {
                                        ($u['picture']) ? $user_img = base_url() . 'photo/profile/' . $u['picture'] : $user_img = base_url() . 'photo/no_image.png';
                                        echo '<tr>';
                                        echo '<td class="text-center" style="vertical-align:middle;">'.$u['user_admin_id'].'</td>';
                                        echo '<td class="text-center h3" style="vertical-align:middle;"><img src="'.$user_img.'" class="img-responsive img-thumbnail" alt="Profile Photo" width="80"></td>';
                                        echo '<td class="text-center" style="vertical-align:middle;">'.$u['name'].'</td>';                                        
                                        echo '<td class="text-center" style="vertical-align:middle;"><a href="'.$this->Csz_model->base_link().'/member/viewuser/' . $u['user_admin_id'] . '" class="btn btn-info btn-sm" role="button"><i class="glyphicon glyphicon-eye-open"></i></a> &nbsp;&nbsp; <a href="'.$this->Csz_model->base_link().'/member/newpm/' . $u['user_admin_id'] . '" class="btn btn-primary btn-sm" role="button"><i class="glyphicon glyphicon-envelope"></i></a></td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <?php echo $this->pagination->create_links(); ?> <b><?php echo $this->Csz_model->getLabelLang('total_txt') . ' ' . $total_row . ' ' . $this->Csz_model->getLabelLang('records_txt'); ?></b>
                    <!-- /widget-content -->
                </div>
            </div>
        </div>
    </div>
</div>