<?php
session_start();
include_once './backend/tablecreation.php';

$uid = $_SESSION["id"];

$select_host_id = "SELECT accountdetails.account_id, hostdetails.host_id FROM accountdetails 
INNER JOIN hostdetails ON hostdetails.userId = accountdetails.account_id
where accountdetails.account_id = $uid";
$get_host_id = $conn->query($select_host_id);
$host_id = mysqli_fetch_array($get_host_id);
$host_id = $host_id['host_id'];

//get accommodation details
$select_review = "SELECT accountdetails.account_id, accomodationdetails.houseImage, accomodationdetails.houseName, 
review.* FROM accountdetails INNER JOIN hostdetails ON hostdetails.userId = accountdetails.account_id 
INNER JOIN accomodationdetails ON accomodationdetails.hostID = hostdetails.host_id 
INNER JOIN review ON review.accommodationId = accomodationdetails.accomodation_id 
where review.hostID = $host_id";
$get_review = $conn->query($select_review);

$get_review_number = $conn->query($select_review);
$review_number = 0;
while (mysqli_fetch_array($get_review_number)) {
  $review_number++;
}

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

  <!-- Begin banner -->
  <section class="main-banner position-relative p-3 p-md-0 text-center bg-light text-white">
    <div class="p-lg-5 mx-auto my-5">
      <h1 class="display-4 fw-normal">Host Dashboard</h1>
      <button class="btn btn-outline-light btn-lg" onclick="location.href='host_house.php'" type="button">
        House
      </button>
      <button class="btn btn-outline-light btn-lg" onclick="location.href='host_request.php'" type="button">
        Request
      </button>
      <button class="btn btn-outline-light btn-lg" onclick="location.href='host_review.php'" type="button">
        Review
      </button>
    </div>
  </section>

  <!-- Begin page content -->
  <main class="flex-shrink-0">
    <p></p>
    <div class="container">
      <h1>Review<?php echo " (" . $review_number . " in total)";?></h1>
        <div class="row row-cols-1 row-cols-md-3 g-4">
          <?php
          while ($review = mysqli_fetch_array($get_review)) {
          ?>

            <div class="col">
              <div class="card h-100">
                <div class="ratio ratio-4x3">      <!-- Get the uploaded image of the house from the SQL database -->
                  <img src="data:image/jpeg;base64,<?php echo base64_encode( $review['houseImage'] ); ?>" class="card-img-top"/>
                </div>
                <div class="card-body">
                  <div class="card-text">
                    <p style="font-weight: bold;">
                      Rate for accommodation:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $review['accomodationRate']; ?> <!-- Get the current rating of the house from the SQL database -->
                      </span>
                      <br>
                      Comment:<br>
                      <span style="font-weight: normal;">
                        <?php echo $review['accomodationReview']; ?> <!-- Get the current review of the house from the SQL database -->
                      </span>
                    <p>
                    <p style="font-weight: bold;">
                      Rate for you:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $review['hostRate']; ?> <!-- Get the current rating of the host from the SQL database -->
                      </span>
                      <br>
                      Comment:<br>
                      <span style="font-weight: normal;">
                        <?php echo $review['hostReview']; ?> <!-- Get the current review of the host from the SQL database -->
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