<?php

session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    die();
}

include './config/connect.php';
include './functions/function.php';

if (isset($_GET['verification'])) {

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE code= ?");
    $select_user->execute([$_GET['verification']]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($row > 0) {
        $update_code = $conn->prepare("UPDATE `users` SET code = ? WHERE code = ?");
       if($update_code->execute(['',$_GET['verification']])){
        msg("Your account has been verified successfully.", "success");
       }
    } else {
        header("Location: index.php");
    }
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $password = sha1($_POST['password']);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select_user->execute([$email, $password]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);


    if ($select_user->rowCount() > 0) {

        if (empty($row['code'])) {
            if($row['role'] == "admin") {
                $_SESSION['admin_id'] = $row['id'];
                header("Location: admin/index.php");
            } else {
                $_SESSION['user_id'] = $row['id'];
                header("Location: index.php");
            }
        } else {
            msg("First verify your account and try again.", "danger");
        }
    } else {
        msg("Email or password do not match.", "danger");
    }
}
?>


<?php include('./includes/header.php'); ?>

<section class="vh-100" style="background-color: #95DED3;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card" style="border-radius: 1rem;">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-4 d-none d-md-block">
                            <img src="./image/cone-bg-pink.jpg" alt="login form" class="img-fluid"
                                style="border-radius: 1rem 0 0 1rem;" />
                        </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5 text-black">

                                <?php
                                if (isset($_SESSION['message'])) { ?>
                                    <div class='alert alert-<?= $_SESSION['method']; ?>'>
                                        <?= $_SESSION['message']; ?>
                                    </div>
                                    <?php
                                    unset($_SESSION['message']);
                                    unset($_SESSION['method']);
                                }
                                ?>

                                <form action="" method="post">

                                    <div class="d-flex align-items-center mb-3 pb-1">
                                        <span class="h1 fw-bold mb-0"
                                            style="font-family: 'Rubik Bubbles', cursive; color: pink;">
                                            KUSHI
                                        </span>
                                    </div>

                                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your
                                        account</h5>

                                    <div class="form-outline mb-4">
                                        <input type="email" class="form-control form-control-lg" name="email" value="<?php if (isset($_POST['submit'])) {
                                            echo $email;
                                        } ?>" required />
                                        <label class="form-label">Email address</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" name="password" class="form-control form-control-lg"
                                            required />
                                        <label class="form-label">Password</label>
                                    </div>

                                    <div class="pt-1 mb-4">
                                        <button class="btn btn-dark btn-lg btn-block" name="submit"
                                            type="submit">Login</button>
                                    </div>

                                    <a class="small text-muted" href="forgot-password.php">Forgot password?</a>
                                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a
                                            href="register.php" style="color: #393f81;">Register here</a></p>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('./includes/footer.php'); ?>