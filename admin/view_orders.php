<?php

include('./includes/connect.php');
include './functions/admin_function.php';

session_start();


$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:../index.php');
}


if (isset($_GET['u_status']) && isset($_GET['order_id'])) {

    $order_id = $_GET['order_id'];
    $payment_status = $_GET['u_status'];
    $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_status->execute([$payment_status, $order_id]);
    msg('Order Status Updated!', 'success');

}
?>

<?php include('./includes/header.php'); ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">View Orders</h3>
        </div>

        <div class="row ">


            <div class="col-12 grid-margin mh-20">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Orders</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="sticky"">
                                    <tr>
                                        <th>
                                            <h5> Client Name </h5>
                                        </th>
                                        <th> Order No #</th>
                                        <th> Price </th>
                                        <th> Date </th>
                                        <th> Time </th>
                                        <th> Payment </th>
                                        <th> Order Status </th>
                                        <th> More Details </th>
                                    </tr>
                                </thead>
                                <?php
                                $select_orders = $conn->prepare("SELECT * FROM `orders` ORDER BY `id` DESC");
                                $select_orders->execute();
                                if ($select_orders->rowCount() > 0) {
                                    while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h5 class=" pl-2">
                                    <?= $fetch_orders['name']; ?>
                                    </h5>
                                    </td>
                                    <td>
                                        #
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
                                    <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                                    <?php if ($fetch_orders['payment_status'] == 'completed') { ?>
                                        <td>
                                            <div class="dropdown">

                                                <a href="view_orders.php?u_status=pending&order_id=<?= $fetch_orders['id']; ?>"
                                                    class="btn btn-outline-success px-3">completed</a>
                                            </div>
                                        </td>
                                        <?php
                                    } else {
                                        ?>
                                            <td>
                                                <div class="dropdown">

                                                    <a href="view_orders.php?u_status=completed&order_id=<?= $fetch_orders['id']; ?>"
                                                        class="btn btn-outline-warning px-4"> Pending </a>
                                                </div>

                                            </td>
                                            <?php
                                    } ?>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#myModal<?php echo $fetch_orders['id'] ?>">View</button>
                                        </div>
                                    </td>

                                    </tr>


                                    <div id="myModal<?php echo $fetch_orders['id'] ?>" class="modal fade" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Details</h4>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body text-info">
                                                    <h4>Name :
                                                        <?php echo $fetch_orders['name']; ?>
                                                    </h4>
                                                    <hr>
                                                    <h4>Mobile Number :
                                                        <?php echo $fetch_orders['number']; ?>
                                                    </h4>
                                                    <hr>
                                                    <h4>Address :
                                                        <?php echo $fetch_orders['address']; ?>
                                                    </h4>
                                                    <hr>
                                                    <h4 class="text-danger">
                                                        Order :
                                                        <span class="text-success"> [
                                                            <?php echo $fetch_orders['total_products']; ?> ]
                                                        </span>
                                                    </h4>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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