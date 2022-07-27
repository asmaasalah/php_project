<?php
include "./database/config.php";
include "./database/function.php";
include './database/checklogin.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  

  $email    = Clean($_POST['email']);
  $password = Clean($_POST['password']);

  $errors = [];


  # Validate Email
  if (!Validate($email, 1)) {
      $errors['Email'] = 'Field Required';
  } elseif (!Validate($email, 2)) {
      $errors['Email'] = 'Invalid Email';
  }

  # Validate Password
  if (!Validate($password, 1)) {
      $errors['Password'] = 'Field Required';
  } elseif (!Validate($password, 3)) {
      $errors['Password'] = 'Length must be >= 6 chars';
  }

  if (count($errors) > 0) {
      # Print Errors
      Messages($errors);
  } else {
      # Logic ....... 

    

      $sql = "select * from user where email = '$email' and password = '$password'";
      $op  = mysqli_query($conn,$sql);

      if(mysqli_num_rows($op) == 1){
          // code .... 
         $data = mysqli_fetch_assoc($op);
         
         $_SESSION['user'] = $data;

         header("Location: index.php");

      }else{
          echo '* Error in Email || Password Try Again !!!!';
      }



  }
}

?>



<!DOCTYPE html>
<html lang="en">
    <head>
      
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

</head>
    

    <body class="bg-light">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form   action = "<?php   echo htmlspecialchars($_SERVER['PHP_SELF']);?>"   method = "post" >
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control py-2" id="inputEmailAddress"  name ="email" type="email" placeholder="Enter email address" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control py-2" id="inputPassword" name="password"  type="password" placeholder="Enter password" />
                                            </div>
 
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type="submit" class="btn btn-primary">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="register.php"> Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
          
        
    </body>
</html>