<?php
require_once 'db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check</title>


    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link rel="stylesheet" href="css/register.css">
    <script src="script/register.js"></script>

</head>
<body>
<script src="script/script.js"></script>
<div class="page-wrapper bg p-t-130 p-b-100 font-poppins">
    <div class="wrapper wrapper--w680">
        <div class="card card-4">
            <div class="card-body">

                <?php
                $r = 0;

                if (isset($_GET["r"]) and is_numeric($_GET['r'])) {
                    $r = (int)$_GET["r"];

                    if (array_key_exists($r, $messages)) {
                        echo '
                    <div  style="font-size: 40px" role="alert">
                        ' . $messages[$r] . '
                        
                    </div>
                    ';
                    }
                }
                ?><br><br>
                <a href="signIn.php" class="btn btn--radius-2 btn--blue" style="text-decoration: none">Login page</a>
                <a href="index.php" class="btn btn--radius-2 btn--blue" style="text-decoration: none">Continue as guest</a>
                <a href="register.php" class="btn btn--radius-2 btn--blue" style="text-decoration: none">Registration page</a>

            </div>
        </div>
    </div>

</body>
</html>
