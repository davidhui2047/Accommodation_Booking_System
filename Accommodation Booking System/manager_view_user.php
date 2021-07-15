<?php
  session_start();
  include_once './backend/tablecreation.php';
  
  //get accomodation id
  $id=$_GET["id"];
  $select_user = "SELECT * FROM accountDetails WHERE account_id = $id";
  $get_user = $conn->query($select_user);
  $user_details = mysqli_fetch_array($get_user);
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
      <img src="data:image/jpeg;base64,<?php echo base64_encode( $user_details['image'] ); ?>" style="width: 400px; height: 400px; object-fit:cover;"/>
    </div>
    <div class="row">
      <p>
        Username:&emsp;
        <?php echo $user_details['username']; ?>
      </p>
      <p>
        First Name:&emsp;
        <?php echo $user_details['firstName']; ?> 
      </p>
      <p>
        Last Name:&emsp;
        <?php echo $user_details['lastName']; ?> 
      </p>
      <p>
        Email:&emsp;
        <?php echo $user_details['email']; ?> 
      </p>
      <p>
        Mobile:&emsp;
        <?php echo $user_details['mobile']; ?> 
      </p>
      <p>
        Address:&emsp;
        <?php echo $user_details['postalAddress']; ?> 
      </p>
      <p>
        User type:&emsp;
        <?php echo $user_details['userType']; ?> 
      </p>
      <?php if ($user_details['userType'] == "host"): ?>
      <?php
        $select_host = "SELECT * FROM `hostdetails` WHERE `userId` = $id";
        $get_host = $conn->query($select_host);
        $host = mysqli_fetch_array($get_host);
        $host_abn = $host['abnNumber'];
      ?>
      <p>
        ABN number:&emsp;
        <?php echo $host_abn; ?> 
      </p>
      <?php endif; ?>
      <p>
        Access level:&emsp;
        <?php echo $user_details['accessLevel']; ?> 
      </p>
    </div>    
    <div style="float:right;">
      <a href="manager_user.php" class="btn btn-outline-info">
        <i class="fa fa-arrow-circle-o-left"> Back</i>
      </a>
      <?php
      echo '<button type="button" id="' . $id . '" name="' . $user_details['username'] . '"  class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="delete_house(this.id,this.name)">'
      ?>
      <i class="fa fa-trash"> Delete</i>
      </button>
      <a href="manager_edit_user.php?id=<?php echo $id; ?>" class="btn btn-outline-success">
        <i class="fa fa-edit"> Edit</i>
      </a>
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
          <h5 class="modal-title" id="exampleModalLabel">Delete user?</h5>
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

    <!-- JS to Delete Table Rows-->
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
