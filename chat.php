<?php
include('connect.php');
session_start();
$data = json_decode(file_get_contents("php://input"));
$value = json_decode(json_encode($data), true);
$r_username = $value["to"];
$message = "";
$time = "";

$username = $_SESSION['user'];

if (!empty($value['chat_message'])) {
    $message = mysqli_real_escape_string($conn, $value['chat_message']);
    $time = $value['time'];

    $sql = "INSERT INTO chat(message, to1, from1, timestamp) VALUES('$message', '$r_username', '$username', '$time')";
    $result = mysqli_query($conn, $sql);
}
$sql1 = "SELECT * FROM chat WHERE from1='$username' AND to1='$r_username' UNION SELECT * FROM chat WHERE from1='$r_username' AND to1='$username' ORDER BY timestamp";
$result1 = mysqli_query($conn, $sql1);
if ($result1->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result1)) {
        if ($row['from1'] == $username) {
            echo "<li class='sent-messages'>" . $row['message'] . "</li>";
        } else {
            echo "<li class='received-messages'>" . $row['message'] . "</li>";
        }
    }
} else {
    echo "You can chat here :)";
}
