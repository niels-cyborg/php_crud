<?php
session_start();
include('segments/adminHeader.php');
include('classes/product.php');


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$edit = new Product;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $edit->deleteProduct($_GET['post_id']);
}
?>