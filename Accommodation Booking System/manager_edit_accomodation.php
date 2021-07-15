<?php
session_start();
include_once './backend/tablecreation.php';

$id = $_GET["id"];
$select_accomodation = "SELECT * FROM accomodationdetails WHERE accomodation_id = $id";

$get_accomodation = $conn->query($select_accomodation);
$accomodation_details = mysqli_fetch_array($get_accomodation);
?>
<!doctype html>
<html lang="en" class="h-100">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Paul Watts, David Chui Fan Hui, Beven Dwyer, and Bootstrap contributors">
  <title>Accommodation Booking System · ABS</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="css/main.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/edit_user.css">

  <!-- Add icon library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Bootstrap bi bi style sheet-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

  <!-- Datepicker JavaScript -->
  <script src="js/datepicker-full.min.js"></script>

  <!-- Datepicker CSS -->
  <link href="css/datepicker.min.css" rel="stylesheet">
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
    <p></p>
    <div class="container">
      <form id="edit_accomodation" action="./backend/manager_update_accomodation.php?aid=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <p>
          <lable>House image</lable><br>
          <?php
          echo '<img id="houseImage" src="data:image/jpeg;base64,' . base64_encode($accomodation_details["houseImage"]) . '"/>';
          ?>
          <br /><br />
          <input type="file" class="form-control" name="houseImage" accept="image/*" id="imgLoad" onchange="previewFile()">
        </p>
        <p>
          <lable>House name</lable>
          <input class="form-control" type="text" name="a_name" value="<?php echo $accomodation_details["houseName"]; ?>" required>
        </p>
          <p>
            <lable>Description</lable>
            <input class="form-control" type="text" name="a_description" placeholder="Description" value="<?php echo $accomodation_details["houseDescription"]; ?>" required>
          </p>
          <p>
            <lable>Address</lable>
            <input class="form-control" type="text" name="a_address" placeholder="Address" value="<?php echo $accomodation_details["address"]; ?>" required>
          </p>
          <p>
            <lable>City</lable>
            <input class="form-control" type="text" name="a_city" placeholder="city" value="<?php echo $accomodation_details["city"]; ?>" required>
          </p>
          <p>
            <lable>Price per night</lable>
            <input class="form-control" type="number" name="a_price" placeholder="Price" value="<?php echo $accomodation_details["pricePerNight"]; ?>" required>
          </p>
          <p>
            <lable>Maximum guest number</lable>
            <select class="form-control" name="num_guest" required>
              <?php for ($i = 1; $i <= 20; $i++) : ?>
              <option value="<?php echo $i ?>"<?php if( $i == $accomodation_details['numGuestAllowed'] ): ?> selected="selected"<?php endif; ?>><?php echo $i ?></option>
              <?php endfor; ?>
            </select>
          </p>
          <p>
            <lable>Number of rooms</lable>
            <select class="form-control" name="num_room" required>
              <?php for ($i = 1; $i <= 20; $i++) : ?>
              <option value="<?php echo $i ?>"<?php if( $i == $accomodation_details['numRoom'] ): ?> selected="selected"<?php endif; ?>><?php echo $i ?></option>
              <?php endfor; ?>
            </select>
          </p>
          <p>
            <lable>Number of bathrooms</lable>
            <select class="form-control" name="num_bathroom" value="<?php echo $accomodation_details["numBath"]; ?>" required>
              <?php for ($i = 1; $i <= 20; $i++) : ?>
              <option value="<?php echo $i ?>"<?php if( $i == $accomodation_details['numBath'] ): ?> selected="selected"<?php endif; ?>><?php echo $i ?></option>
              <?php endfor; ?>
            </select>
          </p>
          <div id="bookingDate">
            <p>
              <lable>Avaliable date</lable>
              <input type="text" class="form-control start" name="start_date" placeholder="Check-In" value="<?php echo $accomodation_details["avaliableStartDate"]; ?>" required>
              <span>to</span>
              <input type="text" name="end_date" class="form-control end" placeholder="Check-Out" value="<?php echo $accomodation_details["avaliableEndDate"]; ?>" required>  
            </p>
          </div>
          <p>
            <lable>Entire house</lable>
            <select class="form-control" name="entire_house" value="<?php echo $accomodation_details["entireHouse"]; ?>" required>
            <?php
              echo '<option value="" selected disabled hidden>---Select---</option>';
              for ($i = 0; $i <= 1; $i++) {
                if ($i == 0) {
                  $a = "No";
                } else {
                  $a = "Yes";
                }
              ?>
                <option value="<?php echo $i ?>"<?php if( $i == $accomodation_details['entireHouse'] ): ?> selected="selected"<?php endif; ?>><?php echo $a ?></option>
            <?php } ?>
            </select>
          </p>
          <p>
            <lable>Number of garage</lable>
            <select class="form-control" name="num_garage" value="<?php echo $accomodation_details["garage"]; ?>" required>
              <?php for ($i = 1; $i <= 20; $i++) : ?>
              <option value="<?php echo $i ?>"<?php if( $i == $accomodation_details['garage'] ): ?> selected="selected"<?php endif; ?>><?php echo $i ?></option>
              <?php endfor; ?>
            </select>
          </p>
          <p>
            <lable>Smoking allowed</lable>
            <select class="form-control" name="smoking_allowed" value="<?php echo $accomodation_details["smorkingAllowed"]; ?>" required>
            <?php
              echo '<option value="" selected disabled hidden>---Select---</option>';
              for ($i = 0; $i <= 1; $i++) {
                if ($i == 0) {
                  $a = "No";
                } else {
                  $a = "Yes";
                }
              ?>
                <option value="<?php echo $i ?>"<?php if( $i == $accomodation_details['smorkingAllowed'] ): ?> selected="selected"<?php endif; ?>><?php echo $a ?></option>
            <?php } ?>
            </select>
          </p>
          <p>
            <lable>Internet provided</lable>
            <select class="form-control" name="internet_provided" value="<?php echo $accomodation_details["internetProvided"]; ?>" required>
            <?php
              echo '<option value="" selected disabled hidden>---Select---</option>';
              for ($i = 0; $i <= 1; $i++) {
                if ($i == 0) {
                  $a = "No";
                } else {
                  $a = "Yes";
                }
              ?>
                <option value="<?php echo $i ?>"<?php if( $i == $accomodation_details['internetProvided'] ): ?> selected="selected"<?php endif; ?>><?php echo $a ?></option>
            <?php } ?>
            </select>
          </p>
          <p>
            <lable>Pet friendly</lable>
            <select class="form-control" name="pet_friendly" value="<?php echo $accomodation_details["petFriendly"]; ?>" required>
            <?php
              echo '<option value="" selected disabled hidden>---Select---</option>';
              for ($i = 0; $i <= 1; $i++) {
                if ($i == 0) {
                  $a = "No";
                } else {
                  $a = "Yes";
                }
              ?>
                <option value="<?php echo $i ?>"<?php if( $i == $accomodation_details['petFriendly'] ): ?> selected="selected"<?php endif; ?>><?php echo $a ?></option>
            <?php } ?>
            </select>
          </p>
      <div class="saveCancel">
        <button class="btn btn-outline-danger" onclick="location.href='manager_accomodation.php'" type="button">Cancel</button>
        <input type="submit" name="submit" id="submit" form="edit_accomodation" value="Save" class="btn btn-outline-primary"></input>
      </div>
      </form>
    </div>
    </div>
  </main>
  <p></p>
  <footer class="footer mt-auto py-3 bg-light">
    <div class="container">
      <span class="text-muted">
        <p>© 2021 UniTas Pty Ltd</p>
      </span>
    </div>
  </footer>


  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/del_Id.js"></script>
  <script>
    function previewFile() {
      var preview = document.querySelector('img');
      var file = document.querySelector('input[type=file]').files[0];
      var reader = new FileReader();

      reader.addEventListener("load", function() {
        preview.src = reader.result;
      }, false);

      if (file) {
        reader.readAsDataURL(file);
      }
    }
  </script>
  <script>
  const elem = document.getElementById('bookingDate');
  const rangepicker = new DateRangePicker(elem, {
    'autohide': true,
    format: 'yyyy-mm-dd'
  }); 
  </script>
</body>

</html>