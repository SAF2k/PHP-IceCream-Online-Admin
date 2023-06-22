<?php
session_start();

?>

<!-- Header Start -->
<?php include('includes/header.php'); ?>
<!-- Header End -->


<!-- Page Header Start -->
<div class="container-fluid page-header py-6 mb-3 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center pt-5 pb-3">
        <h1 class="display-4 text-white animated slideInDown mb-3">Profile</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Profile</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<div class="container">
    <?php
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_user->execute([$user_id]);
    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class=" col-lg-12 title text-center mb-5">
        <h2 class="position-relative d-inline-block my-5">YOUR PROFILE</h2>

        <div
            class="row g-4 my-2 py-3 d-flex justify-content-around align-item-center border border-secondary rounded shadow text-center">
            <div class="collection-img position-relative col-lg-4">
                <img height="200vh" width="200vh" src="user_img/face-<?= $fetch_user['image']; ?>.png" class="rounded mb-3">
            </div>
            <p><i class="fas fa-user"></i><span>
                    <?= $fetch_user['name']; ?>
                </span></p>
            <p><i class="fas fa-phone"></i><span>
                    <?= $fetch_user['number']; ?>
                </span></p>
            <p><i class="fas fa-envelope"></i><span>
                    <?= $fetch_user['email']; ?>
                </span></p>
            <a href="update_profile.php" class="btn btn-primary col-lg-3 col-md-6">update info</a>
            <p><i class="fas fa-map-marker-alt"></i><span>
                    <?= $fetch_user['address']; ?>
                </span></p>
            <a href="update_address.php" class="btn btn-outline-primary col-lg-3">update address</a>




        </div>

    </div>
</div>


<!-- footer Start -->
<?php include('includes/footer.php'); ?>
<!-- footer End -->