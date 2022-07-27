<?php
include '../database/config.php';
include '../database/function.php';


#############################################################################
$id = $_GET['id'];

$sql = "select * from articles where id = $id";
$op = mysqli_query($conn, $sql);

if (mysqli_num_rows($op) == 1) {

    
    // code .....
    $BlogData = mysqli_fetch_assoc($op);

      if(!($_SESSION['user']['role_id'] == 2 || ($_SESSION['user']['id'] == $BlogData['addedBy']))){
        header('Location: index.php');
        exit();

      }
      
    } else {
        $_SESSION['Message'] = ['Message' => 'Invalid Id'];
        header('Location: index.php');
        exit();
    }
    
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = Clean($_POST['title']);
        $content = Clean($_POST['content']);
        $date = Clean($_POST['date']);
    
        # Validate name ....
        $errors = [];
    
        # Validate Title
        if (!Validate($title, 1)) {
            $errors['Title'] = 'Required Field';
        } elseif (!Validate($title, 6)) {
            $errors['Title'] = 'Invalid String';
        }
    
        # Validate Desc ...
        if (!Validate($content, 1)) {
            $errors['Content'] = 'Required Field';
        } elseif (!Validate($content, 3, 20)) {
            $errors['Content'] = 'Length Must be  >= 20 CHARS';
        }
    
    
    
        # Validate date ....
        if (!Validate($date, 1)) {
            $errors['date'] = 'Field Required';
        }
    
        # Validate Image
        if (Validate($_FILES['image']['name'], 1)) {
            $ImgTempPath = $_FILES['image']['tmp_name'];
            $ImgName = $_FILES['image']['name'];
    
            $extArray = explode('.', $ImgName);
            $ImageExtension = strtolower(end($extArray));
    
            if (!Validate($ImageExtension, 7)) {
                $errors['Image'] = 'Invalid Extension';
            } else {
                $FinalName = time() . rand() . '.' . $ImageExtension;
            }
        }
    
        if (count($errors) > 0) {
            $Message = $errors;
        } else {
            // DB CODE .....
    
            if (Validate($_FILES['image']['name'], 1)) {
                $disPath = './uploads/' . $FinalName;
    
                if (!move_uploaded_file($ImgTempPath, $disPath)) {
                    $Message = ['Message' => 'Error  in uploading Image  Try Again '];
                } else {
                    unlink('./uploads/' . $BlogData['image']);
                }
            } else {
                $FinalName = $BlogData['image'];
            }
    
            if (count($errors) == 0) {
                $date = strtotime($date);
                $sql = "update articles set title='$title' , content='$content' , date= $date , image ='$FinalName' where id = $id";
    
                $op = mysqli_query($conn, $sql);
    
                if ($op) {
                    $Message = ['Message' => 'Raw Updated'];
                } else {
                    $Message = ['Message' => 'Error Try Again ' . mysqli_error($conn)];
                }
            }
            # Set Session ......
            $_SESSION['Message'] = $Message;
            header('Location: index.php');
            exit();
        }
        $_SESSION['Message'] = $Message;
    }
    
    
    ?>
    
    <head>
        <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    
    </head>
    
    <main>
        <div class="container-fluid">
            <ol class="breadcrumb mb-4">
                <h2 class="breadcrumb-item active">Edit Articals</h2>
    
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
    
                    <form action="edit.php?id=<?php echo $BlogData['id']; ?>" method="post" enctype="multipart/form-data">
    
                        <div class="form-group">
                            <label for="exampleInputName">Title</label>
                            <input type="text" class="form-control" id="exampleInputName" name="title" aria-describedby=""
                                placeholder="Enter Title" value="<?php echo $BlogData['title']; ?>">
                        </div>
    
    
                        <div class="form-group">
                            <label for="exampleInputName"> Content</label>
                            <textarea class="form-control" id="exampleInputName"
                                name="content"> <?php echo $BlogData['content']; ?></textarea>
                        </div>
    
    
                        <div class="form-group">
                            <label for="exampleInputName">Date</label>
                            <input type="date" class="form-control" id="exampleInputName" name="date" aria-describedby=""
                                value="<?php echo date($BlogData['date']); ?>">
                        </div><br>
    
    
                        <div class="form-group">
                            <label for="exampleInputName">Image</label>
                            <input type="file" name="image">
                        </div><br>
    
                        <img src="./uploads/<?php echo $BlogData['image']; ?>" alt="" height="50px" width="50px"> <br><br>
    
    
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
    
    
                </div>
            </div>
        </div>
    </main>
    
   