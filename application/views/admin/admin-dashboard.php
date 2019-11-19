<!DOCTYPE html>
<?php
$access_role = array();
include "includes/header.php";
$access_role1 = $this->session->userdata('access_role');
$access_role = explode(',', $access_role1);
?>
<style>
    .blink-one {
        animation: blinker-one 1s linear infinite;
    }

    @keyframes blinker-one {
        0% {
            opacity: 0;
        }
    }

    .chart {
        border-radius: 10px;
        padding: 0 15px;
        position: relative;
        min-height: 200px;
        margin: 15px auto;
        width: 96%;
        box-sizing: border-box;
        background-color: #fff;
        overflow: hidden;
    }

    @media only screen and (min-width:601px) {
        #DonutTicketsByDepartment {
            width: 500px;
            float: left;
        }

        #TicketByDepartmentLegends {
            display: block;
            margin-left: 80%;
            list-style-type: none;
            padding-top: 0px !important;
        }

        .title {
            display: block;
            margin-right: 150px;
        }

        .author {
            float: left;
            width: 150px;
        }

        .lt {
            display: none;
        }
    }

    @media only screen and (max-width:600px) {
        .chart {
            text-align: center;
        }

        #DonutTicketsByDepartment {
            width: 500px;
            margin: 0 auto;
            float: none;
        }

        #TicketByDepartmentLegends {
            list-style-type: none;
            padding-top: 0px !important;
            margin: 0 auto;
            display: inline-block;
            text-align: right;
        }

        .title,
        .author {
            display: block;
            text-align: center;
        }

        .author {
            margin-top: 5px;
        }

        .lt {
            display: block;
        }

        .rt {
            display: none;
        }
    }

    #TicketByDepartmentLegends li {
        margin-bottom: 10px;
        font-family: 'Titillium Web', sans-serif;
        font-weight: 400;
        color: #000;
    }

    #TicketByDepartmentLegends li span.icon {
        width: 15px;
        height: 15px;
        float: left;
    }

    #TicketByDepartmentLegends li span.label {
        display: block;
        margin-left: 30px;
        font-size: 15px;
        line-height: 0;
        color: black;
        text-align: left;
    }

    .progress-circle {
        font-size: 21px;
        margin: 10px 10px;
        position: relative;
        /* so that children can be absolutely positioned */
        padding: 0;
        width: 5em;
        height: 5em;
        display: inline-block;
        border-radius: 50%;
        line-height: 5em;
    }

    .progress-circle.red {
        background-color: red;
    }

    .progress-circle.orange {
        background-color: orange;
    }

    .progress-circle.green {
        background-color: green;
    }

    .progress-circle:after {
        border: none;
        position: absolute;
        top: 0.35em;
        left: 0.35em;
        text-align: center;
        display: block;
        border-radius: 50%;
        width: 4.3em;
        height: 4.3em;
        background-color: white;
        content: " ";
    }

    /* Text inside the control */
    .progress-circle span.red {
        position: absolute;
        line-height: 4em;
        width: 5em;
        text-align: center;
        display: block;
        color: red;
        z-index: 2;
    }

    .progress-circle span.orange {
        position: absolute;
        line-height: 4em;
        width: 5em;
        text-align: center;
        display: block;
        color: orange;
        z-index: 2;
    }

    .progress-circle span.green {
        position: absolute;
        line-height: 4em;
        width: 5em;
        text-align: center;
        display: block;
        color: green;
        z-index: 2;
    }

    .left-half-clipper {
        /* a round circle */
        border-radius: 50%;
        width: 5em;
        height: 5em;
        position: absolute;
        /* needed for clipping */
        clip: rect(0, 5em, 5em, 2.5em);
        /* clips the whole left half*/
    }

    .right-half-clipper {
        margin-top: 65px;
        font-size: 15px;
        text-align: center !important;
    }

    /* when p>50, don't clip left half*/
    .value-bar {
        /*This is an overlayed square, that is made round with the border radius,
   then it is cut to display only the left half, then rotated clockwise
   to escape the outer clipping path.*/
        position: absolute;
        /*needed for clipping*/
        clip: rect(0, 2.5em, 5em, 0);
        width: 5em;
        height: 5em;
        border-radius: 50%;
        border: 0.45em solid #dcdcdc;
        /*The border is 0.35 but making it larger removes visual artifacts */
        /*background-color: #4D642D;*/
        /* for debug */
        box-sizing: border-box;
    }

    /* Progress bar filling the whole right half for values above 50% */
    .progress-circle.over50 .first50-bar {
        /*Progress bar for the first 50%, filling the whole right half*/
        position: absolute;
        /*needed for clipping*/
        clip: rect(0, 5em, 5em, 2.5em);
        background-color: #53777A;
        border-radius: 50%;
        width: 5em;
        height: 5em;
    }

    /* Progress bar rotation position */
    .progress-circle.p0 .value-bar {
        display: none;
    }

    .progress-circle.p1 .value-bar {
        transform: rotate(36deg);
    }

    .progress-circle.p2 .value-bar {
        transform: rotate(72deg);
    }

    .progress-circle.p3 .value-bar {
        transform: rotate(108deg);
    }

    .progress-circle.p4 .value-bar {
        transform: rotate(144deg);
    }

    .progress-circle.p5 .value-bar {
        transform: rotate(180deg);
    }

    .progress-circle.p6 .value-bar {
        transform: rotate(216deg);
    }

    .progress-circle.p7 .value-bar {
        transform: rotate(252deg);
    }

    .progress-circle.p8 .value-bar {
        transform: rotate(288deg);
    }

    .progress-circle.p9 .value-bar {
        transform: rotate(324deg);
    }

    .progress-circle.p10 .value-bar {
        transform: rotate(360deg);
    }
</style>
<!-- <script>
   function autoRefresh()
   {
       window.location = window.location.href;
   }
    setInterval('autoRefresh()', 5000);
   </script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
   $(document).ready(function () {
      //$('#timer1').delay(1000).load('admin-dashboard.php');
   });
</script>-->

