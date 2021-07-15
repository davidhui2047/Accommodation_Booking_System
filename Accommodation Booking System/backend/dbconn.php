<?php
  /*
  File name: dbconn
  Description: Create connection to the database and insert tables into database
  */
  $servername = "localhost";
  $username = "root";
  $password = "";

  // Create connection to MySQL database
  $conn = mysqli_connect($servername, $username, $password);

  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Create database
  $sql = "CREATE DATABASE IF NOT EXISTS kit202";
  mysqli_query($conn, $sql);

  $dbName = "kit202";

  // Create connection to kit202 database
  $conn = mysqli_connect($servername, $username, $password, $dbName);
?>