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
   
      <form class="form-signin" enctype="multipart/form-data" method="post"  action="<?php echo base_url(); ?>index.php/login/update_new_password">
	  
        <h2 class="form-signin-heading">Update Password</h2>
        <div class="login-wrap">
			
            <input type="password" class="form-control" required placeholder="New Password" name='new_pass' autofocus>
            <input type="password" class="form-control" required placeholder="Confirm Password" name="con_pass" >
           
            <button class="btn btn-lg btn-login btn-block" type="submit">Update</button>
           

        </div>
		<a href='<?php echo base_url(); ?>index.php/login' class="btn btn-lg btn-login btn-block">GO Back Login Page</a>
		<?php if($this->session->flashdata("error1"))
						{ ?>
					<div class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $this->session->flashdata("error1") ?></a></div>
					<?php
						}
                     ?>
            <?php if($this->session->flashdata("error"))
						{ ?>
					<div class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $this->session->flashdata("error") ?></a></div>
					<?php
						}
                     ?>
          <!-- Modal -->
       
          <!-- modal -->
 
      </form>
	  
	     

    </div>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>


  </body>
</html>
