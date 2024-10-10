<?php

//DB connection
require('../../config/db_connection.php');

//Get data from register from

$email        = $_POST['email'];
$pass         = $_POST['passwd'];
// Encrypt password whit md5 hashing algorithm
$enc_pass     = md5 ($pass);

// Validate if email already exists
$query = "SELECT * FROM users WHERE email = '$email'";
$result = pg_query($conn, $query);
$row = pg_fetch_assoc($result);
if ($row){
    echo "<script>alert('Email already exists!');</script>";
    header('refresh:0; url=http://127.0.0.1/beta/api/src/register_form.html');
    exit();
  
} 

//Query to insert data into users table
$query = "INSERT INTO users (email, password) VALUES ('$email', '$enc_pass')";
//Execute query
$result = pg_query($conn, $query);

if ($result) {
    // echo " Registration successful!";
    echo "<script>alert('Registration successful!');</script>";
    header('refresh:0; url=http://127.0.0.1/beta/api/src/login_form.html');
} else { 
    echo " Registration failed!";
}
pg_close($conn); 

?>