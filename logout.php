<?php
session_start();
include("connect.php");
setcookie("PHPSESSID", $_COOKIE["PHPSESSID"], time() - 3600, "/");
setcookie("remember", $_SESSION['key'], time() - 3600, "/");
session_destroy();
echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center'>You have been logged out successfully</span><br><br>";
echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center'>Redirecting to Sign-In page ...</span><br><br>";

header('Refresh: 1; URL=index.php');
?>
<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icons.png" type="image/x-icon">
    <title>Logout</title>
</head>

<body>

</body>

</html> -->