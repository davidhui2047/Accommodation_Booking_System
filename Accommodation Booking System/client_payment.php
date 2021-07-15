<?php
session_start();
include_once './backend/tablecreation.php';

$booking_id = $_GET["id"];

//get the account and booking details from the database so the client can pay for the accomodation
$select_request = "SELECT accountdetails.account_id, bookingdetails.*, accomodationdetails.houseImage, accomodationdetails.houseName, accomodationdetails.accomodation_id FROM bookingdetails 
INNER JOIN accomodationdetails ON accomodationdetails.accomodation_id = bookingdetails.accommodationId 
INNER JOIN hostdetails ON hostdetails.host_id = accomodationdetails.hostID 
INNER JOIN accountdetails ON accountdetails.account_id = hostdetails.userId
where bookingdetails.booking_id = $booking_id";
$get_request = $conn->query($select_request);
$request = mysqli_fetch_array($get_request);
//SELECT accountdetails.account_id, bookingdetails.* FROM bookingdetails INNER JOIN accomodationdetails ON accomodationdetails.accomodation_id = bookingdetails.accommodationId INNER JOIN hostdetails ON hostdetails.host_id = accomodationdetails.hostID INNER JOIN accountdetails ON accountdetails.account_id = hostdetails.userId

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
    
    <!-- Bootstrap5 JavaScript -->
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- jQuery with Ajax JavaScript -->
    <script src="js/jquery-3.6.0.min.js"></script>
    
    <!-- Datepicker JavaScript -->
    <script src="js/datepicker-full.min.js"></script>
    
    <!-- Custom CSS -->
    <link href="css/main.css" rel="stylesheet">

    <!-- Add icon library -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
  
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

    <!-- Begin page content -->
    <main class="flex-shrink-0">
    <div class="container">
      <div class="row">
        <div class="col-4">
        <!-- Get the uploaded image of the house from the SQL database -->
          <img src="data:image/jpeg;base64,<?php echo base64_encode( $request['houseImage'] ); ?>" class="card-img-top"/>
        </div>
        <div class="col-4">
          <h5>Request details</h5>
          <p style="font-weight: bold;">
              Booking ID:
              <span style="float:right;font-weight: normal;">
                <?php echo $request['booking_id']; ?> <!-- Get the booking id of the house from the SQL database -->
              </span>
              <br>
              House ID:
              <span style="float:right;font-weight: normal;">
                <?php echo $request['accomodation_id']; ?> <!-- Get the accomodation id image of the house from the SQL database -->
              </span>
              <br>
              House Name:
              <span style="float:right;font-weight: normal;">
                <?php echo $request['houseName']; ?> <!-- Get the name of the house from the SQL database -->
              </span>
              <br>
              Check-in date:
              <span style="float:right;font-weight: normal;">
                <?php echo $request['checkIndate']; ?> <!-- Get the check in date of the house from the SQL database -->
              </span>
              <br>
              Check-out date:
              <span style="float:right;font-weight: normal;">
                <?php echo $request['checkOutdate']; ?> <!-- Get the check out date of the house from the SQL database -->
              </span>
              <br>
              Number of Guest:
              <span style="float:right;font-weight: normal;">
                <?php echo $request['numGuest']; ?> <!-- Get the number of guest allowed to stay at the house from the SQL database -->
              </span>
              <br>
              Total Price:
              <span style="float:right;font-weight: normal;">
                <?php echo $request['amount']; ?> <!-- Get the ammount of money requested by the host to stay at the property of the house from the SQL database -->
              </span>
              <br>
            <p>
        </div>
      </div>
      <div class="row">
        <p></p>
        <h3>Payment</h3>
        <!-- Begin the form so the user can input their payment details -->
        <form id="client_pay" action="./backend/client_pay_booking.php?id=<?php echo $request['booking_id']; ?>" method="POST"> <!-- Action to be performed on submit -->
          <p>
            <b>Credit card number</b>
            <input class="form-control" type="text" name="card_num" placeholder="Credit Card Number" required> <!-- Card number input -->
          </p>
          <p>
            <b>Security code</b>
            <input class="form-control" type="text" name="card_num" placeholder="Security Code (CVS)" required> <!-- Card Security Code (CVS) input -->
          <p>
            <b>Name</b>
            <input class="form-control" type="text" name="card_num" placeholder="Name On Card" required> <!-- Name on card input -->
          </p>
          <div style="float: right;"> <!-- Submit button that will perform Action. ie input the changed data to the database -->
            <input type="submit" name="submit" id="submit" form="client_pay" value="Pay" class="btn btn-outline-success"></input>  
            <button class="btn btn-outline-danger" onclick="location.href='client_request.php'" type="button">Cancel</button> <!-- Cancel button. Takes the user to client_request.php -->
          </div>
        </form> 
      </div>
    </main>

    <footer class="footer mt-auto py-3 bg-light">
      <div class="container">
        <span class="text-muted"><p>© 2021 UniTas Pty Ltd</p></span>
      </div>
    </footer>

    <!-- Datepicker component for booking dates -->
    <!-- Allows a little calandar box to pop up in the user input for easy input of dates -->
    <script>
      const elem = document.getElementById('bookingDate');
      const rangepicker = new DateRangePicker(elem, {
        'autohide': true,
        format: 'yyyy-mm-dd'
      }); 
    </script>

  </body>
</html>