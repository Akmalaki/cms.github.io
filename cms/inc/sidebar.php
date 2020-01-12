 <div class="widgets">
     <form action="index.php" method="post">
        <div class="input-group">
      <input type="text" class="form-control" name="search-title" placeholder="Search for...">
      <span class="input-group-btn">
        <input type="submit" name="search" value="Go" class="btn btn-primary">
      </span>
    </div><!-- /input-group -->
         </form>
    </div><!--Widgets close Search Box-->
    
       <div class="widgets">
    <div class="popular">
    <h4>Popular post</h4>
        <?php
        $p_query ="SELECT * FROM posts WHERE status ='publish' ORDER BY views DESC LIMIT 5";
        $p_run= mysqli_query($con,$p_query);
        if(mysqli_num_rows($p_run) > 0){
            while($p_row=mysqli_fetch_array($p_run)){
                $p_id = $p_row['id'];
                $p_date = getdate($p_row['date']);
                $p_day = $p_date['mday'];
                $p_month = $p_date['month'];
                $p_year = $p_date['year'];
                $p_title = $p_row['title'];
                $p_image = $p_row['image'];
        
        ?>
    <hr>
    <div class="row">
    <div class="col-md-4">
        <a href="post.php?post_id=<?php echo $p_id?>"><img src="image/<?php echo $p_image;?>" alt="panel1" height="60px"></a>
    </div><!--Col 4-->
     <div class="col-md-8 details">
     <a href="post.php?post_id=<?php echo $p_id?>"><h4><?php echo $p_title;?></h4></a>
     <p><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo "$p_day $p_month $p_year";?></p>
     </div><!--Col 8-->
        </div><!--row close-->
        <?php
            }
        }
        else
        {
            echo "<>Posts Not Available</>";
        }
        ?>
       </div><!--popular div close-->
       </div><!--Widgets close popular post-->

       <div class="widgets">
    <div class="popular">
    <h4>Recent post</h4>
        <?php
        $r_query ="SELECT * FROM posts WHERE status ='publish' ORDER BY id DESC LIMIT 5";
        $r_run= mysqli_query($con,$r_query);
        if(mysqli_num_rows($r_run) > 0){
            while($r_row=mysqli_fetch_array($r_run)){
                $r_id = $r_row['id'];
                $r_date = getdate($r_row['date']);
                $r_day = $r_date['mday'];
                $r_month = $r_date['month'];
                $r_year = $r_date['year'];
                $r_title = $r_row['title'];
                $r_image = $r_row['image'];
        
        ?>
    <hr>
    <div class="row">
    <div class="col-md-4">
        <a href="post.php?post_id=<?php echo $r_id?>"><img src="image/<?php echo $r_image;?>" alt="panel1" height="60px"></a>
    </div><!--Col 4-->
     <div class="col-md-8 details">
     <a href="post.php?post_id=<?php echo $r_id?>"><h4><?php echo $r_title;?></h4></a>
     <p><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo "$r_day $r_month $r_year";?></p>
     </div><!--Col 8-->
        </div><!--row close-->
        <?php
            }
        }
        else
        {
            echo "<>Posts Not Available</>";
        }
        ?>
       </div><!--popular div close-->
       </div><!--Widgets close Recent post-->

          <div class="widgets">
    <div class="popular">
    <h4>Categories</h4>
    <hr>
     <div class="row">
        <div class="col-xs-6">
            <ul>
                 <?php
              
              $c_query = "SELECT * FROM categories";
              $c_run = mysqli_query($con,$c_query);
              if(mysqli_num_rows($c_run) > 0){
                   $count = 2;
                  while($c_row = mysqli_fetch_array($c_run)){
                      $c_category = ucfirst($c_row['category']);
                      $c_id = $c_row['id'];
                      $count = $count + 1;
                      if(($count % 2) == 1){
                        echo "<li><a href='index.php?cat=".$c_id."'>$c_category</a></li>";

                      }
                  }
                      
              }
              else 
                       echo "<li><a href='#'>No Category</a></li>";
              
              ?>
            </ul>
        </div><!--Col xs 6 close-->
        <div class="col-xs-6">
            <ul>
               <?php
              
              $c_query = "SELECT * FROM categories";
              $c_run = mysqli_query($con,$c_query);
              if(mysqli_num_rows($c_run) > 0){
                   $count = 2;
                  while($c_row = mysqli_fetch_array($c_run)){
                      $c_category = ucfirst($c_row['category']);
                      $c_id = $c_row['id'];
                      $count = $count + 1;
                      if(($count % 2) == 0){
                        echo "<li><a href='index.php?cat=".$c_id."'>$c_category</a></li>";

                      }
                  }
                      
              }
              else 
                       echo "<li><a href='#'>No Category</a></li>";
              
              ?>
            </ul>
        </div><!--Col xs 6 close-->

    </div><!--Row close-->
    
       </div><!--Popular close-->
       </div><!--Widgets close category-->
            <div class="widgets">
    <div class="categories">
    <h4>Social Icons</h4>
    <hr>
     <div class="row">
         <div class="col-xs-4"><a href="http://www.facebook.com"><img src="image/fb.png" alt="fb"></a></div>
        <div class="col-xs-4"><a href="http://www.twitter.com"><img src="image/Twitter.png" alt="Twitter"></a></div>
        <div class="col-xs-4"><a href="http://www.google.com"><img src="image/Googleplus.png" alt="Googleplus"></a></div>
           
    </div><!--Row close-->
         <hr>
     <div class="row">
         <div class="col-xs-4"><a href="http://www.linkdink.com"><img src="image/linkdink.jpg" alt="Linkdink"></a></div>
        <div class="col-xs-4"><a href="http://www.skype.com"><img src="image/Skype.png" alt="Skype"></a></div>
        <div class="col-xs-4"><a href="http://www.youtube.com"><img src="image/youtube.png" alt="youtube"></a></div>
           
    </div><!--Row close-->
    
       </div><!--Categories close-->
       </div><!--Widgets close social icon-->
       