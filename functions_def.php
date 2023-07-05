<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require_once "db_config.php";

$pdo = connectDatabase($dsn, $pdoOptions);

/** Function tries to connect to database using PDO
 * @param string $dsn
 * @param array $pdoOptions
 * @return PDO
 */
function connectDatabase(string $dsn, array $pdoOptions): PDO
{

    try {
        $pdo = new PDO($dsn, PARAMS['USER'], PARAMS['PASS'], $pdoOptions);

    } catch (\PDOException $e) {
        var_dump($e->getCode());
        throw new \PDOException($e->getMessage());
    }

    return $pdo;
}


/**
 * Function redirects user to given url
 *
 * @param string $url
 */
function redirection($url)
{
    header("Location:$url");
    exit();
}


/**
 * Function checks that login parameters exists in users_web table
 *
 * @param PDO $pdo
 * @param string $email
 * @param string $enteredPassword
 * @return array
 */
function checkUserLogin(PDO $pdo, string $email, string $enteredPassword): array
{
    $sqlUser = "SELECT user_id, user_password,firstname,lastname,age,phone FROM user WHERE email=:email AND active=1 AND is_banned = 0 LIMIT 0,1";
    $sqlTrainer = "SELECT trainer_id, trainer_password, admin_approval,firstname,lastname,age,phone,biography FROM trainer WHERE email=:email AND active=1 AND is_banned = 0 LIMIT 0,1";

    $stmtUser = $pdo->prepare($sqlUser);
    $stmtUser->bindParam(':email', $email, PDO::PARAM_STR);

    $stmtTrainer = $pdo->prepare($sqlTrainer);
    $stmtTrainer->bindParam(':email', $email, PDO::PARAM_STR);


    $data = [];

    $stmtUser->execute();
    $stmtTrainer->execute();
    if($stmtUser->rowCount() > 0){
        $result = $stmtUser->fetch(PDO::FETCH_ASSOC);

    }else if($stmtTrainer->rowCount() > 0){
        $result = $stmtTrainer->fetch(PDO::FETCH_ASSOC);

    }
    $data['firstname'] = $result['firstname'];
    $data['lastname'] = $result['lastname'];
    $data['age'] = $result['age'];
    $data['phone'] = $result['phone'];

    $data['biography'] = $result['biography'];

    //$result = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if ($stmtUser->rowCount() > 0) {

        $registeredPassword = $result['user_password'];

        if (password_verify($enteredPassword, $registeredPassword)) {
            $data['user_id'] = $result['user_id'];
        }
    }
    else if($stmtTrainer->rowCount() > 0){

        $registeredPassword = $result['trainer_password'];

        if (password_verify($enteredPassword, $registeredPassword)) {
            $data['trainer_id'] = $result['trainer_id'];
            $data['admin_approval'] = $result['admin_approval'];

        }
    }

    return $data;
}


/**
 * Function checks that user exists in users table
 * @param PDO $pdo
 * @param string $email
 * @return bool
 */
