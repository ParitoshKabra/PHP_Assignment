<?php
// include("config.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("config.php");


$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWD, DB_DATABASE);

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
} else {
  $user = $_POST["username"];
  $passwd = $_POST["passwd"];
  $sql = "SELECT * FROM test1 WHERE username='$user' AND passwd='$passwd'";
  $result = mysqli_query($con, $sql);
  if (mysqli_num_rows($result) > 0) {
    echo "<h1 style='color:red'>Welcome " . $user . " to Sociophobia!!</h1>";
  } else {
    echo "Register to login...  :)";
  }
}
