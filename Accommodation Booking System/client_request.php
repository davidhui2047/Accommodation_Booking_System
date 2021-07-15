<?php
session_start();
include_once './backend/tablecreation.php';

$uid = $_SESSION["id"];


//total request number
//get accommodation details
$select_total_request_number = "SELECT accountdetails.account_id, bookingdetails.*, accomodationdetails.houseImage, accomodationdetails.houseName, accomodationdetails.accomodation_id FROM bookingdetails 
INNER JOIN accomodationdetails ON accomodationdetails.accomodation_id = bookingdetails.accommodationId 
INNER JOIN hostdetails ON hostdetails.host_id = accomodationdetails.hostID 
INNER JOIN accountdetails ON accountdetails.account_id = hostdetails.userId
where bookingdetails.userId = $uid";
$get_total_request_number = $conn->query($select_total_request_number);
$total_request_number = 0;
  while (mysqli_fetch_array($get_total_request_number)) {
    $total_request_number++;
}
//get a specific request from the sql database based on a request number
//get accommodation details
$select_request = "SELECT accountdetails.account_id, bookingdetails.*, accomodationdetails.houseImage, accomodationdetails.houseName, accomodationdetails.accomodation_id FROM bookingdetails 
INNER JOIN accomodationdetails ON accomodationdetails.accomodation_id = bookingdetails.accommodationId 
INNER JOIN hostdetails ON hostdetails.host_id = accomodationdetails.hostID 
INNER JOIN accountdetails ON accountdetails.account_id = hostdetails.userId
where bookingdetails.userId = $uid and bookingdetails.hostConfirmation = 2";
$get_request = $conn->query($select_request);

$get_new_request_number = $conn->query($select_request);
$new_request_number = 0;
  while (mysqli_fetch_array($get_new_request_number)) {
    $new_request_number++;
}

//get accommodation details
$select_request_record = "SELECT accountdetails.account_id, bookingdetails.*, accomodationdetails.houseImage, accomodationdetails.houseName, accomodationdetails.accomodation_id FROM bookingdetails 
INNER JOIN accomodationdetails ON accomodationdetails.accomodation_id = bookingdetails.accommodationId 
INNER JOIN hostdetails ON hostdetails.host_id = accomodationdetails.hostID 
INNER JOIN accountdetails ON accountdetails.account_id = hostdetails.userId
where bookingdetails.userId = $uid and bookingdetails.hostConfirmation < 2";
$get_request_record = $conn->query($select_request_record);

$request_record_number = 0;
  while (mysqli_fetch_array($get_request_record)) {
    $request_record_number++;
}

//get accommodation details
$select_accept = "SELECT accountdetails.account_id, bookingdetails.*, accomodationdetails.houseImage, accomodationdetails.houseName, accomodationdetails.accomodation_id FROM bookingdetails 
INNER JOIN accomodationdetails ON accomodationdetails.accomodation_id = bookingdetails.accommodationId 
INNER JOIN hostdetails ON hostdetails.host_id = accomodationdetails.hostID 
INNER JOIN accountdetails ON accountdetails.account_id = hostdetails.userId
where bookingdetails.userId = $uid and bookingdetails.hostConfirmation = 1 and bookingdetails.paymentMade = 2 ";
$get_accept = $conn->query($select_accept);

$get_accept_number = $conn->query($select_accept);
$request_accept_number = 0;
  while (mysqli_fetch_array($get_accept_number)) {
    $request_accept_number++;
}
//get accommodation details
$select_reject = "SELECT accountdetails.account_id, bookingdetails.*, accomodationdetails.houseImage, accomodationdetails.houseName, accomodationdetails.accomodation_id FROM bookingdetails 
INNER JOIN accomodationdetails ON accomodationdetails.accomodation_id = bookingdetails.accommodationId 
INNER JOIN hostdetails ON hostdetails.host_id = accomodationdetails.hostID 
INNER JOIN accountdetails ON accountdetails.account_id = hostdetails.userId
where bookingdetails.userId = $uid and bookingdetails.hostConfirmation = 0";
$get_reject = $conn->query($select_reject);

$get_reject_number = $conn->query($select_reject);
$request_reject_number = 0;
  while (mysqli_fetch_array($get_reject_number)) {
    $request_reject_number++;
}

?>
<!doctype html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Paul Watts, David Chui Fan Hui, Beven Dwyer, and Bootstrap contributors">
    <title>Accommodation Booking System · ABS</title>  

    <!-- Bootstrap5 core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Datepicker CSS -->
    <link href="css/datepicker.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/main.css" rel="stylesheet">
    
    <!-- Bootstrap5 JavaScript -->
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- jQuery with Ajax JavaScript -->
    <script src="js/jquery-3.6.0.min.js"></script>
    
    <!-- Datepicker JavaScript -->
    <script src="js/datepicker-full.min.js"></script>

    <!-- Add icon library -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <!--CSS styling -->
    <style>
      table {
        width: 80%;
        border-collapse: collapse;
        border: 1px solid black;
      }
      th, td {
        padding: 5px;
        text-align: left;
      }
    </style>
  </head>
  <body class="d-flex flex-column h-100">
  <header>
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">ABS</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.php">Home</a>
          </li>
          <?php if($_SESSION["userType"] == "manager"): ?>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="manager_accomodation.php">Dashboard</a>
            </li>
            <?php endif ?>
          <?php if($_SESSION["userType"] == "host"): ?>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="host_house.php">Dashboard</a>
            </li>
          <?php endif ?>
          <?php if($_SESSION["userType"] == "client"): ?>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="client_request.php">Request</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="client_review.php">Review</a>
            </li>
          <?php endif ?>
          <?php if(isset($_SESSION["id"])): ?>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="account_detail.php">Account</a>
          </li>
          <?php endif ?>  
        </ul>
        <ul class="navbar-nav ml-auto">
          <?php if(!isset($_SESSION["id"])): ?>
          <li class="nav-item">
            <a class="nav-link" href="registration.php">Registration</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
          <?php endif ?>

          <?php if(isset($_SESSION["id"])): ?>
          <li class="nav-item">
            <a class="nav-link" href="./backend/logout.php">Logout</a>
          </li>
          <?php endif ?>
        </ul>
      </div>
    </div>
  </nav>
