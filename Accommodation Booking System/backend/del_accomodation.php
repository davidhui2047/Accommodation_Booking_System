<?php
  session_start();
  include_once 'tablecreation.php';
  
  //get accomodation id
  $id=$_GET["id"];
  echo $id;

  $conn->query("DELETE FROM `accomodationdetails` WHERE `accomodationdetails`.`accomodation_id` = $id");
  
  

  header("Location: ../manager_accomodation.php");
?>