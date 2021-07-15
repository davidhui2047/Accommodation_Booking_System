<?php
  session_start();
  include_once './backend/tablecreation.php';
  
  //get accomodation id
  $id=$_GET["id"];
  $select_accommodation = "SELECT * FROM `accomodationdetails` WHERE `accomodation_id` = $id";
  $get_accommodation = $conn->query($select_accommodation);
  $accommodation = mysqli_fetch_array($get_accommodation);
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
    <p></p>
    <div class="row">
      <img src="data:image/jpeg;base64,<?php echo base64_encode( $accommodation['houseImage'] ); ?>" style="width: 400px; height: 400px; object-fit:cover;"/>
    </div>
    <div class="row">
      <h1><?php echo $accommodation['houseName']; ?></h1>
      <p>
        <?php echo $accommodation['rateHouse']; ?><i class="fa fa-star" aria-hidden="true" style="color: orange;"></i>
        (review)
        &emsp;
        <?php echo $accommodation['city']; ?>
      </p>
      <p>
        Description:
        <?php echo $accommodation['houseDescription']; ?>
      </p>
    </div>
    <div class="row">
      <p>
        Avalibility: 
        <?php echo $accommodation['avaliableStartDate']; ?> 
        &emsp;-&emsp;
        <?php echo $accommodation['avaliableEndDate']; ?> 
      </p>
      <p>
        Price:
        $<?php echo $accommodation['pricePerNight']; ?>/night
      </p>
      <p>
       Bedroom:
        <?php echo $accommodation['numRoom']; ?> 
      </p>
      <p>
       Bathroom:
        <?php echo $accommodation['numBath']; ?> 
      </p>
      <p>
        Smorking Allowed: 
        <?php 
          if ($accommodation['smorkingAllowed'] == 0) {
          echo "Yes";
          } else {
          echo "No";
          }
        ?>
      </p>
      <p>
        Garage:
        <?php echo $accommodation['garage']; ?>
      </p>
      <p>
        Pet friendly:
        <?php 
          if ($accommodation['petFriendly'] == 0) {
          echo "Yes";
          } else {
          echo "No";
          }
        ?>
      </p>
      <p>
        Internet provided:
        <?php 
          if ($accommodation['internetProvided'] == 0) {
          echo "Yes";
          } else {
          echo "No";
          }
        ?>
      </p>
      <p>
        Eentire house
        <?php 
          if ($accommodation['entireHouse'] == 0) {
          echo "Yes";
          } else {
          echo "No";
          }
        ?>
      </p>
      <p>
        Address:
        <?php echo $accommodation['address']; ?>
      </p>
      <p>
        City:
        <?php echo $accommodation['city']; ?>
      </p>
      <p>
        Max Guest:
        <?php echo $accommodation['numGuestAllowed']; ?>
      </p>
    </div>    
    <div style="float: right;">
      <a href="index.php" class="btn btn-outline-info">
        <i class="fa fa-arrow-circle-o-left"> Back</i>
      </a>
      <?php if(isset($_SESSION["id"])): ?>
      <a href="booking.php?id=<?php echo $accommodation['accomodation_id']; ?>" class="btn btn-outline-success">
        <i class="fa fa-calendar-plus-o"> Book</i>
      </a>
      <?php else: ?>
      <a href="login.php" class="btn btn-outline-success" onclick="loginAlert()">
        <i class="fa fa-calendar-plus-o"> Book</i>
      </a>
      <?php endif ?>
    </div>
  </div>
</main>
<p></p>

<!-- Bootstrap Footer -->
<footer class="footer mt-auto py-3 bg-light">
  <div class="container">
    <span class="text-muted"><p>© 2021 UniTas Pty Ltd</p></span>
  </div>
</footer>


    <!-- Bootstrap modal dialog box for login -->
    <div class="modal" id="loginModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Login</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1">
              </div>
              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Remember me</label>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">login</button>
            <a href="registration.html" type="button" class="btn btn-secondary">Register</a>
          </div>
        </div>
      </div>
    </div>
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
