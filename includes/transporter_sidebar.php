<?php
		  $role = $this->session->userdata('user_role');
		  $name = $this->session->userdata('name');
		  ?>
 <aside>
          <div id="sidebar"  class="nav-collapse " style="background-color: seagreen">
              <!-- sidebar menu start-->
			  <div class="sidebar-block">
				<div class="profile">
					<a href="#">
						<img src="<?php echo base_url();?>images/logo.jpg" alt="people" class="img-circle width-100" />
					</a>
					<h4 class="text-display-1 margin-none"><?php echo $name ?> </h4>

				</div>
			</div>
              <ul class="sidebar-menu" id="nav-accordion">
                  <li>
                      <a href="<?php echo base_url();?>index.php/transporter/dashboard">
                          <i class="fa fa-dashboard"></i>
                          <span>DASHBOARD</span>
                      </a>
                  </li>
				  <p class="sidebar_heading"> MANAGEMENT</p>
				  <li class="sub-menu">
					  <a href="javascript:;">
						  <i class="fa fa-user"></i>
						  <span>DRIVER MANAGEMENT</span>
					  </a>
					  <ul class="sub">
						  <li><a  href="<?php echo base_url();?>index.php/transporter/view_driver">VIEW ALL</a></li>
						  <li><a  href="<?php echo base_url();?>index.php/transporter/add_driver">ADD NEW</a></li>
						 
					  </ul>
				  </li>
                  <li class="sub-menu">
                      <a href="javascript:;">
                          <i class="fa fa-truck"></i>
                          <span>VEHICLE MANAGEMENT</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?php echo base_url();?>index.php/transporter/view_vehicle">VIEW ALL</a></li>
                          <li><a  href="<?php echo base_url();?>index.php/transporter/add_vehicle">ADD NEW</a></li>
                         
                      </ul>
                  </li>
				  <p class="sidebar_heading"> Orders</p>
				  <li class="sub-menu">
                      <a href="javascript:;">
                          <i class="fa fa-truck"></i>
                          <span>ORDERS</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?php echo base_url();?>index.php/transporter/pending_orders">PENDING</a></li>
                          <li><a  href="<?php echo base_url();?>index.php/transporter/inprocess_orders">IN PROCESS</a></li>
                          <li><a  href="<?php echo base_url();?>index.php/transporter/dispatched_orders">DISPATCHED</a></li>
                          <li><a  href="<?php echo base_url();?>index.php/transporter/completed_orders">DELIVERED</a></li>
                          <li><a  href="<?php echo base_url();?>index.php/transporter/attn_required">MISSED</a></li>
                         
                      </ul>
                  </li>
				  <li>
                      <a href="<?php echo base_url();?>index.php/transporter/open_orders">
                          <i class="fa fa-truck"></i>
                          <span>BROWSE ORDERS</span>
                      </a>
                  </li>
				  
                  <li>
                      <a href="<?php echo base_url();?>index.php/transporter/track_now">
                          <i class="fa fa-map-marker"></i>
                          <span>TRACK ORDER</span>
                      </a>
                  </li>
				  <li>
                      <a href="<?php echo base_url();?>index.php/transporter/milestone">
                          <i class="fa fa-gift"></i>
                          <span>MILESTONE</span>
                      </a>
                  </li>
                   <li>
                      <a href="<?php echo base_url();?>index.php/transporter/notification">
                          <i class="fa fa-bell-o"></i>
                          <span>NOTIFICATIONS</span>
                      </a>
                  </li>
				   <li>
                      <a href="<?php echo base_url();?>index.php/transporter/settings">
                          <i class="fa fa-cogs"></i>
                          <span>SETTINGS</span>
                      </a>
                  </li>

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>