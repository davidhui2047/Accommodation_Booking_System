<?php
  session_start();
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

    <!-- Begin page content -->
    <main class="flex-shrink-0">
      <div class="container">
        <h3 align="center">Add accommodation</h3>
        <!-- Begin Form contents for Host adding accomodation to the database-->
        <form id="host_add_house" action="./backend/host_insert_accomodation.php" method="POST"  enctype="multipart/form-data"> <!-- Action performed on submit -->
          <p>
            <lable>Accommodation image</lable><br> <!-- Upload a new image of the house  -->
            <input type="file" class="form-control" name="a_image" required>
          </p>
            <p>
            <lable>Accommodation name</lable> <!-- Input for a name of the house  -->
            <input class="form-control" type="text" name="a_name" placeholder="Accommodation name" required>
          </p>
          <p>
            <lable>Description</lable> <!-- Input for a description of the house  -->
            <textarea class="form-control" type="text" name="a_description" placeholder="Description" required></textarea>
          </p>
          <p>
            <lable>Address</lable> <!-- Input for a street address of the house -->
            <input class="form-control" type="text" name="a_address" placeholder="Address" required>
          </p>
          <p>
            <lable>City</lable> <!-- Input for the City the house is in  -->
            <input class="form-control" type="text" name="a_city" placeholder="city" required>
          </p>
          <p>
            <lable>Price per night</lable> <!-- Input of the price per night of the house -->
            <input class="form-control" type="number" name="a_price" placeholder="Price" required>
          </p>
          <p>
            <lable>Maximum guest number</lable> <!-- Input for the number of guests allowed in the house  -->
            <select class="form-control" name="num_guest" required>
            <?php
              echo '<option value="" selected disabled hidden>---Select number---</option>';
              for ($i = 1; $i <= 20; $i++) {
                echo("<option value='".$i."'>".$i."</option>"); 
              }
            ?>
            </select>
          </p>
          <p>
            <lable>Number of rooms</lable>  <!-- Input for the number of guests allowed in the house  -->
            <select class="form-control" name="num_room" required>
            <?php
              echo '<option value="" selected disabled hidden>---Select number---</option>';
              for ($i = 1; $i <= 10; $i++) {
                echo("<option value='".$i."'>".$i."</option>"); 
              }
            ?>
            </select>
          </p>
          <p>
            <lable>Number of bathrooms</lable> <!-- Input for the number of guests allowed in the house  -->
            <select class="form-control" name="num_bathroom" required>
            <?php
              echo '<option value="" selected disabled hidden>---Select number---</option>';
              for ($i = 1; $i <= 10; $i++) {
                echo("<option value='".$i."'>".$i."</option>"); 
              }
            ?>
            </select>
          </p>
          <div id="bookingDate">
            <p>
              <lable>Avaliable date</lable> <!-- Input for the number of guests allowed in the house  -->
              <input type="text" class="form-control start" name="start_date" placeholder="Check-In" required>
              <span>to</span>
              <input type="text" name="end_date" class="form-control end" placeholder="Check-Out" required>  
            </p>
          </div>
          <p>
            <lable>Entire house</lable> <!-- Input for wether the entire house is avaliable  -->
            <select class="form-control" name="entire_house" required>
            <?php
              echo '<option value="" selected disabled hidden>---Select---</option>';
              for ($i = 0; $i <= 1; $i++) {
                if ($i == 0) {
                  $a = "No";
                } else {
                  $a = "Yes";
                }
                echo("<option value='".$i."'>". $a ."</option>"); 
              }
            ?>
            </select>
          </p>
          <p>
            <lable>Number of garage</lable> <!-- Input for the number of garage spaces avaliable at the house  -->
            <select class="form-control" name="num_garage" required>
            <?php
              echo '<option value="" selected disabled hidden>---Select number---</option>';
              for ($i = 0; $i <= 10; $i++) {
                echo("<option value='".$i."'>".$i."</option>"); 
              }
            ?>
            </select>
          </p>
          <p>
            <lable>Smoking allowed</lable> <!-- Input for whether smoking is allowed in the house  -->
            <select class="form-control" name="smoking_allowed" required>
            <?php
              echo '<option value="" selected disabled hidden>---Select---</option>';
              for ($i = 0; $i <= 1; $i++) {
                if ($i == 0) {
                  $a = "No";
                } else {
                  $a = "Yes";
                }
                echo("<option value='".$i."'>". $a ."</option>"); 
              }
            ?>
            </select>
          </p>
          <p>
            <lable>Internet provided</lable> <!-- Input for whether internet access is provided in the house  -->
            <select class="form-control" name="internet_provided" required>
            <?php
              echo '<option value="" selected disabled hidden>---Select---</option>';
              for ($i = 0; $i <= 1; $i++) {
                if ($i == 0) {
                  $a = "No";
                } else {
                  $a = "Yes";
                }
                echo("<option value='".$i."'>". $a ."</option>"); 
              }
            ?>
            </select>
          </p>
          <p>
            <lable>Pet friendly</lable> <!-- Input for whether the house is pet friendly is allowed in the house  -->
            <select class="form-control" name="pet_friendly" required>
            <?php
              echo '<option value="" selected disabled hidden>---Select---</option>';
              for ($i = 0; $i <= 1; $i++) {
                if ($i == 0) {
                  $a = "No";
                } else {
                  $a = "Yes";
                }
                echo("<option value='".$i."'>". $a ."</option>"); 
              }
            ?>
            </select>
          </p>
        </form>  
        <div class="saveCancel" style="float: right;">
          <input type="submit" name="submit" id="submit" form="host_add_house" value="Save" class="btn btn-outline-primary"></input> <!-- Submit button that will perform Action -->
          <button class="btn btn-outline-danger" onclick="location.href='host_house.php'" type="button">Cancel</button> <!-- Cancel button. Takes the user host house page-->
        </div>
      </div>
    </main>
              <p></p>
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
