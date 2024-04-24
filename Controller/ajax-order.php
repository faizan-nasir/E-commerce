<?php

require_once '../vendor/autoload.php';
require_once '../core/Dotenv.php';
require_once '../Model/Database.php';
require_once '../Helper/Mailer.php';
require_once '../Helper/PDF.php';

session_start();

$env = new Dotenv();
$db_obj = new Database($_ENV['HOST_NAME'], $_ENV['DB_NAME'], $_ENV['USER_NAME'], $_ENV['DB_PASSWORD']);
$mail = new Mailer();
$pdf = new PDF();
$exists = $db_obj->isExistingCart($_SESSION['email']);
if ($exists) {
  $db_obj = new Database($_ENV['HOST_NAME'], $_ENV['DB_NAME'], $_ENV['USER_NAME'], $_ENV['DB_PASSWORD']);
  $email = $_SESSION['email'];
  $res = $db_obj->getCart($email);
  $total = 0;
  $order_id = uniqid($email . '_');
  foreach ($res as $i) :
    $total += $i['quantity'] * $i['price'];
  endforeach;
  $db_obj->insertInto('orders', ['order_id', 'email', 'total'], [$order_id, $email, $total]);
  foreach ($res as $i) :
    $db_obj->insertInto(
      'order_item',
      ['order_id', 'product_id', 'quantity', 'price'],
      [$order_id, $i['product_id'], $i['quantity'], $i['price']]
    );
  endforeach;
  if ($pdf->generateBill($total, $res, $order_id)) {
    $db_obj->clearCart($email);
    if ($mail->sendBill($email, $order_id)) {
      echo "1";
    }
    else {
      echo "0";
    }
  }
  else {
    echo "0";
  }
  $db_obj->closeDb();
}