</header>

    <!-- Begin page content -->
  <main class="flex-shrink-0">
    <div class="container">
      <h1>Request sent<?php //echo " (" . $total_request_number . " in total)";?></h1>
      <h1>Pending <?php //echo " (" . $new_request_number . " in total)";?></h1>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        while ($request = mysqli_fetch_array($get_request)) {
        ?>

          <div class="col">
            <div class="card h-100">
            <div class="ratio ratio-4x3">
              <img src="data:image/jpeg;base64,<?php echo base64_encode( $request['houseImage'] ); ?>" class="card-img-top"/>
            </div>
              <div class="card-body">
                <div class="card-text">
                  <p style="font-weight: bold;">
                    Booking ID:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $request['booking_id']; ?>
                    </span>
                    <br>
                    House ID:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $request['accomodation_id']; ?>
                    </span>
                    <br>
                    House Name:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $request['houseName']; ?>
                    </span>
                    <br>
                    Check-in date:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $request['checkIndate']; ?>
                    </span>
                    <br>
                    Check-out date:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $request['checkOutdate']; ?>
                    </span>
                    <br>
                    Number of Guest:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $request['numGuest']; ?>
                    </span>
                    <br>
                    Total Price:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $request['amount']; ?>
                    </span>
                    <br>
                  <p>
                </div>
                <div style="float:right;">
                  <form id="client_cancel1" action="./backend/client_cancel_booking.php?id=<?php echo $request['booking_id']; ?>" method="POST">
                    <input type="submit" name="submit" id="submit" form="client_cancel1" value="Cancel" class="btn btn-outline-danger"></input>  
                  </form>  
                </div>
              </div>
            </div>
          </div>

        <?php
        }
        ?>
      </div>
    </div>
    <div class="container"> 
      <h1>Confirmationed <?php //echo " (" . $request_record_number . " in tatal)";?></h1>
      <p></p>
      <h2>Accept <?php //echo " (" . $request_accept_number . " in tatal)";?></h2>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        while ($accept = mysqli_fetch_array($get_accept)) {
        ?>

          <div class="col">
            <div class="card h-100">
            <div class="ratio ratio-4x3">
              <img src="data:image/jpeg;base64,<?php echo base64_encode( $accept['houseImage'] ); ?>" class="card-img-top"/>
            </div>
              <div class="card-body">
                <div class="card-text">
                  <p style="font-weight: bold;">
                    Booking ID:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $accept['booking_id']; ?>
                    </span>
                    <br>
                    House ID:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $accept['accomodation_id']; ?>
                    </span>
                    <br>
                    House Name:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $accept['houseName']; ?>
                    </span>
                    <br>
                    Check-in date:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $accept['checkIndate']; ?>
                    </span>
                    <br>
                    Check-out date:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $accept['checkOutdate']; ?>
                    </span>
                    <br>
                    Number of Guest:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $accept['numGuest']; ?>
                    </span>
                    <br>
                    Total Price:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $accept['amount']; ?>
                    </span>
                    <br>
                  <p>
                </div>
                <div style="float:right;">
                <a href="client_payment.php?id=<?php echo $accept['booking_id']; ?>" class="btn btn-outline-primary">
                Pay
                </a>
                <input type="submit" name="submit" id="submit_cancel" form="client_cancel" value="Cancel" class="btn btn-outline-danger"></input> 
                  <form id="client_accept" action="./backend/client_pay_booking.php?id=<?php echo $accept['booking_id']; ?>" method="POST">
                  </form>  
                  <form id="client_cancel" action="./backend/client_cancel_booking.php?id=<?php echo $accept['booking_id']; ?>" method="POST">
                  </form> 
                </div>
              </div>
            </div>
          </div>

        <?php
        }
        ?>
      </div>
      <p></p>
      <h2>Reject <?php //echo " (" . $request_reject_number . " in tatal)";?></h2>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        while ($reject = mysqli_fetch_array($get_reject)) {
        ?>

          <div class="col">
            <div class="card h-100">
            <div class="ratio ratio-4x3"> <!-- Get the uploaded image of the house related to the review from the SQL database -->
              <img src="data:image/jpeg;base64,<?php echo base64_encode( $reject['houseImage'] ); ?>" class="card-img-top"/>
            </div>
              <div class="card-body">
                <div class="card-text">
                  <p style="font-weight: bold;">
                    Booking ID:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $reject['booking_id']; ?>
                    </span>
                    <br>
                    House ID:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $reject['accomodation_id']; ?>
                    </span>
                    <br>
                    House Name:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $reject['houseName']; ?>
                    </span>
                    <br>
                    Reject reason:<br>
                    <span style="font-weight: normal;">
                      <?php echo $reject['rejectReason']; ?>
                    </span>
                    <br>
                  <p>
                </div>
              </div>
            </div>
          </div>

        <?php
        }
        ?>
      </div>
      <p></p>
    </div>
  </main>


    <!-- Bootstrap Footer -->
    <footer class="footer mt-auto py-3 bg-light">
      <div class="container">
        <span class="text-muted"><p>© 2021 UniTas Pty Ltd</p></span>
      </div>
    </footer>

  </body>
</html>