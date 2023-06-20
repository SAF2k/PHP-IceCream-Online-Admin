<?php

session_start();

include 'config/connect.php';

include 'includes/add_cart.php';

?>

<!-- Header Start -->
<?php include('./includes/header.php'); ?>
<!-- Header End -->


<!-- Carousel Start -->
<div class="container-fluid p-0 pb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="owl-carousel header-carousel position-relative">
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="img/carousel-1.jpg" alt="">
            <div class="owl-carousel-inner">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-lg-8">
                            <p class="text-primary text-uppercase fw-bold mb-2">// The Best Ice Cream Parlour</p>
                            <h1 class="display-1 text-light mb-4 animated slideInDown">We Serve The best</h1>
                            <p class="text-light fs-5 mb-4 pb-3">Vero elitr justo clita lorem. Ipsum dolor sed stet sit
                                diam rebum ipsum.</p>
                            <a href="" class="btn btn-primary rounded-pill py-3 px-5">See Menu</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="img/carousel-2.jpg" alt="">
            <div class="owl-carousel-inner">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-lg-8">
                            <p class="text-primary text-uppercase fw-bold mb-2">// The Best Ice Cream Parlour</p>
                            <h1 class="display-1 text-light mb-4 animated slideInDown">We Serve The best</h1>
                            <p class="text-light fs-5 mb-4 pb-3">Vero elitr justo clita lorem. Ipsum dolor sed stet sit
                                diam rebum ipsum.</p>
                            <a href="" class="btn btn-primary rounded-pill py-3 px-5">See Menu</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Carousel End -->

<!-- Product Start -->
<div class="container-xxl bg-light my-6 py-6 pt-0">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <h1 class="display-6 mb-4 pt-5">Explore The Categories Of Our Ice Creams</h1>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="product-item d-flex flex-column bg-white rounded overflow-hidden h-100">
                    <div class="text-center p-4">
                        <div class="d-inline-block border border-primary rounded-pill px-3 mb-3">₹11 - ₹99</div>
                        <h3 class="mb-3">Cake</h3>
                        <span>Tempor erat elitr rebum at clita dolor diam ipsum sit diam amet diam et eos</span>
                    </div>
                    <div class="position-relative mt-auto">
                        <img class="img-fluid" src="img/product-1.jpg" alt="">
                        <div class="product-overlay">
                            <a class="btn btn-lg-square btn-outline-light rounded-circle" href=""><i
                                    class="fa fa-eye text-primary"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="product-item d-flex flex-column bg-white rounded overflow-hidden h-100">
                    <div class="text-center p-4">
                        <div class="d-inline-block border border-primary rounded-pill pt-1 px-3 mb-3">₹11 - ₹99</div>
                        <h3 class="mb-3">Bread</h3>
                        <span>Tempor erat elitr rebum at clita dolor diam ipsum sit diam amet diam et eos</span>
                    </div>
                    <div class="position-relative mt-auto">
                        <img class="img-fluid" src="img/product-2.jpg" alt="">
                        <div class="product-overlay">
                            <a class="btn btn-lg-square btn-outline-light rounded-circle" href=""><i
                                    class="fa fa-eye text-primary"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="product-item d-flex flex-column bg-white rounded overflow-hidden h-100">
                    <div class="text-center p-4">
                        <div class="d-inline-block border border-primary rounded-pill pt-1 px-3 mb-3">₹11 - ₹99</div>
                        <h4 class="mb-3">Cookies</h4>
                        <span>Tempor erat elitr rebum at clita dolor diam ipsum sit diam amet diam et eos</span>
                    </div>
                    <div class="position-relative mt-auto">
                        <img class="img-fluid" src="img/product-3.jpg" alt="">
                        <div class="product-overlay">
                            <a class="btn btn-lg-square btn-outline-light rounded-circle" href=""><i
                                    class="fa fa-eye text-primary"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product End -->

<!-- collection -->
<section id="collection" class="py-5">
    <div class=" container wow fadeInUp" data-wow-delay="0.1s">
        <div class=" title text-center">
            <h1 class="position-relative d-inline-block">Experience Our New</h1>
        </div>

        <div class="row g-0 wow fadeInUp" data-wow-delay="0.1s">


            <div class="collection-list mt-4 row gx-0 gy-3">
                <?php
                $select_products = $conn->prepare("SELECT * FROM `products` ORDER BY `id` DESC LIMIT 4");
                $select_products->execute();
                if ($select_products->rowCount() > 0) {
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                        ?>


                        <div class="col-md-6 col-lg-4 col-xl-3 p-2 shadow ">
                            <a href="./menu.php">
                                <div class="collection-img position-relative wow fadeInUp" data-wow-delay="0.05s">
                                    <img src="uploaded_img/<?= $fetch_products['image']; ?>"
                                        class="position-relative w-100 h-100 rounded-3">
                                </div>
                                <div class="text-center">
                                    <p class="text-capitalize my-1">
                                        <?= $fetch_products['name']; ?>
                                    </p>
                                    <span class="fw-bold">₹
                                        <?= $fetch_products['price']; ?>
                                    </span>
                                </div>
                            </a>
                        </div>


                        <?php
                    }
                } else {
                    echo '<h3 class="empty">no products added yet!</h3>';
                }
                ?>
            </div>
        </div>
    </div>
</section>
<!-- end of collection -->



<!-- Service Start -->
<?php include('./includes/service.php'); ?>
<!-- Service end -->

<!-- Testimonial Start -->
<?php include('./includes/testimonial.php'); ?>
<!-- Testimonial End -->


<!-- Footer Start -->
<?php include('./includes/footer.php'); ?>
<!-- Footer End -->