function existsUser(PDO $pdo, string $email): bool
{

    $sql = "SELECT user_id FROM user WHERE email=:email AND (registration_token_expiry>now() OR active ='1') LIMIT 0,1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

function existsTrainer(PDO $pdo, string $email): bool
{

    $sql = "SELECT trainer_id FROM trainer WHERE email=:email AND (registration_token_expiry>now() OR active ='1') LIMIT 0,1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}


/**Function registers user and returns id of created user
 * @param PDO $pdo
 * @param string $password
 * @param string $firstname
 * @param string $lastname
 * @param string $email
 * @param string $token
 * @return int
 */
function registerUser(PDO $pdo, string $password, string $firstname, string $lastname, string $email, string $token,string $age,string $phone,string $gender): int
{

    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user(user_password,firstname,lastname,email,registration_token, registration_token_expiry,active,age,phone,gender)
            VALUES (:passwordHashed,:firstname,:lastname,:email,:token,DATE_ADD(now(),INTERVAL 1 DAY),0,:age,:phone,:gender)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':passwordHashed', $passwordHashed, PDO::PARAM_STR);
    $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->bindParam(':age', $age, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->execute();

    // http://dev.mysql.com/doc/refman/5.6/en/date-and-time-functions.html

    return $pdo->lastInsertId();

}

function registerTrainer(PDO $pdo, string $password, string $firstname, string $lastname, string $email, string $token,string $age,string $phone,string $gender, string $biography): int
{

    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO trainer(trainer_password,firstname,lastname,email,registration_token, registration_token_expiry,active,age,phone,gender,biography)
            VALUES (:passwordHashed,:firstname,:lastname,:email,:token,DATE_ADD(now(),INTERVAL 1 DAY),0,:age,:phone,:gender,:biography)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':passwordHashed', $passwordHashed, PDO::PARAM_STR);
    $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->bindParam(':age', $age, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':biography', $biography, PDO::PARAM_STR);
    $stmt->execute();

    // http://dev.mysql.com/doc/refman/5.6/en/date-and-time-functions.html

    return $pdo->lastInsertId();

}

function editUser(PDO $pdo, string $password, string $firstname, string $lastname, string $age, string $phone, string $id): bool
{
    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE user SET ";

    $updateFields = [];
    $params = [];

    if (!empty($password)) {
        $updateFields[] = "user_password = :passwordHashed";
        $params[':passwordHashed'] = $passwordHashed;
    }

    if (!empty($firstname)) {
        $updateFields[] = "firstname = :firstname";
        $params[':firstname'] = $firstname;
    }

    if (!empty($lastname)) {
        $updateFields[] = "lastname = :lastname";
        $params[':lastname'] = $lastname;
    }

    if (!empty($age)) {
        $updateFields[] = "age = :age";
        $params[':age'] = $age;
    }

    if (!empty($phone)) {
        $updateFields[] = "phone = :phone";
        $params[':phone'] = $phone;
    }

    if (empty($updateFields)) {
        return false; // No fields to update
    }

    $sql .= implode(", ", $updateFields);
    $sql .= " WHERE user_id = :id";
    $params[':id'] = $id;

    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute($params);
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }

}

function editTrainer(PDO $pdo, string $password, string $firstname, string $lastname, string $age, string $phone,string $biography, string $id): bool
{
    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE trainer SET ";

    $updateFields = [];
    $params = [];

    if (!empty($password)) {
        $updateFields[] = "trainer_password = :passwordHashed";
        $params[':passwordHashed'] = $passwordHashed;
    }

    if (!empty($firstname)) {
        $updateFields[] = "firstname = :firstname";
        $params[':firstname'] = $firstname;
    }

    if (!empty($lastname)) {
        $updateFields[] = "lastname = :lastname";
        $params[':lastname'] = $lastname;
    }

    if (!empty($age)) {
        $updateFields[] = "age = :age";
        $params[':age'] = $age;
    }

    if (!empty($phone)) {
        $updateFields[] = "phone = :phone";
        $params[':phone'] = $phone;
    }

    if (!empty($biography)) {
        $updateFields[] = "biography = :biography";
        $params[':biography'] = $biography;
    }

    if (empty($updateFields)) {
        return false; // No fields to update
    }

    $sql .= implode(", ", $updateFields);
    $sql .= " WHERE trainer_id = :id";
    $params[':id'] = $id;

    $stmt = $pdo->prepare($sql);


    try {
        $stmt->execute($params);
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }

}

/** Function creates random token for given length in bytes
 * @param int $length
 * @return string|null
 */
function createToken(int $length): ?string
{
    try {
        return bin2hex(random_bytes($length));
    } catch (\Exception $e) {
        // c:xampp/apache/logs/
        error_log("****************************************");
        error_log($e->getMessage());
        error_log("file:" . $e->getFile() . " line:" . $e->getLine());
        return null;
    }
}

/**
 * Function creates code with given length and returns it
 *
 * @param $length
 * @return string
 */
