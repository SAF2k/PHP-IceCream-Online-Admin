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
        <h1 class="display-4 text-white animated slideInDown mb-3">Orders</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Orders</li>
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
                    <h2 class="position-relative d-inline-block">YOUR ORDERS</h2>
                </div>
                 <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover pt-5">
                            <thead class="thead-primary">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Product Name</th>
                                    <th>Product Price</th>
                                    <th>Payment Method</th>
                                    <th>Order Date</th>
                                    <th>Order Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $selectOrder = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");
                                $selectOrder->execute([$user_id]);
                                $orders = $selectOrder->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($orders as $key => $order) {
                                    ?>
                                    <tr>
                                        <td>#<?php echo $order['id']; ?></td>
                                        <td><?php echo $order['total_products']; ?></td>
                                        <td><?php echo $order['total_price']; ?></td>
                                        <td><?php echo $order['method']; ?></td>
                                        <td><?php echo $order['placed_on']; ?></td>
                                        <td><?php echo $order['payment_status']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</div>


    <?php include 'includes/footer.php'; ?>