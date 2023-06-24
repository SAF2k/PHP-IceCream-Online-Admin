<?php

include 'config/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:index.php');
}
;

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);
    $address = $_POST['address'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];

    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $check_cart->execute([$user_id]);

    if ($check_cart->rowCount() > 0) {

        if ($address == '') {
            $message[] = 'please add your address!';
        } else {

            $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
            $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart->execute([$user_id]);

            $message[] = 'order placed successfully!';
            header('location:orders.php');
        }

    } else {
        $message[] = 'your cart is empty';
    }

}

?>

<!-- Header Start  -->
<?php include 'includes/header.php'; ?>
<!-- Header End  -->

<!-- Page Header Start -->
<div class="container-fluid page-header mb-1 py-6 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center pt-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">Checkout</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Checkout</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<div class="container">
    <div class="container-fluid d-flex justify-content-center">
        <div class="col-lg-6 row d-flex justify-content-center align-item-center border p-2 border-primary">
            <div
                class="col-lg-11 row d-flex justify-content-center align-item-center bg-primary m-4 p-3 text-capitalize">


                <form action="" method="post">

                    <h2 class="text-center pb-2">cart items</h2>

                    <?php
                    $grand_total = 0;
                    $cart_items[] = '';
                    $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                    $select_cart->execute([$user_id]);
                    if ($select_cart->rowCount() > 0) {
                        while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                            $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
                            $total_products = implode($cart_items);
                            $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                            ?>


                            <h5 class="d-flex justify-content-between">
                                <span class="name">
                                    <?= $fetch_cart['name']; ?>
                                </span>
                                <span class="price">$
                                    <?= $fetch_cart['price']; ?> x
                                    <?= $fetch_cart['quantity']; ?>
                                </span>
                            </h5>


                            <?php
                        }
                    } else {
                        echo '<p class="empty">your cart is empty!</p>';
                    }
                    ?>

                    <h4 class="d-flex justify-content-between border border-dark-top">
                        <span class="name">grand total :</span>
                        <span class="price font-bold">$
                            <?= $grand_total; ?>
                        </span>
                    </h4>
                    <a href="cart.php" class="col-lg-6 mt-3 btn btn-secondary">veiw cart</a>
            </div>

            <div class="container p-3 text-center">


                <?php
                $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_profile->execute([$user_id]);
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                ?>



                <input type="hidden" name="total_products" value="<?= $total_products; ?>">
                <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
                <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
                <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
                <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
                <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">


                <div class="mx-2 row d-flex justify-content-center py-4 g-2 text-capitalize">
                    <h3>your info</h3>
                    <p><i class="fas fa-user"></i><span>
                            <?= $fetch_profile['name'] ?>
                        </span></p>
                    <p><i class="fas fa-phone"></i><span>
                            <?= $fetch_profile['number'] ?>
                        </span></p>
                    <p><i class="fas fa-envelope"></i><span>
                            <?= $fetch_profile['email'] ?>
                        </span></p>
                    <a href="update_profile.php" class="col-lg-6 btn btn-outline-secondary">update info</a>
                    <h3>delivery address</h3>
                    <p><i class="fas fa-map-marker-alt"></i><span>
                            <?php if ($fetch_profile['address'] == '') {
                                echo 'please enter your address';
                            } else {
                                echo $fetch_profile['address'];
                            } ?>
                        </span></p>
                    <a href="update_address.php" class="col-lg-6 btn btn-outline-primary">update address</a>
                    <select name="method" class="m-3 col-lg-6 btn btn-outline-light text-dark border border-primary"
                        required>
                        <option value="" disabled selected>select payment method --</option>
                        <option value="cash on delivery">cash on delivery</option>
                        <option value="credit card">credit card</option>
                        <option value="paytm">paytm</option>
                        <option value="paypal">paypal</option>
                    </select>
                    <input type="submit" value="place order" class="btn btn-secondary <?php if ($fetch_profile['address'] == '') {
                        echo 'disabled';
                    } ?>" name="submit">
                </div>

            </div>

            </form>

        </div>

    </div>
</div>






<!-- Footer Start   -->
<?php include 'includes/footer.php'; ?>
<!-- Footer End   -->