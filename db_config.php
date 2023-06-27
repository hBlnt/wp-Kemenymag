<?php

const PARAMS = [
    "HOST" => 'localhost',
    "USER" => 'root',
    "PASS" => '',
    "DBNAME" => 'workoutnew',
    "CHARSET" => 'utf8mb4'
];

const SITE = 'https://localhost/egyhely/PROJEKTPROJEKTPROJEKTPROJEKT/'; // enter your path on localhost

$dsn = "mysql:host=" . PARAMS['HOST'] . ";dbname=" . PARAMS['DBNAME'] . ";charset=" . PARAMS['CHARSET'];

$pdoOptions = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];

    $actions = ['login', 'register', 'forget','userRatingTrainer'];

$messages = [
    0 => 'No direct access!',
    1 => 'Unknown user!',
    2 => 'User with this e-mail already exists, choose another one!',//
    3 => 'Check your email to activate your account!',
    4 => 'Fill all the fields!',//
    5 => 'You are logged out!!',
    6 => 'Your account is activated, you can login now!',
    7 => 'Passwords are not equal!',//
    8 => 'Format of e-mail address is not valid!',//
    9 => 'Password can not be empty!',//
    10 => 'Password is not long enough! (min 8 characters)',//
    11 => 'Something went wrong with mail server. We will try to send email later!',
    12 => 'Your account is already activated!',
    13 => 'If you have an account on our site, email with instructions for reset password is sent to you.',
    14 => 'Something went wrong with server.',
    15 => 'Token or other data are invalid!',
    16 => 'Your new password is set and you can login.',
    17 => 'Fill out the biography field!',//
    18 => 'Fill out the new fields!',//
    19 => 'Choose a gender!',//
    20 => 'UserType error',//
    21 => 'Type in your biography!',
    22 => 'Logged in congrats, you are a USER',
    23 => 'Logged in ,you are a TRAINER',
    24 => 'Admin didnt approve yet!',
    25 => 'We couldn\'t rate the trainer. ',
    26 => 'Thank you for your rating '
];

$emailMessages = [
    'register' => [
        'subject' => 'Register on web site',
        'altBody' => 'This is the body in plain text for non-HTML mail clients'
    ],
    'forget' => [
        'subject' => 'Forgotten password - create new password',
        'altBody' => 'This is the body in plain text for non-HTML mail clients'
    ]
];
