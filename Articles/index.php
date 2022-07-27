<?php
include '../database/config.php';
include '../database/function.php';
################################################################
# Fetch  User Data .......

if($_SESSION['user']['role_id'] == 2){
   $sql = 'select articles.*,user.fname  from  articles inner join user on user.id = articles.addedBy';
}else{
   $sql = 'select articles.*,user.name  from  articles inner join user on user.id = articles.addedBy where articles.addedBy = '.$_SESSION['user']['id'];

}



$op = mysqli_query($conn, $sql);
################################################################

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
            <h2 class="breadcrumb-item active">Articales/display</h2>
            <?php 
            echo '<br>';
           if(isset($_SESSION['Message'])){
             Messages($_SESSION['Message']);
          
              # Unset Session ... 
              unset($_SESSION['Message']);
              }
        
             ?>
        </ol>


        <div class="card mb-4">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Date</th>
                                <th>image</th>
                                <th>AddedBy</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>

                            <?php 
                                        # Fetch Data ...... 
                                        while($data = mysqli_fetch_assoc($op)){
                                      
                                    ?>

                            <tr>
                                <td><?php echo $data['id']; ?></td>
                                <td><?php echo $data['title']; ?></td>
                                <td><?php echo substr($data['content'],0,20); ?></td>
                                <td><?php echo date($data['date']); ?></td>
                                <td> <img src="./uploads/<?php echo $data['image']; ?>" height="40px" width="40px">  </td>
                                <td><?php echo $data['fname'];?></td>


                                <td>
                                    <a href='delete.php?id=<?php echo $data['id']; ?>'
                                        class='btn btn-danger m-r-1em'>Delete</a>
                                    <a href='edit.php?id=<?php echo $data['id']; ?>' class='btn btn-primary m-r-1em'>Edit</a>
                                </td>

                            </tr>

                            <?php 
                                        }
                                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

