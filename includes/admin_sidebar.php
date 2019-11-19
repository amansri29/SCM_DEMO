 
   <?php
          $access_role=array();
		  $role = $this->session->userdata('user_role');
		  $name = $this->session->userdata('name');
		  $access_role1 = $this->session->userdata('access_role');
		  $access_role=explode(',',$access_role1);
		//  print_r($access_role1);
		  ?>
 <aside>
          <div id="sidebar"  class="nav-collapse " style="background-color: seagreen">
              <!-- sidebar menu start-->
			  <div class="sidebar-block">
				<div class="profile">
					<a href="#">
						<img src="<?php echo base_url();?>images/logo.jpg" alt="people" class="img-circle width-100" />
					</a>
					<h4 class="text-display-1 margin-none"><?php echo $name ?></h4>

				</div>
			</div>
              <ul class="sidebar-menu" id="nav-accordion">
                  <li>
                      <a href="<?php echo base_url();?>index.php/admin/dashboard">
                          <i class="fa fa-dashboard"></i>
                          <span>DASHBOARD</span>
                      </a>
                  </li>
				  <?php if ((in_array("view_customer", $access_role)) || (in_array("view_transporter", $access_role)) || (in_array("view_driver", $access_role)) || (in_array("view_vehicle", $access_role)) || (in_array("av_suser", $access_role)) || (in_array("all", $access_role))) { ?>
				  <p class="sidebar_heading"> MANAGEMENT</p>
				  <?php } if((in_array("view_customer", $access_role)) || (in_array("all", $access_role))) { ?>
				  <li>
                      <a href="<?php echo base_url();?>index.php/admin/view_client">
                          <i class="fa fa-user"></i>
                          <span>CUSTOMERS</span>
                      </a>
                  </li>

                  <li>
                      <a href="<?php echo base_url();?>index.php/admin/export_dispatch">
                          <i class="fa fa-shopping-cart"></i>
                          <span>Add Dispatch Order</span>
                      </a>
                   </li>


				  <?php } if((in_array("view_transporter", $access_role)) || (in_array("all", $access_role))) { ?>
				   <li>
                      <a href="<?php echo base_url();?>index.php/admin/view_transporter">
                          <i class="fa fa-user"></i>
                          <span>TRANSPORTERS</span>
                      </a>
            </li>
				   <?php } if((in_array("view_driver", $access_role)) || (in_array("all", $access_role))) { ?>
				  <li class="sub-menu">
					  <a href="<?php echo base_url();?>index.php/admin/view_driver"">
						  <i class="fa fa-male"></i>
						  <span>DRIVERS</span>
					  </a>
					 <!-- <ul class="sub">
						  <li><a  href="<?php echo base_url();?>index.php/admin/view_driver">VIEW ALL</a></li>
						  <li><a  href="<?php echo base_url();?>index.php/admin/add_driver">ADD NEW</a></li>
						 
					  </ul>-->
				  </li>
				    <?php } if((in_array("view_vehicle", $access_role)) || (in_array("all", $access_role))) { ?>
                  <li class="sub-menu">
                      <a href="<?php echo base_url();?>index.php/admin/view_vehicle"">
                          <i class="fa fa-truck"></i>
                          <span>VEHICLES</span>
                      </a>
                    <!--  <ul class="sub">
                          <li><a  href="<?php echo base_url();?>index.php/admin/view_vehicle">VIEW ALL</a></li>
                          <li><a  href="<?php echo base_url();?>index.php/admin/add_vehicle">ADD NEW</a></li>
                         
                      </ul>-->
					  
                  </li>
				     <?php } if(in_array("all", $access_role)) { ?>
				  <li class="sub-menu">
                      <a href="javascript:;">
                          <i class="fa fa-user"></i>
                          <span>ADMIN MANAGEMENT</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?php echo base_url();?>index.php/admin/view_admin">VIEW ALL</a></li>
                          <li><a  href="<?php echo base_url();?>index.php/admin/add_admin">ADD NEW</a></li>
                         
                      </ul>
                  </li>
				  <?php } if ((in_array("av_suser", $access_role)) || (in_array("all", $access_role))) { ?>
				  <li class="sub-menu">
                      <a href="javascript:;">
                          <i class="fa fa-user"></i>
                          <span>ADD SCANNER USER</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?php echo base_url();?>index.php/admin/view_scanner_user">VIEW ALL</a></li>
                          <li><a  href="<?php echo base_url();?>index.php/admin/add_scanner_user">ADD NEW</a></li>
                         
                      </ul>
                  </li>
				  <?php }  ?>
				   <?php if ((in_array("edit_request", $access_role)) || (in_array("cancel_request", $access_role)) || (in_array("today_dispatched", $access_role)) || (in_array("confirm_pending", $access_role)) || (in_array("pending_dispatches", $access_role)) || (in_array("live_bidding", $access_role)) || (in_array("attn_required", $access_role)) || (in_array("dispatched_order", $access_role)) || (in_array("vehicle_track", $access_role)) || (in_array("missed_order", $access_role)) || (in_array("all", $access_role))) { ?>
				  <p class="sidebar_heading"> Orders</p>
				  <!--<li>
                      <a href="<?php echo base_url();?>index.php/admin/confirmed_orders">
                          <i class="fa fa-shopping-cart"></i>
                          <span>CONFIRMED ORDERS</span>
                      </a>
                  </li>-->
				  <?php
				                  $this->db->select('*');
	                               $this->db->from('dbo.orders_change_details');
								   $this->db->where('status','Not Approved');
								    $data1= $this->db->get()->result_array(); 
								    $count=count($data1);
				  ?>
				   <?php } if ((in_array("edit_request", $access_role)) || (in_array("all", $access_role))) { ?>
				  <li>
                      <a href="<?php echo base_url();?>index.php/admin/approvel_orders">
                          <i class="fa fa-edit"></i>
                          <span>EDIT REQUEST</span>
						  <span class="badge bg-warning"><?php echo $count ?></span>
                      </a>
                  </li> 
				  
				   <?php } ?>
				   <?php
				                  $this->db->select('*');
	                               $this->db->from('dbo.orders_change_details');
								   $this->db->where('status','Canceled');
								    $data1= $this->db->get()->result_array(); 
								    $cancel=count($data1);
				  ?>
				   <?php  if ((in_array("cancel_request", $access_role)) || (in_array("all", $access_role))) { ?>
				    <li>
                      <a href="<?php echo base_url();?>index.php/admin/trans_cancel_approvel">
                          <i class="fa fa-times-circle"></i>
                          <span>CANCEL REQUEST</span>
						  <span class="badge bg-warning"><?php echo $cancel ?></span>
                      </a>
                  </li> 
				   <?php } if ((in_array("today_dispatched", $access_role)) || (in_array("all", $access_role))) { ?>
				  <li>
                      <a href="<?php echo base_url();?>index.php/admin/todays_dispatch">
                          <i class="fa fa-shopping-cart"></i>
                          <span>TODAY'S DISPATCHES</span>
                      </a>
                  </li>
				     <?php } if ((in_array("confirm_pending", $access_role)) || (in_array("all", $access_role))) { ?>
				  <li>
                      <a href="<?php echo base_url();?>index.php/admin/pending_dispatches">
                          <i class="fa fa-shopping-cart"></i>
                          <span>CONFIRMED PEN. DISP.</span>
                      </a>
                  </li>
				  <?php } if ((in_array("pending_dispatches", $access_role)) || (in_array("all", $access_role))) { ?>
				   <li>
                      <a href="<?php echo base_url();?>index.php/admin/not_accepted_orders">
                          <i class="fa fa-shopping-cart"></i>
                          <span>PENDING DISPATCHES</span>
                      </a>
                  </li>
				    <?php } if ((in_array("live_bidding", $access_role)) || (in_array("all", $access_role))) { ?>
				  <li>
                      <a href="<?php echo base_url();?>index.php/admin/live_bidding">
                          <i class="fa fa-legal"></i>
                          <span>LIVE BIDDING STATUS</span>
                      </a>
                  </li>
				  <?php } if ((in_array("attn_required", $access_role)) || (in_array("all", $access_role))) { ?>
				  <li>
                      <a href="<?php echo base_url();?>index.php/admin/attn_required">
                          <i class="fa fa-warning"></i>
                          <span>ATTENTION REQUIRED</span>
                      </a>
                  </li>
				  <?php } if ((in_array("dispatched_order", $access_role)) || (in_array("all", $access_role))) { ?>
				   <li>
                      <a href="<?php echo base_url();?>index.php/admin/completed_orders">
                          <i class="fa fa-shopping-cart"></i>
                          <span>DISPATCHED ORDERS </span>
                      </a>
                  </li>
				   <?php } if ((in_array("vehicle_track", $access_role)) || (in_array("all", $access_role))) { ?>
				  <li>
				  
                      <a href="<?php echo base_url();?>index.php/admin/track_now">
                          <i class="fa fa-map-marker"></i>
                          <span>TRACK ORDER</span>
                      </a>
                  </li>
				   <?php } ?>
				  <!--<li>
				  
                      <a href="<?php echo base_url();?>index.php/admin/vehicle_track">
                          <i class="fa fa-map-marker"></i>
                          <span>VEHICLES TRACK</span>
                      </a>
                  </li>-->
				  <!-- <li>
                      <a href="<?php echo base_url();?>index.php/admin/cancel_orders">
                          <i class="fa fa-times-circle"></i>
                          <span>DELETED ORDERS</span>
						   
                      </a>
                  </li>-->
				   <?php  if ((in_array("missed_order", $access_role)) || (in_array("all", $access_role))) { ?>
				  <li>
                      <a href="<?php echo base_url();?>index.php/admin/missed_orders">
                          <i class="fa fa-warning"></i>
                          <span>MISSED ORDERS BY TRANS.</span>
						   
                      </a>
                  </li>
				   <?php } ?>
