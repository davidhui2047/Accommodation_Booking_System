<?php
session_start();
include_once './backend/tablecreation.php';

$uid = $_SESSION["id"];

//get accommodation details
$select_all_review_by_user_himself = "SELECT accountdetails.username, accomodationdetails.houseImage, 
accomodationdetails.houseName, review.* FROM accomodationdetails 
INNER JOIN review on review.accommodationId = accomodationdetails.accomodation_id 
INNER JOIN accountdetails on accountdetails.account_id = review.userId
where accountdetails.account_id = $uid";
$get_all_review_by_user_himself = $conn->query($select_all_review_by_user_himself);

//get accommodation details
$select_all_review_except_user_himself = "SELECT accountdetails.username, accomodationdetails.houseImage, 
accomodationdetails.houseName, review.* FROM accomodationdetails 
INNER JOIN review on review.accommodationId = accomodationdetails.accomodation_id 
INNER JOIN accountdetails on accountdetails.account_id = review.userId
where accountdetails.account_id != $uid";
$get_all_review_except_user_himself = $conn->query($select_all_review_except_user_himself);

$select_review_have_not_made = "SELECT * FROM `bookingdetails` WHERE `userId` = $uid and 'paymentMade' = 1"
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
  <!-- Begin container content for the current logged in user's reviews of properties and hosts -->
    <div class="container">
      <h1>Your Review </h1>
        <div class="row row-cols-1 row-cols-md-3 g-4">
          <?php //sql connection to store the data about all the current user's reviews in the $all_review_by_user_himself variable.
          while ($all_review_by_user_himself = mysqli_fetch_array($get_all_review_by_user_himself)) {
          ?>

            <div class="col">
              <div class="card h-100">
                <div class="ratio ratio-4x3"> <!-- Get the uploaded image of the house from the SQL database -->
                  <img src="data:image/jpeg;base64,<?php echo base64_encode( $all_review_by_user_himself['houseImage'] ); ?>" class="card-img-top"/>
                </div>
                <div class="card-body">
                  <div class="card-text">
                    <p style="font-weight: bold;">
                      House name:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $all_review_by_user_himself['houseName']; ?> <!-- Get house name details from the SQL database -->
                      </span>
                      <br>
                      Review ID:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $all_review_by_user_himself['review_id']; ?> <!-- Get review id  details from the SQL database -->
                      </span>
                      <br>
                      From:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $all_review_by_user_himself['username']; ?> <!-- Get username details from the SQL database -->
                      </span>
                      <br>
                      Rate for accommodation:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $all_review_by_user_himself['accomodationRate']; ?> <!-- Get house rating details from the SQL database -->
                      </span>
                      <br>
                      Comment:<br>
                      <span style="font-weight: normal;">
                        <?php echo $all_review_by_user_himself['accomodationReview']; ?> <!-- Get house reveiw details from the SQL database -->
                      </span>
                    <p>
                    <p style="font-weight: bold;">
                      Rate for Host:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $all_review_by_user_himself['hostRate']; ?> <!-- Get host rating details from the SQL database -->
                      </span>
                      <br>
                      Comment:<br>
                      <span style="font-weight: normal;">
                        <?php echo $all_review_by_user_himself['hostReview']; ?> <!-- Get house review details from the SQL database -->
                      </span>
                    <p>
                  </div>
                  <div style="float:right;">
                  <?php // delete button. Will open a modal when pressed that will ask the user to confirm their action
                  echo '<button type="button" id="' . $all_review_by_user_himself['review_id'] . '"  class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="delete_house(this.id,this.name)">'
                  ?>
                  <i class="fa fa-trash"> Delete</i>
                  </button> <!-- Edit button. Will open the client_edit_review page for the currently selected user review  -->
                  <a href="client_edit_review.php?id=<?php echo $all_review_by_user_himself['review_id']; ?>" class="btn btn-outline-success">
                    <i class="fa fa-edit"> Edit</i>
                  </a>
                </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
        <p></p>
        <!-- Begin container content for the other user's reviews of properties and hosts -->
        <h1>Other's Review </h1>
        <div class="row row-cols-1 row-cols-md-3 g-4">
          <?php //sql connection to store the data about other user's reviews in the $all_review_except_user_himself variable.
          while ($all_review_except_user_himself = mysqli_fetch_array($get_all_review_except_user_himself)) { 
          ?>

            <div class="col">
              <div class="card h-100">
                <div class="ratio ratio-4x3"> <!-- Get the uploaded image of the house from the SQL database -->
                  <img src="data:image/jpeg;base64,<?php echo base64_encode( $all_review_except_user_himself['houseImage'] ); ?>" class="card-img-top"/>
                </div>
                <div class="card-body">
                  <div class="card-text">
                    <p style="font-weight: bold;">
                      House name:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $all_review_except_user_himself['houseName']; ?> <!-- Get house name details from the SQL database -->
                      </span>
                      <br>
                      From:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $all_review_except_user_himself['username']; ?> <!-- Get user name details from the SQL database -->
                      </span>
                      <br>
                      Rate for accommodation:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $all_review_except_user_himself['accomodationRate']; ?> <!-- Get house rating details from the SQL database -->
                      </span>
                      <br>
                      Comment:<br>
                      <span style="font-weight: normal;">
                        <?php echo $all_review_except_user_himself['accomodationReview']; ?> <!-- Get house review details from the SQL database -->
                      </span>
                    <p>
                    <p style="font-weight: bold;">
                      Rate for Host:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $all_review_except_user_himself['hostRate']; ?> <!-- Get host rating details from the SQL database -->
                      </span>
                      <br>
                      Comment:<br>
                      <span style="font-weight: normal;">
                        <?php echo $all_review_except_user_himself['hostReview']; ?> <!-- Get host review details from the SQL database -->
                      </span>
                    <p>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
    </div>
    <p></p>
  </main>

<!-- Modal for confirmation of the deletion of a user review -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete review?</h5>
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

    <footer class="footer mt-auto py-3 bg-light">
      <div class="container">
        <span class="text-muted"><p>© 2021 UniTas Pty Ltd</p></span>
      </div>
    </footer>

  <!-- JS to Delete Table Rows-->
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/del_par.js"></script>
  <script>
    var myId="";

// Wiill take in and id and house name as parameters
// Display that information in a the modal
// Ask the user if the want to delete a listing
    function delete_house(id, name) {
      document.getElementById('modal_text').innerHTML = " (Review ID: " + id + ") will be deleted. Are you sure?";
      myId = id;
    }
// If confirmation from the user is recieved. The listing will be deleted from the SQL database
    function delete_confirmation() {
      window.location.href = "./backend/client_del_review.php?id="+myId;
      myId = ""
    }
// the action will be cancelled
    function confirmation_dismiss() {
      myId = "";
    }
  </script>

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