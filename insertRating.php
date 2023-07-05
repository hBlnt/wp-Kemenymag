<?php
header('X-Frame-Options: SAMEORIGIN');
require_once 'db_config.php';

header("Content-Type: application/json");
$data = json_decode(stripslashes(file_get_contents("php://input")), true);

$score = isset($data['score']) ? mysqli_real_escape_string($connection, $data['score']) : '';
$comment = isset($data['comment']) ? mysqli_real_escape_string($connection, $data['comment']) : '';
$user = isset($data['user_id']) ? mysqli_real_escape_string($connection, $data['user_id']) : '';
$trainer = isset($data['trainer_id']) ? mysqli_real_escape_string($connection, $data['trainer_id']) : '';

$error = false;
$responseMessage = "Thank you for your rating!";

if (empty($trainer)) {
    $error = true;
}

if (empty($user)) {
    $error = true;
}


if ($error) {
    $responseMessage = "Something went wrong, please try later!";
} else {
    $sql = "INSERT INTO trainer_rating (trainer_id, user_id,score,comment) VALUES ('$trainer','$user','$score','$comment')";
    $result = mysqli_query($connection, $sql) or die(mysqli_error($connection));
}

$response = [
    "message" => $responseMessage,
    "status" => 'OK'
];

sleep(1);

echo json_encode($response);