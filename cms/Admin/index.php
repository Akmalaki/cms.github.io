<?php require_once('inc/top.php');

ob_start();
session_start();
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}

/*Quries for All tag Boxes start*/

$comment_tag_query ="SELECT * FROM comments WHERE status ='pending'";
$posts_tag_query ="SELECT * FROM posts";
$users_tag_query ="SELECT * FROM users";
$category_tag_query ="SELECT * FROM categories";

$com_run = mysqli_query($con,$comment_tag_query);
$posts_run = mysqli_query($con,$posts_tag_query);
$users_run = mysqli_query($con,$users_tag_query);
$cat_run = mysqli_query($con,$category_tag_query);

$get_com_row = mysqli_num_rows($com_run);
$get_posts_row = mysqli_num_rows($posts_run);
$get_users_row = mysqli_num_rows($users_run);
$get_cat_row = mysqli_num_rows($cat_run);

/*Quries for All tag Boxes End*/

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
          <h1><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard <small>Statistics Overview</small></h1><hr>
              <ol class="breadcrumb">
                  <li class="active"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</li>
              </ol>
              <div class="row tag-boxes">
                  <div class="col-md-6 col-lg-3">
              <div class="panel panel-primary">
              <div class="panel-heading">
                  <div class="row">
                  <div class="col-xs-3">
                      <i class="fa fa-comment fa-5x"></i>
                      </div>
                  <div class="col-xs-9">
                      <div class="text-right huge"><?php echo $get_com_row;?></div>
                      <div class="text-right">Comments</div>
                      </div>
                  </div>
                  </div>
                  <a href="comments.php">
                  <div class="panel-footer">
                      <div class="pull-left">View All Comments</div>
                      <div class="pull-right"><i class="fa fa-arrow-circle-right"></i></div>
                      <div class="clearfix"></div>
                      </div>
                  </a>
              </div>
