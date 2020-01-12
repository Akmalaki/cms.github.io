      <?php require_once('inc/top.php');
    ob_start();
    session_start();
    if(!isset($_SESSION['username'])){
        header('Location: login.php');
        }
else if(isset($_SESSION['username']) && $_SESSION['role'] =='author'){
            header('Location: index.php');
    
}
$session_username = $_SESSION['username'];
?>
<!--Delete comments Query-->
<?php 

if(isset($_GET['del'])){
    
    $del_id = $_GET['del'];
    
    $del_check_query ="SELECT * FROM comments WHERE id = $del_id";
    $del_check_run = mysqli_query($con,$del_check_query);
    if(mysqli_num_rows($del_check_run)>0){
        $del_query ="DELETE FROM `comments` WHERE `comments`.`id` = $del_id";
    if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin'){
        if(mysqli_query($con,$del_query)){
        
        $msg =" Comment Has Been Deleted Successfully";
    }
    else 
    {
        $errror ="Comment Has Not Been Deleted";
    }
    }
    }
    else
    {
        header('Location: index.php');
    }
}

?>
<!--Delete comments Query-->

<!--Upadate status to Approve-->
<?php

if(isset($_GET['approve'])){
    $approve_id =$_GET['approve'];
    $approve_check_query_ ="SELECT * FROM comments WHERE id = $approve_id";
    $approve_query_run = mysqli_query($con,$approve_check_query_);
    if(mysqli_num_rows($approve_query_run)>0){
        
        $approve_query ="UPDATE `comments` SET `status` = 'Approve' WHERE `comments`.`id` = $approve_id";
        if(isset($_SESSION['username']) && $_SESSION['role']=='admin'){
            if(mysqli_query($con,$approve_query)){
                $msg ="Comment Has Been Approved";
            }
            else{ $error ="Comment Has Not Been Approve";}
        }
    }
    else { header('Location: index.php'); }
}

?>
<!--Upadate status to Approve-->

<!--Upadate status to unapprove-->
<?php

if(isset($_GET['unapprove'])){
    $unapprove_id =$_GET['unapprove'];
    $unapprove_check_query_ ="SELECT * FROM comments WHERE id = $unapprove_id";
    $unapprove_query_run = mysqli_query($con,$unapprove_check_query_);
    if(mysqli_num_rows($unapprove_query_run)>0){
        
        $unapprove_query ="UPDATE `comments` SET `status` = 'Pending' WHERE `comments`.`id` = $unapprove_id";
        if(isset($_SESSION['username']) && $_SESSION['role']=='admin'){
            if(mysqli_query($con,$unapprove_query)){
                $msg ="Comment Has Been Unapproved";
            }
            else{ $error ="Comment Has Not Been Unapprove";}
        }
    }
    else { header('Location: index.php'); }
}

?>
<!--Upadate status to unapprove-->


<!--Bulk Option Checkboxes-->
<?php 

