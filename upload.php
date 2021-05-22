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
                echo "<script>alert('File is - ')" . $check['mime'] . "</script>";
            } else {
                echo "<script>alert('Uploading multiple images is not allowed!')</script>";
                $uploadConfirm = 0;
            }

            if ($_FILES['fileToUpload']['size'] > 1000000) {
                echo "<script>alert('File too large! Compress and upload.')</script>";

                $uploadConfirm = 0;
            }
            if ($ext !== 'jpg' && $ext !== 'bmp' && $ext !== 'png'  && $ext !== 'jpeg') {
                echo "<script>alert('File is not jpg/png/bmp/jpeg!<br><br>')</script>";
                $uploadConfirm = 0;
            }
            if ($uploadConfirm) {
                $target_file = $target_dir . $_SESSION['user'] . "." . $ext;
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center'>You have been logged in successfully</span><br><br>";
                    echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center;transition:opacity 1s;'>Redirecting to main page...</span>";
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
        if (empty($_SESSION['profile'])) {
            $sql = "INSERT into usersProfile VALUES('$name','$work','$desc','$date','$id','$path')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $_SESSION['profile'] = true;
                if ($file) {
                    echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center'>You have been logged in successfully. Server will render a default profile pic :)</span><br><br>";
                    echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center;transition:opacity 1s;'>Redirecting to main page...</span>";
                    header("Refresh:2; URL=users.php");
                }
            }
        } else {
            $sql1 = "UPDATE usersProfile SET name='$name',work='$work',description='$desc', dateOb='$date',ProfilePic='$path' WHERE id = $id";
            $result = mysqli_query($conn, $sql1);
            if ($result) {
                echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center'>Profile updated!</span><br><br>";
                echo "<span style='color:green; font-size: 20px; font-weight:bold; text-align:center;transition:opacity 1s;'>Redirecting to main page...</span>";
                header("Refresh:2; URL=users.php");
            }
        }
    }
}
