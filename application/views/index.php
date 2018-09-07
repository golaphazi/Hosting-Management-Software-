<?php require('include/header.php');?>
  
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">My Dashboard</li>
      </ol>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-comments"></i>
              </div>
              <div class="mr-5">
			  <?php 
				$where = "TYPE = 'domain' AND DOMIAN_STATUS = 'Active'";
				$sum = $this->user_model->count_any_where('m_domain_info', 'DOMAIN_ID', $where);
				?>
			  <?= $sum;?> New Domain!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?= SITE_URL;?>report/active_domain/">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-list"></i>
              </div>
              <div class="mr-5">
			   <?php 
				$where1 = "TYPE = 'hosting' AND DOMIAN_STATUS = 'Active'";
				$sum1 = $this->user_model->count_any_where('m_domain_info', 'DOMAIN_ID', $where1);
				?>
				 <?= $sum1;?> New Hosting!
			  </div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?= SITE_URL;?>report/active_hosting/">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-shopping-cart"></i>
              </div>
              <div class="mr-5">
			  <?php 
				$where2 = "CLIENTS_STATUS = 'Active'";
				$sum2 = $this->user_model->count_any_where('m_client_info', 'CLIENTS_ID', $where2);
				?>
				 <?= $sum2;?> Clients!
			  </div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?= SITE_URL;?>dashboard/client/">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-support"></i>
              </div>
              <div class="mr-5">
			    <?php 
				$where3 = "HISTORY_STATUS = 'Active'";
				$sum3 = $this->user_model->sum_any_where('r_expire_history', 'AMOUNT', $where3);
				?>
				 <?= number_format($sum3, 2);?> BDT.
			  </div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
      </div>
	  
	 
      <!-- Area Chart Example-->
	  <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Report for [ <?=  date("d M Y", strtotime(date('Y-m-d', strtotime('-30 days'))));?> to <?=  date("d M Y");?> ]</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th style="text-align:center;">SL#</th>
                  <th>Date Period</th>
                  <th><center>QTY.</center></th>
                  <th style="text-align:right;">Net Amount</th>
                </tr>
              </thead>
              
              <tbody>
				 <?php
					//$compire_date = date("Y-m-d");
					$compire_date = date('Y-m-d', strtotime('-30 days'));
					$label = '';
					$sum4 = '';
					$toal_sum5 = '';
					$toal_count5 = '';
					for($i = 0; $i<=30; $i++){
						$compire_date2 = date('Y-m-d', strtotime('-'.$i.' days'));
						if($compire_date2 != '0000-00-00' OR $compire_date2 != '1970-01-01'){
							$label = date('d M Y', strtotime($compire_date2));
							
							$where5 = "HISTORY_STATUS = 'Active' AND (DATE BETWEEN '".$compire_date2."' AND '".$compire_date2."')";
							$count5 = $this->user_model->count_any_where('r_expire_history', 'AMOUNT', $where5);
							$sum5 = $this->user_model->sum_any_where('r_expire_history', 'AMOUNT', $where5);
							
							?>
							<tr>
							  
							  <td style="text-align:center;"><?= ($i+1);?></td>
							  <td><?= $label;?></td>
							  <td><center><?= $count5;?></center></td>
							  <td  style="text-align:right;"><?= number_format($sum5, 2);?></td>
							</tr>
							<?php
						$toal_count5 += $count5;
						$toal_sum5 += $sum5;
						
						}
					}
					
				?>
				
              </tbody>
              <tfoot>
			  <tr>			  
				  <td></td>
				  <td></td>
				  <td><center><b><?= $toal_count5;?></b></center></td>
				  <td  style="text-align:right;"><b>Total = <?= number_format($toal_sum5, 2);?></b></td>
				</tr>
			  </tfoot>
            </table>
          </div>
        </div>
       
      </div>
    </div>
    <!-- /.container-fluid-->
 
	
	<?php require('include/footer.php');?>
   	
