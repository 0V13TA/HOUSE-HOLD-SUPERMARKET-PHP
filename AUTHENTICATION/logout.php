<?php
session_start();
print_r($_SESSION);
$_SESSION["isLoggedIn"] = 'false';
$_SESSION["role"] = null;
$_SESSION["userId"] = null;
// print_r($_SESSION);
header("Location: ../index.php");
