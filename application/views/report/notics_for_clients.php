<?php require('include/header.php');?>
	
	<script>
	function getClientInfo(data){		
		var from_date = $("#registration_date").val();
		var to_date = $("#endDate").val();
		
		$.post(SCRIPT_URL+"report/active_notics_report_ajax/", {data: data, from_date: from_date, to_date : to_date}, function(res){
			$("#show_report").html(res);
		});
		
	}
	$(function(){
		//alert();
		getClientInfo();
	});
	
	</script>
	
	<?php
		if(isset($_POST['submit_data'])){
			$info = isset($_POST['select_check']) ? $_POST['select_check']: '';
			if(is_array($info) AND sizeof($info) > 0){
				//echo '<pre>'; print_r($info);
				
			}
		}
		?>
		
	
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
		  
		 </form>
      </div>
	  </div>
	  <div class="card mb-3" style="margin:4px;">
        <div class="card-header">
          <i class="fa fa-table"></i> Notics
		 </div>
        <div class="card-body">
          <div class="table-responsive" id="show_report">
				 
				  
				   
          </div>
        </div>
       
      </div>
    
	 <?php require('include/footer.php');?>