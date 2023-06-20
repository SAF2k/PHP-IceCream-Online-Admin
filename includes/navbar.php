<?php
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}
;
?>


<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
    <a class = "navbar-brand d-flex justify-content-between align-items-center order-lg-0" href = "index.php">
                <h1 class="text-primary m-0">Kushi</h1>
            </a>

            <div class = "order-lg-2 nav-btns">

                <?php
                $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $count_cart_items->execute([$user_id]);
                $total_cart_items = $count_cart_items->rowCount();
                ?>

                <a href="cart.php" class = "btn position-relative">
                    <i class = "fa fa-shopping-cart text-light"></i>
                    <span class = "position-absolute top-0 start-100 translate-middle badge bg-primary"><?= $total_cart_items; ?></span>
                </a>
                <a href="login.php" class = "btn position-relative">
                    <i class = "fa fa-user text-light"></i>
                </a>

            </div>

            <button class = "navbar-toggler border-0" type = "button" data-bs-toggle = "collapse" data-bs-target = "#navMenu">
                <span class = "navbar-toggler-icon"></span>
            </button>

            <div class = "collapse navbar-collapse order-lg-1" id = "navMenu">
                <ul class = "navbar-nav mx-auto text-center">
                    <li class = "nav-item px-2 py-2">
                        <a class = "nav-link text-uppercase active" href = "index.php">home</a>
                    </li>
                    <li class = "nav-item px-2 py-2">
                        <a class = "nav-link text-uppercase" href = "menu.php">menu</a>
                    </li>
                    <li class = "nav-item px-2 py-2">
                        <a class = "nav-link text-uppercase" href = "orders.php">orders</a>
                    </li>
                    <li class = "nav-item px-2 py-2">
                        <a class = "nav-link text-uppercase" href = "about.php">about us</a>
                    </li>
                    <li class = "nav-item px-2 py-2 border-0">
                        <a class = "nav-link text-uppercase" href = "contact.php">contact us</a>
                    </li>
                </ul>
            </div>
            
</nav>
<!-- Navbar End -->
