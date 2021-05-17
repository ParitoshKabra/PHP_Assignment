<?php
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username'])) {
        $sql = "SELECT * FROM test1 WHERE username='$username'";
        $result = mysqli_query($conn, $sql);
        $total = mysqli_num_rows($result);
        if ($total) {
            echo "<b style='color:red'>User already exist!</b>";
        } else {
            echo "<b style='color:green'>OK</b>";
        }
    } else {
        print_r($_POST);
    }
}
