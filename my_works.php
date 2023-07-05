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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My programs</title>

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
                <li class="nav-item"><a class="nav-link"  href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="trainer.php">Trainers</a></li>
                <li class="nav-item"><a class="nav-link" href="aboutus.php">About Us</a></li>
                <?php
                if(isset($_SESSION['username']) && isset($_SESSION['trainer_id']) && is_int($_SESSION['trainer_id'])){
                    echo '<li class="nav-item"><a class="nav-link"  href="exercises.php">Exercises</a></li>';
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
                    <a class="nav-link dropdown-toggle active" aria-current="page" href="#" role="button" data-bs-toggle="dropdown">'.$_SESSION["firstname"]. '</a>
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
    <div class="row gx-4 gx-lg-5">
        <div class="row gx-4 gx-lg-5">
            <?php
            if (isset($_SESSION['username']) && isset($_SESSION['user_id']) && is_int($_SESSION['user_id'])) {
                echo "    <h1 class='my-5'>MY PROGRAM</h1>";
                $userID = $_SESSION['user_id'];
                //$pdo = connectDatabase($dsn, $pdoOptions);

                $sqlCheckIsHidden = "SELECT is_hidden FROM user_programs WHERE user_id =:user_id";
                $stmtCheckIsHidden = $pdo->prepare($sqlCheckIsHidden);

                $stmtCheckIsHidden->bindParam(':user_id',$userID,PDO::PARAM_STR);
                $stmtCheckIsHidden->execute();
                if(!($stmtCheckIsHidden->fetchAll(PDO::FETCH_OBJ))){
                    echo '<h1 class=\'my-5\'>You didn\'t make a program yet.</h1>';
                }

                $sqlUserProgramListing = "SELECT e.title AS title, eu.unit_name AS unit, upe.count AS count,e.image AS image ,e.description AS description,e.link AS link
                                FROM user_programs_exercises upe
                                INNER JOIN exercises e ON upe.exercise_id = e.exercise_id
                                INNER JOIN exercise_unit eu ON e.unit_id = eu.unit_id
                                INNER JOIN user_programs up ON upe.user_programs_id = up.user_programs_id
                                WHERE up.user_id = :user_id AND is_hidden= 0

            ";
                //need a new listing because now it checks from upe.
                $sqlUserProgramExist = "SELECT * FROM user_programs WHERE user_id = :user_id AND is_hidden = 0";

                $stmtUserProgramExist = $pdo->prepare($sqlUserProgramExist);
                $stmtUserProgramExist->bindParam(':user_id', $userID, PDO::PARAM_STR);
                $stmtUserProgramExist->execute();

                $stmtUserProgramListing = $pdo->prepare($sqlUserProgramListing);
                $stmtUserProgramListing->bindParam(':user_id', $userID, PDO::PARAM_STR);

                $stmtUserProgramListing->execute();
                $results = $stmtUserProgramListing->fetchAll(PDO::FETCH_OBJ);

                if ($stmtUserProgramListing->rowCount() > 0) {
                    echo "
                        <div class='col-md-6 mb-5'>
                            <div class='card h-100'>
                                <div class='card-body'><table class='table'>  
                    <thead>     
                        <tr>                
                            <th>Exercise name</th>
                            <th>How many</th>
                            <th>Unit</th>
                            <th>Tutorial</th>
                            
                        </tr>
                    </thead>
                    <tbody>";
                    foreach ($results as $result) {


                        echo "<tr>";
                        echo "<td>";
                        echo "<div class='abbr-container'>";
                        echo "<abbr title='" . $result->description . "'>";
                        echo $result->title;
                        echo "<img class='abbr-image' src='" . $result->image . "' alt='Image Description'>";
                        echo "</abbr>";
                        echo "</div>";
                        echo "</td>";
                        echo "<td>" . $result->count . "</td>";
                        echo "<td>" . $result->unit . "</td>";
                        echo "<td><a href ='" . $result->link . "'target='_blank' >Link</a></td>";
                        echo "</tr>";


                    }
                    echo "</tbody>
</table>";

                    echo "
                    </div>
                </div>
            </div>
            
    ";

                }
                if($stmtUserProgramExist->rowCount() > 0) {

                    echo "
                    <form method='post' action='web.php'>
                         <input type='hidden' name='action' value='userDeleteProgram'>
                        <button type='submit' class='btn btn-danger btn-sm'>Delete program</button>
                    </form>";
                }

                echo '<h1 class=\'my-5\'>Ongoing programs</h1>';
                $sqlOngoing = "SELECT p.program_name AS name FROM programs p
                                    INNER JOIN ongoing_programs op ON p.program_id = op.program_id
                                    INNER JOIN user u ON op.user_id = u.user_id
                                    WHERE op.in_usage = 1 AND op.user_id = :user_id;";
                $stmtOngoing = $pdo->prepare($sqlOngoing);

                $stmtOngoing->bindParam(':user_id',$userID,PDO::PARAM_STR);
                $stmtOngoing->execute();

                $OngoingResults = $stmtOngoing->fetchAll(PDO::FETCH_OBJ);

             if ($stmtOngoing->rowCount() > 0) {
                 echo "
                        <div class='col-md-6 mb-5'>
                            <div class='card h-100'>
                                <div class='card-body'><table class='table'>  
                    <thead>     
                        <tr>                
                            <th>Program name</th>       
                        </tr>
                    </thead>
                    <tbody>";

                 foreach ($OngoingResults as $result) {
                     echo "<tr>";
                     echo "<td>" . $result->name . "</td>";
                     echo "</tr>";
                 }

                 echo "
                        </tbody>
                    </table>
                </div>
            </div>
        </div>";
             }
            

             ?>

                <?php


            }

            else if(isset($_SESSION['username']) && isset($_SESSION['trainer_id']) && is_int($_SESSION['trainer_id'])){
                echo"        <h1 class='my-5'>THE PROGRAMS I MADE:</h1>";

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
        WHERE p.is_hidden=0 AND t.trainer_id = :trainer_id 
           ";



                $stmtProgramListing = $pdo->prepare($sqlProgramListing);
                $stmtProgramListing->bindParam(':trainer_id', $_SESSION['trainer_id'], PDO::PARAM_INT);

                $stmtProgramListing->execute();
                if ($stmtProgramListing->rowCount() > 0) {
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
                                        <h2>" . $row["program_name"] . "</h2>
                                        <input type='hidden' name='program_name' value='" . htmlspecialchars($row["program_name"], ENT_QUOTES) . "'>
                                        <input type='hidden' name='program_id' value='" . $row["program_id"] . "'>
                                        <p>Created by: " . $row["firstname"] . " " . $row["lastname"] . "</p>
                                        <p>Category: " . $row["category_name"] . "</p>
                                        <p class='fw-bold text-decoration-underline'>Popularity: " . programPopularity($pdo, $row["program_id"], $row["trainer_id"]) . "</p>
                                       
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>";



                        if (isset($_SESSION['username']) && isset($_SESSION['user_id']) && is_int($_SESSION['user_id'])) {
                            echo "                                   
                       
                            
                        </form>";
                            //$sqlTrainerInsertRating = existsUserTrainerRating($pdo,$_SESSION['user_id'],$row["trainer_id"],$score);

                        } else if (isset($_SESSION['username']) && isset($_SESSION['trainer_id']) && is_int($_SESSION['trainer_id'])) {
                            echo "                                   
                            
                            
                        </form>";
                        }


                        echo "
                
    ";
                    }

                } else echo '<h2 class=\'my-5\'>There are no programs like this </h2>';


                echo"        <h1 class='my-2'>My comments</h1>";
                $trainerID = $_SESSION['trainer_id'];
                $i = 0;
                $sqlComment = "SELECT score,comment FROM trainer_rating WHERE trainer_id = :trainer_id;";
                $stmtComment = $pdo->prepare($sqlComment);

                $stmtComment->bindParam(':trainer_id',$trainerID,PDO::PARAM_STR);
                $stmtComment->execute();

                $CommentResults = $stmtComment->fetchAll(PDO::FETCH_OBJ);

                if ($stmtComment->rowCount() > 0) {
                    echo "
                        <div class='col-md-6 mb-5'>
                            <div class='card h-100'>
                                <div class='card-body'><table class='table'>  
                    <thead>     
                        <tr>
                            <th>Number</th>                
                            <th>Score</th>
                            <th>Comment</th>       
                        </tr>
                    </thead>
                    <tbody>";

                    foreach ($CommentResults as $result) {
                        echo "<tr>";
                        echo "<td>" . ++$i . "</td>";
                        echo "<td>" . $result->score . "</td>";
                        echo "<td>" . $result->comment . "</td>";
                        echo "</tr>";
                    }

                    echo "
                        </tbody>
                    </table>
                </div>
            </div>
        </div>";
                }

            }
            ?>


        </div>

    </div>
</div>


<footer class="py-5 bg-dark">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; Personal Trainers 2023</p></div>
</footer>
</body>
</html>