function createCode($length): string
{
    $down = 97;
    $up = 122;
    $i = 0;
    $code = "";

    /*
      48-57  = 0 - 9
      65-90  = A - Z
      97-122 = a - z
    */

    $div = mt_rand(3, 9); // 3

    while ($i < $length) {
        if ($i % $div == 0)
            $character = strtoupper(chr(mt_rand($down, $up)));
        else
            $character = chr(mt_rand($down, $up)); // mt_rand(97,122) chr(98)
        $code .= $character; // $code = $code.$character; //
        $i++;
    }
    return $code;
}


/** Function tries to send email with activation code
 * @param PDO $pdo
 * @param string $email
 * @param array $emailData
 * @param string $body
 * @param int $id_user
 * @return void
 */

const GMailUSEREmail = 'personaltrainerhelp2023@gmail.com'; // your username on gmail
const GoogleAppsPassword = 'ybyvuesekrtnjjbb'; // you password for created APP

function sendEmail(PDO $pdo, string $email, array $emailData, string $body, int $id_user): void
{

    $toEmail =$email ;
    $subject = $emailData['subject'];
    $from = 'personaltrainerhelp2023@gmail.com';
    $fromName = 'Personal Trainer';


    try {
        $phpmailer = new PHPMailer(true);
        $phpmailer->IsSMTP();
        $phpmailer->SMTPDebug = 0;
        $phpmailer->SMTPAuth = true;
        $phpmailer->SMTPSecure = 'ssl';
        $phpmailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $phpmailer->Host = 'smtp.gmail.com';
        $phpmailer->Port = 465;
        $phpmailer->Username = GMailUSEREmail;
        $phpmailer->Password = GoogleAppsPassword;
        $phpmailer->SetFrom($from, $fromName);
        $phpmailer->isHTML(true);
        $phpmailer->Subject = $subject;
        $phpmailer->Body = $body;

        $phpmailer->AltBody = $emailData['altBody'];
        $phpmailer->AddAddress($toEmail);
        $phpmailer->send();
    } catch (Exception $e) {
        $message = "Message could not be sent. Mailer Error: {$phpmailer->ErrorInfo}";
        addEmailFailure($pdo, $id_user, $message);
    }

}
/*
function sendEmail(PDO $pdo, string $email, array $emailData, string $body, int $id_user): void
{

    $phpmailer = new PHPMailer(true);

    try {


        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = '5c1241c4bb377d';
        $phpmailer->Password = 'a7b5078ba5570d';


        $phpmailer->setFrom('matkovity77@gmail.com', 'Gabor');
        $phpmailer->addAddress("$email");

        $phpmailer->isHTML(true);
        $phpmailer->Subject = $emailData['subject'];
        $phpmailer->Body = $body;
        $phpmailer->AltBody = $emailData['altBody'];

        $phpmailer->send();
    } catch (Exception $e) {
        $message = "Message could not be sent. Mailer Error: {$phpmailer->ErrorInfo}";
        addEmailFailure($pdo, $id_user, $message);
    }

}
*/

/**
 * @param PDO $pdo
 * @param string $email
 * @return bool
 * @throws Exception
 */
function sendForgetPasswordToken(PDO $pdo, string $email): bool
{
    $token = createToken(20);


    return true;
}


/** Function inserts data in database for e-mail sending failure
 * @param PDO $pdo
 * @param int $id_user
 * @param string $message
 * @return void
 */
function addEmailFailure(PDO $pdo, int $id_user, string $message): void
{
    $sql = "INSERT INTO user_email_failures (user_id, message, date_time_added)
            VALUES (:id_user,:message, now())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);
    $stmt->execute();

}


/**
 * Function returns user data for given field and given value
 * @param PDO $pdo
 * @param string $data
 * @param string $field
 * @param mixed $value
 * @return mixed
 */
function getUserData(PDO $pdo, string $data, string $field, string $value): string
{
    $sql = "SELECT $data as data FROM user WHERE $field=:value LIMIT 0,1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':value', $value, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $data = '';

    if ($stmt->rowCount() > 0) {
        $data = $result['data'];
    }

    return $data;
}

function getTrainerData(PDO $pdo, string $data, string $field, string $value): string
{
    $sql = "SELECT $data as data FROM trainer WHERE $field=:value LIMIT 0,1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':value', $value, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $data = '';

    if ($stmt->rowCount() > 0) {
        $data = $result['data'];
    }

    return $data;
}

