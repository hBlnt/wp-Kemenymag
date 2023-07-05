<?php
session_start();
require_once 'db_config.php';
require_once 'functions_def.php';

if(!isset($_SESSION['username']) || !isset($_SESSION['trainer_id']) || !is_int($_SESSION['trainer_id'])){
    redirection('signIn.php?l=0');
}
elseif (isset($_SESSION['admin_id']))
{
    redirection('signIn.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insert exercise</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="script/script.js"></script>

    <link href="css/guestStyle.css" rel="stylesheet" />
    <link href="css/register.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Personal Trainers</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="trainer.php">Trainers</a></li>
                <li class="nav-item"><a class="nav-link" href="aboutus.php">About Us</a></li>
                <?php
                if(isset($_SESSION['username']) && isset($_SESSION['trainer_id']) && is_int($_SESSION['trainer_id'])){
                    echo '<li class="nav-item"><a class="nav-link active" aria-current="page"  href="exercises.php">Exercises</a></li>';
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
        <h1>Insert new exercise</h1>
    </div>

    <form action="web.php" method="post" id="insertForm" enctype="multipart/form-data">

        <div class="row row-space">
            <div class="col-2">
                <div class="input-group">
                    <label for="insertExerciseTitle" class="label">title</label>
                    <input class="input--style-4"
                           type="text" id="insertExerciseTitle" name="title">
                    <small></small>
                </div>
            </div>
            <div class="col-2">
                <label  for="insertExerciseUnit" class="label">unit: </label>
                <div class="input-group">
                    <select name="unit" id="insertExerciseUnit" class="form-control-sm">
                        <option value="">Choose</option>

                        <?php
                        $sql = 'SELECT * FROM exercise_unit';
                        $query = $pdo->prepare($sql);
                        $query->execute();
                        $units = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($units as $singleUnit) {
                            $unitId = $singleUnit['unit_id'];
                            $unitName = $singleUnit['unit_name'];

                            ?>
                            <option value="<?php echo $unitId; ?>"><?php echo $unitName; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <small></small>
                </div>
            </div>
        </div>
        <div class="row row-space">
            <div class="col-2">
                <div class="input-group">
                    <label for="insertExerciseImage" class="label">image</label>
                    <input
                            type="file" id="insertExerciseImage" name="image">
                    <small></small>
                </div>
            </div>

            <div class="col-2">
                <div class="input-group">
                    <label for="insertExerciseLink" class="label">link</label>
                    <input class="input--style-4"
                           type="text" id="insertExerciseLink" name="link">
                    <small></small>
                </div>
            </div>

        </div>


        <div class="row row-space">
            <label for="insertExerciseDescription" class="label">description:</label>
            <textarea id="insertExerciseDescription" rows="10" cols="40" name="description" ></textarea>
            <small></small>
        </div>



        <div class="p-t-15 text-center">
            <input type="hidden" name="action" value="insertExercise">
            <button type="submit" class="btn btn--radius-2 btn--blue">Insert</button>
        </div>
    </form>


</div>

<footer class="py-5 bg-dark">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; Personal Trainers 2023</p></div>
</footer>
</body>
</html>