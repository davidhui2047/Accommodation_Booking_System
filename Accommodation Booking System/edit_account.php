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
  <!-- Begin Form contents for user account editing-->
    <form id="edit_user" action="./backend/update_user.php?uid=<?php echo $id; ?>" method="POST" enctype="multipart/form-data"> <!-- Action performed on submit -->
        <p>
          <lable>image</lable><br>
          <?php //< Get the uploaded image of the house from the SQL database ->
          echo '<img id="houseImage" src="data:image/jpeg;base64,' . base64_encode($user_details["image"]) . '"/>';
          ?>
          <br /><br /> <!-- Upload a new image of the house from the SQL database -->
          <input type="file" class="form-control" name="u_image" accept="image/*" id="imgLoad" onchange="previewFile()">
        </p>
        <p>
        <lable>User name</lable> <!-- Change username from the one that is stored in the SQL database -->
        <input class="form-control" type="text" name="username" value="<?php echo $user_details["username"]; ?>" required>
      </p>
      <p>
        <lable>First Name</lable> <!-- Change first name from the one that is stored in the SQL database -->
        <input class="form-control" type="text" name="first_name" value="<?php echo $user_details["firstName"]; ?>" required>
      </p>
      <p>
        <lable>Last Name</lable> <!-- Change last name from the one that is stored in the SQL database -->
        <input class="form-control" type="text" name="last_name" value="<?php echo $user_details["lastName"]; ?>" required>
      </p>
      <p>
        <lable>Email</lable> <!-- Change email from the one that is stored in the SQL database -->
        <input class="form-control" type="text" name="email" value="<?php echo $user_details["email"]; ?>" required>
      </p>
      <p>
        <lable>Mobile</lable> <!-- Change mobile from the one that is stored in the SQL database -->
        <input class="form-control" type="text" name="mobile" value="<?php echo $user_details["mobile"]; ?>" required>
      </p>
      <p>
        <lable>Address</lable> <!-- Change address from the one that is stored in the SQL database -->
        <input class="form-control" type="text" name="address" value="<?php echo $user_details["postalAddress"]; ?>" required>
      </p>
    <div class="saveCancel">
      <button class="btn btn-outline-danger" onclick="location.href='index.php'" type="button">Cancel</button> <!-- Cancel button. Takes the user home page index.php-->
      <button class="btn btn-outline-info" onclick="location.href='reset_pw.php?id=<?php echo $id; ?>'" type="button">Reset password</button> <!-- button that will allow the user to reset their password -->
      <input type="submit" name="submit" id="submit" form="edit_user" value="Save" class="btn btn-outline-primary"></input> <!-- Submit button that will perform Action -->
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
      
  </body>
</html>
