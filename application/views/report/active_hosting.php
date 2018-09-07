<?php require('include/header.php');?>
	
	<script>
	function getClientInfo(data){
		//alert(SCRIPT_URL);
		/*$.post(SCRIPT_URL+"dashboard/domain_search/", {data: data}, function(res){
			$("#search_id").html(res);
		});*/
		var from_date = $("#registration_date").val();
		var to_date = $("#endDate").val();
		
		$.post(SCRIPT_URL+"report/active_hosting_report_ajax/", {data: data, from_date: from_date, to_date : to_date}, function(res){
			$("#show_report").html(res);
		});
		//alert(to_date);
		
	}
	$(function(){
		//alert();
		getClientInfo();
	});
	</script>
	
	
	
	<div class="card card-register mx-auto mt-12">
      <div class="card-header"><?= $MSG;?></div>
      <div class="card-body">
        <form action="" method="POST">
           <div class="form-group">
            <label for="exampleInputEmail1">Client Select</label>
            <select id="customer_id" name="customer_id" onchange="getClientInfo(this.value);" required="" autofocus="">   
				 <option value="">Select Client</option>                                       	
				<?= $this->user_model->select_client_table('');?>
			</select>
					
		  </div>
		   <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputEmail1">From date </label>
				<input class="form-control" id="registration_date" name="fromDate" onchange="getClientInfo(customer_id.value);" value=""  type="date" placeholder="Enter from date">
			  </div>
              <div class="col-md-6">
                <label for="exampleInputLastName">To date</label>
               <input class="form-control" id="endDate" name="endDate" required="" value=""  onchange="getClientInfo(customer_id.value);" type="date"  placeholder="Enter to date">
              </div>
            </div>
          </div>
		 </form>
      </div>
	  </div>
	  <div class="card mb-3" style="margin:4px;">
        <div class="card-header">
          <i class="fa fa-table"></i> Report
		  
		  </div>
        <div class="card-body">
          <div class="table-responsive" id="show_report">
				  
				   
          </div>
        </div>
       
      </div>
    
	 <?php require('include/footer.php');?>