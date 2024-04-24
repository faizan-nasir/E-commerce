<?php

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class to generate OTP and send mail to user.
 */
class Mailer {

  private $otp,$mail;

  function __construct() {
    $env = new Dotenv();
    $this->mail = new PHPMailer(true);
  }

  public function config() {
    // Use SMPT Protocol to send the message.
    $this->mail->isSMTP();
    // Setting SMTPAuth to TRUE to use gmail credentials for sending message.
    $this->mail->SMTPAuth = TRUE;
    // Set configurations.
    $this->mail->Host = $_ENV['MAILHOST'];
    $this->mail->Username = $_ENV['USERNAME'];
    $this->mail->Password = $_ENV['PASSWORD'];
    // Set SMTPSecure to ENCRYPTION_STARTTLS to ensure encrypted conversation
    $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $this->mail->Port = 587;
    $this->mail->setFrom($_ENV['SENT_FROM'], $_ENV['SENT_FROM_NAME']);
    // Set recipient mail.
    $this->mail->addReplyTo($_ENV['REPLY_TO'], $_ENV['REPLY_TO_NAME']);
    $this->mail->isHTML();
  }

  /**
   * Function to generate random otp.
   *
   * @return int
   *   Returns randomly generated otp.
   */
  private function otp_generate() {
    $this->otp = rand(1000, 9980);
    return $this->otp;
  }

  /**
   * Function to send OTP Mail to user.
   *
   * @param string $email
   *   Email id of the recipient.
   *
   * @return bool
   *   Returns true if email was successfully delivered and false otherwise.
   */
  public function sendOtpMail(string $email, string $task) {
    $otp = $this->otp_generate();
    $this->config();
    $this->mail->addAddress($email);
    $this->mail->Subject = 'Your OTP';
    $this->mail->Body = "<h2>Your OTP is {$otp}</h2>";
    $this->mail->AltBody = "<h2>Your OTP is {$otp}</h2>";
    // Send mail and return message.
    if (!$this->mail->send()) {
      header('location:signup/signup.php');
      return false;
    }
    else {
      session_start();
      date_default_timezone_set("Asia/Kolkata");
      $_SESSION['otp'] = $otp;
      $_SESSION['valid_time'] = strtotime('+60 second');
      $_SESSION['task'] = $task;
    }
    return true;
  }

  /**
   * Function to send Bill Mail to user.
   *
   * @param string $email
   *   Email id of the recipient
   * @param string $order_id
   *   Order Id of the bill
   * 
   * @return bool
   *   Returns true if email was successfully delivered and false otherwise.
   */
  public function sendBill(string $email, string $order_id) {
    $this->config();
    $this->mail->addAddress($email);
    $this->mail->Subject = "Your Invoice for OrderID: {$order_id}";
    $this->mail->Body = "<h2>Thanks for shopping! Your invoice is attached below!</h2>";
    $this->mail->AltBody = "<h2>Thanks for Shopping!</h2>";
    // Add Attachment.
    $this->mail->addAttachment("../static/pdf/{$order_id}.pdf",'PDF','base64', 'application/pdf');
    // Send mail and return message.
    if (!$this->mail->send()) {
      return false;
    }
    return true;
  }
}
