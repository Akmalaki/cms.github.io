      <?php require_once('inc/top.php');
ob_start();
session_start();
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}
/*Edit users query*/
$session_username = $_SESSION['username'];

if(isset($_GET['edit'])){
    $edit_user = $_GET['edit'];
    $edit_query = "SELECT * FROM users WHERE id ='$edit_user'";
    $edit_query_run = mysqli_query($con,$edit_query);
    if(mysqli_num_rows($edit_query_run)>0){
        $edit_row = mysqli_fetch_array($edit_query_run);
        $e_username = $edit_row['username'];
        
        if($e_username == $session_username){
            $e_first_name = $edit_row['first_name'];
            $e_last_name = $edit_row['last_name'];
            $e_image = $edit_row['image'];
            $e_details = $edit_row['details'];
                                            }
        else 
        {
            header('location: index.php');
        }
                                        }
        else 
        {
            header('location: index.php');
        }
                        }
    else
    {
    header('location: index.php');
    }
/*Edit users query*/
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
          <h1><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profile <small>Edit Users Profile</small></h1><hr>
              <ol class="breadcrumb">
                  <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                  <li class="active"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Profile</li>
              </ol>
              <?php
              
              if(isset($_POST['submit'])){
                  $first_name =mysqli_real_escape_string($con,$_POST['first_name']);
                  $last_name =mysqli_real_escape_string($con,$_POST['last_name']);
                  $password =mysqli_real_escape_string($con,$_POST['password']);
                  $image =$_FILES['image']['name'];
                  $image_tmp =$_FILES['image']['tmp_name'];
                  $details =mysqli_real_escape_string($con,$_POST['details']);
                  if(empty($image)){
                      $image = $e_image;
                  }
                  
                  
                  
                  $salt_query ="SELECT * FROM users Order BY id DESC Limit 1";
                  $salt_run = mysqli_query($con,$salt_query);
                  $salt_row = mysqli_fetch_array($salt_run);
                  $salt = $salt_row['salt'];
                  $insert_password = crypt($password,$salt);
                  
                                    
                  if(empty($first_name) or empty($last_name) or empty($image)){
                      $error = "All Star(*) Feilds are Required";
                  }
                  
                  else 
                  {
                      $update_query = "UPDATE `users` SET `first_name` = '$first_name', `last_name` = '$last_name', `image` = '$image', `details`= '$details'";
                      if(isset($password)){
                          $update_query .=",`password` = '$insert_password'";
                      }
                      $update_query .="WHERE `users`.`id` =$edit_user";
                      if(mysqli_query($con,$update_query)){
                          $msg ="User Has been Updated Successfully";
                          header("refresh:0; url=edit_profile.php?edit=$edit_user");
                          if(!empty($image)){
                              move_uploaded_file($image_tmp, "image/$image");
                          }
                      }
                      else
                      {
                          $error ="User Has Not Been Updated";
                      }
                  }
              }
              
              ?>
              <div class="row">
                  <div class="col-md-8">
                      <form action="" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="first_name">First Name:*</label>
                          <?php if(isset($error))
                            {
                                echo "<span class='pull-right' style='color:red;'>$error</span>";
                            }
                          else if(isset($msg))
                          {
                               echo "<span class='pull-right' style='color:green;'>$msg</span>";
                          }
                          
                          ?>
                          <input type="text" id="first_name" name="first_name" value="<?php echo $e_first_name?>" placeholder="First Name" class="form-control">
                      </div>
                          <div class="form-group">
                          <label for="last_name">Last Name:*</label>
                          <input type="text" id="last_name" name="last_name" value="<?php echo $e_last_name?>" placeholder="Last Name" class="form-control">
                      </div>
                          
                          
                          <div class="form-group">
                          <label for="password">Password:*</label>
                          <input type="password" id="password" name="password" placeholder="Password" class="form-control">
                      </div>
                          
                          <div class="form-group">
                          <label for="image">Profile Picture:*</label>
                          <input type="file"  id="image" name="image">
                          </div>
                          <div class="form-group">
                          <label for="details">Details:*</label>
                          <textarea name="details" id="details" cols="30" rows="10" class="form-control"><?php echo $e_details;?></textarea>
                          </div>
                          <input type="submit" value="Update Profile" name="submit" class="btn btn-primary">
              </form>
                  </div>
                  <div class="col-md-4">
                  <?php 
                          echo "<img src='image/$e_image' width='100%'>";
                      
                      ?>
                  </div>
              </div>
              
          </div><!--Close col-md 9-->
          
          </div><!--Row Close-->
          
      </div>
            <?php require_once('inc/footer.php');?>