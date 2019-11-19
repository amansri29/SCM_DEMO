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
					<h4 class="text-display-1 margin-none"><?php echo $name ?></h4>

				</div>
			</div>
              <ul class="sidebar-menu" id="nav-accordion">
                  <li>
                      <a href="<?php echo base_url();?>index.php/customer/dashboard">
                          <i class="fa fa-dashboard"></i>
                          <span>DASHBOARD</span>
                      </a>
                  </li>
				  <li class="sub-menu">
                      <a href="javascript:;">
                          <i class="fa fa-shopping-cart"></i>
                          <span>ORDER MANAGEMENT</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?php echo base_url();?>index.php/customer/orders">VIEW ALL</a></li>
                          <!--<li><a  href="new-order.html">CREATE NEW</a></li>-->
                      </ul>
                  </li>
				  <li>
                      <a href="<?php echo base_url();?>index.php/customer/create_order">
                          <i class="fa fa-shopping-cart"></i>
                          <span>CREATE ORDER</span>
                      </a>
                  </li>
				   <li>
                      <a href="<?php echo base_url();?>index.php/customer/placed_order">
                          <i class="fa fa-shopping-cart"></i>
                          <span>PLACED ORDER</span>
                      </a>
                  </li>
				  <li>
                    <a href="<?php echo base_url();?>index.php/customer/track_order">
                          <i class="fa fa-map-marker"></i>
                          <span>TRACK ORDER</span>
                      </a>
                  </li>
                  <li>
                      <a href="<?php echo base_url();?>index.php/customer/notification">
                          <i class="fa fa-bell-o"></i>
                          <span>NOTIFICATIONS</span>
                      </a>
                  </li>

                  

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>