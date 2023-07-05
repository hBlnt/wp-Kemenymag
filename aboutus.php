<?php
session_start();
require_once 'db_config.php';
require_once 'functions_def.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us</title>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="script/script.js"></script>

    <link href="css/guestStyle.css" rel="stylesheet" />
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
                <li class="nav-item"><a class="nav-link active" href="aboutus.php">About Us</a></li>

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

    <div class="col-lg">
        <h1 class="font-weight-light my-2 text-center">Welcome to Personal Trainers!</h1>
        <p>Your one-stop online platform for personalized training programs tailored to meet your fitness goals. Whether you're a beginner looking to kickstart your fitness journey or an experienced athlete aiming to push your limits, Personal Trainers has got you covered.</p>
    </div>
    <div class="row gx-4 gx-lg-5 align-items-center my-5">
    <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" src="images/about1.jpg" alt="about1.jpg" /></div>
    <div class="col-lg-5">
        <p>We understand that each individual is unique, with specific needs and aspirations. That's why we offer a wide range of personalized training programs designed to cater to your requirements. Our team of certified fitness professionals and trainers have years of experience in crafting effective and results-driven workout routines.</p>
        <p>Our comprehensive range of training programs covers various fitness disciplines, including strength training, cardiovascular workouts, flexibility training, and more. Whether your goal is to lose weight, build muscle, increase endurance, or enhance overall fitness, we have the perfect program to help you achieve it.</p>
    </div>
    </div>

    <div class="row gx-4 gx-lg-5 align-items-center my-5">

        <div class="col-lg-5">
            <p>Your personal training program is accessible anytime, anywhere. Our mobile-friendly platform allows you to access your workout plans on your phone or tablet, making it convenient for you to stay committed to your fitness goals, even when life gets busy.</p>
            <p>So, if you're ready to take charge of your fitness journey, look no further than Personal Trainers. Join our community of fitness enthusiasts, and let us help you unlock your true potential. Start today and experience the transformation that personalized training can bring to your life.</p>
        </div>
        <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" src="images/about2.jpg" alt="about2.jpg" /></div>
    </div>
</div>



<footer class="py-5 bg-dark">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; Personal Trainers 2023</p></div>
</footer>
</body>
</html>