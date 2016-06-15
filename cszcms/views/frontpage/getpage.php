<?php
if ($page_rs !== FALSE) {
    echo $content = $this->Csz_model->getHtmlContent($page_rs->content, $page, $this->uri->segment(2));
} else {
    ?>
    <div class="jumbotron">
        <div class="container">
            <h1>Sorry, Page not Found!</h1>
            <p>Sorry! Page not Found. ('<?php echo  $page ?>' page) <br>Please back to home page.<p>
                <a class="btn btn-primary btn-lg" href="<?php echo BASE_URL?>" role="button">back to home &raquo;</a>
        </div>
    </div>
<?php } ?>