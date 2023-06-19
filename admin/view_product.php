<?php

include './includes/connect.php';
include './functions/admin_function.php';

session_start();

// $admin_id = $_SESSION['admin_id'];

// if (!isset($admin_id)) {
//     header('location:admin_login.php');
// }
// ;


if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('./uploaded_img/' . $fetch_delete_image['image']);
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);
    msg('Product Deleted Successfully!', 'error');
    // header('location:view_product.php');

}

if (isset($_POST['update'])) {

    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);

    $update_product = $conn->prepare("UPDATE `products` SET name = ?, category = ?, price = ? WHERE id = ?");
    $update_product->execute([$name, $category, $price, $pid]);


    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = './uploaded_img/' . $image;

    if (!empty($image)) {
        if ($image_size > 2000000) {
            msg('Images size is too large!', 'error');
        } else {
            $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
            $update_image->execute([$image, $pid]);
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('./uploaded_img/' . $old_image);
            msg('Image Updated Successfully!', 'success');
        }
    }

    msg('Product Updated!', 'success');
    // header('location:view_product.php');

}


?>

<?php include('./includes/header.php'); ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">View Products</h3>
        </div>


        <div class="row">
            <?php
            $show_products = $conn->prepare("SELECT * FROM `products`");
            $show_products->execute();
            if ($show_products->rowCount() > 0) {
                while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
                    ?>

                    <div class="card m-3" style="max-width: 18rem;">
                        <img src="./uploaded_img/<?= $fetch_products['image']; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title m-1">
                                <?= $fetch_products['name']; ?>
                            </h5>
                            <div class="d-flex justify-content-between mt-3">
                                <p>
                                    <?= $fetch_products['category']; ?>
                                </p>
                                <p>
                                    <?= $fetch_products['price']; ?>
                                </p>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="update_product.php?update=<?= $fetch_products['id']; ?>"
                                    class="btn btn-primary">update</a>
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#deleteModal<?php echo $fetch_products['id'] ?>">delete</button>
                            </div>
                        </div>


                        <div id="deleteModal<?php echo $fetch_products['id'] ?>" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Details</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <h4>
                                            Are you sure you want to delete?
                                        </h4>
                                        <h3>
                                            Product : <?php echo $fetch_products['name']; ?>
                                        </h3>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a href="view_product.php?delete=<?= $fetch_products['id']; ?>" class="btn btn-danger"
                                            onclick="return confirm;">delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <?php
                }
            } else {
                echo '<p class="empty">no products added yet!</p>';
            }
            ?>

        </div>
    </div>

</div>


<?php include('./includes/footer.php'); ?>