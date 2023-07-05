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
                <li class="nav-item"><a class="nav-link active" href="check_programs.php">Programs</a></li>
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
        <h1 class="font-weight-light">Trainer programs:</h1>
        <?php
        $pt = 0;

        if (isset($_GET["pt"]) and is_numeric($_GET['pt'])) {
            $pt = (int)$_GET["pt"];

            if (array_key_exists($pt, $messages)) {
                echo '
                    <div  style="font-size: 40px" role="alert">
                        ' . $messages[$pt] . '
                        
                    </div>
                    ';
            }
        }
        ?>
    </div>
    <?php
    $sql = "SELECT p.program_id, CONCAT(t.firstname,' ',t.lastname) AS Creator_name,ca.name,p.popularity,p.is_hidden
            FROM programs p
            INNER JOIN program_creators pc ON p.creator_id = pc.p_creator_id
            INNER JOIN trainer t ON pc.trainer_id = t.trainer_id
            INNER JOIN program_category ca ON p.category_id = ca.category_id;";

    if($result =$pdo->query($sql)){
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $programs[] = $row;
        }
    }
    ?>

    <form action="web.php" method="post">
        <table>
            <tr>
                <th>Program ID</th>
                <th>Creator name</th>
                <th>Category</th>
                <th>Popularity</th>
                <th>Blocked</th>
                <th>Operation</th>
            </tr>

            <?php
            foreach ($programs as $key => $value) {
                echo '<tr>
                    <td>' . $value['program_id'] . '</td>
                    <td>' . $value['Creator_name'] . '</td>
                    <td>' . $value['name'] . '</td>
                    <td>' . $value['popularity'] . '</td>
                    <td>' . $value['is_hidden'] . '</td>
                   <td>';

                if ($value['is_hidden'] === 0) {
                    echo ' <input type="hidden" name="action" value="block">
                       <button class="btn btn-danger" type="submit" name="trainer_program_Block" value="' . $value['program_id'] . '">Block</button>';
                } else {
                    echo '  <input type="hidden" name="action" value="block">
                        <button class="btn btn-success" type="submit" name="trainer_program_Unblock" value="' . $value['program_id'] . '">Unblock</button>';
                }

           echo '</td>
    </tr>';
            }
            ?>
        </table>
    </form>

    <div class="my-2">
        <h1 class="font-weight-light">User programs:</h1>
        <?php
        $pu = 0;

        if (isset($_GET["pu"]) and is_numeric($_GET['pu'])) {
            $pu = (int)$_GET["pu"];

            if (array_key_exists($pu, $messages)) {
                echo '
                    <div  style="font-size: 40px" role="alert">
                        ' . $messages[$pu] . '
                        
                    </div>
                    ';
            }
        }
        ?>

        <?php
        $sql = "SELECT up.user_programs_id,u.firstname,u.lastname,up.is_hidden FROM user_programs up 
                INNER JOIN user u ON up.user_id = u.user_id;";

        if($result =$pdo->query($sql)){
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $userprograms[] = $row;
            }
        }
        ?>

        <form action="web.php" method="post">
            <table>
                <tr>
                    <th>Program ID</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Blocked</th>
                    <th>Operation</th>
                </tr>

                <?php
                foreach ($userprograms as $key => $value) {
                    echo '<tr>
                    <td>' . $value['user_programs_id'] . '</td>
                    <td>' . $value['firstname'] . '</td>
                    <td>' . $value['lastname'] . '</td>         
                    <td>' . $value['is_hidden'] . '</td>
                   <td>';

                    if ($value['is_hidden'] === 0) {
                        echo ' <input type="hidden" name="action" value="block2">
                       <button class="btn btn-danger" type="submit" name="user_program_Block" value="' . $value['user_programs_id'] . '">Block</button>';
                    } else {
                        echo '  <input type="hidden" name="action" value="block2">
                        <button class="btn btn-success" type="submit" name="user_program_Unblock" value="' . $value['user_programs_id'] . '">Unblock</button>';
                    }

                    echo '</td>
    </tr>';
                }
                ?>
            </table>
        </form>
    </div>

</div>
<footer class="py-5 bg-dark">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; Personal Trainers 2023</p></div>
</footer>
</body>
</html>
