<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user_model extends CI_Model {
	var $CI;
	public function __construct(){
		parent::__construct();
      	$this->CI =& get_instance();
	
 	}
	public function loginAuthentication($username,$password){
		$query = $this->db->query("SELECT * FROM admin_control WHERE ADMIN_USER = '".addslashes($username)."' AND ADMIN_PASS = '".$password."'");
		$count = $query->num_rows();
		if($count == 1){
			return $query->row();
		}else{
			return '0';
		}
		
	}
	
	public function login_check(){
		$userID = $this->session->has_userdata('userID');
		$logged_in = $this->session->has_userdata('logged_in');
		if($userID > 0 AND $logged_in == TRUE){
			
		}else{
			redirect(SITE_URL.'login/');
		}
	}
	
	public function cliensInfo($id='0'){
		if($id > 0){
			$query = $this->db->query("SELECT * FROM m_client_info WHERE CLIENTS_ID = '".$id."' AND CLIENTS_STATUS != 'Delete' ORDER BY CLIENTS_ID DESC");
		}else{
			$query = $this->db->query("SELECT * FROM m_client_info WHERE CLIENTS_STATUS != 'Delete' ORDER BY CLIENTS_ID DESC");
		}
		$count = $query->num_rows();
		//print_r($query->result());exit;
		if($count > 0){
			return $query->result();
			//return $query;
		}else{
			return '0';
		}
		
	}
	
	public function select_client_table($id=''){
		$query = $this->db->query("SELECT * FROM m_client_info WHERE CLIENTS_STATUS != 'Delete' ORDER BY CLIENTS_ID DESC");
		$count = $query->num_rows();
		if($count > 0){
			$dataRow = $query->result();
			$res = '';
			foreach($dataRow AS $data){
				if($id == $data->CLIENTS_ID){
					$res .= '<option value="'.$data->CLIENTS_ID.'" selected> '.$data->CLIENTS_NAME.' </option>';
				}else{
					$res .= '<option value="'.$data->CLIENTS_ID.'"> '.$data->CLIENTS_NAME.' </option>';
				}
			}
			return $res;
		}else{
			return '';
		}
	}
	
	
	public function domainInfo($id='0', $type='domain'){
		if($id > 0){
			$query = $this->db->query("SELECT * FROM m_domain_info WHERE DOMAIN_ID = '".$id."' AND TYPE = '".$type."' AND DOMIAN_STATUS != 'Delete' ORDER BY DOMAIN_ID DESC");
		}else{
			$query = $this->db->query("SELECT * FROM m_domain_info WHERE DOMIAN_STATUS != 'Delete'  AND TYPE = '".$type."' ORDER BY DOMAIN_ID DESC");
		}
		$count = $query->num_rows();
		//print_r($query->result());exit;
		if($count > 0){
			return $query->result();
			//return $query;
		}else{
			return '0';
		}
		
	}
	
	
	public function renewInfo($id='0', $type='domain'){
		if($id > 0){
			$query = $this->db->query("SELECT * FROM r_expire_history WHERE EXPIRE_ID = '".$id."' AND TYPE = '".$type."' AND HISTORY_STATUS  != 'Delete' ORDER BY HISTORY_ID DESC");
		}else{
			$query = $this->db->query("SELECT * FROM r_expire_history WHERE HISTORY_STATUS  != 'Delete' AND TYPE = '".$type."' ORDER BY HISTORY_ID DESC");
		}
		$count = $query->num_rows();
		//print_r($query->result());exit;
		if($count > 0){
			return $query->result();
			//return $query;
		}else{
			return '0';
		}
		
	}
	public function renewInfoAll($id='0'){
		if($id > 0){
			$query = $this->db->query("SELECT * FROM r_expire_history WHERE EXPIRE_ID = '".$id."'  AND HISTORY_STATUS  != 'Delete' ORDER BY HISTORY_ID DESC");
		}else{
			$query = $this->db->query("SELECT * FROM r_expire_history WHERE HISTORY_STATUS  != 'Delete'  ORDER BY HISTORY_ID DESC");
		}
		$count = $query->num_rows();
		//print_r($query->result());exit;
		if($count > 0){
			return $query->result();
			//return $query;
		}else{
			return '0';
		}
		
	}
	
	public function domainInfoAll($id='0'){
		if($id > 0){
			$query = $this->db->query("SELECT * FROM m_domain_info WHERE DOMAIN_ID = '".$id."' AND DOMIAN_STATUS != 'Delete' ORDER BY DOMAIN_ID DESC");
		}else{
			$query = $this->db->query("SELECT * FROM m_domain_info WHERE DOMIAN_STATUS != 'Delete' ORDER BY DOMAIN_ID DESC");
		}
		$count = $query->num_rows();
		//print_r($query->result());exit;
		if($count > 0){
			return $query->result();
			//return $query;
		}else{
			return '0';
		}
		
	}
	
	public function date_format_orginal($date=''){
		return date("d M Y", strtotime($date));
	}
	
	public function select_client_information($from_date='0000-00-00',$to_date='0000-00-00',$clientID='0',$report_nae=''){
		$massage = '';
		$massage .= '<div class="div_center"><p class="headding">European IT Solutions <br/><span class="subheadding">Senpara, Mirpur 10, Dhaka, Bangladesh.</span></p>
						';
		if($report_nae != ''){
			$massage .= '<span class="subheadding bold_subheadding">'.$report_nae.'</span> <br/>';
		}
		if($from_date != '0000-00-00' AND $to_date != '0000-00-00'){
			$massage .= '<span class="subheadding">Reporting Period: <span class="bold_subheadding"> '.$from_date.'</span> to  <span class="bold_subheadding"> '.$to_date.'</span></span><br/>';
		}
		if($clientID > 0){
			$clientInfo = $this->cliensInfo($clientID);
			$massage .= '<span class="subheadding">  <span class="bold_subheadding"> '.$clientInfo[0]->CLIENTS_NAME.' </span> ('.$clientInfo[0]->COMPANY_NAME.') </span> <br/>';
		}
		$massage .= '</div>';
		
		return $massage;
	}
	
	
	public function count_any_where($table, $field, $where=''){
		if(strlen($where)>4){
			$query = $this->db->query("SELECT COUNT($field) AS count_field FROM $table WHERE $where");
		}else{
			$query = $this->db->query("SELECT COUNT($field) AS count_field FROM $table");
		}
		$cout = $query->result();
		return $cout[0]->count_field;
	}
	
	public function min_any_where($table, $field, $where=''){
		if(strlen($where)>4){
			$query = $this->db->query("SELECT MIN($field) AS count_field FROM $table WHERE $where");
		}else{
			$query = $this->db->query("SELECT MIN($field) AS count_field FROM $table");
		}
		$cout = $query->result();
		if($cout[0]->count_field == '0000-00-00' OR strlen($cout[0]->count_field) < 3){
			return  date("Y-m-d");
		}else{
			return $cout[0]->count_field;
		}
		
	}
	
	public function sum_any_where($table, $field, $where=''){
		if(strlen($where)>4){
			$query = $this->db->query("SELECT SUM($field) AS count_field FROM $table WHERE $where");
		}else{
			$query = $this->db->query("SELECT SUM($field) AS count_field FROM $table");
		}
		$cout = $query->result();
		$sum = $cout[0]->count_field;
		if($sum > 0){
			$sum = $sum;
		}else{$sum = 0;}
		return $sum;
	}
}
