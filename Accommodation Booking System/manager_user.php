<?php
  session_start();
  if ($_SESSION["userType"] != "manager") {
    header("Location: 404.html");
  }
  include_once './backend/dbconn.php';

  //get user details
  $select_client = "SELECT * FROM accountDetails WHERE userType = 'client'";
  $get_client = $conn->query($select_client);

  //get user details
  $select_host = "SELECT * FROM accountDetails WHERE userType = 'host'";
  $get_host = $conn->query($select_host);

  $count_total_user = "SELECT count(*) as total_user FROM accountDetails";
  $get_total_user = $conn->query($count_total_user);
  $total_user = mysqli_fetch_array($get_total_user);

  $count_total_client = "SELECT count(*) as total_client FROM accountDetails WHERE userType = 'client'";
  $get_total_client = $conn->query($count_total_client);
  $total_client = mysqli_fetch_array($get_total_client);

  $count_total_host = "SELECT count(*) as total_host FROM accountDetails WHERE userType = 'host'";
  $get_total_host = $conn->query($count_total_host);
  $total_host = mysqli_fetch_array($get_total_host);
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
    <section
      class="main-banner position-relative p-3 p-md-0 text-center bg-light text-white"
    >
      <div class="p-lg-5 mx-auto my-5">
        <h1 class="display-4 fw-normal">System Manager Dashboard</h1>
        <button
          class="btn btn-outline-light btn-lg"
          onclick="location.href='manager_user.php'"
          type="button"
        >
          User
        </button>
        <button
          class="btn btn-outline-light btn-lg"
          onclick="location.href='manager_accomodation.php'"
          type="button"
        >
          House
        </button>
        <button
          class="btn btn-outline-light btn-lg"
          onclick="location.href='manager_review.php'"
          type="button"
        >
          Review
        </button>
        <button
          class="btn btn-outline-light btn-lg"
          onclick="location.href='manager_booking.php'"
          type="button"
        >
          Booking
        </button>
      </div>
    </section>

    <!-- Begin page content -->
    <main class="flex-shrink-0">
      <p></p>
      <!-- Container to hold the total number of users as well as the individual client and hosts details-->
      <div class="container">
        <h1>User<?php echo " (" . $total_user['total_user'] . " in total)";?>
        <button
          id="addUser"
          class="btn btn-outline-primary"
          onclick="location.href='add_user.php'"
          type="button"
          style="float: right;"
        >
          <i class="fa fa-plus"> Add user</i>
        </button></h1>
        <h1>Client<?php echo " (" . $total_client['total_client'] . " in total)";?></h1>
        <div class="row row-cols-1 row-cols-md-3 g-4">
          <?php
          while ($client_details = mysqli_fetch_array($get_client)) {
          ?>

            <div class="col">
              <div class="card h-100">
                <div class="ratio ratio-4x3">
                  <img src="data:image/jpeg;base64,<?php echo base64_encode($client_details['image']); ?>" class="card-img-top" />
                </div>
                <div class="card-body">
                  <div class="card-text">
                    <p style="font-weight: bold;">
                      User ID:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $client_details['account_id']; ?>
                      </span>
                      <br>
                      Username:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $client_details['username']; ?>
                      </span>
                      <br>
                      First name:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $client_details['firstName']; ?>
                      </span>
                      <br>
                      Access level:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $client_details['accessLevel']; ?>
                      </span>
                    <p>
                  </div>
                  <div style="float:right;">
                    <?php
                    echo '<button type="button" id="' . $client_details['account_id'] . '" name="' . $client_details['username'] . '"  class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="delete_house(this.id,this.name)">'
                    ?>
                    <i class="fa fa-trash"> Delete</i>
                    </button>
                    <a href="manager_edit_user.php?id=<?php echo $client_details['account_id']; ?>" class="btn btn-outline-success">
                      <i class="fa fa-edit"> Edit </i>
                    </a>
                    <a href="manager_view_user.php?id=<?php echo $client_details['account_id']; ?>" class="btn btn-outline-primary">
                      <i class="fa fa-eye"> View</i>
                    </a>
                  </div>
                </div>
              </div>
            </div>

          <?php
          }
          ?>
        </div>
        <h1>Host<?php echo " (" . $total_host['total_host'] . " in total)";?></h1>
        <div class="row row-cols-1 row-cols-md-3 g-4">
          <?php
          while ($host_details = mysqli_fetch_array($get_host)) {
          ?>

            <div class="col">
              <div class="card h-100">
                <div class="ratio ratio-4x3">
                  <img src="data:image/jpeg;base64,<?php echo base64_encode($host_details['image']); ?>" class="card-img-top" />
                </div>
                <div class="card-body">
                  <div class="card-text">
                    <p style="font-weight: bold;">
                      User ID:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $host_details['account_id']; ?>
                      </span>
                      <br>
                      Username:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $host_details['username']; ?>
                      </span>
                      <br>
                      First name:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $host_details['firstName']; ?>
                      </span>
                      <br>
                      Access level:
                      <span style="float:right;font-weight: normal;">
                        <?php echo $host_details['accessLevel']; ?>
                      </span>
                    <p>
                  </div>
                  <div style="float:right;">
                    <?php
                    echo '<button type="button" id="' . $host_details['account_id'] . '" name="' . $host_details['username'] . '"  class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="delete_house(this.id,this.name)">'
                    ?>
                    <i class="fa fa-trash"> Delete</i>
                    </button>
                    <a href="manager_edit_user.php?id=<?php echo $host_details['account_id']; ?>" class="btn btn-outline-success">
                      <i class="fa fa-edit"> Edit </i>
                    </a>
                    <a href="manager_view_user.php?id=<?php echo $host_details['account_id']; ?>" class="btn btn-outline-primary">
                      <i class="fa fa-eye"> View</i>
                    </a>
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

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete User?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p id="modal_text"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onClick="confirmation_dismiss()" data-bs-dismiss="modal">No</button>
          <button type="button" class="btn btn-primary" onClick="delete_confirmation()">Yes</button>
        </div>
      </div>
    </div>
  </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/del_par.js"></script>
    <script>
    var myName="";
    var myId="";

    function delete_house(id, name) {
      document.getElementById('modal_text').innerHTML = name + " (User ID: " + id + ") will be deleted. Are you sure?";
      myName = name;
      myId = id;
    }

    function delete_confirmation() {
      // var formData = new FormData();
      // var request = new XMLHttpRequest();
      // request.open("POST", "./backend/del_accomodation.php?id="+myId);
      // request.send(formData);
      window.location.href = "./backend/manager_del_user.php?id="+myId;
      myId = ""
      myName = ""
    }

    function confirmation_dismiss() {
      myName = "";
      myId = "";
    }
  </script>
  </body>
</html>