<body>
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
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
                <?php
                if (($this->session->flashdata('item'))) {

                    $message = $this->session->flashdata('item');

                    ?>
                    <div id="mess" class="<?php echo $message['class']; ?>"><?php echo $message['message']; ?></div>
                <?php
            } else { }
            ?>
                <!-- page start-->
                <div class="row state-overview">
                    <div class="col-lg-4 col-sm-6">
                        <section class="panel">
                            <div class="symbol terques" style='height: 217px; background-color: orange'>
                                <i class="fa fa-user" style="margin-top: 50px;"></i>
                            </div>
                            <div class="value">
                                <span>Today's</span>
                                <h1 class="count">
                                    <?php
                                    $total = count($old_get_in) + count($vehicle_arrived) + count($awating_for_arrival) + count($attention);


                                    $dispatched = count($vehicle_dispatched);


                                    echo $total . '<br>';

                                    ?>
                                    <p style='font-size:20px'>Total</p>
                                    <?php
                                    echo '--------<br>';

                                    echo $dispatched;

                                    ?>
                                </h1>
                                <p>Dispatched</p>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <section class="panel" >
                            <div class="symbol red" style="background-color: red">
                                <i class="fa fa-truck"></i>
                            </div>
                            <div class="value">
                                <span class="width-150">Old Gate In</span>
                                <h1 class=" count2">
                                    <?php echo count($old_get_in); ?>
                                </h1>
                                <p>Old Gate In</p>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <section class="panel">
                            <div class="symbol yellow" style="background-color: green">
                                <i class="fa fa-truck"></i>
                            </div>
                            <div class="value">
                                <span>Gate In</span>
                                <h1 class=" count3">
                                    <?php echo count($vehicle_arrived); ?>
                                </h1>
                                <p>Gate In</p>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <section class="panel">
                            <div class="symbol blue">
                                <i class="fa fa-truck"></i>
                            </div>
                            <div class="value">
                                <span class="width-120">Awaiting For Arrival</span>
                                <h1 class=" count4">
                                    <?php echo count($awating_for_arrival); ?>
                                </h1>
                                <p>Awaiting For Arrival</p>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <section class="panel">
                            <div class="symbol red">
                                <i class="fa fa-warning"></i>
                            </div>
                            <div class="value">
                                <span class="width-120">Attention</span>
                                <h1 class=" count4">
                                    <?php echo count($attention); ?>
                                </h1>
                                <p>Attention</p>
                            </div>
                        </section>
                    </div>
                </div>
                
                <div class="row">
                    <?php if ((in_array("today_dispatched", $access_role)) || (in_array("all", $access_role))) { ?>
                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="task-progress">
                                        <h1>Today's Dispatch</h1>
                                        <p>Track Now</p>
                                    </div>
                                    <div class="adv-table">
                                        <table class="display table table-bordered table-striped personal-task" id="dynamic-table1">
                                            <thead>
                                                <tr>
                                                    <th class="width-80"></th>
                                                    <th class="width-120">Dispatch Date</th>
                                                    <th class="width-80">Order ID</th>
                                                    <!-- <th class="width-80">SC</th> -->
                                                    <th class="width-150">Item Code</th>
                                                    <th class="width-250">Description</th>
                                                    <th class="width-200">Route</th>
                                                    <th class="width-200">Planned date</th>
                                                    <th class="width-200">Qty to Ship</th>
                                                    <th class="width-150">Customer Name</th>
                                                    <th class="width-150">Shipment Name</th>
                                                    <th class="width-150">Transporter Name</th>
                                                    <th class="width-250">Status</th>
                                                    <th class="width-250">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                date_default_timezone_set("Asia/Calcutta");
                                                $date = date('Y-m-d');

                                                //print_r($data);
                                                foreach ($data as $get) {
                                                    //$posting_date=$get['posting_date'];
                                                    $state_code = $get['state_code'];
                                                    $company = $get['company'];
                                                    $qty_to_ship = explode(',', $get['qty_to_ship']);
                                                    $item_code = explode(',', $get['item_code']);
                                                    $description = explode(',', $get['description']);
                                                    $planned_delivery_date = explode(',', $get['planned_delivery_date']);
                                                    $route = explode(',', $get['route']);
                                                    $delivery_date = explode(',', $get['planned_delivery_date']);
                                                    if (array_fill(0, count($qty_to_ship), '0') === array_values($qty_to_ship)) { } else {

                                                        ?>
                                                        <tr>
                                                            <?php
                                                            $base_url = base_url();
                                                            // print( $base_url);
                                                            
                                                               if($get['T10Status'] =='Yes')
                                                               {
                                                                 echo '<td> <img src="' . $base_url . 'images/premium.png" height="70" width="65"> </td>';
                                                                  // echo '<td></td>';
                                                               }
                                                               else
                                                               {
                                                                  echo '<td></td>';
                                                               }
                                                            
                                                            ?>
                                                            <td> <?php echo date('d-m-Y', strtotime($get['delivery_date'])) ?><strong></td>
                                                            <td><strong><a href='<?php echo base_url(); ?>index.php/admin/order_view?id=<?php echo $get['order_id'] ?>'><?php echo $get['order_id'] ?></a></strong><br>
                                                                <?php echo $get['company'] ?>
                                                            </td>
                                                            <!-- <td> <?php echo $get['state_code'] ?></td> -->
                                                            <td><?php
                                                                foreach ($qty_to_ship as $qty_key => $qty) {

                                                                    if ($qty > '0') {
                                                                        if (array_key_exists($qty_key, $item_code)) {
                                                                            print($item_code[$qty_key] . '<br>');
                                                                        }
                                                                    }
                                                                }
                                                                ?></td>
                                                            <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                    if ($qty > '0') {
                                                                        if (array_key_exists($qty_key, $description)) {
                                                                            print($description[$qty_key] . '<br>');
                                                                        }
                                                                    }
                                                                } ?></td>
                                                            <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                    if ($qty > '0') {
                                                                        if (array_key_exists($qty_key, $route)) {
                                                                            print($route[$qty_key] . '<br>');
                                                                        }
                                                                    }
                                                                } ?></td>
                                                            <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                    if ($qty > '0') {
                                                                        if (array_key_exists($qty_key, $planned_delivery_date)) {
                                                                            print($planned_delivery_date[$qty_key] . '<br>');
                                                                        }
                                                                    }
                                                                } ?></td>
                                                            <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                    if ($qty > '0') {

                                                                        print($qty . '<br>');
                                                                    }
                                                                } ?></td>
                                                            <td><?php echo $get['cust_name'] ?></td>
                                                            <td><?php echo $get['ship_to_name'] ?></td>
                                                            <td><?php echo $get['trans_name'] ?></td>
                                                            <?php if ($get['sales_status'] == 'Reopened') { ?>
                                                                <td class=''>
                                                                    <a class='btn btn-danger blink-one width-150'>
                                                                        <?php echo $get['sales_status'] ?> </button>
                                                                </td>
                                                                <td class=''><a disabled class='btn btn-danger btn-sm abc' data-tooltip="top" id="<?php echo $get['order_id'] ?>" title="Cancel Order" href="" data-toggle="modal">Cancel Order</a></td>
                                                            <?php } else if ($get['sales_status'] == 'Released') { ?>
                                                                <?php if ($get['status'] == 'Awaiting For Arrival') { ?>
                                                                    <td class=''>
                                                                        <a class='btn btn-primary width-150'>
                                                                            <?php echo $get['status'] ?></button>
                                                                    </td>
                                                                <?php } else if ($get['status'] == 'Gate In') { ?>
                                                                    <td class=''><a class='btn btn-info width-150'><?php echo $get['status'] ?></button></td>
                                                                <?php } else if ($get['status'] == 'Tare Weight (Weighbridge)') { ?>
                                                                    <td class=''><a class='btn btn-warning width-150'><?php echo 'Weigh In' ?></button></td>
                                                                <?php } else if ($get['status'] == 'Loading') { ?>
                                                                    <td class=''><a class='btn btn-danger width-150'>Loading In</button></td>
                                                                <?php } else if ($get['status'] == 'Loading Out') { ?>
                                                                    <td class=''><a class='btn btn-danger width-150'><?php echo $get['status'] ?></button></td>
                                                                <?php } else if ($get['status'] == 'Gross Weight (Weighbridge)') { ?>
                                                                    <td class=''><a class='btn btn-warning width-150'><?php echo 'Weigh Out' ?></button></td>
                                                                <?php } else if ($get['status'] == 'Dispatched') { ?>
                                                                    <td class=''><a class='btn btn-success  width-150'><?php echo $get['status'] ?></button></td>
                                                                <?php } else if ($get['status'] == 'Delivered') { ?>
                                                                    <td class=''><a class='btn btn-success  width-150'><?php echo $get['status'] ?></button></td>
                                                                <?php } else if ($get['status'] == 'Not Approved') {  ?>
                                                                    <td class=''><a class='btn btn-danger width-150' href="<?php echo base_url(); ?>index.php/admin/approvel_orders">Not Approved</button></td>
                                                                <?php } else if ($get['status'] == 'Awaiting For Approvel') { ?>
                                                                    <td class='left'><a class='btn btn-danger width-165' href="<?php echo base_url(); ?>index.php/admin/trans_cancel_approvel"><?php echo $get['status'] ?></button></td>
                                                                <?php }  ?>
                                                                <td> <?php if ($get['status'] == 'Awaiting For Arrival') { ?>
                                                                        <a class='btn btn-danger btn-sm cancel' data-tooltip="top" id="<?php echo $get['order_id'] ?>" title="Cancel Order" href="#cancel_model" name='<?php echo $get['order_id']; ?>' data-toggle="modal">Cancel Order</a>
                                                                    <?php } else { ?>
                                                                        <a disabled class='btn btn-danger btn-sm abc' data-tooltip="top" id="<?php echo $get['order_id'] ?>" title="Cancel Order" href="" data-toggle="modal">Cancel Order</a>
                                                                    <?php } ?></td> <?php } ?>
                                                        </tr>
                                                    <?php  }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="task-progress col-md-12 allview">
                                        <div class="row">
                                            <a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/admin/todays_dispatch">View All</a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    <?php  }
                if ((in_array("confirm_pending", $access_role)) || (in_array("all", $access_role))) { ?>
                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="task-progress">
                                        <h1>Confirmed Pending Dispatches</h1>
                                        <p>pending</p>
                                    </div>
                                    <div class="adv-table">
                                        <table class="display table table-bordered table-striped personal-task" id="dynamic-table2">
                                            <thead>
                                                <tr>
                                                    <th class="width-80"></th>
                                                    <th class="width-150">Dispatch Date</th>
                                                    <th class="width-80">Order ID</th>
                                                    <!-- <th class="width-80">SC</th> -->
                                                    <th class="width-150">Item Code</th>
                                                    <th class="width-250">Description</th>
                                                    <th class="width-200">Route</th>
                                                    <th class="width-200">Planned date</th>
                                                    <th class="width-200">Qty to Ship</th>
                                                    <th class="width-150">Cust. Name</th>
                                                    <th class="width-150">Spmt Name</th>
                                                    <th class="width-200">Trans. Name</th>
                                                    <th class="width-200">Status</th>
                                                    <th class="width-200">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // print_r($pending);
                                                foreach ($pending as $get) {
                                                    $state_code = $get['state_code'];
                                                    $company = $get['company'];
                                                    $global_id = $get['global_id'];
                                                    $qty_to_ship = explode(',', $get['qty_to_ship']);
                                                    $item_code = explode(',', $get['item_code']);
                                                    $description = explode(',', $get['description']);
                                                    $planned_delivery_date = explode(',', $get['planned_delivery_date']);
                                                    $route = explode(',', $get['route']);

                                                    ?>
                                                    <tr>
                                                        <?php
                                                        $base_url = base_url();
                                                        // print( $base_url);
                                                        
                                                           if($get['T10Status'] =='Yes')
                                                           {
                                                             echo '<td> <img src="' . $base_url . 'images/premium.png" height="70" width="60"> </td>';
                                                              // echo '<td></td>';
                                                           }
                                                           else
                                                           {
                                                              echo '<td></td>';
                                                           }
                                                        
                                                        ?>
                                                        <td> <?php echo date('d-m-Y', strtotime($get['delivery_date'])) ?><strong></td>
                                                        <td><strong><a href='<?php echo base_url(); ?>index.php/admin/order_view?id=<?php echo $get['order_id'] ?>'><?php echo $get['order_id'] ?></a></strong><br>
                                                            <?php echo $get['company'] ?>
                                                        </td>
                                                        <!-- <td> <?php echo $get['state_code'] ?></td> -->
                                                        <td><?php
                                                            foreach ($qty_to_ship as $qty_key => $qty) {
                                                                if ($qty > '0') {
                                                                    if (array_key_exists($qty_key, $item_code)) {
                                                                        print($item_code[$qty_key] . '<br>');
                                                                    }
                                                                }
                                                            }
                                                            ?></td>
                                                        <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                if ($qty > '0') {
                                                                    if (array_key_exists($qty_key, $description)) {
                                                                        print($description[$qty_key] . '<br>');
                                                                    }
                                                                }
                                                            } ?></td>
                                                        <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                if ($qty > '0') {
                                                                    if (array_key_exists($qty_key, $route)) {
                                                                        print($route[$qty_key] . '<br>');
                                                                    }
                                                                }
                                                            } ?></td>
                                                        <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                if ($qty > '0') {
                                                                    if (array_key_exists($qty_key, $planned_delivery_date)) {
                                                                        print($planned_delivery_date[$qty_key] . '<br>');
                                                                    }
                                                                }
                                                            } ?></td>
                                                        <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                if ($qty > '0') {

                                                                    print($qty . '<br>');
                                                                }
                                                            } ?></td>
                                                        <td><?php echo $get['cust_name'] ?></td>
                                                        <td><?php echo $get['ship_to_name'] ?></td>
                                                        <td><?php echo $get['trans_name'] ?></td>
                                                        <?php if ($get['sales_status'] == 'Reopened') { ?>
                                                            <td class=''>
                                                                <a class='btn btn-danger blink-one width-150'>
                                                                    <?php echo $get['sales_status'] ?> </button>
                                                            </td>
                                                            <td class=''><a disabled class='btn btn-danger btn-sm abc' data-tooltip="top" id="<?php echo $get['order_id'] ?>" title="Cancel Order" href="" data-toggle="modal">Cancel Order</a></td>
                                                        <?php } else if ($get['sales_status'] == 'Released') { ?>
                                                            <?php if ($get['status'] == 'Awaiting For Arrival') { ?>
                                                                <td class=''>
                                                                    <a class='btn btn-primary  width-150'>
                                                                        <?php echo $get['status'] ?></button>
                                                                </td>
                                                            <?php } else if ($get['status'] == 'Gate In') { ?>
                                                                <td class=''><a class='btn btn-info width-150'><?php echo $get['status'] ?></button></td>
                                                            <?php } else if ($get['status'] == 'Tare Weight (Weighbridge)') { ?>
                                                                <td class=''><a class='btn btn-warning width-150'><?php echo 'Weigh In' ?></button></td>
                                                            <?php } else if ($get['status'] == 'Loading') { ?>
                                                                <td class=''><a class='btn btn-danger width-150'>Loading In</button></td>
                                                            <?php } else if ($get['status'] == 'Loading Out') { ?>
                                                                <td class=''><a class='btn btn-danger width-150'><?php echo $get['status'] ?></button></td>
                                                            <?php } else if ($get['status'] == 'Gross Weight (Weighbridge)') { ?>
                                                                <td class=''><a class='btn btn-warning width-150'><?php echo 'Weigh Out' ?></button></td>
                                                            <?php } else if ($get['status'] == 'Dispatched') { ?>
                                                                <td class=''><a class='btn btn-success width-150'><?php echo $get['status'] ?></button></td>
                                                            <?php } else if ($get['status'] == 'Not Approved') {  ?>
                                                                <td class=''><a class='btn btn-danger width-150' href="<?php echo base_url(); ?>index.php/admin/approvel_orders">Not Approved</button></td>
                                                            <?php } else if ($get['status'] == 'Awaiting For Approvel') { ?>
                                                                <td class='left'><a class='btn btn-danger width-165' href="<?php echo base_url(); ?>index.php/admin/trans_cancel_approvel"><?php echo $get['status'] ?></button></td>
                                                            <?php }  ?>
                                                            <?php if ($get['status'] == 'Awaiting For Arrival') { ?>
                                                                <td> <a class='btn btn-danger btn-sm cancel' data-tooltip="top" id="<?php echo $get['order_id'] ?>" title="Cancel Order" href="#cancel_model" name='<?php echo $get['order_id']; ?>' data-toggle="modal">Cancel Order</a></td>
                                                            <?php } else { ?>
                                                                <td> <a disabled class='btn btn-danger btn-sm abc' data-tooltip="top" id="<?php echo $value['order_id'] ?>" title="Cancel Order" href="" data-toggle="modal">Cancel Order</a>
                                                                </td>
                                                            <?php }
                                                    } ?>
                                                    </tr>
                                                <?php }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="task-progress col-md-12 allview">
                                        <div class="row">
                                            <a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/admin/pending_dispatches">View All</a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    <?php  }
                if ((in_array("pending_dispatches", $access_role)) || (in_array("all", $access_role))) { ?>
                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="task-progress">
                                        <h1>Pending Dispatches</h1>
                                        <p>pending</p>
                                    </div>
                                    <div class="adv-table">
                                        <table class="display table table-bordered table-striped personal-task" id="dynamic-table3">
                                            <thead>
                                                <tr>
                                                    <th class='width-80'></th>
                                                    <th>Dispatch Date</th>
                                                    <th>Order ID</th>
                                                    <!-- <th>SC</th> -->
                                                    <th>Item Code</th>
                                                    <th>Description</th>
                                                    <th>Route</th>
                                                    <th>Qty to Ship</th>
                                                    <th>Cust. Name</th>
                                                    <th>Shipment Name</th>
                                                    <th>Trans. Name</th>
                                                    <th>Assigned By</th>
                                                    <th class='width-150'>status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //echo "<pre>";print_r($not_accept);die();
                                                foreach ($not_accept as $get) {
                                                    if ($get['ocs_status'] == 'Bid') {
                                                        if ($get['order_status'] == 'Pending' && $get['ocs_status'] == 'Bid') {

                                                            $this->db->select('*');
                                                            $this->db->from('dbo.settings');
                                                            $data1 = $this->db->get()->result_array();

                                                            $time = "00:00:00";
                                                            foreach ($data1 as $get1) {

                                                                $bid_hours = $get1['assign_bidding_hours'];
                                                                $assign_bidding_hours_second = $get1['assign_bidding_hours_second'];
                                                                //echo $bid_hours;
                                                            }

                                                            $delivery_date = $get['delivery_date'];
                                                            $acutal_date = $delivery_date . " " . $time;
                                                            if ($bid_hours < 0) {
                                                                $hours = (-$bid_hours);
                                                                //echo $hours;
                                                                $bid_newdate = date("Y-m-d H:i:s", strtotime('+' . $hours . ' hours', strtotime($acutal_date)));
                                                            } else {

                                                                $bid_newdate = strtotime('-' . $bid_hours . ' hour', strtotime($acutal_date));

                                                                $bid_newdate = date('Y-m-d H:i:s', $bid_newdate);
                                                            }
                                                            if ($assign_bidding_hours_second < 0) {
                                                                $hours = (-$assign_bidding_hours_second);
                                                                //echo $hours;
                                                                $bid_newdate_second = date("Y-m-d H:i:s", strtotime('+' . $hours . ' hours', strtotime($acutal_date)));
                                                            } else {

                                                                $bid_newdate1 = strtotime('-' . $assign_bidding_hours_second . ' hour', strtotime($acutal_date));

                                                                $bid_newdate_second = date('Y-m-d H:i:s', $bid_newdate1);
                                                            }
                                                        }
                                                        $this->db->select('*');
                                                        $this->db->from('dbo.attn_required');
                                                        $this->db->where('order_id', $value1['order_id']);
                                                        $result = $this->db->get()->result_array();
                                                        $current_date = date("Y-m-d H:i:s");
                                                        if ((strtotime($current_date) >= strtotime($bid_newdate)) or $result) {

                                                            $k = $this->db->query("SELECT bid_amount,transporter_no,global_id FROM bidding_orders e WHERE 2=(SELECT COUNT(DISTINCT bid_amount) FROM bidding_orders p WHERE e.bid_amount>=p.bid_amount AND e.order_id = '" . $get['order_id'] . "' )");
                                                            $sql1 = $k->row();

                                                            if (!empty($sql1)) {

                                                                $this->db->select('*');
                                                                $this->db->from('dbo.sales_dispatched_order');
                                                                $this->db->where('order_id', $get['order_id']);
                                                                $query = $this->db->get();
                                                                $rows = $query->row();


                                                                $value = array(
                                                                    'order_id' => $rows->order_id,
                                                                    'trans_no' => $sql1->transporter_no,
                                                                    'global_id' => $sql1->global_id,
                                                                    'cust_no' => $rows->cust_no,

                                                                );


                                                                $this->db->where('order_id', $get['order_id']);
                                                                $query = $this->db->update('dbo.order_details', $value);
                                                                if (!$query) {
                                                                    print_r($this->db->error());
                                                                    die;
                                                                } else {

                                                                    $values = array(
                                                                        'trans_no' => $sql1->transporter_no,
                                                                    );
                                                                    $this->db->where('order_id', $get['order_id']);
                                                                    $sql = $this->db->update('dbo.sales_dispatched_order', $values);
                                                                    if (!$sql) {
                                                                        print_r($this->db->error());
                                                                        die;
                                                                    } else {
                                                                        $company = $get['company'];
                                                                        $order_key = $get['order_key'];

                                                                        echo '<script type="text/javascript">
                                                                                                $(document).ready(function(){ update_transporter("' . $sql1->transporter_no . '","' . $company . '","' . $order_key . '");})
                                                                                                 </script>';
                                                                    }
                                                                }
                                                                if (strtotime($current_date) >= strtotime($bid_newdate_second)) {

                                                                    /*********rating*******/
                                                                    $this->db->select('*');
                                                                    $this->db->from('dbo.trans_rating');
                                                                    $this->db->where('order_id', $value1['order_id']);
                                                                    $this->db->where('global_id', $value1['global_id']);

                                                                    $query = $this->db->get();
                                                                    $rating = $query->row();
                                                                    if ($rating->order_id == $value1['order_id']) {
                                                                        $update = array(

                                                                            'order_id' => $rating->order_id,
                                                                            'global_id' => $rating->global_id,
                                                                        );
                                                                        $this->db->where('order_id', $value1['order_id']);

                                                                        $data = $this->db->update('dbo.trans_rating', $update);
                                                                    } else {

                                                                        $insert = array(

                                                                            'order_id' => $value1['order_id'],
                                                                            'global_id' => $sql1->global_id,
                                                                            'accept_and_assign' => '0',

                                                                        );
                                                                        $data = $this->db->insert('dbo.trans_rating', $insert);
                                                                    }
                                                                    /*****end rating*****/
                                                                    $this->db->select('*');
                                                                    $this->db->from('dbo.attn_required');
                                                                    $this->db->where('order_id', $get['order_id']);
                                                                    $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                                                    $res = $this->db->get()->result_array();
                                                                    foreach ($res as $get_data) {
                                                                        $id = $get_data['id'];
                                                                        $customer_no = $get_data['customer_no'];
                                                                        $order_id = $get_data['order_id'];
                                                                        $global_id1 = $get_data['global_id'];
                                                                        $transporter_no = $get_data['transporter_no'];
                                                                        $delivery_date = $get_data['delivery_date'];
                                                                        $reason = $get_data['reason'];
                                                                    }
                                                                    if ($order_id == $get['order_id']) {
                                                                        $update = array(
                                                                            'order_id' => $order_id,
                                                                            'global_id' => $global_id1,
                                                                            'customer_no' => $customer_no,
                                                                            'transporter_no' => $transporter_no,
                                                                            'reason' => $reason,
                                                                            'delivery_date' => $delivery_date,
                                                                        );

                                                                        $this->db->where('order_id', $order_id);
                                                                        $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                                                        $data = $this->db->update('dbo.attn_required', $update);
                                                                    } else {
                                                                        $save = array(
                                                                            'order_id' => $value1['order_id'],
                                                                            'global_id' => $sql1->global_id,
                                                                            'customer_no' => $value1['cust_no'],
                                                                            'transporter_no' => $sql1->transporter_no,
                                                                            'delivery_date' => $value1['delivery_date'],
                                                                            'reason' => 'Not assigned in given time frame by vendor',
                                                                        );
                                                                        $data = $this->db->insert('dbo.attn_required', $save);
                                                                        $this->load->model('notification_save');
                                                                        $sender = 'transporter';
                                                                        $receiver = 'admin';
                                                                        $result = $this->notification_save->save_notification_all($order_id, 'order_not_assign', $sender, $receiver);
                                                                    }
                                                                    /********end attn required****/
                                                                    /********missed orders****/
                                                                    $this->db->select('*');
                                                                    $this->db->from('dbo.missed_orders');
                                                                    $this->db->where('order_id', $get['order_id']);
                                                                    $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                                                    $res1 = $this->db->get()->result_array();
                                                                    foreach ($res1 as $get_data1) {
                                                                        $id = $get_data1['id'];
                                                                        $customer_no = $get_data1['customer_no'];
                                                                        $order_id1 = $get_data1['order_id'];
                                                                        $global_id1 = $get_data1['global_id'];
                                                                        $transporter_no = $get_data1['transporter_no'];
                                                                        $delivery_date = $get_data1['delivery_date'];
                                                                        $reason = $get_data1['reason'];
                                                                    }
                                                                    if ($order_id1 == $get['order_id']) {
                                                                        $update = array(
                                                                            'order_id' => $order_id,
                                                                            'global_id' => $global_id1,
                                                                            'customer_no' => $customer_no,
                                                                            'transporter_no' => $transporter_no,
                                                                            'reason' => $reason,
                                                                            'delivery_date' => $delivery_date,
                                                                        );

                                                                        $this->db->where('order_id', $order_id1);
                                                                        $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                                                        $data = $this->db->update('dbo.missed_orders', $update);
                                                                    } else {
                                                                        $save = array(
                                                                            'order_id' => $get['order_id'],
                                                                            'global_id' => $sql1->global_id,
                                                                            'customer_no' => $get['cust_no'],
                                                                            'transporter_no' => $sql1->transporter_no,
                                                                            'delivery_date' => $get['delivery_date'],
                                                                            'reason' => 'Not assigned in given time frame by vendor',
                                                                        );
                                                                        $data = $this->db->insert('dbo.missed_orders', $save);
                                                                    }
                                                                    $this->db->where('order_id', $get['order_id']);
                                                                    $this->db->delete('dbo.bidding_orders');
                                                                    $this->db->where('order_id', $get['order_id']);
                                                                    $this->db->delete('dbo.order_details');
                                                                }
                                                            } else {
                                                                /*********rating*******/
                                                                $this->db->select('*');
                                                                $this->db->from('dbo.trans_rating');
                                                                $this->db->where('order_id', $value1['order_id']);
                                                                $this->db->where('global_id', $value1['global_id']);

                                                                $query = $this->db->get();
                                                                $rating = $query->row();
                                                                if ($rating->order_id == $value1['order_id']) {
                                                                    $update = array(

                                                                        'order_id' => $rating->order_id,
                                                                        'global_id' => $value1['global_id'],
                                                                    );
                                                                    $this->db->where('order_id', $value1['order_id']);

                                                                    $data = $this->db->update('dbo.trans_rating', $update);
                                                                } else {

                                                                    $insert = array(

                                                                        'order_id' => $value1['order_id'],
                                                                        'global_id' => $sql1->global_id,
                                                                        'accept_and_assign' => '0',

                                                                    );
                                                                    $data = $this->db->insert('dbo.trans_rating', $insert);
                                                                }
                                                                /*****end rating*****/
                                                                /********attn required****/

                                                                $this->db->select('*');
                                                                $this->db->from('dbo.attn_required');
                                                                $this->db->where('order_id', $get['order_id']);
                                                                $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                                                $res = $this->db->get()->result_array();
                                                                foreach ($res as $get_data) {
                                                                    $id = $get_data['id'];
                                                                    $customer_no = $get_data['customer_no'];
                                                                    $order_id = $get_data['order_id'];
                                                                    $global_id1 = $get_data['global_id'];
                                                                    $transporter_no = $get_data['transporter_no'];
                                                                    $delivery_date = $get_data['delivery_date'];
                                                                    $reason = $get_data['reason'];
                                                                }
                                                                if ($order_id == $get['order_id']) {
                                                                    $update = array(
                                                                        'order_id' => $order_id,
                                                                        'global_id' => $global_id1,
                                                                        'customer_no' => $customer_no,
                                                                        'transporter_no' => $transporter_no,
                                                                        'reason' => $reason,
                                                                        'delivery_date' => $delivery_date,
                                                                    );

                                                                    $this->db->where('order_id', $order_id);
                                                                    $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                                                    $data = $this->db->update('dbo.attn_required', $update);
                                                                } else {
                                                                    $save = array(
                                                                        'order_id' => $get['order_id'],
                                                                        'global_id' => $sql1->global_id,
                                                                        'customer_no' => $get['cust_no'],
                                                                        'transporter_no' => $sql1->transporter_no,
                                                                        'delivery_date' => $get['delivery_date'],
                                                                        'reason' => 'Not assigned in given time frame by vendor',
                                                                    );
                                                                    $data = $this->db->insert('dbo.attn_required', $save);
                                                                    $this->db->where('order_id', $order_id);
                                                                    $query1 = $this->db->delete('dbo.order_details');

                                                                    $this->load->model('notification_save');
                                                                    $sender = 'transporter';
                                                                    $receiver = 'admin';
                                                                    $result = $this->notification_save->save_notification_all($order_id, 'order_not_assign', $sender, $receiver);
                                                                }
                                                                /********end attn required****/
                                                                /********missed orders****/
                                                                $this->db->select('*');
                                                                $this->db->from('dbo.missed_orders');
                                                                $this->db->where('order_id', $get['order_id']);
                                                                $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                                                $res1 = $this->db->get()->result_array();
                                                                foreach ($res1 as $get_data1) {
                                                                    $id = $get_data1['id'];
                                                                    $customer_no = $get_data1['customer_no'];
                                                                    $order_id1 = $get_data1['order_id'];
                                                                    $global_id1 = $get_data1['global_id'];
                                                                    $transporter_no = $get_data1['transporter_no'];
                                                                    $delivery_date = $get_data1['delivery_date'];
                                                                    $reason = $get_data1['reason'];
                                                                }
                                                                if ($order_id1 == $get['order_id']) {
                                                                    $update = array(
                                                                        'order_id' => $order_id,
                                                                        'global_id' => $global_id1,
                                                                        'customer_no' => $customer_no,
                                                                        'transporter_no' => $transporter_no,
                                                                        'reason' => $reason,
                                                                        'delivery_date' => $delivery_date,
                                                                    );

                                                                    $this->db->where('order_id', $order_id1);
                                                                    $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                                                    $data = $this->db->update('dbo.missed_orders', $update);
                                                                } else {
                                                                    $save = array(
                                                                        'order_id' => $get['order_id'],
                                                                        'global_id' => $sql1->global_id,
                                                                        'customer_no' => $get['cust_no'],
                                                                        'transporter_no' => $sql1->transporter_no,
                                                                        'delivery_date' => $get['delivery_date'],
                                                                        'reason' => 'Not assigned in given time frame by vendor',
                                                                    );
                                                                    $data = $this->db->insert('dbo.missed_orders', $save);
                                                                }
                                                                $this->db->where('order_id', $get['order_id']);
                                                                $this->db->delete('dbo.order_details');
                                                                $this->db->where('order_id', $get['order_id']);
                                                                $this->db->delete('dbo.bidding_orders');
                                                            }
                                                        }
                                                        $qty_to_ship = explode(',', $get['qty_to_ship']);
                                                        $item_code = explode(',', $get['item_code']);
                                                        $description = explode(',', $get['description']);
                                                        $planned_delivery_date = explode(',', $get['planned_delivery_date']);
                                                        $route = explode(',', $get['route']);
                                                        $attn_reason = $get['reason'];
                                                        $state_code = $get['state_code'];
                                                        $company = $get['company'];
                                                        /* foreach($qty_to_ship as $qty_key => $qty) { */
                                                        /*   if(in_array(0, $qty_to_ship, true))
                                                 { */
                                                        if (array_fill(0, count($qty_to_ship), '0') === array_values($qty_to_ship)) { } else {
                                                            $arr = explode(' ', trim($attn_reason));
                                                            $reject = $arr[0];
                                                            if ($reject != 'Not') {

                                                                if ($get['order_status'] != 'Inprocess') {


                                                                    ?>
                                                                    <tr>
                                                                        <td> <?php echo date('d-m-Y', strtotime($get['delivery_date'])) ?></td>
                                                                        <td><strong><a href='<?php echo base_url(); ?>index.php/admin/order_view?id=<?php echo $get['order_id'] ?>'><?php echo $get['order_id'] ?></a></strong><br>
                                                                            <?php echo $get['company'] ?>
                                                                        </td>
                                                                        <td> <?php echo $get['state_code'] ?></td>
                                                                        <td><?php
                                                                            foreach ($qty_to_ship as $qty_key => $qty) {
                                                                                if ($qty > '0') {
                                                                                    if (array_key_exists($qty_key, $item_code)) {
                                                                                        print($item_code[$qty_key] . '<br>');
                                                                                    }
                                                                                }
                                                                            }
                                                                            ?></td>
                                                                        <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                                if ($qty > '0') {
                                                                                    if (array_key_exists($qty_key, $description)) {
                                                                                        print($description[$qty_key] . '<br>');
                                                                                    }
                                                                                }
                                                                            } ?></td>
                                                                        <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                                if ($qty > '0') {
                                                                                    if (array_key_exists($qty_key, $route)) {
                                                                                        print($route[$qty_key] . '<br>');
                                                                                    }
                                                                                }
                                                                            } ?></td>
                                                                        <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                                if ($qty > '0') {

                                                                                    print($qty . '<br>');
                                                                                }
                                                                            } ?></td>
                                                                        <td><?php echo $get['cust_name'] ?></td>
                                                                        <td><?php echo $get['ship_to_name'] ?></td>
                                                                        <td><?php echo $get['trans_name'] ?></td>
                                                                        <td><?php echo $get['ocs_status'] ?></td>
                                                                        <?php if ($get['sales_status'] == 'Reopened') { ?>
                                                                            <td class=''>
                                                                                <a class='btn btn-danger blink-one width-150'>
                                                                                    <?php echo $get['sales_status'] ?> </button>
                                                                            </td>
                                                                        <?php } else if ($get['sales_status'] == 'Released') { ?>
                                                                            <?php if ($get['order_status'] == '') { ?>
                                                                                <td style='background-color:#27313b;color:white ; text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Awaiting for acceptance <br>
                                                                                    <h4><strong>[ <span class='countdown' value='<?php echo $newdate ?>'></span> ]</strong></h4>
                                                                                <?php } else if ($get['order_status'] == 'Pending' && $get['ocs_status'] == 'Bid') {
                                                                                if (strtotime($current_date) >= strtotime($bid_newdate)) {
                                                                                    ?>
                                                                                    <td style='background-color:green;color:white;text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Time Left for Assign order<br>
                                                                                        <h4><strong>[ <span class='countdown' value='<?php echo $bid_newdate_second ?>'></span> ]</strong></h4>
                                                                                    </td><?php } else { ?>
                                                                                    <td style='background-color:green;color:white;text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Time Left for Assign order<br>
                                                                                        <h4><strong>[ <span class='countdown' value='<?php echo $bid_newdate ?>'></span> ]</strong></h4>
                                                                                    </td>
                                                                                <?php }
                                                                        } ?>
                                                                            <!--<span class='countdown' value='<?php echo $newdate ?>'></span><br />-->
                                                                            <!--<div id='time'>
                                                                   <span class="strclock" style="font-weight:bold;font-size:1.2em;"></span></div>-->
                                                                            <!--<td><span class='countdown' value='<?php echo $newdate ?>'></span></td>-->
                                                                        </tr>
                                                                    <?php }
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    if ($get['order_status'] == '') {

                                                        $this->db->select('*');
                                                        $this->db->from('dbo.settings');
                                                        $data = $this->db->get()->result_array();

                                                        $time = "00:00:00";
                                                        foreach ($data as $get1) {
                                                            $allowance_hours = $get1['allowance_hours'];
                                                        }

                                                        $delivery_date = $get['delivery_date'];
                                                        $acutal_date = $delivery_date . " " . $time;
                                                        if ($allowance_hours < 0) {
                                                            $hours = (-$allowance_hours);

                                                            $newdate = date("Y-m-d H:i:s", strtotime('+' . $hours . ' hours', strtotime($acutal_date)));
                                                        } else {


                                                            /* echo $acutal_date;  */
                                                            $newdate = strtotime('-' . $allowance_hours . ' hour', strtotime($acutal_date));

                                                            $newdate = date('Y-m-d H:i:s', $newdate);
                                                        }
                                                    } else if ($get['order_status'] == 'Pending') {

                                                        $this->db->select('*');
                                                        $this->db->from('dbo.settings');
                                                        $data = $this->db->get()->result_array();

                                                        $time = "00:00:00";
                                                        foreach ($data as $get1) {
                                                            $assign_hours = $get1['assign_hours'];
                                                        }

                                                        $delivery_date = $get['delivery_date'];
                                                        $acutal_date = $delivery_date . " " . $time;
                                                        if ($assign_hours < 0) {
                                                            $hours = (-$assign_hours);

                                                            $newdate = date("Y-m-d H:i:s", strtotime('+' . $hours . ' hours', strtotime($acutal_date)));
                                                        } else {


                                                            /* echo $acutal_date;  */
                                                            $newdate = strtotime('-' . $assign_hours . ' hour', strtotime($acutal_date));

                                                            $newdate = date('Y-m-d H:i:s', $newdate);
                                                        }
                                                    }



                                                    error_reporting(0);
                                                    $tz_object = new DateTimeZone('Asia/Kolkata');
                                                    $datetime = new DateTime();
                                                    $datetime->setTimezone($tz_object);
                                                    $yt = $datetime->format('Y');
                                                    $mt = $datetime->format('m');
                                                    $dt = $datetime->format('d');
                                                    $hours = $datetime->format('H');
                                                    $minutes = $datetime->format('i');
                                                    $seconds = $datetime->format('s');
                                                    $now = $yt . "-" . $mt . "-" . $dt . " " . $hours . ":" . $minutes . ":" . $seconds;
                                                    $time1 = strtotime($now);
                                                    $time2 = strtotime($newdate);
                                                    $diffdhg = $time2 - $time1;
                                                    gmdate("d H:i:s", $diffdhg);
                                                    $days = $diffdhg / 86400;
                                                    $day_explode = explode(".", $days);
                                                    $d = $day_explode[0];
                                                    $hours = '.' . $day_explode[1] . '';
                                                    $hour = $hours * 24;
                                                    $hourr = explode(".", $hour);
                                                    $h = $hourr[0];
                                                    $minute = '.' . $hourr[1] . '';
                                                    $minutes = $minute * 60;
                                                    $minute = explode(".", $minutes);
                                                    $m = $minute[0];
                                                    $seconds = '.' . $minute[1] . '';
                                                    $second = $seconds * 60;
                                                    $s = round($second);
                                                    $timer = $d . ":" . "$h" . ":" . $m . ":" . $s;
                                                    //print_r($timer);
                                                    if ($d < '0' || $d === '-0') {
                                                        // if ($get['order_status'] == '') {
                                                        //     /************rating********/
                                                        //     $this->db->select('*');
                                                        //     $this->db->from('dbo.trans_rating');
                                                        //     $this->db->where('order_id', $value1['order_id']);
                                                        //     $this->db->where('global_id', $value1['global_id']);

                                                        //     $query = $this->db->get();
                                                        //     $rating = $query->row();
                                                        //     if ($rating->order_id == $value1['order_id']) {
                                                        //         $update = array(

                                                        //             'order_id' => $rating->order_id,
                                                        //             'global_id' => $value1['global_id'],
                                                        //         );
                                                        //         $this->db->where('order_id', $value1['order_id']);

                                                        //         $data = $this->db->update('dbo.trans_rating', $update);
                                                        //     } else {

                                                        //         $insert = array(

                                                        //             'order_id' => $value1['order_id'],
                                                        //             'global_id' => $value1['global_id'],
                                                        //             'accept_and_assign' => '0',

                                                        //         );
                                                        //         $data = $this->db->insert('dbo.trans_rating', $insert);
                                                        //     }
                                                        //     /************ end rating********/
                                                        //     /********attn required****/
                                                        //     $this->db->select('*');
                                                        //     $this->db->from('dbo.attn_required');
                                                        //     $this->db->where('order_id', $get['order_id']);
                                                        //     $this->db->where('reason', 'Not accepted in given time frame by vendor');
                                                        //     $res = $this->db->get()->result_array();
                                                        //     foreach ($res as $get_data) {
                                                        //         $id = $get_data['id'];
                                                        //         $customer_no = $get_data['customer_no'];
                                                        //         $order_id = $get_data['order_id'];
                                                        //         $transporter_no = $get_data['transporter_no'];
                                                        //         $delivery_date = $get_data['delivery_date'];
                                                        //         $reason = $get_data['reason'];
                                                        //         $global_id1 = $get_data['global_id'];
                                                        //     }
                                                        //     if ($order_id == $get['order_id']) {
                                                        //         $update = array(
                                                        //             'order_id' => $order_id,
                                                        //             'global_id' => $global_id1,
                                                        //             'customer_no' => $customer_no,
                                                        //             'transporter_no' => $transporter_no,
                                                        //             'reason' => $reason,
                                                        //             'delivery_date' => $delivery_date,
                                                        //         );

                                                        //         $this->db->where('order_id', $order_id);
                                                        //         $this->db->where('reason', 'Not accepted in given time frame by vendor');
                                                        //         $data = $this->db->update('dbo.attn_required', $update);
                                                        //     } else {
                                                        //         $save = array(
                                                        //             'order_id' => $get['order_id'],
                                                        //             'global_id' => $get['global_id'],
                                                        //             'customer_no' => $get['cust_no'],
                                                        //             'transporter_no' => $get['trans_no'],
                                                        //             'delivery_date' => $get['delivery_date'],
                                                        //             'reason' => 'Not accepted in given time frame by vendor',
                                                        //         );
                                                        //         $data = $this->db->insert('dbo.attn_required', $save);
                                                        //         $this->load->model('notification_save');
                                                        //         $sender = 'transporter';
                                                        //         $receiver = 'admin';
                                                        //         $result = $this->notification_save->save_notification_all($order_id, 'order_not_accept', $sender, $receiver);
                                                        //     }
                                                        //     /********end attn required****/
                                                        //     /********missed orders****/
                                                        //     $this->db->select('*');
                                                        //     $this->db->from('dbo.missed_orders');
                                                        //     $this->db->where('order_id', $get['order_id']);
                                                        //     $this->db->where('reason', 'Not accepted in given time frame by vendor');
                                                        //     $res1 = $this->db->get()->result_array();
                                                        //     foreach ($res1 as $get_data1) {
                                                        //         $id = $get_data1['id'];
                                                        //         $customer_no = $get_data1['customer_no'];
                                                        //         $order_id1 = $get_data1['order_id'];
                                                        //         $global_id1 = $get_data1['global_id'];
                                                        //         $transporter_no = $get_data1['transporter_no'];
                                                        //         $delivery_date = $get_data1['delivery_date'];
                                                        //         $reason = $get_data1['reason'];
                                                        //     }
                                                        //     if ($order_id1 == $get['order_id']) {

                                                        //         $update = array(
                                                        //             'order_id' => $order_id,
                                                        //             'global_id' => $global_id1,
                                                        //             'customer_no' => $customer_no,
                                                        //             'transporter_no' => $transporter_no,
                                                        //             'reason' => $reason,
                                                        //             'delivery_date' => $delivery_date,
                                                        //         );

                                                        //         $this->db->where('order_id', $order_id1);
                                                        //         $this->db->where('reason', 'Not accepted in given time frame by vendor');
                                                        //         $data = $this->db->update('dbo.missed_orders', $update);
                                                        //     } else {

                                                        //         $save = array(
                                                        //             'order_id' => $get['order_id'],
                                                        //             'global_id' => $get['global_id'],
                                                        //             'customer_no' => $get['cust_no'],
                                                        //             'transporter_no' => $get['trans_no'],
                                                        //             'delivery_date' => $get['delivery_date'],
                                                        //             'reason' => 'Not accepted in given time frame by vendor',
                                                        //         );
                                                        //         $data = $this->db->insert('dbo.missed_orders', $save);
                                                        //     }
                                                        //     /********end missed orders****/
                                                        // } else if ($get['order_status'] == 'Pending' && $get['ocs_status'] == 'Admin') {
                                                        //     /********attn required****/
                                                        //     $this->db->select('*');
                                                        //     $this->db->from('dbo.attn_required');
                                                        //     $this->db->where('order_id', $get['order_id']);
                                                        //     $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                                        //     $res = $this->db->get()->result_array();
                                                        //     foreach ($res as $get_data) {
                                                        //         $id = $get_data['id'];
                                                        //         $customer_no = $get_data['customer_no'];
                                                        //         $order_id = $get_data['order_id'];
                                                        //         $transporter_no = $get_data['transporter_no'];
                                                        //         $delivery_date = $get_data['delivery_date'];
                                                        //         $reason = $get_data['reason'];
                                                        //         $global_id1 = $get_data['global_id'];
                                                        //     }
                                                        //     if ($order_id == $get['order_id']) {
                                                        //         $update = array(
                                                        //             'order_id' => $order_id,
                                                        //             'global_id' => $global_id1,
                                                        //             'customer_no' => $customer_no,
                                                        //             'transporter_no' => $transporter_no,
                                                        //             'reason' => $reason,
                                                        //             'delivery_date' => $delivery_date,
                                                        //         );

                                                        //         $this->db->where('order_id', $order_id);
                                                        //         $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                                        //         $data = $this->db->update('dbo.attn_required', $update);
                                                        //     } else {
                                                        //         $save = array(
                                                        //             'order_id' => $get['order_id'],
                                                        //             'global_id' => $get['global_id'],
                                                        //             'customer_no' => $get['cust_no'],
                                                        //             'transporter_no' => $get['trans_no'],
                                                        //             'delivery_date' => $get['delivery_date'],
                                                        //             'reason' => 'Not assigned in given time frame by vendor',
                                                        //         );
                                                        //         $data = $this->db->insert('dbo.attn_required', $save);
                                                        //         $this->db->where('order_id', $order_id);
                                                        //         $query1 = $this->db->delete('dbo.order_details');

                                                        //         $this->load->model('notification_save');
                                                        //         $sender = 'transporter';
                                                        //         $receiver = 'admin';
                                                        //         $result = $this->notification_save->save_notification_all($order_id, 'order_not_assign', $sender, $receiver);
                                                        //     }
                                                        //     /********end attn required****/
                                                        //     /********missed orders****/
                                                        //     $this->db->select('*');
                                                        //     $this->db->from('dbo.missed_orders');
                                                        //     $this->db->where('order_id', $get['order_id']);
                                                        //     $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                                        //     $res1 = $this->db->get()->result_array();
                                                        //     foreach ($res1 as $get_data1) {
                                                        //         $id = $get_data1['id'];
                                                        //         $customer_no = $get_data1['customer_no'];
                                                        //         $order_id1 = $get_data1['order_id'];
                                                        //         $global_id1 = $get_data1['global_id'];
                                                        //         $transporter_no = $get_data1['transporter_no'];
                                                        //         $delivery_date = $get_data1['delivery_date'];
                                                        //         $reason = $get_data1['reason'];
                                                        //     }
                                                        //     if ($order_id1 == $get['order_id']) {
                                                        //         $update = array(
                                                        //             'order_id' => $order_id,
                                                        //             'global_id' => $global_id1,
                                                        //             'customer_no' => $customer_no,
                                                        //             'transporter_no' => $transporter_no,
                                                        //             'reason' => $reason,
                                                        //             'delivery_date' => $delivery_date,
                                                        //         );

                                                        //         $this->db->where('order_id', $order_id1);
                                                        //         $this->db->where('reason', 'Not assigned in given time frame by vendor');
                                                        //         $data = $this->db->update('dbo.missed_orders', $update);
                                                        //     } else {
                                                        //         $save = array(
                                                        //             'order_id' => $get['order_id'],
                                                        //             'global_id' => $get['global_id'],
                                                        //             'customer_no' => $get['cust_no'],
                                                        //             'transporter_no' => $get['trans_no'],
                                                        //             'delivery_date' => $get['delivery_date'],
                                                        //             'reason' => 'Not assigned in given time frame by vendor',
                                                        //         );
                                                        //         $data = $this->db->insert('dbo.missed_orders', $save);
                                                        //     }
                                                        // }
                                                    } else {

                                                        $qty_to_ship = explode(',', $get['qty_to_ship']);
                                                        $item_code = explode(',', $get['item_code']);
                                                        $description = explode(',', $get['description']);
                                                        $planned_delivery_date = explode(',', $get['planned_delivery_date']);
                                                        $route = explode(',', $get['route']);
                                                        $attn_reason = $get['reason'];
                                                        $state_code = $get['state_code'];
                                                        $company = $get['company'];
                                                        /* foreach($qty_to_ship as $qty_key => $qty) { */
                                                        /*   if(in_array(0, $qty_to_ship, true))
                                         { */
                                                        if (array_fill(0, count($qty_to_ship), '0') === array_values($qty_to_ship)) { } else {
                                                            $arr = explode(' ', trim($attn_reason));
                                                            $reject = $arr[0];
                                                            if (!$reject == 'Rejected' or !$reject == 'Not') {

                                                                if ($get['order_status'] != 'Inprocess') {


                                                                    ?>
                                                                        <tr>
                                                                             <?php
                                                                                $base_url = base_url();
                                                                                // print( $base_url);
                                                                                
                                                                                   if($get['T10Status'] =='Yes')
                                                                                   {
                                                                                     echo '<td> <img src="' . $base_url . 'images/premium.png" height="70" width="60"> </td>';
                                                                                      // echo '<td></td>';
                                                                                   }
                                                                                   else
                                                                                   {
                                                                                      echo '<td></td>';
                                                                                   }
                                                                                
                                                                                ?>
                                                                            <td> <?php echo date('d-m-Y', strtotime($get['delivery_date'])) ?></td>
                                                                            <td><strong><a href='<?php echo base_url(); ?>index.php/admin/order_view?id=<?php echo $get['order_id'] ?>'><?php echo $get['order_id'] ?></a></strong><br>
                                                                                <?php echo $get['company'] ?>
                                                                            </td>
                                                                            <!-- <td> <?php echo $get['state_code'] ?></td> -->
                                                                            <td><?php
                                                                                foreach ($qty_to_ship as $qty_key => $qty) {
                                                                                    if ($qty > '0') {
                                                                                        if (array_key_exists($qty_key, $item_code)) {
                                                                                            print($item_code[$qty_key] . '<br>');
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?></td>
                                                                            <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                                    if ($qty > '0') {
                                                                                        if (array_key_exists($qty_key, $description)) {
                                                                                            print($description[$qty_key] . '<br>');
                                                                                        }
                                                                                    }
                                                                                } ?></td>
                                                                            <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                                    if ($qty > '0') {
                                                                                        if (array_key_exists($qty_key, $route)) {
                                                                                            print($route[$qty_key] . '<br>');
                                                                                        }
                                                                                    }
                                                                                } ?></td>
                                                                            <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                                    if ($qty > '0') {

                                                                                        print($qty . '<br>');
                                                                                    }
                                                                                } ?></td>
                                                                            <td><?php echo $get['cust_name'] ?></td>
                                                                            <td><?php echo $get['ship_to_name'] ?></td>
                                                                            <td><?php echo $get['trans_name'] ?></td>
                                                                            <td>
                                                                                <?php
                                                                                if ($get['ocs_status'] == '' or  $get['ocs_status'] == 'Admin') {
                                                                                    echo 'Admin';
                                                                                } else {
                                                                                    echo $get['ocs_status'];
                                                                                } ?>
                                                                            </td>
                                                                            <?php if ($get['sales_status'] == 'Reopened') { ?>
                                                                                <td class=''><a class='btn btn-danger blink-one width-150'><?php echo $get['sales_status'] ?> </button></td>
                                                                            <?php } else if ($get['sales_status'] == 'Released') { ?>
                                                                                <?php if ($get['order_status'] == '') { ?>
                                                                                    <td style='background-color:#27313b;color:white ; text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Awaiting for acceptance <br>
                                                                                        <h4><strong>[ <span class='countdown' value='<?php echo $newdate ?>'></span> ]</strong></h4>
                                                                                    <?php } else if ($get['order_status'] == 'Pending') { ?>
                                                                                    <td style='background-color:green;color:white;text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>Awaiting for Assign order<br>
                                                                                        <h4><strong>[ <span class='countdown' value='<?php echo $newdate ?>'></span> ]</strong></h4>
                                                                                    </td>
                                                                                <?php }
                                                                        } ?>
                                                                            <!--<span class='countdown' value='<?php echo $newdate ?>'></span><br />-->
                                                                            <!--<div id='time'>
                                                                <span class="strclock" style="font-weight:bold;font-size:1.2em;"></span></div>-->
                                                                            <!--<td><span class='countdown' value='<?php echo $newdate ?>'></span></td>-->
                                                                        </tr>
                                                                    <?php }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="task-progress col-md-12 allview">
                                        <div class="row">
                                            <a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/admin/not_accepted_orders">View All</a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    <?php  }
                if ((in_array("attn_required", $access_role)) || (in_array("all", $access_role))) { ?>
                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="task-progress">
                                        <h1>Attention Required</h1>
                                        <p>Rejected</p>
                                    </div>
                                    <div class="adv-table">
                                        <table class="display table table-bordered table-striped personal-task" style='background-color:#CFCAC8' id="dynamic-table4">
                                            <thead>
                                                <tr>
                                                    <th class="width-80"></th>
                                                    <th class="width-100">Dispatch Date</th>
                                                    <th class="width-80">Order ID</th>
                                                    <!-- <th class="width-80">SC</th> -->
                                                    <th class="width-120">Item Code</th>
                                                    <th class="width-180">Description</th>
                                                    <th class="width-150">Route</th>
                                                    <th class="width-100">Planned date</th>
                                                    <th class="width-100">Qty to ship</th>
                                                    <th class="width-150">Customer Name</th>
                                                    <th class="width-150">Shipment Name</th>
                                                    <th class="width-150">Transporter Name</th>
                                                    <th class="width-200">Reason</th>
                                                    <th class="width-150 text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //echo "<pre>"; print_r($attn); die;

                                                foreach ($attn as $get) {
                                                    $qty_to_ship = explode(',', $get['qty_to_ship']);
                                                    $item_code = explode(',', $get['item_code']);
                                                    $description = explode(',', $get['description']);
                                                    $planned_delivery_date = explode(',', $get['planned_delivery_date']);
                                                    $route = explode(',', $get['route']);
                                                    $state_code = $get['state_code'];
                                                    $company = $get['company'];
                                                    /* foreach($qty_to_ship as $qty_key => $qty) {  */
                                                    if (array_fill(0, count($qty_to_ship), '0') === array_values($qty_to_ship)) {
                                                        //    echo "here";
                                                    } else {
                                                        //print_r($attn);
                                                        ?>
                                                        <tr>
                                                            <?php
                                                                $base_url = base_url();
                                                                // print( $base_url);
                                                                
                                                                   if($get['T10Status'] =='Yes')
                                                                   {
                                                                     echo '<td> <img src="' . $base_url . 'images/premium.png" height="70" width="60"> </td>';
                                                                      // echo '<td></td>';
                                                                   }
                                                                   else
                                                                   {
                                                                      echo '<td></td>';
                                                                   }
                                                                
                                                                ?>
                                                            <td> <?php echo date('d-m-Y', strtotime($get['delivery_date'])) ?><strong></td>
                                                            <td><strong><a href='<?php echo base_url(); ?>index.php/admin/order_view?id=<?php echo $get['order_id'] ?>'><?php echo $get['order_id'] ?></a></strong><br>
                                                                <?php echo $get['company'] ?>
                                                            </td>
                                                            <!-- <td> <?php echo $get['state_code'] ?></td> -->
                                                            <td><?php
                                                                foreach ($qty_to_ship as $qty_key => $qty) {
                                                                    if ($qty > '0') {
                                                                        if (array_key_exists($qty_key, $item_code)) {
                                                                            print($item_code[$qty_key] . '<br>');
                                                                        }
                                                                    }
                                                                }
                                                                ?></td>
                                                            <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                    if ($qty > '0') {
                                                                        if (array_key_exists($qty_key, $description)) {
                                                                            print($description[$qty_key] . '<br>');
                                                                        }
                                                                    }
                                                                } ?></td>
                                                            <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                    if ($qty > '0') {
                                                                        if (array_key_exists($qty_key, $route)) {
                                                                            print($route[$qty_key] . '<br>');
                                                                        }
                                                                    }
                                                                } ?></td>
                                                            <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                    if ($qty > '0') {
                                                                        if (array_key_exists($qty_key, $planned_delivery_date)) {
                                                                            print($planned_delivery_date[$qty_key] . '<br>');
                                                                        }
                                                                    }
                                                                } ?></td>
                                                            <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                    if ($qty > '0') {

                                                                        print($qty . '<br>');
                                                                    }
                                                                } ?></td>
                                                            <td><?php echo $get['cust_name'] ?></td>
                                                            <td><?php echo $get['ship_to_name'] ?></td>
                                                            <td><?php echo $get['trans_name'] ?></td>
                                                            <td><?php echo $get['reason'] ?></td>
                                                            <?php if ($get['sales_status'] == 'Reopened') { ?>
                                                                <td class=''>
                                                                    <a class='btn btn-danger blink-one width-150'>
                                                                        <?php echo $get['sales_status'] ?> </button>
                                                                </td>
                                                            <?php } else if ($get['sales_status'] == 'Released') { ?>
                                                                <td>
                                                                    <a class='btn btn-primary btn-xs open' name='<?php echo $get['order_id']; ?>' data-toggle="modal" href="#myModal6" type="button"><i class="fa fa-legal"></i></a>
                                                                    <a class='btn btn-danger btn-xs update' id="<?php echo $get['delivery_date'] ?>" value='<?php echo $get['order_id'] ?>' name='<?php echo $get['trans_name'] ?>' data-toggle="modal" company='<?php echo $get['company'] ?>' href="#myModal1" type="button"><i class="fa fa-pencil"></i></a>
                                                                </td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="task-progress col-md-12 allview">
                                        <div class="row">
                                            <a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/admin/attn_required">View All</a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    <?php  }
                if ((in_array("live_bidding", $access_role)) || (in_array("all", $access_role))) { ?>
                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="task-progress">
                                        <h1>Live Bidding Orders</h1>
                                        <p>Assigned from ERP</p>
                                    </div>
                                    <div class="adv-table">
                                        <table class="display table table-bordered table-striped personal-task" id="dynamic-table5">
                                            <thead>
                                                <tr>
                                                    <th class="width-80">Order ID</th>
                                                    <th class="width-200">Item Code</th>
                                                    <th class="width-250">Description</th>
                                                    <th class="width-100">Quantity</th>
                                                    <th class="width-250">Root</th>
                                                    <th class="width-200">Client Name</th>
                                                    <th class="width-100">Delivery Date</th>
                                                    <th class="width-200">Lowest Bid</th>
                                                    <th class="width-200">Time Left</th>
                                                    <th class="width-50 text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                /*  print_r($open_orders); */
                                                foreach ($open_orders as $get) {


                                                    $global_id = $get['global_id'];
                                                    $this->db->select('*');
                                                    $this->db->from('dbo.settings');
                                                    $q1 = $this->db->get()->row();
                                                    $bid_hours = $q1->bidding_hours;


                                                    $posting_date = $get['delivery_date'];
                                                    $time = "00:00:00";
                                                    $acutal_date = $posting_date . " " . $time;
                                                    if ($bid_hours < 0) {
                                                        $hours = (-$bid_hours);

                                                        $newdate = date("Y-m-d H:i:s", strtotime('+' . $hours . ' hours', strtotime($acutal_date)));
                                                    } else {


                                                        /* echo $acutal_date;  */
                                                        $newdate = strtotime('-' . $bid_hours . ' hour', strtotime($acutal_date));

                                                        $newdate = date('Y-m-d H:i:s', $newdate);
                                                    }
                                                    //$newdate = date("Y-m-d H:i:s", strtotime('-'.$bid_hours.' hours', strtotime($acutal_date)));
                                                    $current_date = date("Y-m-d H:i:s");
                                                    //print_r($newdate);
                                                    if (strtotime($current_date) >= strtotime($newdate)) {


                                                        $k = $this->db->query("SELECT transporter_no,global_id FROM dbo.bidding_orders WHERE bid_amount = (SELECT MIN(bid_amount) FROM dbo.bidding_orders WHERE order_id = '" . $get['order_id'] . "' )");
                                                        $sql1 = $k->row();

                                                        if (!empty($sql1)) {

                                                            $this->db->select('order_id,cust_no');
                                                            $this->db->from('dbo.sales_dispatched_order');
                                                            $this->db->where('order_id', $get['order_id']);
                                                            $query = $this->db->get();
                                                            $rows = $query->row();

                                                            $insert = array(
                                                                'order_id' => $rows->order_id,
                                                                'trans_no' => $sql1->transporter_no,
                                                                'global_id' => $sql1->global_id,
                                                                'cust_no' => $rows->cust_no,
                                                                'vehicle_id' => '',
                                                                'driver_id' => '',
                                                                'shipping_status' => 'Pending',
                                                                'order_status' => 'Pending',
                                                                'time' => '',
                                                                'lr_rr_file' => '',
                                                                'eway_no' => '',
                                                                'lr_rr_no' => '',
                                                                'lr_rr_date' => '',
                                                                'eway_file' => '',
                                                                'gps_enabled' => '',
                                                                'qr_code' => '',
                                                                'qr_status' => '',
                                                                'insurance_no' => '',
                                                                'order_created_status' => 'Bid',

                                                            );

                                                            /*print_r($value);
                                                    die; */
                                                            $query = $this->db->insert('dbo.order_details', $insert);
                                                            if (!$query) {
                                                                echo 'error';
                                                                //print_r($this->db->error());
                                                                //die;
                                                            } else {
                                                                $values = array(
                                                                    'trans_no' => $sql1->transporter_no,
                                                                );
                                                                $this->db->where('order_id', $get['order_id']);
                                                                $sql = $this->db->update('dbo.sales_dispatched_order', $values);
                                                                if (!$sql) {
                                                                    //print_r($this->db->error());
                                                                    //die;
                                                                } else {
                                                                    $company = $get['company'];
                                                                    $order_key = $get['order_key'];

                                                                    echo '<script type="text/javascript">
                                                                                              $(document).ready(function(){ update_transporter("' . $sql1->transporter_no . '","' . $company . '","' . $order_key . '");
                                                                   })
                                                                                               </script>';
                                                                }
                                                                //$this->db->where('order_id', $value['order_id']);
                                                                //  $this->db->delete('dbo.bidding_orders');
                                                            }
                                                        } else {
                                                            //  echo 'aaaaaaaa';
                                                            /****attn required****/
                                                            $this->db->select('*');
                                                            $this->db->from('dbo.attn_required');
                                                            $this->db->where('order_id', $get['order_id']);
                                                            $this->db->where('reason', 'No Bidding placed');
                                                            $res = $this->db->get()->result_array();
                                                            foreach ($res as $get_data) {
                                                                $id = $get_data['id'];
                                                                $customer_no = $get_data['customer_no'];
                                                                $order_id = $get_data['order_id'];
                                                                $transporter_no = $get_data['transporter_no'];
                                                                $delivery_date = $get_data['delivery_date'];
                                                                $reason = $get_data['reason'];
                                                            }
                                                            if ($order_id == $get['order_id']) {
                                                                $update = array(
                                                                    'order_id' => $order_id,

                                                                    'customer_no' => $customer_no,
                                                                    'transporter_no' => $transporter_no,
                                                                    'reason' => $reason,
                                                                    'delivery_date' => $delivery_date,
                                                                );

                                                                $this->db->where('order_id', $order_id);
                                                                $this->db->where('reason', 'No Bidding placed');
                                                                $data = $this->db->update('dbo.attn_required', $update);
                                                            } else {
                                                                $save = array(
                                                                    'order_id' => $get['order_id'],
                                                                    'global_id' => '',
                                                                    'customer_no' => $get['cust_no'],
                                                                    'transporter_no' => '',
                                                                    'delivery_date' => $get['delivery_date'],
                                                                    'reason' => 'No Bidding placed',
                                                                );
                                                                $data = $this->db->insert('dbo.attn_required', $save);

                                                                $this->load->model('notification_save');
                                                                $sender = 'transporter';
                                                                $receiver = 'admin';
                                                                $result = $this->notification_save->save_notification_all($order_id, 'no_bidding_place', $sender, $receiver);
                                                            }
                                                        }
                                                    } else {
                                                        $qty_to_ship = explode(',', $get['qty_to_ship']);
                                                        $item_code = explode(',', $get['item_code']);
                                                        $description = explode(',', $get['description']);
                                                        $planned_delivery_date = explode(',', $get['planned_delivery_date']);
                                                        $route = explode(',', $get['route']);
                                                        $arr = explode(' ', trim($get['reason']));
                                                        $reject = $arr[0];
                                                        $this->db->select('MIN(bid_amount) as lowest_amount, unit');
                                                        $this->db->from('dbo.bidding_orders');
                                                        $this->db->where('order_id', $get['order_id']);
                                                        $this->db->group_by('unit');
                                                        $q2 = $this->db->get()->row();
                                                        //print_r($reject);
                                                        if (!$reject == 'Not' or !$reject == 'No') {
                                                            ?>
                                                            <tr>
                                                                <td><a href='<?php echo base_url(); ?>index.php/admin/order_overview?id=<?php echo $get['order_id'] ?>'><?php echo $get['order_id'] ?></a></td>
                                                                <td><?php
                                                                    foreach ($qty_to_ship as $qty_key => $qty) {
                                                                        if ($qty > '0') {
                                                                            if (array_key_exists($qty_key, $item_code)) {
                                                                                print($item_code[$qty_key] . '<br>');
                                                                            }
                                                                        }
                                                                    }
                                                                    ?></td>
                                                                <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                        if ($qty > '0') {
                                                                            if (array_key_exists($qty_key, $description)) {
                                                                                print($description[$qty_key] . '<br>');
                                                                            }
                                                                        }
                                                                    } ?></td>
                                                                <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                        if ($qty > '0') {

                                                                            print($qty . '<br>');
                                                                        }
                                                                    } ?></td>
                                                                <td><?php foreach ($qty_to_ship as $qty_key => $qty) {
                                                                        if ($qty > '0') {
                                                                            if (array_key_exists($qty_key, $route)) {
                                                                                print($route[$qty_key] . '<br>');
                                                                            }
                                                                        }
                                                                    } ?></td>
                                                                <td><?php echo $get['cust_name'] ?></td>
                                                                <td><?php echo $get['delivery_date'] ?></td>
                                                                <td> <strong class="highlight" style="font-size:20px;"><?php echo $q2->lowest_amount; ?> <span style="font-size:15px;"><?php echo $q2->unit; ?></span></strong></td>
                                                                <td style='background-color:#27313b;color:white ; text-align:  center;padding: 10px 0 0px 0;font-size: 12px;'>
                                                                    Time left for Bidding <br>
                                                                    <h4><strong>[ <span class='countdown' value='<?php echo $newdate ?>'></span> ]</strong></h4>
                                                                </td>
                                                                <td>
                                                                    <a href="<?php echo base_url(); ?>index.php/admin/order_overview?id=<?php echo $get['order_id'] ?>" class="btn btn-primary btn-xs right "><i class="fa fa-eye"></i></a>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="task-progress col-md-12 allview">
                                        <div class="row">
                                            <a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/admin/live_bidding">View All</a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    <?php  }
                if ((in_array("live_bidding", $access_role)) || (in_array("all", $access_role))) { ?>
                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="task-progress">
                                        <h1>Live Bidding Status</h1>
                                        <p>Bid Applied from Transporter</p>
                                    </div>
                                    <div class="adv-table">
                                        <table class="display table table-bordered table-striped personal-task" id="dynamic-table6">
                                            <thead>
                                                <tr>
                                                    <th class="width-80">Order ID</th>
                                                    <th class="width-200">Bidding Date</th>
                                                    <th class="width-250">Bidding Time</th>
                                                    <th class="width-200">Lowest Bid</th>
                                                    <th class="width-200">Transporter Name</th>
                                                    <th class="width-100">Current Bid</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                /* print_r($open_orders); */
                                                foreach ($get_bid_applied_order as $get) {
                                                    $created =   date('m-d-Y', strtotime($get['created']));
                                                    $time = date('H:i:s', strtotime($get['created']));
                                                    $pickup_date =  date('m-d-Y', strtotime($get['pickup_date']));
                                                    $fleet_type =  $get['fleet_type'];
                                                    $transit_time = $get['transit_time'];
                                                    $comments = $get['comments'];
                                                    $amount =  $get['amount'];
                                                    $trans_name =  $get['trans_name'];

                                                    $this->db->select('MIN(bid_amount) as lowest_amount, unit');
                                                    $this->db->from('dbo.bidding_orders');
                                                    $this->db->where('order_id', $get['order_id']);
                                                    $this->db->group_by('unit');
                                                    $q2 = $this->db->get()->row();
                                                    ?>
                                                    <tr>
                                                        <td><a href='<?php echo base_url(); ?>index.php/admin/order_overview?id=<?php echo $get['order_id'] ?>'><?php echo $get['order_id'] ?></a></td>
                                                        <td><?php echo $created; ?></td>
                                                        <td><?php echo $time; ?></td>
                                                        <td> <strong class="highlight" style="font-size:20px;"><?php echo $q2->lowest_amount; ?> <span style="font-size:15px;"><?php echo $q2->unit; ?></span></strong></td>
                                                        <td><?php echo $get['trans_name'] ?></td>
                                                        <td><?php echo $amount ?></td>

                                                    </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="task-progress col-md-12 allview">
                                        <div class="row">
                                            <a class="btn btn-primary" href="<?php echo base_url(); ?>index.php/admin/get_bid_applied_order">View All</a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <!-- page end-->
                        <section class="panel">
                            <!--<header class="panel-heading">Track Vehicle
                        </header>
                        <div class="panel-body">
                            <div id="map" style="height:400px; width:100%;"></div>
                        </div>-->
                        </section>
                    </div>
                </div>
            </section>
        </section>
        <!--main content end-->
        <!-- <div id="faade"></div>
      <div id="modaal">
        <!-- <img id="loader" src="<?php echo base_url(); ?>images/ajax-loader.gif" />
      </div>-->
        <div class="modal fade modal-dialog-center" id="myModal6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content-wrap">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Confirmation</h4>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo base_url(); ?>index.php/admin/open_for_bid_order" method="post" enctype="multipart/form-data">
                                <p>Are you sure you want to open order for bid?</p>
                                <input type="hidden" value='' name='open_bid_id' id='open_bid_id'>
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
        <div class="modal fade modal-dialog-center" id="myModal1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content-wrap">
                    <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/admin/update_order_details">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Edit Details</h4>
                            </div>
                            <input type='hidden' id="orderid" name="order_id" value=''>
                            <div class="modal-body">
                                <div class="">
                                    <div class="form-group">
                                        <input type="hidden" id="trans_name" value="">
                                        <div class="col-md-12">
                                            <select class="js-example-basic-single" id="transporter_id" name="transporter_id">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-11">
                                            <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" class="input-append date dpYears">
                                                <input type="text" readonly="" size="16" id='delivery_date' name="delivery_date" class="form-control">
                                                <span class="input-group-btn add-on">
                                                    <button class="btn btn-danger" type="button"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                            <span class="help-block">Select Dispatch Date</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                <button class="btn btn-danger" type="submit"> Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal modal-dialog-center fade" id="cancel_model">
            <div class="modal-dialog modal-sm">
                <div class="v-cell">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Confirmation</h4>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo base_url(); ?>index.php/admin/cancel_order" method="post" enctype="multipart/form-data">
                                <p>Are you sure you want to Cancel order?</p>
                                <input type="hidden" value='' name='cancel_order_id' id='cancel_order_id'>
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
        <!--footer start-->
        <?php
        include "includes/footer.php";
        ?>
        <!--footer end-->
    </section>
    <!-- js placed at the end of the document so the pages load faster -->
    <!--<script type="text/javascript" src="https://cdn.rawgit.com/hilios/jQuery.countdown/2.1.0/dist/jquery.countdown.min.js"></script>-->
    <script type="text/javascript">
        function update_transporter(trans_id, company, order_key) {
            $.ajax({

                type: 'post',
                url: '<?php echo base_url(); ?>index.php/transporter/update_transporter',
                data: 'trans_id=' + trans_id + '&company=' + company + '&order_key=' + order_key,
                success: function(res) {
                    /*  alert(res); */

                }
            });
        }
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.countdown.min.js"></script>
    <script>
        $(function() {

            $('.countdown').each(function() {
                $a = $(this).attr('value');
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
        $(function() {
            $("#datepicker").datepicker({
                minDate: 0
            });
        });

        $("#select2Input").select2({
            dropdownParent: "#modal-container"
        });

        //owl carousel

        $(document).ready(function() {
            $(".js-example-basic-single").select2();

            $("#owl-demo").owlCarousel({
                navigation: true,
                slideSpeed: 300,
                paginationSpeed: 400,
                singleItem: true,
                autoPlay: true


            });
            $('.cancel').click(function() {
                $id = $(this).attr("name");
                $('#cancel_order_id').val($id);
            });
            $('.open').click(function() {
                $id = $(this).attr("name");
                $('#open_bid_id').val($id);
            });
            $('.update').on('click', function() {
                $id = $(this).attr("value");
                $trans_name = $(this).attr("name");
                $delivery_date = $(this).attr("id");
                $company = $(this).attr("company");
                // alert($id); 
                $('#orderid').val($id);
                $('#delivery_date').val($delivery_date);
                $('#trans_name').val($trans_name);



                $.ajax({

                    type: 'post',
                    url: '<?php echo base_url(); ?>index.php/admin/transporter_list',
                    data: 'company=' + $company,
                    success: function(res) {
                        /*  alert(res); */
                        var obj = jQuery.parseJSON(res);
                        if (obj) {
                            $(obj).each(function() {
                                var option = $('<option />');
                                if (this.name == $trans_name) {
                                    option.attr({
                                        'value': this.user_id,
                                        'selected': "selected"
                                    }).text(this.name + ' (' + this.state_code + ')');
                                } else {
                                    option.attr('value', this.user_id).text(this.name + ' (' + this.state_code + ')');
                                }

                                $('#transporter_id').append(option);
                            });
                        } else {
                            $('#transporter_id').html('<option value="">Transporter not available</option>');
                        }
                    }
                });

            });

        });
        $(".knob").knob();
        //custom select box


        $(window).on("resize", function() {
            var owl = $("#owl-demo").data("owlCarousel");
            owl.reinit();
        });
        var values = [],
            labels = [],
            legends = true,
            legendsElement = $('#TicketByDepartmentLegends'),
            colors = ['#f00', '#ff6600', '#7cbe88', '#018301'];

        $("#TicketByDepartment tr").each(function() {
            values.push(parseInt($("td", this).text(), 10));
            labels.push($("th", this).text());
        });

        $("#TicketByDepartment").hide();
        var r = Raphael("DonutTicketsByDepartment", 200, 200);
        r.donutChart(100, 100, 88, 35, values, labels, colors, legends, legendsElement, colors);
    </script>
    <script>
        $(document).ready(function() {
            $("#dynamic-table1").dataTable();
            $("#dynamic-table2").dataTable();
            $("#dynamic-table3").dataTable();
            $("#dynamic-table4").dataTable();
            $("#dynamic-table5").dataTable();
            $("#dynamic-table6").dataTable();
        });
        $("#dynamic-table4 tbody tr").on("click", function() {
            console.log($(this).text());
        });
    </script>
</body>

</html>