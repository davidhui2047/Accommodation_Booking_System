<?php
  session_start();
  if (isset($_POST['submit'])) { 
    include_once 'tablecreation.php';
    $user_id = $_GET["uid"];

    if ($_FILES['u_image']['size'] != 0)
    {
        //image
        $user_image = addslashes(file_get_contents($_FILES["u_image"]["tmp_name"]));  
        mysqli_query($conn, "UPDATE `accountdetails` SET `image` = '$user_image'
        WHERE `accountdetails`.`account_id` = $user_id");
     }

    //store form user username
    $uname = $_POST['username'];

    //store form user first name
    $first = $_POST['first_name'];

    //store form user last name
    $last = $_POST['last_name'];

    //store form user email
    $email  = $_POST['email'];

    //store form user mobile
    $mobile = $_POST['mobile'];

    //store form user address
    $address = $_POST['address'];


    mysqli_query($conn, "UPDATE `accountdetails` SET `username` = '$uname', 
    `firstName` = '$first', `lastName` = '$last', `email` = '$email', 
    `mobile` = '$mobile', `postalAddress` = '$address'
    WHERE `accountdetails`.`account_id` = $user_id");

    header("Location: ../index.php");
  } else {
    header("Location: ../404.html");
 }
?>