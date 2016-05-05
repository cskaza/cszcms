<?php
if ($page_rs !== FALSE) {
    $frm_name = $this->Csz_model->frmNameInHtml($page_rs->content);
    if($frm_name === FALSE){
        echo $page_rs->content;
    }else{       
        echo $this->Csz_model->addFrmToHtml($page_rs->content, $frm_name, $page, $this->uri->segment(2));
    }
    
} else {
    ?>
    <div class="jumbotron">
        <div class="container">
            <h1>Sorry, Page not Found!</h1>
            <p>Sorry! Page not Found. ('<?= $page ?>' page) <br>Please back to home page.<p>
                <a class="btn btn-primary btn-lg" href="<?=BASE_URL?>" role="button">back to home &raquo;</a>
        </div>
    </div>
<? } ?>