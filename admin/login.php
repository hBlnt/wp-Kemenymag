<?php
require_once 'db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log in</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="script/script.js"></script>

    <link rel="stylesheet" href="css/style.css">


</head>
<body id="login-body">

<section  class="vh-100 login-bg">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-md-4 pb-5">

                            <h2 class="fw-bold mb-2 text-uppercase">Admin</h2>
                            <div class="text-white-50 mb-5"></div>
                            <form action="web.php" method="post" id="loginForm">
                                <div class="form-outline form-white mb-4">
                                    <input type="text" id="adminUsername" class="form-control form-control-lg" name="username">
                                    <label class="form-label" for="adminUsername">Username</label>
                                    <small></small>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="password" id="adminPassword" class="form-control form-control-lg" name="password">
                                    <label class="form-label" for="adminPassword">Password</label>
                                    <small></small>
                                </div>

                                <input type="hidden" name="action" value="login">
                                <button type="submit" class="btn btn-outline-light btn-lg px-5">Log in</button>
                            </form>

                            <?php

                            $l = 0;

                            if (isset($_GET["l"]) and is_numeric($_GET['l'])) {
                                $l = (int)$_GET["l"];

                                if (array_key_exists($l, $messages)) {
                                    echo '
                    <div style="font-size: 40px" role="alert">
                        ' . $messages[$l] . '
                        
                    </div>
                    ';
                                }
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>