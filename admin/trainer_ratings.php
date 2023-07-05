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
                <li class="nav-item"><a class="nav-link" href="user_permissions.php">Permissions</a></li>
                <li class="nav-item"><a class="nav-link" href="check_programs.php">Programs</a></li>
                <li class="nav-item"><a class="nav-link active" href="trainer_ratings.php">Ratings</a></li>
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
    <div class="my-2 text-center">
        <h1 class="font-weight-light">Trainers average rating:</h1>
    </div>
    <?php
    $t = 0;

    if (isset($_GET["t"]) and is_numeric($_GET['t'])) {
    $t = (int)$_GET["t"];

    if (array_key_exists($t, $messages)) {
    echo '
    <div  style="font-size: 40px" role="alert">
        ' . $messages[$t] . '

    </div>
    ';
    }
    }
    ?>

    <?php
    $sql = "SELECT t.trainer_id, t.firstname, t.lastname, AVG(tr.score)
            FROM trainer t
            INNER JOIN trainer_rating tr ON t.trainer_id = tr.trainer_id
            GROUP BY t.trainer_id, t.firstname, t.lastname;";

    if($result =$pdo->query($sql)){
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $avgRatings[] = $row;
        }
    }
    ?>
    <table>

        <tr>
            <th>Trainer ID</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Average score</th>
        </tr>

        <?php
        foreach ($avgRatings as $key => $value) {
            echo '<tr>
                        <td>' . $value['trainer_id'] . '</td>                 
                        <td>' . $value['firstname'] . '</td>
                        <td>' . $value['lastname'] . '</td>
                        <td>' . $value['AVG(tr.score)'] . '</td>
                        ';
        }
        ?>

    </table>
</div>

<div class="container px-4 px-lg-5">
    <div class="my-2 text-center">
        <h1 class="font-weight-light">All ratings:</h1>
    </div>

    <form action="web.php" method="post">
    <?php
    $sql = "SELECT tr.rating_id,CONCAT(u.firstname,' ',u.lastname) AS User, CONCAT(t.firstname,' ',t.lastname) AS Trainer, tr.score, tr.comment
            FROM trainer_rating tr
            INNER JOIN trainer t ON tr.trainer_id = t.trainer_id 
            INNER JOIN user u ON tr.user_id = u.user_id;";

    if($result =$pdo->query($sql)){
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $allRatings[] = $row;
        }
    }
    ?>
    <table>

        <tr>
            <th>User</th>
            <th>Trainer</th>
            <th>Score</th>
            <th>Comment</th>
        </tr>

        <?php
        foreach ($allRatings as $key => $value) {
            echo '<tr>
                        <td>' . $value['User'] . '</td>                 
                        <td>' . $value['Trainer'] . '</td>
                        <td>' . $value['score'] . '</td>
                        <td>' . $value['comment'] . '</td>
                        ';

             echo '<td>  <input type="hidden" name="action" value="deleteRating">
                        <button class="btn btn-danger" type="submit" name="deleteButton" value="' . $value['rating_id'] . '">Delete</button></td>';
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
