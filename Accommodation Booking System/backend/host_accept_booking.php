<?php
  session_start();
  if (isset($_POST['submit'])) { 
    include_once 'tablecreation.php';
    $booking_id = $_GET["id"];

    mysqli_query($conn, "UPDATE `bookingdetails` SET `hostConfirmation` = 1 
    WHERE `bookingdetails`.`booking_id` = '$booking_id'");

    header("Location: ../host_request.php");
  } else {
    header("Location: ../404.html");
 }
?>