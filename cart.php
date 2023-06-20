<?php
session_start();

include 'config/connect.php';

echo $_SESSION['user_id'];


// if (isset($_SESSION['user_id'])) {
//   $user_id = $_SESSION['user_id'];
//   header('location: cart.php');
// } else {
//   $user_id = '';
//   header('location:login.php');
// }
// ;

if (isset($_POST['delete'])) {
  $cart_id = $_POST['cart_id'];
  $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
  $delete_cart_item->execute([$cart_id]);
  $message[] = 'cart item deleted!';
}

if (isset($_POST['delete_all'])) {
  $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
  $delete_cart_item->execute([$user_id]);
  // header('location:cart.php');
  $message[] = 'deleted all from cart!';
}

if (isset($_POST['update_qty'])) {
  $cart_id = $_POST['cart_id'];
  $qty = $_POST['qty'];
  $qty = filter_var($qty, FILTER_SANITIZE_STRING);
  $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
  $update_qty->execute([$qty, $cart_id]);
  $message[] = 'cart quantity updated';
}

$grand_total = 0;

?>

<!-- Header Start -->
<?php include('./includes/header.php'); ?>
<!-- Header End -->


<!-- Page Header Start -->
<div class="container-fluid page-header mb-1 py-6 wow fadeIn" data-wow-delay="0.1s">
  <div class="container text-center pt-5">
    <h1 class="display-4 text-white animated slideInDown mb-3">Enjoy your Cart</h1>
    <nav aria-label="breadcrumb animated slideInDown">
      <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
        <li class="breadcrumb-item text-primary active" aria-current="page">Cart</li>
      </ol>
    </nav>
  </div>
</div>
<!-- Page Header End -->


<div class="h-100" style="background-color: #eee;">
  <div class="container h-100 py-5">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-10">

        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3 class="fw-normal mb-0 text-black">Shopping Cart</h3>
          <div>
            <p class="mb-0"><span class="text-muted">Sort by:</span> <a href="#!" class="text-body">price <i
                  class="fas fa-angle-down mt-1"></i></a></p>
          </div>
        </div>

        <?php
        $grand_total = 0;
        $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $select_cart->execute([$user_id]);
        if ($select_cart->rowCount() > 0) {
          while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <form action="" method="post" class="box"></form>
            <div class="card rounded-3 mb-4">
              <div class="card-body p-4">
                <div class="row d-flex justify-content-between align-items-center">
                  <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                  <div class="col-md-2 col-lg-2 col-xl-2">
                    <img src="uploaded_img/<?= $fetch_cart['image']; ?>" class="img-fluid rounded-3" alt="Cotton T-shirt">
                  </div>
                  <div class="col-md-3 col-lg-3 col-xl-3">
                    <p class="lead fw-normal mb-2">
                      <?= $fetch_cart['name']; ?>
                    </p>
                    <p><span class="text-muted">Price: </span>
                      <?= $fetch_cart['price']; ?>
                    </p>
                  </div>
                  <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                    <button class="btn btn-link px-2"
                      onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                      <i class="fas fa-minus"></i>
                    </button>

                    <input id="form1" min="1" max="6" name="quantity" value="<?= $fetch_cart['quantity']; ?>" maxlength="2"
                      type="number" class="form-control form-control-sm" />

                    <button class="btn btn-link px-2"
                      onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                  <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                    <h5 class="mb-0">Total : $
                      <?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>
                    </h5>
                  </div>
                  <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                    <a href="" type="submit" name="update_qty" class="text-success"><i class="fa fa-check fa-lg"></i></a>
                  </div>
                  <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                    <a href="" type="submit" name="delete" class="text-danger"><i class="fa fa-trash fa-lg"></i></a>
                  </div>
                </div>
              </div>
            </div>
            </form>

            <?php
            $grand_total += $sub_total;
          }
        } else {
          echo '<p class="empty">your cart is empty</p>';
        }
        ?>

        <div class="card mb-4">
          <div class="card-body p-4 d-flex flex-row">
            <div class="form-outline flex-fill">
              <input type="text" id="form1" class="form-control form-control-lg" />
              <label class="form-label" for="form1">Discound code</label>
            </div>
            <button type="button" class="btn btn-outline-warning btn-lg ms-3">Apply</button>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <button type="button" class="btn btn-warning btn-block btn-lg">Proceed to Pay</button>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>


<!-- Footer Start -->
<?php include('./includes/footer.php'); ?>
<!-- Footer End -->