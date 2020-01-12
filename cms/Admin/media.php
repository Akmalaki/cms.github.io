<?php require_once('inc/top.php');

ob_start();
session_start();
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}

?>
</head>
  <body>
      <div id="wrapper">
      <?php require_once('inc/header.php');?>
      <div class="container-fluid body-section">
      <div class="row">
          <div class="col-md-3">
          <?php require_once('inc/sidebar.php');?>

          </div><!--Close col-md 3-->
          <div class="col-md-9">
          <h1><i class="fa fa-database" aria-hidden="true"></i> Media <small>Add Or View Media files</small></h1><hr>
              <ol class="breadcrumb">
                  <li><a href="index.php"><i class="fa fa-database" aria-hidden="true"></i> Dashboard</a></li>
                  <li class="active"><i class="fa fa-database" aria-hidden="true"></i> Media</li>
              </ol>
              <!--Add media files-->
              <?php 
              
              if(isset($_POST['submit'])){
                  if(count($_FILES['media']['name']) > 0){
                      
                      for($i = 0;$i < count($_FILES['media']['name']);$i++){
                          
                          $image = $_FILES['media']['name'][$i];
                          $tmp_name = $_FILES['media']['tmp_name'][$i];
                          
                          $media_query ="INSERT INTO media (image) VALUES ('$image')";
                          if(mysqli_query($con,$media_query)){
                              $path = "media/$image";
                              if(move_uploaded_file($tmp_name, $path)){
                                  copy($path, "../$path");
                              }
                              header('location: media.php');
                          }
                      }
                  }
              }
              
              ?>
              
              <!--Add media files-->
          <form action="" method="post" enctype="multipart/form-data">
              <div class="row">
                  <div class="col-sm-4 col-xs-8">
                    <input type="file" name="media[]" required multiple>
                  </div>
                  <div class="col=sm-4 col-xs-4">
                  <input type="submit" value="Add Media" name="submit" class="btn btn-primary btn-sm">
                  </div>
              </div>
              </form><hr>
              <div class="row">
                  <?php 
                  
                  $query ="SELECT * FROM media ORDER By id DESC";
                  $run = mysqli_query($con,$query);
                  if(mysqli_num_rows($run) > 0){
                   while($get_row =mysqli_fetch_array($run)){
                       $get_image =$get_row['image'];
                      
                  
                  ?>
                  <div class="col-lg-2 col-md-3 col-sm-3 col-xs-6 thumb">
                      <a href="media/<?php echo $get_image;?>" class="thumbnail">
                      <img src="media/<?php echo $get_image;?>" width="100%" alt="">
                      </a>
                  </div>
                  <?php
                       }
                  }
                  else
                  {
                      echo "<center><h2>No Media Files Available Now</h2></cnter>";
                  }
                  
                  ?>
              </div>
          </div><!--Close col-md 9-->
          
          </div><!--Row Close-->
          
      </div>
      <?php require_once('inc/footer.php');?>