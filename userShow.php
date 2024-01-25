<?php
session_start();

include('segments/adminHeader.php');
include('classes/User.php');


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$user = new User;
$user->fetchUsers();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $user->deleteUsers($_POST['user_id']);
    }
    



?>

