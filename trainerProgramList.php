<?php

require_once 'functions_def.php';
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['trainer_id']) || !is_int($_SESSION['trainer_id'])){
    redirection('signIn.php?l=0');
}
$trainer = $_SESSION['trainer_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Program making</title>

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
        <a class="navbar-brand" href="#">Personal Trainers</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="trainer.php">Trainers</a></li>
                <li class="nav-item"><a class="nav-link" href="aboutus.php">About Us</a></li>
                <?php
                if(isset($_SESSION['username']) && isset($_SESSION['trainer_id']) && is_int($_SESSION['trainer_id'])){
                    echo '<li class="nav-item"><a class="nav-link" aria-current="page"  href="exercises.php">Exercises</a></li>';
                    echo '<li class="nav-item"><a class="nav-link active" aria-current="page"  href="trainerProgramList.php">Program making</a></li>';
                }
                ?>

                <?php
                if (!isset($_SESSION['username'])) {
                    echo'
                <li class="nav-item"><a class="nav-link" href="signIn.php">Log-in</a></li>
                <li class="nav-item"><a class="nav-link" href="register.php">Registration</a></li>
                    ';
                }else{
                    echo '
                    <li class="nav-item"><a class="nav-link" href="user_list_program.php">Programs</a></li>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">'.$_SESSION["firstname"]. '</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="editprofile.php">Edit profile</a>
                        <a class="dropdown-item" href="my_works.php">My programs</a>
                   <div class="dropdown-divider"></div>
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
    <div class="row gx-4 gx-lg-5 my-5 text-center">
        <h1 class="font-weight-light">PROGRAMS</h1>
        <form method="get" action="insertTrainerProgram.php">
            <button class='btn btn-primary' type='submit'>Make new program</button>
        </form>
        <?php

        $e = 0;

        if (isset($_GET["e"]) and is_numeric($_GET['e'])) {
            $e = (int)$_GET["e"];

            if (array_key_exists($e, $messages)) {
                echo '
                    <div style="font-size: 40px" role="alert">
                        ' . $messages[$e] . '
                        
                    </div>
                    ';
            }
        }
        ?>
    </div>


    <div class="row gx-4 gx-lg-5 overflow-auto">
        <?php
        // BUTTON ÜRESBUTTON ÜRESBUTTONBUTTON ÜRESBUTTON ÜRESBUTTON ÜRESBUTTON ÜRES
        $sql = "SELECT  program_id, program_name , t.email AS 'email', pcategory.name AS 'category_name', popularity FROM programs p
INNER JOIN program_creators pc ON p.creator_id=pc.p_creator_id
INNER JOIN trainer t ON pc.trainer_id = t.trainer_id
INNER JOIN program_category pcategory ON p.category_id = pcategory.category_id 
WHERE t.trainer_id = :trainer_id
";

        $query = $pdo->prepare($sql);
        $query->bindParam(':trainer_id', $trainer, PDO::PARAM_STR);

        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);


        ?>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Program name</th>
                <th>Category</th>
                <th>Popularity</th>
                <th colspan="2">Operation</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($query->rowCount() > 0) {
                $_SESSION['program_ids'] = [];
                $index = 0;
                foreach ($results as $result) {
                    $_SESSION['program_ids'][] = $result->program_id;
                    echo " <tr>";
                    echo "<td>". $result->program_name ."</td>";
                    echo "<td>". $result->category_name ."</td>";
                    echo "<td>". $result->popularity ."</td>";
                    echo "<td><form method='POST' action=''>";
                    echo "<input type='hidden' name='index' value='". $index . "'>";
                    echo "<button class='btn btn-primary' type='submit'>Edit</button>";
                    echo "</form></td>";
                    echo "<td><form method='POST' action='web.php'>";
                    echo "<input type='hidden' name='index' value='". $index . "'>";
                    echo "<input type='hidden' name='action' value='deleteTrainerProgram'>";
                    echo "<button class='btn btn-danger' type='submit'>Delete</button>";
                    echo "</form></td>";
                    echo "</tr>";
                    $index++;
                }
            }
            ?>
            </tbody>
        </table>


    </div>
</div>


<footer class="py-5 bg-dark">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; Personal Trainers 2023</p></div>
</footer>
</body>
</html>