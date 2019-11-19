<!DOCTYPE html>
<html>
<head>
	<title>How to Import Excel Data into Mysql in Codeigniter</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/bootstrap.min.css" />
	<script src="<?php echo base_url(); ?>asset/jquery.min.js"></script>
</head>

<body>

						<?php
					        echo 'Hello';
					        if ( isset($_POST["import"]) ) {
					            echo 'Hello 3';
					            echo $_FILES["file"]["name"];
					            $path = $_FILES["file"]["tmp_name"];
								$object = PHPExcel_IOFactory::load($path);
								foreach($object->getWorksheetIterator() as $worksheet)
								{
									$highestRow = $worksheet->getHighestRow();
									$highestColumn = $worksheet->getHighestColumn();
									for($row=2; $row<=$highestRow; $row++)
									{
										echo '<br/>';
										echo $worksheet->getCellByColumnAndRow(0, $row)->getValue();
										// $address = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
										// $city = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
										// $postal_code = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
										// $country = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
										
									}
								}

					       
					        }
					     ?>
   

	<div class="container">
		<br />
		<h3 align="center">Import Excel Data</h3>
		<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" id="import_form" enctype="multipart/form-data">
			<p><label>Select Excel File</label>
			<input type="file" name="file" id="file" required accept=".xls, .xlsx" /></p>
			<br />
			<input type="submit" name="import" value="Import" class="btn btn-info" />
		</form>
		<br />
		<div class="table-responsive" id="customer_data">

		</div>
	</div>
</body>
</html>


</script>
