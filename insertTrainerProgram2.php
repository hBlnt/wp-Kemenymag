<?php

require_once 'functions_def.php';
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['trainer_id']) || !is_int($_SESSION['trainer_id'])){
    redirection('signIn.php?l=0');
}
$trainer = $_SESSION['trainer_id'];

$programName="";
$category="";
$creator="";

if (isset($_POST['creator'])) {
    $creator = trim($_POST["creator"]);
}

if (isset($_POST['category'])) {
    $category = trim($_POST["category"]);
}

if (isset($_POST['programName'])) {
    $programName = trim($_POST["programName"]);
}
if (isset($_POST['programDay'])) {
    $programDay = $_POST["programDay"];
}

if (empty($category)) {
    redirection('trainerProgramList.php?e=4');
}

if (empty($programName)) {
    redirection('trainerProgramList.php?e=4');
}

if (empty($programDay)) {
    redirection('trainerProgramList.php?e=4');
}

if (empty($creator)) {
    redirection('trainerProgramList.php?e=4');
}
if(!existsTrainerProgram($pdo,$programName)) {

    $result = insertProgram($pdo, $programName, $creator, $category);


}
$_SESSION['current_program_id'] = getProgramId($pdo,$programName);
$_SESSION['programDay'] = $programDay;
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
        <h1 class="font-weight-light">Program making</h1>

    </div>


    <div class="row gx-4 gx-lg-5 overflow-auto">

        <form method="post" action="insertTrainerProgram3.php">

            <?php
            foreach ($programDay as $day) {
                $dayId = $day;
                $dayName = '';
                $dayName = getDayName($pdo,$dayId);
                echo '<label for="exerciseCount_' . $dayId . '">How many exercises should there be on, ' . $dayName . '</label>';
                echo '<input type="number" name="exerciseCount[]" id="exerciseCount_' . $dayId . '" /><br>';

            }

            ?>
            <button type="submit" class="btn btn--radius-2 bg-primary">go next</button>
        </form>

    </div>
</div>


<footer class="py-5 bg-dark">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; Personal Trainers 2023</p></div>
</footer>
</body>
</html>