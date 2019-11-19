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
           <section class="wrapper">
              <!-- page start-->
				<div class="row" style="margin:10px">
					<div class="col-lg-12">
						<h3>Import Dispatchs Order from Excel</h3>
					</div>

					 	<?php
					        // echo 'Hello';
					        if ( isset($_POST["submit"]) ) {
					            // echo 'Hello 3';
					            //echo $_FILES["file"]["name"];
					            //echo '<br/>';
					            $this->load->database();
					            $path = $_FILES["file"]["tmp_name"];
								$object = PHPExcel_IOFactory::load($path);
								$query = '';
								foreach($object->getWorksheetIterator() as $worksheet)
								{
									$highestRow = $worksheet->getHighestRow();
									$highestColumn = $worksheet->getHighestColumn();
									// echo $highestColumn;
									for($row=2; $row<=$highestRow; $row++)
									{
										//echo '<br/>';
										// echo $worksheet->getCellByColumnAndRow(0, $row)->getValue();
										// echo '  '.$worksheet->getCellByColumnAndRow(1, $row)->getValue();
										$order_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
										$item_code = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
										$description = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
										$route = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
										$ship_to_name = $worksheet->getCellByColumnAndRow(4, $row)->getValue();	
										$company = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
										$party_order_no = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
										$bidding_amount = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
										$cust_no = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
										$trans_no = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
										$quantity = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
										$delivery_date = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
										// echo ' '.$delivery_date;
										$ship_to_address = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
										$ship_to_address_2 = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
										$ship_to_post_code = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
										$ship_to_city = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
										$sales_order_number = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
										$status = 'Released';

										if($row > 2)
										{
										$query = $query. ";INSERT INTO [dbo].[sales_dispatched_order] ([order_id] ,[item_code],[description],[route] ,
												[ship_to_name], [company] ,[status],
												[party_order_no] ,[bidding_amount] ,[cust_no] ,[trans_no] ,[quantity] ,[qty_to_ship] ,[delivery_date] ,[req_delivery_date] ,
												[promised_delivery_date] ,[planned_delivery_date] ,[ship_to_address] ,[ship_to_address_2] ,[Ship_to_Post_Code] ,[ship_to_city],
												[sales_order_number] ,[initial_posting_date])
													VALUES ('".$order_id. "', '".$item_code. "', '".$description. "', '".$route. "', '".$ship_to_name. "', '".$company. "', '".$status. "', '".$party_order_no. "', '".	$bidding_amount. "', '".$cust_no. "', '".$trans_no. "', '".$quantity. "', '".$quantity. "', '".$delivery_date. "', '".$delivery_date. "', '".$delivery_date. "', '".$delivery_date. "', '".$ship_to_address. "', '".$ship_to_address_2. "', '".$ship_to_post_code. "', '".$ship_to_city. "', '".$sales_order_number. "', '".$delivery_date  ."')";
												}
												else
												{
													$query = $query. "INSERT INTO [dbo].[sales_dispatched_order] ([order_id] ,[item_code],[description],[route] ,
												[ship_to_name], [company] ,[status],
												[party_order_no] ,[bidding_amount] ,[cust_no] ,[trans_no] ,[quantity] ,[qty_to_ship] ,[delivery_date] ,[req_delivery_date] ,
												[promised_delivery_date] ,[planned_delivery_date] ,[ship_to_address] ,[ship_to_address_2] ,[Ship_to_Post_Code] ,[ship_to_city],
												[sales_order_number] ,[initial_posting_date])
													VALUES ('".$order_id. "', '".$item_code. "', '".$description. "', '".$route. "', '".$ship_to_name. "', '".$company. "', '".$status. "', '".$party_order_no. "', '".	$bidding_amount. "', '".$cust_no. "', '".$trans_no. "', '".$quantity. "', '".$quantity. "', '".$delivery_date. "', '".$delivery_date. "', '".$delivery_date. "', '".$delivery_date. "', '".$ship_to_address. "', '".$ship_to_address_2. "', '".$ship_to_post_code. "', '".$ship_to_city. "', '".$sales_order_number. "', '".$delivery_date  ."')";
												}

										
										// echo $query;
										
										

									}
									echo '<b>Your data inserted sucessfully.</b>';
									$query = $this->db->query($query);
									return $query->result_array();
									echo '<b>Please visit dashboard to see the change.</b>';

									
								}

					       
					        }
					     ?>
	
                      <section class="panel">
                          <header class="panel-heading">
                             Import Data
                          </header>
						   <div class="panel-body">
	                            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
						            <h3>Upload Your File </h3>
						            <input type ="file" name="file" class ="form-control" style="width:450px" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >
						            <input type ="submit" name="submit" class ="btn btn-info" style="margin:20px;>
						        </form>
							</div>
						</section>
					</div>
				</div>
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

    <!-- js placed at the end of the document so the pages load faster -->

  </body>
</html>

