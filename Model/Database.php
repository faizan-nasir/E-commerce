<?php

use Dotenv\Util\Str;

/**
 * Class to perform all database based operations.
 */
class Database {

  private $sql;
  private $stmt;
  private $pdo;

  /**
   * Constructor to initialize PDO object for performing queries.
   *
   * @param string $host
   *   Host name.
   * @param string $db
   *   Database Name.
   * @param string $user
   *   Database User Name.
   * @param string $password
   *   Password of database user.
   */
  function __construct(string $host, string $db, string $user, string $password) {
    // Initializing PDO Object.
    try {
      $this->pdo = new PDO("mysql:host=$host;dbname=$db",$user,$password);
    }
    catch (Exception $e) {
      echo "Connection Failed: " . $e->getMessage();
    }

  }

  /**
   * Function to close the database connection
   *
   * @return void
   */
  public function closeDb() {
    $this->pdo = NULL;
    $this->stmt = NULL;
  }

  /**
   * Function to insert into any table in the database.
   *
   * @param string $table_name
   *   Name of the table to insert data into.
   * @param array $column_names
   *   Column Names in the table.
   * @param array $values
   *   Values to be inserted.
   *
   * @return bool
   *   Returns true on success and false otherwise.
   */
  public function insertInto(string $table_name, array $column_names, array $values) {
    $this->sql = "INSERT INTO {$table_name} (";
    $col_len = count($column_names);
    $val_len = count($values);
    for ($i = 0; $i < $col_len; $i++) {
      $tmp = '';
      if ($i == $col_len-1) {
        $tmp = "{$column_names[$i]}) VALUES(";
      }
      else {
        $tmp = "{$column_names[$i]}, ";
      }
      $this->sql .= $tmp;
    }

    for ($i = 0; $i < $val_len; $i++) {
      $tmp = '';
      if ($i == $val_len - 1) {
        $tmp = "?);";
      }
      else {
        $tmp = "?, ";
      }
      $this->sql .= $tmp;
    }

    $this->stmt = $this->pdo->prepare($this->sql);
    try{
      return $this->stmt->execute($values);
    }
    catch (Exception $e) {
      echo "Error Occured: " . $e;
    }
  }

  /**
   * Undocumented function
   *
   * @param string $table_name
   *   Name of the table.
   * @param array $column_names
   *   Name of columns to be updated.
   * @param array $values
   *   Values to be updated.
   * @param string $email
   *   Email to identify the updation selection.
   *
   * @return bool
   *   Returns true on success and false otherwise.
   */
  public function updateInto(string $table_name, array $column_names, array $values, string $email) {
    $this->sql = "UPDATE {$table_name} SET ";
    $col_len = count($column_names);
    for ($i = 0; $i < $col_len; $i++) {
      $tmp = '';
      if ($i == $col_len - 1) {
        $tmp = "{$column_names[$i]} = '{$values[$i]}' WHERE email = '{$email}';";
      }
      else {
        $tmp = "{$column_names[$i]} = '{$values[$i]}', ";
      }
      $this->sql .= $tmp;
    }
    $this->stmt = $this->pdo->prepare($this->sql);
    try {
      return $this->stmt->execute();
    }
    catch (Exception $e) {
      echo "Error Occured: " . $e;
    }
  }

  /**
  * Function to select a particular row from a table using email.
  *
  * @param string $table_name
  *   Table name to select from.
  * @param string $email
  *   Email id to identify row.
  *
  * @return mixed
  *  Returns array of details on success and false otherwise.
  */
  public function selectUser(string $table_name, string $email) {
  $this->sql = "SELECT * FROM {$table_name} WHERE email = '{$email}';";
  $this->stmt = $this->pdo->prepare($this->sql);
    try {
      $this->stmt->execute();
      $res = $this->stmt->fetch();
      return $res;
    }
    catch (Exception $e) {
      echo "Error Occured: " . $e;
    }
 }

  /**
   * Function to select all data from any table.
   *
   * @param string $table_name
   *   Table name to select from.
   *
   * @return mixed
   *   Returns array of details on success and false otherwise.
   */
  public function selectAll(string $table_name) {
    $this->sql = "SELECT * FROM {$table_name};";
    $this->stmt = $this->pdo->prepare($this->sql);
    try {
      $this->stmt->execute();
      $res = $this->stmt->fetchAll();
      return $res;
    }
    catch (Exception $e) {
      echo "Error Occured: " . $e;
    }
 }

  /**
  * Function to load 3 latest products.
  *
  * @return array|false
  *   Returns fetched array on success and false otherwise.
  */
  public function getDefaultItems() {
    $this->sql = "SELECT * FROM products LIMIT 3;";
    $this->stmt = $this->pdo->prepare($this->sql);
    try {
      $this->stmt->execute();
      $res = $this->stmt->fetchAll();
      return $res;
    }
    catch (Exception $e) {
      echo "Error Occured: " . $e;
    }
 }

