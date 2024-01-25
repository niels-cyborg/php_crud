<?php
session_start();

include('segments/adminHeader.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
} else {
    echo "<h1 style='margin-top:3vh; width:100vw; display:flex; justify-content:center;'>Welkom " . $_SESSION["username"] . "!</h1>";
}

?>