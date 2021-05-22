<?php
include('connect.php');
$sql = $conn->prepare("SELECT DISTINCT username,email FROM paritosh_user JOIN paritosh_usersProfile ON paritosh_user.id=paritosh_usersProfile.id");
$sql->execute();
$result = $sql->get_result();
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
