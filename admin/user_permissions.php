<?php
session_start();
require_once 'db_config.php';
require_once 'functions.php';

if(!isset($_SESSION['username']) || !isset($_SESSION['admin_id'])) {
    redirection('login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="script/script.js"></script>

    <link href="css/guestStyle.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Personal Trainers Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="user_permissions.php">Permissions</a></li>
                <li class="nav-item"><a class="nav-link" href="check_programs.php">Programs</a></li>
                <li class="nav-item"><a class="nav-link" href="trainer_ratings.php">Ratings</a></li>
                <li class="nav-item"><a class="nav-link" href="category.php">Categories</a></li>
                <?php
                if (isset($_SESSION['username'])) {
                    echo '
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">'.$_SESSION["username"]. '</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">                 
                        <a class="dropdown-item" href="logout.php">Log out</a>
                    </div>
                </li>
                    ';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container px-4 px-lg-5">
    <div class="my-2">
        <h1 class="font-weight-light">All users:</h1>
        <?php
        $ub = 0;

        if (isset($_GET["ub"]) and is_numeric($_GET['ub'])) {
            $ub = (int)$_GET["ub"];

            if (array_key_exists($ub, $messages)) {
                echo '
                    <div  style="font-size: 40px" role="alert">
                        ' . $messages[$ub] . '
                        
                    </div>
                    ';
            }
        }
        ?>
    </div>
    <?php
    $sql = "Select user_id,email,firstname,lastname,age,gender,phone,is_banned FROM user";

    if($result =$pdo->query($sql)){
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $row;
        }
    }
    ?>
    <form action="web.php" method="post">
    <table>

        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Phone</th>
            <th>Banned</th>
            <th>Operation</th>
        </tr>


        <?php
        foreach ($users as $key => $value) {
            echo '<tr>
        <td>' . $value['user_id'] . '</td>
        <td>' . $value['email'] . '</td>
        <td>' . $value['firstname'] . '</td>
        <td>' . $value['lastname'] . '</td>
        <td>' . $value['age'] . '</td>
        <td>' . $value['gender'] . '</td>
        <td>' . $value['phone'] . '</td>
        <td>' . $value['is_banned'] . '</td>
           <td> ';

            if ($value['is_banned'] === 0) {
                echo ' <input type="hidden" name="action" value="ban">
                       <button class="btn btn-danger" type="submit" name="userBan" value="' . $value['user_id'] . '">Ban</button>';
            } else {
                echo '  <input type="hidden" name="action" value="ban">
                        <button class="btn btn-success" type="submit" name="userUnban" value="' . $value['user_id'] . '">Unban</button>';
            }

            echo '</td>
    </tr>';
        }
        ?>

    </table>
    </form>


    <div class="my-2">
        <h1 class="font-weight-light">All trainers:</h1>
        <?php
        $tb = 0;

        if (isset($_GET["tb"]) and is_numeric($_GET['tb'])) {
            $tb = (int)$_GET["tb"];

            if (array_key_exists($tb, $messages)) {
                echo '
                    <div  style="font-size: 40px" role="alert">
                        ' . $messages[$tb] . '
                        
                    </div>
                    ';
            }
        }
        ?>
    </div>
    <?php
    $sql = "Select trainer_id,email,firstname,lastname,age,gender,phone,biography,is_banned,admin_approval FROM trainer";

    if($result =$pdo->query($sql)){
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $trainers[] = $row;
        }
    }
    ?>
    <form action="web.php" method="post">
        <table >

            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>Biography</th>
                <th>Banned</th>
                <th>Approval</th>
                <th colspan="3">Operation</th>
            </tr>

        <?php
        foreach ($trainers as $key => $value) {
            echo '<tr>
                <td>' . $value['trainer_id'] . '</td>
                <td>' . $value['email'] . '</td>
                <td>' . $value['firstname'] . '</td>
                <td>' . $value['lastname'] . '</td>
                <td>' . $value['age'] . '</td>
                <td>' . $value['gender'] . '</td>
                <td>' . $value['phone'] . '</td>
                <td>' . $value['biography'] . '</td>
                <td>' . $value['is_banned'] . '</td>
                <td>' . $value['admin_approval'] . '</td>                                
                <td>';

            if ($value['is_banned'] === 0) {
                echo ' <input type="hidden" name="action" value="ban">
                       <button class="btn btn-danger" type="submit" name="trainerBan" value="' . $value['trainer_id'] . '">Ban</button>';
            } else {
                echo '  <input type="hidden" name="action" value="ban">
                        <button class="btn btn-success" type="submit" name="trainerUnban" value="' . $value['trainer_id'] . '">Unban</button>';
            }
            if($value['admin_approval'] ===0){
                echo '<td> <input type="hidden" name="action" value="ban">
                       <button class="btn btn-success" type="submit" name="trainerApprove" value="' . $value['trainer_id'] . '">Approve</button></td>';

                echo '<td>  <input type="hidden" name="action" value="ban">
                        <button class="btn btn-danger" type="submit" name="trainerDelete" value="' . $value['trainer_id'] . '">Denie</button></td>';
            }


            echo '</td>
    </tr>';
        }
        ?>
        </table>
    </form>




</div>

<footer class="py-5 bg-dark">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; Personal Trainers 2023</p></div>
</footer>
</body>
</html>
