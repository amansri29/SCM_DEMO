<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="Transportlab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="<?php echo base_url();?>imeges/favicon.png">

    <title>TMS</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/style-responsive.css" rel="stylesheet" />

   
</head>

  <body class="login-body">

    <div class="container">
     
      <form class="form-signin" enctype="multipart/form-data" method="post"  action="<?php echo base_url(); ?>index.php/login/otp_verify">
	 
        <h2 class="form-signin-heading">Otp Verification</h2></br>
		  <img src="https://cdn2.iconfinder.com/data/icons/luchesa-part-3/128/SMS-512.png" class="img-responsive" style="width:100px; height:100px;margin:0 auto;">
		  <h3 class="text-center">Verify your mobile number</h3>
		  <p color='black'> Thanks for giving your details. An OTP has been sent to your Mobile Number. Please enter the 4 digit OTP below for Forgot Password</p>
        <div class="login-wrap">
			
            <input type="text" class="form-control" required placeholder="Enter Your OTP Number" name='otp' autofocus>
           
            <button class="btn btn-lg btn-login btn-block" type="submit">Verify</button>
            <h5><span>Don't Receive the OTP ? </span><a href='<?php echo base_url(); ?>index.php/login/resend_otp' class="form-signin-heading">Resend OTP</h5></br>

        </div>
		<a href='<?php echo base_url(); ?>index.php/login' class="btn btn-lg btn-login btn-block">GO Back Login Page</a>
          <!-- Modal -->
       
          <!-- modal -->
		 <?php if($this->session->flashdata("error1"))
						{ ?>
					<div class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $this->session->flashdata("error1") ?></a></div>
					<?php
						}
                     ?>
            <?php if($this->session->flashdata("success"))
						{ ?>
					<div class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $this->session->flashdata("success") ?></a></div>
					<?php
						}
                     ?>

      </form>
	  
	    

    </div>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>


  </body>
</html>
