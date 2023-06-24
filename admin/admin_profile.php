<?php

include('./includes/connect.php');
include './functions/admin_function.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    if (!empty($name)) {
        $select_name = $conn->prepare("SELECT * FROM `users` WHERE name = ?");
        $select_name->execute([$name]);
        if ($select_name->rowCount() > 0) {
            msg('username already taken!','error');
        } else {
            $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
            $update_name->execute([$name, $admin_id]);
        }
    }

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $select_old_pass = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
    $select_old_pass->execute([$admin_id]);
    $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
    $prev_pass = $fetch_prev_pass['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

    if ($old_pass != $empty_pass) {
        if ($old_pass != $prev_pass) {
            msg('old password not matched!','error');
        } elseif ($new_pass != $confirm_pass) {
            msg('confirm password not matched!','error');
        } else {
            if ($new_pass != $empty_pass) {
                $update_pass = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
                $update_pass->execute([$confirm_pass, $admin_id]);
               msg('password updated successfully!','success');
            } else {
                msg('please enter a new password!','warning');
            }
        }
    }

}

?>

<?php include('./includes/header.php'); ?>


<div class="main-panel">
    <div class="content-wrapper">

        <div class="row d-flex justify-content-center align-items-center mt-5">

            <div class="col-6 stretch-card">
                <div class="card d-flex justify-content-center">
                    <div class="card-body">
                        <h4 class="card-title">Update Profile</h4>

                        <?php
                        $select_admin = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                        $select_admin->execute(["$admin_id"]);
                        $fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <form class="forms-sample" method="POST">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="name"
                                    placeholder="Username">
                            </div>
                             <div class="form-group">
                                <label>Old Password</label>
                                <input type="password" class="form-control" name="old_pass"
                                    placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" class="form-control" name="new_pass"
                                    placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password" class="form-control" name="confirm_pass"
                                    placeholder="Password">
                            </div>
                            <button name="submit" type="submit" class="btn btn-primary mr-2">Submit</button>
                        </form>


                    </div>
                </div>
            </div>

        </div>

    </div>
</div>



<?php include('./includes/footer.php'); ?>