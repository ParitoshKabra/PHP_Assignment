<?php
include('connect.php');
session_start();
$file = true;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {
            $target_dir = "uploads/";
            $target_name = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadConfirm = 1;
            $ext = strtolower(pathinfo($target_name, PATHINFO_EXTENSION));
            $target_file = $target_dir . $_SESSION['user'] . "." . $ext;
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                echo "<script>alert('File is - ')" . $check['mime'] . "</script>";
            } else {
                echo "<script>alert('Uploading multiple images is not allowed!')</script>";
                $uploadConfirm = 0;
            }
            if (file_exists($target_name)) {
                echo "<script>alert('Upload with a rename! File with the same name exists!')</script>";
                $uploadConfirm = 0;
            }
            if ($_FILES['fileToUpload']['size'] > 1000000) {
                echo "File too large! Compress and upload.";
                $uploadConfirm = 0;
            }
            if ($ext !== 'jpg' && $ext !== 'bmp' && $ext !== 'png'  && $ext !== 'jpeg') {
                echo "File is not jpg/png/bmp/jpeg!<br><br>";
                $uploadConfirm = 0;
            }
            if ($uploadConfirm) {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center'>You have been logged in successfully</span><br><br>";
                    echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center;transition:opacity 1s;'>Redirecting to main page...</span>";
                    $file = false;
                    $_SESSION['profile'] = true;

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
        $id = $_SESSION['check'];
        if (!isset($_SESSION['profile'])) {
            $sql = "INSERT into usersProfile VALUES('$name','$work','$desc','$date','$id')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                if ($file) {
                    $_SESSION['profile'] = true;
                    echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center'>You have been logged in successfully. Server will render a default profile pic :)</span><br><br>";
                    echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center;transition:opacity 1s;'>Redirecting to main page...</span>";
                    header("Refresh:2; URL=users.php");
                }
            }
        } else {
            $sql1 = "UPDATE usersProfile SET name='$name',work='$work',description='$desc', dateOb='$date' WHERE id = $id";
            $result = mysqli_query($conn, $sql1);
            if ($result) {
                echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center'>Profile updated!</span><br><br>";
                echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center;transition:opacity 1s;'>Redirecting to main page...</span>";
                header("Refresh:2; URL=users.php");
            }
        }
    }
}
