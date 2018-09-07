 <div class="row col-md-12">
 <button type='button' style='border:none;background:none;font-size:18px;color:red;cursor:pointer;float:right;' onclick='PrintDiv();' > <i class="fa fa-print"></i> </button>
<a href="<?= SITE_URL;?>report/hosting_renew_history_ajax/<?= $clientID?>/<?= $from_date?>/<?= $to_date?>?pdf_opton=csv" style="padding-left: 6px;border:none;background:none;font-size:15px;color:red;" target="_blank"> <i class="fa fa-file-excel-o" title="csv page"></i></a> 

 </div>
 <div class="col-md-12" id="divToPrint">
	<div class="page">
		<div class="subpage">
		<?= $this->user_model->select_client_information($from_date,$to_date,$clientID,'Hosting Renew History');?>
		
		<table class="table table-bordered" id="" width="100%" cellspacing="0">
		  <thead>
			<tr>
			  <th style="text-align:center;">SL#</th>
			  <th>Domain Name</th>
			  <th>DNS1</th>
			  <th>DNS2</th>
			  <th>Start date</th>
			  <th>Reg. Year</th>
			  <th>End date</th>	
			   <th style="text-align:right;">Total Amount</th>		
			  <th style="text-align:right;">Pay Amount</th>		
			  <th style="text-align:right;">Due</th>	
			</tr>
		  </thead>
		  
		  <tbody>
	 <?php			
		$total_sum = 0;
		$total_sum_pay_ = 0;
		$total_sum_due_ = 0;
		
		if(is_array($result) AND sizeof($result) > 0){
			$i = 1;
			$cli = 0;
			foreach($result AS $data){
			if($clientID == 0){
				$clientInfo = $this->user_model->cliensInfo($data->CLIENTS_ID);
				$where = "TYPE = 'hosting' AND DOMIAN_STATUS != 'Delete' AND CLIENTS_ID = '".$data->CLIENTS_ID."'";
				$sum = $this->user_model->count_any_where('m_domain_info', 'CLIENTS_ID', $where);
				$afre_id = $result[$cli]->CLIENTS_ID;
				//$before_id = $result[($cli+1)]->CLIENTS_ID;
				if($afre_id == $data->CLIENTS_ID){
					echo  '<tr><td colspan="10" align="center"><strong>Client Name:</strong> '.$clientInfo[0]->CLIENTS_NAME.' ('.$clientInfo[0]->COMPANY_NAME.') </td></tr>';
				}
			}
			 $dataArray_do = $this->user_model->renewInfo($data->DOMAIN_ID, 'hosting');
			 if(is_array($dataArray_do) AND sizeof($dataArray_do) > 0){
				$count_array = count($dataArray_do)+1;
				
				$dataArray_domain = $this->user_model->domainInfo($data->REFER_ID,'domain');
				echo  '<tr>
						<td align="center" rowspan="'.$count_array.'">'.$i.'</td> 
						<td rowspan="'.$count_array.'">'.$dataArray_domain[0]->DOMAIN_NAME.'  </td>
						<td rowspan="'.$count_array.'">'.$data->DNS1.' </td>
						<td rowspan="'.$count_array.'">'.$data->DNS2.' </td>
						</tr>';
				$net_total = 0;	
				$net_total_pay = 0;	
				$net_total_due = 0;	
				$count_renew = 0;
				//$cli = 1;
				foreach($dataArray_do AS $value){
					$net_total += $value->TOTAL_AMOUNT;
					$net_total_pay += $value->AMOUNT;
					
					$due = $value->TOTAL_AMOUNT - $value->AMOUNT;
					$net_total_due += $due;	
		?>
				<tr>
				  <td><?= $this->user_model->date_format_orginal($value->START_DATE); ?></td>
				  <td align="center"><?= $value->LIMIT_YEAR; ?></td>
				  <td><?= $this->user_model->date_format_orginal($value->END_DATE); ?> </td>
				  <td align="right"><?= number_format($value->TOTAL_AMOUNT,2); ?></td>
				  <td align="right"><?= number_format($value->AMOUNT,2); ?></td>
				  <td align="right"><?= number_format($due,2); ?></td>
			</tr>
		<?php
				$count_renew +=$value->LIMIT_YEAR;
				
				}
				echo '<tr><td colspan="4"></td><td colspan="3" align="center"><strong>'.$count_renew.' y</strong></td><td align="right"><strong>'.number_format($net_total,2).'</strong></td><td align="right"><strong>'.number_format($net_total_pay,2).'</strong></td><td align="right"><strong>'.number_format($net_total_due,2).'</strong></td></tr>';
			}
			$total_sum += $net_total;
			$total_sum_pay_ += $net_total_pay;
			$total_sum_due_ += $net_total_due;
			$i++;
			$cli++;
			}
		}else{
			echo '<tr><td colspan="10"> No entry hosting renew history</td></tr>';
		}
	  ?>
	 </tbody>
	 <?php if($clientID == 0){?>
	  <tfoot>
		 <th colspan="8" style="text-align:right;">Total Amount := <?= number_format($total_sum,2);?></th>	
		 <th style="text-align:right;"><?= number_format($total_sum_pay_,2);?></th>	
		 <th style="text-align:right;"> <?= number_format($total_sum_due_,2);?></th>	
	  </tfoot>
	 <?php }?>
</table>
</div>
</div>
</div>