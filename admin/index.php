<?php

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:../index.php');
}

include('./includes/connect.php'); 

?>

<?php include('./includes/header.php'); ?>
<meta http-equiv="refresh" content="<?php echo $sec ?>;URL='<?php echo $page ?>'">
<!-- partial -->

<div class="main-panel">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                $select_orders->execute(['pending']);
                $pending_orders = $select_orders->rowCount();
                ?>
                <div class="card">
                    <a href="pending_orders.php" style="text-decoration: none;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">
                                            <?= $pending_orders; ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal mt-3">Total Pending</h6>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                $select_orders->execute(['completed']);
                $complete_orders = $select_orders->rowCount();
                ?>
                <div class="card">
                    <a href="completed_orders.php" style="text-decoration: none;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">
                                            <?= $complete_orders; ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal mt-3">Total Completed</h6>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <?php
                $select_products = $conn->prepare("SELECT * FROM `products`");
                $select_products->execute();
                $numbers_of_products = $select_products->rowCount();
                ?>
                <div class="card">
                    <a href="view_product.php" style="text-decoration: none;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">
                                            <?= $numbers_of_products; ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal mt-3">Total Products</h6>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <?php
                $select_users = $conn->prepare("SELECT * FROM `users`");
                $select_users->execute();
                $numbers_of_users = $select_users->rowCount();
                ?>
                <div class="card">
                    <a href="view_users.php" style="text-decoration: none;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">
                                            <?= $numbers_of_users; ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal mt-3">Total Users</h6>
                        </div>
                    </a>
                </div>
            </div>


        </div>


        <div class="row">
            <a href="view_orders.php" style="text-decoration: none;">
                <div class="col-sm-4 grid-margin">
                    <div class="card">

                        <?php
                        $total_sale = 0;
                        $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                        $select_completes->execute(['completed']);
                        while ($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)) {
                            $total_sale += $fetch_completes['total_price'];
                        }
                        ?>

                        <div class="card-body">
                            <h5>Total Sales</h5>
                            <div class="row">
                                <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                    <div class="d-flex d-sm-block d-md-flex align-items-center">
                                        <h2 class="mb-0">₹
                                            <?= $total_sale; ?>
                                        </h2>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                    <i class="icon-lg mdi mdi-codepen text-primary ml-auto"></i>
                                </div>
                            </div>
                        </div>
                    </div>
            </a>
        </div>
        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">

                    <?php
                    $total_todays_sale = 0;
                    $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ? AND DATE(placed_on) = CURDATE()");
                    $select_completes->execute(['completed']);
                    while ($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)) {
                        $total_todays_sale += $fetch_completes['total_price'];
                    }
                    ?>

                    <h5>Todays Sales</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0">₹ <?= $total_todays_sale; ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-wallet-travel text-danger ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Purchase</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0">$2039</h2>
                                <p class="text-danger ml-2 mb-0 font-weight-medium">-2.1% </p>
                            </div>
                            <h6 class="text-muted font-weight-normal">2.27% Since last month</h6>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-monitor text-success ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row ">


        <div class="col-12 grid-margin mh-20">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Order Status</h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <h5> Client Name </h5>
                                    </th>
                                    <th> Order No </th>
                                    <th> Price </th>
                                    <th> Date </th>
                                    <th> Time </th>
                                    <th> Payment </th>
                                    <th> Order Status </th>
                                </tr>
                            </thead>
                            <?php
                            $select_orders = $conn->prepare("SELECT * FROM `orders` ORDER BY `id` DESC LIMIT 6");
                            $select_orders->execute();
                            if ($select_orders->rowCount() > 0) {
                                while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tbody>
                                        <tr>
                                            <a href="view_orders">
                                                <td>
                                                    <h5 class="pl-2">
                                                        <?= $fetch_orders['name']; ?>
                                                    </h5>
                                                </td>
                                            </a>
                                            <td>
                                                <?= $fetch_orders['id']; ?>
                                            </td>
                                            <td>
                                                <?= $fetch_orders['total_price']; ?>
                                            </td>
                                            <td>
                                                <?= $fetch_orders['placed_on']; ?>
                                            </td>
                                            <td>
                                                <?= $fetch_orders['placed_time']; ?>
                                            </td>
                                            <td>
                                                <?= $fetch_orders['method']; ?>
                                            </td>
                                            <?php if ($fetch_orders['payment_status'] == 'completed') { ?>
                                                <td>
                                                    <div class="badge badge-outline-success">Completed</div>
                                                </td>
                                                <?php
                                            } else {
                                                ?>
                                                <td>
                                                    <div class="badge badge-outline-warning">Pending</div>
                                                </td>
                                                <?php
                                            } ?>
                                        </tr>
                                    </tbody>
                                    <?php
                                }
                            } else {
                                echo '<p class="empty">no orders placed yet!</p>';
                            }
                            ?>
                        </table>
                    </div>
                </div>

            </div>
        </div>


    </div>

    <!-- partial -->

</div>
<!-- main-panel ends -->
</div>

<?php include('./includes/footer.php'); ?>