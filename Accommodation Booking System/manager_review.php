<?php
session_start();
include_once './backend/tablecreation.php';
if ($_SESSION["userType"] != "manager") {
  header("Location: 404.html");
}
//get accommodation details
$select_review_accomodation = "SELECT accomodationdetails.houseImage, accomodationdetails.houseName, review.* FROM accountdetails 
INNER JOIN hostdetails ON hostdetails.userId = accountdetails.account_id 
INNER JOIN accomodationdetails ON accomodationdetails.hostID = hostdetails.host_id 
INNER JOIN review ON review.accommodationId = accomodationdetails.accomodation_id";
$get_review_accomodation = $conn->query($select_review_accomodation);

$select_review_host = "SELECT accountdetails.username, review.* FROM accountdetails 
INNER JOIN review ON review.userId = accountdetails.account_id";
$get_review_host = $conn->query($select_review_host);


$select_num_review = "SELECT count(*) as total_review FROM `review`";
$get_num_review= $conn->query($select_num_review);
$num_review = mysqli_fetch_array($get_num_review)
?>
<!DOCTYPE html>
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

  <!-- Begin banner -->
  <section class="main-banner position-relative p-3 p-md-0 text-center bg-light text-white">
    <div class="p-lg-5 mx-auto my-5">
      <h1 class="display-4 fw-normal">System Manager Dashboard</h1>
      <button class="btn btn-outline-light btn-lg" onclick="location.href='manager_user.php'" type="button">
        User
      </button>
      <button class="btn btn-outline-light btn-lg" onclick="location.href='manager_accomodation.php'" type="button">
        House
      </button>
      <button class="btn btn-outline-light btn-lg" onclick="location.href='manager_review.php'" type="button">
        Review
      </button>
      <button class="btn btn-outline-light btn-lg" onclick="location.href='manager_booking.php'" type="button">
        Booking
      </button>
    </div>
  </section>

  <!-- Begin page content -->
  <main class="flex-shrink-0">
    <div class="container">
      <h1>Review<?php echo " (" . $num_review['total_review'] . " in total)";?></h1>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        while ($review_accomodation = mysqli_fetch_array($get_review_accomodation)) {
        ?>
        <div class="col">
          <div class="card h-100">
            <div class="ratio ratio-4x3"> <!-- Get the uploaded image of the house from the SQL database -->
              <img src="data:image/jpeg;base64,<?php echo base64_encode($review_accomodation['houseImage']); ?>" class="card-img-top" />
            </div>
            <div class="card-body">
              <div class="card-text">
                <p style="font-weight: bold;">
                  Review ID:
                  <span style="float:right;font-weight: normal;">
                    <?php echo $review_accomodation['review_id']; ?>
                  </span>
                  <br>
                  From:
                  <span style="float:right;font-weight: normal;">
                    <?php 
                      $user_id = $review_accomodation['userId'];
                      $select_username = "SELECT * FROM accountdetails where accountdetails.account_id = $user_id";
                      $get_username = $conn->query($select_username);
                      $username = mysqli_fetch_array($get_username);
                      echo $username['username'];
                    ?>
                  </span>
                  <br>
                  Rate for accomodation:
                  <span style="float:right;font-weight: normal;">
                    <?php echo $review_accomodation['accomodationRate']; ?> <!-- Get house rating details from the SQL database -->
                  </span>
                  <br>
                  Comment:<br>
                  <span style="font-weight: normal;">
                    <?php echo $review_accomodation['accomodationReview']; ?> <!-- Get house reveiw details from the SQL database -->
                  </span>
                  <br>
                  Rate for host:
                  <span style="float:right;font-weight: normal;">
                    <?php echo $review_accomodation['hostRate']; ?> <!-- Get host rating details from the SQL database -->
                      </span>
                  </span>
                  <br>
                  Comment:<br>
                  <span style="font-weight: normal;">
                    <?php echo $review_accomodation['hostReview']; ?> <!-- Get house review details from the SQL database -->
                  </span>
                <p>
              </div>
              <div style="float:right;">
                <?php // delete button. Will open a modal when pressed that will ask the user to confirm their action
                echo '<button type="button" id="' . $review_accomodation['review_id'] . '"  class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="delete_review(this.id)">'
                ?>
                <i class="fa fa-trash"> Delete</i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <p></p>
    </div>
  </main>

  <!-- Bootstrap Footer -->
  <footer class="footer mt-auto py-3 bg-light">
    <div class="container">
      <span class="text-muted">
        <p>© 2021 UniTas Pty Ltd</p>
      </span>
    </div>
  </footer>
<!-- Modal for confirmation of the deletion of a user review -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Review?</h5>
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
      document.getElementById('modal_text').innerHTML = " (Review ID: " + id + ") will be deleted. Are you sure?";
      myId = id;
    }

    function delete_confirmation() {
      window.location.href = "./backend/manager_del_review.php?id="+myId;
      myId = ""
    }

    function confirmation_dismiss() {
      myId = "";
    }
  </script>
</body>

</html>