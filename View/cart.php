<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
  <link rel="stylesheet" href="static/css/user_styles.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <title>Cart</title>
</head>

<body>
  <header>
    <?php
    require 'View/header.php'; ?>
  </header>
  <main class="container">
    <div class="profile-view flex-all flex-column">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Quantity</th>
            <th>Item</th>
            <th>Price</th>
            <th>Amount</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $total = 0;
          foreach ($res as $i) :
            $amount = $i['price'] * $i['quantity'];
            $total += $amount;
          ?>
            <tr>
              <td><?= $i['quantity'] ?></td>
              <td class="flex-all">
                <div class="cart-img">
                  <img src="static/images/<?= $i['product_image'] ?>" alt="image">
                </div>
                <?= $i['name'] ?>
              </td>
              <td><?= $i['price'] ?>₹</td>
              <td><?= $amount ?>₹</td>
              <td>-</td>
            </tr>
          <?php
          endforeach;
          ?>
        </tbody>
        <tfoot>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td><?= $total ?>₹</td>
        </tfoot>
      </table>
      <div class="cartAction flex-all space-between">
        <button class="cartBtn emptyBtn">Empty Cart</button>
        <button class="cartBtn OrderBtn">Place Order</button>
      </div>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="View/js/cart_script.js"></script>
</body>

</html>
