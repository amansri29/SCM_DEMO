
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
     <h2>Dispatch Delay Report  <small>(In Days)</small></h2>
     </div>

     <!-- Export a Table to Excel - START -->


     <div class="container">
     <button id="exportButton" class="btn btn-lg btn-danger clearfix" style="margin-bottom: 20px"><span class="fa fa-file-excel-o"></span> Export to Excel</button>

     <table id="exportTable" class="table table-striped table-bordered" data-toggle="table"
          data-sortable="true">
          <thead class="thead-dark" style="color: white" >
               <tr> 
                    <th data-sortable="true">Placement_Date</th>
                    <th data-sortable="true">Planned_Date</th>
                    <th data-sortable="true">Delay</th>
                    <th>Dispatch_Order</th>
               </tr>
          </thead> 
          <?php
          // $serverName = "45.114.141.43"; //serverName\instanceName
          // $connectionInfo = array( "Database"=>"SCM_LIVE", "UID"=>"aman.srivastav", "PWD"=>"Change@123");
          // $conn = sqlsrv_connect( $serverName, $connectionInfo);

          // if( $conn ) {
          //      // echo "Connection established.<br />";
          // }else{
          //      echo "Connection could not be established.<br />";
          //      die( print_r( sqlsrv_errors(), true));
          // }

          // $query = "select * from DelayReport order by [Placement Date] desc";

          // $result = sqlsrv_query($conn, $query);

          // if( $result === false ) {
          //      die( print_r( sqlsrv_errors(), true));
          // }

          // else
          // {
          //     print($result) ;
          echo '<tbody>';
          // while( $obj = sqlsrv_fetch_object( $result )) {

          //      // echo $obj->Planned_Date.'<br/>';
          //      echo '<tr>';
          //      echo  '<td>'.$obj->{"Placement Date"}.'</td>';
          //      echo  '<td>'.$obj->Planned_Date.'</td>';
          //      echo   '<td>'.$obj->Delay.'</td>';
          //      echo   '<td>'.$obj->{"Dispatch Order"}.'</td>';
          //      echo '</tr>';
          
          //      }



          foreach ($data as $get)
          {
             echo '<tr>';
             echo  '<td>'.$get['Placement Date'].'</td>';
             echo  '<td>'.$get['Planned_Date'].'</td>';
             echo   '<td>'.$get['Delay'].'</td>';
             echo   '<td>'.$get['Dispatch Order'].'</td>';
             echo '</tr>';   
          }
                                 
                                                    
                                    
          echo '</tbody>';
          // }


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
                         Planned_Date: { type: Date },
                         Placement_Date: { type: Date },
                         Delay: { type: Number },
                         Dispatch_Order: { type: String },
                         }
                    }
               });

               // when parsing is done, export the data to Excel
               dataSource.read().then(function (data) {
                    new shield.exp.OOXMLWorkbook({
                         author: "Aman Srivastav",
                         worksheets: [
                         {
                              name: "SCM - Delay Report",
                              rows: [
                                   {
                                        cells: [
                                             {
                                             style: {
                                                  bold: true
                                             },
                                             type: String,
                                             value: "Placement Date"
                                             },
                                             {
                                             style: {
                                                  bold: true
                                             },
                                             type: String,
                                             value: "Planned Date"
                                             },
                                             {
                                             style: {
                                                  bold: true
                                             },
                                             type: String,
                                             value: "Delay(days)"
                                             },
                                             {
                                             style: {
                                                  bold: true
                                             },
                                             type: String,
                                             value: "Dispatch Order"
                                             }
                                        ]
                                   }
                              ].concat($.map(data, function(item) {
                                   return {
                                        cells: [
                                             { type: Date, value: item.Placement_Date },
                                             { type: Date, value: item.Planned_Date },  
                                             { type: Number, value: item.Delay },
                                             { type: String, value: item.Dispatch_Order }
                                        ]
                                   };
                              }))
                         }
                         ]
                    }).saveAs({
                         fileName: "DelayReport"
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