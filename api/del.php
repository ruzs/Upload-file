<?php
include_once "./base.php";

$file=find("upload",$_GET['id']);

unlink("../upload/".$file['file_name']);

del("upload",$_GET['id']);
to("../upload.php");
?>