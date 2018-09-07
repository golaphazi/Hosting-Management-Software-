<?php require('include/header.php');?>
	<div class="card card-register mx-auto mt-5">
      <div class="card-header"><?= $MSG;?></div>
      <div class="card-body">
        <form action="" method="POST">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Name</label>
                <input class="form-control" id="clientsName" name="clientsName" type="text" aria-describedby="nameHelp" value="<?= $CLIENTS_NAME;?>" required="" placeholder="Enter client name">
              </div>
              <div class="col-md-6">
                <label for="exampleInputLastName">Company name</label>
                <input class="form-control" id="companyName" name="companyName" required="" type="text" value="<?= $COMPANY_NAME;?>"  aria-describedby="nameHelp" placeholder="Enter company name">
              </div>
            </div>
          </div>
		     <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Phone</label>
                <input class="form-control" id="phoneNo" name="phoneNo" type="text" aria-describedby="nameHelp" value="<?= $PHONE_NUM;?>"  placeholder="Enter phone no">
              </div>
              <div class="col-md-6">
                <label for="exampleInputLastName">Mobile</label>
                <input class="form-control" id="mobileNo" name="mobileNo" type="text" aria-describedby="nameHelp" value="<?= $MOBILE_NUM;?>"  placeholder="Enter mobile no">
              </div>
            </div>
          
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input class="form-control" id="exampleInputEmail1" name="exampleInputEmail1" required="" value="<?= $EMAIL_ADDRESS;?>"  type="email" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
           <div class="form-group">
            <label for="exampleInputEmail1">Address of client</label>
           <textarea class="form-control" name="address" id="address" required=""rows="2" cols="30" placeholder="Write down client address"><?= $CLIENTS_ADDRESS;?> </textarea>
          </div>
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
          <i class="fa fa-table"></i> Clients List</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th align="center">SL#</th>
                  <th>Name</th>
                  <th>Company</th>
                  <th>Phone</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tfoot>
               <tr>
                  <th align="center">SL#</th>
				  <th>Name</th>
                  <th>Company</th>
                  <th>Phone</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Action</th>
                </tr>
              </tfoot>
			  <tbody>
			  <?php
				$dataArray = $this->user_model->cliensInfo();
				if(is_array($dataArray) AND sizeof($dataArray) > 0){
					$i = 1;
					foreach($dataArray AS $data){
						
				?>
					 <tr>
					  <td align="center"><?= $i; ?></td>
					  <td><?= $data->CLIENTS_NAME; ?></td>
					  <td><?= $data->COMPANY_NAME; ?></td>
					  <td><?= $data->PHONE_NUM; ?></td>
					  <td><?= $data->MOBILE_NUM; ?></td>
					  <td><?= $data->EMAIL_ADDRESS; ?></td>
					  <td align="center"> <a href="<?= SITE_URL;?>dashboard/client/<?= $data->CLIENTS_ID; ?>/"><span class="fa fa-edit"></span></a></td>
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