      <?php require_once('inc/top.php');
    ob_start();
    session_start();
    if(!isset($_SESSION['username'])){
        header('Location: login.php');
        }
/*else if(isset($_SESSION['username']) && $_SESSION['role'] =='author'){
            header('Location: index.php');
}*/
$session_username =$_SESSION['username'];
?>
<!--Delete User Query-->
<?php 

if(isset($_GET['del'])){
    
    $del_id = $_GET['del'];
    
    $del_check_query ="SELECT * FROM posts WHERE id = $del_id";
    $del_check_run = mysqli_query($con,$del_check_query);
    if(mysqli_num_rows($del_check_run)>0){
        $del_query ="DELETE FROM `posts` WHERE `posts`.`id` = $del_id";
    
        if(mysqli_query($con,$del_query)){
        
        $msg =" Post Has Been Deleted Successfully";
    }
    else 
    {
        $errror ="Post Has Not Been Deleted";
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
    foreach($_POST['checkboxes']as $post_id){
        $bulk_options = $_POST['bulk-options'];
        
        if($bulk_options == 'delete'){
            
            $bulk_del_query ="DELETE FROM `posts` WHERE `posts`.`id` = $post_id";
mysqli_query($con,$bulk_del_query);            
        }
        else if($bulk_options == 'publish'){
            $bulk_publish_query = "UPDATE `posts` SET `status` = 'publish' WHERE `posts`.`id` = $post_id";
            mysqli_query($con,$bulk_publish_query);
        }
        else if($bulk_options == 'draft'){
            $bulk_draft_query = "UPDATE `posts` SET `status` = 'draft' WHERE `posts`.`id` = $post_id";
            mysqli_query($con,$bulk_draft_query);
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
          <h1><i class="fa fa-file-text" aria-hidden="true"></i> Posts <small>View all Posts</small></h1><hr>
              <ol class="breadcrumb">
                  <li><a href="index.php"><i class="fa fa-file-text" aria-hidden="true"></i> Dashboard</a></li>
                  <li><a href="posts.php"><i class="fa fa-file-text" aria-hidden="true"></i> Posts</a></li>
                  <li class="active"><i class="fa fa-file-text" aria-hidden="true"></i> Posts</li>
              </ol>
              
              <?php
              
              if($_SESSION['role'] == 'admin'){
                    $query = "SELECT * FROM posts ORDER BY id DESC";
                    $run = mysqli_query($con,$query);
              }
              else if($_SESSION['role'] == 'author'){
                  $query = "SELECT * FROM posts WHERE author = '$session_username' ORDER BY id DESC";
                    $run = mysqli_query($con,$query);
              }
              
              if(mysqli_num_rows($run) > 0){
              
              ?>
              <form action="#" method="post">
              <div class="row">
              <div class="col-sm-8">
                  
                  <div class="row">
                  <div class="col-xs-4">
                  <select name="bulk-options" id="" class="form-control">
                      <option value="delete">Delete</option>
                      <option value="publish">Publish</option>
                      <option value="draft">Draft</option>
                      </select>
                      </div><!--col xs 4 close-->
                  <div class="col-xs-8">
                      <input type="submit" value="Apply" class="btn btn-success">
                      <a href="add_post.php" class="btn btn-primary">Add New</a>
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
              
              <table class="table table-ifhover table-striped table-bordered" >
              <thead>
                  <tr>
                      <th><input type="checkbox" id="selectallboxes"></th>
                      <th>Sr #</th>
                      <th>Date</th>
                      <th>Title</th>
                      <th>Author</th>
                      <th>Image</th>
                      <th>Category</th>
                      <th>Views</th>
                      <th>status</th>
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
                          $title = $row['title'];
                          $author = $row['author'];
                          $image = $row['image'];
                          $category = $row['category'];
                          $views = $row['views'];
                          $status = $row['status'];
                           
                      
                      ?>
                  <tr>
                      <th><input type="checkbox" class="checkboxes" name="checkboxes[]" value="<?php echo $id?>"></th>
                      <td><?php echo $id;?></td>
                      <td><?php echo "$day $month $year";?></td>
                      <td><?php echo "$title";?></td>
                      <td><?php echo $author;?></td>
                    <td><img src="image/<?php echo $image;?>" width="30px"></td>
                      <td><?php echo $category;?></td>
                      <td><?php echo $views;?></td>
                      <td><span style="color:<?php if($status == 'publish'){echo 'green';} else if($status == 'draft'){echo 'red';}?>;"><?php echo ucfirst($status);?></span></td>
                      <td><a href="edit_posts.php?edit=<?php echo $id?>"><i class="fa fa-pencil"></i></a></td>
                      <td><a href="posts.php?del=<?php echo $id?>"><i class="fa fa-times"></i></a></td>
                      </tr><!-- td tr 1 close-->
                      <?php }?>
                  </tbody>
              </table><!--User table close--><hr>
                  <?php
                  }
              
              else{
                  echo "<center><h2>Posts Not available Now</h2></center>";
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