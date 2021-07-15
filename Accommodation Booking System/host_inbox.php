<?php
session_start();
include_once './backend/tablecreation.php';

$uid = $_SESSION["id"];

//get accommodation details from the SQL database based on the Host that is requesting them
$select_accommodation = "SELECT accountdetails.account_id, accomodationdetails.* FROM accountdetails 
  INNER JOIN hostdetails ON hostdetails.userId = accountdetails.account_id 
  INNER JOIN accomodationdetails ON accomodationdetails.hostID = hostdetails.host_id 
  where accountdetails.account_id = $uid";
$get_accommodation = $conn->query($select_accommodation);

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
  <link href="css/host.css" rel="stylesheet">

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
  <!-- Used to navigate around the host pages as required -->
  <section class="main-banner position-relative p-3 p-md-0 text-center bg-light text-white">
    <div class="p-lg-5 mx-auto my-5">
      <h1 class="display-4 fw-normal">Host Dashboard</h1>
      <button class="btn btn-outline-light btn-lg" onclick="location.href='host_house.php'" type="button"> <!-- Button to host house page -->
        House
      </button>
      <button class="btn btn-outline-light btn-lg" onclick="location.href='host_request.php'" type="button"> <!-- Button to host request page -->
        Request
      </button>
      <button class="btn btn-outline-light btn-lg" onclick="location.href='host_review.php'" type="button"> <!-- Button to host reviews page -->
        Review
      </button>
    </div>
  </section>

  <!-- Begin page content -->
  <!-- For the Retreive message data for host -->
  <main class="flex-shrink-0">
    <div class="container">
      <h1>Your accommodation</h1>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        while ($accommodation = mysqli_fetch_array($get_accommodation)) {  //sql connection to store the data about the houses in the $accomodation variable.
        ?>

          <div class="col">
            <div class="card h-100">
              <div class="ratio ratio-4x3">
              <!-- Get the uploaded image of the house from the SQL database -->
                <img src="data:image/jpeg;base64,<?php echo base64_encode($accommodation['houseImage']); ?>" class="card-img-top" />
              </div>
              <div class="card-body">
                <div class="card-text">
                  <p style="font-weight: bold;">
                    Rate:
                    <span style="float:right;font-weight: normal;">  <!-- Get house rating details from the SQL database -->
                      <?php echo $accommodation['rateHouse']; ?> 
                    </span>
                    <br>
                    Location:
                    <span style="float:right;font-weight: normal;">  <!-- Get the house's city details from the SQL database -->
                      <?php echo $accommodation['city']; ?>
                    </span>
                    <br>
                    From:
                    <span style="float:right;font-weight: normal;">  <!-- Get the avaliability start date for the house from the SQL database -->
                      <?php echo $accommodation['avaliableStartDate']; ?>
                    </span>
                    <br>
                    To:
                    <span style="float:right;font-weight: normal;">  <!-- Get the avaliability end date for the house from the SQL database -->
                      <?php echo $accommodation['avaliableEndDate']; ?>
                    </span>
                    <br>
                    Max guest:
                    <span style="float:right;font-weight: normal;">  <!-- Get details for the number of guests allowed at the house from the SQL database -->
                      <?php echo $accommodation['numGuestAllowed']; ?>
                    </span>
                  <p>
                </div>
                <div style="float:right;">
                <!-- Button that will enable the host to view the Accomodation based on its Id (accomodation_id) from the SQL database -->
                  <a href="view_accommodation.php?id=<?php echo $accommodation['accomodation_id']; ?>" class="btn btn-outline-primary">  
                    <i class="fa fa-eye"> View</i>
                  </a>
                  <!-- Button that will enable the host to view the Accomodation booking details based on its Id (accomodation_id) from the SQL database -->
                  <?php if (isset($_SESSION["id"])) : ?>
                    <a href="booking.php?id=<?php echo $accommodation['accomodation_id']; ?>" class="btn btn-outline-success">
                      <i class="fa fa-calendar-plus-o"> Book</i>
                    </a>
                  <?php endif ?>
                </div>
              </div>
            </div>
          </div>

        <?php
        }
        ?>
      </div>
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

  <!-- JS to Delete Table Rows-->
  <script>

  </script>

</body>

</html>