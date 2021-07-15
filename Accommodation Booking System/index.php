<?php
  session_start();
  include_once './backend/tablecreation.php';
  
  //get accommodation details
  $select_city = "SELECT city FROM `accomodationdetails` GROUP BY city";
  $get_city = $conn->query($select_city);
  //get accommodation details
  $select_accommodation = "SELECT * FROM `accomodationdetails` ORDER BY `accomodationdetails`.`rateHouse` DESC LIMIT 3";
  $get_accommodation = $conn->query($select_accommodation);
  $max_numOfGuest_query = "SELECT MAX(numGuestAllowed) FROM accomodationdetails";
  $select_max_numOfGuest = $conn->query($max_numOfGuest_query);
  
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
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <?php if($_SESSION["userType"] == "manager"): ?>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="manager_accomodation.php">Dashboard</a>
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
<section class="main-banner position-relative p-3 p-md-5 bg-light ">
  <section class="search-bar container">
  <div class="card">
    <div class="card-header">
      <h2>Accomodation search</h2>
    </div>
    <div class="card-body">
      <form action="search.php">
        <div class="container">
          <div class="row align-items-start">
            <div class="col-md-5">
              <p>
              <label for="city" class="form-label">City</label>
              <select name="city" id="city" class="form-control city" class="form-select city" required>
              <option value="" selected disabled hidden>Select city</option>  
              <?php
                 while ($city = mysqli_fetch_array($get_city)) {
                    echo '<option value='.urlencode($city["city"]).'>'.$city["city"].'</option>';
                  }
                ?>
              </select>
              </p>
            </div>
            <div class="col-md-5">
              <label class="form-label">Booking dates</label>
              <div id="bookingDate">
                <p>
                  <input type="text" class="form-control start" name="start" placeholder="Arrival" required>
                  <span>to</span>
                  <input type="text" name="end" class="form-control end" placeholder="Departure" required>  
                </p>
              </div> 
            </div>            
            <div class="col-md-2">
              <p>
                <label for="guests" class="form-label">No. of guests</label>
                <select name="guests" id="guests" id="guests" class="form-control guests" required>
                <option value="" selected disabled hidden>Select No. of guests</option>  
                <?php
                  $num_of_guest = mysqli_fetch_array($select_max_numOfGuest);
                  for ($i = 1; $i <= $num_of_guest[0]; $i++) {
                    echo '<option value='.$i.'>'.$i.'</option>';
                  } 
                ?>
                </select>
              </p>
            </div>

            <div class="col-md-12">
              <p><input type="submit" class="btn btn-outline-dark action" value="Search"/></p>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
</section>



<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
      <h1>Top 3 rating</h1>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
          while ($accommodation = mysqli_fetch_array($get_accommodation)) {
        ?>

        <div class="col">
          <div class="card h-100">
            <div class="ratio ratio-4x3">
              <img src="data:image/jpeg;base64,<?php echo base64_encode( $accommodation['houseImage'] ); ?>" class="card-img-top"/>
            </div>
            <div class="card-body">
              <div class="card-text">
                <p style="font-weight: bold;">
                  Rate:
                  <span style="float:right;font-weight: normal;">
                    <?php 
                      if ($accommodation['rateHouse'] == 6) {
                        echo "N/A";
                      } else {
                        echo $accommodation['rateHouse']; 
                      }
                    ?>
                  </span>
                  <br>
                  Location:
                  <span style="float:right;font-weight: normal;">
                    <?php echo $accommodation['city']; ?>
                  </span>
                  <br>
                  From: 
                  <span style="float:right;font-weight: normal;">
                    <?php echo $accommodation['avaliableStartDate']; ?>
                  </span>
                  <br>
                  To: 
                  <span style="float:right;font-weight: normal;">
                    <?php echo $accommodation['avaliableEndDate']; ?>
                  </span>
                  <br>
                  Max guest: 
                  <span style="float:right;font-weight: normal;"> 
                    <?php echo $accommodation['numGuestAllowed']; ?>
                  </span>  
                <p>
              </div>
              <div style="float:right;">
                <a href="view_accommodation.php?id=<?php echo $accommodation['accomodation_id']; ?>" class="btn btn-outline-primary">
                  <i class="fa fa-eye"> View</i>
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
          </div>
        </div>

        <?php
          }
        ?>
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
          <form action="./backend/login_validation.php" method="post">
            <div class="modal-body">
                <div class="mb-3">
                  <label for="email" class="form-label">Email address</label>
                  <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                  <label for="psw" class="form-label">Password</label>
                  <input type="password" class="form-control" name="psw" required>
                </div>
                <a href="registration.php" type="button" class="btn btn-outline-secondary">Register</a>
                <button type="submit" class="btn btn-outline-primary" data-bs-dismiss="modal" name="login">login</button>
            </div>
          </form>
            <div class="modal-footer">
              <a href="registration.php" type="button" class="btn btn-outline-secondary">Register</a>
              <button type="submit" class="btn btn-outline-primary" data-bs-dismiss="modal" name="login">login</button>
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

      function loginAlert() {
        alert("Please login before booking");
      }
    </script>
  </body>
</html>
