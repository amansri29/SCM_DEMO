   <?php
   include "includes/header.php";
   ?>

  <body>

  <section id="container" class="">
      <!--header start-->
     
      <!--header end-->
      <!--sidebar start-->
        <?php
   include "includes/transporter_sidebar.php";
   ?>
      <!--sidebar end-->
      <!--main content start-->
     <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <section class="panel">
                  <header class="panel-heading" style='font-weight: bold;font-size:20px'>
                    Notifications
                  </header>
          <?php
           if($this->session->flashdata("success"))
            { ?>
          <div class="alert alert-success alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $this->session->flashdata("success") ?></a></div>
          <?php
            }
                     ?>
            <?php  
                       if($this->session->flashdata("error"))
            { ?>
          <div class="alert alert-danger alert-dismissible fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $this->session->flashdata("error") ?></a></div>
          <?php
            }
                     ?>
                  <div class="panel-body">
                      <div class="adv-table editable-table ">
                          <div class="clearfix">
                             <div class="panel-body">
                              <!--<form role="form" method="POST" action="<?php echo base_url(); ?>admin/save_categories">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Add Category</label>
                    
                    <input type="text" required value='<?php echo $cat_name ?>' name='category' class="form-control" id="title" placeholder="Enter Coupon Category">
                    <input type="hidden" name='id' value='<?php echo $id?>' class="form-control" id="title" placeholder="Enter Coupon Category">
                    
                                  </div>
                   
                                  
                                  <button type="submit" class="btn btn-info">Save </button>
                  </form>-->
                          </div>
                              
                          </div>
                          <div class="row">
                 
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              Notifications
                             
                          </header>
                          <div class="panel-body">
                              <div class="timeline-messages">
                                  <!-- Comment -->
                  <?php 
                  if($data)
                  {
                  foreach($data as $get)
                  {
                    $created=$get['created'];
                    $time_ago = strtotime($created);
              $cur_time   = strtotime(date('Y-m-d H:i:s'));
              $time_elapsed   = $cur_time - $time_ago;
              $seconds    = $time_elapsed ;
              $minutes    = round($time_elapsed / 60 );
              $hours      = round($time_elapsed / 3600);
              $days       = round($time_elapsed / 86400 );
              $weeks      = round($time_elapsed / 604800);
              $months     = round($time_elapsed / 2600640 );
              $years      = round($time_elapsed / 31207680 );
               if($seconds <= 60){
                $a= "just now";
               }
              //Minutes
               else if($minutes <=60){
                if($minutes==1){
                  $a= "one minute ago";
                }
                else{
                  $a =$minutes ." minutes ago";
                }
              }
              //Hours
              else if($hours <=24){
                if($hours==1){
                  $a= "last hour ago";
                }else{
                  $a =$hours ." hrs ago";
                }
              }
              //Days
              else if($days <= 7){
                if($days==1){
                  $a ="yesterday";
                }else{
                  $a =$days ." days ago";
                }
              }
              //Weeks
              else if($weeks <= 4.3){
                if($weeks==1){
                  $a= "last week ago";
                }else{
                  $a= $weeks." weeks ago";
                }
              }
              //Months
              else if($months <=12){
                if($months==1){
                  $a ="last month ago";
                }else{
                  $a =$months ." months ago";
                }
              }
              //Years
              else{
                if($years==1){
                  $a= "1 year ago";
                }else{
                  $a =$years." years ago";
                } 
              }
               
              
            
                  
                    ?>
                                  <div class="msg-time-chat">
                                      <!--<a class="message-img" href="#"><img alt="" src="img/chat-avatar.jpg" class="avatar"></a>-->
                    <a class="fa fa-bell-o" style="font-size:30px;color:red"></a>
                                      <div class="message-body msg-in">
                                          <span class="arrow"></span>
                                          <div class="text"style="margin-top: -30px;" >
                                              <p class="attribution"><a id="btn" href="#" value="<?php echo $get['coupon_id']; ?>" onclick="myfn(<?php echo $get['coupon_id']; ?>);"><?php echo $get['title']; ?></a> <?php echo $a ?>, <?php echo $created ?></p>
                                              <p><?php echo $get['message']; ?></p>
                                          </div>
                                      </div>
                                  </div>
                 <?php }
                  } else { ?>
                      
                                     
                                     <div>
                                          <div class="text"style="margin-top: 10px;" >
                                              <h2 style='text-align: center;'>No Notification Available</h2>
                                          </div>
                                     
                                  </div>
                                <?php } ?>
                                  <!-- /comment -->

                                  
                                  <!-- /comment -->
                              </div>
                             
                          </div>
                      </section>
                  </div>
              </div>
       <form method='POST' action="<?php echo base_url();?>create_coupon" id="myform">
       <input name="id" value="" id="id" type="hidden">
       </form>
                      </div>
                  </div>
              </section>
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->



      <!--footer start-->
       <?php
   include "includes/footer.php";
   ?>
      <!--footer end-->
  </section>
 <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.countdown.min.js"></script>
  
   <script>
     $(function(){
        
      $('.countdown').each(function(){
        $a=$(this).attr('value');
        //alert($a);
        $(this).countdown($(this).attr('value'), function(event) {
        $(this).text(
        event.strftime('%D %H:%M:%S')
        );
        });
      });
    });
     </script>

    <!-- js placed at the end of the document so the pages load faster -->
  <!-- <script>
          jQuery(document).ready(function() {
              EditableTable.init();
          });
      
      function myfn(id)
      {
        var id = id;
        $('#id').val(id);
        document.getElementById("myform").submit();
      
      }
      </script>-->
  </body>
</html>

