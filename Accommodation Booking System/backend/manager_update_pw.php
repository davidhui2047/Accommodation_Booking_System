<?php
  session_start();
  if (isset($_POST['submit'])) { 
    include_once 'dbconn.php';
    $user_id = $_GET["uid"];

    //password
    $psw = $_POST['password'];

    mysqli_query($conn, "UPDATE `accountdetails` SET `password` = '$psw'
    WHERE `accountdetails`.`account_id` = $user_id");

    header("Location: ../manager_user.php");
  } else {
    header("Location: ../404.html");
 }
?>