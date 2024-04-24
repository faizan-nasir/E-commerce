<?php

require_once '../vendor/autoload.php';
require_once '../core/Dotenv.php';
require_once '../Model/Database.php';

session_start();

$product_id = $_POST['product_id'];
$env = new Dotenv();
$db_obj = new Database($_ENV['HOST_NAME'], $_ENV['DB_NAME'], $_ENV['USER_NAME'], $_ENV['DB_PASSWORD']);
$exists = $db_obj->isExistingCartItem($_SESSION['email'], $product_id);

if ($exists) {
  $quantity = $db_obj->getProductQuantity($_SESSION['email'], $product_id);
  if ($db_obj->updateItemQuantity($_SESSION['email'], $product_id, $quantity['quantity'] + 1)) {
    echo "1";
  }
}
else if ($db_obj->insertInto('cart', ['email', 'product_id', 'quantity'], [$_SESSION['email'], $product_id, 1])) {
  echo "1";
}
