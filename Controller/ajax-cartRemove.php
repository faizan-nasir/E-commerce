<?php

require_once '../vendor/autoload.php';
require_once '../core/Dotenv.php';
require_once '../Model/Database.php';

$env = new Dotenv();
$db_obj = new Database($_ENV['HOST_NAME'], $_ENV['DB_NAME'], $_ENV['USER_NAME'], $_ENV['DB_PASSWORD']);
try {
  session_start();
  $db_obj->clearCart($_SESSION['email']);
  echo "1";
}
catch (Exception $e) {
  echo "0";
}
$db_obj->closeDb();
