<?php

//DB connection
require('../../config/db_connection.php');

//Get data from register from

$email        = $_POST['email'];
$pass         = $_POST['passwd'];
$enc_pass     = md5 ($pass);
//Query to insert data into users table
$query = "INSERT INTO users (email, password) VALUES ('$email', '$enc_pass')";

$result = pg_query($conn, $query);

if ($result) {
    echo "Registration successful!";
} else { 
    echo "Registration failed!";
}
pg_close($conn); 

?>