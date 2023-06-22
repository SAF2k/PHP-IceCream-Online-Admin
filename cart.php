<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Include database connection and other necessary files
include 'config/connect.php';

// Handle increment and decrement actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['increment'])) {
        $cartId = $_POST['cart_id'];
        updateQuantity($cartId, 1);
    } elseif (isset($_POST['decrement'])) {
        $cartId = $_POST['cart_id'];
        updateQuantity($cartId, -1);
    }
}

// Function to update the quantity of a cart item
function updateQuantity($cartId, $change)
{
    global $conn;

    // Retrieve the current quantity from the database
    $selectQuery = $conn->prepare("SELECT quantity FROM cart WHERE id = ?");
    $selectQuery->execute([$cartId]);
    $currentQuantity = $selectQuery->fetchColumn();

    // Calculate the new quantity
    $newQuantity = $currentQuantity + $change;

    // Ensure the quantity does not go below 1
    if ($newQuantity < 1) {
        $newQuantity = 1;
    }

    // Update the quantity in the database
    $updateQuery = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
    $updateQuery->execute([$newQuantity, $cartId]);

    // Redirect back to the cart page
    header('Location: cart.php');
    exit;
}

if (isset($_POST['delete_item'])) {
    $cart_id = $_POST['cart_id'];
    $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
    $delete_cart_item->execute([$cart_id]);
    $message[] = 'cart item deleted!';
}

// Fetch the cart items for the logged-in user
$user_id = $_SESSION['user_id'];
$selectCart = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
$selectCart->execute([$user_id]);
$cartItems = $selectCart->fetchAll(PDO::FETCH_ASSOC);
?>




<?php include('./includes/header.php'); ?>



<!-- Page Header Start -->
<div class="container-fluid page-header mb-1 py-6 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center pt-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">Shopping Cart</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Cart</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->





<div class="container-xxl py-6">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="title text-center">
                    <h2 class="position-relative d-inline-block">Your Cart</h2>
                </div>

                <?php if (!empty($cartItems)): ?>

                    <?php
                    $grandTotal = 0;
                    foreach ($cartItems as $key => $item) {
                        $total = $item['price'] * $item['quantity'];
                        $grandTotal += $total;
                    }
                    ?>

                    <div class="container p-2 ">
                        <?php foreach ($cartItems as $key => $item): ?>
                            <div class="card mb-2">
                                <div class="row g-0 d-flex justify-content-between">
                                    <div class="col-md-2">
                                        <img src="uploaded_img/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>"  class="img-fluid rounded">
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <?php echo $item['name']; ?>
                                            </h5>
                                            <p class="card-text">Price: $
                                                <?php echo $item['price']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <div class="card-body">
                                            <form action="" method="post">
                                                <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                                                <div class="input-group">
                                                    <button type="submit" name="decrement"
                                                        class="btn btn-sm btn-outline-primary">-</button>
                                                    <input type="text" max="6" name="quantity"
                                                        class="form-control form-control-sm" style="max-width: 60px;"
                                                        value="<?php echo $item['quantity']; ?>">
                                                    <button type="submit" name="increment"
                                                        class="btn btn-sm btn-outline-primary">+</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <div class="card-body">
                                            <p class="card-text">Total: $
                                                <?php echo $item['price'] * $item['quantity']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <div class="card-body">
                                            <form action="" method="post">
                                                <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                                                <button type="submit" name="delete_item"
                                                    class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="text-md-left text-center mt-4">
                        <h4 class="mb-3" style="font-weight: bold;">Grand Total: $
                            <?php echo $grandTotal; ?>
                        </h4>
                    </div>
                    <div class="text-md-right text-center mt-4">
                        <button class="btn btn-primary" style="font-weight: bold;">Proceed to Payment</button>
                    </div>

                <?php else: ?>
                    <h3 class="text-center text-muted mt-5">Your cart is empty.</h3>
                <?php endif; ?>


            </div>
        </div>
    </div>
</div>



<?php include('./includes/footer.php'); ?>