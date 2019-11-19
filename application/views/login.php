<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="Transportlab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="<?php echo base_url();?>imeges/favicon.png">

    <title>Transportlab - Transport & Responsive Bootstrap Admin Template</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/style-responsive.css" rel="stylesheet" />

   
</head>

  <body class="login-body" style="background-image: url(<?php echo base_url();?>images/backgroundtms.jpg); background-repeat: no-repeat;background-size: cover; height: 100%; margin: 0px; padding: 0px; " >

    <div class="container">
   
      <form class="form-signin" enctype="multipart/form-data" method="post"  action="<?php echo base_url(); ?>index.php/login/login_validation">
	  
        <h2 class="form-signin-heading" style="background-color: seagreen">sign in now</h2>
        <div class="login-wrap">
			
            <input type="text" class="form-control" required placeholder="User ID/ Email" name='user_id' autofocus>
            <input type="password" class="form-control" required placeholder="Password" name="password" >
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> Remember me
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Forgot Password?</a>

                </span>
            </label>
            <button class="btn btn-lg btn-login btn-block" type="submit" >Sign in</button>
           

        </div>
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
	  
	     <div aria-hidden="true" aria-labelledby="myModallabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Forgot Password ?</h4>
                      </div>
                      <div class="modal-body">
					  <form action="<?php echo base_url();?>index.php/login/forgot_password" method="post" enctype="multipart/form-data" >
                          <p>Enter your Mobile Number below to reset your password.</p>
                          <input type="number" name="mobile" placeholder="Enter Mobile Number" autocomplete="off" class="form-control placeholder-no-fix">

                      </div>
                      <div class="modal-footer">
                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                          <button class="btn btn-success" type="submit"> Submit</button>
                      </div>
					  </form>
                  </div>
              </div>
			     
          </div>

    </div>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>


  </body>
</html>
