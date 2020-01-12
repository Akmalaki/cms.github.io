<?php
/*Login */
ob_start();
session_start();
require_once('../inc/db.php');

if(isset($_POST['submit']))
{
    $username = mysqli_real_escape_string($con,strtolower($_POST['username']));
    $password = mysqli_real_escape_string($con,$_POST['password']);
    
    $check_username_query ="SELECT * FROM users WHERE username='$username'";
    $check_username_run = mysqli_query($con,$check_username_query);
    if(mysqli_num_rows($check_username_run)>0){
        $row = mysqli_fetch_array($check_username_run);
        $db_username = $row['username'];
        $db_author_image = $row['image'];
        $db_password = $row['password'];
        
        
        $password =crypt($password,$db_password);
        $db_role = $row['role'];
         
        if($username == $db_username && $password == $db_password){
            header('Location: index.php');
            $_SESSION['username'] = $db_username;
            $_SESSION['author_image'] = $db_author_image;
            $_SESSION['role'] = $db_role;
            
        }
        else 
    {
        $error ="Wrong Username & Password";
    }
    }
    else 
    {
        $error ="Wrong Username & Password";
    }
}

/*Login */
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="image/Icon.png">
    <link rel="canonical" href="https://getbootstrap.com/docs/3.4/examples/signin/">

    <title>Login | Babar 786</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="css/Animated.css" rel="stylesheet">

       <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form class="form-signin animated shake" action="#" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Username</label>
        <input type="text" id="inputEmail" name="username" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
              <?php 
              if(isset($error)){
                  echo $error;
              }
              ?>
<!--            <input type="checkbox" value="remember-me"> Remember me-->
          </label>
        </div>
        <input type="submit" name="submit" value="Sign In" class="btn btn-lg btn-primary btn-block">
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
