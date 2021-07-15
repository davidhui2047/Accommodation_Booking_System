<?php
  session_start();
  include_once 'tablecreation.php';
  
  //get accomodation id
  $booking_id = $_GET["id"];

  $conn->query("UPDATE `bookingdetails` SET `paymentMade` = '1' WHERE `bookingdetails`.`booking_id` = $booking_id");

  $select_accommodationId_userID = "SELECT * FROM `bookingdetails` WHERE `booking_id` = $booking_id";
  $get_accommodationId_userID = $conn->query($select_accommodationId_userID);
  $accommodationId_userID = mysqli_fetch_array($get_accommodationId_userID);
  $accommodationId = $accommodationId_userID["accommodationId"];
  $userID = $accommodationId_userID["userId"];


  $select_host_user_id = "SELECT hostdetails.host_id, bookingdetails.booking_id FROM bookingdetails 
  INNER JOIN accomodationdetails ON accomodationdetails.accomodation_id = bookingdetails.accommodationId 
  INNER JOIN hostdetails ON hostdetails.host_id = accomodationdetails.hostID 
  where bookingdetails.booking_id = $booking_id" ;

  $get_host_user_id = $conn->query($select_host_user_id);
  $host_user_id = mysqli_fetch_array($get_host_user_id);
  $host_user_id = $host_user_id["host_id"];

  mysqli_query($conn, "INSERT INTO `review` (`review_id`, `accomodationReview`, `accomodationRate`, 
  `hostReview`, `hostRate`, `userId`, `accommodationId`, `hostID`) VALUES 
  (NULL, NULL, NULL, NULL, NULL, '$userID', '$accommodationId', '$host_user_id')");

  //echo $userID;
  //echo $accommodationId;
  //echo $host_user_id;

  header("Location: ../client_request.php");
?>



