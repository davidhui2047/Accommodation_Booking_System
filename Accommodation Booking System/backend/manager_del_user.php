<?php
  session_start();
  include_once 'tablecreation.php';
  
  //get accomodation id
  $id=$_GET["id"];

  $conn->query("DELETE FROM `accountDetails` WHERE `accountDetails`.`account_id` = $id");
  
  
  header("Location: ../manager_user.php");
?>