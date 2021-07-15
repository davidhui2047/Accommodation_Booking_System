<?php
  include_once './backend/tablecreation.php';
  session_start();
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

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

      <!-- Custom CSS -->
    <link href="css/main.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/edit_user.css">
    
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
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
            <a class="nav-link active" aria-current="page" href="account_detail.php">Account</a>
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
    <form id="reset_pw" action="./backend/update_pw.php?uid=<?php echo $id; ?>" method="POST">
      <p>
        <lable>Password</lable>
        <input class="form-control" type="password" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[!@#$%]).{6,12}$" 
         id="password" placeholder="6 to 12 characters in length
        Contains at least 1 lower case letter, 1 uppercase letter, 1 number and one of following special characters ! @ # $ % 
        "required title="6 to 12 characters in length 
        Contains at least 1 lower case letter, 1 uppercase letter, 1 number and one of following special characters ! @ # $ % ">
      </p>
      <p>
        <lable>Password confirmation</lable>
        <input class="form-control" type="password" placeholder="Confirm password" name="password" id="passwordConfirmation" required>
      </p>
    <div class="saveCancel">
      <button class="btn btn-outline-danger" onclick="location.href='index.php'" type="button">Cancel</button>
      <input type="submit" name="submit" id="submit" form="reset_pw" value="Reset" class="btn btn-outline-primary"></input> 
    </div>
    </form>
  </div>
  </div>
</main>
<p></p>
<footer class="footer mt-auto py-3 bg-light">
  <div class="container">
    <span class="text-muted"><p>© 2021 UniTas Pty Ltd</p></span>
  </div>
</footer>


<script>
  var password = document.getElementById("password");
  var password_confirmation = document.getElementById("passwordConfirmation");

  function password_confirmation1(){
    if(password.value != password_confirmation.value) {
      password_confirmation.setCustomValidity("Password Doesn't Match");
    } else {
      password_confirmation.setCustomValidity('');
    }
  }

  password.onchange = password_confirmation1;
  password_confirmation.onkeyup = password_confirmation1;

 
</script>
      
  </body>
</html>