/**
 * Function sets the forgotten token
 * @param PDO $pdo
 * @param string $email
 * @param string $token
 * @return void
 */

function setForgottenToken(PDO $pdo, string $table, string $email, string $token): void
{
    $sql = "UPDATE $table SET forgotten_password_token = :token, forgotten_password_expires = DATE_ADD(now(),INTERVAL 6 HOUR) WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
}

function existsUserTrainerRating(PDO $pdo, string $user_id, string $trainer_id, string $score, string $comment): bool
{
    //We select user and trainer, and check if there is already a pair in trainer_rating table

    $sql = "SELECT user_id,trainer_id FROM trainer_rating WHERE trainer_id = :trainer_id AND user_id = :user_id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':trainer_id', $trainer_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $stmt->fetch(PDO::FETCH_ASSOC);

    //if there is we only update it if there isn't we insert

    if ($stmt->rowCount() > 0) {
        $sqlRating = "UPDATE trainer_rating SET score = :score, comment =:comment WHERE user_id = :user_id AND trainer_id = :trainer_id";
    } else {
        $sqlRating = "INSERT INTO trainer_rating (trainer_id, user_id, score,comment) VALUES (:trainer_id, :user_id, :score, :comment)";
    }

    $stmtRating = $pdo->prepare($sqlRating);
    $stmtRating->bindParam(':trainer_id', $trainer_id);
    $stmtRating->bindParam(':user_id', $user_id);
    $stmtRating->bindParam(':score', $score);
    $stmtRating->bindParam(':comment', $comment);

    return $stmtRating->execute();
}
//Testing function
//existsUserTrainerRating($pdo,'18','3','2');

function programInUsage(PDO $pdo, string $user_id, string $trainer_id): bool
{
    $sqlOngoingProgramListing = "SELECT pc.trainer_id FROM program_creators pc 
                                INNER JOIN programs p ON pc.p_creator_id = p.creator_id 
                                INNER JOIN ongoing_programs op ON p.program_id = op.program_id 
                                 WHERE op.user_id = :user_id AND pc.trainer_id = :trainer_id; ";
    $stmt = $pdo->prepare($sqlOngoingProgramListing);

    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':trainer_id', $trainer_id);
    $stmt->execute();
    $trainerFound = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($trainerFound !== false) {
        return true;
    } else {
        return false;
    }
}

function insertOngoingProgram(PDO $pdo, string $user_id, string $program_id):bool
{
    $sql = "SELECT user_id,program_id,in_usage FROM ongoing_programs WHERE user_id = :user_id AND program_id = :program_id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':program_id', $program_id);
    $stmt->execute();
    $foundRow = $stmt->fetch(PDO::FETCH_ASSOC);

    // we only change inusage if we find a row
    // if we got 0 for inusage we update it to 1 meaning they start the program again
    // if inusage is 1, we update it to 0 meaning the user isnt using the program currently
    // else we insert a new ongoing program
    if ($foundRow) {
        if ($foundRow['in_usage'] == 0) {
            $sqlProgramUsage = "UPDATE ongoing_programs SET in_usage = '1' WHERE user_id = :user_id AND program_id = :program_id;";
        } elseif ($foundRow['in_usage'] == 1) {
            $sqlProgramUsage = "UPDATE ongoing_programs SET in_usage = '0' WHERE user_id = :user_id AND program_id = :program_id;";
        }
    } else {
        $sqlProgramUsage = "INSERT INTO ongoing_programs (program_id, user_id, in_usage) VALUES (:program_id, :user_id, '1');";
    }

    $stmtProgramUsage = $pdo->prepare($sqlProgramUsage);
    $stmtProgramUsage->bindParam(':program_id',  $program_id);
    $stmtProgramUsage->bindParam(':user_id', $user_id);
    $stmtProgramUsage->execute();

    if(!$foundRow){
        $sqlPopularityUpdate = "UPDATE programs SET popularity = popularity + 1 WHERE program_id = :program_id";
        $stmtPopularityUpdate = $pdo->prepare($sqlPopularityUpdate);
        $stmtPopularityUpdate->bindParam(':program_id',  $program_id);
        $stmtPopularityUpdate->execute();

    }

    return true;
}

