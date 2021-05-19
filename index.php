<?php
include("connect.php");
session_start();
$setusernameDefault = "";
if (!empty($_COOKIE['remember'])) {
    echo 'hi';
    if (!empty($_SESSION['key'])) {
        echo 'hi';
        echo $_SESSION['key'];
        if ($_COOKIE['remember'] == $_SESSION['key']) {
            header('location: users.php');
        } else {
            session_unset();
            session_destroy();
            setcookie('PHPSESSID', $_COOKIE['PHPSESSID'], time() - 3600, "/");
            header('location: index.php');
        }
    } else {
        $id =  $_COOKIE['id'];
        echo 'hi';
        $sql1 = "SELECT * FROM usersPro WHERE id=$id";
        $result1 = mysqli_query($conn, $sql1);
        if (($result1)) {
            while ($row = mysqli_fetch_assoc($result1)) {
                $setusernameDefault = $row['username'];
            }
        }
    }
    // } ---> my cookies were not getting disabled  so include this if it works in your browser.
}
$err = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["passwd"];
    $sql = "SELECT * FROM usersPro WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    // print_r($result);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                echo "entered";
                $_SESSION["user"] = $username;
                $_SESSION["loggedin"] = true;

                header("location: users.php");
            } else {
                session_unset();
                session_destroy();
                $err = true;
            }
        }
    } else {
        $err = true;
    }
    if ($result) {
        $_SESSION['key'] = 'pkadminsys&' . $username . '@007registered';
        $_SESSION['user'] = $username;
        $sess = $_SESSION['key'];
        $_SESSION['loggedin'] = true;
        if (!empty($_POST['remember'])) {
            setcookie('remember', $sess, time() + 86400, '/');
        }
    } else {
        session_destroy();
    }
}
echo $setusernameDefault;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/icons.png" type="image/x-icon">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            width: 100%;
            flex-direction: column;
        }

        .container {
            display: flex;
            flex-direction: column;
            width: 500px;

        }

        .container>h3 {
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input {
            max-width: inherit;
            padding: 10px;
            color: navy;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        #submit-btn {
            display: block;
            width: 100%;
            background-color: black;
            padding: 10px;
            color: white;
            cursor: pointer;
        }

        #submit-btn:hover,
        a:hover {
            opacity: 0.9;
        }

        #error {
            font-size: 18px;
            color: red;
            background-color: rgb(255, 207, 214);
            border: 2px solid red;
            font-weight: bold;
            list-style: disc;
            padding: 15px;
            margin: 5px 0;
            min-width: inherit;
            display: flex;
            justify-content: space-between;
        }

        #first {
            color: rgb(79, 79, 255);
            margin-top: 10px;
            font-size: 20px;
            font-family: sans-serif;
        }

        .cancel {
            background-color: transparent;
            outline: none;
            border: none;
            font-weight: bold;
            font-size: 18px;
            margin-left: 20px;
        }

        label {
            font-size: 20px;
            color: navy;
            margin: 5px 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <?php
        if ($err) {
            echo "<div id='error'><span>Invalid Credentials!</span><button class='cancel'onclick='func()'>&times;</button></div>";
        }
        ?>
        <h1>Sign-In to your account</h1>
        <form action="index.php" method="post">
            <?php if ($setusernameDefault !== "") {
                echo "<input type='text' name='username' id='iname' value='$setusernameDefault'>";
            } else {
                echo "<input type='text' name='username' id='iname' placeholder='Your Username'>";
            } ?>


            <input type="password" name="passwd" id="ipasswd" placeholder="Password">
            <div class="element1">
                <label for="remember" id="labelSpecial">Remember Me</label>
                <input type="checkbox" name="remember">
            </div>
            <button type="submit" id="submit-btn">Sign In</button>
        </form>
    </div>
    <div id="first">
        First time? <a id="SignUp" href="sign-up.php">Register here</a>
    </div>
</body>
<script>
    function func() {
        document.getElementById('error').style.display = 'none';
    }
</script>

</html>