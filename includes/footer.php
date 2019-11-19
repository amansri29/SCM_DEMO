  <!-- Footer -->
   <footer class="site-footer" style="background-color: seagreen">
          <div class="text-center">
              2018 &copy; SCM
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
    <!-- // Footer -->
	  <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/plugins/jquery-knob/js/jquery.knob.js"></script>
    <script src="<?php echo base_url();?>assets/js/respond.min.js" ></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
  <!--right slidebar-->
  <script src="<?php echo base_url();?>assets/js/slidebars.min.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
 	<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
	 <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/ckeditor/ckeditor.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
    <!--common script for all pages-->
    <script src="<?php echo base_url();?>assets/js/common-scripts.js"></script>
	 <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/select2/js/select2.min.js"></script>
	 
  <!--this page plugins-->


  <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/jquery-multi-select/js/jquery.quicksearch.js"></script>


  <!--this page  script only-->
  <script src="<?php echo base_url();?>assets/js/advanced-form-components.js"></script>

   
	
	 <script type="text/javascript" src="<?php echo base_url();?>assets/js/modernizr.custom.js"></script>
	 <script src="<?php echo base_url();?>assets/js/soon/plugins.js"></script>
    <script src="<?php echo base_url();?>assets/js/soon/custom.js"></script>

    <script src="<?php echo base_url();?>assets/js/jquery.sparkline.js" type="text/javascript"></script>

 <script src="<?php echo base_url();?>assets/js/owl.carousel.js" ></script>
  
  <script type="text/javascript" src="https://rawgithub.com/rathoreahsan/Interactive-Charts/master/raphael.js"></script>
<script type="text/javascript" src="https://rawgithub.com/rathoreahsan/Interactive-Charts/master/donut-chart.js"></script> 
    <!--script for this page-->
    <script src="<?php echo base_url();?>assets/js/jquery.customSelect.min.js" ></script>
 <script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/plugins/advanced-datatable/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/data-tables/DT_bootstrap.js"></script>
  <!--dynamic table initialization -->
    <script src="<?php echo base_url();?>assets/js/dynamic_table_init.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>

	  <script>
	   setTimeout(function(){$(".success").hide(); }, 3000);
		setTimeout(function(){$(".error").hide(); }, 3000);
  $(document).ready(function(){
	   $(".js-example-basic-single").select2();
       var url  = window.location.href;
      $('.sidebar-menu li a').each(function(){
        var li_url=$(this).attr('href');
          if(li_url==url){
           $(this).parents('li').addClass('active open');
		    $(this).parents('ul').addClass('in');
           }
        });
function openModal() {
        document.getElementById('modaal').style.display = 'block';
        document.getElementById('faade').style.display = 'block';
}
function closeModal() {
    document.getElementById('modaal').style.display = 'none';
    document.getElementById('faade').style.display = 'none';
}
  
		$('#run').on('click',function()
		{
			openModal();
			$get = $('#webservice').val();
			
			/* alert($get); */
			$.ajax({
				url: $get,
				type: 'POST',
				success: function (resp) {
					closeModal();
					/* alert(resp); */
				}
			});
		});
   });
   
       
   </script>

    <script>
    $(function () {
 $('.notifications_admin').on('click',function(){
    $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>index.php/admin/notification_seen',
                data:'',
                success:function(res){
          /* alert('marked'); */
          //$( "#count_notification" ).load( "" );
          //$("#count_notification").load(location.href + " #count_notification");
          $("#count_notification").load(location.href+" #count_notification>*","");
           $("#yellow").load(location.href+" #yellow>*","");
          
                }
            });
        });
    
  });   
    function myFnn(id)    {     var id = id;           $('#idsss').val(id);     document.getElementById("myform").submit();       }
   </script>
    <script>
    $(function () {
 $('.notifications_cust').on('click',function(){
    $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>index.php/customer/notification_seen',
                data:'',
                success:function(res){
          /* alert('marked'); */
          //$( "#count_notification" ).load( "" );
          //$("#count_notification").load(location.href + " #count_notification");
          $("#count_notification").load(location.href+" #count_notification>*","");
           $("#yellow").load(location.href+" #yellow>*","0");
          
                }
            });
        });
    
  });   
    function myFnn(id)    {     var id = id;           $('#idsss').val(id);     document.getElementById("myform").submit();       }
   </script>
    <script>
    $(function () {
 $('.notifications_trans').on('click',function(){
    $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>index.php/transporter/notification_seen',
                data:'',
                success:function(res){
          /* alert('marked'); */
          //$( "#count_notification" ).load( "" );
          //$("#count_notification").load(location.href + " #count_notification");
          $("#count_notification").load(location.href+" #count_notification>*","");
          $("#yellow").load(location.href+" #yellow>*","");
          
                }
            });
        });
    
  });   
    function myFnn(id)    {     var id = id;           $('#idsss').val(id);     document.getElementById("myform").submit();       }
   </script>

