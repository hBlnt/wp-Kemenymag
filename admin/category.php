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
    <link href="css/register.css" rel="stylesheet" />
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
                <li class="nav-item"><a class="nav-link" href="trainer_ratings.php">Ratings</a></li>
                <li class="nav-item"><a class="nav-link active" href="category.php">Categories</a></li>
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
    <div class="my-5 text-center">
        <h1 class="font-weight-light">Categories</h1>
    </div>
    <div>
        <?php
        $c = 0;

        if (isset($_GET["c"]) and is_numeric($_GET['c'])) {
            $c = (int)$_GET["c"];

            if (array_key_exists($c, $messages)) {
                echo '
                    <div  style="font-size: 30px" role="alert">
                        ' . $messages[$c] . '
                        
                    </div>
                    ';
            }
        }
        ?>
    </div>

    <?php
    $sql = "Select MAX(category_id)+1 AS next_id FROM program_category";
    $queryresult =$pdo->query($sql);
    $result = $queryresult->fetch(PDO::FETCH_ASSOC);

    echo '
    

    <form action="web.php" method="post" id="categoryForm">
        <div class="row row-space">
            <div class="col-2">
                <div class="input-group">
                    <label for="editID" class="label">ID</label>
                    <input class="input--style-4"
                           type="text" id="editID" name="category_id" readonly value="">
                    <small></small>
                </div>
            </div>
            
            <div class="col-2">
                <div class="input-group">
                    <label for="editName" class="label">name</label>
                    <input class="input--style-4"
                           type="text" id="editName" name="name" value="">
                    <small></small>
                </div>
            </div>
        </div>
        <div class="row row-space">
            <label for="editDescription" class="label">Description</label>
            <textarea id="editDescription" rows="10" cols="40" name="description" value=""></textarea>
            <small></small>
        </div>
        <div class="p-t-15 text-center">


                    <input type="hidden" name="action" id="hiddenInput" value="">
                    <button class="btn btn--radius-2 btn--green" type="button" name="newButton" onclick="setID('.$result['next_id'].'),setHiddenInput(\'newCategory\')">Add new</button>
            ';
            ?>

                    <button  class="btn btn--radius-2 btn-primary" type="button" name="editButton" onclick="setHiddenInput('editCategory')">Edit</button>

                    <button class="btn btn--radius-2 btn-danger" type="button" name="deleteButton" onclick="setHiddenInput('deleteCategory')">Delete</button>


            </div>

    </form>

    <div class="my-2">
        <h1 class="font-weight-light">All categories:</h1>
    </div>

    <?php
    $sql = "Select * FROM program_category";

    if($result =$pdo->query($sql)){
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = $row;
        }
    }
    ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
        </tr>

        <?php
        foreach ($categories as $key => $value) {
            echo '<tr onclick="fill(\'' . $value['category_id'] . '\', \'' . $value['name'] . '\', \'' . $value['description'] . '\')">
                            <td >' . $value['category_id'] . '</td>
                            <td>' . $value['name'] . '</td>
                            <td>' . $value['description'] . '</td>         
                            ';
            }
        ?>
    </table>
</div>

    <footer class="py-5 bg-dark">
        <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; Personal Trainers 2023</p></div>
    </footer>
</body>
</html>
