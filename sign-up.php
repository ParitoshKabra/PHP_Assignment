<?php
session_start();
include("connect.php");

$showAlert = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $passplain = $_POST["passwd"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $gender = $_POST["gender"];







    $password = password_hash($passplain, PASSWORD_DEFAULT);
    $sql = $conn->prepare("INSERT INTO paritosh_user(username, password , email, gender, phone) VALUES(?,?,?,?,?)");
    $sql->bind_param('sssss', $username, $password, $email, $gender, $phone);
    $sql->execute();
    $result = $sql->get_result();
    $sql2 = $conn->prepare("SELECT id FROM paritosh_user WHERE username=?");
    $sql2->bind_param('s', $username);
    $sql2->execute();
    $result2 = $sql2->get_result();
    echo "What's this!";
    $row = mysqli_fetch_assoc($result2);
    if (mysqli_num_rows($result2)) {

        $_SESSION['key'] = 'pkadminsys&' . $username . '@007registered';
        $_SESSION['user'] = $username;
        $_SESSION['check'] = $row['id'];
        $sess = $_SESSION['key'];
        $sqlUpdate = $conn->prepare("UPDATE paritosh_user SET session_key='$sess' WHERE username='$username'");
        $sqlUpdate->execute();

        if ($sqlUpdate->affected_rows > 0) {
            $_SESSION['loggedin'] = true;
            if (!empty($_POST['remember'])) {
                setcookie('remember', $sess, time() + 86400, '/');
                setcookie('id', $_SESSION['check'], time() + 86400, "/");
            }
            $showAlert = true;
        } else {
            session_unset();
            session_destroy();
        }
    } else {
        session_unset();
        session_destroy();
    }
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/icons.png" type="image/x-icon">
    <title>Sign Up</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .error1 {
            color: red;
            margin-left: 10px;
            font-weight: bold;
            font-size: 15px;
        }

        .success1 {
            color: green;
            margin-left: 10px;
            font-weight: bold;
            font-size: 15px;
        }

        .hidden {
            display: none;
        }

        #container {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 20px;
            font-weight: 600;
            margin: 5px 10px;
        }

        label:hover {
            cursor: pointer;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input,
        select {
            padding: 15px;
            margin: 5px 10px;
            font-weight: bold;
            color: navy;
        }

        #btn {
            padding: 10px;
            background-color: navy;
            color: white;
            margin: 5px 10px;
            border-radius: 2px;
            cursor: pointer;
            width: 80px;
            font-size: 15px;
        }

        .element {
            display: flex;
            flex-direction: column;
        }

        .element1 {
            display: flex;
        }

        .error {
            font-size: 18px;
            color: red;
            background-color: rgb(255, 207, 214);
            border: 2px solid red;
            font-weight: bold;
            list-style: disc;
            padding: 15px;
            margin: 5px 10px;
            display: none;
        }

        .success {
            font-size: 18px;
            color: #395e00;
            background-color: rgb(172, 255, 165);
            border: 2px solid #395e00;
            font-weight: bold;
            list-style: disc;
            padding: 15px;
            margin: 5px 10px;
            display: block;

        }

        .cancel {
            background-color: transparent;
            outline: none;
            border: none;
            font-weight: bold;
            font-size: 18px;
            margin-left: 20px;
        }
    </style>
</head>

<body>
    <?php
    if ($showAlert) {
        echo "<span class='success'>Your account is created!</span>";
        header('Refresh: 1; URL=profile.php');
    }
    ?>
    <div id="container">

        <form action="sign-up.php" method="post" id="myform" onsubmit="return false;">
            <div class="element"><label class="label" for="name">Username</label>
                <input class="inputF" name="username" type="text" id="name">
            </div>
            <span class="toggleSuccess" id="existUser"></span>
            <span class="error"></span>

            <div class="element"><label class="label" for="phone">Phone</label>
                <input class="inputF" name="phone" type="text" id="phone">
            </div>
            <span class="error"></span>

            <div class="element">
                <label for="gender">Gender:</label><select name="gender" id="gender">
                    <option value="male">male</option>
                    <option value="female">female</option>
                    <option value="other">other</option>
                </select>
            </div>

            <div class="element"><label class="label" for="email">Email</label>
                <input class="inputF" name="email" type="text" id="email">
            </div>
            <span class="error"></span>
            <div class="element"><label class="label" for="password">Password</label>
                <input class="inputF" name="passwd" type="password" id="password">
            </div>
            <span class="error"></span>
            <div class="element"><label class="label" for="cword">Confirm Password</label>
                <input class="inputF" type="password" id="cword">
            </div>
            <span class="error"></span>
            <div class="element1">
                <label for="remember" id="labelSpecial">Remember Me</label>
                <input type="checkbox" name="remember" value="Remember Me">
            </div>

            <button id="btn" onclick="checkFinal(); " type="submit">Sign Up</button>
        </form>
    </div>
</body>
<script src="signupScript.js"></script>
<script>
    document.getElementById('name').addEventListener('change', () => {
        ajaxDb();
    });


    function ajaxDb() {
        let bool = true;
        let xhr = new XMLHttpRequest();
        let userExist = document.getElementById('existUser');
        let value = document.getElementById('name').value;
        let data = {
            username: value
        };
        let textnode;
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                console.log(this.responseText);
                if (this.responseText == "OK") {
                    userExist.setAttribute("class", "");
                    userExist.setAttribute("class", "success1");
                } else {
                    userExist.setAttribute("class", "");
                    userExist.setAttribute("class", "error1");
                    bool = false;
                    console.log(bool);
                }
                userExist.innerText = this.responseText;

            }
        }
        xhr.open('POST', "test.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        if (boolname && boolean) {
            xhr.send(JSON.stringify(data));
        }
        console.log(boolname);
        return bool;


    }

    function checkFinal() {
        let b1 = ajaxDb();
        console.log(b1);
        let b2 = regCheck();
        console.log(b1 + " " + b2);
        if (b1 && b2) {
            document.getElementById('myform').setAttribute('onsubmit', 'return true');
            document.getElementById('btn').click();
        } else {
            alert('Fulfill all the requisites and then submit!');
        }
    }
</script>

</html>