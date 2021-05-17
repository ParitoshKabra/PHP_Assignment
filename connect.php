<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "phpmyadmin";
$password = "password";
$datab = "mysql";
$conn = mysqli_connect($host, $user, $password, $datab);
