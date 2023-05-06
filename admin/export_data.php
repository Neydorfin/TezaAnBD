<?php 
    require "log.php";
?>
<?php
include_once("../php/config.php");
$filename = "user_log_export_".$user['user_fname']."_".$user['user_lname'];
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$filename.".xls");
require "data.php";