<?php

// Display All Post in the $res array
foreach ($res as $i) {
?>
  <div class="card" style="width: 18rem;">
    <img src="static/images/<?= $i['product_image'] ?>" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title"><?= $i['name'] ?></h5>
      <h5 class="card-title price">Price: <?= $i['price'] ?>INR</h5>
      <button data-productid="<?= $i['product_id'] ?>" class="btn btn-primary">
      Add to cart
      </button>
    </div>
  </div>
<?php
}
