<?php
require_once 'db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>


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
                <h2 class="title">Registration Form</h2>
                <form action="web.php" method="post" id="registerForm">
                    <div class="row row-space">
                        <div class="col-2">
                            <div class="input-group">
                                <label for="registerEmail" class="label">Email</label>
                                <input class="input--style-4"
                                       type="text" id="registerEmail" name="email">
                                <small></small>

                            </div>
                        </div>

                        <div class="col-2">
                            <div class="input-group">
                                <label for="registerAge" class="label">Age</label>
                                <input class="input--style-4"
                                       type="text" id="registerAge" name="age">
                                <small></small>
                            </div>
                        </div>


                    </div>
                    <div class="row row-space">
                        <div class="col-2">
                            <div class="input-group">
                                <label for="registerFirstname" class="label">first name</label>
                                <input class="input--style-4"
                                       type="text" id="registerFirstname" name="firstname">
                                <small></small>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <label for="registerLastname" class="label">last name</label>
                                <input class="input--style-4"
                                       type="text" id="registerLastname" name="lastname">
                                <small></small>
                            </div>
                        </div>
                    </div>
                    <div class="row row-space">
                        <div class="col-2">
                            <div class="input-group">
                                <label for="registerPassword" class="label">password</label>
                                <input class="input--style-4"
                                       type="password" id="registerPassword" name="password">
                                <small></small>
                                <span id="strengthDisp" class="badge displayBadge"></span>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="input-group">
                                <label for="registerPasswordConfirm" class="label">password confirm</label>
                                <input class="input--style-4"
                                       type="password" id="registerPasswordConfirm" name="passwordConfirm">
                                <small></small>
                            </div>
                        </div>

                    </div>
                    <div class="row row-space">

                        <div class="col-2">
                            <div class="input-group">
                                <label  for="registerPhone" class="label">Phone Number</label>
                                <input class="input--style-4" type="text" id="registerPhone" name="phone">
                                <small></small>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <label class="label">Gender</label>
                                <div class="p-t-10" id="registerGender">
                                    <label for="registerGenderMale" class="radio-container m-r-45">Male
                                        <input type="radio" name="gender" id="registerGenderMale" value="0">
                                        <small></small>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label for="registerGenderFemale" class="radio-container">Female
                                        <input type="radio" name="gender" id="registerGenderFemale" value="1">
                                        <small></small>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <small></small>
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <label class="label">Register as:</label>
                        <div class="p-t-10" id="registerUserType">
                            <label class="radio-container m-r-45">User
                                <input id="registerUserTypeUser" type="radio" onclick="hideInput()" name="usertype" value="user">
                                <span class="checkmark"></span>
                            </label>
                            <label class="radio-container">Trainer
                                <input id="registerUserTypeTrainer" type="radio" onclick="showInput()" name="usertype" value="trainer">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <small></small>
                    </div>

                    <div id="additional-input" class="row row-space" style="display: none;">
                        <label for="registerTrainerBiography" class="label">Biography:</label>
                        <textarea id="registerTrainerBiography" rows="10" cols="40" name="biography"></textarea>
                        <small></small>
                    </div>

                    <div class="p-t-15">
                        <input type="hidden" name="action" value="register">
                        <button type="submit" class="btn btn--radius-2 btn--blue" id="register" >Register</button>


<!--                        <button type="submit" formaction="signIn.php" class="btn btn--radius-2 btn--blue" >Log in page</button>-->
                        <a href="signIn.php" class="btn btn--radius-2 btn--blue" style="text-decoration: none">Login page</a>
                    </div>

                </form>

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
                ?>
        </div>
    </div>
</div>

</body>
</html>