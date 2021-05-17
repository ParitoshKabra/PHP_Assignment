<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION["loggedin"] != true) {
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icons.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/ad5664a170.js" crossorigin="anonymous"></script>
    <title>Sociophobia</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    #navigation {
        display: flex;
        width: 100%;
        border: 1px solid rgb(0, 0, 0, 0.1);
        align-items: center;
        height: 70px;
    }

    .item {
        margin: 0 40px;
    }

    .navFirst {
        height: 100%;
        width: 50%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
    }

    .search-container {
        display: flex;
        align-items: center;
    }

    .search-main {
        display: flex;
        ;
    }

    .search-container>form {
        border: 2px solid navy;
        margin-right: 10px;
    }

    .btn {
        padding: 10px;
        background-color: transparent;
        outline: none;
        border: none;
    }

    .link {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        width: 10%;
    }

    * {
        padding: 0;
        margin: 0;
    }

    .link:hover {
        border-bottom: 4px solid purple;
    }

    button {
        background-color: transparent;
        outline: none;
        border: none;

    }

    button:hover {
        cursor: pointer;
    }

    .fa-sign-out-alt {
        color: white;
        background-color: black;
    }

    .fa-caret-square-down {
        padding: 16px;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;

    }

    .dropbtn {
        display: inline-block;
        position: relative;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown-content .use-links:hover {
        background-color: #ddd;
    }

    .dropdown:hover .dropbtn {
        cursor: pointer;
        opacity: 0.9;
    }

    .use-links {
        padding: 10px;
    }

    .use-links a {
        display: block;
        text-decoration: none;
        color: navy;
        margin-bottom: 10px;

        font-weight: bold;
        font-size: 20px;
    }

    .use-links button {
        color: navy;
        font-weight: bold;
        display: block;

        font-size: 20px;
    }
</style>

<body>
    <nav id="navigation">
        <div class="navFirst item">
            <a href="welcome.php" id="home"><img src="icons.png" alt="icon"></a>
            <a href="welcome.php" id="home" class="link"><i class="fas fa-church fa-5x"></i></a>
        </div>
        <div class="search-main item">
            <div class="search-container">
                <form action="welcome.php">
                    <input type="text" placeholder="Search.." name="search" class="btn">
                    <button type="submit" class="fas fa-search btn"></button>
                </form>
            </div>
            <div class="dropdown">
                <button class="dropbtn"><i class="fas fa-caret-square-down fa-2x"></i></button>
                <div class="dropdown-content">
                    <div class="logout use-links"><a href="logout.php">
                            <p>Logout</p>
                        </a></div>
                    <div class="use-links">
                        <button onclick="ajaxR()">See Users</button>
                    </div>
                </div>
            </div>
        </div>

    </nav>
</body>
<script src="ajax.js"></script>

</html>