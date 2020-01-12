<?php   require_once('inc/top.php'); ?>
  </head>
  <body>
       <?php require_once('inc/header.php');?>
   
    <?php
      
      //pagination start
      
      if(isset($_GET['page'])){
          $page_id = $_GET['page'];
      }
      else
      {
          $page_id = 1;
      }
      
      //Fetch data Category wise//
      if(isset($_GET['cat'])){
          $cat_id = $_GET['cat'];
          $cat_query = "SELECT * FROM categories WHERE id ='$cat_id'";
          $cat_run = mysqli_query($con,$cat_query);
          $cat_row =mysqli_fetch_array($cat_run);
          $cat_name = $cat_row['category'];
        
      }
      //Fetch data Category wise//
      $num_of_posts = 3;
      
     if(isset($_POST['search'])){
         $search = $_POST['search-title'];
         $all_posts_query = "SELECT * FROM posts WHERE status = 'publish'";
         $all_posts_query .=" and tags LIKE '%$search%'";
         $all_posts_run = mysqli_query($con,$all_posts_query);
         $all_posts = mysqli_num_rows($all_posts_run);
         $total_pages = ceil($all_posts / $num_of_posts);
         $post_start_from = ($page_id - 1) * $num_of_posts;
     }
      else
      {
           $all_posts_query = "SELECT * FROM posts WHERE status = 'publish'";
           if(isset ($cat_name)){
          
           $all_posts_query .="and category ='$cat_name'";
      }
          $all_posts_run = mysqli_query($con,$all_posts_query);
          $all_posts = mysqli_num_rows($all_posts_run);
          $total_pages = ceil($all_posts / $num_of_posts);
          $post_start_from = ($page_id - 1) * $num_of_posts;
      }
      
      
      //pagination end
      ?>  
      
      
        <!-- Jumbotron start-->
        <div class="jumbotron">
            <div class="container">
                <div id="details" class="animated fadeInLeft">
                    <h1>Web CMS<span> Blog</span></h1>
                    <p>This is an Online Web Control Management System</p>
                </div>
             
        </div>
        <img src="image/Jumbotrantop.jpg" alt="Top Image">
        </div><!-- /Jumbotron Close-->
        
        <!--Section start-->
        <section>
        <div class="container">
        <div class="row"><!--Section row-->
        <div class="col-md-8">
            <?php
            // Slider start
            $slider_query ="SELECT * FROM posts WHERE status='publish' ORDER BY id DESC LIMIT 3";
            $slider_run = mysqli_query($con,$slider_query);
            if(mysqli_num_rows($slider_run) > 0){
                $count = mysqli_num_rows($slider_run);
                    
            ?>
            
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
      <?php
      for($i = 0; $i < $count; $i++){
          if($i == 0){
              echo "<li data-target='#carousel-example-generic' data-slide-to='".$i."' class='active'></li>";
          }
          else
          {
              echo "<li data-target='#carousel-example-generic' data-slide-to='".$i."'></li>";
          }
      }
      ?>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
      <?php
       $check = 0;        
      while($slider_row = mysqli_fetch_array($slider_run)){
          $check = $check + 1;
          $slider_id = $slider_row['id'];
          $slider_title = $slider_row['title'];
          $slider_image = $slider_row['image'];
          if($check == 1){
              
              echo "<div class='item active'>";
          }
          else
          {
              echo "<div class='item'>";
          }
      
      ?>
      <a href="post.php?post_id=<?php echo $slider_id;?>"><img src="image/<?php echo $slider_image;?>"  style="height: 400px; width: 100%;"></a>
      <div class="carousel-caption">
        <h2><?php echo $slider_title;?></h2>
      </div>
    </div>
        
      <?php 
      // Slider end
      }?>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>  
            <?php
                    
            }
            
            if(isset($_POST['search'])){
            $search = $_POST['search-title'];
            $query = "SELECT * FROM posts WHERE status ='publish'";
            $query .= "and tags LIKE '%$search%'";
            $query .="ORDER BY id DESC LIMIT $post_start_from,$num_of_posts";

            }
            else
            {
                $query = "SELECT * FROM posts WHERE status ='publish'";
            if(isset ($cat_name)){
                $query .= "and category ='$cat_name'";
            }
            $query .="ORDER BY id DESC LIMIT $post_start_from,$num_of_posts";

            }
            
            $run = mysqli_query($con,$query);
            if(mysqli_num_rows($run) > 0){
                while($row =mysqli_fetch_array($run)){
                    $id = $row['id'];
                    $date = getdate($row['date']);
                    $day = $date['mday'];
                    $month = $date['month'];
                    $year = $date['year'];
                    $title = $row['title'];
                    $author = $row['author'];
                    $author_image = $row['author_image'];
                    $image = $row['image'];
                    $category = $row['category'];
                    $tags = $row['tags'];
                    $post_data = $row['post_data'];
                    $views = $row['views'];
                    $status = $row['status'];
             
            
            ?>
            <div class="post">
                
            <div class="row">
                <div class="col-md-2 post-date" >
                <div class="day"><?php echo $day?></div>
                    <div class="month"><?php echo $month?></div>
                    <div class="year"><?php echo $year?></div>
                </div><!--poost col 2 close-->
                <div class="col-md-8 post-title" >
                <a href="post.php?post_id=<?php echo $id?>"><h2><?php echo ucfirst($title);?><Urdu></Urdu></h2></a>
                    <p>Written by :<span><?php echo ucfirst($author);?></span></p>
                </div><!--poost col 8 close-->
                <div class="col-md-2 profile-picture">
                    <img src="image/<?php echo $author_image;?>" alt="post-pic" class="img-circle">
                </div><!--poost col 2 close-->
                </div><!--post row close-->
                <a href="post.php?post_id=<?php echo $id?>">
                    <img src="image/<?php echo $image;?>" alt="panel3"></a>
                 <div class="desc"><?php echo substr($post_data,0,300)."....";?>
                </div>
           <a href="post.php?post_id=<?php echo $id?>" class="btn btn-primary">Read More...</a>
           <div class="bottom">
     <span class="first"><i class="fa fa-folder" aria-hidden="true"></i><a href="#"> <?php echo ucfirst($category);?></a></span>|
     <span class="second"><i class="fa fa-comment" aria-hidden="true"></i><a href="#"> Comment</a></span>
           </div><!bottm close-->
            </div><!--post close-->
            <?php
            
                       }//close while loop-->
            }//close if-->
            else{
                echo "<center><h2>Post Not Available</h2></center>";
            }
            ?>
            
            <!--nav Pagination start-->
            <nav id="pagination">
                  <ul class="pagination">
                    <li>
                      <a href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>
                   <?php
                      
                      for($i = 1;$i <= $total_pages; $i++){
                          echo "<li class='".($page_id == $i ? 'active':'')."'><a href='index.php?page=".$i."&".(isset($cat_name )?"cat=$cat_id":"")."'>$i</a></li>";
                      }
                      
                      ?>
                    <li>
                      <a href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                  </ul>
                </nav><!--nav Pagination close-->
        
        </div><!--Col 8 close-->
        <div class="col-md-4"><!--Col 4 start-->
        <?php require_once('inc/sidebar.php');?>
       </div><!--Col 4 close-->
       </div><!--Row close-->
       </div><!--container close-->
        </section>
        
        <!section close-->
        
        <!--Footer-->
      <?php require_once('inc/footer.php');?>
        <!-- Footer close-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/npm.js"></script>
  </body>
</html>