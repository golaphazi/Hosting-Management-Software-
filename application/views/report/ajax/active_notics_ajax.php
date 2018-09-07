 <div class="row col-md-12">
 <button type='button' style='border:none;background:none;font-size:18px;color:red;cursor:pointer;float:right;' onclick='PrintDiv();' > <i class="fa fa-print"></i> </button>
<a href="<?= SITE_URL;?>report/active_notics_report_ajax/<?= $clientID?>/?pdf_opton=csv" style="padding-left: 6px;border:none;background:none;font-size:15px;color:red;" target="_blank"> <i class="fa fa-file-excel-o" title="csv page"></i></a> 

 </div>
 <div class="col-md-12" id="divToPrint">
	<div class="page">
		<div class="subpage">
		<?= $this->user_model->select_client_information('0000-00-00','0000-00-00',$clientID,'Alert massage for renew ');?>
		
		
		<form action="" method="post">
		<table class="table table-bordered" id="" width="100%" cellspacing="0">
		  <thead>
			<tr>
			  <th style="text-align:center;"> <!--<input type="checkbox" name="checkall" id="checkall"/> -->SL# </th>
			  <th>Information</th>
			  <th>Start date</th>
			  <th>Reg. Year</th>
			  <th>End date</th>	
			  
			</tr>
		  </thead>
		  
		  <tbody>
	 <?php			
		$total_sum = 0;
			
		if(is_array($result) AND sizeof($result) > 0){
			$i = 1;
			foreach($result AS $data){
			$dataArray_do = $this->user_model->domainInfoAll($data->EXPIRE_ID);	
			$dataArray_do1 = $this->user_model->renewInfoAll($dataArray_do[0]->DOMAIN_ID);
			
			$compire_date = date("Y-m-d");
			$compire_to_date = $dataArray_do1[0]->END_DATE;
			
			$ts1 = strtotime($compire_date);
			$ts2 = strtotime($compire_to_date);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
			if($diff <= 1){
			
			$this->user_model->cliensInfo();
			
		?>
			 <tr>
			  <td align="center"> <!--<input type="checkbox" name="select_check[]" id="select_check" value="<?= $dataArray_do[0]->DOMAIN_ID; ?>__<?= $dataArray_do[0]->CLIENTS_ID; ?>"/> --><b><?= $i; ?></b></td>
			  <td>
			  <?php
			  if($dataArray_do[0]->TYPE == 'domain'){
				$domain_nae = 'No Hosting';
				if($dataArray_do[0]->DOMAIN_ID > 0){
					$query = $this->db->query("SELECT 
														distinct(do.REFER_ID),DNS1
												 FROM
														m_domain_info do
												 WHERE 
														do.DOMIAN_STATUS != 'Delete'	
														AND do.REFER_ID = '".$dataArray_do[0]->DOMAIN_ID."'	
														AND TYPE = 'hosting'	
														
										");
					$more_domain = $query->result();
					if(is_array($more_domain) AND sizeof($more_domain) > 0){
						$domain_nae = $more_domain[0]->DNS1;
					}
					
				}
				?>
				<b>Domain: </b><?= $dataArray_do[0]->DOMAIN_NAME;?> <b>Hosting: </b><?= $domain_nae;?> (<?= sizeof($dataArray_do1) - 1; ?>)
				<?php				 
			  }else{
				  $domain_nae = 'No Domain';
				if($dataArray_do[0]->REFER_ID > 0){
					$dataArray_domain = $this->user_model->domainInfo($dataArray_do[0]->REFER_ID,'domain');
					$domain_nae = $dataArray_domain[0]->DOMAIN_NAME;
				}
			  ?>
			  
			 <b>Hosting: </b> <?= $dataArray_do[0]->DNS1;?> - <b>Domain: </b><?= $domain_nae;?> (<?= sizeof($dataArray_do1) - 1; ?>)
			  <?php
			  }
			  ?>
			  </td>
			  <td><?= $this->user_model->date_format_orginal($dataArray_do1[0]->START_DATE); ?></td>
			  <td align="center"><?= $dataArray_do1[0]->LIMIT_YEAR; ?></td>
			  <td><?= $this->user_model->date_format_orginal($dataArray_do1[0]->END_DATE); ?>
			  
			  <?php if($diff <= 1){?>
				<a href="<?= SITE_URL;?>dashboard/<?= $dataArray_do[0]->TYPE;?>_renew/<?= $dataArray_do[0]->DOMAIN_ID; ?>/" target="_blank" ><span class="fa fa-fw fa-plus" title="Renew"> </span></a>
			  <?php }?>
			  </td>
			  
			</tr>
		<?php
			$i++;
			
			}else{
				//echo '<tr><td colspan="5">Not found Expired domain/hosting </td></tr>';
			}
			}
		}else{
			echo '<tr><td colspan="5"> Not found Expired domain/hosting</td></tr>';
		}
	  ?>
	 </tbody>
	 
</table>
</form>
</div>
</div>
</div>
<script>
$(document).ready(function() {
  $('#checkall').click(function() {
	var checked = $(this).prop('checked');
    $('input:checkbox').prop('checked', checked);
  });
})
</script>