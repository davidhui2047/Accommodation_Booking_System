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
where accountdetails.account_id = $uid";
$get_total_request_number = $conn->query($select_total_request_number);
$total_request_number = 0;
  while (mysqli_fetch_array($get_total_request_number)) {
    $total_request_number++;
}

//get accommodation details
$select_request = "SELECT accountdetails.account_id, bookingdetails.*, accomodationdetails.houseImage, accomodationdetails.houseName, accomodationdetails.accomodation_id FROM bookingdetails 
INNER JOIN accomodationdetails ON accomodationdetails.accomodation_id = bookingdetails.accommodationId 
INNER JOIN hostdetails ON hostdetails.host_id = accomodationdetails.hostID 
INNER JOIN accountdetails ON accountdetails.account_id = hostdetails.userId
where accountdetails.account_id = $uid and bookingdetails.hostConfirmation = 2";
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
where accountdetails.account_id = $uid and bookingdetails.hostConfirmation != 2";
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
where accountdetails.account_id = $uid and bookingdetails.hostConfirmation = 1";
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
where accountdetails.account_id = $uid and bookingdetails.hostConfirmation = 0";
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
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="" />
  <meta name="author" content="Paul Watts, David Chui Fan Hui, Beven Dwyer, and Bootstrap contributors" />
  <title>Accommodation Booking System · ABS</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet" />

  <!-- Custom CSS -->
  <link href="css/main.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="css/accomodation.css">

  <!-- Add icon library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

  <!-- Bootstrap bi bi style sheet-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
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
              <a class="nav-link" aria-current="page" href="client_request.php">Request</a>
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

  <!-- Begin banner -->
  <section class="main-banner position-relative p-3 p-md-0 text-center bg-light text-white">
    <div class="p-lg-5 mx-auto my-5">
      <h1 class="display-4 fw-normal">Host Dashboard</h1>
      <button class="btn btn-outline-light btn-lg" onclick="location.href='host_house.php'" type="button">
        House
      </button>
      <button class="btn btn-outline-light btn-lg" onclick="location.href='host_request.php'" type="button">
        Request
      </button>
      <button class="btn btn-outline-light btn-lg" onclick="location.href='host_review.php'" type="button">
        Review
      </button>
    </div>
  </section>

  <!-- Begin page content -->
  <main class="flex-shrink-0">
  <!-- Container to display the current accomodation requests for the host from clients stored in the SQL database -->
    <div class="container">
      <h1>Request<?php echo " (" . $total_request_number . " in total)";?></h1>
      <h1>New request <?php echo " (" . $new_request_number . " in total)";?></h1>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php //sql connection to store the data about all the current requests for the host in the $request variable.
        while ($request = mysqli_fetch_array($get_request)) {
        ?>

          <div class="col">
            <div class="card h-100">
            <div class="ratio ratio-4x3"> <!-- Get the uploaded image of the requested house from the SQL database -->
              <img src="data:image/jpeg;base64,<?php echo base64_encode( $request['houseImage'] ); ?>" class="card-img-top"/>
            </div>
              <div class="card-body">
                <div class="card-text">
                  <p style="font-weight: bold;">
                    Booking ID:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $request['booking_id']; ?> <!-- Get the requests booking id from the SQL database -->
                    </span>
                    <br>
                    House ID:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $request['accomodation_id']; ?> <!-- Get the requests accomodation id from the SQL database -->
                    </span>
                    <br>
                    House Name:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $request['houseName']; ?> <!-- Get the requested house name from the SQL database -->
                    </span>
                    <br>
                    Check-in date:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $request['checkIndate']; ?> <!-- Get the requested checkin date from the SQL database -->
                    </span>
                    <br>
                    Check-out date:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $request['checkOutdate']; ?> <!-- Get the requested checkout date from the SQL database -->
                    </span>
                    <br>
                    Number of Guest:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $request['numGuest']; ?> <!-- Get the requests number of guest from the SQL database -->
                    </span>
                    <br>
                    Total Price:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $request['amount']; ?> <!-- Get the amount of money the request costs for the client in total from the SQL database -->
                    </span>
                    <br>
                  <p>
                </div>
                <div style="float:right;"> 
                <!-- Begin form content for the host input buttons to accept or reject the request from the client-->
                  <form id="host_accpt" action="./backend/host_accept_booking.php?id=<?php echo $request['booking_id']; ?>" method="POST"> <!-- Action for the submit button -->
                  <a href="host_reject.php?id=<?php echo $request['booking_id']; ?>" class="btn btn-outline-danger"> <!-- reject button action -->
                    Reject
                  </a>
                    <input type="submit" name="submit" id="submit" form="host_accpt" value="Accept" class="btn btn-outline-primary"></input> 
                  
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
    <p></p>
    <!-- Container to display the previously accepted and rejected accomodation requests for the host from clients stored in the SQL database -->
    <div class="container">
    <!-- Accepted Requests--> 
      <h1>Record <?php echo " (" . $request_record_number . " in total)";?></h1>
      <p></p>
      <h2>Accept <?php echo " (" . $request_accept_number . " in total)";?></h2>
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
                      <?php echo $accept['booking_id']; ?>  <!-- Get the requests booking id from the SQL database -->
                    </span>
                    <br>
                    House ID:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $accept['accomodation_id']; ?> <!-- Get the requests accomodation id from the SQL database -->
                    </span>
                    <br>
                    House Name:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $accept['houseName']; ?> <!-- Get the requested houses name from the SQL database -->
                    </span>
                    <br>
                    Check-in date:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $accept['checkIndate']; ?> <!-- Get the requested check-in date from the SQL database -->
                    </span>
                    <br>
                    Check-out date:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $accept['checkOutdate']; ?> <!-- Get the requested check-out date from the SQL database -->
                    </span>
                    <br>
                    Number of Guest:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $accept['numGuest']; ?> <!-- Get the requests number of guest from the SQL database -->
                    </span>
                    <br>
                    Total Price:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $accept['amount']; ?> <!-- Get the amount of money the request costs for the client in total from the SQL database -->
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
      <!-- Rejected Requests -->
      <h2>Reject <?php echo " (" . $request_reject_number . " in total)";?></h2>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        while ($reject = mysqli_fetch_array($get_reject)) {
        ?>

          <div class="col">
            <div class="card h-100">
            <div class="ratio ratio-4x3">
              <img src="data:image/jpeg;base64,<?php echo base64_encode( $reject['houseImage'] ); ?>" class="card-img-top"/>
            </div>
              <div class="card-body">
                <div class="card-text">
                  <p style="font-weight: bold;">
                    Booking ID:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $reject['booking_id']; ?> <!-- Get the requests booking id from the SQL database -->
                    </span>
                    <br>
                    House ID:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $reject['accomodation_id']; ?> <!-- Get the requests accomodation id from the SQL database -->
                    </span>
                    <br>
                    House Name:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $reject['houseName']; ?> <!-- Get the requested houses name from the SQL database -->
                    </span>
                    <br>
                    Reject reason:<br>
                    <span style="font-weight: normal;">
                      <?php echo $reject['rejectReason']; ?> <!-- Get the reason for rejecting the request from the SQL database -->
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
<p></p>
  <!-- Being Footer Here-->
  <footer class="footer mt-auto py-3 bg-light">
    <div class="container">
      <span class="text-muted">
        <p>© 2021 UniTas Pty Ltd</p>
      </span>
    </div>
  </footer>




</body>

</html>