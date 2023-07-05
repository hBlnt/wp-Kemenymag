<?php
session_start();
require_once 'db_config.php';
require_once 'functions_def.php';

if (!isset($_SESSION['username'])) {
    redirection('signIn.php?l=1');
}
if (isset($_SESSION['admin_id']))
{
    redirection('logout.php');
}

$_SESSION['program_name']='';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Programs</title>

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
        <a class="navbar-brand" href="index.php">Personal Trainers</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="trainer.php">Trainers</a></li>
                <li class="nav-item"><a class="nav-link" href="aboutus.php">About Us</a></li>
                <?php
                if(isset($_SESSION['username']) && isset($_SESSION['trainer_id']) && is_int($_SESSION['trainer_id'])){
                    echo '<li class="nav-item"><a class="nav-link" href="exercises.php">Exercises</a></li>';
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
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="user_list_program.php">Programs</a></li>
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
    <div class="row gx-4 gx-lg-5 align-items-center my-5">
        <div class="col-lg-7">
            <?php
            $uLP = 0;

            if (isset($_GET["uLP"]) and is_numeric($_GET['uLP'])) {
                $uLP = (int)$_GET["uLP"];

                if (array_key_exists($uLP, $messages)) {
                    echo '
                    <div class="serious_message" role="alert">
                        ' . $messages[$uLP] . '
                        
                    </div>
                    ';
                }
            }
            ?>
            <h1 class="font-weight-light">TRAINING PROGRAMS</h1>
            <p>All of our programs:</p>

            <div>
                <form method="post">
                    <label for="search_by_name">Search</label>
                    <input type="text" name="search" id="search_by_name" class="form-control-lg" placeholder="Search"><br>
                    <label for="category">Program category:</label>
                    <select name="category" id="category" class="form-control-lg">
                        <option value="">Choose</option>
                        <?php

                        $sql = 'SELECT * FROM program_category';
                        $query = $pdo->prepare($sql);
                        $query-> execute();
                        $categories = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach($categories as $category){
                        $categoryId = $category['category_id'];
                        $categoryName = $category['name'];

                        ?>
                        <option value="<?php echo $categoryId;?>"><?php echo $categoryName;}
                            ?></option>
                    </select><br>
                    <button type='submit' id='searchButton' class='btn btn-primary btn-sm'>Go search</button>
                </form>
            </div>
        </div>
        <div class="col-lg-5">
            <?php
            if (isset($_SESSION['username']) && isset($_SESSION['user_id']) && is_int($_SESSION['user_id'])) {
                if(!(userProgramExists($pdo,$_SESSION['user_id']))){
                    echo '<h2 class="font-weight-light">Do you want to make yourself a program?</h2>
                <!--We check with another form if the user wants to make a program -->

                    <form class="text-center" method="post" action="user_make_program.php">
                    <input type="hidden" name="action" value="userMakeProgram">
                    <button type="submit" id="new_program_user" class="btn btn-primary btn-lg">Yes I do</button>
                </form>
           
            '; }
            }
            ?>
        </div>

    </div>
    <div class="row gx-4 gx-lg-5">
        <?php

        //$pdo = connectDatabase($dsn, $pdoOptions);
        $selectedCategory = $_POST['category'] ?? '';
        $insertedSearch = $_POST['search'] ?? '';

        $sqlProgramListing = "SELECT p.program_id, p.category_id,p.is_hidden,
        p.program_name,  t.firstname,  t.lastname,t.trainer_id,  pcg.name AS 'category_name'
        FROM 
          programs p
        INNER JOIN 
          program_creators pc ON p.creator_id = pc.p_creator_id
        INNER JOIN 
          trainer t ON pc.trainer_id = t.trainer_id
        INNER JOIN 
          program_category pcg ON p.category_id = pcg.category_id
        WHERE p.is_hidden=0 AND t.is_banned=0 
           ";

        //checking if the category is sent
        if (!empty($selectedCategory)) {
            $sqlProgramListing .= " AND p.category_id = :category_id";
        }
        if (!empty($insertedSearch)) {

            $sqlProgramListing .= " AND (p.program_name LIKE :search)";
        }

        $stmtProgramListing = $pdo->prepare($sqlProgramListing);

        if (!empty($selectedCategory)) {
            $stmtProgramListing->bindParam(':category_id', $selectedCategory, PDO::PARAM_INT);
        }
        if (!empty($insertedSearch)) {
            $searchTerm = '%' . $insertedSearch . '%';
            $stmtProgramListing->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        }
        $stmtProgramListing->execute();
        if($stmtProgramListing->rowCount() > 0){
            while ($row = $stmtProgramListing->fetch(PDO::FETCH_ASSOC)) {
                if (!empty($insertedSearch) && !str_contains(strtolower($row["program_name"]), strtolower($insertedSearch))) {
                    continue;
                }

                echo "   
                    <div class='col-md-4 mb-5'>
                        <div class='card h-100'>
                            <div class='card-body'>    
                            <form action='program_information.php' method='POST' class='flex-grow-1 d-flex flex-column h-100'>
                            <div class='flex-grow-1'>
                            
                                <h2>".$row["program_name"]."</h2>
                                
                                <input type='hidden' name='program_name' value='".htmlspecialchars($row["program_name"], ENT_QUOTES)."'>
                                <input type='hidden' name='program_id' value='".$row["program_id"]."'>
                                <p>Created by: ".$row["firstname"]." ".$row["lastname"]."</p>
                                    <p>Category: ".$row["category_name"]."</p>
                            </div>";

                if (isset($_SESSION['username']) && isset($_SESSION['user_id']) && is_int($_SESSION['user_id'])) {
                    echo "                                   
                            <button type='submit' id='more_info' class='btn btn-primary btn-sm'>More information</button>
                       
                            
                        </form>";
                    //$sqlTrainerInsertRating = existsUserTrainerRating($pdo,$_SESSION['user_id'],$row["trainer_id"],$score);

                }
                else if(isset($_SESSION['username']) && isset($_SESSION['trainer_id']) && is_int($_SESSION['trainer_id']))
                {
                    echo "                                   
                            <p class='fw-bold text-decoration-underline'>Popularity: ".programPopularity($pdo,$row["program_id"],$row["trainer_id"]) . "</p>
                            
                        </form>";
                }


                echo "
                </div>
            </div>
        </div>
    ";
            }

        }
        else echo '<h2>There are no programs like this </h2>';
        ?>



    </div>
</div>


<footer class="py-5 bg-dark">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; Personal Trainers 2023</p></div>
</footer>
</body>
</html>