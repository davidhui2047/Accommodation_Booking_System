<?php
  session_start();
  if (isset($_POST['submit'])) { 
    include_once 'tablecreation.php';
    $accomodation_id = $_GET["aid"];

  if ($_FILES['a_image']['size'] != 0)
  {
      $a_image = addslashes(file_get_contents($_FILES["a_image"]["tmp_name"]));  
      mysqli_query($conn, "UPDATE `accomodationdetails` SET `houseImage` = '$a_image' 
      WHERE `accomodationdetails`.`accomodation_id` = $accomodation_id");
   }

    //store form user username
    $a_name = $_POST['a_name'];

    //store form user first name
    $a_description = $_POST['a_description'];

    //store form user last name
    $a_address = $_POST['a_address'];

    //store form user email
    $a_city  = $_POST['a_city'];

    //store form user mobile
    $a_price = $_POST['a_price'];

    //store form user address
    $num_guest = $_POST['num_guest'];

    //store form user user type
    $num_room = $_POST['num_room'];

    //store form user user type
    $num_bathroom = $_POST['num_bathroom'];

    //store form user user type
    $start_date = $_POST['start_date'];
    
    //store form user user type
    $end_date = $_POST['end_date'];
    
    //store form user user type
    $entire_house = $_POST['entire_house'];
    
    //store form user user type
    $num_garage = $_POST['num_garage'];
    
    //store form user user type
    $smoking_allowed = $_POST['smoking_allowed'];
    
    //store form user user type
    $internet_provided = $_POST['internet_provided'];
    
    //store form user user type
    $pet_friendly = $_POST['pet_friendly'];

    mysqli_query($conn, "UPDATE `accomodationdetails` SET `houseName` = '$a_name', `houseDescription` = '$a_description', 
    `avaliableStartDate` = '$start_date', `avaliableEndDate` = '$end_date', 
    `pricePerNight` = '$a_price', `numRoom` = '$num_room', `numBath` = '$num_bathroom', 
    `smorkingAllowed` = '$smoking_allowed', 
    `garage` = '$num_garage', `petFriendly` = '$pet_friendly', 
    `internetProvided` = '$internet_provided', `entireHouse` = '$entire_house', 
    `address` = '$a_address', `city` = '$a_city', `numGuestAllowed` = '$num_guest' 
    WHERE `accomodationdetails`.`accomodation_id` = '$accomodation_id'");

    header("Location: ../host_house.php");
  } else {
    header("Location: ../404.html");
 }
?>