      <?php require_once('inc/top.php');
ob_start();
session_start();
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}
else if(isset($_SESSION['username']) && $_SESSION['role'] =='author'){
            header('Location: index.php');
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
          <h1><i class="fa fa-user-plus" aria-hidden="true"></i> Add Users <small>Add New Users</small></h1><hr>
              <ol class="breadcrumb">
                  <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                  <li class="active"><i class="fa fa-user-plus" aria-hidden="true"></i> Add New Users</li>
              </ol>
              <?php
              
              if(isset($_POST['submit'])){
                  $date = time();
                  $first_name =mysqli_real_escape_string($con,$_POST['first_name']);
                  $last_name =mysqli_real_escape_string($con,$_POST['last_name']);
                  $username =mysqli_real_escape_string($con,strtolower($_POST['username']));
                  $username_trim = preg_replace('/\s+/','',$username);
                  $email =mysqli_real_escape_string($con,strtolower($_POST['email']));
                  $password =mysqli_real_escape_string($con,$_POST['password']);
                  $role =$_POST['role'];
                  $image =$_FILES['image']['name'];
                  $image_tmp =$_FILES['image']['tmp_name'];
                  
                  $check_query ="SELECT * FROM users WHERE username ='$username' or email ='$email'";
                  $check_run =mysqli_query($con,$check_query);
                  
                  $salt_query ="SELECT * FROM users Order BY id DESC Limit 1";
                  $salt_run = mysqli_query($con,$salt_query);
                  $salt_row = mysqli_fetch_array($salt_run);
                  $salt = $salt_row['salt'];
                  $password = crypt($password,$salt);
                  
                                    
                  if(empty($first_name) or empty($last_name) or empty($username) or empty($email) or empty($password) or empty($image)){
                      $error = "All Star(*) Feilds are Required";
                  }
                  else if($username != $username_trim)
                  {
                      $error = "Dont Use The Space in User Name Feild ";
                  }
                  else if(mysqli_num_rows($check_run) > 0)
                  {
                      $error = "User Name and Email Address Already Exixts. Please Try again";
                  }
                  else 
                  {
                      $insert_query ="INSERT INTO `users` (`id`, `date`, `first_name`, `last_name`, `username`, `email`, `image`, `password`, `role`) VALUES (NULL, '$date', '$first_name', '$last_name', '$username', '$email', '$image', '$password', '$role')";
                      
                      if(mysqli_query($con,$insert_query))
                      {
                          $msg = "User Added Successfully";
                          
                          move_uploaded_file($image_tmp, "image/$image");
                          $image_check = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
                          $image_run =mysqli_query($con,$image_check);
                          $image_row = mysqli_fetch_array($image_run);
                          $check_image = $image_row['image'];
                          
                          $first_name ="";
                          $last_name ="";
                          $username ="";
                          $email ="";
                      }
                      else 
                      {
                          $error ="User Not Added";
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
                          <input type="text" id="first_name" name="first_name" value="<?php if(isset($first_name)){echo $first_name;}?>" placeholder="First Name" class="form-control">
                      </div>
                          <div class="form-group">
                          <label for="last_name">Last Name:*</label>
                          <input type="text" id="last_name" name="last_name" value="<?php if(isset($last_name)){echo $last_name;}?>" placeholder="Last Name" class="form-control">
                      </div>
                          <div class="form-group">
                          <label for="username">User Name:*</label>
                          <input type="text" id="username" name="username" value="<?php if(isset($username)){echo $username;}?>" placeholder="Username" class="form-control">
                      </div>
                          <div class="form-group">
                          <label for="email">Email:*</label>
                          <input type="text" id="email" name="email"value="<?php if(isset($email)){echo $email;}?>" placeholder="Email Address" class="form-control">
                      </div>
                          <div class="form-group">
                          <label for="password">Password:*</label>
                          <input type="password" id="password" name="password" placeholder="Password" class="form-control">
                      </div>
                          <div class="form-group">
                          <label for="role">Role:*</label>
                              <select name="role" id="role" class="form-control">
                                  <option value="author">Author</option>
                                  <option value="admin">Admin</option>
                              </select>
                         </div>
                          <div class="form-group">
                          <label for="image">Profile Picture:*</label>
                          <input type="file"  id="image" name="image">
                      </div>
                          <input type="submit" value="Add User" name="submit" class="btn btn-primary">
              </form>
                  </div>
                  <div class="col-md-4">
                  <?php 
                      
                      if(isset($check_image))
                      {
                          echo "<img src='image/$check_image' width='100%'>";
                      }
                      
                      ?>
                  </div>
              </div>
              
          </div><!--Close col-md 9-->
          
          </div><!--Row Close-->
          
      </div>
            <?php require_once('inc/footer.php');?>