<?php 
  require './database/config.php';
  require './database/function.php';
  require './database/checklogin.php';

$sql = 'select articles.*,user.fname ,user.lname ,user.image as userImage  from  articles  inner join user on user.id = articles.addedBy';
$op  = mysqli_query($conn,$sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
      
      <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  <style>
    .post-image img{
      width: 100%;
      height: 200px;
    }
  </style>
  </head>
<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand ms-3" href="#">Articales</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <?php if($_SESSION['user']['role_id'] == 2){?>
      <div class="navbar-nav col-md-9 ms-4">
        <a class="nav-link active" aria-current="page" href="./Articles/create.php">Add Artical</a>
      </div>
      <?php }?>
        <div class="col-md-3">
             <a href="login.php"><button type="submit" class="btn ">Login</button></a>
        </div>
        
    </div>

  </div>
</nav>


<section>
  <div class="container">
    <div class="row">
      


     <?php 
           // Fetch data .... 
           while($data = mysqli_fetch_assoc($op)){

        ?>


        <div class="col-lg-4 col-md-4 mt-5">
        <div class="post">
          <div class="post-image">
            <img class="img-fluid" src="./uploads/<?php echo $data['image'];?>" alt="">
          </div>
          <div class="post-desc">
            <div class="post-date"><?php echo date($data['date'])?> 
            </div>
            <div class="post-title">
              <h5><a href="view.php?id=<?php echo $data['id']; ?>"><?php echo $data['title'];?></a></h5>
            </div>
            <p><?php echo substr($data['content'],0,100);?></p>
            <div class="post-author">
              <div class="post-author-img">
                <img class="img-fluid" src="./uploads/<?php echo $data['userImage'];?>" alt="">
              </div> <span><?php echo "<b>Writer Name </b>".$data['st_name']." ".$data['lname'];?></span>
            </div>
          </div>
        </div>
      </div>

      <?php } ?>

    </div>
  </div>
</section>

</body>

</html>