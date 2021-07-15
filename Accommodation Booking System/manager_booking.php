<?php
session_start();
include_once './backend/tablecreation.php';

//total request number
//get accommodation details
$select_total_request_number = "SELECT accountdetails.account_id, bookingdetails.*, accomodationdetails.houseImage, 
accomodationdetails.houseName, accomodationdetails.accomodation_id FROM bookingdetails 
INNER JOIN accomodationdetails ON accomodationdetails.accomodation_id = bookingdetails.accommodationId 
INNER JOIN hostdetails ON hostdetails.host_id = accomodationdetails.hostID 
INNER JOIN accountdetails ON accountdetails.account_id = hostdetails.userId";
$get_total_request_number = $conn->query($select_total_request_number);
$total_request_number = 0;
  while (mysqli_fetch_array($get_total_request_number)) {
    $total_request_number++;
}

//get accommodation details
$select_request = "SELECT accountdetails.account_id, bookingdetails.*, accomodationdetails.houseImage, 
accomodationdetails.houseName, accomodationdetails.accomodation_id FROM bookingdetails 
INNER JOIN accomodationdetails ON accomodationdetails.accomodation_id = bookingdetails.accommodationId 
INNER JOIN hostdetails ON hostdetails.host_id = accomodationdetails.hostID 
INNER JOIN accountdetails ON accountdetails.account_id = hostdetails.userId
where bookingdetails.hostConfirmation = 2";
$get_request = $conn->query($select_request);

$get_new_request_number = $conn->query($select_request);
$new_request_number = 0;
  while (mysqli_fetch_array($get_new_request_number)) {
    $new_request_number++;
}

//get accommodation details
$select_request_record = "SELECT accountdetails.account_id, bookingdetails.*, accomodationdetails.houseImage, 
accomodationdetails.houseName, accomodationdetails.accomodation_id FROM bookingdetails 
INNER JOIN accomodationdetails ON accomodationdetails.accomodation_id = bookingdetails.accommodationId 
INNER JOIN hostdetails ON hostdetails.host_id = accomodationdetails.hostID 
INNER JOIN accountdetails ON accountdetails.account_id = hostdetails.userId
where bookingdetails.hostConfirmation != 2";
$get_request_record = $conn->query($select_request_record);

$request_record_number = 0;
  while (mysqli_fetch_array($get_request_record)) {
    $request_record_number++;
}

//get accommodation details
$select_num_paid = "SELECT accountdetails.account_id, bookingdetails.*, accomodationdetails.houseImage, 
accomodationdetails.houseName, accomodationdetails.accomodation_id FROM bookingdetails 
INNER JOIN accomodationdetails ON accomodationdetails.accomodation_id = bookingdetails.accommodationId 
INNER JOIN hostdetails ON hostdetails.host_id = accomodationdetails.hostID 
INNER JOIN accountdetails ON accountdetails.account_id = hostdetails.userId
where bookingdetails.hostConfirmation = 1 and bookingdetails.paymentMade = 1";
$get_paid = $conn->query($select_num_paid);

$get_num_paid = $conn->query($select_num_paid);
$paid_number = 0;
while (mysqli_fetch_array($get_num_paid)) {
  $paid_number++;
}

//get accommodation details
$select_num_pend_paid = "SELECT accountdetails.account_id, bookingdetails.*, accomodationdetails.houseImage, 
accomodationdetails.houseName, accomodationdetails.accomodation_id FROM bookingdetails 
INNER JOIN accomodationdetails ON accomodationdetails.accomodation_id = bookingdetails.accommodationId 
INNER JOIN hostdetails ON hostdetails.host_id = accomodationdetails.hostID 
INNER JOIN accountdetails ON accountdetails.account_id = hostdetails.userId
where bookingdetails.hostConfirmation = 1 and bookingdetails.paymentMade != 1";
$get_pend_paid = $conn->query($select_num_pend_paid);

$get_num_pend_paid = $conn->query($select_num_pend_paid);
$num_pend_paid = 0;
while (mysqli_fetch_array($get_num_pend_paid)) {
  $num_pend_paid++;
}

