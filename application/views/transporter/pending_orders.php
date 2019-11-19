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
      <!--sidebar start-->
      <?php
         include "includes/transporter_sidebar.php";
         $user_id   = $this->session->userdata('user_id');
         $global_id = $this->session->userdata('global_id');
         ?>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
         <section class="wrapper">
            <!-- page start-->
            <div class="row">
               <div class="col-lg-12">
                  <h3 class="left">Pending Orders</h3>
                  <br/>
                  <a class="left">Orders pending for acceptance and assignment.</a>
                  <div class="row">
                     <div class="col-lg-12">
                        <!--widget start-->
                        <?php
                           if (($this->session->flashdata('item'))) {
                               $message = $this->session->flashdata('item');
                           ?>
                        <div id="mess" class="<?php
                           echo $message['class'];
                           ?>"><?php
                           echo $message['message'];
                           ?></div>
                        <?php
                           } else {
                           }
                           ?>
                        <section class="panel">
                           <div class="panel-body">
                              <div class="adv-table">
                                 <table  class="display table table-bordered table-striped" id="dynamic-table">
                                    <thead>
                                       <tr>
                                          <th class="width-80">Order ID</th>
                                          <th class="width-50">SC</th>
                                          <th class="width-200">Item Code</th>
                                          <th class="width-250">Description</th>
                                          <th class="width-100">Quantity</th>
                                          <th class="width-250">Route</th>
                                          <th class="width-150">Dispatch Date</th>
                                          <th class="width-170">Time Left</th>
                                          <th class="width-210">Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                          foreach ($awarded_orders as $value1) {
                                              date_default_timezone_set("Asia/Calcutta");
                                                            $this->db->select('*');
                                                            $this->db->from('dbo.attn_required');
                                                            $this->db->where('order_id', $value1['order_id']);
                                                          $result= $this->db->get()->result_array();
                                              /****bid assign order******/
                                              if ($value1['ocs_status'] == 'Bid') {
                                                  if ($value1['order_status'] == 'Pending' && $value1['ocs_status'] == 'Bid') {
                                                      $this->db->select('*');
                                                      $this->db->from('dbo.settings');
                                                      $data1 = $this->db->get()->result_array();
                                                      $time  = "00:00:00";
                                                      foreach ($data1 as $get1) {
                                                          $bid_hours                   = $get1['assign_bidding_hours'];
                                                          $assign_bidding_hours_second = $get1['assign_bidding_hours_second'];
                                                          //echo $bid_hours;
                                                      }
                                                      $delivery_date = $value1['delivery_date'];
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
                                                  if ((strtotime($current_date) >= strtotime($bid_newdate))  OR $result) {
                                                  }
                                                  $items        = explode(',', $value1['item_code']);
                                                  $descriptions = explode(',', $value1['description']);
                                                  $quantity     = explode(',', $value1['qty_to_ship']);
                                                  $route        = explode(',', $value1['route']);
                                                  $order_status = $value1['order_status'];
                                                  $attn_reason  = $value1['reason'];
                                                  //print_r($attn_reason);
                                                  /* foreach($quantity as $qty_key => $qty) { */
                                                  if (array_fill(0, count($quantity), '0') === array_values($quantity)) {
                                                  } else {
                                                      $arr    = explode(' ', trim($attn_reason));
                                                      $reject = $arr[0];
                                                      if ($reject != 'Not') {
                                                          if ($value1['order_status'] != 'Inprocess') {
                                          ?>
                                       <tr>
                                          <td><strong><a href='<?php
                                             echo base_url();
                                             ?>index.php/transporter/order_view?id=<?php
                                             echo $value1['order_id'];
                                             ?>'><?php
                                             echo $value1['order_id'];
                                             ?></a></strong><br>
                                             <?php
                                                echo $value1['company'];
                                                ?>
                                          </td>
                                          <td><?php
                                             echo $value1['state_code'];
                                             ?></td>
                                          <td><?php
                                             foreach ($quantity as $qty_key => $qty) {
                                                 if ($qty > '0') {
                                                     if (array_key_exists($qty_key, $items)) {
                                                         print($items[$qty_key] . '<br>');
                                                     }
                                                 }
                                             }
                                             ?></td>
                                          <td><?php
                                             foreach ($quantity as $qty_key => $qty) {
                                                 if ($qty > '0') {
                                                     if (array_key_exists($qty_key, $descriptions)) {
                                                         print($descriptions[$qty_key] . '<br>');
                                                     }
                                                 }
                                             }
                                             ?></td>
                                          <td><?php
                                             foreach ($quantity as $qty_key => $qty) {
                                                 if ($qty > '0') {
                                                     if (array_key_exists($qty_key, $quantity)) {
                                                         print($quantity[$qty_key] . '<br>');
                                                     }
                                                 }
                                             }
                                             ?></td>
                                          <td><?php
                                             foreach ($quantity as $qty_key => $qty) {
                                                 if ($qty > '0') {
                                                     if (array_key_exists($qty_key, $route)) {
                                                         print($route[$qty_key] . '<br>');
                                                     }
                                                 }
                                             }
                                             ?></td>
                                          <td> <?php
                                             echo date('d-m-Y', strtotime($value1['delivery_date']));
                                             ?></td>
                                          <?php
                                             if ($value1['order_status'] == '') {
                                             ?>
                                          <td style='background-color:#27313b;color:white ; text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>
                                             Time left for acceptance <br>
                                             <h4><strong >[ <span class='countdown' value='<?php
                                                echo $newdate;
                                                ?>'></span> ]</strong></h4>
                                          </td>
                                          <?php
                                             } else if ($value1['order_status'] == 'Pending' && $value1['ocs_status'] == 'Admin') {
                                             ?>
                                          <td style='background-color:green;color:white;text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>
                                             Time Left for Assign order<br>
                                             <h4><strong>[ <span class='countdown' value='<?php
                                                echo $newdate;
                                                ?>'></span> ]</strong></h4>
                                          </td>
                                          <?php
                                             } else if ($value1['order_status'] == 'Pending' && $value1['ocs_status'] == 'Bid') {
                                                 if (strtotime($current_date) >= strtotime($bid_newdate)) {
                                             ?>
                                          <td style='background-color:green;color:white;text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>
                                             Time Left for Assign order<br>
                                             <h4><strong>[ <span class='countdown' value='<?php
                                                echo $bid_newdate_second;
                                                ?>'></span> ]</strong></h4>
                                          </td>
                                          <?php
                                             } else {
                                             ?>
                                          <td style='background-color:green;color:white;text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>
                                             Time Left for Assign order<br>
                                             <h4><strong>[ <span class='countdown' value='<?php
                                                echo $bid_newdate;
                                                ?>'></span> ]</strong></h4>
                                          </td>
                                          <?php
                                             }
                                             }
                                             ?>
                                          <?php
                                             if ($value1['sales_status'] == 'Reopened') {
                                             ?>
                                          <td class=''>
                                             <a class='btn btn-danger blink-one width-150'>
                                                <?php
                                                   echo $value1['sales_status'];
                                                   ?> </button>
                                          </td>
                                          <?php
                                             } else if ($value1['sales_status'] == 'Released') {
                                             ?>
                                          <td>
                                          <?php
                                             if ($order_status == 'Pending') {
                                             ?> 
                                          <a class='btn btn-success btn-sm assign' data-toggle="modal" href="#myModal" name='<?php
                                             echo $value1['order_id'];
                                             ?>'>Assign Order</a>
                                          <?php
                                             } else {
                                             ?>    
                                          <a class="btn btn-danger accept" type="button" href="#confirmModal" data-toggle="modal" name='<?php
                                             echo $value1['order_id'];
                                             ?>'> Accept</a>
                                          <a class="btn btn-default reject" type="button" href="#confirmModal1" data-toggle="modal" name='<?php
                                             echo $value1['order_id'];
                                             ?>'> Reject</a>
                                          <!--<button class="btn btn-default" type="button">Reject</button>-->
                                          <?php
                                             }
                                             ?>
                                          <button data-content="Awarded From Bid" data-placement="left" data-trigger="hover" class="btn btn-success popovers btn-round"><i class="fa fa-legal"></i></button>
                                          </td>
                                          <?php
                                             }
                                             ?>
                                       </tr>
                                       <?php
                                          }
                                          }
                                          }
                                          } else {
                                            if ($value1['order_status'] == '') {
                                              $this->db->select('*');
                                              $this->db->from('dbo.settings');
                                              $data = $this->db->get()->result_array();
                                              $time = "00:00:00";
                                              foreach ($data as $get1) {
                                                $allowance_hours = $get1['allowance_hours'];
                                              }
                                              $delivery_date = $value1['delivery_date'];
                                              $acutal_date   = $delivery_date . " " . $time;
                                              if ($allowance_hours < 0) {
                                              $hours   = (-$allowance_hours);
                                              $newdate = date("Y-m-d H:i:s", strtotime('+' . $hours . ' hours', strtotime($acutal_date)));
                                              } else {
                                                /* echo $acutal_date;  */
                                                $newdate = strtotime('-' . $allowance_hours . ' hour', strtotime($acutal_date));
                                                $newdate = date('Y-m-d H:i:s', $newdate);
                                              }
                                            }
                                           else if ($value1['order_status'] == 'Pending' && $value1['ocs_status'] == 'Admin') {
                                              $this->db->select('*');
                                              $this->db->from('dbo.settings');
                                              $data = $this->db->get()->result_array();
                                              $time = "00:00:00";
                                              foreach ($data as $get1) {
                                              $assign_hours = $get1['assign_hours'];
                                              }
                                              $delivery_date = $value1['delivery_date'];
                                              $acutal_date   = $delivery_date . " " . $time;
                                              if ($assign_hours < 0) {
                                                $hours   = (-$assign_hours);
                                                $newdate = date("Y-m-d H:i:s", strtotime('+' . $hours . ' hours', strtotime($acutal_date)));
                                              } 
                                              else {
                                              /* echo $acutal_date;  */
                                                $newdate = strtotime('-' . $assign_hours . ' hour', strtotime($acutal_date));
                                                $newdate = date('Y-m-d H:i:s', $newdate);
                                              }
                                          }
                                          $current_date = date("Y-m-d H:i:s");
                                          if (strtotime($current_date) >= strtotime($newdate)) {
                                          if ($value1['order_status'] == '') {
                                          /********attn required****/
                                          // $this->db->select('*');
                                          // $this->db->from('dbo.attn_required');
                                          // $this->db->where('order_id', $value1['order_id']);
                                          // $this->db->where('reason', 'Not accepted in given time frame by vendor');
                                          // $res = $this->db->get()->result_array();
                                          // foreach ($res as $get_data) {
                                          //     $id             = $get_data['id'];
                                          //     $customer_no    = $get_data['customer_no'];
                                          //     $order_id       = $get_data['order_id'];
                                          //     $transporter_no = $get_data['transporter_no'];
                                          //     $delivery_date  = $get_data['delivery_date'];
                                          //     $reason         = $get_data['reason'];
                                          //     $global_id1     = $get_data['global_id'];
                                          // }
                                          // if ($order_id == $value1['order_id']) {
                                          //     $update = array(
                                          //         'order_id' => $order_id,
                                          //         'global_id' => $global_id1,
                                          //         'customer_no' => $customer_no,
                                          //         'transporter_no' => $transporter_no,
                                          //         'reason' => $reason,
                                          //         'delivery_date' => $delivery_date
                                          //     );
                                          //     $this->db->where('order_id', $order_id);
                                          //     $this->db->where('reason', 'Not accepted in given time frame by vendor');
                                          //     $data = $this->db->update('dbo.attn_required', $update);
                                          // } else {
                                          //     $save = array(
                                          //         'order_id' => $value1['order_id'],
                                          //         'global_id' => $global_id,
                                          //         'customer_no' => $value1['cust_no'],
                                          //         'transporter_no' => $value1['trans_no'],
                                          //         'delivery_date' => $value1['delivery_date'],
                                          //         'reason' => 'Not accepted in given time frame by vendor'
                                          //     );
                                          //     $data = $this->db->insert('dbo.attn_required', $save);
                                          //     $this->load->model('notification_save');
                                          //            $sender='transporter';
                                          //    $receiver='admin';
                                          //    $result = $this->notification_save->save_notification_all($order_id,'order_not_accept',$sender,$receiver);
                                          // }
                                          /********end attn required****/
                                          /********missed orders****/
                                          // $this->db->select('*');
                                          // $this->db->from('dbo.missed_orders');
                                          // $this->db->where('order_id', $value1['order_id']);
                                          // $this->db->where('reason', 'Not accepted in given time frame by vendor');
                                          // $res1 = $this->db->get()->result_array();
                                          // foreach ($res1 as $get_data1) {
                                          //     $id             = $get_data1['id'];
                                          //     $customer_no    = $get_data1['customer_no'];
                                          //     $order_id1      = $get_data1['order_id'];
                                          //     $global_id1     = $get_data1['global_id'];
                                          //     $transporter_no = $get_data1['transporter_no'];
                                          //     $delivery_date  = $get_data1['delivery_date'];
                                          //     $reason         = $get_data1['reason'];
                                          // }
                                          // if ($order_id1 == $value1['order_id']) {
                                          //     $update = array(
                                          //         'order_id' => $order_id1,
                                          //         'global_id' => $global_id1,
                                          //         'customer_no' => $customer_no,
                                          //         'transporter_no' => $transporter_no,
                                          //         'reason' => $reason,
                                          //         'delivery_date' => $delivery_date
                                          //     );
                                          //     $this->db->where('order_id', $order_id1);
                                          //     $this->db->where('reason', 'Not accepted in given time frame by vendor');
                                          //     $data = $this->db->update('dbo.missed_orders', $update);
                                          // } else {
                                          //     $save = array(
                                          //         'order_id' => $value1['order_id'],
                                          //         'global_id' => $global_id,
                                          //         'customer_no' => $value1['cust_no'],
                                          //         'transporter_no' => $value1['trans_no'],
                                          //         'delivery_date' => $value1['delivery_date'],
                                          //         'reason' => 'Not accepted in given time frame by vendor'
                                          //     );
                                          //     $data = $this->db->insert('dbo.missed_orders', $save);
                                          // }
                                          // /********end missed orders****/
                                          // } else if ($value1['order_status'] == 'Pending') {
                                          // /********attn required****/
                                          // $this->db->select('*');
                                          // $this->db->from('dbo.attn_required');
                                          // $this->db->where('order_id', $value1['order_id']);
                                          // $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                          // $res = $this->db->get()->result_array();
                                          // foreach ($res as $get_data) {
                                          //     $id             = $get_data['id'];
                                          //     $customer_no    = $get_data['customer_no'];
                                          //     $order_id       = $get_data['order_id'];
                                          //     $global_id1     = $get_data['global_id'];
                                          //     $transporter_no = $get_data['transporter_no'];
                                          //     $delivery_date  = $get_data['delivery_date'];
                                          //     $reason         = $get_data['reason'];
                                          // }
                                          // if ($order_id == $value1['order_id']) {
                                          //     $update = array(
                                          //         'order_id' => $order_id,
                                          //         'global_id' => $global_id1,
                                          //         'customer_no' => $customer_no,
                                          //         'transporter_no' => $transporter_no,
                                          //         'reason' => $reason,
                                          //         'delivery_date' => $delivery_date
                                          //     );
                                          //     $this->db->where('order_id', $order_id);
                                          //     $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                          //     $data = $this->db->update('dbo.attn_required', $update);
                                          // } else {
                                          //     $save = array(
                                          //         'order_id' => $value1['order_id'],
                                          //         'global_id' => $global_id,
                                          //         'customer_no' => $value1['cust_no'],
                                          //         'transporter_no' => $value1['trans_no'],
                                          //         'delivery_date' => $value1['delivery_date'],
                                          //         'reason' => 'Not assigned in given time frame by vendor'
                                          //     );
                                          //     $data = $this->db->insert('dbo.attn_required', $save);
                                          //     $this->db->where('order_id', $order_id);
                                          //     $query1 = $this->db->delete('dbo.order_details');

                                          //     $this->load->model('notification_save');
                                          //    $sender='transporter';
                                          //    $receiver='admin';
                                          //    $result = $this->notification_save->save_notification_all($order_id,'order_not_assign',$sender,$receiver);
                                          // }
                                          /********end attn required****/
                                          /********missed orders****/
                                          // $this->db->select('*');
                                          // $this->db->from('dbo.missed_orders');
                                          // $this->db->where('order_id', $value1['order_id']);
                                          // $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                          // $res1 = $this->db->get()->result_array();
                                          // foreach ($res1 as $get_data1) {
                                          //     $id             = $get_data1['id'];
                                          //     $customer_no    = $get_data1['customer_no'];
                                          //     $order_id1      = $get_data1['order_id'];
                                          //     $global_id1     = $get_data1['global_id'];
                                          //     $transporter_no = $get_data1['transporter_no'];
                                          //     $delivery_date  = $get_data1['delivery_date'];
                                          //     $reason         = $get_data1['reason'];
                                          // }
                                          // if ($order_id1 == $value1['order_id']) {
                                          //     $update = array(
                                          //         'order_id' => $order_id,
                                          //         'global_id' => $global_id1,
                                          //         'customer_no' => $customer_no,
                                          //         'transporter_no' => $transporter_no,
                                          //         'reason' => $reason,
                                          //         'delivery_date' => $delivery_date
                                          //     );
                                          //     $this->db->where('order_id', $order_id1);
                                          //     $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                          //     $data = $this->db->update('dbo.missed_orders', $update);
                                          // } else {
                                          //     $save = array(
                                          //         'order_id' => $value1['order_id'],
                                          //         'global_id' => $global_id,
                                          //         'customer_no' => $value1['cust_no'],
                                          //         'transporter_no' => $value1['trans_no'],
                                          //         'delivery_date' => $value1['delivery_date'],
                                          //         'reason' => 'Not assigned in given time frame by vendor'
                                          //     );
                                          //     $data = $this->db->insert('dbo.missed_orders', $save);
                                          // }
                                          }
                                          } else {
                                          //print_r($timer);
                                          $items                 = explode(',', $value1['item_code']);
                                          $descriptions          = explode(',', $value1['description']);
                                          $quantity              = explode(',', $value1['qty_to_ship']);
                                          $route                 = explode(',', $value1['route']);
                                          $planned_delivery_date = explode(',', $value1['planned_delivery_date']);
                                          $order_status          = $value1['order_status'];
                                          $attn_reason           = $value1['reason'];
                                          /* foreach($quantity as $qty_key => $qty) { */
                                          if (array_fill(0, count($quantity), '0') === array_values($quantity)) {
                                          //echo 'dsada';
                                          } else {
                                          $arr    = explode(' ', trim($attn_reason));
                                          $reject = $arr[0];
                                          if (!$reject == 'Rejected' or !$reject == 'Not') {
                                              if ($value1['order_status'] != 'Inprocess') {
                                          ?>
                                       <tr>
                                          <td><strong><a href='<?php
                                             echo base_url();
                                             ?>index.php/transporter/order_view?id=<?php
                                             echo $value1['order_id'];
                                             ?>'><?php
                                             echo $value1['order_id'];
                                             ?></a></strong><br>
                                             <?php
                                                echo $value1['company'];
                                                ?>
                                          </td>
                                          <td><?php
                                             echo $value1['state_code'];
                                             ?></td>
                                          <td><?php
                                             foreach ($quantity as $qty_key => $qty) {
                                                 if ($qty > '0') {
                                                     if (array_key_exists($qty_key, $items)) {
                                                         print($items[$qty_key] . '<br>');
                                                     }
                                                 }
                                             }
                                             ?></td>
                                          <td><?php
                                             foreach ($quantity as $qty_key => $qty) {
                                                 if ($qty > '0') {
                                                     if (array_key_exists($qty_key, $descriptions)) {
                                                         print($descriptions[$qty_key] . '<br>');
                                                     }
                                                 }
                                             }
                                             ?></td>
                                          <td><?php
                                             foreach ($quantity as $qty_key => $qty) {
                                                 if ($qty > '0') {
                                                     if (array_key_exists($qty_key, $quantity)) {
                                                         print($quantity[$qty_key] . '<br>');
                                                     }
                                                 }
                                             }
                                             ?></td>
                                          <td><?php
                                             foreach ($quantity as $qty_key => $qty) {
                                                 if ($qty > '0') {
                                                     if (array_key_exists($qty_key, $route)) {
                                                         print($route[$qty_key] . '<br>');
                                                     }
                                                 }
                                             }
                                             ?></td>
                                          <td> <?php
                                             echo date('d-m-Y', strtotime($value1['delivery_date']));
                                             ?></td>
                                          <?php
                                             if ($value1['order_status'] == '') {
                                             ?>
                                          <td style='background-color:#27313b;color:white ; text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>
                                             Time left for acceptance <br>
                                             <h4><strong >[ <span class='countdown' value='<?php
                                                echo $newdate;
                                                ?>'></span> ]</strong></h4>
                                          </td>
                                          <?php
                                             } else if ($value1['order_status'] == 'Pending') {
                                             ?>
                                          <td style='background-color:green;color:white;text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>
                                             Time Left for Assign order<br>
                                             <h4><strong>[ <span class='countdown' value='<?php
                                                echo $newdate;
                                                ?>'></span> ]</strong></h4>
                                          </td>
                                          <?php
                                             }
                                             ?>
                                          <?php
                                             if ($value1['sales_status'] == 'Reopened') {
                                             ?>
                                          <td class=''>
                                             <a class='btn btn-danger blink-one width-150'>
                                                <?php
                                                   echo $value1['sales_status'];
                                                   ?> </button>
                                          </td>
                                          <?php
                                             } else if ($value1['sales_status'] == 'Released') {
                                             ?>
                                          <td>
                                          <?php
                                             if ($order_status == 'Pending') {
                                             ?> 
                                          <a class='btn btn-success btn-sm assign' data-toggle="modal" href="#myModal" name='<?php
                                             echo $value1['order_id'];
                                             ?>'>Assign Order</a>
                                          <?php
                                             } else {
                                             ?>    
                                          <a class="btn btn-danger accept" type="button" href="#confirmModal" data-toggle="modal" name='<?php
                                             echo $value1['order_id'];
                                             ?>'> Accept</a>
                                          <a class="btn btn-default reject" type="button" href="#confirmModal1" data-toggle="modal" name='<?php
                                             echo $value1['order_id'];
                                             ?>'> Reject</a>
                                          <!--<button class="btn btn-default" type="button">Reject</button>-->
                                          <?php
                                             }
                                             ?>
                                          <button data-content="Assigned From Admin" data-placement="left" data-trigger="hover" class="btn btn-info right popovers btn-round"><i class="fa fa-user"></i></button>
                                          </td>
                                          <?php
                                             }
                                             ?>
                                       </tr>
                                       <?php
                                          }
                                          }
                                          }
                                          }
                                          }
                                          }
                                          ?>
                                    </tbody>
                                    <tfoot>
                                       <th>Order ID</th>
                                       <th class="width-50">SC</th>
                                       <th >Item Code</th>
                                       <th>Description</th>
                                       <th>Quantity</th>
                                       <th>route</th>
                                       <th>Dispatch Date</th>
                                       <th>Timer</th>
                                       <th>Action</th>
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
         </div>
         </div>
         <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                     <h4 class="modal-title">Assign Vehicle & Driver</h4>
                  </div>
                  <div class="modal-body">
                     <form action="<?php
                        echo base_url();
                        ?>index.php/transporter/assign_order" method="post" class='form-horizontal' enctype="multipart/form-data" >
                        <input type="hidden" name="order_id" value='' id='orderId'>
                        <div class="form-group">
                           <label class="col-lg-3 col-sm-2 control-label">Vehicle No.</label>
                           <div class="col-lg-8">
                              <select class="js-example-basic-single vehicle" id='vehicle' required name='vehicle_id'>
                                 <option value="0">Select vehicle</option>
                              </select>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="insurance" class="col-lg-3 col-sm-2 control-label">Insurance</label>
                           <div class="col-lg-8">
                              <input type="text" class="form-control" disabled readonly id="insurance" name='insurance_no' placeholder="Enter Insurance No">
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="insurance" class="col-lg-3 col-sm-2 control-label">GPS Availability</label>
                           <div class="col-md-3">
                              <div class="radio radio-info radio-inline">
                                 <input id="inlineRadio1" value="yes" name="gps_enabled[]" checked="" type="radio">
                                 <label for="inlineRadio1">Yes</label>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="radio radio-info radio-inline">
                                 <input id="inlineRadio2" value="no" name="gps_enabled[]" type="radio">
                                 <label for="inlineRadio2">No</label>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="col-lg-3 col-sm-2 control-label">Driver</label>
                           <div class="col-lg-8">
                              <select class="js-example-basic-single " id='driver' name='driver_id'>
                                 <option value="0">Select driver</option>
                                 <?php
                                    $this->db->select('*');
                                    $this->db->from('dbo.driver');
                                    $this->db->where('global_id', $global_id);
                                    $query = $this->db->get();
                                    $row   = $query->result_array();
                                    foreach ($row as $value) {
                                    ?>
                                 <option value="<?php
                                    echo $value['id'];
                                    ?>"><?php
                                    echo $value['name'];
                                    ?></option>
                                 <?php
                                    }
                                    ?>    
                              </select>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="mobile" class="col-lg-3 col-sm-2 control-label">Mobile</label>
                           <div class="col-lg-8">
                              <input type="text" class="form-control" required  disabled readonly id="mobile" name='mobile' placeholder="Enter Mobile">
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="license" class="col-lg-3 col-sm-2 control-label">License No.</label>
                           <div class="col-lg-8">
                              <input type="text" class="form-control" id="license" name='license_no' required readonly disabled placeholder="Enter License No">
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="lr_no" class="col-lg-3 col-sm-2 control-label">LR/RR No.</label>
                           <div class="col-lg-4">
                              <input type="text" class="form-control" id="lr_no" name='lr_rr_no' placeholder="Enter Number">
                           </div>
                           <div class="col-lg-4">
                              <input type="file" class="" id="lr" name='lr_rr_file'><br/>
                           </div>
                        </div>
                        <!--<div class="form-group">
                           <label for="eway_no" class="col-lg-3 col-sm-2 control-label">Eway No.</label>
                           <div class="col-lg-4">
                               <input type="text" class="form-control" required id="eway_no" name='eway_no' placeholder="Enter Number">
                           </div>
                           <div class="col-lg-4">
                               <input type="file" class="" id="eway" name="eway_file" ><br/>
                           </div>
                           </div>-->
                        <div class="form-group">
                           <label for="lr_rr_date" class="col-lg-3 col-sm-2 control-label">LR/RR Date.</label>
                           <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" class="input-append date dpYears col-lg-4">
                              <input type="text" readonly="" size="5" name="lr_rr_date" class="form-control">
                              <span class="input-group-btn add-on">
                              <button class="btn btn-danger" type="button"><i class="fa fa-calendar"></i></button>
                              </span>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="col-lg-offset-5 col-lg-2">
                              <button type="submit" class="btn btn-danger">Assign</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </section>
   <!--main content end-->
   <div class="modal modal-dialog-center fade" id="confirmModal">
      <div class="modal-dialog modal-sm">
         <div class="v-cell">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title">Confirmation</h4>
               </div>
               <div class="modal-body">
                  <form action="<?php
                     echo base_url();
                     ?>index.php/transporter/accept_order" method="post" enctype="multipart/form-data" >
                     <p>Are you sure you want to accept order assignment?</p>
                     <input type="hidden" value='' name='order_id' id='order_id'>
                     <div class="text-center">
                        <button type="submit" class="btn btn-success paper-shadow relative">Yes</button>
                        <button type="button" data-dismiss="modal" class="btn btn-danger paper-shadow relative no">No</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="modal modal-dialog-center fade" id="confirmModal1">
      <div class="modal-dialog modal-sm">
         <div class="v-cell">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title">Confirmation</h4>
               </div>
               <div class="modal-body">
                  <form action="<?php
                     echo base_url();
                     ?>index.php/transporter/reject_order" method="post" enctype="multipart/form-data" >
                     <p>Are you sure you want to reject order assignment?</p>
                     <input type="hidden" value='' name='order_id' id='order-id'>
                     <div class="form-group">
                        <div class="col-lg-12">
                           <select class="js-example-basic-single vehicle" id='reject_reason' required name='reject_reason'>
                              <option disabled value="0">Select Reason</option>
                              <?php
                                 $this->db->select('*');
                                 $this->db->from('dbo.reject_reason');
                                 $query = $this->db->get();
                                 $row   = $query->result_array();
                                 foreach ($row as $value) {
                                 ?>
                              <option value="<?php
                                 echo $value['reject_reason'];
                                 ?>"><?php
                                 echo $value['reject_reason'];
                                 ?></option>
                              <?php
                                 }
                                 ?>                                                                
                           </select>
                        </div>
                     </div>
                     <div class="text-center"><br><br>
                        <button type="submit" id='save' class="btn btn-success paper-shadow relative">Yes</button>
                        <button type="button" data-dismiss="modal" class="btn btn-danger paper-shadow relative no">No</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!--footer start-->
   <?php
      include "includes/footer.php";
      ?>
   <!--footer end-->
   </section>
   <script type="text/javascript">
      $(document).ready(function () {
          $(".js-example-basic-single").select2();
      
          $(".js-example-basic-multiple").select2();
      
        
        $('.accept').click(function() {
           $id = $(this).attr("name");
            $('#order_id').val($id);
        });
        
        $('.reject').click(function() {
           $id = $(this).attr("name");
            $('#order-id').val($id);
        });
      
         $('.assign').click(function() {
             
           $("#vehicle option").remove();
           $("#driver option").remove();
           $id = $(this).attr("name");
            $('#orderId').val($id);
            var id = $(this).val();
            $.ajax({
                 type:'POST',
                url:'<?php
         echo base_url();
         ?>index.php/transporter/get_vehicle',
                data:'id='+$id,
                success:function(result){
                    
                    var obj= jQuery.parseJSON(result);
                    /* alert(obj); */
                    if(obj){         
                      $('#vehicle').append("<option value=''>Select vehicle</option>");
                         $(obj).each(function(){       
                        var option = $('<option />'); 
                      //  option.attr({'selected':'selected'}).text('select vehicles');  
                        if(this.status=='disabled')
                        {
                            
                            option.attr({'value': this.id, 'disabled':this.status,'style':'background-color: gray'}).text(this.registration_no+'   TC('+this.tcapacity+'),'+'   RC('+this.rcapacity+')');  
                        
                             
                         }
                          else if(this.status=='enabled')    
                          {
                              option.attr({'value': this.id, 'enabled':this.status}).text(this.registration_no+'   TC('+this.tcapacity+'),'+'   RC('+this.rcapacity+')');
                        
                             
                          }
                          $('#vehicle').append(option);                               
                        });              
                     }
                    else{        
                        $('#vehicle').html('<option value="">Vehicle not available</option>');  
                    }   
               
             }});
             
             
             $.ajax({
                 type:'POST',
                url:'<?php
         echo base_url();
         ?>index.php/transporter/get_driver',
                data:'id='+$id,
                success:function(result){
                    
                    var obj= jQuery.parseJSON(result);
                    /* alert(obj); */
                    if(obj){         
                      $('#driver').append("<option value=''>Select Driver</option>");
                         $(obj).each(function(){       
                        var option = $('<option />'); 
                       // option.attr({'selected':'selected'}).text('select driver');  
                        if(this.status=='disabled')
                        {
                            
                            option.attr({'value': this.did, 'disabled':this.status}).text(this.name);  
                        
                              
                         }
                          else if(this.status=='enabled')    
                          {
                             option.attr({'value': this.did, 'enabled':this.status}).text(this.name);  
                        
                            
                          }  
                           $('#driver').append(option);                             
                        });              
                     }
                    else{        
                        $('#driver').html('<option value="">Driver not available</option>');  
                    }   
               
             }});
             
        });
        $('#driver').on('change',function(){
        
        var id = $(this).val();
        if(id){
        
            $.ajax({
                type:'POST',
                url:'<?php
         echo base_url();
         ?>index.php/transporter/get_driver_details',
                data:'id='+id,
                success:function(res){
                    /* alert(res); */
                    var obj= JSON.parse(res);
                    var mobile = obj.d[0].mobile;
                    var license = obj.d[0].license_no;
                    
                        document.getElementById('mobile').value = mobile;
                        document.getElementById('license').value = license;
                    
                    
                }
                }); 
            }
        });
        $('#vehicle').on('change',function(){
        
        var id = $(this).val();
        if(id){
        
            $.ajax({
                type:'POST',
                url:'<?php
         echo base_url();
         ?>index.php/transporter/get_vehicle_details',
                data:'id='+id,
                success:function(res){
                    /* alert(res); */
                    var obj= JSON.parse(res);
                    var insurance = obj.d[0].insurance;
                    
                        document.getElementById('insurance').value = insurance;
                    
                }
                }); 
            }
        });
      
      });
   </script>
   <script type="text/javascript" src="<?php
      echo base_url();
      ?>assets/js/jquery.countdown.min.js"></script>
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
</body>
</html>