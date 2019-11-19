<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="Transportlab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>SCM</title>

   
    <link href="<?php echo base_url();?>assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/owl.carousel.css" type="text/css">

   

	<link href="<?php echo base_url();?>assets/css/soon.css" rel="stylesheet">
	

   
     <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/jquery-multi-select/css/multi-select.css" />

	
     <!--bootstrap switcher-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/bootstrap-switch/static/stylesheets/bootstrap-switch.css" />

    <!-- switchery-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/switchery/switchery.css" />

    <!--select 2-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/select2/css/select2.min.css"/>
    <!--right slidebar-->
    <link href="<?php echo base_url();?>assets/css/slidebars.css" rel="stylesheet">

   <!--dynamic table-->
    <link href="<?php echo base_url();?>assets/plugins/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/plugins/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/data-tables/DT_bootstrap.css" />

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/style-responsive.css" rel="stylesheet" />
   
  
  </head>
<header class="header white-bg">
          <div class="sidebar-toggle-box">
              <i class="fa fa-bars"></i>
          </div>
		  <?php
		  $role = $this->session->userdata('user_role');
		  $name = $this->session->userdata('name');
      $global_id = $this->session->userdata('global_id');
		  ?>
          <!--logo start-->
          <a class="logo" >Supply Chain<span> Managememt</span> System (<?php echo $role;?>)</a>
			
          <!--logo end-->
        
          <div class="nav notify-row">
		     <ul class="nav pull-left top-menu" style="margin: 0px 15px;">
				<?php if($role=='admin')
			  {?>
			  <li >
			      <select class="js-example-basic-single width-200" id="webservice" name='webservice'>
					<option disabled >Select Web Service</option>
					<option value="http://45.114.141.43:88/webservice-new/SaleDispatchOrder.php">Sales Dispatched Order</option>
					<option value="http://45.114.141.43:88/webservice-new/PostedSalesDispatchOrder.php">Posted Sales Dispatched Order</option>
					<option value="http://45.114.141.43:88/webservice-new/Customers.php">Customers</option>
					<option value="http://45.114.141.43:88/webservice-new/Transporter.php">Transporters</option>
					</select>
					</li>
					<li style="margin-left: 5px;"><button type='submit' id="run" class="btn btn-success">Run</button></li>
				
			  <?php }?>
			 </ul>
            <?php 
           if($role=='admin')
            { 
               $this->db->where('admin_seen', '0');
               $this->db->like('receiver_type', $role, 'both');
               $this->db->like('receiver_id', 'Admin', 'both');
            }
            else if($role=='transporter')
            { 
                 $this->db->where('trans_seen','0');
                 $this->db->like('receiver_type', $role, 'both');
                 $this->db->like('receiver_id', $global_id, 'both');
            }
            else if($role=='customer')
            {  
                $this->db->where('cust_seen', '0');
                $this->db->like('receiver_type', $role, 'both');
                $this->db->like('receiver_id', $global_id, 'both');
            }
           $this->db->select('id');
           $this->db->from('dbo.notification');
           $this->db->order_by("created","desc");
           $count = $this->db->get()->result_array(); 
           $c=count($count);
           if(count($count) > 0)
           {
            $noti_count=count($count);
           }

          if($role=='admin')
            { 
               $this->db->like('receiver_id', 'Admin', 'both');
            }
            else if($role=='transporter')
            { 
                 $this->db->like('receiver_id', $global_id, 'both');
            }
            else if($role=='customer')
            {  
                $this->db->like('receiver_id', $global_id, 'both');
            }

          $this->db->select('TOP 5 message');
          $this->db->from('dbo.notification');
          $this->db->order_by("created","desc");
          $q = $this->db->get()->result_array();

             
         
             
          ?>
              <ul class="nav pull-right top-menu">
			  
			 <li><a onClick="window.location.reload()" class="btn btn-info btn-lg" style='margin-left: 0%;' >
           Refresh
        </a></li>
                  <?php if($role=='admin'){ ?>
                  <li id="header_notification_bar" class="dropdown notifications_admin">
                      <?php } ?>
                       <?php if($role=='transporter'){ ?>
                  <li id="header_notification_bar" class="dropdown notifications_trans">
                      <?php } ?>
                       <?php if($role=='customer'){ ?>
                  <li id="header_notification_bar" class="dropdown notifications_cust">
                      <?php } ?>
                  <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                 
                      <i class="fa fa-bell-o"></i>
                      <span class="badge bg-warning" id='count_notification'><?php echo $noti_count;  ?></span>
                  </a>
                  <ul class="dropdown-menu extended notification">
                      <div class="notify-arrow notify-arrow-yellow"></div>
                      <li>
                          <p class="yellow" >You have <span id='yellow'><?php echo $c; ?></span> new notifications</p>
                      </li>
                      <li>
                        <?php 
                        foreach ($q as $key => $value) {

                          
                          
                          $message = mb_strimwidth($value['message'], 0, 50, '...');
                       ?>
                          <a href="#">
                              <span class="label label-danger"><i class="fa fa-shopping-cart"></i></span>
                             <?php  echo $message; ?>
                              <!--<span class="small italic">34 mins</span>-->
                          </a>
                        <?php } ?>
                      </li>
                      <li>
                        <?php if($role=='admin'){ ?>
                              <a href="<?php echo base_url('index.php/admin/notification');?>">See all notifications</a>
                      <?php } ?>
                       <?php if($role=='transporter'){ ?>
                             <a href="<?php echo base_url('index.php/transporter/notification');?>">See all notifications</a>
                      <?php } ?>
                       <?php if($role=='customer'){ ?>
                             <a href="<?php echo base_url('index.php/customer/notification');?>">See all notifications</a>
                      <?php } ?>
                         
                      </li>
                  </ul>
              </li>
                  <!-- user login dropdown start-->
                  <li class="dropdown">
                      <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                          <img alt="" src="img/avatar1_small.jpg">
                          <span class="username"><?php echo $name ?></span>
                          <b class="caret"></b>
                      </a>
                      <ul class="dropdown-menu extended logout">
					  <?php if($role=='admin')
					  { ?>
                          <li><a href="<?php echo base_url();?>index.php/admin/settings"><i class=" fa fa-cogs"></i>Settings</a></li>
					  <?php } 
				       if($role=='transporter') 
					  { ?>
					   <li><a href="<?php echo base_url();?>index.php/transporter/settings"><i class=" fa fa-cogs"></i>Settings</a></li>
					  <?php } ?>
                          <li><a href="<?php echo base_url();?>index.php/login/logout"><i class="fa fa-key"></i> Log Out</a></li>
                      </ul>
                  </li>
                 
              </ul>
          </div>
      </header>