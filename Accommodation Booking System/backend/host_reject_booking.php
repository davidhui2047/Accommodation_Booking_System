<?php
  session_start();
  if (isset($_POST['submit'])) { 
    include_once 'tablecreation.php';
    $booking_id = $_GET["id"];

    $reason = $_POST["reason"];

    mysqli_query($conn, "UPDATE `bookingdetails` SET `hostConfirmation` = 0,  `rejectReason` = '$reason'
    WHERE `bookingdetails`.`booking_id` = '$booking_id'");

    header("Location: ../host_request.php");
  } else {
    header("Location: ../404.html");
 }
?>