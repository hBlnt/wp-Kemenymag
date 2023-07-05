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
            $_SESSION['lastname'] = '';
            $_SESSION['age'] = '';
            $_SESSION['phone'] = '';

            $_SESSION['biography'] = '';

            $username = trim($_POST["username"]);
            $password = trim($_POST["password"]);

            if (!empty($username) and !empty($password)) {
                $data = checkUserLogin($pdo, $username, $password);

                if ($data and is_int($data['user_id'])) {

                    $_SESSION['usertype'] = 'user';
                    $_SESSION['username'] = $username;
                    $_SESSION['user_id'] = $data['user_id'];
                    $_SESSION['firstname'] = $data['firstname'];
                    $_SESSION['lastname'] = $data['lastname'];
                    $_SESSION['age'] = $data['age'];
                    $_SESSION['phone'] = $data['phone'];
                    //redirection('signIn.php?l=22');
                    redirection('index.php');
                }
                else if ($data and is_int($data['trainer_id'])){
                    //Those who are approved by admin are let in
                    $_SESSION['admin_approval'] = $data['admin_approval'];
                    if($_SESSION['admin_approval'] === 1){
                        $_SESSION['usertype'] = 'trainer';
                        $_SESSION['username'] = $username;
                        $_SESSION['trainer_id'] = $data['trainer_id'];
                        $_SESSION['firstname'] = $data['firstname'];
                        $_SESSION['lastname'] = $data['lastname'];
                        $_SESSION['age'] = $data['age'];
                        $_SESSION['phone'] = $data['phone'];
                        $_SESSION['biography'] = $data['biography'];
                        redirection('index.php');

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
            $comment = trim($_POST["comment"]);
            try{
                existsUserTrainerRating($pdo,$_SESSION['user_id'],$trainer,$score,$comment);
                redirection("trainer.php?uRT=26");
            }catch (Exception $e){
                error_log("****************************************");
                error_log($e->getMessage());
                error_log("file:" . $e->getFile() . " line:" . $e->getLine());
                redirection("trainer.php?uRT=25");
            }

            break;


        case "userListProgram":
            try{
                //existsUserTrainerRating($pdo,$_SESSION['user_id'],$trainer,$score);
                //redirection("user_list_program.php");

                $program = trim($_SESSION["currentProgramID"]);
                insertOngoingProgram($pdo,$_SESSION['user_id'],$program);
                redirection("user_list_program.php?uLP=27");

            }catch (Exception $e){
                error_log("****************************************");
                error_log($e->getMessage());
                error_log("file:" . $e->getFile() . " line:" . $e->getLine());
                redirection("user_list_program.php?uLP=28");
            }

            break;
        case "userMakeProgram":
            try{
                $exercise = $_POST['exercise'];
                $count = $_POST['count'];
                $userID = $_SESSION['user_id'];
                insertUserProgramData($pdo,$exercise,$count,$userID);
                redirection("my_works.php");

            }catch (Exception $e){
                error_log("****************************************");
                error_log($e->getMessage());
                error_log("file:" . $e->getFile() . " line:" . $e->getLine());
                redirection("user_list_program.php?uLP=28");
            }

            break;
        case "userDeleteProgram":
            try{
                $count = $_POST['count'];
                $userID = $_SESSION['user_id'];
                deleteUserProgram($pdo,$userID);
                redirection("my_works.php");

            }catch (Exception $e){
                error_log("****************************************");
                error_log($e->getMessage());
                error_log("file:" . $e->getFile() . " line:" . $e->getLine());
                redirection("user_list_program.php?uLP=28");
            }

            break;

        case "editExercise":
            $availability="";
            $image="";
            if(isset($_POST['title'])){
                $title = trim($_POST["title"]);
            }
            if(isset($_POST['trainer'])){
                $trainer = trim($_POST["trainer"]);
            }
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $image = $_FILES['image'];
            }
            //Checking the error in the errorlog file
            //error_log('Image value: ' . print_r($image, true));

            if(isset($_POST['link'])){
                $link= trim($_POST["link"]);
            }
            if(is_numeric($_POST['availability']) && ($_POST['availability'] == 0 || $_POST['availability'] == 1)){
                $availability= trim($_POST["availability"]);
            }
            if(isset($_POST['unit'])){
                $unit= trim($_POST["unit"]);
            }
            if(isset($_POST['description'])){
                $description = trim($_POST["description"]);
            }
            if(isset($_POST['exerciseId'])){
                $exerciseId = trim($_POST["exerciseId"]);
            }

            try{

                $result = updateExercise($pdo,$title,$trainer,$image,$link,$availability,$unit,$description,$exerciseId);

                if ($result == true)
                    redirection('exercises.php?e=27');
                else
                    redirection('exercises.php?e=28');


            }catch (Exception $e){
                error_log("****************************************");
                error_log($e->getMessage());
                error_log("file:" . $e->getFile() . " line:" . $e->getLine());
                redirection("user_list_program.php?uLP=28");
            }

            break;
        case "deleteExercise":
            if(isset($_POST['exerciseId'])){
                $exerciseId = trim($_POST["exerciseId"]);
            }

            try{
                $result = deleteExercise($pdo,$exerciseId);
                if ($result == true)
                    redirection('exercises.php?e=27');
                else
                    redirection('exercises.php?e=28');

            }catch (Exception $e){
                error_log("****************************************");
                error_log($e->getMessage());
                error_log("file:" . $e->getFile() . " line:" . $e->getLine());
                redirection("user_list_program.php?uLP=28");
            }

            break;
        case "insertExercise":
            /*
                            $creator = "";
                            $title = "";
                            $description = "";
                            $image = "";
                            $link = "";
                            $unit_id ="";
            */

            $creator = $_SESSION['trainer_id'];

            if (isset($_POST['title'])) {
                $title = trim($_POST["title"]);
            }

            if (isset($_POST['description'])) {
                $description = trim($_POST["description"]);
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $image = $_FILES['image'];
            }

            if (isset($_POST['link'])) {
                $link = trim($_POST["link"]);
            }

            if (isset($_POST['unit'])) {
                $unit_id = trim($_POST["unit"]);
            }


            if (empty($creator)) {
                redirection('exercises.php?e=4');
            }

            if (empty($title)) {
                redirection('exercises.php?e=4');
            }

            if (empty($description)) {
                redirection('exercises.php?e=4');
            }
            if (empty($image)) {
                redirection('exercises.php?e=4');
            }

            if (empty($link)) {
                redirection('exercises.php?e=4');
            }

            if (empty($unit_id)) {
                redirection('exercises.php?e=4');
            }

            try{
                if(!existsExercise($pdo,$title)){

                    $result = insertExercise($pdo,$title,$creator,$image,$link,$unit_id,$description);
                    if ($result == true)
                        redirection('exercises.php?e=27');
                    else
                        redirection('exercises.php?e=28');
                }
                else{
                    redirection('exercises.php?e=2');

                }

            }catch (Exception $e){
                error_log("****************************************");
                error_log($e->getMessage());
                error_log("file:" . $e->getFile() . " line:" . $e->getLine());
                redirection('exercises.php?e=28');
            }

            break;


        case "edit" :

            if(isset($_POST['firstname'])) {
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
            if (isset($_POST['age'])) {
                $age = trim($_POST["age"]);
            }
            if (isset($_POST['phone'])) {
                $phone = trim($_POST["phone"]);
            }
            if($_SESSION['usertype'] === 'trainer') {
                if (isset($_POST['biography'])) {
                    $biography = trim($_POST["biography"]);
                }
            }

            if(empty($firstname) && empty($lastname) && empty($password) && empty($passwordConfirm) && empty($age) && empty($phone) && empty($biography))
                redirection('editprofile.php?e=30');

            if (!empty($password) && strlen($password) < 8) {
                redirection('editprofile.php?e=10');
            }

           /* if (!empty($password) || !empty($passwordConfirm) || $password !== $passwordConfirm) {
                redirection('editprofile.php?e=7');
            }*/

            try{
                if($_SESSION['usertype'] === 'user') {
                    $result = editUser($pdo, $password, $firstname, $lastname, $age, $phone, $_SESSION['user_id']);
                    if ($result == true)
                        redirection('editprofile.php?e=31');
                    else
                        redirection('editprofile.php?e=29');
                }
                else if($_SESSION['usertype'] === 'trainer')
                {
                    $result = editTrainer($pdo, $password, $firstname, $lastname, $age, $phone,$biography, $_SESSION['trainer_id']);
                    if ($result == true)
                        redirection('editprofile.php?e=31');
                    else
                        redirection('editprofile.php?e=29');
                }
                else
                    redirection('editprofile.php?e=29');
            }
            catch (Exception $ex)
            {
                error_log("****************************************");
                error_log($ex->getMessage());
                error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
                redirection('editprofile.php?e=1');
            }

            break;

        case "deleteTrainerProgram":
            //if(isset($_POST['programId'])){
            //    $programId = trim($_POST["programId"]);
            //}
            $programIds = $_SESSION['program_ids'];
            try{
                $programId = $programIds[$_POST['index']];
                $result = deleteTrainerProgram($pdo,$programId);
                if ($result == true)
                    redirection('trainerProgramList.php?e=27');
                else
                    redirection('trainerProgramList.php?e=28');

            }catch (Exception $e){
                error_log("****************************************");
                error_log($e->getMessage());
                error_log("file:" . $e->getFile() . " line:" . $e->getLine());
                redirection("user_list_program.php?uLP=28");
            }

            break;
        case "trainerMakeProgram":
            $currentProgramId = $_SESSION['current_program_id'];
            $programDay = $_SESSION['programDay'];
            /*
                            $exercise1 = "";
                            $exercise2 = "";
                            $exercise3 = "";
                            $exercise4 = "";
                            $exercise5 = "";
                            $exercise6 = "";
                            $exercise7 = "";

                            $count1 = "";
                            $count2 = "";
                            $count3 = "";
                            $count4 = "";
                            $count5 = "";
                            $count6 = "";
                            $count7 = "";

                            if (isset($_POST['exercise1'])) {
                                $exercise1 = trim($_POST["exercise1"]);
                            }

                            if (isset($_POST['exercise2'])) {
                                $exercise2 = trim($_POST["exercise2"]);
                            }

                            if (isset($_POST['exercise3'])) {
                                $exercise3 = trim($_POST["exercise3"]);
                            }

                            if (isset($_POST['exercise4'])) {
                                $exercise4 = trim($_POST["exercise4"]);
                            }

                            if (isset($_POST['exercise5'])) {
                                $exercise5 = trim($_POST["exercise5"]);
                            }

                            if (isset($_POST['exercise6'])) {
                                $exercise6 = trim($_POST["exercise6"]);
                            }

                            if (isset($_POST['exercise7'])) {
                                $exercise7 = trim($_POST["exercise7"]);
                            }


                            if (isset($_POST['count1'])) {
                                $count1 = trim($_POST["exercise1"]);
                            }

                            if (isset($_POST['count2'])) {
                                $count2 = trim($_POST["count2"]);
                            }

                            if (isset($_POST['count3'])) {
                                $count3 = trim($_POST["count3"]);
                            }

                            if (isset($_POST['count4'])) {
                                $count4 = trim($_POST["count4"]);
                            }

                            if (isset($_POST['count5'])) {
                                $count5 = trim($_POST["count5"]);
                            }

                            if (isset($_POST['count6'])) {
                                $count6 = trim($_POST["count6"]);
                            }

                            if (isset($_POST['count7'])) {
                                $count7 = trim($_POST["count7"]);
                            }
            */
            try{
                foreach ($programDay as $index => $day) {
                    if (isset($_POST['exercise' . $day])) {
                        $exercises = $_POST['exercise' . $day];
                        $counts = $_POST['count' . $day];

                        for ($i = 0; $i < count($exercises); $i++) {
                            $exerciseId = $exercises[$i];
                            $count = $counts[$i];

                            $sql = 'INSERT INTO programs_exercises (program_id, exercise_id, day_id, count) VALUES (?, ?, ?, ?)';
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([$currentProgramId, $exerciseId, $day, $count]);
                        }
                    }
                }
                redirection("trainerProgramList.php?e=27");


            }catch (Exception $e){
                error_log("****************************************");
                error_log($e->getMessage());
                error_log("file:" . $e->getFile() . " line:" . $e->getLine());
                redirection("user_list_program.php?uLP=28");
            }

            break;


        default:
            redirection('signIn.php?l=1');
            break;


    }

} else {
    redirection('signIn.php?l=1');
}
