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

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $image = $_POST['image'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);

    if (!empty($name)) {
        $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
        $update_name->execute([$name, $user_id]);
        header('location:profile.php');
    }

    if (!empty($email)) {
        $select_email = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select_email->execute([$email]);
        if ($select_email->rowCount() > 0) {
            $message[] = 'email already taken!';
        } else {
            $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
            $update_email->execute([$email, $user_id]);
        }
    }

    if (!empty($number)) {
        $select_number = $conn->prepare("SELECT * FROM `users` WHERE number = ?");
        $select_number->execute([$number]);
        if ($select_number->rowCount() > 0) {
            $message[] = 'number already taken!';
        } else {
            $update_number = $conn->prepare("UPDATE `users` SET number = ? WHERE id = ?");
            $update_number->execute([$number, $user_id]);
        }
    }

    if (!empty($image)) {
        $select_image = $conn->prepare("SELECT * FROM `users` WHERE image = ?");
        $select_image->execute([$image]);
        if ($image <= 0 || $image > 10) {
            $message[] = 'image already taken!';
        } else {
            $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
            $update_image->execute([$image, $user_id]);
        }
    }

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $select_prev_pass = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
    $select_prev_pass->execute([$user_id]);
    $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
    $prev_pass = $fetch_prev_pass['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

    if ($old_pass != $empty_pass) {
        if ($old_pass != $prev_pass) {
            $message[] = 'old password not matched!';
        } elseif ($new_pass != $confirm_pass) {
            $message[] = 'confirm password not matched!';
        } else {
            if ($new_pass != $empty_pass) {
                $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
                $update_pass->execute([$confirm_pass, $user_id]);
                $message[] = 'password updated successfully!';

            } else {
                $message[] = 'please enter a new password!';
            }
        }
    }

}

if (isset($_SESSION['user_id'])) {
    $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_profile->execute([$user_id]);
    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

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
            <div class="row g-3 d-flex justify-content-center">
                <div class="col-7 text-center">
                    <h4>Tell us Something!</h4>
                </div>
                <div class="col-8">
                    <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" class="form-control border-primary"
                        maxlength="50">
                </div>
                <div class="col-8">
                    <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" class="form-control border-primary"
                        maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="col-8">
                    <input type="number" name="number" placeholder="<?= $fetch_profile['number']; ?>"" class=" form-control border-primary"
                        min="0" max="9999999999" maxlength="10">
                </div>
                 <div class="col-8">
                    <input type="number" name="image" placeholder="<?= $fetch_profile['image']; ?>" class="form-control border-primary" max="10"
                        maxlength="2">
                </div>
                <div class="col-8">
                   <input type="password" name="old_pass" placeholder="enter your old password" class="form-control border-primary" maxlength="50"
                    oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="col-8">
                     <input type="password" name="new_pass" placeholder="enter your new password" class="form-control border-primary" maxlength="50"
                    oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="col-8">
                     <input type="password" name="confirm_pass" placeholder="confirm your new password" class="form-control border-primary"
                    maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="col-8 d-flex justify-content-center">
                    <button type="submit" name="submit"
                        class="btn btn-primary border-secondary col-lg-4">Update Now</button>
                </div>
            </div>
        </form>
    </div>

</div>



<!-- Footer Start  -->
<?php include 'includes/footer.php'; ?>
<!-- Footer End  -->