<?php 
include('./includes/connect.php');
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:../index.php');
}
?>

<?php include('./includes/header.php'); ?>

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">View Completed Orders</h3>
        </div>


        <div class="row ">


            <div class="col-12 grid-margin mh-20">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Orders</h4>
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
                                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ? ORDER BY `id` DESC");
                                $select_orders->execute(['completed']);
                                if ($select_orders->rowCount() > 0) {
                                    while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h5 class="pl-2">
                                                        <?= $fetch_orders['name']; ?>
                                                    </h5>
                                                </td>
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

    </div>
</div>

<?php include('./includes/footer.php'); ?>