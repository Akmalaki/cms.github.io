<?php   require_once('inc/top.php'); ?>
<?php require_once('inc/header.php');?>  
<?php
// fetch data for post page//


if(isset($_GET['post_id'])){
    $post_id =$_GET['post_id'];
    $views_query ="UPDATE `posts` SET `views` = views + 1 WHERE `posts`.`id` = $post_id";
    mysqli_query($con, $views_query);

    $query = "SELECT * FROM posts WHERE status ='publish' and id ='$post_id'";
    $run = mysqli_query($con,$query);
    if(mysqli_num_rows($run) > 0){
        $row = mysqli_fetch_array($run);
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
        $post_data = $row['post_data'];
    }

    else
{
    header('Location: index.php');
}

}

?>
  </head>
  <body>
   
   
      <!-- Jumbotron start-->
        <div class="jumbotron">
            <div class="container">
                <div id="details" class="animated fadeInLeft">
                    <h1>Custom<span> Post</span></h1>
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
            <div class="post">
            <div class="row">
                <div class="col-md-2 post-date" >
                <div class="day"><?Php echo $day; ?></div>
                    <div class="month"><?Php echo $month; ?></div>
                    <div class="year"><?Php echo $year; ?></div>
                </div><!--poost col 2 close-->
                <div class="col-md-8 post-title" >
                <a href="post.php?post_id=<?php echo $id; ?>"><h2><?Php echo ucfirst($title); ?><Urdu></Urdu></h2></a>
                    <p>Written by :<span><?Php echo ucfirst($author);?></span></p>
                </div><!--poost col 8 close-->
                <div class="col-md-2 profile-picture"><img src="image/<?Php echo $author_image; ?>" alt="post-pic" class="img-circle">
                </div><!--poost col 2 close-->
                </div><!--post row close-->
                <a href="image/<?Php echo $image; ?>"><img src="image/<?Php echo $image; ?>" alt="panel3"></a>
                 <div class="desc"><?php echo $post_data; ?></div>
