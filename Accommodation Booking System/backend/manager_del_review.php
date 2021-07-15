<?php
  session_start();
  include_once 'tablecreation.php';
  
  //get accomodation id
  $id=$_GET["id"];

  $conn->query("DELETE FROM `review` WHERE `review`.`review_id` = $id");
  
  header("Location: ../manager_review.php");
?>