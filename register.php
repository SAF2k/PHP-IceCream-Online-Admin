<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: index.php");
    die();
}

//Load Composer's autoloader
require 'vendor/autoload.php';

include './functions/function.php';
include 'config/connect.php';

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $phone = $_POST['phone'];
    $phone = filter_var($phone, FILTER_SANITIZE_STRING);
    $password = sha1($_POST['password']);
    $password = filter_var($password, FILTER_SANITIZE_STRING);
    $cpassword = sha1($_POST['cpassword']);
    $cpassword = filter_var($cpassword, FILTER_SANITIZE_STRING);
    $code = filter_var(md5(rand()), FILTER_SANITIZE_STRING);
    $role="user";



    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);


    if ($select_user->rowCount() > 0) {
        msg("{$email} - This email address has been already exists.", "danger");
    } else {
        if ($password === $cpassword) {

            $insert_user = $conn->prepare("INSERT INTO users (name, email, number, password, code, role) VALUES (?,?,?,?,?,?)");
            $insert_user->execute([$name, $email, $phone, $password, $code, $role]);


            $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
            $select_user->execute([$email]);
            $row = $select_user->fetch(PDO::FETCH_ASSOC);

            if ($row > 0) {
                echo "<div style='display: none;'>";
                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                // try {
                //     //Server settings
                //     $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
                //     $mail->isSMTP(); //Send using SMTP
                //     $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
                //     $mail->SMTPAuth = true; //Enable SMTP authentication
                //     $mail->Username = 'your@email.com'; //SMTP username
                //     $mail->Password = 'yourPassword'; //SMTP password
                //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
                //     $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //     //Recipients
                //     $mail->setFrom('your@email.com');
                //     $mail->addAddress($email);

                //     //Content
                //     $mail->isHTML(true); //Set email format to HTML
                //     $mail->Subject = 'no reply';
                //     $mail->Body = 'Here is the verification link <b><a href="http://localhost/baker/login.php?verification=' . $code . '">Verify here</a></b>';

                //     $mail->send();
                //     echo 'Message has been sent';
                // } catch (Exception $e) {
                //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                // }
                echo "</div>";
                msg("We've send a verification link on your email address.", "info");
            } else {
                msg("Something wrong went.", "danger");
            }
        } else {
            msg("Password and Confirm Password do not match.", "danger");
        }
    }
}
?>

<?php include('./includes/header.php'); ?>

<section class="vh-100" style="background-color: #EAE36E;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-11">
                <div class="card" style="border-radius: 1rem;">
                    <div class="row g-0">
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

                                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Register your account
                                        here.</h5>

                                    <div class="form-outline mb-4">
                                        <input type="text" name="name" value="<?php if (isset($_POST['submit'])) {
                                            echo $name;
                                        } ?>" class="form-control form-control-lg" required />
                                        <label class="form-label">User Name</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="email" name="email" value="<?php if (isset($_POST['submit'])) {
                                            echo $email;
                                        } ?>" class="form-control form-control-lg" required />
                                        <label class="form-label">Email address</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="number" name="phone" value="<?php if (isset($_POST['submit'])) {
                                            echo $phone;
                                        } ?>" class="form-control form-control-lg" required />
                                        <label class="form-label">Phone number</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" name="password" class="form-control form-control-lg"
                                            required />
                                        <label class="form-label">Password</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" name="cpassword" class="form-control form-control-lg"
                                            required />
                                        <label class="form-label">Repeat your Password</label>
                                    </div>

                                    <div class="pt-1 mb-4">
                                        <button class="btn btn-dark btn-lg btn-block" name="submit"
                                            type="submit">Register</button>
                                    </div>

                                    <p class="mb-4 pb-lg-2" style="color: #393f81;">
                                        <a href="login.php" style="color: #393f81;">
                                            I am already member
                                        </a>
                                    </p>
                                </form>

                            </div>
                        </div>
                        <div class="col-md-6 col-lg-5 d-none d-md-block">
                            <img src="./img/candy-bg-blue.jpg" alt="login form" class="img-fluid"
                                style="border-radius: 0 1rem 1rem 0;" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php include('./includes/footer.php'); ?>