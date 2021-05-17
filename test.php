<?php
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $username = $data->username;
    if (isset($username)) {
        $sql = "SELECT * FROM usersPro WHERE username='$username'";
        $result = mysqli_query($conn, $sql);
        $total = mysqli_num_rows($result);
        if ($total) {
            echo "<b style='color:red; font-size:20px; margin-left:10px'>Username already exist!</b>";
        } else {
            echo "<b style='color:green; font-size:20px;margin-left:10px'>OK</b>";
        }
    }
}
