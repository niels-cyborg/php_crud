<?php

include_once("classes/user.php");
include_once("segments/header.php");
include_once("segments/form.php");


$login = new User;
$login->loginUser();

?>