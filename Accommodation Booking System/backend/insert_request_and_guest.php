<?php
session_start();
  include_once 'dbconn.php';
  $aid = $_GET["aid"];

  if (isset($_POST['submit'])) { 

    $uid = $_SESSION["id"];

    $aid = $_POST['aid']; 
    
    $num_guest = $_POST['num_guest'];

    $start_date = $_POST['start_date'];

    $end_date = $_POST['end_date'];

    $total_price = $_POST['total_price'];

    mysqli_query($conn, "INSERT INTO `bookingdetails` (`booking_id`, `checkIndate`, 
    `checkOutdate`, `numGuest`, `amount`, `paymentMade`, `hostConfirmation`, 
    `UserCancel`, `rejectReason`, `accommodationId`, `userId`) 
    VALUES (NULL, '$start_date', '$end_date', '$num_guest', '$total_price', '2', 
    '2', '2', '', '$aid', '$uid')");

    $select_booking_id = "SELECT MAX(booking_id) as id FROM `bookingDetails`";
    $get_booking_id = $conn->query($select_booking_id);
    $booking_id = $get_booking_id->fetch_assoc();

    $bid = $booking_id["id"];

    for ($x = 0; $x < $num_guest; $x++) {

      $fname = "fname" . strval($x); 

      $lname = "lname" . strval($x); 
  
      $email = "email" . strval($x); 
  
      $mobile = "mobile" . strval($x); 

      $fname = $_POST[$fname]; 

      $lname = $_POST[$lname]; 
  
      $email = $_POST[$email]; 
  
      $mobile = $_POST[$mobile]; 
      
      mysqli_query($conn, "INSERT INTO `guestdetails` (`guest_id`, `firstName`, `lastName`, `email`, `mobile`, `bookingId`) 
      VALUES (NULL, '$fname', '$lname', '$email', '$mobile', $bid)");

      header("Location: ../index.php");
    }

  }
?>