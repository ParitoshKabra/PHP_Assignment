<?php
include('connect.php');
$sql = "SELECT DISTINCT username,email FROM usersPro JOIN usersProfile ON usersPro.id=usersProfile.id";
$result = mysqli_query($conn, $sql);
echo "{\"testdata\":[";
$check = 1;
$count = mysqli_num_rows($result);
while ($row = mysqli_fetch_assoc($result)) {
    echo "{";
    echo '"username":"' . $row["username"] . "\",";
    echo '"email":"', $row["email"] . "\"";
    if ($check != $count) {
        echo "},";
    } else {
        echo "}";
    }
    $check++;
}
echo "]}";