function checkProgramInUsage(PDO $pdo, string $user_id, string $program_id):string
{
    $sql = "SELECT in_usage FROM ongoing_programs WHERE user_id = :user_id AND program_id = :program_id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':program_id', $program_id);
    $stmt->execute();

    $foundRow = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($foundRow) {
        if ($foundRow['in_usage'] == 0) {
            return "Start our program again.";
        } elseif ($foundRow['in_usage'] == 1) {
            return "Stop using this program.";
        }
    }

    return "Start our program.";
}

function programPopularity(PDO $pdo, string $program_id, string $trainer_id):int
{
    $popularity = 0;
    $sql = "SELECT p.popularity FROM programs p
            INNER JOIN program_creators pc ON pc.p_creator_id = p.creator_id
            WHERE pc.trainer_id  =:trainer_id AND p.program_id= :program_id
            ;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':trainer_id', $trainer_id);
    $stmt->bindParam(':program_id', $program_id);
    $stmt->execute();
    $foundRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if($foundRow){
        $popularity = $foundRow['popularity'];
    }
    return $popularity;
}

function insertUserProgram(PDO $pdo, string $user_id):bool
{
    $sql = "INSERT INTO user_programs (user_id) VALUES (:user_id);";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

    return $stmt->execute();
}
function insertUserProgramData(PDO $pdo, $exercises,$counts, $user_id )
{
    if (!empty($exercises) && count($exercises) === count($counts)) {
        foreach ($exercises as $key => $exerciseId) {
            $count = $counts[$key];

            $sql = 'INSERT INTO user_programs_exercises (exercise_id, user_programs_id, count) 
                    SELECT :exercise_id, up.user_programs_id, :count
                    FROM user_programs up
                    WHERE up.user_id = :user_id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':exercise_id', $exerciseId);
            $stmt->bindParam(':count', $count);
            $stmt->execute();
        }
    }
}
function deleteUserProgram(PDO $pdo, string $user_id):bool
{
    $sql = "DELETE FROM user_programs WHERE user_id = :user_id;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    return $stmt->execute();
}
function userProgramExists(PDO $pdo, string $user_id):bool
{
    $sql = "SELECT * FROM user_programs WHERE user_id = :user_id;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}
function updateExercise(PDO $pdo, string $title, string $trainer, $image, string $link, string $availability, string $unit, string $description, string $exerciseId):bool
{
    $sql = "UPDATE exercises SET ";

    $directory = 'db-pics/';
    $updateFields = [];
    $params = [];

    if (!empty($title)) {
        $updateFields[] = "title = :title";
        $params[':title'] = $title;
    }

    if (!empty($trainer)) {
        $updateFields[] = "creator_id = :trainer";
        $params[':trainer'] = $trainer;
    }

    if (!empty($image)) {

        if (move_uploaded_file($image['tmp_name'], $directory . $image['name'])) {
            $updateFields[] = "image = :image";
            $params[':image'] = $directory . $image['name'];
        } else {
            return false;
        }
    }

    if (!empty($link)) {
        $updateFields[] = "link = :link";
        $params[':link'] = $link;
    }

    if (is_numeric($availability) && ($availability == 0 || $availability == 1)) {
        $updateFields[] = "availability = :availability";
        $params[':availability'] = $availability;
    }

    if (!empty($unit)) {
        $updateFields[] = "unit_id = :unit";
        $params[':unit'] = $unit;
    }

    if (!empty($description)) {
        $updateFields[] = "description = :description";
        $params[':description'] = $description;
    }

    if (empty($updateFields)) {
        return false; // No fields to update
    }

    $sql .= implode(", ", $updateFields);
    $sql .= " WHERE exercise_id = :id";
    $params[':id'] = $exerciseId;

    $stmt = $pdo->prepare($sql);


    try {
        $stmt->execute($params);
        return true;
    } catch (PDOException $ex) {
        error_log("******************FUNCTIONERROR**********************");
        error_log($ex->getMessage());
        error_log("file:" . $ex->getFile() . " line:" . $ex->getLine());
        return false;
    }
}
function deleteExercise(PDO $pdo, string $exerciseId):bool
{
    $sql = "DELETE FROM exercises WHERE exercise_id = :exerciseId;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':exerciseId', $exerciseId, PDO::PARAM_STR);
    return $stmt->execute();
}
function insertExercise(PDO $pdo, string $title, string $trainer, $image, string $link, string $unit, string $description):bool
{

    $directory = 'db-pics/';
    if (move_uploaded_file($image['tmp_name'], $directory . $image['name'])) {
        $imageParam = $directory . $image['name'];
    }
    $sql = "INSERT INTO `exercises` (`creator_id`, `title`, `description`, `image`, `link`, `availability`, `unit_id`) 
                            VALUES  (:trainer_id,:title,:description,:image,:link,'1' ,:unit_id)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':trainer_id', $trainer, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':image', $imageParam, PDO::PARAM_STR);
    $stmt->bindParam(':link',$link , PDO::PARAM_STR);
    $stmt->bindParam(':unit_id', $unit, PDO::PARAM_STR);


    // http://dev.mysql.com/doc/refman/5.6/en/date-and-time-functions.html

    return $stmt->execute();;
}

