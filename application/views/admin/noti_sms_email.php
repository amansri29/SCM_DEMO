<?php
   include "includes/header.php";
   ?>

  <body>

  <section id="container" class="">
      <!--header start-->
     
      <!--header end-->
      <!--sidebar start-->
        <?php
   include "includes/admin_sidebar.php";
   ?>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="row">
<?php

if(($this->session->flashdata('item'))) {

  $message = $this->session->flashdata('item');

  ?>
              <div id="mess" class="<?php echo $message['class'];?>"><?php echo $message['message']; ?></div>
              <?php

}else{

}

?>
                 <div class="col-md-12">
                    <ul class="vertical-menu" >
                        <li class="active col-md-4" style='display: inline-block;' >
                            <a href="#tab_1" data-toggle="tab">
                                <i class="fa fa-bell-o" style="font-size:22px;color:red"></i>&nbsp
                               Notification
                            </a>
                        </li>
                        <li class="col-md-4" style='display: inline-block;'>
                          <a href="#tab_2" data-toggle="tab">
                            <i class="fa fa-envelope" style="font-size:22px;color:red"></i>&nbsp
                            Email 
                          </a>
                        </li>
                        <li class="col-md-4" style='display: inline-block;'>
                          <a href="#tab_3" data-toggle="tab">
                            <i class="fa fa-mobile-phone" style="font-size:26px;color:red"></i>&nbsp
                            SMS
                          </a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-12">
              <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                  <div class="panel-group" id="accordion1">
                      <div class="panel panel-danger">
                          <div class="panel-heading" style='background-color:#27313B'>
                              <h4 class="panel-title">
                                  <a href="#accordion1_1" data-parent="#accordion1" data-toggle="collapse" style="color:white">
                                    TRANSPORTER EVENT NOTIFICATION
                                  </a>
                              </h4>
                          </div>
                          <div class="panel-heading" style='background-color:#CAC6C4'>
                              <h4 class="panel-title">
                                  <a href="#" data-parent="#accordion1" data-toggle="collapse" style="color:black ;font-size:20px">
                                     {}= use for order_id,  []= use for transporter name, ()= use for customer name, <> use for driver name, Admin= user for Admin, @@ use for vehicle name 
                                  </a>
                              </h4>
                          </div>

                          <div class="row">
                             <div class="panel-collapse collapse  in" id="accordion1_1">
                            <div class="col-md-12">

                          <section class="panel col-md-6" >
                          <header class="panel-heading"  style=" font-size: 20px; font-weight:500;">
                              Order Accepted
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $accept_order_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_accept'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $accept_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                         
                        </section>
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Order Decline
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $decline_order_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_decline'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $decline_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          
                        </section>
                      </div>
                    
                          <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Order Not Accepted in give time frame
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $order_not_accept_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_not_accept'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $order_not_accept_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                								  <div class="col-lg-offset-5 col-lg-2">
                									  <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                								  </div>
                								</div>
                              </form>
                              </div>
                        </section>
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Order Not Assigned in give time frame
                          </header>
                         
                              <div class="panel-body">
                              	<form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $order_not_assign_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_not_assign'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $order_not_assign_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                								  <div class="col-lg-offset-5 col-lg-2">
                									  <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                								  </div>
                								</div>
                              </form>
                              </div>
                         
                        </section>
                      </div>
                    
                       <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Order Assign To Driver
                          </header>
                                <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $assign_order_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_assign'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $assign_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                								  <div class="col-lg-offset-5 col-lg-2">
                									  <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                								  </div>
                								</div>
                              </form>
                              </div>
                          
                        </section>
                         <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Cancel Assignment Request
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $cancel_assignment_request_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='cancel_assignment_request'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $cancel_assignment_request_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          
                        </section>
                      </div>

                      <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Edit Assignment Request
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $edit_assignment_request_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='edit_assignment_request'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $edit_assignment_request_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                         <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             No Bidding Place
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $no_bidding_place_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='no_bidding_place'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $no_bidding_place_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                      
                      </div>
                      </div>
                    </div>
                  </div>
                 <div class="panel panel-danger">
                          <div class="panel-heading" style='background-color:#27313B'>
                              <h4 class="panel-title">
                                  <a href="#accordion1_2" data-parent="#accordion1" data-toggle="collapse" style="color:white">
                                    DRIVER EVENT NOTIFICATION
                                  </a>
                              </h4>
                          </div>
                          <div class="panel-heading" style='background-color:#CAC6C4'>
                              <h4 class="panel-title">
                                  <a href="#" data-parent="#accordion1" data-toggle="collapse" style="color:black ;font-size:20px">
                                     {}= use for order_id,  []= use for transporter name, ()= use for customer name, <> use for driver name, Admin= user for Admin, @@ use for vehicle name 
                                  </a>
                              </h4>
                          </div>

                          <div class="row">
                             <div class="panel-collapse collapse  in" id="accordion1_2">
                            <div class="col-md-12">
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Driver Gate In
                          </header>
                         
                              <div class="panel-body">
                              	<form role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $gate_in_order_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='gate_in'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $gate_in_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                								  <div class="col-lg-offset-5 col-lg-2">
                									  <button type="submit" class="btn btn-danger btn-block">Save</button>
                								  </div>
                								</div>
                              </form>
                              </div>
                        </section>
                     
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Driver Weight In
                          </header>
                          
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $weight_in_order_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='weight_in'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $weight_in_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
								  <div class="col-lg-offset-5 col-lg-2">
									  <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
								  </div>
								</div>
                              </form>
                              </div>
                       
                        </section>
                         </div>
                      <div class="col-md-12">
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Driver Loading In
                          </header>
                        
                              <div class="panel-body">
                              	<form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $loading_in_order_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='loading_in'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $loading_in_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                								  <div class="col-lg-offset-5 col-lg-2">
                									  <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                								  </div>
                								</div>
                              </form>
                              </div>
                         
                        </section>
                     
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Driver Weight Out
                          </header>
                        
                              <div class="panel-body" >
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $weight_out_order_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='weight_out'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $weight_out_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                								  <div class="col-lg-offset-5 col-lg-2">
                									  <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                								  </div>
                								</div>
                              </form>
                              </div>
                          
                        </section>
                         </div>
                      <div class="col-md-12">
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Driver Loading Out
                          </header>
                         
                              <div class="panel-body">
                              	<form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $loading_out_order_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='loading_out'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $loading_out_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                  								  <div class="col-lg-offset-5 col-lg-2">
                  									  <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                  								  </div>
                  								</div>
                              </form>
                              </div>
                        
                        </section>
                     
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                            Dispatched Order
                          </header>
                        
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $dispatched_order_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='dispatched'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $dispatched_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>

                        </section>
                         </div>
                      <div class="col-md-12">
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Delivered Order
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $delivered_order_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='delivered'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $delivered_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                <div class="col-lg-offset-5 col-lg-2">
                                  <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                </div>
                              </div>
                              </form>
                              </div>
                          
                        </section>
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Appreciation achieved -> when reached on time
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $mliestone_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='mliestone'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $mliestone_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                <div class="col-lg-offset-5 col-lg-2">
                                  <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                </div>
                              </div>
                              </form>
                              </div>
                          
                        </section>
                      </div>
                    </div>
                    </div>
                      </div>
                      <div class="panel panel-danger">
                          <div class="panel-heading" style='background-color:#27313B'>
                              <h4 class="panel-title">
                                  <a href="#accordion1_1" data-parent="#accordion1" data-toggle="collapse" style="color:white">
                                    ADMIN EVENT NOTIFICATION
                                  </a>
                              </h4>
                          </div>
                          <div class="panel-heading" style='background-color:#CAC6C4'>
                              <h4 class="panel-title">
                                  <a href="#" data-parent="#accordion1" data-toggle="collapse" style="color:black ;font-size:20px">
                                     {}= use for order_id,  []= use for transporter name, ()= use for customer name, <> use for driver name, Admin= user for Admin, @@ use for vehicle name 
                                  </a>
                              </h4>
                          </div>

                          <div class="row">
                             <div class="panel-collapse collapse  in" id="accordion1_1">
                            <div class="col-md-12">

                          <section class="panel col-md-6" >
                          <header class="panel-heading"  style=" font-size: 20px; font-weight:500;">
                              Cancelleation Request Approved
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $cancelleation_request_approved_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='cancelleation_request_approved'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $cancelleation_request_approved_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                         
                        </section>
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                            Edit Request Approved
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $edit_request_approved_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='edit_request_approved'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $edit_request_approved_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          
                        </section>
                      </div>
                    
                          <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Cancelletion Request - Rejected
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $cancelletion_request_rejected_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='cancelletion_request_rejected'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $cancelletion_request_rejected_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                            Edit Request - Rejected
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $edit_Request_rejected_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='edit_Request_rejected'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $edit_Request_rejected_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                         
                        </section>
                      </div>
                    
                       <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Order Assigned to vendor -> through attention required section
                          </header>
                                <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $order_assigned_to_vendor_attn_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_assigned_to_vendor_attn'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $order_assigned_to_vendor_attn_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          
                        </section>
                         <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                           Appreciation Approved
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $appreciation_approved_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='appreciation_approved'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $appreciation_approved_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          
                        </section>
                      </div>

                      <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Order Cancelletion
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $order_cancelletion_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_cancelletion'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $order_cancelletion_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                       <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              New order Assign From Admin
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_noti_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $assign_order_transporter_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='assign_order_transporter'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $assign_order_transporter_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                      </div>

                      </div>
                    </div>
                  </div>
                  </div>
              </div>
              <div class="tab-pane" id="tab_2">
                  <div class="panel-group" id="accordion2">
                    <div class="panel panel-danger">
                          <div class="panel-heading" style='background-color:#6ccac9'>
                              <h4 class="panel-title">
                                  <a href="#accordion2_2" data-parent="#accordion2" data-toggle="collapse" style="color:white">
                                    TRANSPORTER EVENT EMAILS
                                  </a>
                              </h4>
                          </div>
                          <div class="panel-heading" style='background-color:#CAC6C4'>
                              <h4 class="panel-title">
                                  <a href="#" data-parent="#accordion2" data-toggle="collapse" style="color:black ;font-size:20px">
                                     {}= use for order_id,  []= use for transporter name, ()= use for customer name, <> use for driver name, Admin= user for Admin, @@ use for vehicle name 
                                  </a>
                              </h4>
                          </div>

                          <div class="row">
                             <div class="panel-collapse collapse  in" id="accordion2_2">
                            <div class="col-md-12">

                          <section class="panel col-md-6" >
                          <header class="panel-heading"  style=" font-size: 20px; font-weight:500;">
                              Order Accepted
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_accept_order_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_accept'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_accept_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                         
                        </section>
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Order Decline
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_decline_order_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_decline'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_decline_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          
                        </section>
                      </div>
                    
                          <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Order Not Accepted in give time frame
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_order_not_accept_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_not_accept'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_order_not_accept_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Order Not Assigned in give time frame
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_order_not_assign_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_not_assign'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_order_not_assign_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                         
                        </section>
                      </div>
                    
                       <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Order Assign To Driver
                          </header>
                                <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_assign_order_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_assign'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_assign_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          
                        </section>
                         <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Cancel Assignment Request
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_cancel_assignment_request_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='cancel_assignment_request'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_cancel_assignment_request_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          
                        </section>
                      </div>

                      <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Edit Assignment Request
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_edit_assignment_request_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='edit_assignment_request'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_edit_assignment_request_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                        <!--<section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Add Driver
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_add_driver_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='add_driver'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_add_driver_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>-->
                      
                      </div>
                      </div>
                    </div>
                  </div> 

                  <div class="panel panel-danger">
                          <div class="panel-heading" style='background-color:#6ccac9'>
                              <h4 class="panel-title">
                                  <a href="#accordion2_3" data-parent="#accordion2" data-toggle="collapse" style="color:white">
                                    DRIVER EVENT EMAILS
                                  </a>
                              </h4>
                          </div>
                          <div class="panel-heading" style='background-color:#CAC6C4'>
                              <h4 class="panel-title">
                                  <a href="#" data-parent="#accordion2" data-toggle="collapse" style="color:black ;font-size:20px">
                                     {}= use for order_id,  []= use for transporter name, ()= use for customer name, <> use for driver name, Admin= user for Admin, @@ use for vehicle name 
                                  </a>
                              </h4>
                          </div>

                          <div class="row">
                             <div class="panel-collapse collapse  in" id="accordion2_3">
                            <div class="col-md-12">
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Driver Gate In
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_gate_in_order_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='gate_in'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_gate_in_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                     
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Driver Weight In
                          </header>
                          
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_weight_in_order_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='weight_in'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_weight_in_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                  <div class="col-lg-offset-5 col-lg-2">
                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                  </div>
                </div>
                              </form>
                              </div>
                       
                        </section>
                         </div>
                      <div class="col-md-12">
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Driver Loading In
                          </header>
                        
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_loading_in_order_title ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='loading_in'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_loading_in_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                         
                        </section>
                     
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Driver Weight Out
                          </header>
                        
                              <div class="panel-body" >
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_weight_out_order_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='weight_out'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_weight_out_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          
                        </section>
                         </div>
                      <div class="col-md-12">
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Driver Loading Out
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_loading_out_order_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='loading_out'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_loading_out_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="col-lg-offset-5 col-lg-2">
                                      <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                    </div>
                                  </div>
                              </form>
                              </div>
                        
                        </section>
                     
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                            Dispatched Order
                          </header>
                        
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_dispatched_order_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='dispatched'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_dispatched_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>

                        </section>
                         </div>
                      <div class="col-md-12">
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Delivered Order
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_delivered_order_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='delivered'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_delivered_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                <div class="col-lg-offset-5 col-lg-2">
                                  <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                </div>
                              </div>
                              </form>
                              </div>
                          
                        </section>
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Appreciation achieved -> when reached on time
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_mliestone_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='mliestone'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_mliestone_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                <div class="col-lg-offset-5 col-lg-2">
                                  <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                </div>
                              </div>
                              </form>
                              </div>
                          
                        </section>
                      </div>
                    </div>
                    </div>
                      </div>
                      <div class="panel panel-danger">
                          <div class="panel-heading" style='background-color:#6ccac9'>
                              <h4 class="panel-title">
                                  <a href="#accordion2_4" data-parent="#accordion2" data-toggle="collapse" style="color:white">
                                    ADMIN EVENT EMAILS
                                  </a>
                              </h4>
                          </div>
                          <div class="panel-heading" style='background-color:#CAC6C4'>
                              <h4 class="panel-title">
                                  <a href="#" data-parent="#accordion2" data-toggle="collapse" style="color:black ;font-size:20px">
                                     {}= use for order_id,  []= use for transporter name, ()= use for customer name, <> use for driver name, Admin= user for Admin, @@ use for vehicle name 
                                  </a>
                              </h4>
                          </div>

                          <div class="row">
                             <div class="panel-collapse collapse  in" id="accordion2_4">
                            <div class="col-md-12">

                          <section class="panel col-md-6" >
                          <header class="panel-heading"  style=" font-size: 20px; font-weight:500;">
                              Cancelleation Request Approved
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_cancelleation_request_approved_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='cancelleation_request_approved'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_cancelleation_request_approved_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                         
                        </section>
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                            Edit Request Approved
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_edit_request_approved_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='edit_request_approved'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_edit_request_approved_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          
                        </section>
                      </div>
                    
                          <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Cancelletion Request - Rejected
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_cancelletion_equest_rejected_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='cancelletion_request_rejected'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_cancelletion_equest_rejected_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                            Edit Request - Rejected
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_edit_Request_rejected_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='edit_Request_rejected'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_edit_Request_rejected_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                         
                        </section>
                      </div>
                    
                       <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Order Assigned to vendor -> through attention required section
                          </header>
                                <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_order_assigned_to_vendor_attn_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_assigned_to_vendor_attn'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_order_assigned_to_vendor_attn_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          
                        </section>
                         <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                           Appreciation Approved
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_appreciation_approved_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='appreciation_approved'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_appreciation_approved_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          
                        </section>
                      </div>

                      <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Order Cancelletion
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_order_cancelletion_subject ?>'required id="name" placeholder="Enter subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_cancelletion'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_order_cancelletion_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                       <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              New order Assign From Admin
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_assign_order_transporter_subject ?>'required id="name" placeholder="Enter Subject">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='assign_order_transporter'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_assign_order_transporter_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                      </div>
                      <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Add Customer
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Subject</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_add_customer_subject ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='add_customer'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_add_customer_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Add Subadmin
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_add_subadmin_subject ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='add_subadmin'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_add_subadmin_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                      </div>
                      <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Add Transporter
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_email_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="subject" value='<?php echo $e_add_transporter_subject ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='add_transporter'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $e_add_transporter_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                      </div>
                      </div>
                    </div>
                  </div>  
                  </div>
              </div>
              <div class="tab-pane" id="tab_3">
                  <div class="panel-group" id="accordion3">
                     <div class="panel panel-danger">
                          <div class="panel-heading" style='background-color:#ff6600'>
                              <h4 class="panel-title">
                                  <a href="#accordion3_2" data-parent="#accordion3" data-toggle="collapse" style="color:white">
                                    TRANSPORTER EVENT SMS
                                  </a>
                              </h4>
                          </div>
                          <div class="panel-heading" style='background-color:#CAC6C4'>
                              <h4 class="panel-title">
                                  <a href="#" data-parent="#accordion3" data-toggle="collapse" style="color:black ;font-size:20px">
                                     {}= use for order_id,  []= use for transporter name, ()= use for customer name, <> use for driver name, Admin= user for Admin, @@ use for vehicle name 
                                  </a>
                              </h4>
                          </div>

                          <div class="row">
                             <div class="panel-collapse collapse  in" id="accordion3_2">
                            <div class="col-md-12">

                          <section class="panel col-md-6" >
                          <header class="panel-heading"  style=" font-size: 20px; font-weight:500;">
                              Order Accepted
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_sms_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $s_accept_order_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_accept'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $s_accept_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                         
                        </section>
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Order Decline
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_sms_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $s_decline_order_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_decline'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $s_decline_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                      </div>
                    
                          
                    
                       <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Order Assign To Driver
                          </header>
                                <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_sms_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $s_assign_order_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_assign'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $s_assign_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          
                        </section>
                         <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Cancel Assignment Request
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_sms_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $s_cancel_assignment_request_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='cancel_assignment_request'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $s_cancel_assignment_request_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          
                        </section>
                      </div>

                      <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Edit Assignment Request
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_sms_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $s_edit_assignment_request_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='edit_assignment_request'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $s_edit_assignment_request_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                         <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Add Driver
                          </header>
                                <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_sms_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $s_add_driver_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='add_driver'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $s_add_driver_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          
                        </section>
                      
                      </div>
                      </div>
                    </div>
                  </div> 

                  <div class="panel panel-danger">
                          <div class="panel-heading" style='background-color:#ff6600'>
                              <h4 class="panel-title">
                                  <a href="#accordion3_3" data-parent="#accordion3" data-toggle="collapse" style="color:white">
                                    DRIVER EVENT SMS
                                  </a>
                              </h4>
                          </div>
                          <div class="panel-heading" style='background-color:#CAC6C4'>
                              <h4 class="panel-title">
                                  <a href="#" data-parent="#accordion3" data-toggle="collapse" style="color:black ;font-size:20px">
                                     {}= use for order_id,  []= use for transporter name, ()= use for customer name, <> use for driver name, Admin= user for Admin, @@ use for vehicle name 
                                  </a>
                              </h4>
                          </div>

                          <div class="row">
                             <div class="panel-collapse collapse  in" id="accordion3_3">
                            
                      
                      <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                            Dispatched Order
                          </header>
                        
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_sms_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $s_dispatched_order_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='dispatched'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $s_dispatched_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>

                        </section>
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                             Delivered Order
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_sms_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $s_delivered_order_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='delivered'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $s_delivered_order_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                <div class="col-lg-offset-5 col-lg-2">
                                  <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                </div>
                              </div>
                              </form>
                              </div>
                          
                        </section>
                      </div>
                    </div>
                    </div>
                      </div>
                      <div class="panel panel-danger">
                          <div class="panel-heading" style='background-color:#ff6600'>
                              <h4 class="panel-title">
                                  <a href="#accordion3_4" data-parent="#accordion3" data-toggle="collapse" style="color:white">
                                    ADMIN EVENT SMS
                                  </a>
                              </h4>
                          </div>
                          <div class="panel-heading" style='background-color:#CAC6C4'>
                              <h4 class="panel-title">
                                  <a href="#" data-parent="#accordion3" data-toggle="collapse" style="color:black ;font-size:20px">
                                     {}= use for order_id,  []= use for transporter name, ()= use for customer name, <> use for driver name, Admin= user for Admin, @@ use for vehicle name 
                                  </a>
                              </h4>
                          </div>

                          <div class="row">
                             <div class="panel-collapse collapse  in" id="accordion3_4">
                       <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Order Assigned to vendor -> through attention required section
                          </header>
                                <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_sms_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $s_order_assigned_to_vendor_attn_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_assigned_to_vendor_attn'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $s_order_assigned_to_vendor_attn_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          
                        </section>
                         <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                           Appreciation Approved
                          </header>
                         
                              <div class="panel-body">
                                <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_sms_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $s_appreciation_approved_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='appreciation_approved'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $s_appreciation_approved_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                          
                        </section>
                      </div>

                      <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Order Cancelletion
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_sms_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $s_order_cancelletion_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='order_cancelletion'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $s_order_cancelletion_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Add Transporter
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_sms_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $s_add_transporter_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='add_transporter'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $s_add_transporter_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                      </div>
                      <div class="col-md-12">
                          <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Add Customer
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_sms_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $s_add_customer_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='add_customer'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $s_add_customer_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                        <section class="panel col-md-6" >
                          <header class="panel-heading" style=" font-size: 20px; font-weight:500;">
                              Add Subadmin
                          </header>
                         
                              <div class="panel-body">
                                  <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="<?php echo base_url();?>index.php/admin/save_sms_string">
                                <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Title</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" name="title" value='<?php echo $s_add_subadmin_title ?>'required id="name" placeholder="Enter Title">
                                          <input type="hidden" class="form-control" name="type"  id="name" value='add_subadmin'>
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label for="name" class="col-lg-3 col-sm-2 control-label">Meassage</label>
                                      <div class="col-lg-8">
                                          <textarea  class="form-control" name="message" required id="name" placeholder=""><?php echo $s_add_subadmin_message ?></textarea>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-2">
                                    <button type="submit" id='abc' class="btn btn-danger btn-block">Save</button>
                                  </div>
                                </div>
                              </form>
                              </div>
                        </section>
                      </div>
                      </div>
                    </div>
                  </div>
                  </div>
              </div>
              </div>
              </div>
               </div>
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->
      <!-- Right Slidebar start -->
      <!-- Right Slidebar end -->
      <!--footer start-->
     <?php
   include "includes/footer.php";
   ?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="js/respond.min.js" ></script>

  <!--right slidebar-->
  <script src="js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>


  </body>
</html>
