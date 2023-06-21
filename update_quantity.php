<?php
session_start();

include 'config/connect.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_qty'])) {
        $cart_id = $_POST['cart_id'];
        $quantity = $_POST['quantity'];

        $update_query = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ? AND user_id = ?");
        $update_query->execute([$quantity, $cart_id, $user_id]);

        // Redirect back to the cart page or any other desired location
        header("Location: cart1.php");
        exit;
    }
}

// Redirect back to the cart page if the request is not a POST request
header("Location: cart.php");
exit;
?>