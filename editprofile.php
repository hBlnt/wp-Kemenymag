<?php
session_start();
require_once 'db_config.php';
require_once 'functions_def.php';

$testVariable ='';
if (!isset($_SESSION['username'])) {
    redirection('index.php');
}
elseif (isset($_SESSION['user_id']) && is_int($_SESSION['user_id'])) {

}
elseif (isset($_SESSION['trainer_id']) && is_int($_SESSION['trainer_id'])) {

}
else {
    redirection('index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit</title>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="script/script.js"></script>


    <link href="css/guestStyle.css" rel="stylesheet" />
    <link href="css/register.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Personal Trainers</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link"  href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" aria-current="page"  href="trainer.php">Trainers</a></li>
                <li class="nav-item"><a class="nav-link" href="aboutus.php">About Us</a></li>

                <?php
                if(isset($_SESSION['username']) && isset($_SESSION['trainer_id']) && is_int($_SESSION['trainer_id'])){
                    echo '<li class="nav-item"><a class="nav-link" aria-current="page"  href="exercises.php">Exercises</a></li>';
                    echo '<li class="nav-item"><a class="nav-link"   href="trainerProgramList.php">Program making</a></li>';
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
    <div class="my-5">
        <h1>Edit profile</h1>
    </div>

    <form action="web.php" method="post" id="editForm">

        <div class="row row-space">
            <div class="col-2">
                <div class="input-group">
                    <label for="editFirstname" class="label">first name</label>
                    <input class="input--style-4"
                           type="text" id="editFirstname" name="firstname" placeholder="<?php echo $_SESSION["firstname"]; ?>">
                    <small></small>
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label for="editLastname" class="label">last name</label>
                    <input class="input--style-4"
                           type="text" id="editLastname" name="lastname" placeholder="<?php echo $_SESSION["lastname"]; ?>">
                    <small></small>
                </div>
            </div>
        </div>
        <div class="row row-space">
            <div class="col-2">
                <div class="input-group">
                    <label for="editPassword" class="label">password</label>
                    <input class="input--style-4"
                           type="password" id="editPassword" name="password">
                    <small></small>
                    <span id="strengthDisp" class="badge displayBadge"></span>
                </div>
            </div>

            <div class="col-2">
                <div class="input-group">
                    <label for="editPasswordConfirm" class="label">password confirm</label>
                    <input class="input--style-4"
                           type="password" id="editPasswordConfirm" name="passwordConfirm">
                    <small></small>
                </div>
            </div>

        </div>
        <div class="row row-space">
            <div class="col-2">
                <div class="input-group">
                    <label for="editAge" class="label">Age</label>
                    <input class="input--style-4"
                           type="text" id="editAge" name="age" placeholder="<?php echo $_SESSION["age"]; ?>">
                    <small></small>
                </div>
            </div>
            <div class="col-2">
                <div class="input-group">
                    <label  for="editPhone" class="label">Phone Number</label>
                    <input class="input--style-4" type="text" id="editPhone" name="phone" placeholder="<?php echo $_SESSION["phone"]; ?>">
                    <small></small>
                </div>
            </div>
        </div>

        <?php
        if(isset($_SESSION['trainer_id']) && is_int($_SESSION['trainer_id'])) {
        echo'
        <div class="row row-space">
            <label for="editTrainerBiography" class="label">Biography:</label>
            <textarea id="editTrainerBiography" rows="10" cols="40" name="biography">'.$_SESSION["biography"].'</textarea>
            <small></small>
        </div>
        ';
        }
        ?>

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

        <div class="p-t-15 btn-center">
            <input type="hidden" name="action" value="edit">
            <button type="submit" class="btn btn--radius-2 btn--green" id="edit" >Edit</button>
        </div>
    </form>


</div>

<footer class="py-5 bg-dark">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; Personal Trainers 2023</p></div>
</footer>
</body>
</html>