  /**
   * Function to perform search query and return results.
   *
   * @param string $search
   *   Value of content to be searched.
   *
   * @return array|false
   *   Returns fetched array on success and false otherwise.
   */
  public function searchContent(string $search) {
    $this->sql = "SELECT * FROM products WHERE name LIKE '%$search%';";
    $this->stmt = $this->pdo->prepare($this->sql);
    try {
      $this->stmt->execute();
      $res = $this->stmt->fetchAll();
      return $res;
    }
    catch (Exception $e) {
      echo "Error Occured: " . $e;
    }
  }

  /**
   * Function to retrieve details of a particular table.
   *
   * @param string $product_id
   *   Product id of the product to get details.
   * @return mixed
   *   Returns an associate array on success and false otherwise.
   */
  public function selectProduct(string $product_id) {
    $this->sql = "SELECT * FROM products WHERE product_id = {$product_id};";
    $this->stmt = $this->pdo->prepare($this->sql);
    try {
      $this->stmt->execute();
      $res = $this->stmt->fetch();
      return $res;
    }
    catch (Exception $e) {
      echo "Error Occured: " . $e;
    }
  }

  /**
   * Function to check if a cart item exists in the database.
   *
   * @param string $email
   *   Email id of the user
   * @param string $product_id
   *   Product id of the product to check the cart item.
   * @return bool
   *   Returns true if exists and false otherwise.
   */
  public function isExistingCartItem(string $email, string $product_id) {
    $this->sql = "SELECT * FROM cart WHERE product_id = {$product_id} and email = '{$email}';";
    $this->stmt = $this->pdo->prepare($this->sql);
    try {
      $this->stmt->execute();
      $res = $this->stmt->fetch();
      return $res;
    }
    catch (Exception $e) {
      echo "Error Occured: " . $e;
    }
  }

  /**
   * Function to check if a cart exists for a user.
   *
   * @param string $email
   *   Email id of the user
   * @return bool
   *   Returns true if exists and false otherwise.
   */
  public function isExistingCart(string $email)
  {
    $this->sql = "SELECT * FROM cart WHERE email = '{$email}';";
    $this->stmt = $this->pdo->prepare($this->sql);
    try {
      $this->stmt->execute();
      $res = $this->stmt->fetch();
      return $res;
    }
    catch (Exception $e) {
      echo "Error Occured: " . $e;
    }
  }

  /**
   * Function to get the product quantity from the cart.
   *
   * @param string $email
   *   Email of the user.
   * @param string $product_id
   *   Product id of the product to check quantity
   * @return mixed
   *   returns associative array containing quantity on success and false otherwise.
   */
  public function getProductQuantity(string $email, string $product_id) {
    $this->sql = "SELECT quantity FROM cart WHERE product_id = {$product_id} and email = '{$email}';";
    $this->stmt = $this->pdo->prepare($this->sql);
    try {
      $this->stmt->execute();
      $res = $this->stmt->fetch();
      return $res;
    }
    catch (Exception $e) {
      echo "Error Occured: " . $e;
    }
  }

  /**
   * Function to get the entire cart of the user along with the products.
   *
   * @param string $email
   *   Email of the user
   * @return array|false
   *   Returns associative array of results on success and false otherwise.
   */
  public function getCart(string $email) {
    $this->sql = "SELECT * FROM cart AS c INNER JOIN products AS p ON c.product_id = p.product_id WHERE email = '{$email}';";
    $this->stmt = $this->pdo->prepare($this->sql);
    try {
      $this->stmt->execute();
      $res = $this->stmt->fetchAll();
      return $res;
    }
    catch (Exception $e) {
      echo "Error Occured: " . $e;
    }
  }

  /**
   * Function to update item quantity of a product in existing cart.
   *
   * @param string $email
   *   Email of the user.
   * @param string $product_id
   *   Product ID of the product to increase quantity of.
   * @param integer $quantity
   *   Quantity to be updated.
   * @return bool
   *   returns true on success and false otherwise.
   */
  public function updateItemQuantity(string $email, string $product_id, int $quantity) {
    $this->sql = "UPDATE cart SET quantity = {$quantity} WHERE email='{$email}' AND product_id = {$product_id};";
    $this->stmt = $this->pdo->prepare($this->sql);
    try {
      return $this->stmt->execute();
    }
    catch (Exception $e) {
      echo "Error Occured: " . $e;
    }
  }

  /**
   * Function to clear the cart of a user.
   *
   * @param string $email
   *   Email id of the user.
   * @return bool
   *   returns true on success and false otherwise.
   */
  public function clearCart(string $email) {
    $this->sql = "DELETE FROM cart WHERE email = '{$email}';";
    $this->stmt = $this->pdo->prepare($this->sql);
    try {
      return $this->stmt->execute();
    }
    catch (Exception $e) {
      echo "Error Occured: " . $e;
    }
  }
}
