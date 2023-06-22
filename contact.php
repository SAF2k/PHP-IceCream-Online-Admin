<?php

include 'config/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}
;

if (isset($_POST['send'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
    $select_message->execute([$name, $email, $number, $msg]);

    if ($select_message->rowCount() > 0) {
        $message[] = 'already sent message!';
    } else {

        $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
        $insert_message->execute([$user_id, $name, $email, $number, $msg]);

        $message[] = 'sent message successfully! ';

    }

}

?>


<?php include 'includes/header.php'; ?>


<!-- Page Header Start -->
<div class="container-fluid page-header mb-1 py-6 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center pt-5">
        <h1 class="display-4 text-white animated slideInDown mb-3">Contact Us</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Contact us</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->


<div class="container-xxl py-6">
    <div class="container">
        <div class="row g-2 d-flex justify-content-between align-items-center">
            <div class="wow fadeInUp col-md-6 col-lg-4 d-none d-md-block" data-wow-delay="0.1">
                <img class="img-fluid rounded" src="./img/contact-img.svg" alt="">
            </div>

            <div class="col-sm-6 wow fadeInUp d-flex justify-content-center border border-primary py-5 rounded-3"
                data-wow-delay="0.1">
                <form action="contact.php" method="post" class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="row g-3">
                        <div class="col-12">
                            <h4>Tell us Something!</h4>
                        </div>
                        <div class="col-12">
                            <input type="text" class="form-control border-primary" placeholder="Name" name="name"
                                required>
                        </div>
                        <div class="col-12">
                            <input type="number" class="form-control border-primary" placeholder="Number" name="number"
                                maxlength="10" required>
                        </div>
                        <div class="col-12">
                            <input type="email" class="form-control border-primary" placeholder="Email" name="email"
                                required>
                        </div>
                        <div class="col-12">
                            <textarea class="form-control border-primary" placeholder="Message" name="msg"
                                maxlength="500" required></textarea>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <button type="submit" name="send" class="btn btn-primary border-secondary">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<?php include 'includes/footer.php'; ?>

