<?php
  /*
  File name: tablecreation
  Description: insert tables into database
  */
  include_once 'dbconn.php';

  //create table account details
  $create_table_account = "CREATE TABLE if not exists accountDetails (
      account_id int(20) not null PRIMARY KEY AUTO_INCREMENT,
      username varchar(255) not null,
      image BLOB,
      firstName varchar(255) not null,
      lastName varchar(255) not null, 
      email varchar(255) not null,
      mobile int(20) not null,
      postalAddress text not null,
      password varchar(255),
      userType varchar(20) not null,
      accessLevel int(1) not null
  )";      

  //create table inbox
  $create_table_inbox = "CREATE TABLE if not exists inbox (
      inbox_id int(20) not null PRIMARY KEY AUTO_INCREMENT,
      message text not null,
      readStatus BOOLEAN not null,
      senderId int(10) not null,
      recieverId int(10) not null,
      FOREIGN KEY (senderId) REFERENCES accountDetails(account_id) ON DELETE CASCADE,
      FOREIGN KEY (recieverId) REFERENCES accountDetails(account_id) ON DELETE CASCADE
  )";  

  //create table creditCardDetails
  $create_table_credit_card = "CREATE TABLE if not exists creditCardDetails (
    credit_card_id int(20) not null PRIMARY KEY AUTO_INCREMENT,
    cardNumber int(20) not null,
    expiryDate date not null,
    userId int(10) not null,
    FOREIGN KEY (userId) REFERENCES accountDetails(account_id) ON DELETE CASCADE
  )";  


  //create table hostDetails
  $create_table_host = "CREATE TABLE if not exists hostDetails (
    host_id int(20) not null PRIMARY KEY AUTO_INCREMENT,
    rate float(24) not null,
    abnNumber varchar(20) not null,
    userId int(20) not null,
    FOREIGN KEY (userId) REFERENCES accountDetails(account_id) ON DELETE CASCADE
  )";  


  //create table accommodation
  $create_table_accommodation = "CREATE TABLE if not exists accomodationDetails (
      accomodation_id int(20) not null PRIMARY KEY AUTO_INCREMENT,
      houseName varchar(255) not null,
      houseImage BLOB,
      houseDescription text not null,
      avaliableStartDate date not null,
      avaliableEndDate date not null,
      pricePerNight int(20) not null,
      numRoom int(20) not null,
      numBath int(20) not null,
      smorkingAllowed BOOLEAN not null,
      garage int(20) not null,
      petFriendly BOOLEAN not null,
      internetProvided BOOLEAN not null,
      entireHouse BOOLEAN not null,
      address text not null,
      city varchar(255),
      numGuestAllowed int(20) not null,
      rateHouse float(24) not null,
      hostID int(20) not null,
      FOREIGN KEY (hostID) REFERENCES hostDetails(host_id) ON DELETE CASCADE
  )"; 

  //create table Review
  $create_table_review = "CREATE TABLE if not exists review (
    review_id int(20) not null PRIMARY KEY AUTO_INCREMENT,
    accomodationReview text,
    accomodationRate float(24),
    hostReview text,
    hostRate float(24),
    userId int(20) not null,
    accommodationId int(20) not null,
    hostID int(20) not null,
    FOREIGN KEY (userId) REFERENCES accountDetails(account_id) ON DELETE CASCADE,
    FOREIGN KEY (accommodationId) REFERENCES accomodationDetails(accomodation_id) ON DELETE CASCADE,
    FOREIGN KEY (hostID) REFERENCES hostDetails(host_id) ON DELETE CASCADE
  )";        

  //create table booking Details
  $create_table_booking = "CREATE TABLE if not exists bookingDetails (
    booking_id int(20) not null PRIMARY KEY AUTO_INCREMENT,
    checkIndate date not null,
    checkOutdate date not null,
    numGuest int(20) not null,
    amount int(20) not null,
    paymentMade BOOLEAN not null,
    hostConfirmation BOOLEAN not null,
    UserCancel BOOLEAN not null,
    rejectReason text not null,
    accommodationId int(20) not null,
    userId int(20) not null,
    FOREIGN KEY (accommodationId) REFERENCES accomodationDetails(accomodation_id) ON DELETE CASCADE,
    FOREIGN KEY (userId) REFERENCES accountDetails(account_id) ON DELETE CASCADE
  )";    

  //create table guest details
  $create_table_guest = "CREATE TABLE if not exists guestDetails (
    guest_id int(10) not null PRIMARY KEY AUTO_INCREMENT,
    firstName varchar(255) not null,
    lastName varchar(255) not null, 
    email varchar(255) not null,
    mobile int(20) not null,
    bookingId int(10) not null,
    FOREIGN KEY (bookingId) REFERENCES bookingDetails(booking_id) ON DELETE CASCADE
  )";      

  //create relational table join to show the relationship between table bookingDetails and guestDetails
  $create_table_join = "CREATE TABLE if not exists guestInvitaion (
    invitaion_id int(20) not null PRIMARY KEY AUTO_INCREMENT,
    bookingId int(20) not null,
    guestId int(20) not null,
    FOREIGN KEY (bookingId) REFERENCES bookingDetails(booking_id) ON DELETE CASCADE,
    FOREIGN KEY (guestId) REFERENCES guestDetails(guest_id) ON DELETE CASCADE
  )";  

  $conn->query("ALTER IGNORE TABLE accountDetails ADD UNIQUE INDEX del_duplicate (username)");
  $conn->query("ALTER IGNORE TABLE hostdetails ADD UNIQUE INDEX del_duplicate (userId)");
  $conn->query("ALTER IGNORE TABLE guestdetails ADD UNIQUE INDEX del_duplicate 
  (`firstName`, `lastName`, `email`, `mobile`, `bookingId`)");
  $conn->query("ALTER IGNORE TABLE accomodationdetails ADD UNIQUE INDEX del_duplicate (address)");

  $pw = password_hash("!Aa123123", PASSWORD_DEFAULT);

  $conn->query("INSERT INTO `accountdetails` 
  (`username`, `firstName`, `lastName`, `email`, `mobile`, `postalAddress`, `password`, `userType`, `accessLevel`) VALUES 
  ('david2047', 'david', 'hui', 'davidhui2047@gmail.com', '12345678', '81 sandy bay road', '$pw', 'manager', '3')");

  mysqli_query($conn, $create_table_account);
  mysqli_query($conn, $create_table_inbox);
  mysqli_query($conn, $create_table_credit_card);
  mysqli_query($conn, $create_table_host);
  mysqli_query($conn, $create_table_accommodation);
  mysqli_query($conn, $create_table_review);
  mysqli_query($conn, $create_table_booking);
  mysqli_query($conn, $create_table_guest);
  //mysqli_query($conn, $create_table_join);

  //INSERT INTO `accountdetails` (`id`, `image`, `username`, `firstName`, `lastName`, `email`, `phone`, `postalAddress`, `password`, `userType`, `accessLevel`) VALUES (NULL, '', 'ElonSpaceX', 'Elon', 'Musk', 'elonmusk@gmail.com', '0487029235', '8, view street, North Hobart', NULL, 'Client', '1'), (NULL, '', 'StevePhone', 'Steve', 'Jobs', 'stevephone@gmail.com', '0489532942', '82, view street, Sandy Bay', NULL, 'Host', '2')
?>