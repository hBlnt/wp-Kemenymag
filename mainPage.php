<?php
session_start();
require_once 'db_config.php';
require_once 'functions_def.php';

if (!isset($_SESSION['username'])) {
    redirection('signIn.php?l=0');
}
elseif (isset($_SESSION['user_id']) && is_int($_SESSION['user_id'])) {

}
elseif (isset($_SESSION['trainer_id']) && is_int($_SESSION['trainer_id'])) {

}
else {
    redirection('signIn.php?l=0');
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
            crossorigin="anonymous"></script>

    <title>Web company</title>
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Logo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Our services</a>
            </li>
                <li class="nav-item">
                    <a class="nav-link" href="trainer.php">Trainers</a>
                </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Profile</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Change profile</a>
                    <a class="dropdown-item" href="#">My works</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Log out</a>
                </div>
            </li>
        </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="text" placeholder="Search">
                <button class="btn btn-primary" type="button">Search</button>
            </form>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 p-2">
                <h1 class="display-4">Welcome <?php echo $_SESSION['username'] ?> you are a <?php echo $_SESSION['usertype']?></h1>
            <p class="text-justify">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis convallis augue vitae quam feugiat
                viverra. Nulla at diam at est luctus molestie. Nulla leo orci, feugiat ut ex id, placerat ultricies
                dolor. Ut ac enim vel est sodales egestas eu sed lectus. Mauris sed ligula eu arcu elementum ultricies.
                Morbi mi quam, egestas quis pretium at, sodales elementum risus. Lorem ipsum dolor sit amet, consectetur
                adipiscing elit. Nulla tincidunt non ipsum et varius. Suspendisse feugiat justo eu risus ultricies
                commodo. Donec eleifend mauris at lorem elementum gravida. Curabitur ut accumsan purus, lacinia
                vulputate urna. Proin finibus tristique gravida. Nullam tempus convallis orci, nec congue turpis
                faucibus vel. Nam id lacinia nulla, a gravida nulla. Ut blandit erat nisi, in tempor tellus semper
                vitae. Nullam nec euismod purus, lacinia tincidunt ligula.
            </p>
            <p class="text-justify">
                Phasellus elementum, neque nec aliquet elementum, augue est sodales tortor, sed pellentesque turpis
                tortor sed lacus. Nullam accumsan viverra commodo. Phasellus mattis arcu nec ipsum laoreet ornare.
                Vestibulum finibus suscipit mauris, eget tempor leo euismod eget. Nulla facilisi. Suspendisse lacinia
                condimentum viverra. Nunc risus ex, sodales at justo quis, ultricies ornare ex. Lorem ipsum dolor sit
                amet, consectetur adipiscing elit. In hac habitasse platea dictumst. Vivamus varius id ex nec interdum.
                Donec semper porta euismod.
            </p>
            <p class="text-justify">
                Suspendisse sollicitudin posuere feugiat. Praesent at elit sit amet lacus finibus accumsan eu ac ligula.
                Pellentesque a fermentum orci. Sed pretium accumsan dolor, sed placerat lacus efficitur eu. In hac
                habitasse platea dictumst. Aliquam scelerisque urna vitae lobortis mollis. Vivamus dignissim arcu eu
                odio laoreet lacinia. Sed volutpat commodo orci, non ultrices sem porttitor sed. In a mauris a elit
                porta laoreet. Pellentesque dolor turpis, dignissim vitae orci nec, convallis porttitor risus.
            </p>

        </div>

    </div>
</div>
</body>
</html>