<?php
  session_start();
  include_once 'tablecreation.php';
  
  //get accomodation id
  $id=$_GET["id"];

  $conn->query("DELETE FROM `review` WHERE `review`.`accommodationId` = $id");

  //get accommodation details
  $select_booking_id = "SELECT * FROM `bookingdetails` WHERE `bookingdetails`.`accommodationId` = $id";
  $get_booking_id = $conn->query($select_booking_id);
  $booking_id = mysqli_fetch_array($get_booking_id);
  $booking_id = $booking_id['booking_id'];

  echo $booking_id;

  $conn->query("DELETE FROM `guestdetails` WHERE `bookingId` = $booking_id");
  $conn->query("DELETE FROM `bookingdetails` WHERE `booking_id` = $booking_id");
  $conn->query("DELETE FROM `accomodationdetails` WHERE `accomodationdetails`.`accomodation_id` = $id");

  header("Location: ../host_house.php");
?>