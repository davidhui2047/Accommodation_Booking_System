<?php
  session_start();
  include_once 'tablecreation.php';
  
  //get booking id
  $bid=$_GET["id"];

  $conn->query("DELETE FROM `guestdetails` WHERE `guestdetails`.`bookingId` = $bid");
  $conn->query("DELETE FROM `bookingdetails` WHERE `bookingdetails`.`booking_id` = $bid");
  
  header("Location: ../manager_booking.php");
?>