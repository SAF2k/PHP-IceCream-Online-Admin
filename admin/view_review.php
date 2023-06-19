<?php 

include('./includes/connect.php');

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
    $delete_message->execute([$delete_id]);
    header('location:messages.php');
}

?>

<?php include('./includes/header.php'); ?>




<?php include('./includes/footer.php'); ?>