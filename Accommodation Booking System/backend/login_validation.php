<?php
  session_start();
  include_once 'dbconn.php';

  if (isset($_POST['login'])) {
    //store email from user input
    $email = $_POST['email'];

    //store password from user input
    $psw = $_POST['psw'];
  }

  //get input email from database
  $get_email = mysqli_query($conn, "select * from accountDetails where email = \"$email\"");

  if ($user_exist = mysqli_fetch_assoc($get_email)) {
      $hash = $user_exist["password"];

      if (password_verify($psw, $hash)) {
          $_SESSION["accessLevel"] = $user_exist["accessLevel"];
          $_SESSION["id"] = $user_exist["account_id"];
          $_SESSION["userType"] = $user_exist["userType"];
          $_SESSION["accessLevel"] = $user_exist["accessLevel"];

          if ($user_exist["userType"] == "client") {
            header("Location: ../index.php");
          } else if ($user_exist["userType"] == "host") {
            header("Location: ../host_house.php");
          } else if ($user_exist["userType"] == "manager") {
            header("Location: ../manager_accomodation.php");
          } 

          echo 'Password is valid!';
      } else {
          echo 'Invalid password.';
      }
  } else {
      echo "User does not exist!";
  }
?>