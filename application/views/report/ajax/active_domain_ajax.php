 <div class="row col-md-12">
 <button type='button' style='border:none;background:none;font-size:18px;color:red;cursor:pointer;float:right;' onclick='PrintDiv();' > <i class="fa fa-print"></i> </button>
<a href="<?= SITE_URL;?>report/active_domain_report_ajax/<?= $clientID?>/<?= $from_date?>/<?= $to_date?>?pdf_opton=csv" style="padding-left: 6px;border:none;background:none;font-size:15px;color:red;" target="_blank"> <i class="fa fa-file-excel-o" title="csv page"></i></a> 

 </div>
 <div class="col-md-12" id="divToPrint">
	<div class="page">
		<div class="subpage">
		<?= $this->user_model->select_client_information($from_date,$to_date,$clientID,'Domain information Report');?>
		
		<table class="table table-bordered" id="" width="100%" cellspacing="0">
		  <thead>
			<tr>
			  <th style="text-align:center;">SL#</th>
			  <th>Domain Name</th>
			  <th>Domain Url</th>
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
		$total_sumT = 0;
		$total_due = 0;
			
		if(is_array($result) AND sizeof($result) > 0){
			$i = 1;
			foreach($result AS $data){
			$dataArray_do = $this->user_model->domainInfo($data->EXPIRE_ID);	
			$dataArray_do1 = $this->user_model->renewInfo($dataArray_do[0]->DOMAIN_ID, 'domain');
			
			$compire_date = date("Y-m-d");
			$compire_to_date = $dataArray_do1[0]->END_DATE;
			
			$ts1 = strtotime($compire_date);
			$ts2 = strtotime($compire_to_date);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
			
			$where = "TYPE = 'domain' AND HISTORY_STATUS != 'Delete' AND EXPIRE_ID = '".$data->EXPIRE_ID."'";
			$sumTotal = $this->user_model->sum_any_where('r_expire_history', 'TOTAL_AMOUNT', $where);
			$sumPay = $this->user_model->sum_any_where('r_expire_history', 'AMOUNT', $where);
			
			$due = $sumTotal - $sumPay;
			
			$total_sum += $sumPay;
			$total_sumT += $sumTotal;
			$total_due += $due;
			 $rowClass = '';
			 $status = $dataArray_do[0]->DOMIAN_STATUS;
			 if($status == 'Active'){
				 if($diff <= 1){
					$rowClass = 'style="background:#6f7d9b; color:#fff;"';
				}
			 }else{
				 $rowClass = 'style="background:#ff7200; color:#fff;"';
			 }
			 
		?>
			 <tr <?= $rowClass;?> >
			  <td align="center"><?= $i; ?></td>
			  <td><?= $dataArray_do[0]->DOMAIN_NAME;?> (<?= sizeof($dataArray_do1) - 1; ?>) - <?= $dataArray_do[0]->DISCRIPTION;?></td>
			  <td><?= $dataArray_do[0]->DOMAIN_URL; ?></td>
			  <td><?= $this->user_model->date_format_orginal($dataArray_do1[0]->START_DATE); ?></td>
			  <td align="center"><?= $dataArray_do1[0]->LIMIT_YEAR; ?></td>
			  <td><?= $this->user_model->date_format_orginal($dataArray_do1[0]->END_DATE); ?>
			  
			  <?php if($diff <= 1 AND $status == 'Active'){?>
			  <a href="<?= SITE_URL;?>dashboard/domain_renew/<?= $dataArray_do[0]->DOMAIN_ID; ?>/" target="_blank" style="color:#fff;"><span class="fa fa-fw fa-plus" title="Renew"> </span></a>
			  <?php }else if($status == 'DeActive'){?>
			   <a href="<?= SITE_URL;?>dashboard/domain/<?= $dataArray_do[0]->DOMAIN_ID; ?>/" target="_blank" style="color:#fff;"><span class="fa fa-fw fa-edit" title="Active"> </span></a>
			  <?php }?>
			  </td>
			  <td align="right"><?= number_format($sumTotal,2); ?></td>
			  <td align="right"><?= number_format($sumPay,2); ?></td>
			  <td align="right"><?= number_format($due,2); ?></td>
			</tr>
		<?php
			$i++;
			}
		}else{
			echo '<tr><td colspan="9"> No entry domain information</td></tr>';
		}
	  ?>
	 </tbody>
	  <tfoot>
		<tr>
					  
			  <th colspan="7" style="text-align:right;">Total Amount := <?= number_format($total_sumT,2);?></th>			  
			  <th style="text-align:right;"> <?= number_format($total_sum,2);?></th>			  
			  <th style="text-align:right;"> <?= number_format($total_due,2);?></th>			  
			</tr>
	  </tfoot>
</table>
</div>
</div>
</div>