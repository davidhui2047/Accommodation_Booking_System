<?php
session_start();
include_once './backend/tablecreation.php';

$booking_id = $_GET["id"];

//get accommodation details
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
     <!--Container to display the currently requested house being rejected -->
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
                <?php echo $request['booking_id']; ?>   <!-- Get the booking id of the house from the SQL database -->
              </span>
              <br>
              House ID:
              <span style="float:right;font-weight: normal;">
                <?php echo $request['accomodation_id']; ?> <!-- Get the accomodation id of the house from the SQL database -->
              </span>
              <br>
              House Name:
              <span style="float:right;font-weight: normal;">
                <?php echo $request['houseName']; ?> <!-- Get the house name of the house from the SQL database -->
              </span>
              <br>
            <p>
        </div>
      </div>
      <div class="row">
      <p></p>
        <h3>Reject Reason</h3>
        <!--From to take user input about why the currently requested house is being rejected -->
        <form id="host_reject" action="./backend/host_reject_booking.php?id=<?php echo $request['booking_id']; ?>" method="POST">
          <p>
            <textarea class="form-control" type="text" name="reason" placeholder="Please descripte the reject reason" required></textarea>
          </p>
        <div style="float: right;">
          <button class="btn btn-outline-danger" onclick="location.href='host_request.php'" type="button">Cancel</button> <!--Cancel button to take the user back to the hose requests pages-->
          <input type="submit" name="submit" id="submit" form="host_reject" value="Save" class="btn btn-outline-primary"></input> <!-- submit button to perform action-->
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
    <script>
      const elem = document.getElementById('bookingDate');
      const rangepicker = new DateRangePicker(elem, {
        'autohide': true,
        format: 'yyyy-mm-dd'
      }); 
    </script>

  </body>
</html>