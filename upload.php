<?php
include('connect.php');
session_start();
$file = true;
$target_file = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {
            $target_dir = "uploads/";
            $target_name = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadConfirm = 1;
            $ext = strtolower(pathinfo($target_name, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                echo "<script>alert('File is - '" . $check['mime'] . ");window.location.href='profile.php';</script>";
            } else {
                echo "<script>alert('Uploading multiple images is not allowed!');window.location.href='profile.php';</script>";
                $uploadConfirm = 0;
            }

            if ($_FILES['fileToUpload']['size'] > 1000000) {
                echo "<script>alert('File too large! Compress and upload.');window.location.href='profile.php';</script>";

                $uploadConfirm = 0;
            }
            if ($ext !== 'jpg' && $ext !== 'bmp' && $ext !== 'png'  && $ext !== 'jpeg') {
                echo "<script>alert('File is not jpg/png/bmp/jpeg!<br><br>');window.location.href='profile.php';</script>";

                $uploadConfirm = 0;
            }
            // echo $uploadConfirm;
            if ($uploadConfirm) {
                $target_file = $target_dir . $_SESSION['user'] . "." . $ext;
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center'>You have uploaded in successfully</span><br><br>";


                    $file = false;


                    header("Refresh:2; URL=users.php");
                }
            } else {
                echo "Sorry! File is not uploaded..";
            }
        }
        $name = $_POST['name'];
        $desc = $_POST['comment'];
        $date = $_POST['date'];
        $work = $_POST['work'];
        $path = "";
        if ($target_file !== "") {
            $path = pathinfo($target_file, PATHINFO_DIRNAME) . "/" . pathinfo($target_file, PATHINFO_BASENAME);
        } else {
            $target_file = "images/default.png";
            $path = $target_file;
        }
        $profiles = array($name, $desc, $date, $work);
        $_SESSION['utility'] = $profiles;
        $id = $_SESSION['check'];
        // echo "on line 61 <br>";
        if (empty($_SESSION['profile'])) {
            $sql = $conn->prepare("INSERT into paritosh_usersProfile VALUES(?,?,?,?,?,?)");
            $sql->bind_param("ssssis", $name, $work, $desc, $date, $id, $path);

            $sql->execute();
            $result = $sql->affected_rows;
            if ($result) {
                $_SESSION['profile'] = true;
                if ($file) {
                    echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center'>You have been logged in successfully. Server will render a default profile pic :)</span><br><br>";

                    echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center;transition:opacity 1s;'>Redirecting to main page...</span>";

                    header("Refresh:2; URL=users.php");
                }
            }
        } else {
            $sql1 = $conn->prepare("UPDATE paritosh_usersProfile SET name=?,work=?,description=?, dateOb=?,ProfilePic=? WHERE id = ?");
            $sql1->bind_param("sssssi", $name, $work, $desc, $date, $path, $id);
            $sql1->execute();
            $result = $sql1->affected_rows;
            if ($result) {
                echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center'>Profile updated!</span><br><br>";

                echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center;transition:opacity 1s;'>Redirecting to main page...</span>";

                header("Refresh:2; URL=users.php");
            }
        }
    }
}
