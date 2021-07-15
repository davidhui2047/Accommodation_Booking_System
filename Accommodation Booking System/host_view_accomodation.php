<?php
  session_start();
  include_once './backend/tablecreation.php';
  
  //get accomodation id
  $id=$_GET["id"];
  $select_accommodation = "SELECT * FROM `accomodationdetails` WHERE `accomodation_id` = $id";
  $get_accommodation = $conn->query($select_accommodation);
  $accommodation = mysqli_fetch_array($get_accommodation);
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
<!-- Container to display the host current accomodation selection stored in the SQL database -->
  <div class="container">
    <p></p>
    <div class="row">  <!-- Get the uploaded image of the house from the SQL database -->
      <img src="data:image/jpeg;base64,<?php echo base64_encode( $accommodation['houseImage'] ); ?>" style="width: 400px; height: 400px; object-fit:cover;"/>
    </div>
    <div class="row">
      <h1><?php echo $accommodation['houseName']; ?></h1> <!-- Get the house name from the SQL database -->
      <p>
        <?php echo $accommodation['rateHouse']; ?><i class="fa fa-star" aria-hidden="true" style="color: orange;"></i> <!-- Get the house name from the SQL database -->
        (review)
        &emsp;
        <?php echo $accommodation['city']; ?> <!-- Get the house name from the SQL database -->
      </p>
      <p>
        Description:
        <?php echo $accommodation['houseDescription']; ?> <!-- Get the house description from the SQL database -->
      </p>
    </div>
    <div class="row">
      <p>
        Avalibility: 
        <?php echo $accommodation['avaliableStartDate']; ?>  <!-- Get the avail start date from the SQL database -->
        &emsp;-&emsp;
        <?php echo $accommodation['avaliableEndDate']; ?>  <!-- Get the avail end date from the SQL database -->
      </p>
      <p>
        Price:
        $<?php echo $accommodation['pricePerNight']; ?>/night <!-- Get the house's price per night from the SQL database -->
      </p>
      <p>
       Bedroom:
        <?php echo $accommodation['numRoom']; ?>  <!-- Get the number of rooms in house from the SQL database -->
      </p>
      <p>
       Bathroom:
        <?php echo $accommodation['numBath']; ?>  <!-- Get the number of bathrooms in the house from the SQL database -->
      </p>
      <p>
        Smorking Allowed: <!-- Get the whether smoking is allowed in the house from the SQL database -->
        <?php 
          if ($accommodation['smorkingAllowed'] == 0) { 
          echo "Yes";
          } else {
          echo "No";
          }
        ?>
      </p>
      <p>
        Garage: <!-- Get the number of car spaces avaliable at the house from the SQL database -->
        <?php echo $accommodation['garage']; ?>
      </p>
      <p>
        Pet friendly: <!-- Get the whether pets are allowed in the house from the SQL database -->
        <?php 
          if ($accommodation['petFriendly'] == 0) {
          echo "Yes";
          } else {
          echo "No";
          }
        ?>
      </p>
      <p>
        Internet provided: <!-- Get the whether internet is provided the house from the SQL database -->
        <?php 
          if ($accommodation['internetProvided'] == 0) {
          echo "Yes";
          } else {
          echo "No";
          }
        ?>
      </p>
      <p>
        Eentire house: <!-- Get the whether the entire house is avaliable from the SQL database -->
        <?php 
          if ($accommodation['entireHouse'] == 0) {
          echo "Yes";
          } else {
          echo "No";
          }
        ?>
      </p>
      <p>
        Address: <!-- Get the house address from the SQL database -->
        <?php echo $accommodation['address']; ?>
      </p>
      <p>
        City: <!-- Get the city the house is in from the SQL database -->
        <?php echo $accommodation['city']; ?>
      </p>
      <p>
        Max Guest: <!-- Get the max number of guests allowed at the house from the SQL database -->
        <?php echo $accommodation['numGuestAllowed']; ?>
      </p>
    </div>   
    <!-- Buttons to go back, delete, or edit the current property being viewed -->
    <div style="float:right;">
      <a href="host_house.php" class="btn btn-outline-info"> 
        <i class="fa fa-arrow-circle-o-left"> Back</i> <!-- back button to host house page -->
      </a>
      <?php
      echo '<button type="button" id="' . $accommodation['accomodation_id'] . '" name="' . $accommodation['houseName'] . '"  class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="delete_house(this.id,this.name)">'
      ?>
      <i class="fa fa-trash"> Delete</i> <!-- delete button will open modal to check if you a sure you want to delete the house -->
      </button>
      <a href="host_edit_accomodation.php?id=<?php echo $accommodation['accomodation_id']; ?>" class="btn btn-outline-success">
        <i class="fa fa-edit"> Edit</i> <!-- edit button to the edit accomodation page -->
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

<!-- Modal to check if the user do indeed want to delete the currently viewed property-->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete house?</h5>
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
        document.getElementById('modal_text').innerHTML = name + " (House ID: " + id + ") will be deleted. Are you sure?";
        myName = name;
        myId = id;
      }

      function delete_confirmation() {
        // var formData = new FormData();
        // var request = new XMLHttpRequest();
        // request.open("POST", "./backend/del_accomodation.php?id="+myId);
        // request.send(formData);
        window.location.href = "./backend/host_del_accomodation.php?id="+myId;
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
