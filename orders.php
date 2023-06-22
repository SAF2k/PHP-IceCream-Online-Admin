<?php

include 'config/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:login.php');
}
;

?>

<?php include 'includes/header.php'; ?>

<!-- Page Header Start -->
<div class="container-fluid page-header mb-1 py-6 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center pt-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">Our Menu</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Menu</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->


<?php include 'includes/footer.php'; ?>