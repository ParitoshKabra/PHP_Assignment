<?php
include('connect.php');
session_start();
if (empty($_SESSION['user']) || !isset($_SESSION['user'])) {
    header('location: index.php');
}

$username = $_SESSION['user'];
$sql = $conn->prepare("SELECT name,work,description,dateOb FROM paritosh_usersProfile JOIN paritosh_user ON paritosh_user.id=paritosh_usersProfile.id AND username=?");
$sql->bind_param("s", $username);
$sql->execute();
$result = $sql->get_result();
$row = mysqli_fetch_assoc($result);
$variables = array($row['name'], $row['work'], $row['description'], $row['dateOb']);

// print_r($_SESSION);
$id = $_SESSION['check'];
$sql1 = $conn->prepare("SELECT ProfilePic FROM paritosh_usersProfile WHERE id=?");
$sql1->bind_param("i", $id);
$sql1->execute();
$result1 = $sql1->get_result();
$row1 = mysqli_fetch_assoc($result1);
$target_file = $row1['ProfilePic'];

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
            transition: all 500ms;
        }

        .dropdown-item:hover {
            background-color: rgb(244, 244, 244);
        }



        .profile-container {
            height: 90vh;
            width: 100%;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: bold;
        }

        #profile {
            background-image: linear-gradient(to left, #0087ff, white);
        }

        nav,
        pre {
            font-size: 15px;
        }

        #profile-image {
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: linear-gradient(to left, #0087ff, white);
            max-height: 100%;
        }

        #profile>table {
            max-height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* table-layout: fixed; */
        }



        table tr td {
            font-size: 15px;
            color: #151719;
            font-weight: bold;
            padding: 15px;
        }







        #profile {
            width: 60%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        #profile-image {
            width: 40%;
            height: 100%;
        }






        img {
            display: block;
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">iSocio</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="profile.php">Home <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="profile.php">Update Profile</a>
                        <a class="dropdown-item" href="users.php">See All Users</a>
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

        <div id="profile">
            <table>
                <tr>
                    <td>Name:</td>
                    <td class="planted"><?php echo $variables[0]; ?></td>
                </tr>
                <tr>
                    <td>Current Workplace/School:</td>
                    <td class="planted"><?php echo $variables[1]; ?></td>
                </tr>
                <tr>
                    <td>About Yourself:</td>
                    <td>
                        <pre><?php echo $variables[2]; ?></pre>
                    </td>
                </tr>
                <tr>
                    <td>Date Of Birth:</td>
                    <td class="planted"><?php echo $variables[3]; ?> </td>
                </tr>

            </table>
        </div>
        <div id="profile-image">


            <?php
            echo "<img src='$target_file' alt=''/>";

            ?>

        </div>

    </div>
</body>

</html>
<?php
// echo "<img src='$target_file' alt=''/>";
?>