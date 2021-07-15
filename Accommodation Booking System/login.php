<?php
session_start();
//connect to database
include_once './backend/dbconn.php';
if (isset($_SESSION["id"])) {
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>
    html,
    body {
      font-family: Arial, Helvetica, sans-serif;
      height: 100%;
    }

    form {
      /* border: 3px solid #f1f1f1; */
    }

    /* input[type=email],
    input[type=password] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
    } */

    /* button {
      background-color: #4CAF50;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 100%;
    } */

    button:hover {
      opacity: 0.8;
    }

    .cancelbtn {
      width: auto;
      padding: 10px 18px;
      background-color: #f44336;
    }

    .imgcontainer {
      text-align: center;
      margin: 24px 0 12px 0;
    }

    img.avatar {
      width: 40%;
      border-radius: 50%;
    }

    .container {
      padding: 16px;
    }

    span.psw {
      float: right;
      padding-top: 16px;
    }

    /* Change styles for span and cancel button on extra small screens */
    @media screen and (max-width: 300px) {
      span.psw {
        display: block;
        float: none;
      }

      .cancelbtn {
        width: 100%;
      }
    }
  </style>

</head>

<body>
  <header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <div class="container-fluid">
        <div class="d-flex justify-content-between collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" aria-current="page" href="index.php">Home</a>
            </li>
          </ul>
          <ul class="navbar-nav ml-auto">
            <?php if (!isset($_SESSION["id"])) : ?>
              <li class="nav-item">
                <a class="nav-link" href="registration.php">Registration</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
              </li>
            <?php endif ?>

            <?php if (isset($_SESSION["id"])) : ?>
              <li class="nav-item">
                <a class="nav-link" href="./backend/logout.php">Logout</a>
              </li>
            <?php endif ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <div class="container h-100 mh-100">
    <div class="row row-cols-3 h-100 mh-100">
      <div class="col"></div>
      <div class="col align-self-center">
        <div class="card">
          <div class="card-body">
          <form action="./backend/login_validation.php" method="post">
            <div class="container">
              <h2 class="card-title">Login</h2>
              <p>
              <label for="email"><b>Email address:</b></label>
              <input class="form-control" type="email" placeholder="Enter Email" name="email" required>
              </p>
              <p>
              <label for="psw"><b>Password</b></label>
              <input class="form-control" type="password" placeholder="Enter Password" name="psw" required>
              </p>
              <div class="d-flex justify-content-between">
                <a href="registration.php" type="button" class="btn btn-outline-secondary w-25">Register</a>
                <button class="btn btn-outline-primary w-25" type="submit" name="login">Login</button>
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
      <div class="col"></div>
    </div>
  </div>

</body>

</html>