<?php
include('connect.php');
session_start();
if (!isset($_SESSION['user']) || $_SESSION["loggedin"] != true) {
    header('location: index.php');
}

$error = true;
if (isset($_SESSION['profile'])) {
    $error = false;
}
$username = $_SESSION['user'];
$sql = "SELECT * FROM usersPro";
$result = mysqli_query($conn, $sql);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="images/icons.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/ad5664a170.js" crossorigin="anonymous"></script>
    <title>Sociophobia</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    body {
        height: 100vh;
    }

    .container {
        width: 100%;
        display: flex;
        height: 90%;
    }

    nav {
        font-size: 15px;
        height: 10%;
    }

    .dropdown-menu {
        background-color: #212529;
    }

    .dropdown-item {
        font-size: 15px;
        background-color: #212529;
        color: white;
        transition: all 500ms;
    }

    .dropdown-item:hover {
        background-color: rgb(244, 244, 244);
    }

    .container1 {
        height: 100%;
        width: 50%;
        margin-left: 0;
    }



    .container1>table {
        font-size: 15px;
        color: #151719;
        width: 100%;
    }

    #users th,
    #users td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #users tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #users tr:hover {
        background-color: #ddd;
        cursor: pointer;
    }



    #users th {
        font-size: 15px;
        padding-top: 6px;
        padding-bottom: 6px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }

    #chatroom {
        width: 50%;
        display: flex;
        background-color: #212529;
        flex-direction: column;
        position: relative;
        display: none;

    }

    #send-message {
        display: block;
        padding: 10px;
        width: 10%;
        font-size: 10px;
        font-weight: bold;
        background-color: transparent;
        outline: none;
        border-radius: 4px;
        border: 2px solid orangered;
        background-color: white;
        height: 100%;
    }

    #message {
        font-size: 20px;
        display: flex;
        width: 90%;
        height: 100%;
    }

    #send {
        width: 100%;
        display: flex;
        align-items: center;
        height: 10%;

    }

    #user-chat {
        height: 10%;
        font-size: 20px;
        color: white;
        font-weight: bold;
        border-bottom: 1px solid white;
    }

    #text {
        height: 80%;
        right: 0;
        display: flex;
    }

    #text-message {
        align-self: end;
        color: lime;
        list-style: none;
        font-size: 15px;
        width: 100%;
        overflow: scroll;

    }

    .sent-messages {
        color: lime;
        text-align: end;
    }

    .received-messages {
        color: white;

    }
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">iSocio</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="users.php">Home <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="profile.php">Update Profile</a>
                        <a class="dropdown-item" href="seeprofile.php">See Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
            <!-- <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> -->
        </div>
    </nav>
    <?php
    echo '<div class="container">';
    if (!$error) {
        echo '<div class="container1">
            <table id="users">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                </tr>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td id ="' . $row['username'] . '">' . $row['username'] . '</td>';
            echo '<td id ="' . $row['email'] . '">' . $row['email'] . '</td>';
            echo '</tr>';
        }



        echo '</table>
        </div>';
    } else {
        echo "<b style='color:red; font-size:20px; text-align: center;'>Profile is not completed yet!</b>";
    }

    echo '<div id="chatroom">
        <div id="user-chat">

        </div>
        <div id="text">
        <ul id="text-message">';

    echo '</ul>
        </div>
        <div id="send">
            <input name="message" id="message" ></input>
            
            <button type="button" id="send-message" onclick="func()">SEND</button>
        </div>
    </div>
</div>'; ?>
</body>
<script>
    let users = document.querySelectorAll('tr');
    let username;
    let chat_other = document.getElementById('user-chat');
    console.log(users);
    for (let i = 1; i < users.length; i++) {
        users[i].addEventListener('click', () => {
            document.getElementById('chatroom').style.display = 'flex';
            username = users[i].childNodes[0].textContent;
            chat_other.innerHTML = `<span class='user'>${username}</span>`;
            // setInterval(funcLive(), 1000);
        });
    }

    function funcLive() {
        let xhr = new XMLHttpRequest();
        let receiver = chat_other.innerText;

        chat = {
            to: receiver,
        }
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('text-message').innerHTML = this.response;
            }
        }
        xhr.open("POST", "chat.php", true);
        xhr.setRequestHeader("Content", "application/json");
        xhr.send(JSON.stringify(chat));
    }


    function func() {
        let xhr = new XMLHttpRequest();
        let receiver = chat_other.innerText;
        let chat;

        chat = {
            chat_message: document.getElementById('message').value,
            to: receiver,
            time: startTime()
        }

        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.response);
                document.getElementById('text-message').innerHTML = this.response;
            }
        }
        xhr.open("POST", "chat.php", true);
        xhr.setRequestHeader("Content", "application/json");
        xhr.send(JSON.stringify(chat));
    }
    setInterval(funcLive, 1000);
    document.getElementById('send-message').addEventListener('click', () => {
        if (document.getElementById('message').value.length != 0) {
            // let node = document.createTextNode(document.getElementById('message').value);
            // let ele = document.createElement('li');
            // ele.setAttribute("class", "sent-messages");
            // ele.appendChild(node);
            document.getElementById('message').value = "";
            func();
            // document.getElementById('text-message').append(ele);
        }
    });

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        // add a zero in front of numbers<10
        m = checkTime(m);
        s = checkTime(s);
        return (h + ":" + m + ":" + s);

    }
</script>

</html>