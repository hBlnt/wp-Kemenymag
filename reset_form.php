<?php
require_once 'db_config.php';
if (isset($_GET['token'])) {
    $token = trim($_GET['token']);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">

    <script src="script/script.js"></script>


    <title>Reset password</title>
</head>

<body>
<section  class="vh-100 login-bg">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-md-4 pb-5">

                            <h2 class="fw-bold mb-2 ">Reset your password</h2>

                            <div class="text-white-50 mb-5"></div>
                            <form action="forget.php" method="post" id="resetForm">
                                <div class="form-outline form-white mb-4">
                                    <label for="resetEmail" class="form-label">Email Address</label>
                                    <input type="text" id="resetEmail" class="form-control form-control-lg"
                                           name="resetEmail">
                                    <small></small>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <label for="resetPassword" class="form-label">Password</label>
                                    <input type="password" id="resetPassword" class="form-control form-control-lg"
                                           name="resetPassword" placeholder="Password (min 8 characters)">
                                    <small></small>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <label for="resetPasswordConfirm" class="form-label">Password Confirm</label>
                                    <input type="password" id="resetPasswordConfirm" class="form-control form-control-lg"
                                           name="resetPasswordConfirm">
                                    <small></small>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="hidden" name="action" value="resetPassword">
                                    <input type="hidden" name="token" value="<?php echo $token ?>">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                    <button type="reset" class="btn btn-primary resetButton" >Cancel</button>
                                </div>

                                </form>

                            <?php
                            $rf = 0;

                            if (isset($_GET["rf"]) and is_numeric($_GET['rf'])) {
                                $rf = (int)$_GET["rf"];

                                if (array_key_exists($rf, $messages)) {
                                    echo '
                                    <div style="font-size: 40px" role="alert">
                                        ' . $messages[$rf] . '
                                        
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