<br><br>

           
           <div class="bottom">
     <span class="first"><i class="fa fa-folder" aria-hidden="true"></i><a href="#"> <?Php echo ucfirst($category);?></a></span>|
     <span class="second"><i class="fa fa-comment" aria-hidden="true"></i><a href="#">Comment</a></span>
           </div><!--bottm close-->
            </div><!--post close-->
            <!--Related post start-->
            <div class="related-post">
                <h3>Related Posts</h3><hr>
                <!--Related post row start-->
                <div class="row">
                    <?php
                    $r_query ="SELECT * FROM posts WHERE status='publish' and title LIKE '%$title%'";
                    $r_run = mysqli_query($con,$r_query);
                    while($r_row =mysqli_fetch_array($r_run)){
                        $r_id = $r_row['id'];
                        $r_title = $r_row['title'];
                        $r_image = $r_row['image'];
                    
                    ?>
                    <div class="col-sm-4">
                        <a href="post.php?post_id=<?php echo $r_id;?>"><img src="image/<?php echo $r_image;?>" alt="panel2" height="150px;">
                            <h4><?php echo $r_title;?></h4>
                        </a>
                    </div>
                    <?php }?>
                </div><!--Related post row close-->
            </div><!--Related post close-->
            <!--Author start-->
            <div class="author">
                <!--Author row start-->
                <div class="row">
                <div class="col-sm-3">
                    <img src="image/<?php echo $author_image;?>" alt="postpic image" class="img-circle">
                    </div>
                    <div class="col-sm-9"></div>
                    <h4><?php echo ucfirst($author);?></h4>
                    <?php
                    
                    $bio_query ="SELECT * FROM users WHERE username = '$author'";
                    $bio_query_run =mysqli_query($con,$bio_query);
                    if(mysqli_num_rows($bio_query_run) > 0)
                    {
                        $bio_row = mysqli_fetch_array($bio_query_run);
                        $details =$bio_row['details'];
                    
                    
                    ?>
                    <p><?php echo $details;?></p>
                    <?php 
                        }
                    ?>
                </div><!--Author row close-->
            </div><!--Author close-->
            <!--Comments start-->
             
                <?php
                $c_query = "SELECT * from comments WHERE status ='approve' and post_id = $post_id ORDER BY id DESC LIMIT 5";
                $c_run = mysqli_query($con,$c_query);
                if(mysqli_num_rows($c_run) > 0){
                ?>
            <div class="comments">
                <h3>Comments</h3><hr>
                <!--Comments row start-->
                <?php 
                while($c_row =mysqli_fetch_array($c_run)){
                    $c_id =$c_row['id'];
                    $c_image =$c_row['image'];
                    $c_name =$c_row['name'];
                    $c_comment =$c_row['comment'];
                
                ?>
            <div class="row">
                <div class="col-sm-2">
                <img src="image/<?php echo $c_image; ?>" alt="unknown image" class="img-circle">
                </div>
                <div class="col-sm-10">
                <h4><?php echo $c_name; ?></h4>
                    <p><?php echo $c_comment; ?>.<br></p>
                </div>
                </div> <!--Comments row close-->
                <?php } ?>
            </div> <!--Comments close-->
            <?php }?>
            
            
            <!--comment-box start-->
            <?php
            
            if(isset($_POST['submit'])){
                $cs_name =$_POST['name'];
                $cs_email =$_POST['email'];
                $cs_website =$_POST['website'];
                $cs_comment =$_POST['comment'];
                $cs_date =time();
                if(empty($cs_name)or empty($cs_email) or empty($cs_name) or empty($cs_comment)){
                    
                    $error_msg = "All (*) Feilds are Required";
                }
                else
                {
                    $cs_query ="INSERT INTO `comments` (`id`, `date`, `name`, `username`, `post_id`, `email`, `website`, `image`, `comment`, `status`) VALUES (NULL, '$cs_date', '$cs_name', '$cs_name', '$post_id', '$cs_email', '$cs_website', 'com_boy3.jpg', '$cs_comment', 'pending');";
                    if(mysqli_query($con,$cs_query)){
                        
                            $cs_name ="";
                            $cs_email ="";
                            $cs_website ="";
                            $cs_comment ="";

                    
                    $msg = "Comment has Been Submited Succesfully and Waiting for Approval. Thanks";
                }
                else
                {
                    $error_msg ="Comment has not Been submited";
                }

                }
                
                }
            ?>
            <div class="comment-box">
                <!--comment-box row start-->
            <div class="row">
                <div class="col-xs-12">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="full-name">Full Name*:</label>
                        <input type="text" id="full-name" value="<?php if(isset($cs_name)){echo $cs_name;} ?>" name="name" class="form-control" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email*:</label>
                        <input type="text" id="email" value="<?php if(isset($cs_email)){echo $cs_email;} ?>" name="email" class="form-control" placeholder="Email Adress">
                    </div>
                    <div class="form-group">
                        <label for="website">Website:</label>
                        <input type="text" id="website" value="<?php if(isset($cs_website)){echo $cs_website;} ?>" name="website" class="form-control" placeholder="Website">
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment:</label>
                <textarea id="comment" cols="30" rows="10" name="comment" class="form-control" placeholder="Your comment Should be Here"><?php if(isset($cs_comment)){echo $cs_comment;} ?></textarea>
                    </div>
                    <input type="submit" name="submit" value="Submit Comment" class="btn btn-primary">
                    <?php 
                    if(isset($error_msg)){
                        echo "<span style='color:red;' class='pull-right'>$error_msg</span>";
                    }                    
                    else if(isset($msg)){
                    
                        echo "<span style='color:green;' class='pull-right'>$msg</span>";
                    }
                    
                    ?>
                    </form>
                </div>
                </div><!--comment-box row close-->
            </div><!--comment-box close-->
            
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