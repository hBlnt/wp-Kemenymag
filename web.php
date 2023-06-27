    <?php
    session_start();
    require_once "db_config.php";
    require_once "functions_def.php";

    $password = "";
    $passwordConfirm = "";
    $firstname = "";
    $lastname = "";
    $email = "";

    $phone="";
    $age="";
    $gender="";

    $usertype="";

    $biography="";
    $score ="";
    $action = "";

    $referer = $_SERVER['HTTP_REFERER'];


    $action = $_POST["action"];

    if ($action != "" and in_array($action, $actions) and strpos($referer, SITE) !== false ) {


        switch ($action) {
            case "login":

                $_SESSION['usertype'] = $usertype;

                $_SESSION['firstname'] = '';

                $username = trim($_POST["username"]);
                $password = trim($_POST["password"]);

                if (!empty($username) and !empty($password)) {
                    $data = checkUserLogin($pdo, $username, $password);

                    if ($data and is_int($data['user_id'])) {

                        $_SESSION['usertype'] = 'user';
                        $_SESSION['username'] = $username;
                        $_SESSION['user_id'] = $data['user_id'];
                        $_SESSION['firstname'] = $data['firstname'];
                        //redirection('signIn.php?l=22');
                        redirection('mainPage.php');
                    }
                    else if ($data and is_int($data['trainer_id'])){
                        //Those who are approved by admin are let in
                        $_SESSION['admin_approval'] = $data['admin_approval'];
                        if($_SESSION['admin_approval'] === 1){
                            $_SESSION['usertype'] = 'trainer';
                            $_SESSION['username'] = $username;
                            $_SESSION['trainer_id'] = $data['trainer_id'];
                            $_SESSION['firstname'] = $data['firstname'];
                            redirection('mainPage.php');

                            redirection('signIn.php?l=23');
                        }else{
                            redirection('signIn.php?l=24&admin_approval=' . $_SESSION['admin_approval']);
                        }

                    }
                    else {
                        redirection('signIn.php?l=1');
                    }

                } else {
                    redirection('signIn.php?l=1');
                }
                break;


            case "register" :

                if (isset($_POST['usertype'])) {
                    $usertype = trim($_POST["usertype"]);
                }

                $_SESSION['usertype'] = $usertype;

                if (isset($_POST['gender'])) {
                    $gender = trim($_POST["gender"]);
                }

                if (isset($_POST['phone'])) {
                    $phone = trim($_POST["phone"]);
                }

                if (isset($_POST['age'])) {
                    $age = trim($_POST["age"]);
                }

                if (isset($_POST['firstname'])) {
                    $firstname = trim($_POST["firstname"]);
                }

                if (isset($_POST['lastname'])) {
                    $lastname = trim($_POST["lastname"]);
                }

                if (isset($_POST['password'])) {
                    $password = trim($_POST["password"]);
                }

                if (isset($_POST['passwordConfirm'])) {
                    $passwordConfirm = trim($_POST["passwordConfirm"]);
                }

                if (isset($_POST['email'])) {
                    $email = trim($_POST["email"]);
                }

                if (empty($age)) {
                    redirection('register.php?r=18');
                }
                if (!isset($gender) || $gender === "") {
                    redirection('register.php?r=19');
                }
                if (empty($phone)) {
                    redirection('register.php?r=18');
                }
                if (empty($usertype)) {
                    redirection('register.php?r=20');
                }
                if($usertype === "trainer"){
                    if (isset($_POST['biography'])) {
                        $biography = trim($_POST["biography"]);
                    }
                    if (empty($biography)) {
                        redirection('register.php?r=21');
                    }
                }

                if (empty($firstname)) {
                    redirection('register.php?r=4');
                }

                if (empty($lastname)) {
                    redirection('register.php?r=4');
                }

                if (empty($password)) {
                    redirection('register.php?r=9');
                }

                if (strlen($password) < 8) {
                    redirection('register.php?r=10');
                }

                if (empty($passwordConfirm)) {
                    redirection('register.php?r=9');
                }

                if ($password !== $passwordConfirm) {
                    redirection('register.php?r=7');
                }

                if (empty($email) or !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    redirection('register.php?r=8');
                }

                if($usertype=== "user"){
                    //Making sure that the e-mail is not taken by either a user or a trainer
                    if ((!existsUser($pdo, $email)) && (!existsTrainer($pdo,$email))) {
                        $token = createToken(20);
                        if ($token) {
                            $id_user = registerUser($pdo, $password, $firstname, $lastname, $email, $token,$age,$phone,$gender);
                            try {
                                $body = "Your username is $email. To activate your account click on the <a href=" . SITE . "active.php?token=$token   >link</a>";
                                sendEmail($pdo, $email, $emailMessages['register'], $body, $id_user);
                                redirection("register_authentication.php?r=3");
                            } catch (Exception $e) {
                                error_log("****************************************");
                                error_log($e->getMessage());
                                error_log("file:" . $e->getFile() . " line:" . $e->getLine());
                                redirection("register_authentication.php?r=11");
                            }
                        }
                    } else {
                        redirection('register.php?r=2');
                    }

                }
                else{
                    //Making sure that the e-mail is not taken by either a user or a trainer
                    if ((!existsTrainer($pdo, $email)) && (!existsUser($pdo, $email))) {
                        $token = createToken(20);
                        if ($token) {
                            $id_user = registerTrainer($pdo, $password, $firstname, $lastname, $email, $token,$age,$phone,$gender,$biography);
                            try {
                                $body = "You are a trainer, username is $email. To activate your account click on the <a href=" . SITE . "active.php?token=$token>link</a>";
                                sendEmail($pdo, $email, $emailMessages['register'], $body, $id_user);
                                redirection("register_authentication.php?r=3");
                            } catch (Exception $e) {
                                error_log("****************************************");
                                error_log($e->getMessage());
                                error_log("file:" . $e->getFile() . " line:" . $e->getLine());
                                redirection("register_authentication.php?r=11");
                            }
                        }
                    } else {
                        redirection('register.php?r=2');
                    }

                }
                break;


            case "forget" :
                $email = trim($_POST["email"]);
                //((!existsUser($pdo, $email)) && (!existsTrainer($pdo,$email)))
                if (!empty($email) and getUserData($pdo, 'user_id', 'email', $email)) {
                    $token = createToken(20);
                    if ($token) {
                        setForgottenToken($pdo, 'user', $email, $token);
                        $id_user = getUserData($pdo, 'user_id', 'email', $email);
                        try {
                            $body = "You are a User.<br>To start the process of changing password, visit <a href=" . SITE . "forget.php?token=$token>link</a>.";
                            sendEmail($pdo, $email, $emailMessages['forget'], $body, $id_user);
                            redirection('forgotPassword.php?f=13');
                        } catch (Exception $e) {
                            error_log("****************************************");
                            error_log($e->getMessage());
                            error_log("file:" . $e->getFile() . " line:" . $e->getLine());
                            redirection("forgotPassword.php?f=11");
                        }
                    } else {
                        redirection('forgotPassword.php?f=14');
                    }
                }
                else if(!empty($email) and getTrainerData($pdo, 'trainer_id', 'email', $email)){
                    $token = createToken(20);
                    if ($token) {
                        setForgottenToken($pdo, 'trainer', $email, $token);
                        $id_user = getTrainerData($pdo, 'trainer_id', 'email', $email);
                        try {
                            $body = "You are a Trainer.<br>To start the process of changing password, visit <a href=" . SITE . "forget.php?token=$token>link</a>.";
                            sendEmail($pdo, $email, $emailMessages['forget'], $body, $id_user);
                            redirection('forgotPassword.php?f=13');
                        } catch (Exception $e) {
                            error_log("****************************************");
                            error_log($e->getMessage());
                            error_log("file:" . $e->getFile() . " line:" . $e->getLine());
                            redirection("forgotPassword.php?f=11");
                        }
                    } else {
                        redirection('forgotPassword.php?f=14');
                    }

                }
                else {
                    redirection('forgotPassword.php?f=13');
                }
                break;
            case "userRatingTrainer":
                $score = trim($_POST["score"]);
                $trainer = trim($_POST["trainer_id"]);
                try{
                    existsUserTrainerRating($pdo,$_SESSION['user_id'],$trainer,$score);
                    redirection("trainer.php?uRT=26");
                }catch (Exception $e){
                    error_log("****************************************");
                    error_log($e->getMessage());
                    error_log("file:" . $e->getFile() . " line:" . $e->getLine());
                    redirection("trainer.php?uRT=25");
                }

                break;

            default:
                redirection('register.php?r=0');
                break;
        }

    } else {
        redirection('signIn.php?l=1');
    }
