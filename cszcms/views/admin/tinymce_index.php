<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$row = $this->Csz_admin_model->load_config();
/**
 * Main file for Template.
 * Don't change the file name
 */
?>
<?php echo doctype('html5') ?>
<html lang="<?php echo $row->admin_lang ?>">
    <head>
        <?php echo link_tag('templates/admin/favicon.ico', 'shortcut icon', 'image/ico'); ?>
        <title>TinyMCE Select File</title>

        <!-- Bootstrap Core CSS -->
        <?php echo $core_css ?>
        <?php echo link_tag($this->config->item('assets_url') . '/font-awesome/css/font-awesome.min.css'); ?>
        <?php echo link_tag($this->config->item('assets_url') . '/css/jquery-ui-themes-1.11.4/themes/smoothness/jquery-ui.min.css'); ?>

        <!-- Custom Fonts -->        
        <?php echo link_tag('https://code.cdn.mozilla.net/fonts/fira.css') ?>

        <!-- Ionicons -->
        <?php echo link_tag('https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css') ?>
        <!-- Theme style -->
        <?php echo link_tag('templates/admin/css/AdminLTE.min.css') ?>
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <?php echo link_tag('templates/admin/css/skins/_all-skins.min.css') ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li class="active">
                        <i><span class="glyphicon glyphicon-object-align-top"></span></i> <?php echo $this->lang->line('uploadfile_header') ?>
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="box box-body table-responsive no-padding">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="10%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('uploadfile_thumbnail') ?></th>
                                <th width="45%" style="vertical-align:middle;"><?php echo $this->lang->line('uploadfile_filename') ?></th>
                                <th width="25%" style="vertical-align:middle;"><?php echo $this->lang->line('remark_header') ?></th>
                                <th width="15%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('uploadfile_uploadtime') ?></th>
                                <th width="10%" class="text-center" style="vertical-align:middle;"><?php echo $this->lang->line('btn_add') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($showfile === FALSE) { ?>
                                <tr>
                                    <td colspan="5" class="text-center"><span class="h6 error"><?php echo $this->lang->line('uploadfile_filenotfound') ?></span></td>
                                </tr>                           
                            <?php } else { ?>
                                <?php foreach ($showfile as $file) { ?>
                                    <tr class="fileselect" data-src="<?php echo BASE_URL ?>/photo/upload/<?php echo $file["file_upload"] ?>">
                                        <td class="text-center" style="vertical-align:middle;">
                                            <?php
                                            $ext = strtolower(pathinfo($file["file_upload"], PATHINFO_EXTENSION));
                                            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                                                ?>
                                                <img src="<?php echo base_url() . 'photo/upload/' . $file["file_upload"] ?>" width="60">
                                            <?php } else { ?>
                                                <h4><i class="glyphicon glyphicon-file"></i> <?php echo strtoupper($ext) ?></h4>
                                            <?php } ?>
                                        </td>
                                        <td style="vertical-align:middle;">
                                            <span class="h5"><b><?php echo $file["file_upload"] ?></b></span>
                                        </td>
                                        <td style="vertical-align:middle;">
                                            <span class="h5"><b><?php echo $file["remark"] ?></b></span>
                                        </td>
                                        <td class="text-center" style="vertical-align:middle;">
                                            <span class="h5"><b><?php echo $file["timestamp_create"] ?></b></span>
                                        </td>
                                        <td class="text-center" style="vertical-align:middle;">
                                            <a id="btnselect" data-src="<?php echo BASE_URL ?>/photo/upload/<?php echo $file["file_upload"] ?>" class="btn btn-primary"><?php echo $this->lang->line('btn_add') ?></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /widget-content --> 
                <?php echo $this->pagination->create_links(); ?> <b><?php echo $this->lang->line('total').' '.$total_row.' '.$this->lang->line('records');?></b>
                <br><br>
            </div>
        </div>
        <!-- Bootstrap core JavaScript
                ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <?php echo $core_js ?>
        <script type="text/javascript">
        $(document).on("click","tr.fileselect,a#btnselect",function(){
          item_url = $(this).data("src");
          var args = top.tinymce.activeEditor.windowManager.getParams();
          win = (args.window);
          input = (args.input);
          win.document.getElementById(input).value = item_url;
          top.tinymce.activeEditor.windowManager.close();
        });
        </script>
    </body>
</html>