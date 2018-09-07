<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class report extends CI_Controller {

    var $CI;
	function __construct(){
		parent::__construct();
		$this->CI =& get_instance();
		$this->load->library('session');
		$this->load->model(array('user_model'));
		$this->load->helper('url');
		$this->user_model->login_check();
		
	}
	
	public function active_domain(){
		$data = array();
		$data['MSG'] = 'Active Domain ';
		
		
		$this->load->view('report/active_domain', $data);	
	}
	
	public function active_domain_report_ajax($cli='0',$from='',$to=''){
		$data = array();
		$data['MSG'] = 'Reporting period';
		$data['pdf_opton']  = isset($_GET['pdf_opton']) ? $_GET['pdf_opton']: '';
		
		 if($data['pdf_opton'] == 'csv'){
			$clientID = $cli;
			$from_date = $from;
			$to_date = $to;
		}else{
			$clientID = isset($_POST['data']) ? $_POST['data']: '0';
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
		 } 
		
		
		//echo $clientID; exit;
		
		if($clientID > 0){
			$client = 'AND do.CLIENTS_ID = '.$clientID.'';
			$clientInfo = $this->user_model->cliensInfo($clientID);
			$client_csv = '+,Client Name: '.$clientInfo[0]->CLIENTS_NAME.' ('.$clientInfo[0]->COMPANY_NAME.')';
		}else{
			$client = '';
			$client_csv = '';
			$clientID = 0;
		}
		
		if(strlen($from_date) < 3){
			$dataRfom = $this->user_model->min_any_where('r_expire_history', 'DATE', 'TYPE = "domain"');
			$from_date = $dataRfom;
		}
		
		if(strlen($to_date) < 3){
			$to_date = date("Y-m-d");
		}
		
		if($to_date >= $from_date){
			$from_date = $from_date;
		}else{
			$from_date = $to_date;
		}
		$csv_value = '';
		$data_csv_value = '';
		$query = $this->db->query("SELECT 
											distinct(ex.EXPIRE_ID)
									 FROM
											m_domain_info do,
											r_expire_history ex
									WHERE 
											do.DOMIAN_STATUS != 'Delete'
											AND do.DOMAIN_ID =  ex.EXPIRE_ID
											AND do.TYPE = 'domain'
											$client
											AND (do.DATE BETWEEN '".$from_date."' AND '".$to_date."')
									ORDER BY ex.END_DATE, ex.HISTORY_ID ASC 
											
								");
		$data['result'] = $query->result();
		
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['clientID'] = $clientID;
		if(is_array($data['result']) AND sizeof($data['result']) > 0){
			$i = 1;
			$total_sum = 0;
			$total_sumT = 0;
			$total_due = 0;
			foreach($data['result'] AS $data1){
				$dataArray_do = $this->user_model->domainInfo($data1->EXPIRE_ID);	
				$dataArray_do1 = $this->user_model->renewInfo($dataArray_do[0]->DOMAIN_ID, 'domain');
				$max_renew = sizeof($dataArray_do1) - 1;
				
				$where = "TYPE = 'domain' AND HISTORY_STATUS != 'Delete' AND EXPIRE_ID = '".$data1->EXPIRE_ID."'";
				$sumTotal = $this->user_model->sum_any_where('r_expire_history', 'TOTAL_AMOUNT', $where);
				$sumPay = $this->user_model->sum_any_where('r_expire_history', 'AMOUNT', $where);
				
				$due = $sumTotal - $sumPay;
				
				$total_sum += $sumPay;
				$total_sumT += $sumTotal;
				$total_due += $due;
				
				$csv_value .= ''.$i.' , '.$dataArray_do[0]->DOMAIN_NAME.' ('.$max_renew.') - '.str_replace(',', ' & ', $dataArray_do[0]->DISCRIPTION).' , '.$dataArray_do[0]->DOMAIN_URL.' , '.$this->user_model->date_format_orginal($dataArray_do1[0]->START_DATE).' , '.$dataArray_do1[0]->LIMIT_YEAR.' , '.$this->user_model->date_format_orginal($dataArray_do1[0]->END_DATE).' , '.$sumTotal.' , '.$sumPay.', '.$due.' < ';
			$i++;
			}
			$data_csv_value = ',Total Amount:=,,,,,'.$total_sumT.','.$total_sum.','.$total_due.'';
		}
		
		
		if($data['pdf_opton'] == 'csv'){
				 $data['data_total']        = $csv_value;
				 $data['csv_data_total']    = $data_csv_value;
				 $data['from_date']         = $from_date;
				 $data['to_date']           = $to_date;
				 $data['title']        = ',European IT Solutions
										  +,Senpara - Mirpur 10 - Dhaka - Bangladesh    
										  +,Report Title: Domain information Report   
										  +,Reporting Period: From ['.$this->user_model->date_format_orginal($data['from_date']).'] To ['.$this->user_model->date_format_orginal($data['to_date']).']
										  '.$client_csv.'  
										';
				  if($clientID > 0){
					$data['file']       = 'Report-Domain-'.$clientInfo[0]->COMPANY_NAME.'';
				  }else{
					  $data['file']       = 'Domain-information-Report';
				  }
				  $data['headding']    = 'SL#,Name,Domain Url,Start date,Reg. Year,End date, Total Amount, Pay Amount, Due';
				  $this->load->view('report/grap_page/csv_report',$data);
			}else{
				$this->load->view('report/ajax/active_domain_ajax', $data);	
			}
		
		
	}
	
	
	
	/*hosting report*/
	public function active_hosting(){
		$data = array();
		$data['MSG'] = 'Active Hosting ';
		
		
		$this->load->view('report/active_hosting', $data);	
	}
	
	public function active_hosting_report_ajax($cli='0',$from='',$to=''){
		$data = array();
		$data['MSG'] = 'Reporting period';
		$data['pdf_opton']  = isset($_GET['pdf_opton']) ? $_GET['pdf_opton']: '';
		
		 if($data['pdf_opton'] == 'csv'){
			$clientID = $cli;
			$from_date = $from;
			$to_date = $to;
		}else{
			$clientID = isset($_POST['data']) ? $_POST['data']: '0';
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
		 } 
		
		
		//echo $clientID; exit;
		
		if($clientID > 0){
			$client = 'AND do.CLIENTS_ID = '.$clientID.'';
			$clientInfo = $this->user_model->cliensInfo($clientID);
			$client_csv = '+,Client Name: '.$clientInfo[0]->CLIENTS_NAME.' ('.$clientInfo[0]->COMPANY_NAME.')';
		}else{
			$client = '';
			$client_csv = '';
			$clientID = 0;
		}
		
		if(strlen($from_date) < 3){
			$dataRfom = $this->user_model->min_any_where('r_expire_history', 'DATE', 'TYPE = "hosting"');
			$from_date =$dataRfom;
		}
		
		if(strlen($to_date) < 3){
			$to_date = date("Y-m-d");
		}
		
		if($to_date >= $from_date){
			$from_date = $from_date;
		}else{
			$from_date = $to_date;
		}
		$csv_value = '';
		$data_csv_value = '';
		$query = $this->db->query("SELECT 
											distinct(ex.EXPIRE_ID)
									 FROM
											m_domain_info do,
											r_expire_history ex
									WHERE 
											do.DOMIAN_STATUS != 'Delete'
											AND do.DOMAIN_ID =  ex.EXPIRE_ID
											AND do.TYPE = 'hosting'
											$client
											AND (do.DATE BETWEEN '".$from_date."' AND '".$to_date."')
									ORDER BY ex.END_DATE, ex.HISTORY_ID
											
								");
		$data['result'] = $query->result();
		
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['clientID'] = $clientID;
		if(is_array($data['result']) AND sizeof($data['result']) > 0){
			$i = 1;
			$total_sum = 0;
			$total_sumT = 0;
			$total_due = 0;
			foreach($data['result'] AS $data1){
				$dataArray_do = $this->user_model->domainInfo($data1->EXPIRE_ID,'hosting');	
				$dataArray_do1 = $this->user_model->renewInfo($dataArray_do[0]->DOMAIN_ID, 'hosting');
				$max_renew = sizeof($dataArray_do1) - 1;
				$domain_nae = 'No Domain';
				if($dataArray_do[0]->REFER_ID > 0){
					$dataArray_domain = $this->user_model->domainInfo($dataArray_do[0]->REFER_ID,'domain');
					$domain_nae = $dataArray_domain[0]->DOMAIN_NAME;
				}
				
				$where = "TYPE = 'hosting' AND HISTORY_STATUS != 'Delete' AND EXPIRE_ID = '".$data1->EXPIRE_ID."'";
				$sumTotal = $this->user_model->sum_any_where('r_expire_history', 'TOTAL_AMOUNT', $where);
				$sumPay = $this->user_model->sum_any_where('r_expire_history', 'AMOUNT', $where);
				
				$due = $sumTotal - $sumPay;
				
				$total_sum += $sumPay;
				$total_sumT += $sumTotal;
				$total_due += $due;
				
				$csv_value .= ''.$i.' , '.$domain_nae.' ('.$max_renew.') - '.str_replace(',', ' & ', $dataArray_do[0]->DISCRIPTION).' , '.$dataArray_do[0]->DNS1.' , '.$dataArray_do[0]->DNS2.', '.$this->user_model->date_format_orginal($dataArray_do1[0]->START_DATE).' , '.$dataArray_do1[0]->LIMIT_YEAR.' , '.$this->user_model->date_format_orginal($dataArray_do1[0]->END_DATE).' , '.$sumTotal.' , '.$total_sumT.', '.$total_due.' < ';
			$i++;
			}
			$data_csv_value = ',Total Amount:=,,,,,,'.$total_sumT.','.$total_sum.','.$total_due.'';
		}
		
		
		if($data['pdf_opton'] == 'csv'){
				 $data['data_total']        = $csv_value;
				 $data['csv_data_total']    = $data_csv_value;
				 $data['from_date']         = $from_date;
				 $data['to_date']           = $to_date;
				 $data['title']        = ',European IT Solutions
										  +,Senpara - Mirpur 10 - Dhaka - Bangladesh    
										  +,Report Title: Hosting information Report   
										  +,Reporting Period: From ['.$this->user_model->date_format_orginal($data['from_date']).'] To ['.$this->user_model->date_format_orginal($data['to_date']).']
										  '.$client_csv.'  
										';
				  if($clientID > 0){
					$data['file']       = 'Report-Hosting-'.$clientInfo[0]->COMPANY_NAME.'';
				  }else{
					  $data['file']       = 'Hosting-information-Report';
				  }
				  $data['headding']    = 'SL#,Domain Name,DNS1,DNS2,Start date,Reg. Year,End date, Total Amount, Pay Amount, Due';
				  $this->load->view('report/grap_page/csv_report',$data);
			}else{
				$this->load->view('report/ajax/active_hosting_ajax', $data);	
			}
		
		
	}
	
	
	/*domain renew history report*/
	public function domain_renew_history(){
		$data = array();
		$data['MSG'] = 'Domain History';
		
		
		$this->load->view('report/domain_renew_history', $data);	
	}
	
	public function domain_renew_history_ajax($cli='0',$from='',$to=''){
		$data = array();
		$data['MSG'] = 'Reporting period';
		$data['pdf_opton']  = isset($_GET['pdf_opton']) ? $_GET['pdf_opton']: '';
		
		 if($data['pdf_opton'] == 'csv'){
			$clientID = $cli;
			$from_date = $from;
			$to_date = $to;
		}else{
			$clientID = isset($_POST['data']) ? $_POST['data']: '0';
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
		 } 
		
		
		if($clientID > 0){
			$client = 'AND do.CLIENTS_ID = '.$clientID.'';
			$clientInfo = $this->user_model->cliensInfo($clientID);
			$client_csv = '+,Client Name: '.$clientInfo[0]->CLIENTS_NAME.' ('.$clientInfo[0]->COMPANY_NAME.')';
		}else{
			$client = '';
			$client_csv = '';
			$clientID = 0;
		}
		
		if(strlen($from_date) < 3){
			$dataRfom = $this->user_model->min_any_where('r_expire_history', 'DATE', 'TYPE = "domain"');
			$from_date =$dataRfom;
		}
		
		if(strlen($to_date) < 3){
			$to_date = date("Y-m-d");
		}
		
		if($to_date >= $from_date){
			$from_date = $from_date;
		}else{
			$from_date = $to_date;
		}
		$csv_value = '';
		$data_csv_value = '';
		$query = $this->db->query("SELECT 
											*
									 FROM
											m_domain_info do
									WHERE 
											do.DOMIAN_STATUS != 'Delete'
											AND do.TYPE = 'domain'
											$client
											AND (do.DATE BETWEEN '".$from_date."' AND '".$to_date."')
									ORDER BY do.DOMAIN_ID DESC
											
								");
		$data['result'] = $query->result();
		
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['clientID'] = $clientID;
		if(is_array($data['result']) AND sizeof($data['result']) > 0){
			$i = 1;
			$total_sum = 0;
			$total_sum_pay_ = 0;
			$total_sum_due_ = 0;
			foreach($data['result'] AS $data1){
				if($clientID == 0){
					$clientInfo = $this->user_model->cliensInfo($data1->CLIENTS_ID);
					$where1 = "TYPE = 'domain' AND DOMIAN_STATUS != 'Delete' AND CLIENTS_ID = '".$data1->CLIENTS_ID."'";
					$sum = $this->user_model->count_any_where('m_domain_info', 'DOMAIN_ID', $where1);
					//if($sum < $i OR $i == 1){
						$csv_value .= '< ,'.$clientInfo[0]->CLIENTS_NAME.' ('.$clientInfo[0]->COMPANY_NAME.') < ';
					//}
				}
				
				$dataArray_do = $this->user_model->renewInfo($data1->DOMAIN_ID, 'domain');
			 if(is_array($dataArray_do) AND sizeof($dataArray_do) > 0){
				$count_array = count($dataArray_do)+1;
				
				if($count_array > 2){
					$count_array = ceil($count_array/2);
				}
				//echo $count_array.'<br/>';
				$net_total = 0;	
				$net_total_pay = 0;	
				$net_total_due = 0;	
				$total_year = 0;	
				$count_renew = 1;
				foreach($dataArray_do AS $value){
					$net_total += $value->TOTAL_AMOUNT;
					$net_total_pay += $value->AMOUNT;
					
					$due = $value->TOTAL_AMOUNT - $value->AMOUNT;
					$net_total_due += $due;	
					
					if($count_renew == 1){
						$csv_value .= ''.$i.','.$data1->DOMAIN_NAME.','.$data1->DOMAIN_URL.','.$this->user_model->date_format_orginal($value->START_DATE).','.$value->LIMIT_YEAR.','.$this->user_model->date_format_orginal($value->END_DATE).','.$value->TOTAL_AMOUNT.','.$value->AMOUNT.','.$due.' < ';
					}else{
						$csv_value .= ',,,'.$this->user_model->date_format_orginal($value->START_DATE).','.$value->LIMIT_YEAR.','.$this->user_model->date_format_orginal($value->END_DATE).','.$value->TOTAL_AMOUNT.','.$value->AMOUNT.','.$due.' < ';
					}
					
				$count_renew++;
				$total_year += $value->LIMIT_YEAR;
				}
			 }				
				$total_sum += $net_total;
				$total_sum_pay_ += $net_total_pay;
				$total_sum_due_ += $net_total_due;
			$i++;
			}
			$data_csv_value = ',Total:,,,,,'.$total_sum.','.$total_sum_pay_.','.$total_sum_due_.'';
		}
		
		if($data['pdf_opton'] == 'csv'){
				 $data['data_total']        = $csv_value;
				 $data['csv_data_total']    = $data_csv_value;
				 $data['from_date']         = $from_date;
				 $data['to_date']           = $to_date;
				 $data['title']        = ',European IT Solutions
										  +,Senpara - Mirpur 10 - Dhaka - Bangladesh    
										  +,Report Title: Domain Renew History   
										  +,Reporting Period: From ['.$this->user_model->date_format_orginal($data['from_date']).'] To ['.$this->user_model->date_format_orginal($data['to_date']).']
										  '.$client_csv.'  
										';
				  if($clientID > 0){
					$data['file']       = 'Report-Renew-'.$clientInfo[0]->COMPANY_NAME.'';
				  }else{
					  $data['file']       = 'Domain-Renew-History';
				  }
				  $data['headding']    = 'SL#,Domain Name,Domain Url,Start date,Reg. Year,End date,Total Amount,Pay Amount,Due';
				  $this->load->view('report/grap_page/csv_report',$data);
			}else{
				$this->load->view('report/ajax/domain_renew_history_ajax', $data);	
			}
		
		
	}
	
	/*domain renew history report*/
	public function hosting_renew_history(){
		$data = array();
		$data['MSG'] = 'Domain History';
		
		
		$this->load->view('report/hosting_renew_history', $data);	
	}
	
	public function hosting_renew_history_ajax($cli='0',$from='',$to=''){
		$data = array();
		$data['MSG'] = 'Reporting period';
		$data['pdf_opton']  = isset($_GET['pdf_opton']) ? $_GET['pdf_opton']: '';
		
		 if($data['pdf_opton'] == 'csv'){
			$clientID = $cli;
			$from_date = $from;
			$to_date = $to;
		}else{
			$clientID = isset($_POST['data']) ? $_POST['data']: '0';
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
		 } 
		
		
		if($clientID > 0){
			$client = 'AND do.CLIENTS_ID = '.$clientID.'';
			$clientInfo = $this->user_model->cliensInfo($clientID);
			$client_csv = '+,Client Name: '.$clientInfo[0]->CLIENTS_NAME.' ('.$clientInfo[0]->COMPANY_NAME.')';
		}else{
			$client = '';
			$client_csv = '';
			$clientID = 0;
		}
		
		if(strlen($from_date) < 3){
			$dataRfom = $this->user_model->min_any_where('r_expire_history', 'DATE', 'TYPE = "hosting"');
			$from_date =$dataRfom;
		}
		
		if(strlen($to_date) < 3){
			$to_date = date("Y-m-d");
		}
		
		if($to_date >= $from_date){
			$from_date = $from_date;
		}else{
			$from_date = $to_date;
		}
		$csv_value = '';
		$data_csv_value = '';
		$query = $this->db->query("SELECT 
											*
									 FROM
											m_domain_info do
									WHERE 
											do.DOMIAN_STATUS != 'Delete'
											AND do.TYPE = 'hosting'
											$client
											AND (do.DATE BETWEEN '".$from_date."' AND '".$to_date."')
									ORDER BY do.DOMAIN_ID DESC
											
								");
		$data['result'] = $query->result();
		
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['clientID'] = $clientID;
		if(is_array($data['result']) AND sizeof($data['result']) > 0){
			$i = 1;
			$total_sum = 0;
			$total_sum_pay_ = 0;
			$total_sum_due_ = 0;
			$net_total = 0;
			foreach($data['result'] AS $data1){
				if($clientID == 0){
					$clientInfo = $this->user_model->cliensInfo($data1->CLIENTS_ID);
					$where1 = "TYPE = 'hosting' AND DOMIAN_STATUS != 'Delete' AND CLIENTS_ID = '".$data1->CLIENTS_ID."'";
					$sum = $this->user_model->count_any_where('m_domain_info', 'DOMAIN_ID', $where1);
					//if($sum < $i OR $i == 1){
						$csv_value .= '<,'.$clientInfo[0]->CLIENTS_NAME.' ('.$clientInfo[0]->COMPANY_NAME.') < ';
					//}
				}
				
				$dataArray_do = $this->user_model->renewInfo($data1->DOMAIN_ID, 'hosting');
			 if(is_array($dataArray_do) AND sizeof($dataArray_do) > 0){
				$count_array = count($dataArray_do)+1;
				
				if($count_array > 2){
					$count_array = ceil($count_array/2);
				}
				
				$dataArray_domain = $this->user_model->domainInfo($data1->REFER_ID,'domain');
				
				$net_total = 0;	
				$net_total_pay = 0;	
				$net_total_due = 0;	
				$total_year = 0;	
				$count_renew = 1;
				foreach($dataArray_do AS $value){
					$net_total += $value->TOTAL_AMOUNT;
					$net_total_pay += $value->AMOUNT;
					
					$due = $value->TOTAL_AMOUNT - $value->AMOUNT;
					$net_total_due += $due;	
					
					if($count_renew == 1){
						$csv_value .= ''.$i.','.$dataArray_domain[0]->DOMAIN_NAME.','.$data1->DNS1.','.$data1->DNS2.','.$this->user_model->date_format_orginal($value->START_DATE).','.$value->LIMIT_YEAR.','.$this->user_model->date_format_orginal($value->END_DATE).', '.$value->TOTAL_AMOUNT.', '.$value->AMOUNT.','.$due.' < ';
					}else{
						$csv_value .= ',,,,'.$this->user_model->date_format_orginal($value->START_DATE).','.$value->LIMIT_YEAR.','.$this->user_model->date_format_orginal($value->END_DATE).','.$value->TOTAL_AMOUNT.','.$value->AMOUNT.','.$due.' < ';
					}
					
				$count_renew++;
				$total_year += $value->LIMIT_YEAR;
				}
			 }				
				$total_sum += $net_total;
				$total_sum_pay_ += $net_total_pay;
				$total_sum_due_ += $net_total_due;
			$i++;
			}
			$data_csv_value = ',Total:,,,,,,'.$total_sum.','.$total_sum_pay_.','.$total_sum_due_.'';
		}
		
		if($data['pdf_opton'] == 'csv'){
				 $data['data_total']        = $csv_value;
				 $data['csv_data_total']    = $data_csv_value;
				 $data['from_date']         = $from_date;
				 $data['to_date']           = $to_date;
				 $data['title']        = ',European IT Solutions
										  +,Senpara - Mirpur 10 - Dhaka - Bangladesh    
										  +,Report Title: Hosting Renew History   
										  +,Reporting Period: From ['.$this->user_model->date_format_orginal($data['from_date']).'] To ['.$this->user_model->date_format_orginal($data['to_date']).']
										  '.$client_csv.'  
										';
				  if($clientID > 0){
					$data['file']       = 'Report-Renew-'.$clientInfo[0]->COMPANY_NAME.'';
				  }else{
					  $data['file']       = 'Hosting-Renew-History';
				  }
				  $data['headding']    = 'SL#,Domain Name,DNS1,DNS2,Start date,Reg. Year,End date,Total Amount,Pay Amount,Due';
				  $this->load->view('report/grap_page/csv_report',$data);
			}else{
				$this->load->view('report/ajax/hosting_renew_history_ajax', $data);	
			}
		
		
	}
	
	
	
	public function notify_clients(){
		$data = array();
		$data['MSG'] = 'Notics for Clients ';
		
		
		$this->load->view('report/notics_for_clients', $data);	
	}
	
	public function active_notics_report_ajax($cli='0',$from='',$to=''){
		$data = array();
		$data['MSG'] = 'Reporting period';
		$data['pdf_opton']  = isset($_GET['pdf_opton']) ? $_GET['pdf_opton']: '';
		
		 if($data['pdf_opton'] == 'csv'){
			$clientID = $cli;
			$from_date = $from;
			$to_date = $to;
		}else{
			$clientID = isset($_POST['data']) ? $_POST['data']: '0';
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
		 } 
		
		
		//echo $clientID; exit;
		
		if($clientID > 0){
			$client = 'AND do.CLIENTS_ID = '.$clientID.'';
			$clientInfo = $this->user_model->cliensInfo($clientID);
			$client_csv = '+,Client Name: '.$clientInfo[0]->CLIENTS_NAME.' ('.$clientInfo[0]->COMPANY_NAME.')';
		}else{
			$client = '';
			$client_csv = '';
			$clientID = 0;
		}
		
		if(strlen($from_date) < 3){
			$dataRfom = $this->user_model->min_any_where('r_expire_history', 'DATE', '');
			$from_date =$dataRfom;
		}
		
		if(strlen($to_date) < 3){
			$to_date = date("Y-m-d");
		}
		
		if($to_date >= $from_date){
			$from_date = $from_date;
		}else{
			$from_date = $to_date;
		}
		$csv_value = '';
		$data_csv_value = '';
		//AND (do.DATE BETWEEN '".$from_date."' AND '".$to_date."')
		
		$query = $this->db->query("SELECT 
											distinct(ex.EXPIRE_ID)
									 FROM
											m_domain_info do,
											r_expire_history ex
									WHERE 
											do.DOMIAN_STATUS != 'Delete'
											AND do.DOMAIN_ID =  ex.EXPIRE_ID
											$client
											
									ORDER BY ex.END_DATE, ex.HISTORY_ID
											
								");
		$data['result'] = $query->result();
		
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['clientID'] = $clientID;
		if(is_array($data['result']) AND sizeof($data['result']) > 0){
			$i = 1;
			$total_sum = 0;
			foreach($data['result'] AS $data1){
				$dataArray_do = $this->user_model->domainInfoAll($data1->EXPIRE_ID);	
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
							$details = 'Domain:'.$dataArray_do[0]->DOMAIN_NAME.' Hosting: '.$domain_nae.' ('.(sizeof($dataArray_do1) - 1).')';
						}else{
						  $domain_nae = 'No Domain';
							if($dataArray_do[0]->REFER_ID > 0){
								$dataArray_domain = $this->user_model->domainInfo($dataArray_do[0]->REFER_ID,'domain');
								$domain_nae = $dataArray_domain[0]->DOMAIN_NAME;
							}
							$details = 'Hosting: '.$dataArray_do[0]->DNS1.' -Domain:'.$domain_nae.' ('.(sizeof($dataArray_do1) - 1).')';
						}
					
					$csv_value .= ''.$i.' , '.$details.'  , '.$this->user_model->date_format_orginal($dataArray_do1[0]->START_DATE).' , '.$dataArray_do1[0]->LIMIT_YEAR.' , '.$this->user_model->date_format_orginal($dataArray_do1[0]->END_DATE).' < ';
				$i++;
				}
			}
			$data_csv_value = '';
		}
		
		
		if($data['pdf_opton'] == 'csv'){
				 $data['data_total']        = $csv_value;
				 $data['csv_data_total']    = $data_csv_value;
				 $data['from_date']         = $from_date;
				 $data['to_date']           = $to_date;
				 $data['title']        = ',European IT Solutions
										  +,Senpara - Mirpur 10 - Dhaka - Bangladesh    
										  +,Report Title: Alert massage for renew   
										  '.$client_csv.'  
										';
				  if($clientID > 0){
					$data['file']       = 'Report-Hosting-'.$clientInfo[0]->COMPANY_NAME.'';
				  }else{
					  $data['file']       = 'Hosting-information-Report';
				  }
				  $data['headding']    = 'SL#,Information,Start date,Reg. Year,End date';
				  $this->load->view('report/grap_page/csv_report',$data);
			}else{
				$this->load->view('report/ajax/active_notics_ajax', $data);	
			}
		
		
	}
	
	
	
	}
?>