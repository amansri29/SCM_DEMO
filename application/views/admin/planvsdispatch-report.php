
 <?php
      include "includes/header.php";
      ?>


<head>

     <script type="text/javascript" src="<?php echo base_url();?>assets/reports/js/jquery-1.10.2.min.js"></script>

    
     <script type="text/javascript" src="<?php echo base_url();?>assets/reports/bootstrap/js/bootstrap.min.js"></script>
</head>
  <body>


                                   
                                     
  <section id="container" class="">         

     

     <?php
   include "includes/admin_sidebar.php";
   ?>



     <br>


     <div class="container" style="padding: 30px">

     <div class="page-header">
     <h2>Plan Vs Dispatch Report</h2>
     </div>

     <!-- Export a Table to Excel - START -->


     <div class="container" style="margin-bottom: 40px">
     <button id="exportButton" class="btn btn-lg btn-danger clearfix" style="margin-bottom: 20px"><span class="fa fa-file-excel-o"></span> Export to Excel</button>

     <table id="exportTable" class="table table-striped table-bordered" data-toggle="table"
          data-sortable="true">
          <thead class="thead-dark" style="color: white" >
               <tr> 
                    <th data-sortable="true">Dispatch_Date</th>
                    <th >Company</th>
                    <th >DO_No</th>
                    <th>Quantity</th>
                    <th data-sortable="true">Planned_Dispatch_Date</th>
                    <th>Item_Desc</th>
                    <th>Route</th>
                    <th>Sales_Order_No</th>
                    <th data-sortable="true">Status</th>
               </tr>
          </thead> 
          <?php
          
          echo '<tbody>';
          
          foreach ($data as $get)
          {
             echo '<tr>';
             echo  '<td>'.$get['dispatch_date'].'</td>';
             echo  '<td>'.$get['company'].'</td>';
             echo   '<td>'.$get['DO_No'].'</td>';
             echo   '<td>'.$get['shipping_qty'].'</td>';
             echo   '<td>'.$get['planned_dispatch_date'].'</td>';
             echo   '<td>'.$get['item_desc'].'</td>';
             echo   '<td>'.$get['route'].'</td>';
             echo   '<td>'.$get['sales_order_number'].'</td>';
             echo   '<td>'.$get['dispatch_status'].'</td>';
             echo '</tr>';   
          }
                                 
                                                                                   
          echo '</tbody>';


          ?>
     </table> 
     </div>

     <!-- you need to include the shieldui css and js assets in order for the components to work -->
     <link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
     <script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
     <script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/jszip.min.js"></script>


    <link href="https://unpkg.com/bootstrap-table@1.15.4/dist/bootstrap-table.min.css" rel="stylesheet">

    <script src="https://unpkg.com/bootstrap-table@1.15.4/dist/bootstrap-table.min.js"></script>






     <script type="text/javascript">
     jQuery(function ($) {
          $("#exportButton").click(function () {
               // parse the HTML table element having an id=exportTable
               var dataSource = shield.DataSource.create({
                    data: "#exportTable",
                    schema: {
                         type: "table",
                         fields: {
                         Dispatch_Date: { type: Date },
                         Company: { type: String },
                         DO_No: { type: String },
                         Quantity: { type: Number },
                         Planned_Dispatch_Date: { type: String },
                         Item_Desc: {type: Number },
                         Route: { type: String },
                         Sales_Order_No: { type: String },
                         Status: { type: String }
                         }
                    }
               });

               // when parsing is done, export the data to Excel
               dataSource.read().then(function (data) {
                    new shield.exp.OOXMLWorkbook({
                         author: "Aman Srivastav",
                         worksheets: [
                         {
                              name: "Plan Vs Dispatch Report",
                              rows: [
                                   {
                                        cells: [
                                             {
                                             style: {
                                                  bold: true
                                             },
                                             type: String,
                                             value: "Dispatch Date"
                                             },

                                             {
                                             style: {
                                                  bold: true
                                             },
                                             type: String,
                                             value: "Company"
                                             },
                                             {
                                             style: {
                                                  bold: true
                                             },
                                             type: String,
                                             value: "DO_No"
                                             },
                                             {
                                             style: {
                                                  bold: true
                                             },
                                             type: String,
                                             value: "Quantity"
                                             },
                                             {
                                             style: {
                                                  bold: true
                                             },
                                             type: String,
                                             value: "Planned_Dispatch_Date"
                                             },
                                             {
                                             style: {
                                                  bold: true
                                             },
                                             type: String,
                                             value: "Item"
                                             },
                                             {
                                             style: {
                                                  bold: true
                                             },
                                             type: String,
                                             value: "Route"
                                             },
                                             {
                                             style: {
                                                  bold: true
                                             },
                                             type: String,
                                             value: "Sales_Order_No"
                                             },
                                             {
                                             style: {
                                                  bold: true
                                             },
                                             type: String,
                                             value: "Status"
                                             }
                                        ]
                                   }
                              ].concat($.map(data, function(item) {
                                   return {
                                        cells: [
                                             { type: Date, value: item.Dispatch_Date },
                                             { type: String, value: item.Company },  
                                             { type: String, value: item.DO_No },
                                             { type: Number, value: item.Quantity },  
                                             { type: String, value: item.Planned_Dispatch_Date },  
                                             { type: String, value: item.Item_Desc},
                                             { type: String, value: item.Route },  
                                             { type: String, value: item.Sales_Order_No },  
                                             { type: String, value: item.Status }
                                        ]
                                   };
                              }))
                         }
                         ]
                    }).saveAs({
                         fileName: "PlanVsDispatchReport"
                    });
               });
          });
     });
     </script>

<!--footer start-->
     <?php
      include "includes/footer.php";
      ?>
      <!--footer end-->
  </section>

</body>
</html> 