<?php if ((in_array("driver_wallet", $access_role)) || (in_array("assign_milestone", $access_role))  || (in_array("all", $access_role))) { ?>				   
				  <p class="sidebar_heading"> Driver's Appreciation</p>
				  				   <?php } if ((in_array("assign_milestone", $access_role)) || (in_array("all", $access_role))) { ?>
				  <li>
                      <a href="<?php echo base_url();?>index.php/admin/milestone">
                          <i class="fa fa-gift"></i>
                          <span>ASSIGN MILESTONE</span>
                      </a>
                  </li>
				     <?php } if ((in_array("driver_wallet", $access_role)) || (in_array("all", $access_role))) { ?>
				  <li>
                      <a href="<?php echo base_url();?>index.php/admin/wallet">
                          <i class="fa fa-money"></i>
                          <span>DRIVER WALLET</span>
                      </a>
                  </li>
					 <?php } ?>
					 <?php if ((in_array("report", $access_role)) || (in_array("setting", $access_role)) || (in_array("rating", $access_role))  || (in_array("all", $access_role))) { ?>	
				   <p class="sidebar_heading"> Reports & Configuration</p>
				   <?php } if ((in_array("report", $access_role)) || (in_array("all", $access_role))) { ?>
				 
                <li class="sub-menu">
                      <a href="#">
                          <i class="fa fa-folder-open"></i>
                          <span>REPORTS</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?php echo base_url();?>index.php/admin/delay_report"> Delay Report</a></li>
                      </ul>
                      <ul class="sub">
                          <li><a  href="<?php echo base_url();?>index.php/admin/planVsDispatch"> Plan Vs Dispatch Report</a></li>
                      </ul>
                  </li>
				   <?php } 


           if ((in_array("setting", $access_role)) || (in_array("all", $access_role))) { ?>


				  <li>
                      <a href="<?php echo base_url();?>index.php/admin/settings">
                          <i class="fa fa-cogs"></i>
                          <span>SETTINGS</span>
                      </a>
                  </li>
				   <?php } if ((in_array("rating", $access_role)) || (in_array("all", $access_role))) { ?>
				  <li>
                      <a href="<?php echo base_url();?>index.php/admin/all_rating">
                          <i class="fa fa-star"></i>
                          <span>RATINGS</span>
                      </a>
                  </li>
				   <?php } ?>
				    <li>
                      <a href="<?php echo base_url();?>index.php/admin/noti_sms_email">
                          <i class="fa fa-envelope"></i>
                          <span>NOTI. EMAILS AND SMS</span>
                      </a>
                  </li>
                   <li>
                      <a href="<?php echo base_url();?>index.php/admin/notification">
                          <i class="fa fa-bell-o"></i>
                          <span>NOTIFICATIONS</span>
                      </a>
                  </li>
                   <li>
                      <a href="<?php echo base_url();?>index.php/admin/help">
                          <i class="fa fa-question-circle"></i>
                          <span>HELP</span>
                      </a>
                  </li>

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>