<?php
    include_once 'dbconn.php';

    //image
    $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));  

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

    //password
    $psw = $_POST['password'];
    $psw = password_hash($psw, PASSWORD_DEFAULT);

    //store form user user type
    $utype = $_POST['UserTypeSelect'];

    //store form user user type
    $access_lv = $_POST['access_level'];
    
    mysqli_query($conn, "INSERT INTO `accountdetails` (`image`, `username`, `firstName`, `lastName`,
     `email`, `mobile`, `postalAddress`, `password`, `userType`, `accessLevel`) 
    VALUES ('$file', '$uname', '$first', '$last', '$email', '$mobile', '$address', '$psw', '$utype', '$access_lv')");

    if ($utype == "host") {
      $abnNumber = $_POST['abn'];
      $select_last_user_id = "SELECT MAX(`account_id`) AS last_user_id FROM accountdetails";
      $get_last_user_id = $conn->query($select_last_user_id);
      $last_user_id = $get_last_user_id->fetch_assoc();
      $last_user_id = $last_user_id['last_user_id'];
      mysqli_query($conn, "INSERT INTO `hostdetails` (`host_id`, `rate`, `abnNumber`, `userId`) 
      VALUES (NULL, '6', '$abnNumber', '$last_user_id')");
    }
 
  header("Location: ../index.php");
?>