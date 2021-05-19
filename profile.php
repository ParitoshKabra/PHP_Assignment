<?php
include('connect.php');
session_start();
if (isset($_SESSION['profile']) && $_SESSION['profile'] == true) {
    header('location: users.php');
}
$users = false;
if (isset($_SESSION['profile']) && $_SESSION['profile'] == true) {
    $users = true;
}
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
    <script src="https://kit.fontawesome.com/ad5664a170.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="shortcut icon" href="images/icons.png" type="image/x-icon">
    <title>Welcome <?php echo $_SESSION['user'] ?></title>
    <style>
        html {
            height: 100vh;
        }

        body {
            width: 100%;
        }


        .dropdown-menu {
            background-color: #212529;
        }

        .dropdown-item {
            font-size: 15px;
            background-color: #212529;
            color: white;
            transition: all 1s;
        }

        .dropdown-item:hover {
            background-color: rgb(244, 244, 244);
        }

        .profile-container form {
            display: flex;
            width: 100%;
        }

        .profile-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: bold;
        }

        #profile {
            background-image: linear-gradient(to left, #151719, white);
        }

        nav {
            font-size: 15px;
        }

        #profile-image {
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: linear-gradient(to right, #151719, white);
        }

        #profile>table {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            table-layout: fixed;
        }

        input {
            height: 30px;
            width: 100%;
            font-size: 15px;
            color: #151719;
        }

        table tr td {
            font-size: 15px;
            color: #151719;
            font-weight: bold;
            padding: 15px;
        }

        input:focus,
        textarea:focus {
            background-color: #d5ebff;
            border: 1px solid skyblue;
            border-radius: 2px;
        }

        #upload {
            width: 40%;
            height: 40%;
            background: whitesmoke;
        }

        #upload label {
            max-height: 100%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #actual-btn:hover {
            cursor: pointer;
        }

        #profile {
            width: 60%;
        }

        #profile-image {
            width: 40%;
        }

        #imageU:hover {
            cursor: pointer;
        }


        #submit-btn {
            display: block;
            width: 30%;
            background-color: black;
            padding: 10px;
            color: white;
            cursor: pointer;
        }

        #upload>img {
            max-height: 100%;
        }

        .error {
            color: red;
            margin-left: 10px;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="profile.php">iSocio</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="profile.php">Home <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Change Profile</a>
                        <?php if ($users) {
                            echo '<a class="dropdown-item" href="users.php">See All Users</a>';
                        } ?>
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
    <div class="profile-container">
        <form action="upload.php" method="post" id="uploadProfile" enctype="multipart/form-data" onsubmit="return false">
            <div id="profile">
                <table>
                    <tr>
                        <td>Name:</td>
                        <td class="planted"><input type="text" class="changed" name="name" id="name"></td>
                    </tr>
                    <tr>
                        <td>Current Workplace/School:</td>
                        <td class="planted"><input type="text" class="changed" name="work" id="work"></td>
                    </tr>
                    <tr>
                        <td>About Yourself:</td>
                        <td class="planted"><textarea name="comment" class="changed" id="comment" cols="30" rows="10"></textarea></td>
                    </tr>
                    <tr>
                        <td>Date Of Birth:</td>
                        <td class="planted"><input type="text" class="changed" name="date" id="date" onfocus="(this.type='date')"> </td>
                    </tr>

                </table>
            </div>
            <div id="profile-image">

                <div id="upload">
                    <label for="actual-btn" id="imageU"><img src="images/default.png" alt="default.png" id="previewImg"></label>
                    <input type="file" id="actual-btn" name="fileToUpload" onchange="previewFile(this);" />

                </div>
            </div>
        </form>
        <button type="submit" id="submit-btn" form="uploadProfile" name="submit">Save Profile</button>
    </div>
</body>
<script>
    let input = document.querySelectorAll(".changed");
    let store = document.querySelectorAll(".planted");

    function previewFile(input) {
        var file = $("input[type=file]").get(0).files[0];

        if (file) {
            var reader = new FileReader();

            reader.onload = function() {
                $("#previewImg").attr("src", reader.result);
            }

            reader.readAsDataURL(file);
        }
    }
    let form = document.getElementById('uploadProfile');
    let image = document.getElementById('actual-btn');

    form.addEventListener('submit', event => {
        let b = true;

        for (let i = 0; i < input.length; i++) {
            if (input[i].value.length == 0) {

                let errorele = document.createElement('span');
                errorele.setAttribute("class", "error");
                errorele.textContent = "Field is required!!";
                store[i].appendChild(errorele);
                b = false;
            }
        }
        setTimeout(() => {
            let queries = document.querySelectorAll('td > span');
            for (let index = 0; index < queries.length; index++) {
                queries[index].remove();
            }
            if (b) {
                form.setAttribute("onsubmit", "return true");

                document.getElementById('submit-btn').click();
            }
        }, 1000);



    });
</script>

</html>