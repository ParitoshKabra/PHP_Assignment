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

    $sql = $conn->prepare("INSERT INTO paritosh_chat(message, to1, from1, timestamp) VALUES(?,?,?,?)");
    $sql->bind_param('ssss', $message, $r_username, $username, $time);
    $sql->execute();
    $result = $sql->get_result();
}
$sql1 = $conn->prepare("SELECT * FROM paritosh_chat WHERE from1=? AND to1=? UNION SELECT * FROM paritosh_chat WHERE from1=? AND to1=? ORDER BY timestamp");
$sql1->bind_param('ssss', $username, $r_username, $r_username, $username);
$sql1->execute();
$result1 = $sql1->get_result();
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
