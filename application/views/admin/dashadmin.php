<html>
<head>
     <title>Upload Image</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</head>



<body style="max-width: 100%; overflow-x: hidden;"> 


     <script>
          function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#your_image')
                        .attr('src', e.target.result)
                        .width(400)          
                        
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
     </script>


     <!-- Modal -->
     <div class="modal fade" id="uploadModal" role="dialog">
     <div class="modal-dialog">
     
          <!-- Modal content-->
          <div class="modal-content">
          <div class="modal-header">
               <h4 class="modal-title" style="float:left;">Upload An Image</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               
          </div>
          <div class="modal-body">
               <form id="myForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
                    <input type ="file" name="image_file" class ="form-control" accept="image/jpeg, image/png" onchange="readURL(this);">
                    <img id="your_image" src="#" style="margin:10px;"/>
                    <br>
                    <input type ="text" name="image_name" class ="form-control" placeholder="Image Name">
                    <br>
                    <p>Auto Delete:</p>
                    <input type="radio" name="auto_delete" value="enable" checked="checked">Enable<br>
                    <input type="radio" name="auto_delete" value="disable">Disable<br>
                    <input type ="submit" name="submit" class ="btn btn-info" style="margin:20px">
               </form>
          </div>
          <div class="modal-footer">
               <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
          </div>
          </div>
          
     </div>
     </div>
     
     </div>


     


     <?php
          //echo 'Hello';
          if ( isset($_POST["Delete"]) ) {
               //echo 'Hello 3';
               //echo $_POST["image_name"];
               $name = $this->session->userdata('name');
               if($name == 'admin' | $name == 'Kratika Jain')
               {
                    $serverName = "45.114.141.43"; //serverName\instanceName
                    $connectionInfo = array( "Database"=>"Demo Database NAV (9-0)", "UID"=>"mis", "PWD"=>"123456");
                    $conn = sqlsrv_connect( $serverName, $connectionInfo);
          
                    if( $conn ) {
                         // echo "Connection established.<br />";
                    }else{
                        // echo "Connection could not be established.<br />";
                         die( print_r( sqlsrv_errors(), true));
                    }
          
                    $query = "Delete from [dbo].[ImagesForGolchaDashBoard] where ImageName='".$_POST["image_name"]."'";
                    //print($query);
          
                    $result = sqlsrv_query($conn, $query);
          
                    if( $result === false ) {
                         die( print_r( sqlsrv_errors(), true));
                    }
               }
               else
               {
                    print("You are not authorised to perform this action.");
               }
          }


          if ( isset($_POST["submit"]) ) {
               //echo 'Hello 5';
               //echo $_POST["image_name"];
               $name = $this->session->userdata('name');
               if($name == 'admin' | $name == 'Kratika Jain')
               {
                    $user_name = "mis";
                    $auto_delete = $_POST["auto_delete"];
                    $image_name = $_POST["image_name"];
                    //echo $_FILES["image_file"]["name"];
                    $file_name =$_FILES['image_file']['name'];
                    //   $file_name =$_FILES['image']['tmp_name'];
                    $file_ext = strtolower( end(explode('.',$file_name)));


                    $file_size=$_FILES['image_file']['size'];
                    $file_tmp= $_FILES['image_file']['tmp_name'];
                    //echo $file_tmp;echo "<br>";

                    $type = pathinfo($file_tmp, PATHINFO_EXTENSION);
                    $data = file_get_contents($file_tmp);
                    $base64 = base64_encode($data);
                    //echo "Base64 is ".$base64;

                    //echo $str =  base64_encode(file_get_contents($_FILES["image_file"]));

                   

                    $serverName = "45.114.141.43"; //serverName\instanceName
                    $connectionInfo = array( "Database"=>"Demo Database NAV (9-0)", "UID"=>"mis", "PWD"=>"123456");
                    $conn = sqlsrv_connect( $serverName, $connectionInfo);
          
                    if( $conn ) {
                         // echo "Connection established.<br />";
                    }else{
                         echo "Connection could not be established.<br />";
                         die( print_r( sqlsrv_errors(), true));
                    }
          
                    $query = "Insert into [dbo].[ImagesForGolchaDashBoard] VALUES ('".$image_name."', '".$base64. "', getDate(),'".$auto_delete."', '".$name."')" ;
                    // print($query);
          
                    $result = sqlsrv_query($conn, $query);
          
                    if( $result === false ) {
                         die( print_r( sqlsrv_errors(), true));
                    }
               }
               else
               {
                    print("You are not authorised to perform this action.");
               }
     

          }


     ?>


     <div class="container" style="margin-left:300px"> 

     <div class="page-header">
     <h2>Dashboard - Templates Management</h2>
     <br/>
     <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#uploadModal" style="margin-bottom:20px;"><b>Upload a new Image</b></button>
     
     
     </div>
          <?php
          $serverName = "45.114.141.43"; //serverName\instanceName
          $connectionInfo = array( "Database"=>"Demo Database NAV (9-0)", "UID"=>"mis", "PWD"=>"123456");
          $conn = sqlsrv_connect( $serverName, $connectionInfo);

          if( $conn ) {
               // echo "Connection established.<br />";
          }else{
               echo "Connection could not be established.<br />";
               die( print_r( sqlsrv_errors(), true));
          }

          $query = "Select * from [dbo].[ImagesForGolchaDashBoard] order by Date desc";

          $result = sqlsrv_query($conn, $query);

          if( $result === false ) {
               die( print_r( sqlsrv_errors(), true));
          }

          else
          {
          //     print($result) ;
          
          while( $obj = sqlsrv_fetch_object( $result )) {
               $image = $obj->{"ImgBase64"};
               $image_name = $obj->{"ImageName"};
               

                   echo '<div class="card" style="width:600px;">';
                   echo '<form id="myForm" action="'.$_SERVER["PHP_SELF"].'" method="post">';
                   echo      '<img class="card-img-top" src="data:image/gif;base64,' . $image . '"  alt="Card image" style="width:100%">';
                   echo      '<div class="card-body">';
                    echo          '<h4 class="card-title">'.$image_name.'</h4>';
                    echo      '<input type="hidden" name="image_name" value="'.$image_name.'">';
                    echo          '<input type="submit" value="Delete" class="btn btn-primary" style="float:right;" name="Delete">';
                    echo     '</div>';
                    echo '</form>';
                    echo '</div>';

                    echo '<br/>';
                    echo '<br/>';
          
               }
          }


          ?>
       </div>
     </div>

     <!-- you need to include the shieldui css and js assets in order for the components to work -->
     <link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
     <script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
     <script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/jszip.min.js"></script>


     

</body>
</html> 