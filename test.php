<?php
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $username = $data->username;
    if (isset($username)) {
        $sql = "SELECT * FROM usersPro WHERE username=\"" . $username . "\"";
        $result = mysqli_query($conn, $sql);
        $total = mysqli_num_rows($result);
        if ($total) {
            echo "Username already exist!";
        } else {
            echo "OK";
        }
    }
}
