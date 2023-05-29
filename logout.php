<?php 

include("common/db.php");

session_destroy();

header("location:page-login.php");

?>