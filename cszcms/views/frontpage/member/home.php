<div class="container">
    <div class="row">
        <div class="col-md-12"><br><br><br><br></div>
    </div>
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li class="active">
                    <i><span class="glyphicon glyphicon-dashboard"></span> Member Dashboard</i>
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="h2 sub-header">Welcome to Member dashboard!</div>
            <br><br>
            <?php if($this->session->userdata('admin_type') != 'member'){ ?>
            <p><a href="<?php echo BASE_URL;?>/admin"><span class="glyphicon glyphicon-briefcase"></span> Backend System</a></p>
            <?php } ?>
            <p><a href="<?php echo BASE_URL;?>/member/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></p>
        </div>
    </div>
    <!-- /.row -->
</div>