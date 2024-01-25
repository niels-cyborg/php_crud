<?php
include_once("segments/header.php");
include_once("classes/showMain.php");

$posts = new showMain();
if ($_SERVER['REQUEST_METHOD'] == "GET" and isset($_GET['product_id'])) {
    
}else{
    $posts->fetchProduct();
}


if ($_SERVER['REQUEST_METHOD'] == "GET" and isset($_GET['product_id'])) {
    $posts->fill($_GET['product_id']);
    $posts->fetchRevieuws($_GET['product_id']);
}
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit'])) {
    $posts->addReview($_POST['name'], $_POST['message'], $_POST['id']);
}


?>