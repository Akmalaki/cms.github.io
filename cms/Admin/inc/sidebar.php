<?php

$session_role =$_SESSION['role'];
/*For Comments*/
$get_comment ="SELECT * FROM comments WHERE status ='pending'";
$get_comment_run =mysqli_query($con,$get_comment);
$get_row =mysqli_num_rows($get_comment_run);
/*For Comments*/

/*For All Posts*/
$get_all_posts ="SELECT * FROM posts WHERE status='draft'";
$get_all_posts_run =mysqli_query($con,$get_all_posts);
$get_post_rows =mysqli_num_rows($get_all_posts_run);
/*For All Posts*/
?>
<div class="list-group">
  <a href="index.php" class="list-group-item active">
    <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
  </a>
  <a href="posts.php" class="list-group-item"><?php if($get_post_rows > 0){ echo "<span class='badge'>$get_post_rows</span>";}?><i class="fa fa-file-text" aria-hidden="true"></i> All Posts</a>
  <a href="media.php" class="list-group-item"><i class="fa fa-database" aria-hidden="true"></i> Media</a>
    <?php
    
    if($session_role == 'admin'){
    
    ?>
  <a href="comments.php" class="list-group-item"><?php if($get_row > 0){ echo "<span class='badge'>$get_row</span>";}?><i class="fa fa-comment" aria-hidden="true"></i> Comments</a>
  <a href="categories.php" class="list-group-item"><i class="fa fa-folder-open" aria-hidden="true"></i> Categories</a>
  <a href="users.php" class="list-group-item"><i class="fa fa-users" aria-hidden="true"></i> Users</a>
    <?php
    }
    ?>
    

      
      </div>
              