<?php
   include "includes/header.php";
   ?>
<style>
   .blink-one {
   animation: blinker-one 1s linear infinite;
   }
   @keyframes blinker-one {  
   0% { opacity: 0; }
   }
</style>
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
         <section class="wrapper">
            <!-- page start-->
            <div class="row">
               <div class="col-lg-12">
                  <h3 class="left">Pending Dispatches</h3>
                  <div class="row">
                     <div class="col-lg-12">
                        <!--widget start-->
                        <section class="panel">
                           <div class="panel-body">
                              <div class="adv-table">
                                 <table  class="display table table-bordered table-striped abc" id="dynamic-table">
                                    <thead>
                                       <tr>
                                          <th class="width-150">Dispatch Date</th>
                                          <th class="width-80">Order ID</th>
                                          <th class="width-80">SC</th>
                                          <th class="width-150">Item Code</th>
                                          <th class="width-250">Description</th>
                                          <th class="width-200">Route</th>
                                          <th class="width-200">Quantity to ship</th>
                                          <th class="width-150">Customer Name</th>
                                          <th class="width-150">Shipment Name</th>
                                          <th class="width-200">Transporter Name</th>
                                          <th class="width-200">Assigned By</th>
                                          <th class="width-250">status</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php 
                                          // print_r($data); die;
                                          if(!empty($all_not_accept))
                                          {	
                                           foreach ($all_not_accept as $get)
                                           {

                                             $this->db->select('*');
                                             $this->db->from('dbo.attn_required');
                                             $this->db->where('order_id', $value1['order_id']);
                                             $result= $this->db->get()->result_array();

                                             if ($get['ocs_status'] == 'Bid') {
                                             if ($get['order_status'] == 'Pending' && $get['ocs_status'] == 'Bid') {
                                                $this->db->select('*');
                                                $this->db->from('dbo.settings');
                                                $data1 = $this->db->get()->result_array();
                                                $time  = "00:00:00";
                                                foreach ($data1 as $get1) {
                                                    $bid_hours                   = $get1['assign_bidding_hours'];
                                                    $assign_bidding_hours_second = $get1['assign_bidding_hours_second'];
                                                    //echo $bid_hours;
                                                }
                                                $delivery_date = $get['delivery_date'];
                                                $acutal_date   = $delivery_date . " " . $time;
                                                if ($bid_hours < 0) {
                                                    $hours       = (-$bid_hours);
                                                    //echo $hours;
                                                    $bid_newdate = date("Y-m-d H:i:s", strtotime('+' . $hours . ' hours', strtotime($acutal_date)));
                                                } else {
                                                    $bid_newdate = strtotime('-' . $bid_hours . ' hour', strtotime($acutal_date));
                                                    $bid_newdate = date('Y-m-d H:i:s', $bid_newdate);
                                                }
                                                if ($assign_bidding_hours_second < 0) {
                                                    $hours              = (-$assign_bidding_hours_second);
                                                    //echo $hours;
                                                    $bid_newdate_second = date("Y-m-d H:i:s", strtotime('+' . $hours . ' hours', strtotime($acutal_date)));
                                                } else {
                                                    $bid_newdate1       = strtotime('-' . $assign_bidding_hours_second . ' hour', strtotime($acutal_date));
                                                    $bid_newdate_second = date('Y-m-d H:i:s', $bid_newdate1);
                                                }
                                            }
                                            $current_date = date("Y-m-d H:i:s");
                                            if ((strtotime($current_date) >= strtotime($bid_newdate)) OR $result) {
                                            }
                                            $items        = explode(',', $get['item_code']);
                                            $descriptions = explode(',', $get['description']);
                                            $quantity     = explode(',', $get['qty_to_ship']);
                                            $route        = explode(',', $get['route']);
                                            $order_status = $get['order_status'];
                                            $attn_reason  = $get['reason'];
                                            //print_r($attn_reason);
                                            /* foreach($quantity as $qty_key => $qty) { */
                                            if (array_fill(0, count($quantity), '0') === array_values($quantity)) {
                                            } else {
                                                $arr    = explode(' ', trim($attn_reason));
                                                $reject = $arr[0];
                                                if ($reject != 'Not') {
                                                    if ($get['order_status'] != 'Inprocess') {
																								 $qty_to_ship = explode(',', $get['qty_to_ship']);
                                          $item_code = explode(',', $get['item_code']);
                                          $description = explode(',', $get['description']);
                                          $planned_delivery_date = explode(',', $get['planned_delivery_date']);
                                          $route = explode(',', $get['route']);
                                          $attn_reason = $get['reason'];
                                          $state_code = $get['state_code'];
                                          $company = $get['company'];
                                                                            ?>
                                       <tr>
                                          <td> <?php echo date('d-m-Y',strtotime($get['delivery_date'])) ?></td>
                                          <td><strong><a href='<?php echo base_url();?>index.php/admin/order_view?id=<?php echo $get['order_id']?>'><?php echo $get['order_id']?></a></strong><br>
                                             <?php echo $get['company']?>
                                          </td>
                                          <td> <?php echo $get['state_code'] ?></td>
                                          <td><?php
                                             foreach($qty_to_ship as $qty_key => $qty) {
                                             if ($qty > '0')
                                             {
                                             if (array_key_exists($qty_key, $item_code)) {
                                                  print($item_code[$qty_key].'<br>');   
                                             }}}
                                             ?></td>
                                          <td><?php foreach($qty_to_ship as $qty_key => $qty) {
                                             if ($qty > '0')
                                             {
                                             if (array_key_exists($qty_key, $description)) {
                                                    print($description[$qty_key].'<br>');   
                                             }}} ?></td>
                                          <td><?php foreach($qty_to_ship as $qty_key => $qty) {
                                             if ($qty > '0')
                                             {
                                             if (array_key_exists($qty_key, $route)) {
                                                    print($route[$qty_key].'<br>');   
                                             }}} ?></td>
                                          <td><?php foreach($qty_to_ship as $qty_key => $qty) {
                                             if ($qty > '0')
                                             {
                                             
                                                    print($qty.'<br>');   
                                             }}?></td>
                                          <td><?php echo $get['cust_name']?></td>
                                          <td><?php echo $get['ship_to_name']?></td>
                                          <td><?php echo $get['trans_name']?></td>
                                          <td><?php echo $get['ocs_status']?></td>
                                          <?php if($get['sales_status']=='Reopened') { ?>
                                          <td class=''>
                                             <a class='btn btn-danger blink-one width-150'>
                                                <?php echo $get['sales_status']?> </button>
                                          </td>
                                          <?php } else if($get['sales_status']=='Released') {?>
                                          <?php if($get['order_status']=='') { ?>
                                          <td style='background-color:#27313b;color:white ; text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Awaiting for acceptance <br>
                                          <h4><strong >[ <span class='countdown' value='<?php echo $newdate ?>'></span> ]</strong></h4>
                                          <?php } else if($get['order_status']=='Pending' && $get['ocs_status']=='Bid' ) {
                                             if(strtotime($current_date) >= strtotime($bid_newdate))
                                             {
                                             ?>
                                          <td style='background-color:green;color:white;text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Time Left for Assign order<br>
                                          <h4><strong>[ <span class='countdown' value='<?php echo $bid_newdate_second ?>'></span> ]</strong></h4>
                                          </td><?php } else { ?>
                                          <td style='background-color:green;color:white;text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Time Left for Assign order<br>
                                          <h4><strong>[ <span class='countdown' value='<?php echo $bid_newdate ?>'></span> ]</strong></h4>
                                          </td>
                                          <?php }} ?>
                                          <!--<span class='countdown' value='<?php echo $newdate ?>'></span><br />-->
                                          <!--<div id='time'>
                                             <span class="strclock" style="font-weight:bold;font-size:1.2em;"></span></div>-->
                                          <!--<td><span class='countdown' value='<?php echo $newdate ?>'></span></td>-->
                                       </tr>
                                       <?php
                                          }
                                          }
                                          }
                                          }
                                          }										
                                          
                                          else {
                                          // print_r($all_not_accept);
                                          
                                          if($get['order_status']=='')
                                          {
                                          
                                          $this->db->select('*');
                                          $this->db->from('dbo.settings');
                                          $data= $this->db->get()->result_array(); 
                                          
                                          $time = "00:00:00";
                                          foreach($data as $get1)
                                          {
                                          $allowance_hours=$get1['allowance_hours'];
                                          }
                                          
                                          $delivery_date=$get['delivery_date'];
                                          $acutal_date = $delivery_date." ".$time;
                                          if($allowance_hours<0)
                                          {
                                          $hours=(-$allowance_hours);
                                          
                                          $newdate = date("Y-m-d H:i:s", strtotime('+'.$hours.' hours', strtotime($acutal_date)));
                                          
                                          }
                                          else{
                                          
                                          
                                          /* echo $acutal_date;  */
                                          $newdate = strtotime ( '-'.$allowance_hours.' hour' , strtotime ($acutal_date ) ) ;
                                          
                                          $newdate = date ( 'Y-m-d H:i:s' , $newdate );
                                          }
                                          }
                                          else if ($get['order_status']=='Pending' && $get['ocs_status'] == 'Admin')
                                          {
                                          
                                          $this->db->select('*');
                                          $this->db->from('dbo.settings');
                                          $data= $this->db->get()->result_array(); 
                                          
                                          $time = "00:00:00";
                                          foreach($data as $get1)
                                          {
                                          $assign_hours=$get1['assign_hours'];
                                          }
                                          
                                          $delivery_date=$get['delivery_date'];
                                          $acutal_date = $delivery_date." ".$time;
                                          if($assign_hours<0)
                                          {
                                          $hours=(-$assign_hours);
                                          
                                          $newdate = date("Y-m-d H:i:s", strtotime('+'.$hours.' hours', strtotime($acutal_date)));
                                          
                                          }
                                          else{
                                          
                                          
                                          /* echo $acutal_date;  */
                                          $newdate = strtotime ( '-'.$assign_hours.' hour' , strtotime ($acutal_date ) ) ;
                                          
                                          $newdate = date ( 'Y-m-d H:i:s' , $newdate );
                                          }  
                                          }
                                          
                                          
                                          
                                          
                                          error_reporting(0);
                                          $tz_object = new DateTimeZone('Asia/Kolkata');
                                          $datetime = new DateTime();
                                          $datetime->setTimezone($tz_object);
                                          $yt= $datetime->format('Y');
                                          $mt= $datetime->format('m');
                                          $dt= $datetime->format('d');
                                          $hours= $datetime->format('H');
                                          $minutes= $datetime->format('i');
                                          $seconds= $datetime->format('s');
                                          $now = $yt."-".$mt."-".$dt." ".$hours.":".$minutes.":".$seconds;
                                          $time1 = strtotime($now);
                                          $time2 = strtotime($newdate);
                                          $diffdhg = $time2-$time1;
                                          gmdate("d H:i:s",$diffdhg);
                                          $days = $diffdhg / 86400;
                                          $day_explode = explode(".", $days);
                                          $d = $day_explode[0];
                                          $hours = '.'.$day_explode[1].'';
                                          $hour = $hours * 24;
                                          $hourr = explode(".", $hour);
                                          $h = $hourr[0];
                                          $minute = '.'.$hourr[1].'';
                                          $minutes = $minute * 60;
                                          $minute = explode(".", $minutes);
                                          $m = $minute[0];
                                          $seconds = '.'.$minute[1].'';
                                          $second = $seconds * 60;
                                          $s = round($second);
                                          $timer= $d.":"."$h".":".$m.":".$s;
                                          //print_r($timer);
                                          if($d<'0' || $d === '-0')
                                          {
                                          if($get['order_status']=='')
                                          {
                                          /********attn required****/
                                          $this->db->select('*');
                                          $this->db->from('dbo.attn_required');
                                          $this->db->where('order_id', $get['order_id']);
                                          $this->db->where('reason', 'Not accepted in given time frame by vendor');
                                          $res= $this->db->get()->result_array(); 
                                          foreach($res as $get_data)
                                          {
                                          $id=$get_data['id'];
                                          $customer_no=$get_data['customer_no'];
                                          $order_id=$get_data['order_id'];
                                          $transporter_no=$get_data['transporter_no'];
                                          $delivery_date=$get_data['delivery_date'];
                                          $reason=$get_data['reason'];
                                          $global_id1=$get_data['global_id'];
                                          }
                                          if($order_id==$get['order_id'])
                                          {
                                          $update=array(
                                          'order_id' => $order_id,
                                          'global_id' => $global_id1,
                                          'customer_no' => $customer_no,
                                          'transporter_no' => $transporter_no,
                                          'reason' => $reason,
                                          'delivery_date' => $delivery_date,
                                          );
                                          
                                          $this->db->where('order_id', $order_id);
                                          $this->db->where('reason', 'Not accepted in given time frame by vendor');
                                          $data=$this->db->update('dbo.attn_required', $update);
                                          }
                                          else{
                                          $save=array(
                                          'order_id' => $get['order_id'],
                                          'global_id' => $get['global_id'],
                                          'customer_no' => $get['cust_no'],
                                          'transporter_no' => $get['trans_no'], 
                                          'delivery_date' => $get['delivery_date'], 
                                          'reason' => 'Not accepted in given time frame by vendor',
                                          );
                                          $data=$this->db->insert('dbo.attn_required', $save);

                                           $this->load->model('notification_save');
                                                     $sender='transporter';
                                             $receiver='admin';
                                             $result = $this->notification_save->save_notification_all($order_id,'order_not_accept',$sender,$receiver);
                                          }
                                          /********end attn required****/
                                          /********missed orders****/
                                          $this->db->select('*');
                                          $this->db->from('dbo.missed_orders');
                                          $this->db->where('order_id', $get['order_id']);
                                          $this->db->where('reason', 'Not accepted in given time frame by vendor');
                                          $res1= $this->db->get()->result_array(); 
                                          foreach($res1 as $get_data1)
                                          {
                                          $id=$get_data1['id'];
                                          $customer_no=$get_data1['customer_no'];
                                          $order_id1=$get_data1['order_id'];
                                          $global_id1=$get_data1['global_id'];
                                          $transporter_no=$get_data1['transporter_no'];
                                          $delivery_date=$get_data1['delivery_date'];
                                          $reason=$get_data1['reason'];
                                          }
                                          if($order_id1==$get['order_id'])
                                          {
                                          
                                          $update=array(
                                          'order_id' => $order_id,
                                          'global_id' => $global_id1,
                                          'customer_no' => $customer_no,
                                          'transporter_no' => $transporter_no,
                                          'reason' => $reason,
                                          'delivery_date' => $delivery_date,
                                          );
                                          
                                          $this->db->where('order_id', $order_id1);
                                          $this->db->where('reason', 'Not accepted in given time frame by vendor');
                                          $data=$this->db->update('dbo.missed_orders', $update);
                                          }
                                          else{
                                          
                                          $save=array(
                                          'order_id' => $get['order_id'],
                                          'global_id' => $get['global_id'],
                                          'customer_no' => $get['cust_no'],
                                          'transporter_no' => $get['trans_no'], 
                                          'delivery_date' => $get['delivery_date'], 
                                          'reason' => 'Not accepted in given time frame by vendor',
                                          );
                                          $data=$this->db->insert('dbo.missed_orders', $save);
                                          
                                          
                                          }
                                          /********end missed orders****/
                                          }
                                          else if ($get['order_status']=='Pending' && $get['ocs_status']=='Admin')
                                          {
                                          /********attn required****/
                                          $this->db->select('*');
                                          $this->db->from('dbo.attn_required');
                                          $this->db->where('order_id', $get['order_id']);
                                          $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                          $res= $this->db->get()->result_array(); 
                                          foreach($res as $get_data)
                                          {
                                          $id=$get_data['id'];
                                          $customer_no=$get_data['customer_no'];
                                          $order_id=$get_data['order_id'];
                                          $transporter_no=$get_data['transporter_no'];
                                          $delivery_date=$get_data['delivery_date'];
                                          $reason=$get_data['reason'];
                                          $global_id1=$get_data['global_id'];
                                          }
                                          if($order_id==$get['order_id'])
                                          {
                                          $update=array(
                                          'order_id' => $order_id,
                                          'global_id' => $global_id1,
                                          'customer_no' => $customer_no,
                                          'transporter_no' => $transporter_no,
                                          'reason' => $reason,
                                          'delivery_date' => $delivery_date,
                                          );
                                          
                                          $this->db->where('order_id', $order_id);
                                          $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                          $data=$this->db->update('dbo.attn_required', $update);
                                          $this->load->model('notification_save');
                                                     $sender='transporter';
                                             $receiver='admin';
                                             $result = $this->notification_save->save_notification_all($order_id,'order_not_assign',$sender,$receiver);
                                          
                                          }
                                          else{
                                          $save=array(
                                          'order_id' => $get['order_id'],
                                          'global_id' => $get['global_id'],
                                          'customer_no' => $get['cust_no'],
                                          'transporter_no' => $get['trans_no'], 
                                          'delivery_date' => $get['delivery_date'], 
                                          'reason' => 'Not assigned in given time frame by vendor',
                                          );
                                          $data=$this->db->insert('dbo.attn_required', $save);
                                          $this->db->where('order_id', $order_id);
                                          $query1 = $this->db->delete('dbo.order_details');
                                          }
                                          /********end attn required****/
                                          /********missed orders****/
                                          $this->db->select('*');
                                          $this->db->from('dbo.missed_orders');
                                          $this->db->where('order_id', $get['order_id']);
                                          $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                          $res1= $this->db->get()->result_array(); 
                                          foreach($res1 as $get_data1)
                                          {
                                          $id=$get_data1['id'];
                                          $customer_no=$get_data1['customer_no'];
                                          $order_id1=$get_data1['order_id'];
                                          $global_id1=$get_data1['global_id'];
                                          $transporter_no=$get_data1['transporter_no'];
                                          $delivery_date=$get_data1['delivery_date'];
                                          $reason=$get_data1['reason'];
                                          }
                                          if($order_id1==$get['order_id'])
                                          {
                                          $update=array(
                                          'order_id' => $order_id,
                                          'global_id' => $global_id1,
                                          'customer_no' => $customer_no,
                                          'transporter_no' => $transporter_no,
                                          'reason' => $reason,
                                          'delivery_date' => $delivery_date,
                                          );
                                          
                                          $this->db->where('order_id', $order_id1);
                                          $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                          $data=$this->db->update('dbo.missed_orders', $update);
                                          
                                          }
                                          else{
                                          $save=array(
                                          'order_id' => $get['order_id'],
                                          'global_id' => $get['global_id'],
                                          'customer_no' => $get['cust_no'],
                                          'transporter_no' => $get['trans_no'], 
                                          'delivery_date' => $get['delivery_date'], 
                                          'reason' => 'Not assigned in given time frame by vendor',
                                          );
                                          $data=$this->db->insert('dbo.missed_orders', $save);
                                          
                                          }
                                          }
                                          
                                          }
                                          else{
                                          
                                          $qty_to_ship = explode(',', $get['qty_to_ship']);
                                          $item_code = explode(',', $get['item_code']);
                                          $description = explode(',', $get['description']);
                                          $planned_delivery_date = explode(',', $get['planned_delivery_date']);
                                          $route = explode(',', $get['route']);
                                          $attn_reason = $get['reason'];
                                          $state_code = $get['state_code'];
                                          $company = $get['company'];
                                          /* 									foreach($qty_to_ship as $qty_key => $qty) { */
                                          if(array_fill(0,count($qty_to_ship),'0') === array_values($qty_to_ship)){
                                          
                                          }
                                          else{
                                          $arr = explode(' ',trim($attn_reason));
                                          $reject= $arr[0];
                                          if($reject!='Rejected')
                                          {
                                          
                                          if($get['order_status']!='Inprocess')
                                          {
                                          
                                          ?>
                                       <tr>
                                       <td> <?php echo date('d-m-Y',strtotime($get['delivery_date'])) ?><strong></td>
                                       <td><strong><a href='<?php echo base_url();?>index.php/admin/order_view?id=<?php echo $get['order_id']?>'><?php echo $get['order_id']?></a></strong><br>
                                       <?php echo $get['company']?>
                                       </td>
                                       <td> <?php echo $get['state_code'] ?></td>
                                       <td><?php
                                          foreach($qty_to_ship as $qty_key => $qty) {
                                          if ($qty > '0')
                                          {
                                          if (array_key_exists($qty_key, $item_code)) {
                                               print($item_code[$qty_key].'<br>');   
                                          }}}
                                          ?></td>
                                       <td><?php foreach($qty_to_ship as $qty_key => $qty) {
                                          if ($qty > '0')
                                          {
                                          if (array_key_exists($qty_key, $description)) {
                                                 print($description[$qty_key].'<br>');   
                                          }}} ?></td>
                                       <td><?php foreach($qty_to_ship as $qty_key => $qty) {
                                          if ($qty > '0')
                                          {
                                          if (array_key_exists($qty_key, $route)) {
                                                 print($route[$qty_key].'<br>');   
                                          }}} ?></td>
                                       <td><?php foreach($qty_to_ship as $qty_key => $qty) {
                                          if ($qty > '0')
                                          {
                                          
                                                 print($qty.'<br>');   
                                          }}?></td>
                                       <td><?php echo $get['cust_name']?></td>
                                       <td><?php echo $get['ship_to_name']?></td>
                                       <td><?php echo $get['trans_name']?></td>
                                       <td>
                                       <?php 
                                          if($get['ocs_status']=='' OR  $get['ocs_status']=='Admin')
                                          {
                                           echo 'Admin';
                                          }
                                          else
                                          {
                                               echo $get['ocs_status'];
                                           } ?>
                                       </td>
                                       <?php if($get['sales_status']=='Reopened') { ?>
                                       <td class=''><a class='btn btn-danger blink-one width-150'><?php echo $get['sales_status']?> </button></td>
                                       <?php } else if($get['sales_status']=='Released') {?>
                                       <?php if($get['order_status']=='') { ?>
                                       <td style='background-color:#27313b;color:white ; text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Awaiting for acceptance <br>
                                       <h4><strong >[ <span class='countdown' value='<?php echo $newdate ?>'></span> ]</strong></h4></td>
                                       <?php }  else if($get['order_status']=='Pending') { ?>
                                       <td style='background-color:green;color:white;text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Awaiting for Assign order<br>
                                       <h4><strong>[ <span class='countdown' value='<?php echo $newdate ?>'></span> ]</strong></h4>
                                       </td>
                                       <?php }} ?>
                                       </tr>
                                       <?php } }}}}
                                          }
                                          }
                                          else
                                          {
                                          ?>
                                       <tr class='text-center'>
                                          <td><?php echo "No Data Available";?></td>
                                       </tr>
                                       <?php							
                                          }
                                          ?>
                                    </tbody>
                                    <tfoot>
                                       <th class="width-150">Dispatch Date</th>
                                       <th class="width-80">Order ID</th>
                                       <th class="width-80">SC</th>
                                       <th class="width-150">Item Code</th>
                                       <th class="width-250">Description</th>
                                       <th class="width-200">Route</th>
                                       <th class="width-200">Quantity to ship</th>
                                       <th class="width-150">Customer Name</th>
                                       <th class="width-150">Shipment Name</th>
                                       <th class="width-200">Transporter Name</th>
                                       <th class="width-200">status</th>
                                    </tfoot>
                                 </table>
                              </div>
                           </div>
                        </section>
                     </div>
                  </div>
         </section>
         <!--widget end-->
         </div>
         </div>
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
   <script>
      $(document).ready(function(){
      $("#dynamic-table").dataTable();
             $( "#dynamic-table tbody tr td h4 strong span" ).on( "click", function() {
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
      });
      
      });
      
      
           
   </script>
   <!-- js placed at the end of the document so the pages load faster -->
</body>
</html>