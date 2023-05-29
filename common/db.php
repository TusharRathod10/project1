<?php

session_start();

$path = explode("/", $_SERVER['PHP_SELF']);
$get_path = end($path);
if ($get_path != 'page-login.php' && $get_path != 'page-register.php') {
    if(empty($_SESSION['admin'])){
        header('location:page-login.php');
    }
}

$con=mysqli_connect('localhost','root','','panel') or die("Connection Failed");

?>