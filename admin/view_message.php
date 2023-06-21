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
                                        <th> Message No #</th>
                                        <th> Price </th>
                                        <th> Date </th>
                                    </tr>
                                </thead>
                                <?php
                                $select_message = $conn->prepare("SELECT * FROM `messages` ORDER BY `id` DESC");
                                $select_message->execute();
                                if ($select_message->rowCount() > 0) {
                                    while ($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h5 class=" pl-2">
                                            <?= $fetch_message['name']; ?>
                                            </h5>
                                            </td>
                                            <td>
                                                #
                                                <?= $fetch_message['id']; ?>
                                            </td>
                                            <td>
                                                <?= $fetch_message['message']; ?>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                                        data-target="#myModal<?php echo $fetch_message['id'] ?>">View</button>
                                                </div>
                                            </td>

                                            </tr>


                                            <div id="myModal<?php echo $fetch_message['id'] ?>" class="modal fade" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Details</h4>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body text-info">
                                                            <h4>Name :
                                                                <?php echo $fetch_message['name']; ?>
                                                            </h4>
                                                            <hr>
                                                            <h4>Email :
                                                                <?php echo $fetch_message['email']; ?>
                                                            </h4>
                                                            <hr>
                                                            <h4 class="text-danger">
                                                                Message :
                                                                <span class="text-success"> [
                                                                    <?php echo $fetch_message['message']; ?> ]
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