function existsExercise(PDO $pdo, string $title): bool
{

    $sql = "SELECT exercise_id FROM exercises WHERE title=:title";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}
function deleteTrainerProgram(PDO $pdo, string $programId):bool
{
    $sql = "DELETE FROM programs WHERE program_id = :program_id;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':program_id', $programId, PDO::PARAM_STR);
    return $stmt->execute();
}
function getCreatorId(PDO $pdo, string $trainerId): ?int
{
    $sql = "SELECT p_creator_id FROM program_creators WHERE trainer_id = :trainer_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':trainer_id', $trainerId, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row !== false) {
        return (int) $row['p_creator_id'];
    } else {
        return null;
    }
}
function insertProgram(PDO $pdo, string $programName, string $programCreator, $programCategory):bool
{

    $sql = "INSERT INTO `programs` ( `program_name`, `creator_id`, `category_id`, `popularity`, `is_hidden`) 
            VALUES (:program_name, :creator_id, :category_id, '0', '0');";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':program_name', $programName, PDO::PARAM_STR);
    $stmt->bindParam(':creator_id', $programCreator, PDO::PARAM_STR);
    $stmt->bindParam(':category_id', $programCategory, PDO::PARAM_STR);


    // http://dev.mysql.com/doc/refman/5.6/en/date-and-time-functions.html

    return $stmt->execute();;
}
function existsTrainerProgram(PDO $pdo, string $name): bool
{

    $sql = "SELECT program_id FROM programs WHERE program_name=:name";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}
function getDayName(PDO $pdo, string $day_id): string
{
    $sql = "SELECT day_name FROM `exercise_day` WHERE day_id = :day_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':day_id', $day_id, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['day_name'];
    } else {
        return 'Day not found'; // or any default value/error message you prefer
    }
}
function getProgramId(PDO $pdo, string $name): int
{
    $sql = "SELECT program_id FROM programs WHERE program_name = :program_name";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':program_name', $name, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['program_id'];
    } else {
        return 0;
    }
}
function makeCreatorId(PDO $pdo, string $trainerId):bool
{
    $sql = "SELECT p_creator_id FROM program_creators WHERE trainer_id = :trainer_id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':trainer_id', $trainerId);
    $stmt->execute();
    $foundRow = $stmt->fetch(PDO::FETCH_ASSOC);


    if (!$foundRow) {
        $sqlCreator = "INSERT INTO program_creators (trainer_id) VALUES (:trainer_id);";
        $stmtCreator = $pdo->prepare($sqlCreator);
        $stmtCreator->bindParam(':trainer_id',  $trainerId);
        $stmtCreator->execute();

    }

    return true;
}