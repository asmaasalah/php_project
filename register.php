<?php
include "./database/config.php";
include "./database/function.php";


#########################################################################
# Fetch Roles .... 
$sql = "select * from roles";
$RoleOp  = mysqli_query($conn,$sql);

#########################################################################



# Code .....

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname      = Clean($_POST['fname']);
    $lname      = Clean($_POST['lname']);
    $email     = Clean($_POST['email']);
    $password  = Clean($_POST['password']); 
    $role_id   = $_POST['role_id'];
    $date   = Clean($_POST['date']);


    # Validate name ....
    $errors = [];

    if (!Validate($fname, 1)) {
        $errors['fName'] = 'Required Field';
    } elseif (!Validate($fname, 6)) {
        $errors['fName'] = 'Invalid String';
    }

    if (!Validate($lname, 1)) {
        $errors['lName'] = 'Required Field';
    } elseif (!Validate($lname, 6)) {
        $errors['lName'] = 'Invalid String';
    }
    # Validate Email
    if (!Validate($email,1)) {
        $errors['Email'] = 'Field Required';
    } elseif (!Validate($email,2)) {
        $errors['Email'] = 'Invalid Email';
    }


    # Validate Password
    if (!Validate($password,1)) {
        $errors['Password'] = 'Field Required';
    } elseif (!Validate($password,3)) {
        $errors['Password'] = 'Length must be >= 6 chars';
    }

    
     # Validate role_id .... 
     if (!Validate($role_id,1)) {
        $errors['Role'] = 'Field Required';
    }elseif(!Validate($role_id,4)){
        $errors['Role'] = "Invalid Id";
    }

   
    # Validate Image
    if (!Validate($_FILES['image']['name'],1)) {
        $errors['Image'] = 'Field Required';
    }else{

         $ImgTempPath = $_FILES['image']['tmp_name'];
         $ImgName     = $_FILES['image']['name'];

         $extArray = explode('.',$ImgName);
         $ImageExtension = strtolower(end($extArray));

         if (!Validate($ImageExtension,7)) {
            $errors['Image'] = 'Invalid Extension';
         }else{
             $FinalName = time().rand().'.'.$ImageExtension;
         }

    }


    if (count($errors) > 0) {
        $Message = $errors;
    } else {
        // DB CODE .....

       $disPath = './uploads/'.$FinalName;


       if(move_uploaded_file($ImgTempPath,$disPath)){

        $sql = "insert into user (fname,lname,email,password,image,role_id,date) values ('$fname','$lname','$email','$password','$FinalName',$role_id,'$date')";
        $op = mysqli_query($conn, $sql);

        if ($op) {
            $Message = ['Message' => 'Raw Inserted'];
        } else {
            $Message = ['Message' => 'Error Try Again ' . mysqli_error($con)];
        }
    
       }else{
        $Message = ['Message' => 'Error  in uploading Image  Try Again ' ];
       }
    
    }
    # Set Session ......
    $_SESSION['Message'] = $Message;
}


?>

<head>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<style>
            *{
                box-sizing:border-box;
            }
        input[type=text],select, textarea,input[type=password],input[type=email],input[type=date]{
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

input[type=submit],input[type=reset] {
  background-color: blue;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: left;
  margin-top:6px;
  margin-left:154px;
}

input[type=submit]:hover,input[type=reset]:hover {
  background-color: red;
}

.container {
  border-radius: 5px;
  background-color:#e7e9eb ;
  padding: 25px;
  width: 50%;
  margin:auto;
}

.col-1 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col-2 {
  float: left;
  width: 75%;
  margin-top: 6px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display:table;
  clear: both;
}

/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .col-1, .col-2, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}
        }
    .error{
      color:red;
        }
        </style>
        
</head>

<main>
    <div class="container-fluid">
        <ol class="breadcrumb mb-4">
            <h2 class="breadcrumb-item active">Register</h2>

            <?php
            echo '<br>';
            if (isset($_SESSION['Message'])) {
                Messages($_SESSION['Message']);
            
                # Unset Session ...
                unset($_SESSION['Message']);
            }
            
            ?>

        </ol>


        <div class="card mb-4">

            <div class="card-body">

                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputName">FName</label>
                        <input type="text" class="form-control" id="exampleInputName" name="fname" aria-describedby=""
                            placeholder="Enter FName">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName">LName</label>
                        <input type="text" class="form-control" id="exampleInputName" name="lname" aria-describedby=""
                            placeholder="Enter LName">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail">Email address</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="email"
                            aria-describedby="emailHelp" placeholder="Enter email">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword">New Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password"
                            placeholder="Password">
                    </div>



                    <div class="form-group">
                        <label for="exampleInputPassword">Role</label>
                        <select class="form-control" id="exampleInputPassword1" name="role_id">

                            <?php
                               while($data = mysqli_fetch_assoc($RoleOp)){
                            ?>

                            <option value="<?php echo $data['id'];?>"><?php echo $data['title'];?></option>

                            <?php }
                            ?>

                        </select>
                    </div>


                    <div class="form-group">
                        <label for="exampleInputName">Date Of Birth</label>
                        <input type="date" class="form-control" id="exampleInputName" name="date" aria-describedby="">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputName">Image</label>
                        <input type="file" name="image">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>





            </div>
        </div>
    </div>
</main>


