<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard extends CI_Controller {

    var $CI;
	function __construct(){
		parent::__construct();
		$this->CI =& get_instance();
		$this->load->library('session');
		$this->load->model(array('user_model'));
		$this->load->helper('url');
		$this->user_model->login_check();
		
	}
	
	public function index(){
		$data = array();
		$this->load->view('index', $data);		
	}
	
	public function client($id='0'){
		
		$data = array();
		
		//$id = isset($_GET['id']) ? $_GET['id'] : '0';
		if($id > 0){
			$dataArray = $this->user_model->cliensInfo($id);
			
			if(is_array($dataArray) AND sizeof($dataArray) > 0){
				
				$data['CLIENTS_NAME'] = $dataArray[0]->CLIENTS_NAME;
				$data['COMPANY_NAME'] = $dataArray[0]->COMPANY_NAME;
				$data['PHONE_NUM'] = $dataArray[0]->PHONE_NUM;
				$data['MOBILE_NUM'] = $dataArray[0]->MOBILE_NUM;
				$data['EMAIL_ADDRESS'] = $dataArray[0]->EMAIL_ADDRESS;
				$data['CLIENTS_ADDRESS'] = $dataArray[0]->CLIENTS_ADDRESS;
				$data['BUTON'] = 'Edit';
				$edit = 1;
			}else{
				$data['CLIENTS_NAME'] = '';
				$data['COMPANY_NAME'] = '';
				$data['PHONE_NUM'] = '';
				$data['MOBILE_NUM'] = '';
				$data['EMAIL_ADDRESS'] = '';
				$data['CLIENTS_ADDRESS'] = '';
				$data['BUTON'] = 'Register';
				$edit = 0;
			}
		}else{
			$data['CLIENTS_NAME'] = '';
			$data['COMPANY_NAME'] = '';
			$data['PHONE_NUM'] = '';
			$data['MOBILE_NUM'] = '';
			$data['EMAIL_ADDRESS'] = '';
			$data['CLIENTS_ADDRESS'] = '';
			$data['BUTON'] = 'Register';
			$edit = 0;
			
		}
		$data['MSG'] = ''.$data['BUTON'].' for Client Account';
		if(isset($_POST['submit'])){
			$clientsName = $this->input->post('clientsName');
			$companyName = $this->input->post('companyName');
			$phoneNo = $this->input->post('phoneNo');
			$mobileNo = $this->input->post('mobileNo');
			$emailAddress = $this->input->post('exampleInputEmail1');
			$address = $this->input->post('address');
			if(strlen($clientsName)> 2){
				if($edit == 0){
					$query = $this->db->query("SELECT * FROM m_client_info WHERE CLIENTS_NAME = '".addslashes($clientsName)."' AND COMPANY_NAME = '".addslashes($companyName)."' AND EMAIL_ADDRESS = '".$emailAddress."'");
					$count = $query->num_rows();
					if($count == 0){
						$insert_data = "INSERT INTO 
													m_client_info
													(
														CLIENTS_NAME,
														COMPANY_NAME,
														PHONE_NUM,
														MOBILE_NUM,
														EMAIL_ADDRESS,
														CLIENTS_ADDRESS,
														CLIENTS_STATUS
													)
													VALUES
													(
														'".addslashes($clientsName)."',
														'".addslashes($companyName)."',
														'".addslashes($phoneNo)."',
														'".addslashes($mobileNo)."',
														'".addslashes($emailAddress)."',
														'".addslashes($address)."',
														'Active'
													)
										
										";
						$insert = $this->db->query($insert_data);
						if($insert){
							
							$data['MSG'] = '<span style="color:green;">Successfully submitted client information</span>';
						}else{
							$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
						}
					}else{
						$data['MSG'] = '<span style="color:#a94442;">Already submitted client information</span>';
					}
				
				}else{
					$insert_data = "UPDATE 
											m_client_info

											SET
												CLIENTS_NAME = '".addslashes($clientsName)."',
												COMPANY_NAME = '".addslashes($companyName)."',
												PHONE_NUM = '".addslashes($phoneNo)."',
												MOBILE_NUM = '".addslashes($mobileNo)."',
												EMAIL_ADDRESS = '".addslashes($emailAddress)."',
												CLIENTS_ADDRESS = '".addslashes($address)."'
											WHERE CLIENTS_ID = '".$id."'
									";
					$insert = $this->db->query($insert_data);
					if($insert){
						$data['MSG'] = '<span style="color:green;">Successfully updated client information</span>';
					}else{
						$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
					}
				}
			}else{
				$data['MSG'] = '<span style="color:#a94442;">Please enter client name</span>';
			}
		}
		
		
		$this->load->view('add_client', $data);	
	}
	
	
	public function domain($id='0'){
		
		$data = array();
		
		//$id = isset($_GET['id']) ? $_GET['id'] : '0';
		if($id > 0){
			$dataArray = $this->user_model->domainInfo($id);
			
			if(is_array($dataArray) AND sizeof($dataArray) > 0){
				
				$data['CLIENTS_ID'] = $dataArray[0]->CLIENTS_ID;
				$data['DOMAIN_NAME'] = $dataArray[0]->DOMAIN_NAME;
				$data['DOMAIN_URL'] = $dataArray[0]->DOMAIN_URL;
				$data['COUNTRY'] = $dataArray[0]->COUNTRY;
				$data['REGISTAR_FROM'] = $dataArray[0]->REGISTAR_FROM;
				$data['START_DATE'] = $dataArray[0]->START_DATE;
				$data['LIMIT_YEAR'] = $dataArray[0]->LIMIT_YEAR;
				$data['END_DATE'] = $dataArray[0]->END_DATE;
				$data['DISCRIPTION'] = $dataArray[0]->DISCRIPTION;
				$data['AMOUNT'] = $dataArray[0]->AMOUNT;
				$data['TOTAL_AMOUNT'] = $dataArray[0]->TOTAL_AMOUNT;
				$data['EXPENSE'] = $dataArray[0]->EXPENSE;
				$data['DOMIAN_STATUS'] = $dataArray[0]->DOMIAN_STATUS;
				$payment = $this->user_model->renewInfo($dataArray[0]->DOMAIN_ID, 'domain');
				$data['PAYMENT_STATUS'] = $payment[0]->PAYMENT_STATUS;
				$data['BUTON'] = 'Edit';
				$edit = 1;
			}else{
				$data['CLIENTS_ID'] = '';
				$data['DOMAIN_NAME'] = '';
				$data['DOMAIN_URL'] = '';
				$data['COUNTRY'] = '';
				$data['REGISTAR_FROM'] = '';
				$data['START_DATE'] = '';
				$data['LIMIT_YEAR'] = '1';
				$data['END_DATE'] = '';
				$data['DISCRIPTION'] = '';
				$data['AMOUNT'] = '';
				$data['TOTAL_AMOUNT'] = '';
				$data['EXPENSE'] = '';
				$data['PAYMENT_STATUS'] = '';
				$data['DOMIAN_STATUS'] = '';
				$data['BUTON'] = 'Register';
				$edit = 0;
			}
		}else{
			$data['CLIENTS_ID'] = '';
			$data['DOMAIN_NAME'] = '';
			$data['DOMAIN_URL'] = '';
			$data['COUNTRY'] = '';
			$data['REGISTAR_FROM'] = '';
			$data['START_DATE'] = '';
			$data['LIMIT_YEAR'] = '1';
			$data['END_DATE'] = '';
			$data['DISCRIPTION'] = '';
			$data['AMOUNT'] = '';
			$data['TOTAL_AMOUNT'] = '';
			$data['EXPENSE'] = '';
			$data['PAYMENT_STATUS'] = '';
			$data['DOMIAN_STATUS'] = '';
			$data['BUTON'] = 'Register';
			$edit = 0;
			
		}
		$data['edit_data'] = $edit;
		
		$data['MSG'] = ''.$data['BUTON'].' for Domain';
		if(isset($_POST['submit'])){
			$CLIENTS_ID = $this->input->post('customer_id');
			$domain_name = $this->input->post('domain_name');
			$domain_url = $this->input->post('domain_url');
			$COUNTRY = $this->input->post('COUNTRY');
			$REGISTAR_FROM = $this->input->post('REGISTAR_FROM');
			$registration_date = $this->input->post('registration_date');
			$year = $this->input->post('year');
			$address = $this->input->post('address');
			$endDate = $this->input->post('endDate');
			$AMOUNT = $this->input->post('amount');
			
			$TOTAL_AMOUNT = $this->input->post('TOTAL_AMOUNT');
			$EXPENSE = $this->input->post('EXPENSE');
			$duce = $TOTAL_AMOUNT - $AMOUNT;
			if($duce == 0){
				$PAYMENT_STATUS = 'Paid';
			}else if($duce > 0){
				$PAYMENT_STATUS = 'Due';
			}else if($duce < 0){
				$PAYMENT_STATUS = 'Minus';
			}
			//$PAYMENT_STATUS = $this->input->post('PAYMENT_STATUS');
			if(strlen($CLIENTS_ID)> 0 AND strlen($domain_name) > 2 AND strlen($domain_url) > 2 AND strlen($registration_date) > 2){
				if($edit == 0){
					$query = $this->db->query("SELECT * FROM m_domain_info WHERE DOMAIN_NAME = '".addslashes($domain_name)."' AND DOMAIN_URL = '".addslashes($domain_url)."' AND TYPE = 'domain'");
					$count = $query->num_rows();
					if($count == 0){
						$insert_data = "INSERT INTO 
													m_domain_info
													(
														CLIENTS_ID,
														TYPE,
														DOMAIN_NAME,
														DOMAIN_URL,
														COUNTRY,
														REGISTAR_FROM,
														START_DATE,
														LIMIT_YEAR,
														END_DATE,
														DISCRIPTION,
														AMOUNT,
														EXPENSE,
														TOTAL_AMOUNT,
														DATE,
														DOMIAN_STATUS
													)
													VALUES
													(
														'".addslashes($CLIENTS_ID)."',
														'domain',
														'".addslashes($domain_name)."',
														'".addslashes($domain_url)."',
														'".addslashes($COUNTRY)."',
														'".addslashes($REGISTAR_FROM)."',
														'".addslashes($registration_date)."',
														'".addslashes($year)."',
														'".addslashes($endDate)."',
														'".addslashes($address)."',
														'".addslashes($AMOUNT)."',
														'".addslashes($EXPENSE)."',
														'".addslashes($TOTAL_AMOUNT)."',
														'".date("Y-m-d")."',														
														'Active'
													)
										
										";
						$insert = $this->db->query($insert_data);
						if($insert){
							$insertData = "INSERT INTO
											r_expire_history
											(
												EXPIRE_ID,
												CLIENTS_ID,
												TYPE,
												UPDATE_TYPE,
												START_DATE,
												LIMIT_YEAR,
												END_DATE,
												AMOUNT,
												EXPENSE,
												TOTAL_AMOUNT,
												PAYMENT_STATUS,
												DATE,
												HISTORY_STATUS
											)
											VALUES
											(
												'".$this->db->insert_id()."',
												'".$CLIENTS_ID."',
												'domain',
												'Main',
												'".addslashes($registration_date)."',
												'".addslashes($year)."',
												'".addslashes($endDate)."',
												'".addslashes($AMOUNT)."',
												'".addslashes($EXPENSE)."',
												'".addslashes($TOTAL_AMOUNT)."',
												'".addslashes($PAYMENT_STATUS)."',
												'".date("Y-m-d")."',
												'Active'
											)
											";
							$this->db->query($insertData);
							$data['MSG'] = '<span style="color:green;">Successfully submitted domain information</span>';
						}else{
							$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
						}
					}else{
						$data['MSG'] = '<span style="color:#a94442;">Already submitted domain information</span>';
					}
				
				}else{
					$DOMIAN_STATUS = $this->input->post('status');
					$insert_data = "UPDATE 
											m_domain_info

											SET
												DOMAIN_NAME = '".addslashes($domain_name)."',
												DOMAIN_URL = '".addslashes($domain_url)."',
												COUNTRY = '".addslashes($COUNTRY)."',
												REGISTAR_FROM = '".addslashes($REGISTAR_FROM)."',
												START_DATE = '".addslashes($registration_date)."',
												LIMIT_YEAR = '".addslashes($year)."',
												END_DATE = '".addslashes($endDate)."',
												DISCRIPTION = '".addslashes($address)."',
												AMOUNT = '".addslashes($AMOUNT)."',
												EXPENSE = '".addslashes($EXPENSE)."',
												TOTAL_AMOUNT = '".addslashes($TOTAL_AMOUNT)."',
												DOMIAN_STATUS = '".addslashes($DOMIAN_STATUS)."'
											WHERE DOMAIN_ID = '".$id."'
									";
					$insert = $this->db->query($insert_data);
					if($insert){
						
						$insert_data1 = "UPDATE 
											r_expire_history
											SET
												CLIENTS_ID = '".$CLIENTS_ID."',
												START_DATE = '".addslashes($registration_date)."',
												LIMIT_YEAR = '".addslashes($year)."',
												END_DATE = '".addslashes($endDate)."',
												AMOUNT = '".addslashes($AMOUNT)."',
												EXPENSE = '".addslashes($EXPENSE)."',
												TOTAL_AMOUNT = '".addslashes($TOTAL_AMOUNT)."',
												PAYMENT_STATUS = '".addslashes($PAYMENT_STATUS)."',
												HISTORY_STATUS = '".addslashes($DOMIAN_STATUS)."'
											WHERE EXPIRE_ID = '".$id."' AND UPDATE_TYPE = 'Main'
									";
						$this->db->query($insert_data1);
						
						$data['MSG'] = '<span style="color:green;">Successfully updated domain information</span>';
					}else{
						$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
					}
				}
			}else{
				$data['MSG'] = '<span style="color:#a94442;">Please enter domain information</span>';
			}
		}
		
		
		$this->load->view('add_domain', $data);	
	}
	
	public function domain_renew($id='0'){
		
		$data = array();
		$data['MSG'] = 'Renew Domain';
		
		$data['CLIENTS_ID'] = '';
		$data['EXPIRE_ID'] = '';
		$data['TYPE'] = '';
		$data['START_DATE'] = '';
		$data['LIMIT_YEAR'] = '';
		$data['END_DATE'] = '';
		$data['DOMAIN_NAME'] = '';
		$data['DOMAIN_URL'] = '';
		$data['AMOUNT'] = '';
		$data['EXPENSE'] = '';
		$data['TOTAL_AMOUNT'] = '';
		$data['PAYMENT_STATUS'] = '';
		
		if($id > 0){
			$dataArray = $this->user_model->renewInfo($id);			
			if(is_array($dataArray) AND sizeof($dataArray) > 0){
				$data['CLIENTS_ID'] = $dataArray[0]->CLIENTS_ID;
				$data['EXPIRE_ID'] = $dataArray[0]->EXPIRE_ID;
				$data['TYPE'] = $dataArray[0]->TYPE;
				$data['START_DATE'] = $dataArray[0]->START_DATE;
				$data['LIMIT_YEAR'] = $dataArray[0]->LIMIT_YEAR;
				$data['END_DATE'] = $dataArray[0]->END_DATE;
				$data['AMOUNT'] = $dataArray[0]->AMOUNT;
				$data['EXPENSE'] = $dataArray[0]->EXPENSE;
				$data['TOTAL_AMOUNT'] = $dataArray[0]->TOTAL_AMOUNT;
				$data['PAYMENT_STATUS'] = $dataArray[0]->PAYMENT_STATUS;
				
				$dataArray_do = $this->user_model->domainInfo($id);
				$data['DOMAIN_NAME'] = $dataArray_do[0]->DOMAIN_NAME;
			    $data['DOMAIN_URL'] = $dataArray_do[0]->DOMAIN_URL;
			    $data['START_DATE_domain'] = $dataArray_do[0]->START_DATE;
			    $data['LIMIT_YEAR_domain'] = $dataArray_do[0]->LIMIT_YEAR;
			    $data['END_DATE_domain'] = $dataArray_do[0]->END_DATE;
				
				if(isset($_POST['submit'])){
					$CLIENTS_ID = $this->input->post('customer_id');
					$domain_name = $this->input->post('domain_name');
					$domain_url = $this->input->post('domain_url');
					$registration_date = $this->input->post('registration_date');
					$year = $this->input->post('year');
					$endDate = $this->input->post('endDate');
					$AMOUNT = $this->input->post('amount');
					$TOTAL_AMOUNT = $this->input->post('TOTAL_AMOUNT');
					$EXPENSE = $this->input->post('EXPENSE');
					$duce = $TOTAL_AMOUNT - $AMOUNT;
					if($duce == 0){
						$PAYMENT_STATUS = 'Paid';
					}else if($duce > 0){
						$PAYMENT_STATUS = 'Due';
					}else if($duce < 0){
						$PAYMENT_STATUS = 'Minus';
					}
					
					$insertData = "INSERT INTO
									r_expire_history
									(
										EXPIRE_ID,
										CLIENTS_ID,
										TYPE,
										UPDATE_TYPE,
										START_DATE,
										LIMIT_YEAR,
										END_DATE,
										AMOUNT,
										EXPENSE,
										TOTAL_AMOUNT,
										PAYMENT_STATUS,
										DATE,
										HISTORY_STATUS
									)
									VALUES
									(
										'".$dataArray[0]->EXPIRE_ID."',
										'".$dataArray[0]->CLIENTS_ID."',
										'domain',
										'Renew',
										'".addslashes($registration_date)."',
										'".addslashes($year)."',
										'".addslashes($endDate)."',
										'".addslashes($AMOUNT)."',
										'".addslashes($EXPENSE)."',
										'".addslashes($TOTAL_AMOUNT)."',
										'".addslashes($PAYMENT_STATUS)."',
										'".date("Y-m-d")."',
										'Active'
									)
									";
					//$this->db->query($insertData);
					if($this->db->query($insertData)){
						$data['MSG'] = '<span style="color:green;">Successfully renew domain</span>';
					}else{
						$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
					}
				}
			}else{
				$data['MSG'] = '<span style="color:#a94442;">Invalid Domain</span>';
				$data['CLIENTS_ID'] = '';
				$data['EXPIRE_ID'] = '';
				$data['TYPE'] = '';
				$data['START_DATE'] = '';
				$data['LIMIT_YEAR'] = '';
				$data['END_DATE'] = '';
				$data['DOMAIN_NAME'] = '';
			    $data['DOMAIN_URL'] = '';
			    $data['AMOUNT'] = '';
			}
			
		}else{
			$data['MSG'] = '<span style="color:#a94442;">Invalid Domain</span>';
		}
		
		$this->load->view('add_domain_renew', $data);	
	}
	
	
	public function domain_search(){
		$id =  $this->input->post('data');
		$massage ='';
		if($id > 0){
			$dataArray = $this->user_model->cliensInfo($id);			
			if(isset($dataArray) AND sizeof($dataArray) > 0){
				$massage .= '<p style="margin:10px;border;1px solid #ccc; padding:5px;"><b>Company Name: </b>'.$dataArray[0]->COMPANY_NAME.'</br>';
				$massage .= '<b>Phone: </b>'.$dataArray[0]->PHONE_NUM.'</br>';
				$massage .= '<b>Email: </b>'.$dataArray[0]->EMAIL_ADDRESS.'</p>';
			}
		}
		echo $massage;exit;
	}
	
	public function domain_search_for_hosting(){
		$id =  $this->input->post('data');
		$query = $this->db->query("SELECT * FROM m_domain_info WHERE CLIENTS_ID = '".$id."' AND DOMIAN_STATUS != 'Delete'  AND TYPE = 'domain' ORDER BY DOMAIN_ID DESC");
		$count = $query->num_rows();
		$massage = '';
		if($count > 0){
			$dataRow = $query->result();
			$massage .= '<select id="domain_id" name="domain_id" class="form-control hasDatepicker">   
						<option value="">Select Domain</option> ';
			foreach($dataRow AS $data){
				if($id == $data->DOMAIN_ID){
					$massage .= '<option value="'.$data->DOMAIN_ID.'" selected> '.$data->DOMAIN_NAME.' </option>';
				}else{
					$massage .= '<option value="'.$data->DOMAIN_ID.'"> '.$data->DOMAIN_NAME.' </option>';
				}
			}
			$massage .= '</select>';
			
		}
		echo $massage;exit;
	}
	
	public function hosting($id='0'){
		
		$data = array();
		
		//$id = isset($_GET['id']) ? $_GET['id'] : '0';
		if($id > 0){
			$dataArray = $this->user_model->domainInfo($id, 'hosting');
			
			if(is_array($dataArray) AND sizeof($dataArray) > 0){
				
				$data['CLIENTS_ID'] = $dataArray[0]->CLIENTS_ID;
				$data['DOMAIN_NAME'] = $dataArray[0]->DOMAIN_NAME;
				$data['DOMAIN_URL'] = $dataArray[0]->DOMAIN_URL;
				$data['COUNTRY'] = $dataArray[0]->COUNTRY;
				$data['REGISTAR_FROM'] = $dataArray[0]->REGISTAR_FROM;
				$data['START_DATE'] = $dataArray[0]->START_DATE;
				$data['LIMIT_YEAR'] = $dataArray[0]->LIMIT_YEAR;
				$data['END_DATE'] = $dataArray[0]->END_DATE;
				$data['DISCRIPTION'] = $dataArray[0]->DISCRIPTION;
				$data['AMOUNT'] = $dataArray[0]->AMOUNT;
				$data['DOMIAN_STATUS'] = $dataArray[0]->DOMIAN_STATUS;
				$data['EXPENSE'] = $dataArray[0]->EXPENSE;
				$data['TOTAL_AMOUNT'] = $dataArray[0]->TOTAL_AMOUNT;
				$payment = $this->user_model->renewInfo($dataArray[0]->DOMAIN_ID, 'hosting');
				$data['PAYMENT_STATUS'] = $payment[0]->PAYMENT_STATUS;
				$data['DNS1'] = $dataArray[0]->DNS1;
				$data['DNS2'] = $dataArray[0]->DNS2;
				$data['BUTON'] = 'Edit';
				$edit = 1;
			}else{
				$data['CLIENTS_ID'] = '';
				$data['DOMAIN_NAME'] = '';
				$data['DOMAIN_URL'] = '';
				$data['COUNTRY'] = '';
				$data['REGISTAR_FROM'] = '';
				$data['START_DATE'] = '';
				$data['LIMIT_YEAR'] = '1';
				$data['END_DATE'] = '';
				$data['DISCRIPTION'] = '';
				$data['AMOUNT'] = '';
				$data['EXPENSE'] = '';
				$data['TOTAL_AMOUNT'] = '';
				$data['PAYMENT_STATUS'] = '';
				$data['DOMIAN_STATUS'] = '';
				$data['DNS1'] = '';
				$data['DNS2'] = '';
				$data['BUTON'] = 'Register';
				$edit = 0;
			}
		}else{
			$data['CLIENTS_ID'] = '';
			$data['DOMAIN_NAME'] = '';
			$data['DOMAIN_URL'] = '';
			$data['COUNTRY'] = '';
			$data['REGISTAR_FROM'] = '';
			$data['START_DATE'] = '';
			$data['LIMIT_YEAR'] = '1';
			$data['END_DATE'] = '';
			$data['DISCRIPTION'] = '';
			$data['AMOUNT'] = '';
			$data['EXPENSE'] = '';
			$data['TOTAL_AMOUNT'] = '';
			$data['PAYMENT_STATUS'] = '';
			$data['DOMIAN_STATUS'] = '';
			$data['DNS1'] = '';
			$data['DNS2'] = '';
			$data['BUTON'] = 'Register';
			$edit = 0;
			
		}
		$data['edit_data'] = $edit;
		
		$data['MSG'] = ''.$data['BUTON'].' for Hosting';
		if(isset($_POST['submit'])){
			$CLIENTS_ID = $this->input->post('customer_id');
			$COUNTRY = $this->input->post('COUNTRY');
			$REGISTAR_FROM = $this->input->post('REGISTAR_FROM');
			$registration_date = $this->input->post('registration_date');
			$year = $this->input->post('year');
			$address = $this->input->post('address');
			$endDate = $this->input->post('endDate');
			$AMOUNT = $this->input->post('amount');
			$TOTAL_AMOUNT = $this->input->post('TOTAL_AMOUNT');
			$EXPENSE = $this->input->post('EXPENSE');
			$duce = $TOTAL_AMOUNT - $AMOUNT;
			if($duce == 0){
				$PAYMENT_STATUS = 'Paid';
			}else if($duce > 0){
				$PAYMENT_STATUS = 'Due';
			}else if($duce < 0){
				$PAYMENT_STATUS = 'Minus';
			}
			$DNS1 = $this->input->post('DNS1');
			$DNS2 = $this->input->post('DNS2');
			$REFER_ID = $this->input->post('domain_id');
			if(strlen($CLIENTS_ID)> 0 AND strlen($registration_date) > 2){
				if($edit == 0){
					$query = $this->db->query("SELECT * FROM m_domain_info WHERE CLIENTS_ID = '".addslashes($CLIENTS_ID)."' AND REFER_ID = '".addslashes($REFER_ID)."' AND START_DATE = '".addslashes($registration_date)."' AND TYPE = 'hosting'");
					$count = $query->num_rows();
					if($count == 0){
						$insert_data = "INSERT INTO 
													m_domain_info
													(
														CLIENTS_ID,
														TYPE,														
														COUNTRY,														
														REGISTAR_FROM,														
														START_DATE,
														LIMIT_YEAR,
														END_DATE,
														DISCRIPTION,
														AMOUNT,
														EXPENSE,
														TOTAL_AMOUNT,
														REFER_ID,
														DNS1,
														DNS2,
														DATE,
														DOMIAN_STATUS
													)
													VALUES
													(
														'".addslashes($CLIENTS_ID)."',
														'hosting',
														'".addslashes($COUNTRY)."',
														'".addslashes($REGISTAR_FROM)."',
														'".addslashes($registration_date)."',
														'".addslashes($year)."',
														'".addslashes($endDate)."',
														'".addslashes($address)."',
														'".addslashes($AMOUNT)."',
														'".addslashes($EXPENSE)."',
														'".addslashes($TOTAL_AMOUNT)."',
														'".addslashes($REFER_ID)."',
														'".addslashes($DNS1)."',
														'".addslashes($DNS2)."',
														'".date("Y-m-d")."',														
														'Active'
													)
										
										";
						$insert = $this->db->query($insert_data);
						if($insert){
							$insertData = "INSERT INTO
											r_expire_history
											(
												EXPIRE_ID,
												CLIENTS_ID,
												TYPE,
												UPDATE_TYPE,
												START_DATE,
												LIMIT_YEAR,
												END_DATE,
												AMOUNT,
												EXPENSE,
												TOTAL_AMOUNT,
												PAYMENT_STATUS,
												DATE,
												HISTORY_STATUS
											)
											VALUES
											(
												'".$this->db->insert_id()."',
												'".$CLIENTS_ID."',
												'hosting',
												'Main',
												'".addslashes($registration_date)."',
												'".addslashes($year)."',
												'".addslashes($endDate)."',
												'".addslashes($AMOUNT)."',
												'".addslashes($EXPENSE)."',
												'".addslashes($TOTAL_AMOUNT)."',
												'".addslashes($PAYMENT_STATUS)."',
												'".date("Y-m-d")."',
												'Active'
											)
											";
							$this->db->query($insertData);
							$data['MSG'] = '<span style="color:green;">Successfully submitted hosting information</span>';
						}else{
							$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
						}
					}else{
						$data['MSG'] = '<span style="color:#a94442;">Already submitted hosting information</span>';
					}
				
				}else{
					$status = $this->input->post('status');
					$insert_data = "UPDATE 
											m_domain_info

											SET
												COUNTRY = '".addslashes($COUNTRY)."',
												REGISTAR_FROM = '".addslashes($REGISTAR_FROM)."',
												START_DATE = '".addslashes($registration_date)."',
												LIMIT_YEAR = '".addslashes($year)."',
												END_DATE = '".addslashes($endDate)."',
												DISCRIPTION = '".addslashes($address)."',
												AMOUNT = '".addslashes($AMOUNT)."',
												EXPENSE = '".addslashes($EXPENSE)."',
												TOTAL_AMOUNT = '".addslashes($TOTAL_AMOUNT)."',
												DNS1 = '".addslashes($DNS1)."',
												DNS2 = '".addslashes($DNS2)."',
												DOMIAN_STATUS = '".addslashes($status)."'
											WHERE DOMAIN_ID = '".$id."'
									";
					$insert = $this->db->query($insert_data);
					if($insert){
						
						$insert_data1 = "UPDATE 
											r_expire_history
											SET
												CLIENTS_ID = '".$CLIENTS_ID."',
												START_DATE = '".addslashes($registration_date)."',
												LIMIT_YEAR = '".addslashes($year)."',
												END_DATE = '".addslashes($endDate)."',
												AMOUNT = '".addslashes($AMOUNT)."',
												EXPENSE = '".addslashes($EXPENSE)."',
												TOTAL_AMOUNT = '".addslashes($TOTAL_AMOUNT)."',
												PAYMENT_STATUS = '".addslashes($PAYMENT_STATUS)."',
												HISTORY_STATUS = '".addslashes($status)."'
											WHERE EXPIRE_ID = '".$id."' AND UPDATE_TYPE = 'Main'
									";
						$this->db->query($insert_data1);
						
						$data['MSG'] = '<span style="color:green;">Successfully updated hosting information</span>';
					}else{
						$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
					}
				}
			}else{
				$data['MSG'] = '<span style="color:#a94442;">Please enter domain information</span>';
			}
		}
		
		
		$this->load->view('add_hosting', $data);	
	}
	
	
	public function hosting_renew($id='0'){
		
		$data = array();
		$data['MSG'] = 'Hosting Domain';
		
		$data['CLIENTS_ID'] = '';
		$data['EXPIRE_ID'] = '';
		$data['TYPE'] = '';
		$data['START_DATE'] = '';
		$data['LIMIT_YEAR'] = '';
		$data['END_DATE'] = '';
		$data['DOMAIN_NAME'] = '';
		$data['DOMAIN_URL'] = '';
		$data['AMOUNT'] = '';
		$data['EXPENSE'] = '';
		$data['TOTAL_AMOUNT'] = '';
		$data['PAYMENT_STATUS'] = '';
		
		if($id > 0){
			$dataArray = $this->user_model->renewInfo($id, 'hosting');			
			if(is_array($dataArray) AND sizeof($dataArray) > 0){
				$data['CLIENTS_ID'] = $dataArray[0]->CLIENTS_ID;
				$data['EXPIRE_ID'] = $dataArray[0]->EXPIRE_ID;
				$data['TYPE'] = $dataArray[0]->TYPE;
				$data['START_DATE'] = $dataArray[0]->START_DATE;
				$data['LIMIT_YEAR'] = $dataArray[0]->LIMIT_YEAR;
				$data['END_DATE'] = $dataArray[0]->END_DATE;
				$data['AMOUNT'] = $dataArray[0]->AMOUNT;
				$data['EXPENSE'] = $dataArray[0]->EXPENSE;
				$data['TOTAL_AMOUNT'] = $dataArray[0]->TOTAL_AMOUNT;
				$data['PAYMENT_STATUS'] = $dataArray[0]->PAYMENT_STATUS;
				
				
				$dataArray_do = $this->user_model->domainInfo($id, 'hosting');
				$data['START_DATE_domain'] = $dataArray_do[0]->START_DATE;
			    $data['LIMIT_YEAR_domain'] = $dataArray_do[0]->LIMIT_YEAR;
			    $data['END_DATE_domain'] = $dataArray_do[0]->END_DATE;
				
				if($dataArray_do[0]->REFER_ID > 0){
					$dataArray2 = $this->user_model->domainInfo($dataArray_do[0]->REFER_ID,'domain');
					$data['DOMAIN_NAME'] = $dataArray2[0]->DOMAIN_NAME;
					$data['DOMAIN_URL'] = $dataArray2[0]->DOMAIN_URL;
				}else{
					$data['DOMAIN_NAME'] = '';
					$data['DOMAIN_URL'] = '';
				}
				
				if(isset($_POST['submit'])){
					$CLIENTS_ID = $this->input->post('customer_id');
					$domain_name = $this->input->post('domain_name');
					$domain_url = $this->input->post('domain_url');
					$registration_date = $this->input->post('registration_date');
					$year = $this->input->post('year');
					$endDate = $this->input->post('endDate');
					$AMOUNT = $this->input->post('amount');
					$TOTAL_AMOUNT = $this->input->post('TOTAL_AMOUNT');
					$EXPENSE = $this->input->post('EXPENSE');
					$duce = $TOTAL_AMOUNT - $AMOUNT;
					if($duce == 0){
						$PAYMENT_STATUS = 'Paid';
					}else if($duce > 0){
						$PAYMENT_STATUS = 'Due';
					}else if($duce < 0){
						$PAYMENT_STATUS = 'Minus';
					}
					$insertData = "INSERT INTO
									r_expire_history
									(
										EXPIRE_ID,
										CLIENTS_ID,
										TYPE,
										UPDATE_TYPE,
										START_DATE,
										LIMIT_YEAR,
										END_DATE,
										AMOUNT,
										EXPENSE,
										TOTAL_AMOUNT,
										PAYMENT_STATUS,
										DATE,
										HISTORY_STATUS
									)
									VALUES
									(
										'".$dataArray[0]->EXPIRE_ID."',
										'".$dataArray[0]->CLIENTS_ID."',
										'hosting',
										'Renew',
										'".addslashes($registration_date)."',
										'".addslashes($year)."',
										'".addslashes($endDate)."',
										'".addslashes($AMOUNT)."',
										'".addslashes($EXPENSE)."',
										'".addslashes($TOTAL_AMOUNT)."',
										'".addslashes($PAYMENT_STATUS)."',
										'".date("Y-m-d")."',
										'Active'
									)
									";
					//$this->db->query($insertData);
					if($this->db->query($insertData)){
						$data['MSG'] = '<span style="color:green;">Successfully renew hosting</span>';
					}else{
						$data['MSG'] = '<span style="color:#a94442;">Systen error</span>';
					}
				}
			}else{
				$data['MSG'] = '<span style="color:#a94442;">Invalid hosting</span>';
				$data['CLIENTS_ID'] = '';
				$data['EXPIRE_ID'] = '';
				$data['TYPE'] = '';
				$data['START_DATE'] = '';
				$data['LIMIT_YEAR'] = '';
				$data['END_DATE'] = '';
				$data['DOMAIN_NAME'] = '';
			    $data['DOMAIN_URL'] = '';
			    $data['AMOUNT'] = '';
			}
			
		}else{
			$data['MSG'] = '<span style="color:#a94442;">Invalid hosting</span>';
		}
		
		$this->load->view('add_hosting_renew', $data);	
	}
	
}

?>