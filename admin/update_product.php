<?php

include './includes/connect.php';
include './functions/admin_function.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}
;


?>

<?php include('./includes/header.php'); ?>



<div class="main-panel">
    <div class="content-wrapper">

        <div class="row d-flex justify-content-center mt-3">

            <div class="col-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Product</h4>

                        <?php
                        $update_id = $_GET['update'];
                        $show_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                        $show_products->execute([$update_id]);
                        if ($show_products->rowCount() > 0) {
                            while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
                                ?>


                                <form class="forms-sample" action="./view_product.php" method="POST"
                                    enctype="multipart/form-data">
                                    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                                    <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
                                    <div class="form-group d-flex justify-content-center">
                                        <img src="./uploaded_img/<?= $fetch_products['image']; ?>" class="img-fluid rounded-top"
                                            style="height: 20rem;" alt="">
                                    </div>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" value="<?= $fetch_products['name']; ?>"
                                            name="name" placeholder="Product Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-primary text-white">₹</span>
                                            </div>
                                            <input type="number" class="form-control" name="price" aria-label="Amount"
                                                value="<?= $fetch_products['price']; ?>" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category" class="form-control" required>
                                            <option value="<?= $fetch_products['category']; ?>" selected><?= $fetch_products['category']; ?></option>
                                            <option value="scope">Scope</option>
                                            <option value="softy">Softy</option>
                                            <option value="cone">Cone</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Product Image</label>
                                        <input type="file" name="image" class="file-upload-default">
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info" disabled
                                                placeholder="Upload Image">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                            </span>
                                        </div>
                                    </div>

                                    <button name="update" type="submit" class="btn btn-primary mr-2">Submit</button>
                                </form>

                                <?php
                            }
                        } else {
                            echo '<p class="empty">no products added yet!</p>';
                        }
                        ?>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>



<?php include('./includes/footer.php'); ?>