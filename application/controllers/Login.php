<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {


	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model(array('user_model'));
	}
	
	public function index()
	{
		$data = array();
		$data['MSG'] = 'Login';
		if(isset($_POST['submit'])){
			$username = $this->input->post('exampleInputEmail1');
			$password = $this->input->post('exampleInputPassword1');
			
			if(strlen($username) > 0 AND strlen($password) > 0){
				$query = $this->db->query("SELECT * FROM admin_control WHERE ADMIN_USER = '".addslashes($username)."' AND ADMIN_PASS = '".$password."'");
				$count = $query->num_rows();
				if($count == 1){
					$userData = $query->row();
					//print_r($userData);exit;
					if(isset($userData)){
						$newdata = array(
								'userID'  => $userData->ADMIN_ID,
								'adminName'     => $userData->ADMIN_USER,
								'userName'     => $userData->ADMIN_NAME,
								'logged_in' => TRUE
						);
						$this->session->set_userdata($newdata);
					}else{
						$data['MSG'] = '<span style="color:#a94442;">System error</span>';
					}
				}else{
					$data['MSG'] = '<span style="color:#a94442;">User name or password is wrong</span>';
				}
			}else{
				$data['MSG'] = '<span style="color:#a94442;">Enter user name and password</span>';
			}
			
		}
		
		$userID = $this->session->has_userdata('userID');
		$logged_in = $this->session->has_userdata('logged_in');
		if($userID > 0 AND $logged_in == TRUE){
			$this->load->view('index', $data);
		}else{
			$this->load->view('login', $data);
		}
	}
}
