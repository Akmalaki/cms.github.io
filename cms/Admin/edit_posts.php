<?php require_once('inc/top.php');

ob_start();
session_start();

if(!isset($_SESSION['username'])){
    header('Location: login.php');
}

$session_username = $_SESSION['username'];
$session_role = $_SESSION['role'];
$session_author_image = $_SESSION['author_image'];

if(isset($_GET['edit'])){
    $edit_id = $_GET['edit'];
    
    if($session_role == "admin"){
        $get_query ="SELECT * FROM posts WHERE id = $edit_id";
    $get_query_run = mysqli_query($con,$get_query);
    }
    
    else if($session_role == "author"){
        $get_query ="SELECT * FROM posts WHERE id = $edit_id and author = '$session_role'";
    $get_query_run = mysqli_query($con,$get_query);
    }
    
    if(mysqli_num_rows($get_query_run) > 0){
        $get_row = mysqli_fetch_array($get_query_run);
        $title =$get_row['title'];
        $post_data =$get_row['post_data'];
        $tags =$get_row['tags'];
        $image =$get_row['image'];
        $status =$get_row['status'];
        $categories =$get_row['category'];
    }
    else
    {
        header('location: posts.php');
    }
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
          <h1><i class="fa fa-pencil" aria-hidden="true"></i> Edit Posts <small>Edit Posts</small></h1><hr>
              <ol class="breadcrumb">
                  <li class="a"><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                  <li class="active"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Posts</li>
              </ol>
              <!--insert post data start-->
          <?php
              
              if(isset($_POST['update'])){
                  $up_title = mysqli_real_escape_string($con,$_POST['title']);
                  $up_post_data =mysqli_real_escape_string($con,$_POST['post_data']);
                  $up_image =$_FILES['image']['name'];
                  $up_tmp_name =$_FILES['image']['tmp_name'];
                  $up_categories =$_POST['categories'];
                  $up_tags =mysqli_real_escape_string($con,$_POST['tags']);
                  $up_status =$_POST['status'];
                  
                  if(empty($up_image)){
                      $up_image = $image;
                  }
                  if(empty($up_title) or empty($up_post_data) or empty($up_image) or empty($up_tags)){
                      
                      $error ="All * Feilds are Required";
                  }
                  else
                  {
                      $update_query ="UPDATE posts SET title = '$up_title', image = '$up_image', category ='$up_categories', tags ='$up_tags', post_data = '$up_post_data', status ='$up_status' WHERE id ='$edit_id'";
                     if(mysqli_query($con,$update_query)){
                          $msg = "Post Has Been Updated Successfully";
                          $path = "image/$up_image";
                         header("location: edit_posts.php?edit=$edit_id");
                         
                         if(!empty($up_image)){
                             if(move_uploaded_file($up_tmp_name,$path)){
                             copy($path, "../$path");
                                }
                            }
                      }
                      else
                      {
                          $error ="Post Has Not Been Updated";
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
                                  <option value="publish" <?php if(isset($status) and $status =='publish'){echo "selected";}?>>Publish</option>
                                  <option value="draft" <?php if(isset($status) and $status =='draft'){echo "selected";}?>>Draft</option>
                              </select>
                              </div>
                          </div>  
                      </div>
                      <input type="submit" value="Update" name="update" class="btn btn-primary btn-sm">
                  </form>
              </div>
          </div>
              
              
          </div><!--Row Close-->
          
      </div>
      <?php require_once('inc/footer.php');?>