<?php
  session_start();
  if (isset($_POST['submit'])) { 
    include_once 'dbconn.php';
    $review_id = $_GET["rid"];

    //password
    $accomodationRate = $_POST['accomodationRate'];

    //password
    $accomodationReview = $_POST['accomodationReview'];

    //password
    $hostRate = $_POST['hostRate'];

    //password
    $hostReview = $_POST['hostReview'];

    mysqli_query($conn, "UPDATE `review` SET `accomodationReview` = '$accomodationReview', 
    `accomodationRate` = '$accomodationRate', `hostReview` = '$hostReview', 
    `hostRate` = '$hostRate' WHERE `review`.`review_id` = $review_id");

    $select_host_id = "SELECT * FROM `review` WHERE `review_id` = $review_id";
    $get_hostID = $conn->query($select_host_id);
    $get_accommodationId = $conn->query($select_host_id);
    $hostID = mysqli_fetch_array($get_hostID);
    $hostID = $hostID['hostID'];

    $accommodationId = mysqli_fetch_array($get_accommodationId);
    $accommodationId = $accommodationId['accommodationId'];
    //}

    $select_num_host_rate = "SELECT COUNT(*) as num_host_rate FROM `review` 
    WHERE `hostID`= $hostID";
    $get_num_host_rate = $conn->query($select_num_host_rate);
    $num_host_rate = mysqli_fetch_array($get_num_host_rate);
    $num_host_rate = $num_host_rate["num_host_rate"];

    $select_sum_host_rate = "SELECT SUM(`hostRate`) as sum_host_rate FROM review 
    WHERE `hostID`= $hostID";
    $get_sum_host_rate = $conn->query($select_sum_host_rate);
    $sum_host_rate = mysqli_fetch_array($get_sum_host_rate);
    $sum_host_rate = $sum_host_rate["sum_host_rate"];
    
    $host_new_rate = $sum_host_rate / $num_host_rate;

    $select_num_accommodation_rate = "SELECT COUNT(*) as num_accommodation_rate FROM `review` 
    WHERE `accommodationId`= $accommodationId";
    $get_num_accommodation_rate = $conn->query($select_num_accommodation_rate);
    $num_accommodation_rate = mysqli_fetch_array($get_num_accommodation_rate);
    $num_accommodation_rate = $num_accommodation_rate["num_accommodation_rate"];

    $select_sum_accomodation_rate = "SELECT SUM(`accomodationRate`) as sum_accomodation_rate FROM review 
    WHERE `accommodationId`= $accommodationId";
    $get_sum_accomodation_rate = $conn->query($select_sum_accomodation_rate);
    $sum_accomodation_rate = mysqli_fetch_array($get_sum_accomodation_rate);
    $sum_accomodation_rate = $sum_accomodation_rate["sum_accomodation_rate"];
    
    $accomodation_new_rate = $sum_accomodation_rate / $num_accommodation_rate;
    
    echo $host_new_rate;
    echo $accomodation_new_rate;

    mysqli_query($conn, "UPDATE `accomodationdetails` SET `rateHouse` = '$accomodation_new_rate' 
    WHERE `accomodationdetails`.`accomodation_id` = $accommodationId;");

    mysqli_query($conn, "UPDATE `hostdetails` SET `rate` = '$host_new_rate' 
    WHERE `hostdetails`.`host_id` = $hostID;");


    header("Location: ../client_review.php");
  } else {
    header("Location: ../404.html");
 }
?>