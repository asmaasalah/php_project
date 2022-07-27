<?php 
 
 session_start();
 require './database/function.php';

 
 session_destroy();

 header("location: login.php");


?>