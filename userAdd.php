<?php
session_start();
include('segments/adminHeader.php');
include('classes/user.php');


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$adduser = new User;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adduser->UserAdd($_POST['username'], $_POST['password']);
}

include('segments/userAddForm.php');
?>