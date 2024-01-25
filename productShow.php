<?php
session_start();

include('classes/product.php');
include('segments/adminHeader.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


$showproduct = new Product();
$showproduct->fetchProduct();

?>