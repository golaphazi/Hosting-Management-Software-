<?php require('include/header.php');?>
	
	<script>
	
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
            <label for="exampleInputEmail1"><b>Domain Name : </b></label>
             <?= $DOMAIN_NAME;?> 
          </div>
		   <div class="form-group">
            <label for="exampleInputEmail1"><b>Domain url : </b></label>
            <?= $DOMAIN_URL;?>
          </div>
		  <div class="form-group">
			 <label for="exampleInputEmail1"><b>Start Date : </b></label> <?= $START_DATE_domain;?> &nbsp;
			 <label for="exampleInputEmail1"><b>Year Limit : </b></label> <?= $LIMIT_YEAR_domain;?> &nbsp;
			 <label for="exampleInputEmail1"><b>End Date : </b></label> <?= $END_DATE_domain;?> &nbsp;
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
                <label for="exampleInputEmail1">End Date of Hosting</label>
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
                <input class="form-control" id="amount" name="amount" required="" type="number" start="1" min="1" value="<?= $AMOUNT;?>"  aria-describedby="nameHelp" placeholder="">
              </div>
			 <div class="col-md-6">
                <label for="exampleInputEmail1">Expense</label>
				<input class="form-control" id="EXPENSE" name="EXPENSE" value="<?= $EXPENSE;?>"  type="text" aria-describedby="emailHelp" placeholder="Enter Expense amount">
				
			  </div>
			  <div class="col-md-6">
                <label for="exampleInputEmail1">Payment Status : </label>
				<?= $PAYMENT_STATUS;?>
			  </div>
            </div>
          </div>
          
          <button class="btn btn-primary btn-block" name="submit" type="submit" >Renew</button>
		  </div>
        </form>
       
      </div>
	  
	   <div class="card mb-3" style="margin:4px;">
        <div class="card-header">
          <i class="fa fa-table"></i> Hosting Renew History</div>
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
                </tr>
              </tfoot>
			  <tbody>
			  <?php
				$dataArray = $this->user_model->renewInfo($EXPIRE_ID, 'hosting');
				if(is_array($dataArray) AND sizeof($dataArray) > 0){
					$i = 1;
					foreach($dataArray AS $data){
					  $dataArray_do = $this->user_model->domainInfo($data->EXPIRE_ID, 'hosting');
					
					if($dataArray_do[0]->REFER_ID > 0){
							$dataArray2 = $this->user_model->domainInfo($dataArray_do[0]->REFER_ID,'domain');
							$doname = $dataArray2[0]->DOMAIN_NAME;
							$doname_url = $dataArray2[0]->DOMAIN_URL;
						}else{
							$doname = '';
							$doname_url = '';
						}	
				?>
					 <tr>
					  <td align="center"><?= $i; ?></td>
					  <td><?= $doname; ?></td>
					  <td><?= $doname_url; ?></td>
					  <td><?= $this->user_model->date_format_orginal($data->START_DATE); ?></td>
					  <td align="center"><?= $data->LIMIT_YEAR; ?></td>
					  <td><?= $this->user_model->date_format_orginal($data->END_DATE); ?></td>
					  
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