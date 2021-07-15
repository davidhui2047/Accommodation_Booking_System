<?php
  include_once './backend/tablecreation.php';
  session_start();
  $id=$_GET["id"];

  //get accommodation review details from the sql data base user id 
  $select_review = "SELECT accountdetails.username, accomodationdetails.houseImage, 
  accomodationdetails.houseName, review.* FROM accomodationdetails 
  INNER JOIN review on review.accommodationId = accomodationdetails.accomodation_id 
  INNER JOIN accountdetails on accountdetails.account_id = review.userId
  where review.review_id = $id";
  $get_review = $conn->query($select_review);
  $review = mysqli_fetch_array($get_review)
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
              <a class="nav-link active" aria-current="page" href="client_review.php">Review</a>
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
      <div class="col"> <!-- Get the uploaded image of the house related to the review from the SQL database -->
        <img src="data:image/jpeg;base64,<?php echo base64_encode( $review['houseImage'] ); ?>" style="width: 400px; height: 400px; object-fit:cover;"/>
      </div>
      <!-- Begin the form data for user input to change section of the review -->
      <form id="edit_review" action="./backend/client_update_review.php?rid=<?php echo $review['review_id']; ?>" method="POST"> <!-- Action to be performed on submit -->
        <div class="col" >
          <h1><?php echo $review['houseName']; ?></h1> <!-- Get house name from the SQL database and display it as a header -->
          <p>
            <lable>Rate for accomodation</lable> <!-- Get accomodation rating details from the SQL database and change it if needed -->
            <input class="form-control" type="number" name="accomodationRate" value="<?php echo $review["accomodationRate"]; ?>"  min="0" max="5" required>
          </p>
          <p>
            <lable>Review for accomodation</lable> <!-- Get accomodation review from the SQL database and change it if needed -->
            <input class="form-control" type="text" name="accomodationReview" value="<?php echo $review["accomodationReview"]; ?>" required>
          </p>
          <p>
            <lable>Rate for host</lable> <!-- Get host rating details from the SQL database and change it if needed -->
            <input class="form-control" type="number" name="hostRate" value="<?php echo $review["hostRate"]; ?>" min="0" max="5" required>
          </p>
          <p>
            <lable>Review for host</lable> <!-- Get host review from the SQL database and change it if needed -->
            <input class="form-control" type="text" name="hostReview" value="<?php echo $review["hostReview"]; ?>" required>
          </p>
        </div>
      <div style="float: right;">
        <a href="client_review.php" class="btn btn-outline-info">
          <i class="fa fa-arrow-circle-o-left"> Back</i> <!-- Back button to the client review page -->
        </a>
        <button class="btn btn-outline-success" form="edit_review" type="submit" name="submit"> <!-- Submit button that will perform Action. ie input the changed data to the database -->
          Save
        </button>
      </div>
      </form>        
    </div>
  </div> 
  <p></p>
</main>


<!-- Bootstrap Footer -->
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
        format: 'yyyy-mm-dd',
        "minDate": "<?php echo $accommodation['avaliableStartDate']; ?>",
        "maxDate": "<?php echo $accommodation['avaliableEndDate']; ?>"
      }); 
    </script>
  </body>
</html>