</div><!--fIRST BOX pANLE CLOSE-->
                  <div class="col-md-6 col-lg-3">
              <div class="panel panel-red">
              <div class="panel-heading">
                  <div class="row">
                  <div class="col-xs-3">
                      <i class="fa fa-file-text fa-5x"></i>
                      </div>
                  <div class="col-xs-9">
                      <div class="text-right huge"><?php echo $get_posts_row;?></div>
                      <div class="text-right">Post</div>
                      </div>
                  </div>
                  </div>
                  <a href="posts.php">
                  <div class="panel-footer">
                      <div class="pull-left">View All Posts</div>
                      <div class="pull-right"><i class="fa fa-arrow-circle-right"></i></div>
                      <div class="clearfix"></div>
                      </div>
                  </a>
              </div>
 </div><!--SECOND BOX PANLE CLOSE-->
                  <div class="col-md-6 col-lg-3">
              <div class="panel panel-yellow">
              <div class="panel-heading">
                  <div class="row">
                  <div class="col-xs-3">
                      <i class="fa fa-users fa-5x"></i>
                      </div>
                  <div class="col-xs-9">
                      <div class="text-right huge"><?php echo $get_users_row;?></div>
                      <div class="text-right">Users</div>
                      </div>
                  </div>
                  </div>
                  <a href="users.php">
                  <div class="panel-footer">
                      <div class="pull-left">View All Users</div>
                      <div class="pull-right"><i class="fa fa-arrow-circle-right"></i></div>
                      <div class="clearfix"></div>
                      </div>
                  </a>
              </div>
 </div><!--third BOX pANLE CLOSE-->
                  <div class="col-md-6 col-lg-3">
              <div class="panel panel-green">
              <div class="panel-heading">
                  <div class="row">
                  <div class="col-xs-3">
                      <i class="fa fa-folder-open fa-5x"></i>
                      </div>
                  <div class="col-xs-9">
                      <div class="text-right huge"><?php echo $get_cat_row;?></div>
                      <div class="text-right">Categores</div>
                      </div>
                  </div>
                  </div>
                  <a href="categories.php">
                  <div class="panel-footer">
                      <div class="pull-left">View All Categories</div>
                      <div class="pull-right"><i class="fa fa-arrow-circle-right"></i></div>
                      <div class="clearfix"></div>
                      </div>
                  </a>
              </div>
              </div><!--fourth BOX pANLE CLOSE-->
          </div><hr>
              <!-- Start Table New Users-->
              
              
              <?php 
              
              /*All users Select query start*/
              
              $users_query ="SELECT * FROM users ORDER BY id DESC Limit 5";
              $users_query_run = mysqli_query($con,$users_query);
              if(mysqli_num_rows($users_query_run) > 0){
                  
              ?>
              <h3>New Users</h3>
              <table class="table table-hover table-bordered table-striped">
              <thead>
                  <tr>
                      <th>Sr #</th>
                      <th>Date</th>
                      <th>Name</th>
                      <th>User Name</th>
                      <th>Role</th>
                  </tr>
                  </thead>
                  <tbody>
              <?php 
                      
                  while($users_get_row = mysqli_fetch_array($users_query_run)){
                          
                          $users_id = $users_get_row['id'];
                          $users_date = getdate($users_get_row['date']);
                          $users_day = $users_date['mday'];
                          $users_month = substr($users_date['month'],0,3);
                          $users_year = $users_date['year'];
                          $users_first_name = ucfirst($users_get_row['first_name']);
                          $users_last_name = ucfirst($users_get_row['last_name']);
                          $users_fullname = "$users_first_name $users_last_name";
                          $users_username = $users_get_row['username'];
                          $users_role = ucfirst($users_get_row['role']);
                  
                      ?>
                  <tr>
                      <td><?php echo $users_id;?></td>
                      <td><?php echo "$users_day $users_month $users_year";?></td>
                      <td><?php echo $users_fullname;?></td>
                      <td><?php echo $users_username;?></td>
                      <td><?php echo $users_role;?></td>
                  </tr><!--tr 1 row close-->
                      <?php }?>
                      
                  </tbody>
              </table><!-- close Table New Users-->
              <?php }?>
              
              
              
              <?php
              
              /*Select All posts Query start*/
              
              $post_query ="SELECT * FROM posts ORDER BY id DESC Limit 5";
              $post_query_run = mysqli_query($con,$post_query);
              if(mysqli_num_rows($post_query_run) > 0){
              ?>
              <a href="users.php" class="btn btn-primary">View All Users</a><hr>
              <!--New post Table Start-->
              <h3>New Posts</h3>
              <table class="table table-hover table-striped table-bordered">
              <thead>
                  <tr>
                      <th>Sr #</th>
                      <th>Date</th>
                      <th>Post Title</th>
                      <th>Category</th>
                      <th>View</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php 
                      while($post_get_row = mysqli_fetch_array($post_query_run)){
                      
                          $post_id = $post_get_row['id'];
                          $post_date = getdate($post_get_row['date']);
                          $post_day = $post_date['mday'];
                          $post_month = substr($post_date['month'],0,3);
                          $post_year = $post_date['year'];
                          $post_title = $post_get_row['title'];
                          $post_category = $post_get_row['category'];
                          $post_views = $post_get_row['views'];
                          
                      ?>
                      <tr>
                          <td><?php echo $post_id;?></td>
                          <td><?php echo "$post_day $post_month $post_year";?></td>
                          <td><?php echo $post_title;?></td>
                          <td><?php echo $post_category;?></td>
                          <td><i class="fa fa-eye" aria-hidden="true"></i><?php echo $post_views;?></td>
                      </tr><!--tr row 1 close-->
                      <?php }?>
                  </tbody>
              </table><!--New post Table close-->
              <a href="posts.php" class="btn btn-primary">View All Posts</a>
              <?php }?>
              
          </div><!--Close col-md 9-->
          
          </div><!--Row Close-->
          
      </div>
      <?php require_once('inc/footer.php');?>