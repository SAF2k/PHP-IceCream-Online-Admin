<?php

include './includes/connect.php';
include './functions/admin_function.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}
;

if (isset($_POST['add_product'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;

    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_products->execute([$name]);

    if ($select_products->rowCount() > 0) {
        msg('Product Name Already Exists!', 'error');
    } else {
        if ($image_size > 2000000) {
            msg('Image Size is too Large', 'error');
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);

            $insert_product = $conn->prepare("INSERT INTO `products`(name, category, price, image) VALUES(?,?,?,?)");
            $insert_product->execute([$name, $category, $price, $image]);

            msg('New Product Added!', 'success');
        }

    }

}

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/' . $fetch_delete_image['image']);
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);
    msg(' product Deleted Successfully!', 'success');
    header('location:products.php');

}

?>

<?php include('./includes/header.php'); ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add Products</h3>
        </div>

        <div class="row">

            <div class="col-12 grid-margin stretch-card">
                <div class="card d-flex justify-content-center">
                    <div class="card-body">
                        <h4 class="card-title">Add Products</h4>
                        <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="exampleInputName1">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Product Name" required>
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-primary text-white">₹</span>
                                    </div>
                                    <input type="number" class="form-control" name="price" aria-label="Amount"
                                        step="any" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category" class="form-control" required>
                                    <option value="" disabled selected>-- select category --</option>

                                    <?php
                                    $show_category = $conn->prepare("SELECT * FROM `category`");
                                    $show_category->execute();
                                    if ($show_category->rowCount() > 0) {
                                        while ($fetch_category = $show_category->fetch(PDO::FETCH_ASSOC)) {
                                            ?>

                                            <option value="<?= $fetch_category['c_name']; ?>"><?= $fetch_category['c_name']; ?></option>
                                            
                                            <?php
                                        }
                                    } else {
                                        echo '<p class="empty">no products added yet!</p>';
                                    }
                                    ?>
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

                            <button name="add_product" type="submit" class="btn btn-primary mr-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Recently Add Products</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Image</th>
                                        <th>Update</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <?php
                                $show_products = $conn->prepare("SELECT * FROM `products` ORDER BY `id` DESC LIMIT 4");
                                $show_products->execute();
                                if ($show_products->rowCount() > 0) {
                                    while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <?= $fetch_products['id']; ?>
                                                </td>
                                                <td>
                                                    <?= $fetch_products['name']; ?>
                                                </td>
                                                <td>
                                                    <?= $fetch_products['category']; ?>
                                                </td>
                                                <td>
                                                    <?= $fetch_products['price']; ?>
                                                </td>
                                                <td>
                                                    <img src="../uploaded_img/<?= $fetch_products['image']; ?>" height="100"
                                                        width="100">
                                                </td>
                                                <td>
                                                    <a href="update_product.php?update=<?= $fetch_products['id']; ?>"
                                                        class="btn btn-primary">update</a>
                                                </td>
                                                <td>

                                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                                        data-target="#deleteModal<?php echo $fetch_products['id'] ?>">delete</button>
                                                </td>
                                            </tr>


                                            <div id="deleteModal<?php echo $fetch_products['id'] ?>" class="modal fade"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Details</h4>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4>
                                                                Are you sure you want to delete?
                                                            </h4>
                                                            <h3>
                                                                <?php echo $fetch_products['name']; ?>
                                                            </h3>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <a href="view_product.php?delete=<?= $fetch_products['id']; ?>"
                                                                class="btn btn-danger" onclick="return confirm;">delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </tbody>
                                        <?php
                                    }
                                } else {
                                    echo '<p class="empty">no products added yet!</p>';
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