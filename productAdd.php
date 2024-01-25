<?php
session_start();
include('segments/adminHeader.php');
include('classes/Product.php');


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


$addproduct = new Product();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$addproduct->addPost($_POST['titel'], $_POST['beschrijving'], $_POST['inhoud'], $_SESSION['id']);
}


include('segments/productAddForm.php');
?>