<!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Hosting Management 2017</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="<?= SITE_URL;?>logout">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
   
    <script src="<?= CSS_URL;?>vendor/popper/popper.min.js"></script>
    <script src="<?= CSS_URL;?>vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?= CSS_URL;?>vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="<?= CSS_URL;?>vendor/chart.js/Chart.min.js"></script>
    <script src="<?= CSS_URL;?>vendor/datatables/jquery.dataTables.js"></script>
    <script src="<?= CSS_URL;?>vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?= CSS_URL;?>js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="<?= CSS_URL;?>js/sb-admin-datatables.min.js"></script>
    <script src="<?= CSS_URL;?>js/sb-admin-charts.min.js"></script>
	
	<!--search for select box-->
  <script type="text/javascript" src="<?= CSS_URL;?>search/sol.js"></script>
   <script>
	$(function() {
		$('#customer_id, #domain_id').searchableOptionList({
			showSelectAll: true
		});
	}); 
	</script>
	
  <!--Date picker plugin-->
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	 <script>
	  $(document).ready(function() {
	   $("#registration_date, #endDate").datepicker({ dateFormat: "yy-mm-dd",
		beforeShow: function(input, inst) {
		 if ($("#dateplanedcheck").is(':checked')) {
		  $(".ui-datepicker-calendar").css("display", "none");
		}}
	   });
	  });
	 
	</script>
	
	
	<script type="text/javascript">     
    function PrintDiv() {    
          var divToPrint = document.getElementById('divToPrint');
          var popupWin = window.open('', '_blank', 'width=auto,height=auto,');
          popupWin.document.open();
          popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="'+SCRIPT_URL+'plugin/css/sb-admin.css"/> <link rel="stylesheet" type="text/css" href="'+SCRIPT_URL+'plugin/vendor/bootstrap/css/bootstrap.min.css"/><link rel="stylesheet" type="text/css" media="all" href="'+SCRIPT_URL+'plugin/print/print.css"/></head><body onload="window.print();window.close();"><center>' + divToPrint.innerHTML + '<center></html>');
          popupWin.document.close();
        }
   function PrintDiv1() {    
          var divToPrint = document.getElementById('divToPrint1');
          var popupWin = window.open('', '_blank', 'width=auto,height=auto,');
          popupWin.document.open();
          popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="'+SCRIPT_URL+'plugin/css/sb-admin.css"/> <link rel="stylesheet" type="text/css" href="'+SCRIPT_URL+'plugin/vendor/bootstrap/css/bootstrap.min.css"/><link rel="stylesheet" type="text/css" media="all" href="'+SCRIPT_URL+'plugin/print/print.css"/></head><body onload="window.print();window.close();"><center>' + divToPrint.innerHTML + '<center></html>');
          popupWin.document.close();
        }
 </script>
  </div>
</body>

</html>