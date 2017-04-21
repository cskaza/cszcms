<?php
if ($page_rs !== FALSE) {
    $totSegments = $this->uri->total_segments();
    if(!empty($page_rs->custom_css) && $page_rs->custom_css != NULL){ ?>
        <style type="text/css"><?php echo $page_rs->custom_css; ?></style>
    <?php }
    echo $content = $this->Csz_model->getHtmlContent($page_rs->content, $this->uri->segment($totSegments));
} else {
    if(isset($is_linkstat) && isset($url)){ ?>
    <div class="jumbotron">
        <div class="container">
            <br><br>
            <center><h3>Please Wait... ,Redirect to <?php echo (isset($url)) ? $url : '' ?></h3></center>
        </div>
    </div>
    <?php
    }else{
    ?>
    <div class="jumbotron">
        <div class="container">
            <h1>Sorry, Page not Found!</h1>
            <p>Sorry! Page not Found. ('<?php echo  $page ?>' page) <br>Please back to home page.<p>
                <a class="btn btn-primary btn-lg" href="<?php echo BASE_URL?>" role="button">back to home &raquo;</a>
        </div>
    </div>
    <?php }   
    } ?>