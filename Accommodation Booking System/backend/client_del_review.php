<?php
  session_start();
  include_once 'tablecreation.php';
  
  //get accomodation id
  $booking_id=$_GET["id"];

  //checl whether the user is host

//SELECT * FROM `accountdetails` WHERE `userType` = 'host' ORDER BY `image` ASC
  $conn->query("DELETE FROM `review` WHERE `review`.`review_id` = $booking_id");
  
  
  header("Location: ../client_review.php");
?>