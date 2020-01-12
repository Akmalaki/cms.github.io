<?php require_once('inc/top.php');?>
</head>
  <body>
   
   <?php require_once('inc/header.php');?>
        <!-- Jumbotron start-->
        <div class="jumbotron">
            <div class="container">
                <div id="details" class="animated fadeInLeft">
                    <h1>Contact<span> Us</span></h1>
                    <p>This is an Online Web Control Management System</p>
                </div>
             
        </div>
        <img src="image/Jumbotrantop.jpg" alt="Top Image">
        </div><!-- /Jumbotron Close-->
        
        <!-Section start-->
        <section>
        <div class="container">
        <div class="row"><!--Section row-->
        <div class="col-md-8">
      <div class="row"><!--Row start for google mape & Form-->
            <div class="col-md-12"><!--col 12 start for mape-->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d28965.274877369444!2d67.09615584956808!3d24.841320275023286!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb33bc211b229af%3A0x1c5a3135d6475988!2sKorangi%20Industrial%20Area%2C%20Karachi%2C%20Karachi%20City%2C%20Sindh%2C%20Pakistan!5e0!3m2!1sen!2s!4v1568751489420!5m2!1sen!2s" width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
          </div><!--col 12 close for google mape-->
            <div class="col-md-12 contact-form"><!--col 12 start for Form-->
                <h2>Contact Form</h2><hr>
                <form action="">
                    <div class="form-group">
                        <label for="full-name">Full Name*:</label>
                        <input type="text" id="full-name" class="form-control" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email*:</label>
                        <input type="text" id="email" class="form-control" placeholder="Email Adress">
                    </div>
                    <div class="form-group">
                        <label for="website">Website:</label>
                        <input type="text" id="website" class="form-control" placeholder="Website">
                    </div>
                    <div class="form-group">
                        <label for="message">Messages:</label>
                <textarea id="message" cols="30" rows="10" class="form-control" placeholder="Your Message Should be Here"></textarea>
                    </div>
                    <input type="submit" name="submit" value="Submit" class="btn btn-primary">  
                </form>
          </div><!--col 12 close for Form-->

            </div><!--Row close for google mape & Form-->
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