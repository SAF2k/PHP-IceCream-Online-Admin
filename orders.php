<?php

include 'config/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:home.php');
}
;

?>

<?php include 'includes/header.php'; ?>


<?php include 'includes/footer.php'; ?>