<?php require('include/header.php');?>
	
	<script>
	function getClientInfo(data){
		//alert(SCRIPT_URL);
		$.post(SCRIPT_URL+"dashboard/domain_search/", {data: data}, function(res){
			$("#search_id").html(res);
		});
	}
	
	
	
	function changeYear(date, limit){
		var dateParts = date.split('-');
		var intYear = parseInt(dateParts[0]) + parseInt(limit);
		var current_date = intYear+'-'+dateParts[1]+'-'+dateParts[2];
		
		$("#endDate").val(current_date);
	}
	</script>
	
	
	
	<div class="card card-register mx-auto mt-5">
      <div class="card-header"><?= $MSG;?></div>
      <div class="card-body">
        <form action="" method="POST">
           <div class="form-group">
            <label for="exampleInputEmail1">Client Select</label>
            <select id="customer_id" name="customer_id" onchange="getClientInfo(this.value);" required="" autofocus="">   
				 <option value="">Select Client</option>                                       	
				<?= $this->user_model->select_client_table($CLIENTS_ID);?>
			</select>
			<div id="search_id">
			
			</div>			
		  </div>
		  <div class="form-group">
            <label for="exampleInputEmail1">Domain Name</label>
            <input class="form-control" id="domain_name" name="domain_name" required="" value="<?= $DOMAIN_NAME;?>"  type="text" aria-describedby="emailHelp" placeholder="Enter domain name">
          </div>
		   <div class="form-group">
            <label for="exampleInputEmail1">Domain url</label>
            <input class="form-control" id="domain_url" name="domain_url" required="" value="<?= $DOMAIN_URL;?>"  type="text" aria-describedby="emailHelp" placeholder="Enter domain url">
          </div>
		  <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
              
					<label for="exampleInputEmail1">From Country</label>
					<input class="form-control" id="COUNTRY" list="company" name="COUNTRY" required="" value="<?= $COUNTRY;?>"  type="text" aria-describedby="emailHelp" placeholder="Enter country from">
					<datalist id="company">
						<option value="Bangladesh">
						<option value="Ireland">
						<option value="India">
					</datalist>
			  </div>
              <div class="col-md-6">
				<label for="exampleInputEmail1">Registration From</label>
					<input class="form-control" list="res_form" id="REGISTAR_FROM" name="REGISTAR_FROM" required="" value="<?= $REGISTAR_FROM;?>"  type="text" aria-describedby="emailHelp" placeholder="Enter registration from">
					<datalist id="res_form">
						<option value="Godaddy">
						<option value="Namecheap">
						<option value="BTCL">
					</datalist>
			  </div>
            </div>
          </div>
		 
		  
		  <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Registration Date</label>
                <input class="form-control" id="registration_date" onchange="changeYear(this.value, year.value);" required="" name="registration_date" type="date" aria-describedby="nameHelp" value="<?= $START_DATE;?>" required="" placeholder="Enter start date">
              </div>
              <div class="col-md-6">
                <label for="exampleInputLastName">Reg. Year</label>
                <input class="form-control" id="year" name="year" required="" onchange="changeYear(registration_date.value, this.value);" type="number" start="1" min="1" value="<?= $LIMIT_YEAR;?>"  aria-describedby="nameHelp" placeholder="">
              </div>
            </div>
          </div>
		   
		   <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputEmail1">End Date of domain</label>
				<input class="form-control" id="endDate" name="endDate" required="" value="<?= $END_DATE;?>"  type="date" aria-describedby="emailHelp" placeholder="Enter email">
			  </div>
              <div class="col-md-6">
                <label for="exampleInputLastName">Total Amount</label>
                <input class="form-control" id="TOTAL_AMOUNT" name="TOTAL_AMOUNT" required="" type="number" start="1" min="1" value="<?= $TOTAL_AMOUNT;?>"  aria-describedby="nameHelp" placeholder="">
              </div>
            </div>
          </div>
		  <div class="form-group">
            <div class="form-row">
              
              <div class="col-md-6">
                <label for="exampleInputLastName">Payment</label>
                <input class="form-control" id="amount" name="amount" required="" type="number" start="0" min="0" value="<?= $AMOUNT;?>"  aria-describedby="nameHelp" placeholder="">
              </div>
			  <div class="col-md-6">
                <label for="exampleInputEmail1">Expense</label>
				<input class="form-control" id="EXPENSE" name="EXPENSE" value="<?= $EXPENSE;?>"  type="text" aria-describedby="emailHelp" placeholder="Enter Expense amount">
				
			  </div>
            </div>
          </div>
          
           <div class="form-group">
            <label for="exampleInputEmail1">Short discription</label>
           <textarea class="form-control" name="address" id="address" rows="2" cols="30" placeholder="Write down client address"><?= $DISCRIPTION;?> </textarea>
          </div>
		  <?php
		  if($edit_data > 0){
			 // echo $DOMIAN_STATUS;
			  $arraySta = array('Active', 'DeActive', 'Delete');
			  
		  ?>
		   <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputEmail1">Status</label>
				<select id="status" name="status" class="form-control" >
					<?php
					foreach($arraySta AS $value){
						if(strlen($value) > 0){
					?>
					<option value="<?= $value;?>" <?php if($DOMIAN_STATUS == $value){ echo 'selected="selected"';}?>><?= $value;?> </option>
					<?php
						}
					}
					?>
					
				</select>
			  </div>
              
            </div>
          </div>
		  <?php }?>
          <button class="btn btn-primary btn-block" name="submit" type="submit" ><?= $BUTON;?></button>
		  </div>
        </form>
        <!--<div class="text-center">
          <a class="d-block small mt-3" href="login.html">Login Page</a>
          <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
        </div>-->
      </div>
	  
	   <div class="card mb-3" style="margin:4px;">
        <div class="card-header">
          <i class="fa fa-table"></i> Domain List</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th align="center">SL#</th>
                  <th>Name</th>
                  <th>Domain Url</th>
                  <th>Start date</th>
                  <th>Reg. Year</th>
                  <th>End date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tfoot>
               <tr>
                  <th align="center">SL#</th>
                  <th>Name</th>
                  <th>Domain Url</th>
                  <th>Start date</th>
                  <th>Reg. Year</th>
                  <th>End date</th>
                  <th>Action</th>
                </tr>
              </tfoot>
			  <tbody>
			  <?php
				$dataArray = $this->user_model->domainInfo();
				if(is_array($dataArray) AND sizeof($dataArray) > 0){
					$i = 1;
					foreach($dataArray AS $data){
						$dataArray1 = $this->user_model->renewInfo($data->DOMAIN_ID);
				?>
					 <tr>
					  <td align="center"><?= $i; ?></td>
					  <td><?= $data->DOMAIN_NAME; ?></td>
					  <td><?= $data->DOMAIN_URL; ?></td>
					  <td><?= $this->user_model->date_format_orginal($dataArray1[0]->START_DATE); ?></td>
					  <td align="center"><?= $dataArray1[0]->LIMIT_YEAR; ?></td>
					  <td><?= $this->user_model->date_format_orginal($dataArray1[0]->END_DATE); ?></td>
					  <td align="center"> 
					  <a href="<?= SITE_URL;?>dashboard/domain/<?= $data->DOMAIN_ID; ?>/"><span class="fa fa-edit" title="Edit"></span></a>
					  <a href="<?= SITE_URL;?>dashboard/domain_renew/<?= $data->DOMAIN_ID; ?>/"><span class="fa fa-fw fa-plus" title="Renew"> </span></a>
					  </td>
					</tr>
				<?php
					$i++;
					}
				}else{
					echo '<tr><td colspan="6"> No entry client information</td></tr>';
				}
			  ?>
              </tbody>
               
                
            </table>
          </div>
        </div>
       
      </div>
    </div>
	 <?php require('include/footer.php');?>