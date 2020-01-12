<?php require_once('inc/top.php');

ob_start();
session_start();

if(!isset($_SESSION['username'])){
    header('Location: login.php');
}

$session_username = $_SESSION['username'];
$session_author_image = $_SESSION['author_image'];
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
          <h1><i class="fa fa-plus-square" aria-hidden="true"></i> Add Posts <small>Add New Posts</small></h1><hr>
              <ol class="breadcrumb">
                  <li class="a"><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                  <li class="active"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Posts</li>
              </ol>
              <!--insert post data start-->
          <?php
              
              if(isset($_POST['submit'])){
                  $date =time();
                  $title = mysqli_real_escape_string($con,$_POST['title']);
                  $post_data =mysqli_real_escape_string($con,$_POST['post_data']);
                  $image =$_FILES['image']['name'];
                  $tmp_name =$_FILES['image']['tmp_name'];
                  $categories =$_POST['categories'];
                  $tags =mysqli_real_escape_string($con,$_POST['tags']);
                  $status =$_POST['status'];
                  if(empty($title) or empty($post_data) or empty($image) or empty($tags)){
                      
                      $error ="All * Feilds are Requered";
                  }
                  else
                  {
                    $insert_query= "INSERT INTO posts (date,title,author,author_image,image,category,tags,post_data,views,status) VALUES ('$date','$title','$session_username','$session_author_image','$image','$categories','$tags','$post_data','0','$status')";   
                     if(mysqli_query($con,$insert_query)){
                          $msg = "Post Has Been Added Successfully";
                         $title ="";
                         $post_data ="";
                         $categories ="";
                         $tags ="";
                         $status ="";
                         $path = "image/$image";
                         if(move_uploaded_file($tmp_name,$path)){
                             copy($path, "../$path");
                         }
                      }
                      else
                      {
                          $error ="Post Has Not Been Added";
                      }
                  }
              }
              
              ?>
              <div class="row">
              <div class="col-xs-12">
                  <form action="" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                      <label for="title">Title:*</label>
                          <?php if(isset($msg)){ echo "<span class='pull-right' style='color:green'>$msg</span>";}
                        else if(isset($error)){ echo "<span class='pull-right' style='color:red'>$error</span>";}
                          ?>
                          <input type="text" name="title" value="<?php if(isset($title)){echo $title;}?>" placeholder="Type Post Title Here" class="form-control">
                      </div>
                      <div class="form-group">
                      <a href="media.php" class="btn btn-primary btn-sm" >Add Media</a>
                      </div>
                      <div class="form-group">
                      <textarea name="post_data" id="textarea" rows="10" class="form-control"><?php if(isset($post_data)){echo $post_data;}?></textarea>
                      </div>
                      <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group">
                              <label for="post image">Post Image:*</label>
                            <input type="file" name="image" class="form-control">
                              </div>
                          </div>
                          <div class="col-sm-6">
                          <div class="form-group">
                              <label for="categories">Categories</label>
                              <select name="categories" id="" class="form-control">
                                  <?php
                                  $cat_query ="SELECT * FROM categories ORDER BY id DESC";
                                  $cat_run =mysqli_query($con,$cat_query);
                                  if(mysqli_num_rows($cat_run) > 0)
                                  {
                                      while($cat_row =mysqli_fetch_array($cat_run))
                                      {
                                          $cat_name=$cat_row['category'];
                                          echo "<option value='".$cat_name."' ".((isset($categories) and $categories == $cat_name)?"selected":"").">".ucfirst($cat_name)."</option>";
                                      }
                                      
                                  }
                                  else
                                  {
                                      echo "<center><h6>Category Not Available Now</h6></center>";
                                  }
                                  ?>
                              </select>
                              </div>
                          </div>  
                      </div>
                      <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group">
                              <label for="tags">Tags:*</label>
                            <input type="text" name="tags" value="<?php if(isset($tags)){echo $tags;}?>" placeholder="Your Tags Here " class="form-control">
                              </div>
                          </div>
                          <div class="col-sm-6">
                          <div class="form-group">
                              <label for="status">Status</label>
                              <select name="status" id="status" class="form-control">
                                  <option value="publish" <?php if(isset($status) and $status =='publish'){echo "selected";}?> >Publish</option>
                                  <option value="draft" <?php if(isset($status) and $status =='draft'){echo "selected";}?> >Draft</option>
                              </select>
                              </div>
                          </div>  
                      </div>
                      <input type="submit" value="Add Post" name="submit" class="btn btn-primary btn-sm">
                  </form>
              </div>
          </div>
              
              
          </div><!--Row Close-->
          
      </div>
      <?php require_once('inc/footer.php');?>