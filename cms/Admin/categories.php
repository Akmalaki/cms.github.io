      <?php require_once('inc/top.php');
ob_start();
session_start();
if(!isset($_SESSION['username'])){
    header('Location: login.php');
    
                                 }
else if(isset($_SESSION['username']) && $_SESSION['role'] =='author'){
            header('Location: index.php');
}

/*Update Category*/

if(isset($_GET['edit']))
{
    $edit_id =$_GET['edit'];
}
if(isset($_POST['update'])){
    $cat_name = mysqli_real_escape_string($con,ucfirst($_POST['cat_name']));
   if(empty($cat_name)){
       $up_error = "Must Fill This Field";
   }
    else
    {
         $check_query = "SELECT * FROM categories WHERE category ='$cat_name'";
            $query_run = mysqli_query($con,$check_query);
            if(mysqli_num_rows($query_run)>0){

                $up_error = "Category Name Alredy Exist";
                                             }
            else
            {
                $update_query ="UPDATE `categories` SET `category` = '$cat_name' WHERE `categories`.`id` = $edit_id;";
                if(mysqli_query($con,$update_query)){
                $up_msg = "Category Name Has Been Updated Successfully";
                                                    }
                else
                {
                    $error = "Category Name Has Not Been Updated";
                }
            }
            
    }
                           }



/*Update Category*/

/*Delete Category*/

if(isset($_GET['del']))
{
    $del_id=$_GET['del'];
    
    if(isset($_SESSION['username']) and $_SESSION['role'] =='admin')
    {
        $del_query ="DELETE FROM `categories` WHERE `categories`.`id` = $del_id ";
        if(mysqli_query($con,$del_query)){
        $del_msg = "Category Has Bee  Deleted";
    }
    
    else
    {
        $del_error = "Category Not Deleted";
    }
    }
    
}

/*Delete Category*/


     /*Insert & Select category query*/
     
if(isset($_POST['Submit'])){
    $cat_name = mysqli_real_escape_string($con,ucfirst($_POST['cat_name']));
   if(empty($cat_name)){
       $error = "Must Fill This Field";
   }
    else
    {
         $check_query = "SELECT * FROM categories WHERE category ='$cat_name'";
            $query_run = mysqli_query($con,$check_query);
            if(mysqli_num_rows($query_run)>0){

                $error = "Category Name Alredy Exist";
                                             }
            else
            {
                $insert_query ="INSERT INTO categories (category) VALUES ('$cat_name')";
                if(mysqli_query($con,$insert_query)){
                    $msg = "Category Name Has Been Added Successfully";



                                                    }
                else
                {
                    $error = "Category Name Has Not Been Added";
                }
            }
            
    }
                           }

    /*Insert & Select category query*/
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
          <h1><i class="fa fa-folder-open" aria-hidden="true"></i> Categories <small>Different Categories</small></h1><hr>
              <ol class="breadcrumb">
                  <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a></li>
                  <li class="active"><i class="fa fa-folder-open" aria-hidden="true"></i>Categories</li>
              </ol>
              <div class="row">
              <div class="col-md-6">
                  <form action="" method="post">
                  <div class="form-group">
                      <label for="category">Category</label>
                      <?php 
                      if(isset($msg)){ echo "<span class='pull-right' style ='color:Green;'>$msg</span>"; }
                      
                      else if(isset($error)){echo "<span class='pull-right' style ='color:red;'>$error</span>";}
                      ?>
                      <input type="text" placeholder="Category Name" name="cat_name" class="form-control">
                      </div>
                      <input type="submit" name="Submit" value="Submit" class="btn btn-primary">
                  </form>
                  <?php
                  /*update Category*/
                  if(isset($_GET['edit'])){
                      
                      $edit_check_query ="SELECT * FROM categories WHERE id = $edit_id";
                      $edit_query_run = mysqli_query($con,$edit_check_query);
                      if(mysqli_num_rows($edit_query_run) > 0){
                          
                      $edit_row = mysqli_fetch_array($edit_query_run);
                          $up_category = $edit_row['category'] ;
                  /*update Category*/
                  ?>
                  <hr>
                   <form action="" method="post">
                  <div class="form-group">
                      <label for="category">Update Category</label>
                      <?php 
                      if(isset($up_msg)){ echo "<span class='pull-right' style ='color:Green;'>$up_msg</span>"; }
                      
                      else if(isset($up_error)){echo "<span class='pull-right' style ='color:red;'>$up_error</span>";}
                      ?>
                      <input type="text" value="<?php echo $up_category;?>" placeholder="Category Name" name="cat_name" class="form-control">
                      </div>
                      <input type="submit" name="update" value="Update Category" class="btn btn-primary">
                  </form>
                  <?php } }?>
                  </div><!--Div close col 6-->
              <div class="col-md-6">
                  <!--Select Category Data By row-->
                          <?php
                          
                          $get_query ="SELECT * From categories ORDER BY id DESC LIMIT 10";
                  $get_query_run =mysqli_query($con,$get_query);
                  if(mysqli_num_rows($get_query_run)>0){
                          
                          ?>
                  <?php 
                  if(isset($del_msg)){echo  "<span class='pull-right' style='color:green;'>$del_msg</span>";}
                      
                  else if(isset($del_error)){echo  "<span class='pull-right' style='color:red;'>$del_error</span>";};
                  ?>
                  <table class="table table-hover table-striped table-bordered">
                  <thead>
                      <tr>
                          <th>Sr #</th>
                          <th>Category Name</th>
                          <th>Posts</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </tr>
                      </thead>
                      <tbody>
                          <?php
                          while($get_row=mysqli_fetch_array($get_query_run))
                      {
                  
                              $category_id =$get_row['id'];
                              $category_name =$get_row['category'];
                          
                          ?>
                      <tr>
                          <td><?php echo $category_id;?></td>
                          <td><?php echo $category_name;?></td>
                          <td>12</td>
                          <td><a href="categories.php?edit=<?php echo $category_id;?>"><i class="fa fa-pencil"></i></a></td>
                          <td><a href="categories.php?del=<?php echo $category_id;?>"><i class="fa fa-times"></i></a></td>
                      </tr><!-- tr 1 close-->
                          <?php }?>
                          <!--Select Category Data By row-->
                      </tbody>
                  </table>
                  <?php 
                  }
                  else
                      {
                          echo "<center><h3>No Catagory Found</h3></center>";

                      }
                  
                  ?>
                  </div><!--Div close col 6-->      
              </div>
          </div><!--Close col-md 9-->
          
          </div><!--Row Close-->
          
      </div>
           <?php require_once('inc/footer.php');?>