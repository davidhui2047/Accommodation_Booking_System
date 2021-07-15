<?php
  session_start();
  if (isset($_POST['submit'])) { 
    include_once 'dbconn.php';
    $u_id = $_SESSION["id"];
    //image
    $a_image = addslashes(file_get_contents($_FILES["a_image"]["tmp_name"]));  

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
    
    $select_host_id = "SELECT * FROM `hostdetails` WHERE `userId` = $u_id";
    $get_host_id = $conn->query($select_host_id);
    $host_id = mysqli_fetch_array($get_host_id);
    $host_id = $host_id['host_id'];

    mysqli_query($conn, "INSERT INTO `accomodationdetails` (`accomodation_id`, `houseName`, 
    `houseImage`, `houseDescription`, `avaliableStartDate`, `avaliableEndDate`, `pricePerNight`, 
    `numRoom`, `numBath`, `smorkingAllowed`, `garage`, `petFriendly`, `internetProvided`, 
    `entireHouse`,`address`, `city`, `numGuestAllowed`, `rateHouse`, `hostID`) 
    VALUES (NULL, '$a_name', '$a_image', '$a_description', '$start_date', '$end_date', '$a_price', 
    '$num_room', '$num_bathroom', '$smoking_allowed', '$num_garage', '$pet_friendly', '$internet_provided', 
    '$entire_house', '$a_address', '$a_city', '$num_guest', '6', '$host_id')");

    header("Location: ../host_house.php");
  } else {
    header("Location: ../404.html");
  }
?>