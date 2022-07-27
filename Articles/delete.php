<?php 
include '../database/config.php';


# Fetch Id .... 
$id = $_GET['id'];

$sql = "select * from articles where id = $id";
$op  = mysqli_query($conn,$sql);

$data = mysqli_fetch_assoc($op);

# Check If Count == 1 
if(mysqli_num_rows($op) == 1){

    // delete code ..... 
   $sql = "delete from articles where id = $id";
   $op  = mysqli_query($conn,$sql);

   if($op){

    unlink('./uploads/'.$data['image']);

       $Message = ["Message" => "Raw Removed"];
   }else{
       $Message = ["Message" => "Error try Again"];
   }


}else{
    $Message = ["Message" => "Invalid Id "];
}

   #   Set Session 
   $_SESSION['Message'] = $Message;

   header("location: index.php");

?>