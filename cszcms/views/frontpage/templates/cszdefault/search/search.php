<div class="jumbotron">
    <div class="container">
        <br><br>
        <script>
          (function() {
            var cx = '<?php echo $config->gsearch_cxid ?>';
            var gcse = document.createElement('script');
            gcse.type = 'text/javascript';
            gcse.async = true;
            gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(gcse, s);
          })();
        </script>
        <gcse:searchbox></gcse:searchbox>
    </div>
</div>
<div class="container">
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <gcse:searchresults></gcse:searchresults>
        </div>
    </div>
</div>