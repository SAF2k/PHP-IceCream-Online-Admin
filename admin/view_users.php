<?php 
include('./includes/connect.php');

session_start();

include('functions/admin_function.php');

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:../index.php');
}


if (isset($_GET['role']) && isset($_GET['id'])) {

    $role = $_GET['role'];
    $id = $_GET['id'];
    $update_status = $conn->prepare("UPDATE `users` SET role = ? WHERE id = ?");
    $update_status->execute([$role, $id]);
    msg('User Role  Updated!', 'success');

}
?>

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
                        <h4 class="card-title">Order Status</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th> Profile img </th>
                                        <th> ID </th>
                                        <th>
                                            <h5> Customer Name </h5>
                                        </th>
                                        <th> Email </th>
                                        <th> Number </th>
                                        <th> Join Date </th>
                                        <th> Role </th>
                                    </tr>
                                </thead>
                                <?php
                                $select_account = $conn->prepare("SELECT * FROM `users`");
                                $select_account->execute([]);
                                if ($select_account->rowCount() > 0) {
                                    while ($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <?php if ($fetch_accounts['image'] == "") { ?>
                                                        <img src="./assets/images/user-icon.png" alt="">
                                                    <?php } else { ?>
                                                        <img src="./user_img/<?= $fetch_accounts['image']; ?>" alt="">
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?= $fetch_accounts['id']; ?>
                                                </td>
                                                <td>
                                                    <?= $fetch_accounts['name']; ?>
                                                </td>
                                                <td>
                                                    <?= $fetch_accounts['email']; ?>
                                                </td>
                                                <td>
                                                    <?= $fetch_accounts['number']; ?>
                                                </td>
                                                <td>
                                                    <?= $fetch_accounts['created_at']; ?>
                                                </td>
                                                <input type="hidden" name="order_id" value="<?= $fetch_accounts['id']; ?>">
                                                <?php if ($fetch_accounts['role'] == 'user') { ?>
                                                    <td>
                                                        <div class="dropdown">
                                                
                                                            <a href="view_users.php?role=admin&id=<?= $fetch_accounts['id']; ?>"
                                                                class="btn btn-outline-success px-4">User</a>
                                                        </div>
                                                    </td>
                                                    <?php
                                                } else {
                                                    ?>
                                                        <td>
                                                            <div class="dropdown">
                                                
                                                                <a href="view_users.php?role=user&id=<?= $fetch_accounts['id']; ?>"
                                                                    class="btn btn-outline-warning px-3"> Admin </a>
                                                            </div>
                                                
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