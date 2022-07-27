<?php
 
 session_start();

$server    = "localhost";
$dbName     = "myarticles"; 
$dbUser     = "root";
$dbPassword = "";
 
  $conn =  mysqli_connect($server,$dbUser,$dbPassword,$dbName);

    if($conn->connect_error){
      
        die("connection failed". $conn->connect_error);
    }



?>