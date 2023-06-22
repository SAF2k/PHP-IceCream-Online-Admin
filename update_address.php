<?php

include 'config/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:home.php');
}
;

if (isset($_POST['submit'])) {

    if (empty($_POST['flat']) || empty($_POST['building']) || empty($_POST['area']) || empty($_POST['town']) || empty($_POST['city']) || empty($_POST['pin_code'])) {
        $message[] = 'please fill all the fields!';
    } else {

        $address = $_POST['flat'] . ', ' . $_POST['building'] . ', ' . $_POST['area'] . ', ' . $_POST['town'] . ', ' . $_POST['city'] . ',  - ' . $_POST['pin_code'];
        $address = filter_var($address, FILTER_SANITIZE_STRING);

        $update_address = $conn->prepare("UPDATE `users` set address = ? WHERE id = ?");
        $update_address->execute([$address, $user_id]);

        $message[] = 'address saved!';
        header('location:profile.php');
    }

}

?>

<!-- Header Start -->
<?php include 'includes/header.php'; ?>
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


<div class="container px-12 my-6">

    <div class=" wow fadeInUp d-flex justify-content-center border border-primary py-5 rounded-3" data-wow-delay="0.1">
        <form action="" method="post" class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
            <div class="row g-3">
                <div class="col-12 text-center">
                    <h4>Tell us Something!</h4>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control border-primary" placeholder="Flat No." name="flat" required>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control border-primary" placeholder="Building No." name="building"
                        required>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control border-primary" placeholder="Area Name" name="area" required>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control border-primary" placeholder="Town" name="town" required>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control border-primary" placeholder="City" name="city" required>
                </div>
                <div class="col-12">
                    <input type="number" class="form-control border-primary" placeholder="Pin Code" name="pin_code"
                        maxlength="6" required>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <button type="submit" name="submit"
                        class="btn btn-primary border-secondary col-lg-4">Submit</button>
                </div>
            </div>
        </form>
    </div>

</div>

<!-- Footer Start  -->
<?php include 'includes/footer.php'; ?>
<!-- Footer End  -->