<?php 
$session_role =$_SESSION['role'];
$session_name =$_SESSION['username'];
$session_image =$_SESSION['author_image'];

?>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Babar 786</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
          <li><a href="image/<?php echo $session_image; ?>">Welcome: 
<i class="fa fa-user" aria-hidden="true"></i> <?php echo ucfirst($session_name); ?> <img src="image/<?php echo $session_image; ?>"class="img-circle" width="15px"></a></li>
        <li><a href="add_post.php"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Post</a></li>
          
          <?php 
          
          if($session_role =='admin'){
          ?>
          <li><a href="add_users.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Add User</a></li>
          <?php }?>
          <li><a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i> Profile</a></li>
          
          <li><a href="logout.php"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
          