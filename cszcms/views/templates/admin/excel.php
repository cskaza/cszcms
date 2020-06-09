<?php
header("Content-Type: application/vnd.ms-excel");
if(!$filename){
    $filename = time();
}
header('Content-Disposition: attachment; filename="'.$filename.'".xls');
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<HTML>
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
</HEAD>
<BODY>
<?php echo $content; ?>
</BODY>
</HTML>