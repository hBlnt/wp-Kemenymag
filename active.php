<?php
require_once "db_config.php";
require_once "functions_def.php";
session_start();
$usertype = $_SESSION['usertype'];
if (isset($_GET['token'])) {
    $token = trim($_GET['token']);
}
if (isset($_POST['usertype'])) {
    $usertype = trim($_POST['usertype']);
}

if (!empty($token) and strlen($token) === 40) {
    if ($usertype === "user") {

        $sql = "UPDATE user SET active = 1, registration_token = '', registration_token_expiry = ''
            WHERE binary registration_token = :token AND registration_token_expiry > now()";
    } else {
        $sql = "UPDATE trainer SET active = 1, registration_token = '', registration_token_expiry = ''
            WHERE binary registration_token = :token AND registration_token_expiry > now()";
    }
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();


    if ($stmt->rowCount() > 0) {
        redirection('register_authentication.php?r=6');
    } else {
        redirection('register_authentication.php?r=12');
    }
} else {
    redirection('register_authentication.php?r=0');
}
session_destroy();