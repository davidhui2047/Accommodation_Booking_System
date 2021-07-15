<?php
  session_start();
  if (isset($_POST['submit'])) { 
    include_once 'dbconn.php';
    $user_id = $_GET["uid"];

    //password
    $psw = $_POST['password'];
    $psw = password_hash($psw, PASSWORD_DEFAULT);

    mysqli_query($conn, "UPDATE `accountdetails` SET `password` = '$psw'
    WHERE `accountdetails`.`account_id` = $user_id");

    header("Location: ../index.php");
  } else {
    header("Location: ../404.html");
 }
?>