if(isset($_POST['checkboxes']))
{
    foreach($_POST['checkboxes']as $user_id){
        $bulk_options = $_POST['bulk-options'];
        
        if($bulk_options == 'delete'){
            
            $bulk_del_query ="DELETE FROM `comments` WHERE `comments`.`id` = $user_id";
mysqli_query($con,$bulk_del_query);            
        }
        else if($bulk_options == 'approve'){
            $bulk_author_query = "UPDATE `comments` SET `status` = 'Approve' WHERE `comments`.`id` = $user_id";
            mysqli_query($con,$bulk_author_query);
        }
        else if($bulk_options == 'pending'){
            $bulk_admin_query = "UPDATE `comments` SET `status` = 'Unapprove' WHERE `comments`.`id` = $user_id";
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
          <h1><i class="fa fa-comments" aria-hidden="true"></i> Comments <small>View all Comments</small></h1><hr>
              <ol class="breadcrumb">
                  <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
<!--                  <li><a href="categories.php"><i class="fa fa-folder-open" aria-hidden="true"></i>Comment</a></li>-->
                  <li class="active"><i class="fa fa-comments" aria-hidden="true"></i> comments</li>
              </ol>
              <!--Reply Comments Box-->
              
              <?php
              
              if(isset($_GET['reply'])){
                  $reply_id = $_GET['reply'];
                  
                  $reply_check_query = "SELECT * FROM comments WHERE post_id = $reply_id";
                  $reply_check_run =mysqli_query($con,$reply_check_query);
                  if(mysqli_num_rows($reply_check_run) > 0){
                      if(isset($_POST['reply'])){
                          $comment_data = $_POST['comment'];
                          if(empty($comment_data)){
                              $comment_error ="Must Fill This Field";
                          }
                          else{
                                  $get_user_data = "SELECT * FROM users WHERE username = '$session_username'";
                                    $get_user_run =mysqli_query($con,$get_user_data);
                                    $get_user_row =mysqli_fetch_array($get_user_run);
                              $date = time();
                              $first_name =$get_user_row['first_name'];
                              $last_name =$get_user_row['last_name'];
                              $full_name = "$first_name $last_name";
                              $email = $get_user_row['email'];
                              $image = $get_user_row['image'];
                              
                              $insert_comment_query = "INSERT INTO comments (`date`, `name`, `username`, `post_id`, `email`, `image`, `comment`, `status`) VALUES ('$date', '$full_name', '$session_username', '$reply_id', '$email', '$image', '$comment_data','Approve')";
                              if(mysqli_query($con,$insert_comment_query)){
                                  $comment_msg ="Comment Has Been Submitted";
                                  header('location: comments.php');
                              }
                              else{
                                  $comment_error ="Comment Has Not Been Submitted";
                              }
                              }
                      }
                  
                      
                      
              
              ?>
              <div class="row">
                  <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                      <form action="#" method="post">
                          <div class="form-group">
                          <label for="comments">Comments:*</label>
                              <?php
                              if(isset($comment_error)){
                                  echo "<span class='pull-right' style='color:red;'>$comment_error</span>";
                              }
                      else if(isset($comment_msg)){
                                  echo "<span class='pull-right' style='color:green;'>$comment_msg</span>";
                              }
                              ?>
                          <textarea name="comment" id="comment" placeholder="Your Comments Please Here" cols="30" rows="10" class="form-control"></textarea>
                          </div>
                          <input type="submit" name="reply" value="Reply" class="btn btn-primary">
                      </form>
                  </div>
              </div>
              <hr>
              
              
              
              <!--Reply Comments Box-->
              <?php
                      }
              }
              
              $query = "SELECT * FROM comments ORDER BY id DESC";
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
                      <option value="approve">Approve</option>
                      <option value="pending">Unapprove</option>
                      </select>
                      </div><!--col xs 4 close-->
                  <div class="col-xs-8">
                      <input type="submit" value="Apply" class="btn btn-success">
                      
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
                      <th>User Name</th>
                      <th>Comments</th>
                      <th>Status</th>
                      <th>Approve</th>
                      <th>Unapprove</th>
                      <th>Reply</th>
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
                          $post_id = $row['post_id'];
                          $username = $row['username'];
                          $comment = $row['comment'];
                          $status =$row['status'];
                          
                          
                           
                      
                      ?>
                  <tr>
                      <th><input type="checkbox" class="checkboxes" name="checkboxes[]" value="<?php echo $id?>"></th>
                      <td><?php echo $id;?></td>
                      <td><?php echo "$day $month $year";?></td>
                      <td><?php echo $username;?></td>  
                      <td><?php echo $comment;?></td>
                      <td><span style="color:<?php if($status == 'Approve'){echo 'green';} else if($status == 'Pending'){echo 'red';}?>;"><?php echo ucfirst($status);?></span></td>  
                      <td><a href="comments.php?approve=<?php echo $id;?>">Approve</a></td>
                      <td><a href="comments.php?unapprove=<?php echo $id;?>">Unapprove</a></td>
                      <td><a href="comments.php?reply=<?php echo $post_id;?>"><i class="fa fa-reply"></i></a></td>
                      <td><a href="comments.php?del=<?php echo $id?>"><i class="fa fa-times"></i></a></td>
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