      <?php require_once('inc/top.php');
    ob_start();
    session_start();
    if(!isset($_SESSION['username'])){
        header('Location: login.php');
        }
else if(isset($_SESSION['username']) && $_SESSION['role'] =='author'){
            header('Location: index.php');
}?>
<!--Delete User Query-->
<?php 

if(isset($_GET['del'])){
    
    $del_id = $_GET['del'];
    
    $del_check_query ="SELECT * FROM users WHERE id = $del_id";
    $del_check_run = mysqli_query($con,$del_check_query);
    if(mysqli_num_rows($del_check_run)>0){
        $del_query ="DELETE FROM `users` WHERE `users`.`id` = $del_id";
    if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin'){
        if(mysqli_query($con,$del_query)){
        
        $msg =" User Has Been Deleted Successfully";
    }
    else 
    {
        $errror ="User Has Not Been Deleted";
    }
    }
    }
    else
    {
        header('Location: index.php');
    }
}

?>
<!--Delete User Query-->

<!--Bulk Option Checkboxes-->
<?php 

if(isset($_POST['checkboxes']))
{
    foreach($_POST['checkboxes']as $user_id){
        $bulk_options = $_POST['bulk-options'];
        
        if($bulk_options == 'delete'){
            
            $bulk_del_query ="DELETE FROM `users` WHERE `users`.`id` = $user_id";
mysqli_query($con,$bulk_del_query);            
        }
        else if($bulk_options == 'author'){
            $bulk_author_query = "UPDATE `users` SET `role` = 'author' WHERE `users`.`id` = $user_id";
            mysqli_query($con,$bulk_author_query);
        }
        else if($bulk_options == 'admin'){
            $bulk_admin_query = "UPDATE `users` SET `role` = 'admin' WHERE `users`.`id` = $user_id";
            mysqli_query($con,$bulk_admin_query);
        }
    }
}

?>
<!--Bulk Option Checkboxes-->
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
          <h1><i class="fa fa-users" aria-hidden="true"></i> Users <small>View all Users</small></h1><hr>
              <ol class="breadcrumb">
                  <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                  <li><a href="categories.php"><i class="fa fa-folder-open" aria-hidden="true"></i>Categories</a></li>
                  <li class="active"><i class="fa fa-users" aria-hidden="true"></i> Users</li>
              </ol>
              
              <?php
              
              $query = "SELECT * FROM users ORDER BY id DESC";
              $run = mysqli_query($con,$query);
              if(mysqli_num_rows($run) > 0){
              
              ?>
              <form action="#" method="post">
              <div class="row">
              <div class="col-sm-8">
                  
                  <div class="row">
                  <div class="col-xs-4">
                  <select name="bulk-options" id="" class="form-control">
                      <option value="delete">Delete</option>
                      <option value="author">Change to Author</option>
                      <option value="admin">Change to Admin</option>
                      </select>
                      </div><!--col xs 4 close-->
                  <div class="col-xs-8">
                      <input type="submit" value="Apply" class="btn btn-success">
                      <a href="add_users.php" class="btn btn-primary">Add New</a>
                  </div> <!--col xs 8 close-->     
                  </div><!--Inner row form close-->
                  
              </div>
                  <div class="col-sm-4">
                      <?php
                      if(isset($msg)){
                          echo "<span class='pull-right' style='color:Green;'>$msg</span>";
                      }
                  else if(isset($error)){
                      echo "<span class='pull-right' style='color:Green;'>$error</span>";
                  }
                      ?>
                  </div>
              </div><br>
              
              <table class="table table-hover table-striped table-bordered" >
              <thead>
                  <tr>
                      <th><input type="checkbox" id="selectallboxes"></th>
                      <th>Sr #</th>
                      <th>Date</th>
                      <th>Name</th>
                      <th>User Name</th>
                      <th>Email</th>
                      <th>Image</th>
                      <th>Password</th>
                      <th>Rol</th>
                      <th>Edit</th>
                      <th>Delete</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php
                      while($row = mysqli_fetch_array($run)){
                          $id = $row['id'];
                          $date = getdate($row['date']);
                          $day = $date['mday'];
                          $month = substr($date['month'],0,3);
                          $year = $date['year'];
                          $first_name = ucfirst($row['first_name']);
                          $last_name = ucfirst($row['last_name']);
                          $username = $row['username'];
                          $email = $row['email'];
                          $image = $row['image'];
                          $password = $row['password'];
                          $role = ucfirst($row['role']);
                           
                      
                      ?>
                  <tr>
                      <th><input type="checkbox" class="checkboxes" name="checkboxes[]" value="<?php echo $id?>"></th>
                      <td><?php echo $id;?></td>
                      <td><?php echo "$day $month $year";?></td>
                      <td><?php echo "$first_name $last_name";?></td>
                      <td><?php echo $username;?></td>
                      <td><?php echo $email;?></td>
                      <td><img src="image/<?php echo $image;?>" width="30px"></td>
                      <td>****************</td>
                      <td><?php echo $role;?></td>                      
                      <td><a href="edit_users.php?edit=<?php echo $id?>"><i class="fa fa-pencil"></i></a></td>
                      <td><a href="users.php?del=<?php echo $id?>"><i class="fa fa-times"></i></a></td>
                      </tr><!-- td tr 1 close-->
                      <?php }?>
                  </tbody>
              </table><!--User table close--><hr>
                  <?php
                  }
              
              else{
                  echo "<center><h2>Users Not available Now</h2></center>";
              }
                  ?>
                  </form>
              <nav id="pagination">
                  
                  <ul class="pagination">
                    <li>
                      <a href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li>
                      <a href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                  </ul>
                </nav><!--nav Pagination close-->
          </div><!--Close col-md 9-->
          
          </div><!--Row Close-->
          
      </div>
            <?php require_once('inc/footer.php');?>