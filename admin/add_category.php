<?php

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:../index.php');
}

include './includes/connect.php';
include './functions/admin_function.php';


if (isset($_POST['add_category'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $select_category = $conn->prepare("SELECT * FROM `category` WHERE c_name = ?");
    $select_category->execute([$name]);

    if ($select_category->rowCount() > 0) {
        msg('Category Name Already Exists!', 'error');
    } else {
        $insert_category = $conn->prepare("INSERT INTO `category` (c_name) VALUES(?)");
        $insert_category->execute([$name]);

        msg('New Category Added!', 'success');
    }

}



if (isset($_GET['delete']) & isset($_GET['category'])) {
    $delete_id = $_GET['delete'];
    $c_name = $_GET['category'];
    $delete_category_select = $conn->prepare("SELECT * FROM `category` WHERE id = ?");
    $delete_category_select->execute([$delete_id]);
    $delete_category = $conn->prepare("DELETE FROM `category` WHERE id = ?");
    $delete_category->execute([$delete_id]);
    $delete_product_select = $conn->prepare("SELECT * FROM `category` WHERE id = ?");
    $delete_product_select->execute([$c_name]);
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE category = ?");
    $delete_product->execute([$c_name]);
    msg(' Category Deleted Successfully!', 'success');

}

?>


?>


<?php include('./includes/header.php'); ?>


<div class="main-panel">
    <div class="content-wrapper">

        <div class="col-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body col-6">
                    <h4 class="card-title">Add Category</h4>
                    <form class="form-group" method="POST" enctype="multipart/form-data" action="">
                        <div class="input-group">
                            <input type="text" class="form-control px-6" placeholder="Category Name" name="name"
                                aria-label="Category Name" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-primary" type="submit" name="add_category">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="content-wrapper">

            <div class="row">
                <div class="col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Category</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID#</th>
                                            <th>Category Name</th>
                                            <th>Remove</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $show_category = $conn->prepare("SELECT * FROM `category` ORDER BY `id` DESC");
                                    $show_category->execute();
                                    if ($show_category->rowCount() > 0) {
                                        while ($fetch_category = $show_category->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        #<?= $fetch_category['id']; ?>
                                                    </td>
                                                    <td>
                                                        <?= $fetch_category['c_name']; ?>
                                                    </td>
                                                    <td>

                                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                                            data-target="#deleteModal<?php echo $fetch_category['id'] ?>">Remove</button>
                                                    </td>
                                                </tr>

                                                <div id="deleteModal<?php echo $fetch_category['id'] ?>" class="modal fade"
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
                                                                    <?php echo $fetch_category['c_name']; ?>
                                                                </h3>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <a href="add_category.php?delete=<?= $fetch_category['id']; ?>&category=<?= $fetch_category['c_name']; ?>"
                                                                    class="btn btn-danger" onclick="return confirm;">delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div id="deleteModal<?php echo $fetch_category['id'] ?>" class="modal fade"
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
                                                                    <?php echo $fetch_category['c_name']; ?>
                                                                </h3>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <a href="add_category.php?delete=<?= $fetch_category['id']; ?>"
                                                                    class="btn btn-danger" onclick="return confirm;">delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </tbody>
                                            <?php
                                        }
                                    } else {
                                        echo '<p class="empty">No Category Added Yet!</p>';
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