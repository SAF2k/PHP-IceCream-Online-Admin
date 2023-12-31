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
        <div class="row g-2 d-flex justify-content-around text-center">
            <div class="title text-center mb-5">
                <h2 class="position-relative d-inline-block">YOUR ORDERS</h2>
            </div>


            <?php
            if ($user_id == '') {
                echo '<p class="empty">please login to see your orders</p>';
            } else {
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY id DESC");
                $select_orders->execute([$user_id]);
                if ($select_orders->rowCount() > 0) {
                    while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                        ?>


                        <div class="col-lg-5 p-4 d-flex flex-column justify-content-around align-items-center border border-primary text-secondary text-capitalize wow fadeIn"
                            data-wow-delay="0.1s">
                            <div class="col-lg-8">
                                <p>Order ID:
                                    <?= $fetch_orders['id']; ?>
                                </p>
                            </div>
                            <div class="">
                                <p>Placed On:
                                    <?= $fetch_orders['placed_on']; ?>
                                </p>
                            </div>
                            <div class="">
                                <p>Address:
                                    <?= $fetch_orders['address']; ?>
                                </p>
                            </div>
                            <div class="">
                                <p>your orders:
                                    <span class="text-dark "><?= $fetch_orders['total_products']; ?></span>
                                            </p>
                                        </div>
                                        <div class="">
                                            <p>Total Amount:
                                    <?= $fetch_orders['total_price']; ?>
                                </p>
                            </div>
                            <div class="">
                                <p>Payment Method:
                                    <?= $fetch_orders['method']; ?>
                                </p>
                            </div>
                            <div class="">
                               <p>Order Status:
                                    <?php
                                            if ($fetch_orders['payment_status'] == 'pending') {
                                                echo  "<span class='text-warning'> Pending</span>";
                                            } else {
                                                echo "<span class='text-success'> Delivered</span>";
                                            }
                                            ?>
                                </p>
                            </div>
                        </div>


                        <?php
                    }
                } else {
                    echo '<h3 class="border border-primary p-3 text-center text-muted mt-5">No Orders Placed Yet!</h3>';
                }
            }
            ?>

        </div>
    </div>
</div>


<?php include 'includes/footer.php'; ?>