//get accommodation details
$select_reject = "SELECT accountdetails.account_id, bookingdetails.*, accomodationdetails.houseImage, 
accomodationdetails.houseName, accomodationdetails.accomodation_id FROM bookingdetails 
INNER JOIN accomodationdetails ON accomodationdetails.accomodation_id = bookingdetails.accommodationId 
INNER JOIN hostdetails ON hostdetails.host_id = accomodationdetails.hostID 
INNER JOIN accountdetails ON accountdetails.account_id = hostdetails.userId
where bookingdetails.hostConfirmation = 0";
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
  <link rel="stylesheet" type="text/css" href="css/accomodation.css">

  <!-- Bootstrap5 JavaScript -->
  <script src="js/bootstrap.bundle.min.js"></script>

  <!-- jQuery with Ajax JavaScript -->
  <script src="js/jquery-3.6.0.min.js"></script>

  <!-- Datepicker JavaScript -->
  <script src="js/datepicker-full.min.js"></script>

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
    <section
      class="main-banner position-relative p-3 p-md-0 text-center bg-light text-white"
    >
      <div class="p-lg-5 mx-auto my-5">
        <h1 class="display-4 fw-normal">System Manager Dashboard</h1>
        <button
          class="btn btn-outline-light btn-lg"
          onclick="location.href='manager_user.php'"
          type="button"
        >
          User
        </button>
        <button
          class="btn btn-outline-light btn-lg"
          onclick="location.href='manager_accomodation.php'"
          type="button"
        >
          House
        </button>
        <button
          class="btn btn-outline-light btn-lg"
          onclick="location.href='manager_review.php'"
          type="button"
        >
          Review
        </button>
        <button
          class="btn btn-outline-light btn-lg"
          onclick="location.href='manager_booking.php'"
          type="button"
        >
          Booking
        </button>
      </div>
    </section>

  <!-- Begin page content -->
  <main class="flex-shrink-0">
  <!-- Items that are new request from clients -->
    <div class="container">
      <h1>Request<?php echo " (" . $total_request_number . " in total)";?></h1>
      <h1>New request <?php echo " (" . $new_request_number . " in total)";?></h1>
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
                  <?php
                  echo '<button type="button" id="' . $request['booking_id'] . '"  class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="delete_review(this.id)">'
                  ?>
                  <i class="fa fa-trash"> Cancel</i>
                  </button>
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
    <!-- Items that are accepted and paided for -->
    <div class="container"> 
      <h1>Record <?php echo " (" . $paid_number . " in total)";?></h1>
      <p></p>
      <h2>Paid <?php echo " (" . $paid_number . " in total)";?></h2>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        while ($paid = mysqli_fetch_array($get_paid)) {
        ?>

          <div class="col">
            <div class="card h-100">
            <div class="ratio ratio-4x3">
              <img src="data:image/jpeg;base64,<?php echo base64_encode( $paid['houseImage'] ); ?>" class="card-img-top"/>
            </div>
              <div class="card-body">
                <div class="card-text">
                  <p style="font-weight: bold;">
                    Booking ID:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $paid['booking_id']; ?> <!-- Get the requests booking id from the SQL database -->
                    </span>
                    <br>
                    House ID:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $paid['accomodation_id']; ?> <!-- Get the requests accomodation id from the SQL database -->
                    </span>
                    <br>
                    House Name:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $paid['houseName']; ?> <!-- Get the requested house name from the SQL database -->
                    </span>
                    <br>
                    Check-in date:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $paid['checkIndate']; ?> <!-- Get the requested check-in date from the SQL database -->
                    </span> 
                    <br>
                    Check-out date:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $paid['checkOutdate']; ?> <!-- Get the requested check-out date from the SQL database -->
                    </span>
                    <br>
                    Number of Guest:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $paid['numGuest']; ?>  <!-- Get the requests number of guest from the SQL database -->
                    </span>
                    <br>
                    Total Price:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $paid['amount']; ?> <!-- Get the amount of money the request costs for the client in total from the SQL database -->
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
      <!-- Items that are pending payment-->
      <h2>Pending payment <?php echo " (" . $num_pend_paid . " in total)";?></h2>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        while ($pend_paid = mysqli_fetch_array($get_pend_paid)) {
        ?>

          <div class="col">
            <div class="card h-100">
            <div class="ratio ratio-4x3">
              <img src="data:image/jpeg;base64,<?php echo base64_encode( $pend_paid['houseImage'] ); ?>" class="card-img-top"/>
            </div>
              <div class="card-body">
                <div class="card-text">
                  <p style="font-weight: bold;">
                    Booking ID:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $pend_paid['booking_id']; ?> <!-- Get the requests booking id from the SQL database -->
                    </span>
                    <br>
                    House ID:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $pend_paid['accomodation_id']; ?> <!-- Get the requests accommodation id from the SQL database -->
                    </span>
                    <br>
                    House Name:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $pend_paid['houseName']; ?> <!-- Get the requested house name from the SQL database -->
                    </span>
                    <br>
                    Check-in date:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $pend_paid['checkIndate']; ?> <!-- Get the requested check-in date from the SQL database -->
                    </span>
                    <br>
                    Check-out date:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $pend_paid['checkOutdate']; ?> <!-- Get the requested check-out date from the SQL database -->
                    </span>
                    <br>
                    Number of Guest:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $pend_paid['numGuest']; ?> <!-- Get the requests number of guest from the SQL database -->
                    </span>
                    <br>
                    Total Price:
                    <span style="float:right;font-weight: normal;">
                      <?php echo $pend_paid['amount']; ?> <!-- Get the amount of money the request costs for the client in total from the SQL database -->
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
      <!-- Items that have been rejected -->
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

  <!-- Being Footer Here-->
  <footer class="footer mt-auto py-3 bg-light">
    <div class="container">
      <span class="text-muted">
        <p>© 2021 UniTas Pty Ltd</p>
      </span>
    </div>
  </footer>

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cancel booking?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p id="modal_text"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" onClick="confirmation_dismiss()" data-bs-dismiss="modal">No</button>
          <button type="button" class="btn btn-outline-primary" onClick="delete_confirmation()">Yes</button>
        </div>
      </div>
    </div>
  </div>

  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/del_par.js"></script>
  <script>
    var myId="";

    function delete_review(id) {
      document.getElementById('modal_text').innerHTML = " (Booking ID: " + id + ") will be cancelled. Are you sure?";
      myId = id;
    }

    function delete_confirmation() {
      window.location.href = "./backend/manager_cancel_booking.php?id="+myId;
      myId = ""
    }

    function confirmation_dismiss() {
      myId = "";
    }
  </script>

</body>

</html>