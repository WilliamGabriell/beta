<?php

function save_data_supabase($email, $passwd){
//supabase database configuration
$SUPABASE_URL = 'https://ilybighmtkrzayoqegiv.supabase.co';
$SUPABASE_KEY ='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImlseWJpZ2htdGtyemF5b3FlZ2l2Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzAzODg2ODYsImV4cCI6MjA0NTk2NDY4Nn0.4H_HIH0yD7NjOXLYPXrs44McAQ-ETT6f-06fF1scdrs';


$url = "$SUPABASE_URL/rest/v1/users";
$data = [
    'email' => $email,
    'password' => $passwd,
    ];    

    $options = [
        'http' => [
        'header' => [
        "Content-Type: application/json",
        "Authorization: Bearer $SUPABASE_KEY",
        "apikey: $SUPABASE_KEY"
        ],
        'method' => 'POST',
        'content' => json_encode($data),
        ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
    //$response_data = json_decode($response, true);
    if  ($response === false) {
        echo "Error: unable to save data to supabase";
        exit;
    } else {
        echo "User has been created.";//.json_encode($response_data);
    }   
}

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
    save_data_supabase($email, $enc_pass);
    echo "<script>alert('Registration successful!');</script>";
    header('refresh:0; url=http://127.0.0.1/beta/api/src/login_form.html');
} else { 
    echo " Registration failed!";
}
pg_close($conn); 

?>