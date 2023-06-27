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
    $sqlUser = "SELECT user_id, user_password,firstname FROM user WHERE email=:email AND active=1 AND is_banned = 0 LIMIT 0,1";
    $sqlTrainer = "SELECT trainer_id, trainer_password, admin_approval,firstname FROM trainer WHERE email=:email AND active=1 AND is_banned = 0 LIMIT 0,1";

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
function sendEmail(PDO $pdo, string $email, array $emailData, string $body, int $id_user): void
{

    $phpmailer = new PHPMailer(true);

    try {

        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        //$phpmailer->Username = '---'; // your username on mailtrap
        //$phpmailer->Password = '---'; // your password on mailtrap

        $phpmailer->Username = '420a91b1dceae1';
        $phpmailer->Password = 'cc4de6925884ac';


        $phpmailer->setFrom('balinth3@gmail.com', 'Balint');
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

function existsUserTrainerRating(PDO $pdo, string $user_id, string $trainer_id, string $score): bool
{
    //We select user and trainer, and check if there is already a pair in trainer_rating table

    $sql = "SELECT user_id,trainer_id FROM trainer_rating WHERE trainer_id = :trainer_id AND user_id = :user_id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':trainer_id', $trainer_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $stmt->fetch(PDO::FETCH_ASSOC);

        //if there is we only update it if there isnt we instert

    if ($stmt->rowCount() > 0) {
        $sqlRating = "UPDATE trainer_rating SET score = :score WHERE user_id = :user_id AND trainer_id = :trainer_id";
    } else {
        $sqlRating = "INSERT INTO trainer_rating (trainer_id, user_id, score) VALUES (:trainer_id, :user_id, :score)";
    }

    $stmtRating = $pdo->prepare($sqlRating);
    $stmtRating->bindParam(':trainer_id', $trainer_id);
    $stmtRating->bindParam(':user_id', $user_id);
    $stmtRating->bindParam(':score', $score);

    return $stmtRating->execute();
}
//Testing function
//existsUserTrainerRating($pdo,'18','3','2');

function programInUsage(PDO $pdo, string $user_id, string $trainer_id): bool{
    $sqlOngoingProgramListing ="SELECT pc.trainer_id FROM program_creators pc 
                                INNER JOIN programs p ON pc.p_creator_id = p.creator_id 
                                INNER JOIN ongoing_programs op ON p.program_id = op.program_id 
                                 WHERE op.user_id = :user_id AND pc.trainer_id = :trainer_id; ";
    $stmt = $pdo->prepare($sqlOngoingProgramListing);

    $stmt->bindParam(':user_id',$user_id);
    $stmt->bindParam(':trainer_id',$trainer_id);
    $stmt->execute();
    $trainerFound= $stmt->fetch(PDO::FETCH_ASSOC);

    if ($trainerFound !== false) {
        return true;
    }
    else {
        return false;
    }
}