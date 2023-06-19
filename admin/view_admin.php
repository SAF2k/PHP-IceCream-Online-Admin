<?php include('./includes/connect.php'); ?>

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
                                    </tr>
                                </thead>
                                <?php
                                $select_account = $conn->prepare("SELECT * FROM `users` WHERE role=?");
                                $select_account->execute(["admin"]);
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