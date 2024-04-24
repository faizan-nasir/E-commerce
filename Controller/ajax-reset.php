<?php

require_once '../vendor/autoload.php';
require_once '../core/Dotenv.php';
require_once '../Helper/Validator.php';
require_once '../Helper/Mailer.php';
require_once '../Model/Database.php';

$env = new Dotenv();
$message = '';
$class = 'red';

//Perform verification and validation and send otp for password reset.
if (empty($_POST['email'])) {
  $message = "Email field cannot be empty!";
}
else {
  $valid = new Validator();
  if (!$valid->isValidEmail($_POST['email'])) {
    $message = "Invalid Email";
  }
  elseif (!$valid->isExistingUser($_POST['email'])) {
    echo "hi";
    $message = "User does not exist! Register First";
  }
  else {
    $mail = new Mailer();
    if ($mail->sendOtpMail($_POST['email'], 'reset')) {
      $message = 'Check Mail for OTP';
      $class = 'green';
      session_start();
      $_SESSION['email'] = $_POST['email'];
    }
    else {
      $message = 'OTP Was not sent Try again!';
    }
  }
}
echo "<p class='{$class}'>{$message}</p>";
