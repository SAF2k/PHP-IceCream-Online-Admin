<?php

include 'config/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}
;

include 'includes/add_cart.php';

?>

<!-- Header Start -->
<?php include('./includes/header.php'); ?>
<!-- Header End -->


<!-- Page Header Start -->
<div class="container-fluid page-header mb-1 py-6 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center pt-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">Our Menu</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Menu</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->


<!-- collection -->
<section id="collection" class="py-5">
    <div class="container">
        <div class="title text-center">
            <h2 class="position-relative d-inline-block">List of Ice Cream</h2>
        </div>

        <div class="row g-0">
            <div class="d-flex flex-wrap justify-content-center mt-5 filter-button-group">
                <button type="button" class="btn m-2 text-dark active-filter-btn btn-menu" data-filter="*">All</button>
                <button type="button" class="btn m-2 text-dark btn-menu" data-filter=".cone">Cone</button>
                <button type="button" class="btn m-2 text-dark btn-menu" data-filter=".scope">Scope</button>
                <button type="button" class="btn m-2 text-dark btn-menu" data-filter=".cake">Cake</button>
            </div>

            <div class="collection-list mt-4 row gx-0 gy-3">


                <?php
                $select_products = $conn->prepare("SELECT * FROM `products`");
                $select_products->execute();
                if ($select_products->rowCount() > 0) {
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                        ?>


                        <div class="col-md-6 col-lg-4 col-xl-3 p-2 rounded shadow feat <?= $fetch_products['category']; ?>">
                            <form action="" method="post">
                                <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                                <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                                <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                                <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                                <input type="hidden" name="qty" value="1">
                                        <div class="collection-img position-relative">
                                            <img src="uploaded_img/<?= $fetch_products['image']; ?> " class="w-100 rounded-3 mb-3">
                                </div>
                                <div class="d-flex justify-content-around">
                                    <p class="text-capitalize my-1">
                                        <?= $fetch_products['category']; ?>
                                    </p>
                                    <span class="fw-bold">
                                        <?= $fetch_products['name']; ?>
                                    </span>
                                </div>
                                <div class="text-center">
                                    <span class="fw-bold">$
                                        <?= $fetch_products['price']; ?>
                                    </span>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" name="add_to_cart" class="btn btn-warning btn-block btn-sm btn-menu">Add To Cart</button>
                                </div>

                            </form>
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
</section>
<!-- end of collection -->




<!-- Footer Start -->
<?php include('./includes/footer.php'); ?>
<!-- Footer End -->