<?php require_once('inc/top.php');

ob_start();
session_start();
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}
/*Select Prifle Data*/

$session_username = $_SESSION['username'];

$profile_query = "SELECT * FROM users WHERE username = '$session_username'";
$query_run = mysqli_query($con,$profile_query);
$row = mysqli_fetch_array($query_run);
$image = $row['image'];
$id = $row['id'];
$date = getdate ($row['date']);
$day = $date['mday'];
$month = substr($date['month'],0,3);
$year = $date['year'];
$first_name = $row['first_name'];
$last_name = $row['last_name'];
$username = $row['username'];
$email = $row['email'];
$role = $row['role'];
$details = $row['details'];

/*Select Prifle Data*/
?>
</head>
  <body id="profile">
      <div id="wrapper">
      <?php require_once('inc/header.php');?>
      <div class="container-fluid body-section">
      <div class="row">
          <div class="col-md-3">
          <?php require_once('inc/sidebar.php');?>

          </div><!--Close col-md 3-->
          <div class="col-md-9">
          <h1><i class="fa fa-user" aria-hidden="true"></i> Profile <small>Personal Details</small></h1><hr>
              <ol class="breadcrumb">
                  <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                  <li class="active"><i class="fa fa-user" aria-hidden="true"></i> Profile</li>
              </ol>
              
              <div class="row">
                  <div class="col-xs-12">
                      <center><img src="image/<?php echo $image;?>" alt="" width="200px"  class="img-circle img-thumbnail" id="profile-image"></center><br>
                      <a href="edit_profile.php?edit=<?php echo $id?>" class="btn btn-primary pull-right">Edit Profile</a><br><br>
                      <center><h3>Profile Details</h3></center><br>
                      <table class="table table-bordered">
                          <tr>
                          <td width="20%"><b>User Id</b></td>
                          <td width="30%"><?php echo $id;?></td>
                          <td width="20%"><b>Sign Up Date:</b></td>
                          <td width="30%"><?php echo "$day $month $year";?></td>
                          </tr>
                          <tr>
                          <td width="20%"><b>First Name</b></td>
                          <td width="30%"><?php echo $first_name;?></td>
                          <td width="20%"><b>Last Name</b></td>
                          <td width="30%"><?php echo $last_name;?></td>
                          </tr>
                          <tr>
                          <td width="20%"><b>User Name</b></td>
                          <td width="30%"><?php echo $username;?></td>
                          <td width="20%"><b>Email</b></td>
                          <td width="30%"><?php echo $email;?></td>
                          </tr>
                          <tr>
                          <td width="20%"><b>Role</b></td>
                          <td width="30%"><?php echo $role;?></td>
                          <td width="20%"><b></b></td>
                          <td width="30%"></td>
                          </tr>
                      </table>
                      <div class="row">
                          <div class="col-lg-8 col-xs-12">
                            <b>Details:</b>
                              <div><?php echo $details;?></div><br>
                          </div>
                      </div>
                  </div>
              </div>
              
          </div><!--Close col-md 9-->
          
          </div><!--Row Close-->
          
      </div><!--container Close-->
      <?php require_once('inc/footer.php');?>