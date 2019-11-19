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
              <!-- invoice start-->
              <section>
                  <div class="panel panel-primary">
                      <!--<div class="panel-heading navyblue"> INVOICE</div>-->
                      <div class="panel-body">
                          <div class="row invoice-list">
                              <div class="text-center corporate-id">
                                  <h1 class="highlight">Transport Management System</h1>
                              </div>
                              <div class="col-lg-4 col-sm-4">
                                  <h4>BILLING ADDRESS</h4>
                                  <p>
                                      Jonathan Smith <br>
                                      44 Dreamland Tower, Suite 566 <br>
                                      ABC, Dreamland 1230<br>
                                      Tel: +12 (012) 345-67-89
                                  </p>
                              </div>
                              <div class="col-lg-4 col-sm-4">
                                  <h4>SHIPPING ADDRESS</h4>
                                  <p>
                                      Vector Lab<br>
                                      Road 1, House 2, Sector 3<br>
                                      ABC, Dreamland 1230<br>
                                      P: +38 (123) 456-7890<br>
                                  </p>
                              </div>
                              <div class="col-lg-4 col-sm-4">
                                  <h4>INVOICE INFO</h4>
                                  <ul class="unstyled">
                                      <li>Invoice Number		: <strong>69626</strong></li>
                                      <li>Invoice Date		: 2013-03-17</li>
                                      <li>Due Date			: 2013-03-20</li>
                                      <li>Invoice Status		: Paid</li>
                                  </ul>
                              </div>
                          </div>
                          <table class="table table-striped table-hover">
                              <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Item Code</th>
                                  <th class="hidden-phone">Description</th>
                                  
                                  <th class="">Quantity</th>
                                  <th>Route</th>
                              </tr>
                              </thead>
                              <tbody>
                              <tr>
                                  <td>1</td>
                                  <td>DIS\APR18\0220</td>
                                  <td class="hidden-phone">20 inch Philips LCD Black color monitor</td>
                                  
                                  <td class="">2</td>
                                  <td>Jaipur to Delhi</td>
                              </tr>
                              <tr>
                                  <td>2</td>
                                  <td>DIS\APR18\0220</td>
                                  <td class="hidden-phone">Apple Mac book pro 15” Retina Display. 2.8 GHz Processor,8 GB Ram</td>
                                
                                  <td class="">1</td>
                                  <td>Jaipur to Delhi</td>
                              </tr>
                              <tr>
                                  <td>3</td>
                                  <td>DIS\APR18\0220</td>
                                  <td class="hidden-phone">Apple Magic Mouse</td>
                                 
                                  <td class="">3</td>
                                 <td>Jaipur to Delhi</td>
                              </tr>
                              <tr>
                                  <td>4</td>
                                  <td>DIS\APR18\0220 </td>
                                  <td class="hidden-phone">iMac 21 inch slim body. 1.7 GHz, 8 GB Ram</td>
                                  
                                  <td class="">2</td>
                                  <td>Jaipur to Delhi</td>
                              </tr>
                              <tr>
                                  <td>5</td>
                                  <td>DIS\APR18\0220</td>
                                  <td class="hidden-phone">Epson Color Jet printer </td>
                                 
                                  <td class="">2</td>
                                  <td>Jaipur to Delhi</td>
                              </tr>
                              </tbody>
                          </table>
                          <div class="row">
						  <div class="col-lg-12">
                              <div class="col-lg-2 left padding">
								
								<div class="pro-img-details">
									<img src="<?php echo base_url();?>images/qr-code.png" alt="" style="height: 200px;"><br/>
									
								</div>
								
								<div class="margin-top" style='margin-left: -25px;'><a class="btn btn-danger btn-lg" >Scan for Gate IN & OUT </a></div>
								
                              </div>
							  
							 </div>
                          </div>
                          <div class="text-center invoice-btn">
                              
                              <a class="btn btn-info btn-lg" onClick="javascript:window.print();"><i class="fa fa-print"></i> Print </a>
                          </div>
                      </div>
                  </div>
              </section>
              <!-- invoice end-->
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

