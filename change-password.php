<?php

session_start();

include './config/config.php';
include './functions/function.php';

if (isset($_GET['reset'])) {
    if (mysqli_num_rows(mysqli_query($conn1, "SELECT * FROM users WHERE code='{$_GET['reset']}'")) > 0) {
        if (isset($_POST['submit'])) {
            $password = mysqli_real_escape_string($conn1, md5($_POST['password']));
            $confirm_password = mysqli_real_escape_string($conn1, md5($_POST['cpassword']));

            if ($password === $confirm_password) {
                $query = mysqli_query($conn1, "UPDATE users SET password='{$password}', code='' WHERE code='{$_GET['reset']}'");

                if ($query) {
                    header("Location: index.php");
                }
            } else {
                msg("<div class='alert alert-danger'>Password and Confirm Password do not match.</div>");
            }
        }
    } else {
        msg("<div class='alert alert-danger'>Reset Link do not match.</div>");
    }
} else {
    header("Location: forgot-password.php");
}

?>

<?php include('./includes/header.php'); ?>

<section class="vh-100" style="background-color: #DCCCFE;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card" style="border-radius: 1rem;">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-4 d-none d-md-block">
                            <img src="./image/candy-bg-blue.jpg" alt="login form" class="img-fluid"
                                style="border-radius: 1rem 0 0 1rem;" />
                        </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5 text-black">

                                <?php
                                if (isset($_SESSION['message'])) {
                                    echo $_SESSION['message'];
                                    unset($_SESSION['message']);
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
                                            <input type="password" name="password"
                                                class="form-control form-control-lg" required/>
                                            <label class="form-label">Password</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="password" name="cpassword"
                                                class="form-control form-control-lg" required/>
                                            <label class="form-label">Repeat your Password</label>
                                        </div>

                                    <div class="pt-1 mb-4">
                                        <button class="btn btn-dark btn-lg btn-block" name="submit"
                                            type="submit">Login</button>
                                    </div>

                                      <p class="mb-5 pb-lg-2" style="color: #393f81;">Back to! <a
                                            href="login.php" style="color: #393f81;">login</a></p>
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